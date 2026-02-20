<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductionShield
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected $security;

    public function __construct(\App\Services\Security\SecurityAutomationService $security)
    {
        $this->security = $security;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        // 1. Stealth Check: Application Lockdown Status (L2 Redis)
        if ($this->security->isLockedDown()) {
            // Stealth Rejection: Generic 503 without details
            return response()->view('errors.503', [], 503);
        }

        // 2. Debug Suppressor: Runtime Force-Kill for Public Traffic
        $ip = $request->ip();
        $adminIps = ['127.0.0.1', '::1']; 
        
        if (!in_array($ip, $adminIps)) {
            config(['app.debug' => false]);
        }

        // 3. Brute Force Monitor for API Keys (Phantom/PASETO Bridge)
        if ($request->is('api/*')) {
            $key = 'brute_force_auth:' . $ip;
            $globalKey = 'brute_force_global_counter';
            
            $attempts = \Illuminate\Support\Facades\Cache::increment($key);
            $globalAttempts = \Illuminate\Support\Facades\Cache::increment($globalKey);
            
            if ($attempts === 1) {
                \Illuminate\Support\Facades\Cache::put($key, 1, 60);
            }
            if ($globalAttempts === 1) {
                \Illuminate\Support\Facades\Cache::put($globalKey, 1, 60);
            }

            if ($attempts > 5 || $globalAttempts > 50) {
                // Trigger AutoLockdown
                $reason = $attempts > 5 ? "Brute Force Threshold Exceeded (>5 attempts/min on single IP)" : "Distributed Brute Force Swarm Detected (>50 attempts/min globally)";
                $this->security->triggerAutoLockdown($ip, $reason);
                return response()->view('errors.503', [], 503);
            }
        }

        return $next($request);
    }
}
