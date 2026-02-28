<?php

namespace App\Services\Seo;

class WikiAiService
{
    protected $apiKeys = [];
    protected $endpointTemplate = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $envPath = base_path('.env');
        $envContent = file_exists($envPath) ? file_get_contents($envPath) : '';
        for ($i = 1; $i <= 10; $i++) {
            $keyName = $i === 1 ? 'GEMINI_API_KEY' : "GEMINI_API_KEY_{$i}";
            $key = env($keyName);
            if (empty($key) || str_starts_with($key, 'AIzaSyCK')) {
                if (preg_match("/^{$keyName}=(.*)$/m", $envContent, $matches)) {
                    $key = trim($matches[1], "\"' ");
                }
            }
            if ($key) {
                $this->apiKeys[] = $key;
            }
        }
    }

    private function getGeminiKey()
    {
        if (empty($this->apiKeys)) return null;
        $keyCount = count($this->apiKeys);
        for ($attempts = 0; $attempts < $keyCount; $attempts++) {
            $index = cache()->increment('wiki_key_index') % $keyCount;
            $nodeId = $index + 1;
            if (!cache()->has("gemini_wiki_limit_{$nodeId}")) {
                return ['key' => $this->apiKeys[$index], 'index' => $nodeId];
            }
        }
        return null;
    }

    /**
     * "Neural Automator": Automatically generates technical descriptions and attributes.
     */
    public function generate(string $name, ?string $context = null)
    {
        // Chief Plumbing Auditor & SEO Architect Prompt Setup
        $prompt = <<<PROMPT
System Role: Anda adalah Chief Plumbing Auditor & SEO Architect untuk RooterIn. Tugas Anda adalah melakukan audit mendalam dan menulis ulang entitas WikiPipa agar memiliki otoritas teknis tertinggi (E-E-A-T) dan memenangkan Featured Snippet di Google.

Entitas Yang Di-Audit: {$name}
Konteks / Arahan Tambahan: {$context}

Instruksi Audit & Penulisan (Wajib):

1. Re-Definisi Operasional (Prinsip Fisika):
- Jangan gunakan definisi kamus umum.
- Gunakan prinsip kerja fisika/teknik (misal: Transit-time, Acoustic Correlation, Thermal Diffusivity).
- Tegaskan bahwa ini adalah metode Non-Destructive Test (NDT) untuk menjamin keamanan infrastruktur klien.

2. Konstruksi Tabel "Snippet Winner" (3 Kolom):
Buat tabel spesifikasi Markdown dengan format persis seperti ini:
| Atribut | Parameter Teknis | Analisis Strategis RooterIn |
| :--- | :--- | :--- |
| [Atribut Utama] | [Angka/Spek] | [Mengapa ini penting bagi klien?] |

3. Analisis Semantik & Hubungan Entitas:
- Sebutkan standar industri yang relevan (misal: ISO, SNI, atau ASTM).
- Hubungkan alat ini dengan masalah yang diselesaikan (misal: Water Hammer, NRW Loss, Pipe Corrosion).

4. Expert Discourse (Authority Paragraph):
- Gunakan terminologi tingkat tinggi: Signal-to-noise ratio, Cavitation risk, Laminar vs Turbulent flow.
- Tuliskan header "### RooterIn Field SOP (The Trust Signal)" dan berikan paragraf yang menjelaskan bahwa alat ini dikalibrasi secara rutin untuk menjamin akurasi 98% di lapangan (Zero-Error Excavation).

5. Format Output JSON:
WAJIB dan HANYA KEMBALIKAN RAW JSON (tanpa awalan ```json dan akhiran ```). 
Dilarang memberikan prolog/respon teks apapun selain JSON valid.

Format JSON:
{
  "desc": "Teks Markdown lengkap yang berisi hasil dari poin 1, 2, 3, dan 4 secara berurutan. Format heading gunakan Markdown: ### Header",
  "attrs": {
    "meta_title": "Otoritas Teknis {$name} - Standar Audit",
    "meta_desc": "Audit mendalam...",
    "keywords": "...",
    "internal_link": "Layanan Audit [...]",
    "semantic_signals": "Active (...)",
    "schema": "TechArticle",
    "educationalLevel": "Professional"
  },
  "wikidata": "Qxxxxx (Cari dan berikan Wikidata ID real / Q-Number dari entitas alat/konsep ini di Wikipedia/Wikidata)."
}
PROMPT;

        return $this->processGemini($prompt, $name);
    }

    private function processGemini($prompt, $fallbackName)
    {
        $maxAttempts = count($this->apiKeys);
        $attempts = 0;

        while ($attempts < $maxAttempts) {
            $keyData = $this->getGeminiKey();
            if (!$keyData) break;

            $apiKey = $keyData['key'];
            $nodeId = $keyData['index'];
            
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(30)->post("{$this->endpointTemplate}?key={$apiKey}", [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ],
                    'generationConfig' => ['temperature' => 0.1, 'topK' => 10, 'topP' => 0.6]
                ]);

                if ($response->successful()) {
                    $rawText = $response->json('candidates.0.content.parts.0.text', '');
                    if (preg_match('/\{.*\}/s', $rawText, $matches)) {
                        $data = json_decode($matches[0], true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            return $data;
                        }
                    }
                }

                if ($response->status() === 429) {
                    $errMsg = strtolower($response->json('error.message') ?? '');
                    $cooldownMinutes = (str_contains($errMsg, 'quota') || str_contains($errMsg, 'exhausted')) ? 60 : 2;
                    $until = now()->addMinutes($cooldownMinutes);
                    
                    cache()->put("gemini_wiki_limit_{$nodeId}", true, $until);
                    \Illuminate\Support\Facades\Log::warning("[WIKI AUTOMATOR] NODE-{$nodeId} hit 429. Failover activated.");
                    $attempts++;
                    continue; // Pindah ke key berikutnya
                }
                
                break; // Berhenti jika error lain (bukan 429) atau response aneh
                
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("[WIKI AUTOMATOR] API Fallback Node-{$nodeId}: " . $e->getMessage());
                $attempts++;
            }
        }

        // Fallback Logic if AI fails
        $hash = substr(md5(strtolower($fallbackName)), 0, 8);
        $pseudoID = 'Q' . hexdec($hash) % 100000;

        return [
            'desc' => "### Operasional Definisi\n{$fallbackName} adalah instrumen NDT berbasis fisika teknik presisi tinggi.\n\n### RooterIn Field SOP (The Trust Signal)\nTim RooterIn mengkalibrasi alat ini setiap sebelum uji forensik untuk akurasi 98% (zero-error excavation).\n\n*(Catatan: Neural Automator saat ini sedang dalam mode degradasi. Silakan refresh dan coba lagi.)*",
            'attrs' => [
                'meta_title' => $fallbackName . " - Neural Asset",
                'schema' => 'TechArticle',
                'educationalLevel' => 'Professional'
            ],
            'wikidata' => $pseudoID
        ];
    }
}
