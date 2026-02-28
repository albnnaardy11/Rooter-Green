<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\ProductionShield::class);
        $middleware->append(\App\Http\Middleware\SecurityShield::class);
        $middleware->append(\App\Http\Middleware\PreRenderMiddleware::class);
        $middleware->append(\App\Http\Middleware\TrackVisitors::class);
        $middleware->append(\App\Http\Middleware\SeoRedirectMiddleware::class);
        $middleware->append(\App\Http\Middleware\DetectGooglebotTraffic::class);
        
        $middleware->validateCsrfTokens(except: [
            'admin/api/track-whatsapp',
            'api/phantom/introspect'
        ]);
        
        $middleware->alias([
            'track' => \App\Http\Middleware\TrackVisitors::class,
            'shield' => \App\Http\Middleware\SecurityShield::class,
            'super_admin' => \App\Http\Middleware\SuperAdminOnly::class,
            'audit' => \App\Http\Middleware\AdminAuditLogger::class,
            'phantom' => \App\Http\Middleware\PhantomExchangeMiddleware::class,
            'ai.ratelimit' => \App\Http\Middleware\RateLimitAiDiagnose::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, \Illuminate\Http\Request $request) {
            if (!$request->wantsJson() && !$request->is('admin*') && !$request->is('api*') && !$request->is('storage*') && !$request->is('build*')) {
                try {
                    $url = rtrim($request->url(), '/');
                    \App\Models\Seo404Log::updateOrCreate(
                        ['url' => $url],
                        [
                            'hits' => \Illuminate\Support\Facades\DB::raw('hits + 1'),
                            'last_hit' => now(),
                            'is_redirected' => false
                        ]
                    );
                } catch (\Exception $ex) {
                    \Illuminate\Support\Facades\Log::error('Failed logging 404: ' . $ex->getMessage());
                }
            }
        });
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        // Sentinel Core Observability
        $schedule->command('sentinel:scan')->everyFiveMinutes();
        $schedule->command('sentinel:report')->mondays()->at('08:00');
        
        // Phantom L2 Purge & Cold Storage Archiving
        $schedule->command('system:housekeeping')
                 ->dailyAt('03:30')
                 ->timezone('Asia/Jakarta')
                 ->withoutOverlapping();
                 
        $schedule->command('phantom:reclaim')
                 ->dailyAt('03:00')
                 ->timezone('Asia/Jakarta')
                 ->withoutOverlapping();
                 
        // Automated Backup ke Google Drive (01:00 WIB setiap hari)
        $schedule->command('backup:run --only-db')
                 ->dailyAt('01:00')
                 ->timezone('Asia/Jakarta')
                 ->withoutOverlapping()
                 ->onSuccess(function () {
                     \Illuminate\Support\Facades\Cache::put('last_successful_backup', now());
                     \Illuminate\Support\Facades\Log::info('[BACKUP] Google Drive sync successful.');
                 })
                 ->onFailure(function () {
                     \Illuminate\Support\Facades\Log::critical('[BACKUP] Google Drive sync FAILED.');
                 });

        // Cleanup backup lama (jalankan setelah backup)
        $schedule->command('backup:clean')
                 ->dailyAt('01:30')
                 ->timezone('Asia/Jakarta');

        // --- UNICORP-GRADE: AUTOMATION PIPELINES ---
        
        // 1. Intelligence Sync: Pull GSC Performance Daily
        $schedule->command('seo:sync-gsc')
                 ->dailyAt('02:30')
                 ->timezone('Asia/Jakarta');

        // 2. Self-Healing: Repair Dead Links Hourly
        $schedule->command('seo:repair-404')
                 ->hourly()
                 ->withoutOverlapping();

        // 3. Asset Hardening: Image Optimization & AI Alt Tags
        $schedule->command('media:optimize')
                 ->everyThreeHours()
                 ->withoutOverlapping();

        // 4. Admin Intelligence: WhatsApp Daily Summary (08:00 AM)
        $schedule->command('sentinel:report-daily')
                 ->dailyAt('08:00')
                 ->timezone('Asia/Jakarta');

        // 5. Ghost-Crawl Optimization: Audit Crawl Budget (Weekly on Sundays)
        $schedule->command('seo:analyze-crawl-budget')
                 ->sundays()
                 ->at('23:00')
                 ->timezone('Asia/Jakarta');

        // 6. Cannibal Radar: Full-Auto Resolution Engine (Mon & Thu 01:00)
        $schedule->command('seo:auto-resolve-cannibal')
                 ->days([1, 4]) // Monday & Thursday
                 ->at('01:00')
                 ->timezone('Asia/Jakarta')
                 ->withoutOverlapping();

        // 7. Autonomous Growth: Interlink + CTR + Pulse (Daily 04:00)
        $schedule->command('seo:autonomous-growth')
                 ->dailyAt('04:00')
                 ->timezone('Asia/Jakarta')
                 ->withoutOverlapping();

        // 8. Database Hygiene: Prune old logs (Daily at 04:30)
        $schedule->command('seo:prune-logs')
                 ->dailyAt('04:30')
                 ->timezone('Asia/Jakarta')
                 ->withoutOverlapping();
    })
    ->create();
