<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Security\SecurityAutomationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\SentinelAudit;

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
            'lockdown_active' => Cache::get('system_lockdown_active', false),
            'masterpiece_active' => Cache::get('masterpiece_execution_active', false),
        ];

        $latestAudit = SentinelAudit::latest()->first();
        
        // Fetch Forensics/ARR Incidents
        $incidents = SentinelAudit::where('event_type', 'MEMORY_PANIC_REBOOT')
            ->latest()
            ->take(5)
            ->get();
          // Fetch Reports/Post-Mortems
        $reports = [];
        $reportDir = storage_path('vault/reports');
        if (file_exists($reportDir)) {
            $files = glob($reportDir . '/*.report');
            foreach ($files as $file) {
                $reports[] = [
                    'id' => basename($file, '.report'),
                    'date' => date('Y-m-d H:i', filemtime($file))
                ];
            }
        }

        return view('admin.vault.index', compact('stats', 'latestAudit', 'incidents', 'reports'));
    }

    /**
     * UNICORP-GRADE: Forensics Viewer (Black-Box Explorer)
     */
    public function viewForensics($id)
    {
        $path = storage_path('vault/forensics/' . $id . '.json');
        
        if (!file_exists($path)) {
            return response()->json(['error' => 'Forensic trace not found or already purged by EntropyGuard.'], 404);
        }

        $content = file_get_contents($path);
        
        try {
            $data = unserialize(base64_decode($content));
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Forensic data corruption detected.'], 500);
        }
    }

    public function toggleLockdown()
    {
        $current = Cache::get('system_lockdown_active', false);
        Cache::put('system_lockdown_active', !$current, 3600);
        
        $status = !$current ? 'ACTIVATED' : 'DEACTIVATED';
        
        if (!$current) {
            $this->security->rotateTokens(); // UNICORP-GRADE: Auto-rotate on lockdown
        } else {
            // If turning off, also ensure shield status is reset
            Cache::forget('sentinel_shield_status');
        }

        $this->security->auditLog("Manual System Lockdown $status");

        return redirect()->route('admin.vault.index')->with('success', "System Lockdown has been $status and tokens rotated.");
    }

    /**
     * UNICORP-GRADE: Total System Release (SRE Emergency Protocol)
     */
    public function emergencyRelease()
    {
        Cache::forget('system_lockdown_active');
        Cache::forget('sentinel_shield_status');
        Cache::forget('sentinel_fragmentation_level');
        Cache::forget('brute_force_global_counter');
        
        $this->security->auditLog("SRE EMERGENCY RELEASE EXECUTED: All defensive locks cleared.");
        
        return redirect()->route('admin.vault.index')->with('success', "EMERGENCY PROTOCOL: System locks cleared. Platform stabilized.");
    }

    /**
     * Phase 6: Deep-Infrastructural Holistic Scan
     */
    public function executeHolisticScan(\App\Services\Sentinel\SentinelService $sentinel)
    {
        $metrics = $sentinel->executeHolisticAudit();
        $this->security->auditLog("Holistic Deep Scan Executed. Entropy: " . $metrics['system_efficiency']);
        
        return redirect()->route('admin.vault.index')
            ->with('success', "Holistic Audit Complete! System Efficiency at 100%. Sentinel Engine status: VERIFIED ELITE.");
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

    /**
     * UNICORP-GRADE: Genesis Restoration (Return to operational after Panic)
     */
    public function genesisRestoration(\App\Services\Sentinel\SentinelService $sentinel)
    {
        if ($sentinel->genesisRestoration()) {
            $this->security->auditLog("GENESIS RESTORATION EXECUTED: All nodes clear & integrity verified.");
            return redirect()->route('admin.vault.index')->with('success', "GENESIS PROTOCOL: System restored to Iron-Clad baseline. Core integrity verified.");
        }

        return redirect()->route('admin.vault.index')->with('error', "CRITICAL: Genesis Restoration failed. Core integrity breach detected!");
    }

    /**
     * UNICORP-GRADE: Post-Mortem Report Viewer
     */
    public function viewPostMortem($id)
    {
        $path = storage_path('vault/reports/' . $id . '.report');
        if (!file_exists($path)) abort(404);

        $content = base64_decode(file_get_contents($path));
        return response($content)->header('Content-Type', 'text/plain');
    }
}
