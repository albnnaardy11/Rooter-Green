<?php

namespace App\Observers;

use App\Models\AiDiagnose;
use App\Services\Seo\SitemapService;
use App\Services\Seo\GoogleIndexingService;
use Illuminate\Support\Facades\Log;

class AiDiagnoseObserver
{
    protected $sitemapService;
    protected $indexingService;

    public function __construct(SitemapService $sitemapService, GoogleIndexingService $indexingService)
    {
        $this->sitemapService = $sitemapService;
        $this->indexingService = $indexingService;
    }

    /**
     * Handle the AiDiagnose "created" event.
     */
    public function created(AiDiagnose $aiDiagnose): void
    {
        Log::info("[SENTINEL] New AI Diagnosis detected. Triggering SEO Automation Pipeline.");

        // 1. Update Sitemap
        $this->sitemapService->generate();

        // 2. Ping Google (if location is detected)
        if ($aiDiagnose->city_location && $aiDiagnose->city_location !== 'Auto Detect') {
            // Ideally we'd ping the landing page for this diagnostic or city
            $url = url('/ai-diagnostic'); // Or specific result page if it exists
            $this->indexingService->notifyUpdate($url);
        }
    }
}
