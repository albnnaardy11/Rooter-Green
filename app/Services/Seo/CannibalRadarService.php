<?php

namespace App\Services\Seo;

use App\Models\SeoPerformanceStat;
use App\Models\SeoAuditLog;
use App\Models\SeoRedirect;
use App\Models\SeoRedirectSuggestion;
use App\Models\SeoSetting;
use App\Services\Ai\AiMultiModelService;
use App\Services\Ai\AiQuotaGuardService;
use App\Services\Sentinel\SentinelService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CannibalRadarService
{
    /**
     * UNICORP-GRADE: Performant Conflict Detection
     * Identifies queries targeted by multiple URLs with stagnant/low performance.
     */
    public function scanConflicts()
    {
        // ... (existing scan logic)
        $subquery = DB::table('seo_performance_stats')
            ->select('query', 'url', 
                DB::raw('AVG(position) as avg_pos'), 
                DB::raw('AVG(ctr) as avg_ctr'),
                DB::raw('SUM(clicks) as total_clicks'))
            ->where('date', '>=', now()->subDays(30))
            ->groupBy('query', 'url')
            ->having('avg_pos', '>=', 5)
            ->having('avg_pos', '<=', 15)
            ->having('avg_ctr', '<', 2);

        $conflicts = DB::table(DB::raw("({$subquery->toSql()}) as stats"))
            ->mergeBindings($subquery)
            ->select('query', DB::raw('COUNT(url) as url_count'), DB::raw('GROUP_CONCAT(url) as urls'))
            ->groupBy('query')
            ->having('url_count', '>', 1)
            ->get();

        $results = [];
        foreach ($conflicts as $conflict) {
            $urlList = explode(',', $conflict->urls);
            $metrics = SeoPerformanceStat::where('query', $conflict->query)
                ->whereIn('url', $urlList)
                ->select('url', DB::raw('AVG(position) as pos'), DB::raw('SUM(clicks) as clicks'))
                ->groupBy('url')
                ->get();

            $results[] = [
                'query' => $conflict->query,
                'urls' => $metrics,
                'total_urls' => $conflict->url_count
            ];

            $totalImpressions = SeoPerformanceStat::where('query', $conflict->query)->sum('impressions');
            if ($totalImpressions > 1000) {
                app(SentinelService::class)->sendWhatsAppAlert("🚨 *HIGH-VALUE CANNIBALISM*\nQuery: *{$conflict->query}*\nURLs: {$conflict->url_count}\nWaste: High potential impressions lost.");
            }
        }

        return $results;
    }

    /**
     * UNICORP BLACK-BOX: Full-Auto Resolution Engine
     */
    public function autoResolveConflicts()
    {
        $conflicts = $this->scanConflicts();
        $executedCount = 0;

        foreach ($conflicts as $conflict) {
            $urls = $conflict['urls']->pluck('url')->toArray();
            
            // Check for Protected URLs
            foreach ($urls as $url) {
                if ($this->isProtectedUrl($url)) {
                    app(SentinelService::class)->sendWhatsAppAlert("⚠️ *URGENT CANNIBAL INTERVENTION*\nProtected URL involved in conflict: *{$url}*\nQuery: {$conflict['query']}\nAction: Manual review required.");
                    continue 2;
                }
            }

            $analysis = $this->analyzeConflict($conflict['query'], $urls);
            
            if ($analysis && ($analysis['confidence'] ?? 0) >= 95) {
                $this->executeAutoAction($conflict['query'], $analysis, $urls);
                $executedCount++;
            }
        }

        return $executedCount;
    }

    protected function isProtectedUrl($url)
    {
        $protected = ['cart', 'checkout', 'pricing', 'login', 'register'];
        foreach ($protected as $term) {
            if (str_contains(strtolower($url), $term)) return true;
        }
        return false;
    }

    protected function determineWinner($urls, $query)
    {
        $stats = SeoPerformanceStat::where('query', $query)
            ->whereIn('url', $urls)
            ->select('url', 
                DB::raw('SUM(clicks) as clicks'),
                DB::raw('AVG(position) as pos'),
                DB::raw('MAX(date) as last_seen'))
            ->groupBy('url')
            ->get();

        if ($stats->isEmpty()) return $urls[0];

        return $stats->sortBy(function($s) {
            // Rank score: Higher is better
            // Clicks (70%), Position (20% - inverted), Recency (10%)
            $clickScore = $s->clicks;
            $posScore = 1 / ($s->pos ?: 100);
            $recencyScore = strtotime($s->last_seen);
            
            return ($clickScore * 0.7) + ($posScore * 0.2) + ($recencyScore * 0.1);
        })->last()->url;
    }

    protected function executeAutoAction($query, $analysis, $urls)
    {
        $master = $analysis['master_url'] ?? $this->determineWinner($urls, $query);
        $losers = array_diff($urls, [$master]);

        foreach ($losers as $loser) {
            $previousState = [
                'redirects' => SeoRedirect::where('source_url', $loser)->first(),
                'type' => 'NONE'
            ];

            if ($analysis['action'] === 'MERGE') {
                // Rule 1: Auto-generate 301 Redirect
                SeoRedirect::updateOrCreate(
                    ['source_url' => $this->parseUrlPath($loser)],
                    ['destination_url' => $master, 'status_code' => 301, 'type' => 'REDIRECT']
                );
                
                SeoAuditLog::create([
                    'event_type' => '[AUTO-RESOLVED] CANNIBAL-301',
                    'description' => "Auto-Redirected duplicate cannibal URL {$loser} to master {$master} for query '{$query}'. (Confidence: {$analysis['confidence']}%)",
                    'query' => $query,
                    'winner_url' => $master,
                    'loser_url' => $loser,
                    'previous_state' => $previousState,
                    'confidence' => $analysis['confidence']
                ]);
            } elseif ($analysis['action'] === 'CANONICAL') {
                // Rule 2: Auto-inject Rel=Canonical
                SeoRedirect::updateOrCreate(
                    ['source_url' => $this->parseUrlPath($loser)],
                    ['destination_url' => $master, 'status_code' => 200, 'type' => 'CANONICAL']
                );

                SeoAuditLog::create([
                    'event_type' => '[AUTO-RESOLVED] CANNIBAL-CANONICAL',
                    'description' => "Auto-set Canonical for {$loser} to master {$master} for query '{$query}'. (Confidence: {$analysis['confidence']}%)",
                    'query' => $query,
                    'winner_url' => $master,
                    'loser_url' => $loser,
                    'previous_state' => $previousState,
                    'confidence' => $analysis['confidence']
                ]);
            } elseif ($analysis['action'] === 'CONTENT-MERGE') {
                // Rule 3: Buffer + Notify Admin
                SeoAuditLog::create([
                    'event_type' => '[AUTO-RESOLVED] CANNIBAL-BUFFERED',
                    'description' => "Content from {$loser} buffered for manual merge with {$master} for query '{$query}'.",
                    'query' => $query,
                    'winner_url' => $master,
                    'loser_url' => $loser,
                    'previous_state' => $previousState,
                    'confidence' => $analysis['confidence']
                ]);

                app(SentinelService::class)->sendWhatsAppAlert("*CONTENT MERGE READY*\nQuery: *{$query}*\nWinner: {$master}\nLoser: {$loser}\nConfidence: {$analysis['confidence']}%\nAction: Review content in Buffer for final blend.");
            }
        }
    }

    protected function parseUrlPath($url)
    {
        $path = parse_url($url, PHP_URL_PATH) ?: '/';
        return str_starts_with($path, '/') ? $path : '/' . $path;
    }

    protected $ai;

    public function __construct(AiMultiModelService $ai)
    {
        $this->ai = $ai;
    }

    /**
     * UNICORP-GRADE: AI Strategic Intelligence
     */
    public function analyzeConflict(string $query, array $urls)
    {
        $systemInstruction = "You are a Senior SEO Data Scientist. Analyze Content Cannibalism conflicts and provide JSON resolutions.";
        $prompt = "Conflict:
        Query: $query
        Competing URLs: " . implode(', ', $urls) . "
        
        Provide JSON with following keys:
        1. action: MERGE, CANONICAL, or CONTENT-MERGE.
        2. master_url: URL to prioritize.
        3. reason: Short explanation.
        4. confidence: 0-100 score.
        
        Return ONLY valid JSON.";

        $result = $this->ai->generateWithFailover($prompt, $systemInstruction, 'json');

        if ($result && preg_match('/\{.*\}/s', $result, $matches)) {
            $data = json_decode($matches[0], true);
            Log::info("[CANNIBAL-RADAR] Resolution analyzed for $query", ['confidence' => $data['confidence'] ?? 0]);
            return $data;
        }

        return null;
    }
}
