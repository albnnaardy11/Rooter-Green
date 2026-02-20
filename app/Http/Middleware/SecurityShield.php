<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Security\SecurityAutomationService;
use Illuminate\Support\Facades\Cache;

class SecurityShield
{
    protected $security;

    public function __construct(SecurityAutomationService $security)
    {
        $this->security = $security;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Check IP Blocks
        $blockedIps = Cache::get('blocked_ips', []);
        if (in_array($request->ip(), $blockedIps)) {
            abort(403, 'Your IP has been flagged for security violations.');
        }

        // 2. Continuous Environment Healing
        if (app()->environment('local')) {
            $this->security->killDebugMode();
        }

        // 3. Neural Asset Protection
        if ($request->is('models/*')) {
            $this->security->protectNeuralAssets($request);
        }

        // 4. Lockdown Mode Check
        if (Cache::get('system_lockdown') && !$request->is('admin/*')) {
            return response()->view('errors.lockdown', [], 503);
        }

        // 5. Intelligent Threat Detection (WAF Mockup)
        $this->detectThreats($request);

        // 6. Bot & Scraper Blocker (WikiPipa Protection)
        $this->blockScrapers($request);

        return $next($request);
    }

    protected function blockScrapers(Request $request)
    {
        // Apply stricter bot detection specifically for technical WikiPipa and AI Intelligence sections
        if (!$request->is('wiki*') && !$request->is('ai-intelligence*')) {
            return;
        }

        $userAgent = strtolower($request->userAgent());
        $bots = [
            'python-requests', 'curl', 'wget', 'libcurl', 'go-http-client',
            'postmanruntime', 'scrapy', 'headlesschrome', 'selenium',
            'axios', 'node-fetch'
        ];

        foreach ($bots as $bot) {
            if (str_contains($userAgent, $bot)) {
                $this->security->blockIp($request->ip(), "WikiPipa Scraper Detected: $bot");
                $this->security->auditLog("WikiPipa Bot Blocked", ['agent' => $userAgent]);
                abort(403, 'Automated harvesting of technical RooterIN WikiPipa data is prohibited.');
            }
        }
    }

    protected function detectThreats(Request $request)
    {
        $payload = strtolower($request->fullUrl() . json_encode($request->all()));
        $patterns = [
            'union select',
            'group by',
            'order by',
            'information_schema',
            '--',
            '<script>',
            '\'%20or%201=1'
        ];

        foreach ($patterns as $pattern) {
            if (str_contains($payload, $pattern)) {
                $this->security->blockIp($request->ip(), "WAF Detection: SQLi/XSS Attempt ($pattern)");
                $this->security->auditLog('Malicious Payload Blocked', ['pattern' => $pattern]);
                abort(406, 'Not Acceptable: Security Threat Detected');
            }
        }
    }
}
