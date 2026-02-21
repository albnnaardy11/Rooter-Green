<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Security\SecurityAutomationService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

        // 2. Continuous Environment Hardening (ABSOLUTE DEBUG SUPPRESSION)
        if (app()->environment('production')) {
            config(['app.debug' => false]);
            $this->security->killDebugMode();
        }

        // 3. Neural Asset Protection (Phantom Token Exchange)
        if ($request->is('models/*')) {
            if (!$this->security->verifyHandshake($request)) {
                $this->security->blockIp($request->ip(), 'Neural Handshake Failure (Invalid Phantom Token)');
                abort(403, 'Akses model ditolak. Koneksi tidak tersinkronisasi.');
            }
        }

        // 4. Rate-Limiting Threshold (WikiPipa Protection)
        if ($request->is('wiki/*')) {
            if ($this->security->checkRateLimit($request->ip(), 'WikiPipa')) {
                abort(429, 'Terdeteksi aktivitas scraping massal. Akses ditangguhkan.');
            }
        }

        // 5. Hotlink Prevention (IP Shield)
        $this->preventHotlinking($request);

        // 6. Lockdown Mode Check (IRON-CLAD BUNKER MODE)
        if (Cache::get('system_lockdown_active')) {
            // Priority 1: Full Access to Security Critical Paths
            $isSecurityRoute = $request->is('admin/vault*') || $request->is('admin/sentinel*');
            
            if (!$isSecurityRoute) {
                // Priority 2: Read-Only (GET) only for other Admin modules
                if ($request->is('admin/*')) {
                    if (!$request->isMethod('GET')) {
                        $this->security->auditLog("Unauthorized Write Attempt blocked during Lockdown", ['path' => $request->path()]);
                        abort(403, 'IRON-CLAD POLICY: System is in Write-Protected Lockdown Mode.');
                    }
                } else {
                    // Priority 3: Stealth/Bunker 503 for all non-admin public traffic
                    return response()->view('errors.503', [], 503);
                }
            }
        }

        // 7. Intelligent Threat Detection (WAF Mockup)
        $this->detectThreats($request);

        // 8. Bot & Scraper Blocker (WikiPipa Protection)
        $this->blockScrapers($request);

        return $next($request);
    }

    protected function preventHotlinking(Request $request)
    {
        $referer = $request->headers->get('referer');
        $host = $request->getHost();

        if ($referer && !str_contains($referer, $host)) {
            $path = $request->path();
            if (str_contains($path, 'assets/wiki') || str_contains($path, 'models')) {
                Log::warning("[SECURITY] Hotlink attempt blocked from $referer for $path");
                abort(403, 'Hotlinking is prohibited by RooterIN IP Shield.');
            }
        }
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
        // Zero False Positive: Internal Wiki Automator is exempt from payload inspection
        if ($request->header('X-Internal-Automator') === 'WikiPipa-Safe') {
            return;
        }

        // Phase 3: Anti-Obfuscation (Multi-Stage Decoding)
        $rawPayload = $request->fullUrl() . json_encode($request->all());
        $payload = strtolower(urldecode($rawPayload));
        
        // Handle potential nested URL encoding or Hex masks
        $payload = preg_replace_callback('/%[0-9a-f]{2}/i', function($m) {
            return urldecode($m[0]);
        }, $payload);

        // Phase 3: Anti-Obfuscation Patterns (Deep Packet Inspection)
        $patterns = [
            '/(union\s+.*select)/i',
            '/(group\s+by\s+.*)/i',
            '/(order\s+by\s+.*)/i',
            '/(information_schema|benchmark|waitfor\s+delay|sleep\()/i',
            '/(\-\-|\#|\/\*)/i', // SQL Comments
            '/(<script|javascript:|on\w+\s*=)/i', // XSS Basic
            '/(%27|%22|%3C|%3E|%20or%20|%20and%20)/i', // Hex/URL Encoded attacks
            '/(\'|"|;)\s*(or|and)\s+.*=.* /i', // Logic bypass
            '/base64_decode|exec\(|shell_exec\(|system\(/i', // RCE patterns
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $payload)) {
                $this->security->blockIp($request->ip(), "Sentinel Shield: Deep Packet Inspection matched ($pattern)");
                $this->security->auditLog('Iron-Clad WAF Blocked', ['pattern' => $pattern]);
                abort(406, 'Not Acceptable: Deep Packet Inspection failed. Iron-Clad Shield Active.');
            }
        }
    }
}
