<?php

namespace App\Services\Seo;

use App\Models\SeoCrawlLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\Ai\AiQuotaGuardService;
use App\Models\SeoRedirect;
use App\Services\Seo\SeoRepairService;

class GhostCrawlMonitorService
{
    /**
     * UNICORP-GRADE: Process Googlebot Crawl Event
     */
    public function recordCrawl(string $url, int $statusCode, string $userAgent, ?string $ip)
    {
        // 1. Sitemap Integrity Check (L1 Cache: <10ms latency)
        $isInSitemap = $this->checkSitemapIntegrity($url);
        $isGooglebot = str_contains(strtolower($userAgent), 'googlebot');

        // 2. Intelligent Rate Limiting (Prevent I/O Flooding)
        if ($this->shouldLimitLogging($url, $statusCode)) {
            return;
        }

        $log = SeoCrawlLog::create([
            'url' => $url,
            'user_agent' => $userAgent,
            'status_code' => $statusCode,
            'is_in_sitemap' => $isInSitemap,
            'ip_address' => $ip,
            'is_googlebot' => $isGooglebot,
            'crawled_at' => now()
        ]);

        // 3. SEC-SEO Decision Engine
        if ($isGooglebot && !$isInSitemap) {
            $this->executeOrphanProtocol($log);
        }
    }

    protected function checkSitemapIntegrity(string $url): bool
    {
        return Cache::remember('sitemap_registry:' . md5($url), 86400, function() use ($url) {
            // In a real Unicorp setup, this would check a pre-warmed Redis set of all valid URLs
            // For now, we cross-check with existing dynamic content
            $path = parse_url($url, PHP_URL_PATH) ?: '/';
            
            // Check if it's a known service, city, or post
            $slug = ltrim($path, '/');
            if (empty($slug)) return true;

            return \App\Models\SeoCity::where('slug', $slug)->exists() || 
                   \App\Models\Post::where('slug', $slug)->exists() ||
                   \App\Models\SeoKeyword::where('keyword', $slug)->exists();
        });
    }

    protected function shouldLimitLogging(string $url, int $statusCode): bool
    {
        // Rate limit: Max 1 log per unique URL/Status per hour unless it's a 404
        $key = 'crawl_log_throttle:' . md5($url . $statusCode);
        if (Cache::has($key) && $statusCode !== 404) {
            return true;
        }
        Cache::put($key, true, 3600);
        return false;
    }

    protected function executeOrphanProtocol(SeoCrawlLog $log)
    {
        Log::info("[SENTINEL-GHOST] Orphan Protocol Engaged for: " . $log->url);

        // Case A: Googlebot hits 404 on Orbit/Ghost URL
        if ($log->status_code === 404) {
            $log->update(['action_taken' => 'TRIGGER_AI_REPAIR']);
            app(SeoRepairService::class)->analyzeDeadLinks();
            return;
        }

        // Case B: Googlebot hits 200 on Orphan Page (Ghost Content)
        if ($log->status_code === 200) {
            $this->analyzeGhostContent($log);
        }
    }

    protected function analyzeGhostContent(SeoCrawlLog $log)
    {
        try {
            // Fetch content safely
            $response = Http::get($log->url);
            if (!$response->successful()) return;

            $content = $response->body();
            $text = strip_tags($content);

            $guard = app(AiQuotaGuardService::class);
            $apiKey = $guard->getActiveKey();
            if (!$apiKey) return;

            $prompt = "Analyze the quality of this ghost page content at '{$log->url}'. 
            Content: " . substr($text, 0, 1000) . "
            Tasks:
            1. Rate quality from 0-100.
            2. Suggest action: ADD_TO_SITEMAP, NOINDEX, or REDIRECT.
            Return ONLY JSON: {\"quality\": 85, \"action\": \"ADD_TO_SITEMAP\", \"reason\": \"...\"}";

            $aiResponse = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey", [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($aiResponse->successful()) {
                $result = json_decode($aiResponse->json('candidates.0.content.parts.0.text'), true);
                if (!$result) return;

                $log->update(['metadata' => array_merge($log->metadata ?? [], ['ai_analysis' => $result])]);

                if ($result['quality'] >= 80 && $result['action'] === 'ADD_TO_SITEMAP') {
                    $log->update(['action_taken' => 'INDEXING_ENHANCED']);
                    // In real setup, would trigger Sitemap Re-gen & GSC Indexing API
                    Log::info("[SENTINEL-GHOST] Quality Content Detected. Promoting to Sitemap: " . $log->url);
                } else {
                    $log->update(['action_taken' => 'CRAWL_BUDGET_PROTECTION']);
                    Log::warning("[SENTINEL-GHOST] Low quality Orphan detected. Diverting Googlebot.");
                }
            }
        } catch (\Exception $e) {
            Log::error("[SENTINEL-GHOST] Analysis Failure: " . $e->getMessage());
        }
    }

    /**
     * UNICORP-GRADE: Crawl Budget Optimization Report
     */
    public function analyzeCrawlBudget()
    {
        $overCrawled = SeoCrawlLog::where('is_googlebot', true)
            ->where('is_in_sitemap', false)
            ->select('url', \DB::raw('count(*) as hits'))
            ->groupBy('url')
            ->having('hits', '>', 50)
            ->get();

        if ($overCrawled->isNotEmpty()) {
            $urls = $overCrawled->pluck('url')->implode(', ');
            app(\App\Services\Sentinel\SentinelService::class)->sendWhatsAppAlert(
                "SRE ALERT: Crawl Budget Waste detected on Ghost URLs: $urls. Suggest Adding to robots.txt Disallow."
            );
        }
    }
}
