<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AnalyzeCrawlBudget extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:analyze-crawl-budget';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze Googlebot crawl activity on Ghost URLs and optimize Crawl Budget.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("[SENTINEL-GHOST] Initiating Crawl Budget Audit...");
        $service = app(\App\Services\Seo\GhostCrawlMonitorService::class);
        $service->analyzeCrawlBudget();
        $this->info("[SENTINEL-GHOST] Crawl Budget Audit Complete.");
    }
}
