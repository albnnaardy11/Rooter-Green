<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiVisionService
{
    protected $apiKeys = [];
    protected $endpointTemplate = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct()
    {
        // ROTATION ENGINE: Collect all available keys from .env (GEMINI_API_KEY, GEMINI_API_KEY_2, etc.)
        for ($i = 1; $i <= 10; $i++) {
            $keyName = $i === 1 ? 'GEMINI_API_KEY' : "GEMINI_API_KEY_{$i}";
            $key = env($keyName);
            if ($key) $this->apiKeys[] = $key;
        }
        
        if (empty($this->apiKeys)) {
            Log::error('[SENTINEL] No API keys found in Neural Pool!');
        }
    }

    /**
     * Round-Robin Key Selector (With Rate-Limit Evasion)
     */
    private function getKey()
    {
        if (empty($this->apiKeys)) return null;
        
        $maxAttempts = count($this->apiKeys);
        $attempts = 0;

        while ($attempts < $maxAttempts) {
            $index = cache()->increment('sentinel_key_index') % count($this->apiKeys);
            $nodeId = $index + 1;

            if (!cache()->has("gemini_limit_{$nodeId}")) {
                return [
                    'key' => $this->apiKeys[$index],
                    'index' => $nodeId
                ];
            }
            $attempts++;
        }

        // All keys are exhausted
        return null;
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
        if (empty($this->apiKeys)) {
            Log::error('Gemini API Key is missing.');
            throw new \Exception('Neural Pool Exhausted (429): No API keys configured.');
        }

        $materialLabel = match(strtolower($material)) {
            'pvc'        => 'PVC / Plastik',
            'besi'       => 'Besi / Cast Iron',
            'fleksibel'  => 'Selang Fleksibel',
            default      => 'Tidak Diketahui',
        };

        $prompt = <<<PROMPT
Anda adalah Master Insinyur Forensik Plumbing Senior dengan pengalaman 50 tahun di lapangan, spesialis dalam kegagalan sistem perpipaan kritis (Forensic Plumbing Expert). 
Anda tidak memberikan jawaban generik. Anda berpikir sangat kritis, skeptis, dan mendeteksi detail yang dilewatkan orang awam.

=== TUGAS ANDA ===
Analisis foto secara forensik. Jangan tertipu oleh visual permukaan. 
Cari tanda-tanda: korosi mikro, kelelahan material (material fatigue), pola sedimentasi yang menunjukkan aliran air yang salah, atau degradasi struktural akibat tekanan.

=== KONTEKS SYSTEM ===
- Material yang Diklaim: {$materialLabel}
- Lokasi: {$location}

=== PROTOKOL ANALISIS KRITIS ===
1. [VISUAL SCAN]: Apakah ini benar-benar pipa? (Jika tidak, tolak dengan tegas namun profesional).
2. [QUALITY AUDIT]: Apakah pencahayaan cukup untuk melihat tekstur material?
3. [MATERIAL FINGERPRINT]: Verifikasi jika visual cocok dengan {$materialLabel}. Jika Anda melihat karat merah pada klaim PVC, sebutkan itu anomali!
4. [FORENSIC DIAGNOSIS]: 
   - Jangan hanya bilang "mampet". Jelaskan APA yang menyumbat (lemak membatu, kalsium, atau benda asing).
   - Estimasi persentase penyempitan diameter pipa.
   - Evaluasi resiko pecah/kebocoran dalam waktu dekat.
5. [TECHNICAL ACTION]: Berikan instruksi teknis level profesional (misal: "Gunakan hydro-jet dengan tekanan 3000 PSI" atau "Lakukan descaling mekanis segera"). Rekomendasikan minimal 2 alat spesifik.

PENTING: Gunakan bahasa teknis yang berwibawa namun tetap bisa dipahami oleh klien (Bahasa Indonesia). Jangan gunakan kata-kata seperti "sepertinya" atau "mungkin". Gunakan "Analisis teknis menunjukkan..." atau "Terdeteksi secara visual...".

=== FORMAT OUTPUT ===
PENTING: Hanya berikan JSON valid berikut, TANPA teks di luar JSON:

{
  "is_plumbing_subject": true|false,
  "rejection_reason": "string atau null — mengapa foto ditolak (isi jika is_plumbing_subject=false). Gunakan nada tenang namun tegas sebagai ahli.",
  "image_quality": "GOOD|BLURRY|TOO_DARK|POOR_ANGLE",
  "quality_message": "string — pesan spesifik jika kualitas buruk, null jika GOOD. Jelaskan APA yang tidak terlihat secara teknis.",
  "detected_material": "PVC|BESI|TEMBAGA|BETON|TIDAK_TERLIHAT",
  "material_mismatch": true|false,
  "material_warning": "string — peringatan jika ada ketidakcocokan material, null jika cocok",
  "diagnosis": "string — judul diagnosis profesional (misal: Heavy Calcite Scaling detected)",
  "problem_explanation": "string — Penjelasan mendalam (2-3 kalimat) tentang APA yang Anda temukan secara forensik dan MENGAPA itu terjadi. Bertindaklah seperti dokter pipa.",
  "blockage_percentage": 0,
  "degradation_percentage": 0,
  "technical_report": "string — Urutan langkah mekanis spesifik. Gunakan terminologi profesional (misal: 'Mechanized Spiral Cleaning with C-Cutter'). Berikan minimal 3 poin teknis.",
  "recommended_service_type": "MAMPET|REPARASI|CUCI_TOREN|INSTALASI"
}
PROMPT;

        $keyData = $this->getKey();
        if (!$keyData) {
            Log::error('[SENTINEL] Fatal: All Neural Pool nodes are in cooldown (429).');
            throw new \Exception('429: Semua API key sedang dalam cooldown. Cache telah direset, coba lagi dalam beberapa menit.');
        }

        $startTime = microtime(true);
        $apiKey = $keyData['key'];

        try {
            $response = Http::timeout(45)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->endpointTemplate}?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt . "\n\nKRITIS: Jangan memberikan jawaban yang sama untuk foto yang berbeda. Analisis setiap lekukan, warna, dan tekstur secara spesifik."],
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
                    'temperature'         => 0.2,
                    'topK'                => 32,
                    'topP'                => 1
                ]
            ]);

            $latency = (int)((microtime(true) - $startTime) * 1000);
            
            if ($response->successful()) {
                $result = $response->json();

                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $rawText = $result['candidates'][0]['content']['parts'][0]['text'];

                    if (preg_match('/\{.*\}/s', $rawText, $matches)) {
                        $data = json_decode($matches[0], true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            // Add Performance Audit Metadata
                            $data['performance'] = [
                                'latency_ms' => $latency,
                                'key_used'   => "NODE-{$keyData['index']}",
                                'timestamp'  => now()->toIso8601String(),
                                'status'     => 'STABLE'
                            ];

                            Log::info('[SENTINEL] Neural Inference Success', $data['performance']);
                            return $data;
                        }
                    }

                    Log::error('[ForensicAI] JSON parsing failed. Raw: ' . $rawText);
                }
            } else {
                $status = $response->status();
                Log::error('[ForensicAI] API Error: ' . $response->body());
                
                if ($status === 429) {
                    $errMsg = strtolower($response->json('error.message') ?? '');

                    // Smart cooldown: RPM limit (rate/minute) = short 90s, Daily quota = 60min
                    if (str_contains($errMsg, 'retry') || str_contains($errMsg, 'resource_exhausted') && str_contains($errMsg, 'second')) {
                        // RPM limit — resets in under 2 minutes
                        cache()->put("gemini_limit_{$keyData['index']}", 'rpm', now()->addSeconds(90));
                        Log::warning("[SENTINEL] NODE-{$keyData['index']} RPM limit hit. Cooldown 90s.");
                    } else {
                        // Daily quota exhausted
                        cache()->put("gemini_limit_{$keyData['index']}", 'daily', now()->addMinutes(60));
                        Log::error("[SENTINEL] NODE-{$keyData['index']} daily quota hit. Cooldown 60min.");
                    }

                    // AUTO-FAILOVER: immediately try next available key
                    $fallbackKey = $this->getKey();
                    if ($fallbackKey && $fallbackKey['index'] !== $keyData['index']) {
                        Log::info("[SENTINEL] Auto-failover to NODE-{$fallbackKey['index']}");
                        $retryResp = Http::timeout(45)->withHeaders(['Content-Type' => 'application/json'])
                            ->post("{$this->endpointTemplate}?key={$fallbackKey['key']}", [
                                'contents' => [[
                                    'parts' => [
                                        ['text' => $prompt . "\n\nKRITIS: Analisis setiap detail secara spesifik."],
                                        ['inline_data' => ['mime_type' => $mimeType, 'data' => $base64Image]]
                                    ]
                                ]],
                                'generationConfig' => ['temperature' => 0.2, 'topK' => 32, 'topP' => 1]
                            ]);

                        if ($retryResp->successful()) {
                            $rResult = $retryResp->json();
                            if (isset($rResult['candidates'][0]['content']['parts'][0]['text'])) {
                                if (preg_match('/\{.*\}/s', $rResult['candidates'][0]['content']['parts'][0]['text'], $m)) {
                                    $rData = json_decode($m[0], true);
                                    if (json_last_error() === JSON_ERROR_NONE) {
                                        $rData['performance'] = [
                                            'latency_ms' => (int)((microtime(true) - $startTime) * 1000),
                                            'key_used'   => "NODE-{$fallbackKey['index']} (failover)",
                                            'timestamp'  => now()->toIso8601String(),
                                            'status'     => 'FAILOVER'
                                        ];
                                        Log::info('[SENTINEL] Failover via NODE-' . $fallbackKey['index']);
                                        return $rData;
                                    }
                                }
                            }
                        } elseif ($retryResp->status() === 429) {
                            cache()->put("gemini_limit_{$fallbackKey['index']}", 'rpm', now()->addSeconds(90));
                            Log::error("[SENTINEL] Failover NODE-{$fallbackKey['index']} also rate-limited.");
                        }
                    }

                    // Both keys exhausted — tell user to retry in a moment
                    throw new \Exception('429');
                }

                throw new \Exception("API Error: " . ($response->json('error.code') ?? $status) . " - " . ($response->json('error.message') ?? 'Unknown Error'));
            }
        } finally {
            // Cleanup or final logging if needed
        }

        return null;
    }
}
