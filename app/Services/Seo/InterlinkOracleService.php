<?php

namespace App\Services\Seo;

use App\Models\SeoKeyword;
use App\Models\WikiEntity;
use App\Models\SeoAuditLog;
use App\Services\Ai\AiQuotaGuardService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InterlinkOracleService
{
    /**
     * UNICORP-GRADE: Semantic Internal Linking Engine
     * Transform plain text into a semantically linked SEO network.
     */
    public function oracleLinkContent($content, $currentUrl = null)
    {
        $keywords = SeoKeyword::where('is_active', true)->orderByDesc('priority')->get();
        if ($keywords->isEmpty()) return $content;

        $guard = app(AiQuotaGuardService::class);
        $apiKey = $guard->getActiveKey();
        
        if (!$apiKey) {
            // Fallback to simple regex replacement if AI is unavailable
            return $this->basicRegexLinker($content, $keywords, $currentUrl);
        }

        $targetMap = $keywords->mapWithKeys(function($k) {
            return [$k->keyword => $k->target_url];
        })->toArray();

        $prompt = "You are an SEO Semantic Specialist. Given the following HTML content and a list of TARGET KEYWORDS + URLS, identify the best places to insert internal links.
        RULES:
        1. Only insert a max of 3-5 links depending on length.
        2. Do not link the same keyword twice.
        3. Only link natural occurrences.
        4. Return the fully transformed HTML content.
        
        TARGETS: " . json_encode($targetMap) . "
        
        CONTENT: $content";

        try {
            $response = Http::timeout(30)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey", [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->successful()) {
                $transformed = $response->json('candidates.0.content.parts.0.text');
                // Clean up markdown block if AI wraps it
                $transformed = preg_replace('/^```html\n|```$/', '', trim($transformed));
                return $transformed;
            }
        } catch (\Exception $e) {
            Log::error("[INTERLINK-ORACLE] AI Transform Error: " . $e->getMessage());
        }

        return $this->basicRegexLinker($content, $keywords, $currentUrl);
    }

    protected function basicRegexLinker($content, $keywords, $currentUrl)
    {
        $limit = 3;
        $count = 0;
        
        foreach ($keywords as $k) {
            if ($count >= $limit) break;
            if ($currentUrl && str_contains($k->target_url, $currentUrl)) continue;

            $pattern = '/\b(' . preg_quote($k->keyword, '/') . ')\b(?![^<]*>)/i';
            $replacement = '<a href="' . $k->target_url . '" class="text-primary hover:underline font-semibold">$1</a>';
            
            $newContent = preg_replace($pattern, $replacement, $content, 1, $matches);
            if ($matches > 0) {
                $content = $newContent;
                $count++;
            }
        }
        
        return $content;
    }

    public function processBatchWiki()
    {
        $entities = WikiEntity::where('description', 'not like', '%href%')
            ->limit(10)
            ->get();
            
        foreach ($entities as $entity) {
            /** @var WikiEntity $entity */
            $oldContent = $entity->description;
            $newContent = $this->oracleLinkContent($oldContent, "/wiki/{$entity->slug}");
            
            if ($oldContent !== $newContent) {
                $entity->description = $newContent;
                $entity->save();
                
                SeoAuditLog::create([
                    'event_type' => '[AUTO-OPTIMIZED] INTERLINK-ORACLE',
                    'description' => "Transformed semantic links for Wiki: {$entity->title}",
                    'winner_url' => "/wiki/{$entity->slug}",
                    'previous_state' => ['content' => substr($oldContent, 0, 200)],
                    'new_state' => ['content' => substr($newContent, 0, 200)]
                ]);
            }
        }
    }
}
