<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\AiDiagnose::observe(\App\Observers\AiDiagnoseObserver::class);
        \App\Models\WikiEntity::observe(\App\Observers\WikiEntityObserver::class);

        // UNICORP-GRADE: Enforced Authentication (Removed insecure auto-login)

        // 1. Phantom Security Rate Limiter (High-Performance/Strict)
        RateLimiter::for('phantom-api', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip())->response(function (Request $request, array $headers) {
                \Illuminate\Support\Facades\Log::warning("[SECURITY] Rate Limit Exceeded for Phantom-API from IP: " . $request->ip());
                return response()->json([
                    'status' => 'RATE_LIMIT_ERROR',
                    'message' => 'Too many security requests. System cooldown active.'
                ], 429, $headers);
            });
        });

        // 2. Public Web Rate Limiter (UX-Friendly)
        RateLimiter::for('public-web', function (Request $request) {
            return Limit::perMinute(100)->by($request->ip());
        });
    }
}
