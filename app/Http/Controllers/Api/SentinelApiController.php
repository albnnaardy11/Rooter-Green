<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SentinelAudit;
use App\Http\Resources\SentinelAuditResource;
use Illuminate\Support\Facades\Cache;

class SentinelApiController extends Controller
{
    /**
     * Phase 3 — Retrieve the latest Holistic Scan audit log.
     * Formatted via SentinelAuditResource (Omni-Data Mapping).
     */
    public function latest()
    {
        $audit = SentinelAudit::latest()->first();

        if (!$audit) {
            return response()->json([
                'status'  => 'PENDING',
                'message' => 'No holistic scan records found. Execute a Holistic Audit first.'
            ], 404);
        }

        return new SentinelAuditResource($audit);
    }

    /**
     * Phase 6 — Live Security Pulse (cache-based telemetry).
     * Returns the VERIFIED ELITE badge and last heartbeat timestamp.
     */
    public function pulse()
    {
        return response()->json([
            'security_pulse'   => Cache::get('security_pulse_status', 'PENDING'),
            'last_heartbeat'   => Cache::get('last_system_heartbeat', 'Never'),
            'fragmentation'    => Cache::get('sentinel_fragmentation_level', 5.0) . '%',
            'lockdown_active'  => (bool) Cache::get('system_lockdown_active', false),
            'shield_status'    => Cache::get('sentinel_shield_status', 'ACTIVE'),
            'blocked_ips'      => count(Cache::get('blocked_ips', [])),
            'timestamp_gmt'    => gmdate('Y-m-d H:i:s') . ' GMT+0000',
        ]);
    }
}
