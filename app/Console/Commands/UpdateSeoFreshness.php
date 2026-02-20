<?php

namespace App\Console\Commands;

use App\Models\SeoCity;
use Illuminate\Console\Command;

class UpdateSeoFreshness extends Command
{
    protected $signature = 'seo:freshness';
    protected $description = 'Automated Google News Freshness Engine - Updates headlines based on real-time events.';

    public function handle()
    {
        $cities = SeoCity::where('is_active', true)->get();

        // Simulated Weather Logic ( could be replaced by a real Weather API)
        $weatherPatterns = [
            'Waspada Musim Hujan: Cek Saluran Pembuangan Anda Sekarang!',
            'Jakarta Masuk Fase Hujan: Promo Anti-Mampet Bergaransi.',
            'Cegah Banjir Lokal: Bersihkan Drainase Luar Rumah.',
            'Layanan Darurat 24 Jam: Siap Hadapi Masalah Pipa di Musim Hujan.'
        ];

        foreach ($cities as $city) {
            /** @var \App\Models\SeoCity $city */
            $headline = $weatherPatterns[array_rand($weatherPatterns)];
            $city->update([
                'fresh_headline' => "Update " . date('d M') . ": " . $headline
            ]);
        }

        $this->info('Google News Freshness Engine: All City Headlines Updated.');
    }
}
