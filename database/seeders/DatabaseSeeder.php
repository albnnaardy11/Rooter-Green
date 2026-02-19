<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin RooterIn',
            'email' => 'admin@rooterin.com',
            'password' => bcrypt('password'),
        ]);

        // --- Settings Seeder ---
        $settings = [
            ['key' => 'site_name', 'value' => 'RooterIn', 'group' => 'general'],
            ['key' => 'whatsapp_number', 'value' => '6281246668749', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'hello@rooterin.com', 'group' => 'contact'],
            ['key' => 'address', 'value' => 'Denpasar, Bali', 'group' => 'contact'],
            ['key' => 'instagram', 'value' => 'https://instagram.com/rooterin', 'group' => 'social'],
            ['key' => 'facebook', 'value' => 'https://facebook.com/rooterin', 'group' => 'social'],
            ['key' => 'tiktok', 'value' => 'https://tiktok.com/@rooterin', 'group' => 'social'],
        ];
        foreach ($settings as $setting) {
            \App\Models\Setting::create($setting);
        }

        // --- Posts Seeder ---
        $posts = [
            [
                'title' => 'Cara Darurat Atasi Wastafel Mampet Tanpa Bongkar',
                'slug' => 'cara-darurat-atasi-wastafel-mampet-tanpa-bongkar',
                'category' => 'Dapur',
                'content' => 'Wastafel mampet di tengah malam? Jangan panik. Berikut adalah panduan langkah demi langkah menggunakan bahan rumahan sebelum memanggil teknisi profesional.',
                'featured_image' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=1200&q=80',
                'author' => 'RooterIn Expert',
                'status' => 'published',
            ],
            [
                'title' => '5 Tanda Pipa Pembuangan Anda Mulai Berkerak',
                'slug' => '5-tanda-pipa-pembuangan-anda-mulai-berkerak',
                'category' => 'Tips Hemat',
                'content' => 'Kenali tanda-tanda awal sebelum pipa benar-benar mampet total dan merusak lantai Anda.',
                'featured_image' => 'https://images.unsplash.com/photo-1585955123058-930415956a69?w=800&q=80',
                'author' => 'RooterIn Expert',
                'status' => 'published',
            ],
            [
                'title' => 'Mengapa Grease Trap Penting Untuk Restoran?',
                'slug' => 'mengapa-grease-trap-penting-untuk-restoran',
                'category' => 'Pipa Industri',
                'content' => 'Untuk pemilik bisnis kuliner, menjaga aliran pipa adalah kunci kelancaran operasional harian.',
                'featured_image' => 'https://images.unsplash.com/photo-1521207418485-99c705420785?w=800&q=80',
                'author' => 'RooterIn Expert',
                'status' => 'published',
            ],
            [
                'title' => 'Bahaya Menggunakan Soda Api Pada Pipa PVC',
                'slug' => 'bahaya-menggunakan-soda-api-pada-pipa-pvc',
                'category' => 'Kamar Mandi',
                'content' => 'Banyak yang mengira soda api adalah solusi, padahal bisa berakibat fatal bagi pipa plastik.',
                'featured_image' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&q=80',
                'author' => 'RooterIn Expert',
                'status' => 'published',
            ],
        ];
        foreach ($posts as $post) {
            \App\Models\Post::create($post);
        }

        // --- Services Seeder ---
        $services = [
            [
                'name' => 'Saluran Pembuangan Mampet',
                'slug' => 'saluran-pembuangan-mampet',
                'icon' => 'ri-water-flash-fill',
                'description_short' => 'Solusi tuntas WC & pipa mampet dengan mesin Spiral Baja.',
                'description_full' => 'Menghancurkan sumbatan kerak lemak tanpa merusak konstruksi menggunakan teknologi modern tanpa bongkar.',
                'price' => 600000,
                'items' => ['Sal. Kamar Mandi', 'Sal. Cuci Piring', 'Sal. Cuci Tangan', 'Sal. Talang Air Hujan', 'Sal. Urinoir', 'Sal. Kloset', 'Sal. Bak Kontrol', 'Lain-lain'],
                'pricing' => [
                    ['type' => 'Rumah Hunian', 'price' => 'Rp. 600.000,-', 'note' => 'Per-titik Masalah, Garansi 30 Hari'],
                    ['type' => 'Komersial (Resto, Kantor, dll)', 'price' => 'Rp. 800.000 - 1.800.000', 'note' => 'Per-titik Masalah, Garansi 30 Hari']
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Air Bersih & Cuci Toren',
                'slug' => 'air-bersih-cuci-toren',
                'icon' => 'ri-drop-fill',
                'description_short' => 'Normalisasi kran mampet & cuci tangki air.',
                'description_full' => 'Teknik sterilisasi pipa untuk menjamin aliran air bersih yang sehat & lancar serta bebas lumut.',
                'price' => 200000,
                'items' => ['Kran Mampet', 'Cuci Toren / Tangki Air'],
                'pricing' => [
                    ['type' => 'Survey Lokasi', 'price' => 'Gratis', 'note' => 'Biaya ditentukan setelah survey lokasi']
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Instalasi Sanitary & Pipa',
                'slug' => 'instalasi-sanitary-pipa',
                'icon' => 'ri-tools-fill',
                'description_short' => 'Pemasangan kran, kloset, & jalur pipa baru.',
                'description_full' => 'Dikerjakan dengan standar profesional untuk hasil rapi, kuat, & permanen menggunakan teknik presisi tinggi.',
                'price' => 0,
                'items' => ['Instalasi Pipa Air Bersih', 'Instalasi Pipa Air Kotor', 'Instalasi Kloset Jongkok/Duduk', 'Instalasi Sanitary', 'Instalasi Kran Air', 'Lain-lain'],
                'pricing' => [
                    ['type' => 'Project Based', 'price' => 'Custom Quote', 'note' => 'Berdasarkan volume pengerjaan & material']
                ],
                'is_active' => true,
            ],
        ];
        foreach ($services as $service) {
            \App\Models\Service::create($service);
        }

        // --- Projects Seeder ---
        $projects = [
            ['img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=800&fit=crop', 'title' => 'Pipa Dapur Mampet', 'category' => 'Residential', 'location' => 'Denpasar'],
            ['img' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&fit=crop', 'title' => 'Saluran Air Kamar Mandi', 'category' => 'Residential', 'location' => 'Badung'],
            ['img' => 'https://images.unsplash.com/photo-1521207418485-99c705420785?w=800&fit=crop', 'title' => 'Wastafel Kantor', 'category' => 'Commercial', 'location' => 'Jimbaran'],
            ['img' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800&fit=crop', 'title' => 'Pengerjaan Rooter Spiral', 'category' => 'Commercial', 'location' => 'Kuta'],
            ['img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&fit=crop', 'title' => 'Pipa Mampet Gedung', 'category' => 'Commercial', 'location' => 'Ubud'],
            ['img' => 'https://images.unsplash.com/photo-1531973576160-7125cd663d86?w=800&fit=crop', 'title' => 'Kerja Tim Profesional', 'category' => 'Residential', 'location' => 'Sanur'],
        ];
        foreach ($projects as $project) {
            \App\Models\Project::create([
                'title' => $project['title'],
                'category' => $project['category'],
                'location' => $project['location'],
                'images' => json_encode([$project['img']]),
            ]);
        }

        // --- Testimonials Seeder ---
        $testimonials = [
            ['name' => 'Bpk. Ahmad', 'photo' => 'https://i.pravatar.cc/150?u=ahmad', 'rating' => 5, 'content' => 'Layanan sangat cepat dan pipa wastafel kembali lancar tanpa dibongkar!'],
            ['name' => 'Ibu Maria', 'photo' => 'https://i.pravatar.cc/150?u=maria', 'rating' => 5, 'content' => 'Teknisinya ramah dan kerjanya sangat rapi. Sangat merekomendasikan RooterIn.'],
        ];
        foreach ($testimonials as $testimonial) {
            \App\Models\Testimonial::create($testimonial);
        }
    }
}
