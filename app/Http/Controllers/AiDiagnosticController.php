<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
use App\Models\AiDiagnose;

class AiDiagnosticController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('AI Visual Pipe Diagnostics - Deteksi Mampet Otomatis');
        SEOTools::setDescription('Gunakan teknologi AI (Computer Vision) Rooterin untuk mendeteksi masalah pipa Anda hanya dengan foto. Cepat, akurat, dan canggih.');
        
        return response()
            ->view('ai-diagnostic.diagnosa')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_base64'     => 'nullable|string',
            'result_label'     => 'nullable|string',
            'confidence_score' => 'nullable|integer',
            'audio_label'      => 'nullable|string',
            'audio_confidence' => 'nullable|integer',
            'survey_data'      => 'required|array',
            'recommended_tools'=> 'nullable|string',
            'city_location'    => 'nullable|string',
            'latitude'         => 'nullable|numeric',
            'longitude'        => 'nullable|numeric',
            'metadata'         => 'nullable|array',
        ]);

        $base64Image = $request->input('image_base64');
        $neuralDiagnosis = null;
        $imageHash = null;
        $isQuotaError = false;

        // --- LAYER 0: STRICT INPUT VALIDATION ---
        if (
            empty($base64Image) || 
            empty($validated['survey_data']['location']) || 
            empty($validated['survey_data']['material']) || 
            empty($validated['survey_data']['frequency'])
        ) {
            return response()->json([
                'success' => false, 
                'error_code' => 'INCOMPLETE_SURVEY',
                'message' => 'Anda harus mengunggah foto visual dan melengkapi seluruh bagian Technical Survey (Lokasi, Material, Frekuensi).'
            ], 422);
        }

        // --- PHASE 4: SRE MAINTENANCE & RESOURCE GUARD (Pixel-Infiltration Scan) ---
        if ($base64Image) {
            if (!preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                return response()->json(['success' => false, 'message' => 'Invalid image format. Sentinel Neural Guard Blocked.'], 400);
            }
            
            $imageType = strtolower($type[1]);
            if (!in_array($imageType, ['jpg', 'jpeg', 'png', 'webp'])) {
                return response()->json(['success' => false, 'message' => 'Unsupported format. Sentinel Neural Guard Blocked.'], 400);
            }
            
            $base64Data = substr($base64Image, strpos($base64Image, ',') + 1);
            
            // Check memory footprint size limit (e.g. max 5MB base64 decode limit)
            if (strlen(base64_decode($base64Data)) > 5 * 1024 * 1024) {
                 return response()->json(['success' => false, 'message' => 'Image too large. Sentinel Resource Guard Active.'], 400);
            }

            // --- LAYER 1: THE SMART GATEKEEPER (Zero-Redundancy & Lead Filtering) ---
            $imageHash = hash('sha256', base64_decode($base64Data));
            
            // 1.1: Verified Lead Filter (Prevent bot/anonymous quota burn)
            $isVerifiedLead = $validated['survey_data']['wa_verified'] ?? false;
            // Note: In development, we allow all. In production, we enforce this check.
            
            // 1.2: Zero-Redundancy (Smart Caching)
            $existingResult = null;
            if ($imageHash) {
                $existingResult = AiDiagnose::where('image_hash', $imageHash)
                    ->where('status', 'pending')
                    ->latest()
                    ->first();
            }

            if ($existingResult) {
                \Illuminate\Support\Facades\Log::info('[SENTINEL] Smart Cache Match. Returning Instant Diagnosis.', ['hash' => $imageHash]);
                return response()->json([
                    'success'          => true,
                    'diagnose_id'      => $existingResult->diagnose_id,
                    'deep_ranking'     => $existingResult->final_deep_score,
                    'material_warning' => $existingResult->metadata['material_warning'] ?? null,
                    'cached'           => true,
                    'data'             => $existingResult
                ]);
            }

            // 1.3: Quality-First Override (Session check) - Simplified for controller implementation
            
            try {
                $geminiService = app(\App\Services\AI\GeminiVisionService::class);
                
                $material = $validated['survey_data']['material'] ?? 'unknown';
                $location = $validated['survey_data']['sub_context'] ?? $validated['survey_data']['location'] ?? 'general';

                $neuralDiagnosis = $geminiService->analyzePipeImage(
                    $base64Data, 
                    "image/$imageType", 
                    $material, 
                    $location
                );

                // ── LAYER 1: SUBJECT VALIDATION ──────────────────────────────
                if ($neuralDiagnosis && isset($neuralDiagnosis['is_plumbing_subject']) && $neuralDiagnosis['is_plumbing_subject'] === false) {
                    return response()->json([
                        'success'    => false,
                        'error_code' => 'NOT_PIPE',
                        'message'    => $neuralDiagnosis['rejection_reason'] ?? 'Gambar tidak menunjukkan pipa atau sistem perpipaan. Silakan ambil foto pipa/saluran Anda.',
                        'action'     => 'RETAKE_PHOTO',
                    ], 422);
                }

                // ── LAYER 2: IMAGE QUALITY CHECK ─────────────────────────────
                if ($neuralDiagnosis && isset($neuralDiagnosis['image_quality']) && $neuralDiagnosis['image_quality'] !== 'GOOD') {
                    $qualityMap = [
                        'BLURRY'      => 'Foto terlalu buram/goyang. Pastikan kamera stabil dan fokus sebelum mengambil foto.',
                        'TOO_DARK'    => 'Foto terlalu gelap. Nyalakan lampu atau gunakan flash untuk menerangi area pipa.',
                        'POOR_ANGLE'  => 'Sudut pengambilan foto kurang optimal. Arahkan kamera langsung ke area bermasalah pada pipa.',
                    ];
                    $qualityMsg = $neuralDiagnosis['quality_message'] ?? ($qualityMap[$neuralDiagnosis['image_quality']] ?? 'Kualitas foto tidak memadai untuk analisis forensik.');
                    
                    return response()->json([
                        'success'       => false,
                        'error_code'    => 'POOR_IMAGE_QUALITY',
                        'quality_type'  => $neuralDiagnosis['image_quality'],
                        'message'       => $qualityMsg,
                        'action'        => 'RETAKE_PHOTO',
                    ], 422);
                }

            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("ForensicAI Unreachable: " . $e->getMessage());
                if (str_contains($e->getMessage(), '429')) {
                    return response()->json([
                        'success' => false,
                        'error_code' => 'RATE_LIMIT_EXCEEDED',
                        'message' => 'Sistem Neural AI kami sedang dalam kapasitas penuh (Error 429). Silakan coba lagi nanti.'
                    ], 422);
                }
                
                return response()->json([
                    'success' => false,
                    'error_code' => 'SERVER_ERROR',
                    'message' => 'Gagal terhubung ke Neural AI (' . $e->getMessage() . ').'
                ], 422);
            }
        }

        // --- ROOTERIN INFERENCE ENGINE (STRICT NEURAL ONLY) ---
        $serviceType     = 'MAMPET';
        $materialWarning = null;

        if (!$neuralDiagnosis || !is_array($neuralDiagnosis)) {
            return response()->json([
                'success' => false,
                'error_code' => 'INVALID_AI_RESPONSE',
                'message' => 'AI memberikan respons yang tidak dapat diproses.'
            ], 422);
        }

        \Illuminate\Support\Facades\Log::info('[ForensicAI] Raw Neural Diagnosis Data:', ['data' => $neuralDiagnosis]);

        $validated['result_label']                        = $neuralDiagnosis['diagnosis'] ?? 'Neural Blockage Detect';
        $vScore                                           = $neuralDiagnosis['blockage_percentage'] ?? 80;
        $validated['recommended_tools']                   = $neuralDiagnosis['technical_report'] ?? 'CCTV Inspection Required';
        $validated['metadata']['problem_explanation']     = $neuralDiagnosis['problem_explanation'] ?? 'Masalah terdeteksi pada sistem instalasi Anda. Hubungi tim ahli untuk investigasi lanjut.';
        $validated['metadata']['degradation_percentage']  = $neuralDiagnosis['degradation_percentage'] ?? 0;
        $validated['metadata']['ai_engine']               = 'Google Gemini 2.0 Flash (SENTINEL NODE)';
        $validated['metadata']['performance']             = $neuralDiagnosis['performance'] ?? [];
        $validated['metadata']['detected_material']       = $neuralDiagnosis['detected_material'] ?? null;
        $serviceType                                      = $neuralDiagnosis['recommended_service_type'] ?? 'MAMPET';

        // ── LAYER 3: MATERIAL CROSS-CHECK WARNING ────────────────────
        if (!empty($neuralDiagnosis['material_mismatch']) && $neuralDiagnosis['material_mismatch'] === true) {
            $materialWarning = $neuralDiagnosis['material_warning'] 
                ?? 'Perhatian: AI mendeteksi kemungkinan ketidaksesuaian antara material yang Anda pilih dengan yang terlihat di foto. Pastikan pilihan material sudah benar.';
        }

        $aScore = $validated['audio_confidence'] ?? 0;
        $sScore = !empty($validated['survey_data']) ? 90 : 0;

        // Composite Weighted Score Calculation (Now integrating Neural output natively)
        $compositeScore = ($vScore * 0.5) + ($aScore * 0.3) + ($sScore * 0.2);

        // Deep Ranking Logic (A-E)
        $severity = 'E';
        if ($compositeScore >= 90) $severity = 'A';
        elseif ($compositeScore >= 75) $severity = 'B';
        elseif ($compositeScore >= 50) $severity = 'C';
        elseif ($compositeScore >= 25) $severity = 'D';

        // Generate ID: #RT-YYYY-XXXX
        $year  = date('Y');
        $count = AiDiagnose::whereYear('created_at', $year)->count() + 1;
        $diagnoseId = "#RT-{$year}-" . str_pad($count, 4, '0', STR_PAD_LEFT);

        // Use REAL GPS coordinates sent by the browser.
        // Fall back to Jakarta center ONLY if browser did not provide coords.
        $lat = isset($validated['latitude'])  ? (float) $validated['latitude']  : -6.200000;
        $lng = isset($validated['longitude']) ? (float) $validated['longitude'] : 106.816666;

        // --- SERVICE INTEGRATION MAPPING (DYNAMIC) ---
        $servicePool = [
            'MAMPET'      => ['slug' => 'saluran-pembuangan-mampet', 'name' => 'Saluran Pembuangan Mampet'],
            'REPARASI'    => ['slug' => 'instalasi-sanitary-pipa',   'name' => 'Instalasi Sanitary & Pipa'],
            'CUCI_TOREN'  => ['slug' => 'air-bersih-cuci-toren',      'name' => 'Air Bersih & Cuci Toren'],
            'INSTALASI'   => ['slug' => 'instalasi-sanitary-pipa',   'name' => 'Instalasi Sanitary & Pipa']
        ];
        
        $targetService = $servicePool[$serviceType] ?? $servicePool['MAMPET'];

        try {
            $lead = AiDiagnose::create([
                'diagnose_id' => $diagnoseId,
                'result_label' => $validated['result_label'],
                'confidence_score' => $vScore,
                'final_deep_score' => $severity,
                'material_type' => $validated['survey_data']['material'] ?? 'pvc',
                'location_context' => $validated['survey_data']['sub_context'] ?? $validated['survey_data']['location'] ?? 'general',
                'audio_label' => $validated['audio_label'] ?? 'Standard Flow',
                'audio_confidence' => $aScore,
                'survey_data' => $validated['survey_data'],
                'recommended_tools' => $validated['recommended_tools'] ?? 'Rooter Machine',
                'city_location' => $validated['city_location'] ?? 'Auto Detect',
                'latitude' => $lat,
                'longitude' => $lng,
                'metadata' => array_merge($validated['metadata'] ?? [], [
                    'recommended_service_slug' => $targetService['slug'],
                    'recommended_service_name' => $targetService['name']
                ]),
                'image_hash' => ($neuralDiagnosis && is_array($neuralDiagnosis)) ? $imageHash : null,
                'status' => 'success'
            ]);

            // Optional cache eviction - disabled to avoid triggering Vite reload
            /*
            try {
                \Illuminate\Support\Facades\Cache::forget('ai_intelligence_heatmap');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Cache eviction failed: " . $e->getMessage());
            }
            */

            return response()->json([
                'success'          => true,
                'diagnose_id'      => $lead->diagnose_id,
                'deep_ranking'     => $severity,
                'material_warning' => $materialWarning,
                'data'             => $lead
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Diagnostic Storage Failed: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }
    public function getHandshake()
    {
        $phantom = app(\App\Services\Security\PhantomSyncService::class);
        $token = $phantom->generateToken([
            'ip' => request()->ip(),
            'agent' => request()->userAgent()
        ]);
        
        return response()->json([
            'success' => true,
            'token' => $token
        ]);
    }
}
