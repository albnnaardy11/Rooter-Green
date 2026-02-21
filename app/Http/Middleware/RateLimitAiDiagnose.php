<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitAiDiagnose
{
    /**
     * PHASE 4: SRE SENTINEL & COST GUARD (5x limit per IP per 24 hours)
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        
        // Allowed 5 requests per 1440 minutes (24 hours)
        if (RateLimiter::tooManyAttempts('ai-diagnose-cost-guard:'.$ip, 5)) {
            $seconds = RateLimiter::availableIn('ai-diagnose-cost-guard:'.$ip);
            $hours = ceil($seconds / 3600);
            
            \Illuminate\Support\Facades\Log::warning("Sentinel Cost Guard Blocked AI Diagnostic for IP: $ip (Wait $seconds seconds)");
            
            return response()->json([
                'success' => false,
                'error_code' => 'RATE_LIMIT_EXCEEDED',
                'message' => "Limit Utama Tercapai (5x/24 Jam). Sistem Sentinel membatasi penggunaan per IP untuk menjaga stabilitas Gemini Neural Engine dan memberikan akses adil bagi pengguna lain. Silakan kembali dalam {$hours} jam."
            ], 429);
        }

        RateLimiter::hit('ai-diagnose-cost-guard:'.$ip, 86400); // 24 hours decay

        return $next($request);
    }
}
