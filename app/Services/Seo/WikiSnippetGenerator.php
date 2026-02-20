<?php

namespace App\Services\Seo;

use Spatie\SchemaOrg\Schema as SchemaOrg;
use App\Models\WikiEntity;

class WikiSnippetGenerator
{
    /**
     * Generate "FAQPage" schema for Wiki Entities to dominate Featured Snippets.
     */
    public function generateFaqSchema(WikiEntity $entity)
    {
        $questions = [
            [
                'q' => "Apa itu {$entity->title}?",
                'a' => $entity->description
            ]
        ];

        // Add dynamic questions based on attributes (Skip non-string data or SEO-only keys)
        if ($entity->attributes) {
            $excludedKeys = ['meta_title', 'meta_desc', 'keywords', 'schema', 'internal_link', 'semantic_signals'];
            foreach ($entity->attributes as $key => $value) {
                if (in_array($key, $excludedKeys) || !is_string($value)) {
                    continue;
                }
                
                $questions[] = [
                    'q' => "Berapa {$key} dari {$entity->title}?",
                    'a' => "{$entity->title} memiliki {$key} senilai {$value} sesuai standar teknis profesional."
                ];
            }
        }

        $faqItems = [];
        foreach ($questions as $q) {
            $faqItems[] = SchemaOrg::question()
                ->name($q['q'])
                ->acceptedAnswer(
                    SchemaOrg::answer()->text($q['a'])
                );
        }

        return SchemaOrg::faqPage()->mainEntity($faqItems);
    }

    /**
     * Generate "HowTo" schema for Wiki entities categorized as tools or chemicals.
     */
    public function generateHowToSchema(WikiEntity $entity)
    {
        if (in_array($entity->category, ['Alat Teknisi', 'Kimia', 'Spesialis'])) {
            return SchemaOrg::howTo()
                ->name("Cara Menggunakan {$entity->title} untuk Saluran Mampet")
                ->step([
                    SchemaOrg::howToStep()->text("Identifikasi titik sumbatan pada saluran."),
                    SchemaOrg::howToStep()->text("Siapkan {$entity->title} sesuai instruksi keamanan."),
                    SchemaOrg::howToStep()->text("Gunakan {$entity->title} secara perlahan agar tidak merusak dinding pipa."),
                    SchemaOrg::howToStep()->text("Bilas dengan air mengalir setelah proses pembersihan selesai.")
                ])
                ->totalTime(SchemaOrg::duration()->hours(0)->minutes(30));
        }

        if ($entity->category === 'Masalah Plumbing') {
            return SchemaOrg::howTo()
                ->name("Cara Mengatasi {$entity->title}")
                ->step([
                    SchemaOrg::howToStep()->text("Lakukan pengecekan pada titik yang dicurigai terjadi {$entity->title}."),
                    SchemaOrg::howToStep()->text("Gunakan alat pendeteksi kebocoran atau kamera pipa jika diperlukan."),
                    SchemaOrg::howToStep()->text("Terapkan solusi teknis sesuai dengan tingkat keparahan {$entity->title}."),
                    SchemaOrg::howToStep()->text("Hubungi RooterIn jika masalah terus berlanjut untuk penanganan profesional.")
                ])
                ->totalTime(SchemaOrg::duration()->hours(0)->minutes(45));
        }

        return null;
    }
}
