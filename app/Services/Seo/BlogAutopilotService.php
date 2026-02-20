<?php

namespace App\Services\Seo;

use App\Models\Post;
use App\Models\SeoCity;
use Illuminate\Support\Str;

class BlogAutopilotService
{
    /**
     * "Neural Journalist": Generates a blog post based on current site signals.
     */
    public function execute()
    {
        // 1. Pick a random active city for local context
        $city = SeoCity::where('is_active', true)->inRandomOrder()->first();
        $cityName = $city ? $city->name : 'Indonesia';

        // 2. Determine "Freshness Signal" (e.g. Weather or Season)
        $scenarios = [
            'Hujan' => [
                'title' => "Waspada Saluran Mampet di {$cityName} Saat Musim Hujan: Tips Cegah Banjir di Rumah.",
                'content' => "Musim hujan telah tiba di {$cityName}. Tim RooterIn mencatat kenaikan kasus pipa mampet akibat sampah yang terbawa arus air hujan. Dalam artikel ini, kami merangkum 5 langkah pencegahan..."
            ],
            'Dapur' => [
                'title' => "Rahasia Dapur {$cityName} Tanpa Bau: Cara Membersihkan Pipa Wastafel dari Lemak Membeku.",
                'content' => "Pernahkah Anda mencium bau tak sedap dari wastafel? Bagi warga {$cityName}, lemak masakan seringkali membeku di dalam pipa karena suhu air. RooterIn memberikan solusi hemat biaya..."
            ],
            'Inovasi' => [
                'title' => "Teknologi Terbaru RooterIn di {$cityName}: Membersihkan Pipa Tanpa Bongkar Lantai Sama Sekali.",
                'content' => "Terobosan baru untuk masyarakat {$cityName}. Kami sekarang menggunakan kamera inspeksi dan mesin spiral berkekuatan tinggi untuk memastikan pipa Anda bersih seperti baru."
            ]
        ];

        $scenario = $scenarios[array_rand($scenarios)];

        // 3. Create the Post
        $post = Post::create([
            'title' => $scenario['title'],
            'slug' => Str::slug($scenario['title'] . '-' . uniqid()),
            'content' => $scenario['content'] . "\n\nHubungi RooterIn {$cityName} segera jika Anda membutuhkan bantuan profesional.",
            'excerpt' => Str::limit($scenario['content'], 150),
            'status' => 'published',
            'published_at' => now(),
            'is_featured' => true,
        ]);

        return $post;
    }
}
