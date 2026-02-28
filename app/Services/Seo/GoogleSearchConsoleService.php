<?php

namespace App\Services\Seo;

use Google\Client;
use Google\Service\SearchConsole;
use App\Models\SeoSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GoogleSearchConsoleService
{
    protected $client;
    protected $isConfigured = false;
    protected $siteUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->isConfigured = $this->setupClient();
        $this->siteUrl = config('app.url');
    }

    protected function setupClient()
    {
        $jsonKey = SeoSetting::where('key', 'google_search_console_key')->first()?->value 
                   ?? SeoSetting::where('key', 'google_indexing_key')->first()?->value;

        if ($jsonKey) {
            try {
                $credentials = json_decode($jsonKey, true);
                if ($credentials) {
                    $this->client->setAuthConfig($credentials);
                    $this->client->addScope(SearchConsole::WEBMASTERS_READONLY);
                    return true;
                }
            } catch (\Exception $e) {
                Log::error('GSC API Auth Error: ' . $e->getMessage());
            }
        }
        return false;
    }

    public function isConfigured()
    {
        return $this->isConfigured;
    }

    /**
     * UNICORP-GRADE: Performance Stats for Dashboard
     */
    public function getPerformanceStats($days = 30)
    {
        if (!$this->isConfigured) return ['active' => false];

        try {
            $service = new SearchConsole($this->client);
            $request = new \Google\Service\SearchConsole\SearchAnalyticsQueryRequest();
            $request->setStartDate(date('Y-m-d', strtotime("-$days days")));
            $request->setEndDate(date('Y-m-d', strtotime("-1 day")));
            $request->setDimensions(['date']);
            $request->setRowLimit(100);

            $query = $service->searchanalytics->query($this->siteUrl, $request);
            $rows = $query->getRows() ?: [];

            return [
                'active' => true,
                'rows' => $rows
            ];
        } catch (\Exception $e) {
            Log::error('GSC Performance Query Error: ' . $e->getMessage());
            return ['active' => false];
        }
    }

    /**
     * Get top performing queries
     */
    public function getTopQueries($limit = 5)
    {
        if (!$this->isConfigured) return [];

        try {
            $service = new SearchConsole($this->client);
            $request = new \Google\Service\SearchConsole\SearchAnalyticsQueryRequest();
            $request->setStartDate(date('Y-m-d', strtotime("-30 days")));
            $request->setEndDate(date('Y-m-d', strtotime("-1 day")));
            $request->setDimensions(['query']);
            $request->setRowLimit($limit);

            $query = $service->searchanalytics->query($this->siteUrl, $request);
            return $query->getRows() ?: [];
        } catch (\Exception $e) {
            Log::error('GSC Top Queries Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * UNICORP-GRADE: Synchronize historical performance to local DB
     */
    public function syncHistoricalData($days = 3)
    {
        if (!$this->isConfigured) return false;

        try {
            $service = new SearchConsole($this->client);
            $startDate = date('Y-m-d', strtotime("-$days days"));
            $endDate = date('Y-m-d', strtotime("-1 day"));

            $request = new \Google\Service\SearchConsole\SearchAnalyticsQueryRequest();
            $request->setStartDate($startDate);
            $request->setEndDate($endDate);
            $request->setDimensions(['query', 'page', 'date']);
            $request->setRowLimit(5000);

            $query = $service->searchanalytics->query($this->siteUrl, $request);
            $rows = $query->getRows();

            if (!$rows) return true;

            foreach ($rows as $row) {
                \App\Models\SeoPerformanceStat::updateOrCreate(
                    [
                        'query' => $row->getKeys()[0],
                        'url' => $row->getKeys()[1],
                        'date' => $row->getKeys()[2],
                    ],
                    [
                        'clicks' => $row->getClicks(),
                        'impressions' => $row->getImpressions(),
                        'ctr' => round($row->getCtr() * 100, 2),
                        'position' => round($row->getPosition(), 2)
                    ]
                );
            }

            Log::info("[SENTINEL-GSC] Synced " . count($rows) . " performance records.");
            return true;
        } catch (\Exception $e) {
            Log::error('GSC Sync Error: ' . $e->getMessage());
            return false;
        }
    }
}
