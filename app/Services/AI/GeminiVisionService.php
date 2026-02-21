<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiVisionService
{
    protected $apiKey;
    protected $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    /**
     * FORENSIC GUARD v2.0 — 5-Layer AI Validation System
     * 
     * Layer 1: Subject Validation (Is this a pipe/drain?)
     * Layer 2: Image Quality Check (Is photo clear enough?)
     * Layer 3: Material Cross-Check (Does declared material match visual?)
     * Layer 4: Full Forensic Diagnosis
     * Layer 5: Service Recommendation
     */
    public function analyzePipeImage(string $base64Image, string $mimeType, string $material, string $location): ?array
    {
        if (empty($this->apiKey)) {
            Log::error('Gemini API Key is missing.');
            return null;
        }

        $materialLabel = match(strtolower($material)) {
            'pvc'        => 'PVC / Plastik',
            'besi'       => 'Besi / Cast Iron',
            'fleksibel'  => 'Selang Fleksibel',
            default      => 'Tidak Diketahui',
        };

        $prompt = <<<PROMPT
Anda adalah Insinyur Forensik Pipa Senior bersertifikat ASTM D2321, ASTM F1216, dan SNI 03-6419-2000.
Anda bertugas melakukan 5 lapis validasi dan analisis pada gambar yang diberikan.

=== KONTEKS YANG DIBERIKAN USER ===
- Material Pipa yang Diklaim: {$materialLabel}
- Lokasi Instalasi: {$location}

=== INSTRUKSI VALIDASI ===

[LAYER 1 - VALIDASI SUBJEK]
Periksa apakah gambar ini benar-benar menampilkan pipa, saluran air, fitting pipa, drain, closet, wastafel, toren/tangki air, atau komponen sistem perpipaan ANY lainnya.
Jika gambar menampilkan kucing, makanan, manusia, pemandangan, atau hal NON-plumbing — TOLAK.

[LAYER 2 - KUALITAS GAMBAR]
Evaluasi kualitas foto secara objektif:
- GOOD: Gambar cukup jelas untuk identifikasi profesional
- BLURRY: Gambar buram/goyang sehingga detail tidak terlihat
- TOO_DARK: Gambar terlalu gelap/underexposed, detail pipa tidak terlihat
- POOR_ANGLE: Pipa tidak terlihat memadai karena sudut pengambilan ekstrem

[LAYER 3 - CROSS-CHECK MATERIAL]
Bandingkan material yang DIKLAIM user ({$materialLabel}) dengan apa yang TERLIHAT di gambar secara visual:
- PVC/Plastik biasanya: berwarna putih/abu/oranye, permukaan halus, sering terlihat sambungan solvent
- Besi/Cast Iron: berwarna gelap/hitam/coklat kemerahan (korosi), permukaan kasar, sambungan flanged/threaded
- Tembaga: berwarna keemasan/coklat tembaga, dinding tipis, sambungan soldered

[LAYER 4 - DIAGNOSIS FORENSIK MENDALAM]
Identifikasi semua masalah yang terlihat:
- Akumulasi Grease/FOG (Lemak)
- Korosi/Karat — tingkat keparahan (Ringan/Sedang/Berat/Kritis)
- Kerak Kalsium (Scale)
- Infiltrasi Akar Pohon
- Retakan/Kerusakan Struktural (Crack/Joint Failure)
- Sedimentasi/Endapan

[LAYER 5 - REKOMENDASI LAYANAN]
Pilih layanan yang paling sesuai berdasarkan temuan.

=== FORMAT OUTPUT ===
PENTING: Hanya berikan JSON valid berikut, TANPA teks di luar JSON:

{
  "is_plumbing_subject": true|false,
  "rejection_reason": "string atau null — mengapa foto ditolak (isi jika is_plumbing_subject=false)",
  "image_quality": "GOOD|BLURRY|TOO_DARK|POOR_ANGLE",
  "quality_message": "string — pesan spesifik jika kualitas buruk, null jika GOOD",
  "detected_material": "PVC|BESI|TEMBAGA|BETON|TIDAK_TERLIHAT",
  "material_mismatch": true|false,
  "material_warning": "string — peringatan jika ada ketidakcocokan material, null jika cocok",
  "diagnosis": "string — judul diagnosis singkat dan padat",
  "blockage_percentage": 0,
  "degradation_percentage": 0,
  "technical_report": "string — laporan teknis mendalam dengan terminologi profesional dan solusi spesifik",
  "recommended_service_type": "MAMPET|REPARASI|CUCI_TOREN|INSTALASI"
}
PROMPT;

        try {
            $response = Http::timeout(45)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->endpoint}?key={$this->apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                            [
                                'inline_data' => [
                                    'mime_type' => $mimeType,
                                    'data'      => $base64Image,
                                ]
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature'         => 0.1,
                    'topK'                => 32,
                    'topP'                => 1,
                    'response_mime_type'  => 'application/json'
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();

                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $rawText = $result['candidates'][0]['content']['parts'][0]['text'];

                    if (preg_match('/\{.*\}/s', $rawText, $matches)) {
                        $data = json_decode($matches[0], true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            Log::info('[ForensicAI] Analysis complete.', [
                                'is_plumbing' => $data['is_plumbing_subject'] ?? null,
                                'quality'     => $data['image_quality'] ?? null,
                                'material'    => $data['detected_material'] ?? null,
                                'mismatch'    => $data['material_mismatch'] ?? null,
                            ]);
                            return $data;
                        }
                    }

                    Log::error('[ForensicAI] JSON parsing failed. Raw: ' . $rawText);
                }
            } else {
                Log::error('[ForensicAI] API Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('[ForensicAI] Exception: ' . $e->getMessage());
        }

        return null;
    }
}
