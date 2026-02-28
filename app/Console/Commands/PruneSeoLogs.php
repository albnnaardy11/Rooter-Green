<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PruneSeoLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:prune-logs {--days=90 : Default retention days for general logs}';

    protected $description = 'Clean up old SEO logs and performance stats to maintain database performance.';

    public function handle()
    {
        $days = (int) $this->option('days');
        $this->warn("SENTINEL: Initiating Database Pruning Protocol...");

        // 1. Prune Crawl Logs (High Volume)
        $crawlCount = \App\Models\SeoCrawlLog::where('crawled_at', '<', now()->subDays($days))->delete();
        $this->info(" - Removed $crawlCount old Crawl Logs.");

        // 2. Prune Performance Stats (Retention: 180 days)
        $perfCount = \App\Models\SeoPerformanceStat::where('date', '<', now()->subDays(180))->delete();
        $this->info(" - Removed $perfCount old Performance Stats (180d+).");

        // 3. Prune Audit Logs (Retention: 365 days)
        $auditCount = \App\Models\SeoAuditLog::where('created_at', '<', now()->subDays(365))->delete();
        $this->info(" - Removed $auditCount old Audit Logs (365d+).");

        // 4. Prune 404 Logs (Noise Reduction)
        $errorCount = \App\Models\Seo404Log::where('last_hit', '<', now()->subDays(90))->delete();
        $this->info(" - Removed $errorCount old 404 Logs (90d+).");

        // Log the deletion activity
        \App\Models\SeoAuditLog::create([
            'event_type' => '[SYSTEM-MAINTENANCE] LOG-PRUNING',
            'description' => "Automated pruning complete. Cleaned up total " . ($crawlCount + $perfCount + $auditCount + $errorCount) . " rows.",
            'confidence' => 100
        ]);

        $this->info("Pruning Sequence Complete. Database optimized.");
        return 0;
    }
}
