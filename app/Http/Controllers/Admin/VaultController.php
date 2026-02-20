<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Security\SecurityAutomationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VaultController extends Controller
{
    protected $security;

    public function __construct(SecurityAutomationService $security)
    {
        $this->security = $security;
    }

    public function index()
    {
        $stats = [
            'blocked_ips' => count(Cache::get('blocked_ips', [])),
            'audit_logs' => DB::table('activity_logs')->count(),
            'ssl_days' => $this->security->monitorSsl(),
            'debug_mode' => config('app.debug'),
            'env' => config('app.env'),
            'lockdown_active' => Cache::get('system_lockdown', false),
            'masterpiece_active' => Cache::get('masterpiece_execution_active', false),
        ];

        return view('admin.vault.index', compact('stats'));
    }

    public function toggleLockdown()
    {
        $current = Cache::get('system_lockdown', false);
        Cache::put('system_lockdown', !$current, 3600);
        
        $status = !$current ? 'ACTIVATED' : 'DEACTIVATED';
        
        if (!$current) {
            $this->security->rotateTokens(); // UNICORP-GRADE: Auto-rotate on lockdown
        }

        $this->security->auditLog("Manual System Lockdown $status");

        return redirect()->route('admin.vault.index')->with('success', "System Lockdown has been $status and tokens rotated.");
    }

    public function rotateTokens()
    {
        $this->security->rotateTokens();
        return redirect()->route('admin.vault.index')->with('success', "Global Token Rotation completed.");
    }

    public function clearBlockedIps()
    {
        Cache::forget('blocked_ips');
        $this->security->auditLog("Manual Firewall Flush");
        return redirect()->route('admin.vault.index')->with('success', "Firewall cache has been cleared.");
    }
}
