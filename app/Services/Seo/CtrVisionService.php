<?php

namespace App\Services\Seo;

use App\Models\SeoPerformanceStat;
use App\Models\SeoAuditLog;
use App\Models\SeoSetting;
use App\Services\Ai\AiQuotaGuardService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CtrVisionService
{
    /**
     * UNICORP-GRADE: SERP Engagement Optimizer (CTR Vision)
     * Auto-refines titles and metas for high-impression low-click pages.
     */
    public function scanAndOptimize()
    {
        // Target: High Impressions (>500), Low CTR (<2%), Position < 20
        $targets = SeoPerformanceStat::select('query', 'url', 'ctr', 'impressions', 'position')
            ->where('date', '>=', now()->subDays(14))
            ->where('impressions', '>', 500)
            ->where('ctr', '<', 2)
            ->where('position', '<', 20)
            ->limit(5)
            ->get();

        $executed = 0;
        foreach ($targets as $target) {
            $optimization = $this->generateCtaBoost($target->query, $target->url);
            if ($optimization) {
                $this->applyMetaOptimization($target->url, $optimization);
                $executed++;
            }
        }
        
        return $executed;
    }

    protected function generateCtaBoost($query, $url)
    {
        $guard = app(AiQuotaGuardService::class);
        $apiKey = $guard->getActiveKey();
        if (!$apiKey) return null;

        $prompt = "You are a Conversion Rate Optimization (CRO) expert. 
        A page ranking for '$query' at URL '$url' has high impressions but low click-through rate.
        Write a high-converting SEO Title and Meta Description in Indonesian.
        Rule: Title < 60 chars, Meta < 160 chars. Stay professional but enticing.
        
        Return JSON: {\"title\": \"...\", \"meta_description\": \"...\"}";

        try {
            $response = Http::timeout(30)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey", [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->successful()) {
                $text = $response->json('candidates.0.content.parts.0.text');
                if (preg_match('/\{.*\}/s', $text, $matches)) {
                    return json_decode($matches[0], true);
                }
            }
        } catch (\Exception $e) {
            Log::error("[CTR-VISION] AI Analysis Error: " . $e->getMessage());
        }

        return null;
    }

    protected function applyMetaOptimization($url, $optimization)
    {
        $urlHash = md5($url);
        
        $oldTitle = SeoSetting::get("seo_title_$urlHash");
        $oldDesc = SeoSetting::get("seo_desc_$urlHash");

        SeoSetting::set("seo_title_$urlHash", $optimization['title']);
        SeoSetting::set("seo_desc_$urlHash", $optimization['meta_description']);

        SeoAuditLog::create([
            'event_type' => '[AUTO-OPTIMIZED] CTR-VISION',
            'description' => "Optimized SERP appearance for $url to boost CTR.",
            'winner_url' => $url,
            'previous_state' => ['title' => $oldTitle, 'desc' => $oldDesc],
            'new_state' => $optimization
        ]);
    }
}
