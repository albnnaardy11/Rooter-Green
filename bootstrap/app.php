<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\SecurityShield::class);
        $middleware->append(\App\Http\Middleware\PreRenderMiddleware::class);
        $middleware->append(\App\Http\Middleware\TrackVisitors::class);
        $middleware->append(\App\Http\Middleware\SeoRedirectMiddleware::class);
        
        $middleware->validateCsrfTokens(except: [
            'admin/api/track-whatsapp'
        ]);
        
        $middleware->alias([
            'track' => \App\Http\Middleware\TrackVisitors::class,
            'shield' => \App\Http\Middleware\SecurityShield::class,
            'super_admin' => \App\Http\Middleware\SuperAdminOnly::class,
            'audit' => \App\Http\Middleware\AdminAuditLogger::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->command('sentinel:scan')->everyFiveMinutes();
        $schedule->command('sentinel:report')->mondays()->at('08:00');
    })
    ->create();
