<?php

namespace App\Services\Seo;

use App\Models\SeoAuditLog;
use App\Services\Sentinel\SentinelService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PerformanceGuardService
{
    /**
     * UNICORP-GRADE: Real-User Metrics (RUM) Audit
     * Audits page performance via Google PageSpeed Insights.
     */
    public function auditPulse($url = null)
    {
        $url = $url ?: config('app.url');
        $apiKey = config('services.google.psi_key');

        if (!$apiKey) {
            Log::warning("[GUARD-PULSE] Missing PSI API Key. Fallback to cache.");
            return Cache::get('sentinel_lighthouse_score', 0);
        }

        try {
            $response = Http::timeout(60)->get("https://www.googleapis.com/pagespeedonline/v5/runPagespeed", [
                'url' => $url,
                'key' => $apiKey,
                'category' => 'performance',
                'strategy' => 'mobile'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $score = ($data['lighthouseResult']['categories']['performance']['score'] ?? 0) * 100;
                $lcp = $data['lighthouseResult']['audits']['largest-contentful-paint']['displayValue'] ?? 'Unknown';
                $cls = $data['lighthouseResult']['audits']['cumulative-layout-shift']['displayValue'] ?? 'Unknown';

                Cache::put('sentinel_lighthouse_score', $score, now()->addHours(6));

                if ($score < 80) {
                    app(SentinelService::class)->sendWhatsAppAlert(
                        "PERFORMANCE DEGRADATION\n" .
                        "URL: {$url}\n" .
                        "Score: {$score}/100\n" .
                        "LCP: {$lcp}\n" .
                        "CLS: {$cls}\n" .
                        "Action: Needs urgent optimization."
                    );
                }

                return $score;
            }
        } catch (\Exception $e) {
            Log::error("[GUARD-PULSE] PSI API Error: " . $e->getMessage());
        }

        return Cache::get('sentinel_lighthouse_score', 0);
    }
}
