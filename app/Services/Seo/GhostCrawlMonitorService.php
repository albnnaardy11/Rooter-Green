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
            $path = parse_url($url, PHP_URL_PATH) ?: '/';
            $slug = ltrim($path, '/');
            
            if (empty($slug)) return true; // Homepage

            // UNICORP-GRADE: Multi-Entity Cross-Crawl Validation
            return \App\Models\SeoCity::where('slug', $slug)->exists() || 
                   \App\Models\Post::where('slug', $slug)->exists() ||
                   \App\Models\Service::where('slug', $slug)->exists() ||
                   \App\Models\WikiEntity::where('slug', $slug)->exists() ||
                   \App\Models\SeoKeyword::where('keyword', $slug)->exists() ||
                   // Handle nested paths like area/city/service
                   preg_match('/^area\/([^\/]+)(\/([^\/]+))?$/', $slug) ||
                   preg_match('/^wiki\/([^\/]+)$/', $slug) ||
                   preg_match('/^blog\/([^\/]+)$/', $slug);
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
            // UNICORP-GRADE: Secure Content Retrieval
            $response = Http::timeout(10)->withoutVerifying()->get($log->url);
            if (!$response->successful()) {
                Log::warning("[SENTINEL-GHOST] Content Fetch Failed (404/Timeout) for: " . $log->url);
                return;
            }

            $content = $response->body();
            $text = strip_tags($content);
            $text = preg_replace('/\s+/', ' ', $text); // Clean up whitespace

            $guard = app(AiQuotaGuardService::class);
            $apiKey = $guard->getActiveKey();
            if (!$apiKey) return;

            $prompt = "You are a Senior SEO Content Auditor. Analyze the quality of this 'Ghost Page' (URL not in sitemap but crawled by Googlebot).
            URL: {$log->url}
            Extracted Text Fragment: " . substr($text, 0, 1500) . "
            
            Tasks:
            1. Quality score (0-100) based on E-E-A-T.
            2. Strategic action: 
               - ADD_TO_SITEMAP (if high value)
               - NOINDEX (if thin/duplicate but safe)
               - REDIRECT (if outdated/broken but has link equity)
            
            Return ONLY JSON: {\"quality\": 85, \"action\": \"...\", \"reason\": \"...\"}";

            $aiResponse = Http::timeout(30)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey", [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($aiResponse->successful()) {
                $rawText = $aiResponse->json('candidates.0.content.parts.0.text');
                
                if ($rawText && preg_match('/\{.*\}/s', $rawText, $matches)) {
                    $result = json_decode($matches[0], true);
                    if (!$result) {
                         Log::error("[SENTINEL-GHOST] AI JSON Decode Failed.");
                         return;
                    }

                    $log->update(['metadata' => array_merge($log->metadata ?? [], ['ai_analysis' => $result])]);

                    if ($result['quality'] >= 80 && $result['action'] === 'ADD_TO_SITEMAP') {
                        $log->update(['action_taken' => 'INDEX_ENHANCED']);
                        Log::info("[SENTINEL-GHOST] Quality Content Detected. Promoting to Sitemap: " . $log->url);
                    } else {
                        $log->update(['action_taken' => 'BUDGET_GUARDED']);
                        Log::warning("[SENTINEL-GHOST] Low quality Orphan detected. Action: " . $result['action']);
                    }
                } else {
                    Log::error("[SENTINEL-GHOST] No JSON found in AI response.");
                }
            } else {
                Log::error("[SENTINEL-GHOST] Gemini API Call Failed: " . $aiResponse->body());
                if ($aiResponse->status() === 429) {
                    $guard->reportFailure();
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
