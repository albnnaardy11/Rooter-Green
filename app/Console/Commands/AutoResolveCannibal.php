<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Seo\CannibalRadarService;
use Illuminate\Support\Facades\Log;

class AutoResolveCannibal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:auto-resolve-cannibal';

    protected $description = 'Full-Auto Content Cannibalism Resolution Engine (Black-Box Mode)';

    public function handle(CannibalRadarService $radar)
    {
        $this->warn("Sentinel Auto-Resolution Protocol Engaged [Monday/Thursday Window]");
        
        $count = $radar->autoResolveConflicts();
        
        if ($count > 0) {
            $this->info("Successfully resolved {$count} cannibalization conflicts.");
            Log::info("[SENTINEL-AUTO] Full-Auto Resolution executed. Count: {$count}");
        } else {
            $this->info("Scan complete. No high-confidence conflicts to resolve.");
        }

        return 0;
    }
}
