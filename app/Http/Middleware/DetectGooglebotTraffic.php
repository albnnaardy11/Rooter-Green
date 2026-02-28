<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectGooglebotTraffic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $ua = $request->userAgent();
        if ($ua && str_contains(strtolower($ua), 'googlebot')) {
            try {
                $service = app(\App\Services\Seo\GhostCrawlMonitorService::class);
                $service->recordCrawl(
                    $request->fullUrl(),
                    $response->getStatusCode(),
                    $ua,
                    $request->ip()
                );
            } catch (\Exception $e) {
                // Sentinel Failure Resiliency: Never break customer traffic
                \Illuminate\Support\Facades\Log::error("[SENTINEL-GHOST] Real-Time Monitor Failure: " . $e->getMessage());
            }
        }

        return $response;
    }
}
