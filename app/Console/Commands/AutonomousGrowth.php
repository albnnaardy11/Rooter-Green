<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutonomousGrowth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:autonomous-growth {--module=all : The module to run (interlink, ctr, pulse)}';

    protected $description = 'Unicorp Autonomous SEO Growth Protocol (Interlink + CTR + Performance Pulse)';

    public function handle()
    {
        $module = $this->option('module');

        $this->warn("SENTINEL: Initiating Autonomous Growth Protocol...");

        if ($module === 'all' || $module === 'interlink') {
            $this->info(" - Running Interlink Oracle [Semantic Mapping]...");
            app(\App\Services\Seo\InterlinkOracleService::class)->processBatchWiki();
        }

        if ($module === 'all' || $module === 'ctr') {
            $this->info(" - Running CTR Vision [CTA Optimization]...");
            $count = app(\App\Services\Seo\CtrVisionService::class)->scanAndOptimize();
            $this->line("   Optimized $count meta tags.");
        }

        if ($module === 'all' || $module === 'pulse') {
            $this->info(" - Running Performance Pulse [CWV Sentry]...");
            $score = app(\App\Services\Seo\PerformanceGuardService::class)->auditPulse();
            $this->line("   Current Pulse Score: $score/100");
        }

        $this->info("Protocol Execution Complete.");
        return 0;
    }
}
