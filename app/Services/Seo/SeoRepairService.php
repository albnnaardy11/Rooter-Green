<?php

namespace App\Services\Seo;

use App\Models\Seo404Log;
use App\Models\SeoRedirectSuggestion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use App\Services\Ai\AiMultiModelService;

class SeoRepairService
{
    /**
     * UNICORP-GRADE: Deep-Analysis of 404 Logs via AI matching
     */
    public function analyzeDeadLinks()
    {
        Log::info("[SENTINEL-SEO] Initiating Dead Link Analysis...");

        $deadLinks = Seo404Log::where('is_redirected', false)
            ->where('hits', '>', 5)
            ->orderBy('hits', 'desc')
            ->limit(10)
            ->get();

        if ($deadLinks->isEmpty()) return;

        // Get available "Healthy" URLs from sitemap or dynamic SEO tables
        $validUrls = $this->getValidUrls();

        foreach ($deadLinks as $link) {
            $this->getAiSuggestion($link, $validUrls);
        }
    }

    protected function getValidUrls()
    {
        // For simulation, we pull from cities and keywords (Common architectural pattern in this project)
        $urls = [url('/')];
        
        $cities = \App\Models\SeoCity::pluck('slug')->toArray();
        foreach ($cities as $city) $urls[] = url("/service-rooter-$city");

        $posts = \App\Models\Post::pluck('slug')->toArray();
        foreach ($posts as $post) $urls[] = url("/blog/$post");

        return array_unique($urls);
    }

    protected $ai;

    public function __construct(AiMultiModelService $ai)
    {
        $this->ai = $ai;
    }

    protected function getAiSuggestion($link, $validUrls)
    {
        $systemInstruction = "You are an SEO Expert for RooterIN. Suggest the best redirect for a 404 URL.";
        $prompt = "Dead link: '{$link->url}'.
        Valid URLs:
        " . implode("\n", array_slice($validUrls, 0, 50)) . "
        
        Return JSON: {\"suggested_url\": \"...\", \"confidence\": 0.95, \"reason\": \"...\"}";

        $result = $this->ai->generateWithFailover($prompt, $systemInstruction, 'json');

        if ($result && preg_match('/\{.*\}/s', $result, $matches)) {
            $data = json_decode($matches[0], true);
            
            if ($data && isset($data['suggested_url'])) {
                $suggestion = SeoRedirectSuggestion::updateOrCreate(
                    ['source_url' => $link->url],
                    [
                        'suggested_url' => $data['suggested_url'],
                        'confidence' => ($data['confidence'] ?? 0) * 100,
                        'reason' => $data['reason'] ?? '',
                        'is_applied' => false
                    ]
                );

                if ($suggestion->confidence >= 90) {
                    $this->applyRedirect($suggestion, $link);
                }
            }
        }
    }

    public function applyRedirect($suggestion, $link)
    {
        // UNICORP-GRADE: Model Synchronization (Correcting fillable mapping)
        \App\Models\SeoRedirect::updateOrCreate(
            ['source_url' => $suggestion->source_url], // source_url in model
            [
                'destination_url' => $suggestion->suggested_url, // destination_url in model
                'status_code' => 301,
                'is_active' => true,
                'last_hit_at' => now() // Initialize tracking
            ]
        );

        $suggestion->update([
            'is_applied' => true,
            'applied_at' => now()
        ]);

        $link->update(['is_redirected' => true]);

        Log::info("[SENTINEL-SEO] Auto-Healed 404: {$suggestion->source_url} -> {$suggestion->suggested_url}");
    }

    /**
     * UNICORP-GRADE: Entropy Recovery (Auto-Pruning Algorithm)
     * Prune redirects that haven't received traffic for 180 days to maintain latency below 50ms.
     */
    public function pruneExpiredRedirects($days = 180)
    {
        Log::info("[SENTINEL-SEO] Initiating Redirect Cache Pruning (Entropy Recovery)...");

        $expiredCount = \App\Models\SeoRedirect::where(function ($query) use ($days) {
                $query->where('last_hit_at', '<', now()->subDays($days))
                      ->orWhere(function ($q) {
                          $q->whereNull('last_hit_at')
                            ->where('created_at', '<', now()->subDays(30)); // Cold start protection
                      });
            })
            ->where('is_active', true)
            ->delete();

        if ($expiredCount > 0) {
            Log::info("[SENTINEL-SEO] ENTROPY RECOVERED: $expiredCount stale redirects purged from memory cluster.");
        }

        return $expiredCount;
    }
}
