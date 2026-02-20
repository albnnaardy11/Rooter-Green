<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
use App\Models\AiLead;

class AiDiagnosticController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('AI Visual Pipe Diagnostics - Deteksi Mampet Otomatis');
        SEOTools::setDescription('Gunakan teknologi AI (Computer Vision) Rooterin untuk mendeteksi masalah pipa Anda hanya dengan foto. Cepat, akurat, dan canggih.');
        
        return view('ai-diagnostic.diagnosa');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'result_label' => 'required|string',
            'confidence_score' => 'required|integer',
            'audio_label' => 'nullable|string',
            'audio_confidence' => 'nullable|integer',
            'survey_data' => 'required|array',
            'recommended_tools' => 'nullable|string',
            'city_location' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        // --- ROOTERIN INFERENCE ENGINE (WEIGHTED MULTI-INPUT) ---
        $vScore = $validated['confidence_score'];
        $aScore = $validated['audio_confidence'] ?? 0;
        $sScore = !empty($validated['survey_data']) ? 90 : 0;

        // Composite Weighted Score Calculation
        $compositeScore = ($vScore * 0.5) + ($aScore * 0.3) + ($sScore * 0.2);
        
        // Deep Ranking Logic (A-E)
        $severity = 'E';
        if ($compositeScore >= 90) $severity = 'A';
        elseif ($compositeScore >= 75) $severity = 'B';
        elseif ($compositeScore >= 50) $severity = 'C';
        elseif ($compositeScore >= 25) $severity = 'D';

        // Generate ID: #RT-YYYY-XXXX
        $year = date('Y');
        $count = AiLead::whereYear('created_at', $year)->count() + 1;
        $diagnoseId = "#RT-{$year}-" . str_pad($count, 4, '0', STR_PAD_LEFT);

        $lead = AiLead::create([
            'diagnose_id' => $diagnoseId,
            'material_type' => $validated['survey_data']['material'] ?? 'unknown',
            'location_context' => $validated['survey_data']['sub_context'] ?? $validated['survey_data']['location'] ?? 'general',
            'ai_result' => $validated['result_label'],
            'confidence_score' => $vScore,
            'severity_score' => $severity,
            'audio_analysis' => $validated['audio_label'] ?? 'captured',
            'recommended_tools' => $validated['recommended_tools'] ?? 'Standard Rooter',
            'city_location' => $validated['city_location'] ?? 'Auto-Detect',
            'raw_survey_data' => $validated['survey_data'],
            'metadata' => $validated['metadata'] ?? [],
            'status' => 'new'
        ]);

        return response()->json([
            'success' => true,
            'diagnose_id' => $lead->diagnose_id,
            'deep_ranking' => $severity,
            'data' => $lead
        ]);
    }
}
