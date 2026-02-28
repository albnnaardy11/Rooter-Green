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
        // FORCE-READ: Manually parse .env to bypass Laragon/PHP-CGI environment caching
        $envPath = base_path('.env');
        $envContent = file_exists($envPath) ? file_get_contents($envPath) : '';
        
        for ($i = 1; $i <= 10; $i++) {
            $keyName = $i === 1 ? 'GEMINI_API_KEY' : "GEMINI_API_KEY_{$i}";
            
            // Try standard env first, then manually grep from file if needed
            $key = env($keyName);
            if (empty($key) || str_starts_with($key, 'AIzaSyCK')) { // If empty or stuck on common old key prefix
                if (preg_match("/^{$keyName}=(.*)$/m", $envContent, $matches)) {
                    $key = trim($matches[1], "\"' ");
                }
            }

            if ($key) {
                $this->apiKeys[] = $key;
                Log::info("[SENTINEL] Node-{$i} Loaded. Fingerprint: " . substr($key, 0, 8) . "...");
            }
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
        
        $keyCount = count($this->apiKeys);
        
        // Use a persistent pointer to rotate fairly, but try ALL keys in one go if needed
        for ($attempts = 0; $attempts < $keyCount; $attempts++) {
            $index = cache()->increment('sentinel_key_index') % $keyCount;
            $nodeId = $index + 1;

            if (!cache()->has("gemini_limit_{$nodeId}")) {
                return [
                    'key' => $this->apiKeys[$index],
                    'index' => $nodeId
                ];
            }
        }

        return null;
    }

    /**
     * FORENSIC GUARD v2.0 — 5-Layer AI Validation System
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
  "rejection_reason": "string atau null",
  "image_quality": "GOOD|BLURRY|TOO_DARK|POOR_ANGLE",
  "quality_message": "string atau null",
  "detected_material": "PVC|BESI|TEMBAGA|BETON|TIDAK_TERLIHAT",
  "material_mismatch": true|false,
  "material_warning": "string atau null",
  "diagnosis": "string (judul diagnosa)",
  "problem_explanation": "string (penjelasan 2-3 kalimat)",
  "blockage_percentage": 0,
  "degradation_percentage": 0,
  "technical_report": "string (3-4 langkah mekanis)",
  "recommended_service_type": "MAMPET|REPARASI|CUCI_TOREN|INSTALASI"
}
PROMPT;

        $attempts = 0;
        $maxAttempts = count($this->apiKeys);
        $lastException = null;

        while ($attempts < $maxAttempts) {
            $keyData = $this->getKey();
            if (!$keyData) break;

            $startTime = microtime(true);
            $apiKey = $keyData['key'];
            $nodeId = $keyData['index'];
            $keyFingerprint = substr($apiKey, 0, 8) . '...';

            try {
                Log::info("[SENTINEL] Executing Inference via NODE-{$nodeId} (Fingerprint: $keyFingerprint)");
                $response = Http::timeout(45)->withHeaders([
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/' . rand(110, 120) . '.0.0.0 Safari/537.36',
                ])->post("{$this->endpointTemplate}?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                                ['inline_data' => ['mime_type' => $mimeType, 'data' => $base64Image]]
                            ]
                        ]
                    ],
                    'generationConfig' => ['temperature' => 0.1, 'topK' => 16, 'topP' => 0.6]
                ]);

                if ($response->successful()) {
                    $result = $response->json();
                    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                        $rawText = $result['candidates'][0]['content']['parts'][0]['text'];
                        if (preg_match('/\{.*\}/s', $rawText, $matches)) {
                            $data = json_decode($matches[0], true);
                            if (json_last_error() === JSON_ERROR_NONE) {
                                $data['performance'] = [
                                    'latency_ms' => (int)((microtime(true) - $startTime) * 1000),
                                    'key_used'   => "NODE-{$nodeId}",
                                    'timestamp'  => now()->toIso8601String(),
                                    'status'     => $attempts > 0 ? 'FAILOVER_STABLE' : 'STABLE'
                                ];
                                return $data;
                            }
                        }
                    }
                }

                if ($response->status() === 429) {
                    $errMsg = strtolower($response->json('error.message') ?? '');
                    $cooldownMinutes = (str_contains($errMsg, 'quota') || str_contains($errMsg, 'exhausted')) ? 60 : 2;
                    $until = now()->addMinutes($cooldownMinutes);
                    
                    cache()->put("gemini_limit_{$nodeId}", $until->toIso8601String(), $until);
                    Log::warning("[SENTINEL] NODE-{$nodeId} hit 429. Cooling down... Failover in 2s.");
                    
                    sleep(2); // Circuit breaker delay
                    $attempts++;
                    continue; 
                }

                throw new \Exception("Node-{$nodeId} Error: " . ($response->json('error.message') ?? 'Unknown Error'));

            } catch (\Exception $e) {
                $lastException = $e;
                Log::error("[SENTINEL] Attempt {$attempts} failed on NODE-{$nodeId}: " . $e->getMessage());
                $attempts++;
            }
        }

        throw $lastException ?? new \Exception('429');
    }
}
