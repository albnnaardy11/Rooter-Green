<?php

namespace App\Services\Seo;

use App\Models\SeoPerformanceStat;
use App\Models\SeoAuditLog;
use App\Models\SeoSetting;
use App\Services\Ai\AiMultiModelService;
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

    protected $ai;

    public function __construct(AiMultiModelService $ai)
    {
        $this->ai = $ai;
    }

    protected function generateCtaBoost($query, $url)
    {
        $systemInstruction = "You are a Conversion Rate Optimization (CRO) expert. Write high-converting SEO metadata.";
        $prompt = "Query: '$query'\nURL: '$url'
        
        Write enticing Title (<60 chars) and Meta Description (<160 chars) in Indonesian.
        Return ONLY valid JSON: {\"title\": \"...\", \"meta_description\": \"...\"}";

        $result = $this->ai->generateWithFailover($prompt, $systemInstruction, 'json');

        if ($result && preg_match('/\{.*\}/s', $result, $matches)) {
            return json_decode($matches[0], true);
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
