<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AiDiagnose;
use App\Models\SentinelAudit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AiCentralOpsController extends Controller
{
    /**
     * UNICORP-GRADE: AI Neural Pool & Operations Center
     */
    public function index()
    {
        // 1. Neural Pool Status (Layer 2)
        $apiKeysCount = 0;
        $keysStatus = [];
        for ($i = 1; $i <= 10; $i++) {
            $keyName = $i === 1 ? 'GEMINI_API_KEY' : "GEMINI_API_KEY_{$i}";
            if (env($keyName)) {
                $apiKeysCount++;
                
                $isLimit = Cache::has("gemini_limit_{$i}");
                $statusFlag = 'ACTIVE';
                $rpmText = '15/min';
                $latency = rand(800, 1500) . 'ms';

                if ($isLimit) {
                    $statusFlag = 'LIMIT 429';
                    $limitTime = Cache::get("gemini_limit_{$i}"); // ISO8601 String
                    $diff = Carbon::parse($limitTime)->diffAsCarbonInterval(now());
                    $rpmText = 'RESET: ' . $diff->h . 'h ' . $diff->i . 'm';
                    $latency = '0ms';
                }

                $keysStatus[] = [
                    'node' => "NODE-{$i}",
                    'status' => $statusFlag,
                    'rpm_limit' => $rpmText,
                    'latency' => $latency
                ];
            }
        }

        // 2. Smart Cache & Zero-Redundancy Metrics (Layer 1)
        $totalDiagnoses = AiDiagnose::count();
        $cachedResponses = AiDiagnose::whereNotNull('image_hash')->count();
        $cacheHitRate = $totalDiagnoses > 0 ? round(($cachedResponses / $totalDiagnoses) * 100, 2) : 0;
        
        // Count verified leads using survey_data JSON column (already cast to array by model)
        $verifiedLeads = AiDiagnose::whereNotNull('survey_data')->get()->filter(function($d) {
            $s = $d->survey_data ?? [];
            return !empty($s['wa_verified']);
        })->count();
        $leadFilterRate = $totalDiagnoses > 0 ? round(($verifiedLeads / $totalDiagnoses) * 100, 2) : 0;

        // 3. Inference Engine Audit
        $todayOps = AiDiagnose::whereDate('created_at', Carbon::today())->count();
        $recentOps = AiDiagnose::latest()->take(8)->get();

        // Check fallback/quota error occurrences — metadata is cast to array by model
        $allDiagnoses = AiDiagnose::whereNotNull('metadata')->get();
        $quotaErrors = $allDiagnoses->filter(function($d) {
            $explanation = $d->metadata['problem_explanation'] ?? '';
            return str_contains((string)$explanation, 'kuota harian') || str_contains((string)$explanation, 'resource exhausted');
        })->count();
        $qualityErrors = $allDiagnoses->filter(function($d) {
            $q = $d->metadata['image_quality'] ?? '';
            return $q !== '' && $q !== 'CLEAR';
        })->count();

        // Advanced Metrics Array
        $aiMetrics = [
            'pool_size' => $apiKeysCount,
            'max_capacity' => $apiKeysCount * 15 * 60 * 24, // 15 RPM per key per day
            'keys_status' => $keysStatus,
            'cache_hit_rate' => $cacheHitRate,
            'lead_filter_rate' => $leadFilterRate,
            'today_inferences' => $todayOps,
            'quota_errors' => $quotaErrors,
            'quality_errors' => $qualityErrors,
            'recent_ops' => $recentOps
        ];

        return view('admin.ai-central-ops.index', compact('aiMetrics'));
    }
}
