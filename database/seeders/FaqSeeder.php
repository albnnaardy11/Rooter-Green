<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Teknis & Layanan',
                'icon' => 'ri-tools-fill',
                'faqs' => [
                    ['q' => 'Bagaimana cara kerja metode "Tanpa Bongkar"?', 'a' => 'Kami menggunakan mesin drain cleaning dengan kabel spiral fleksibel yang masuk ke dalam pipa. Ujung kabel memiliki mata pisau/pemotong khusus yang berputar untuk menghancurkan lemak, menarik rambut, atau mendorong benda keras penyebab mampet tanpa melukai dinding pipa PVC.'],
                    ['q' => 'Apakah pipa yang sudah tua/getas aman dibersihkan?', 'a' => 'Teknisi kami akan melakukan survey awal terlebih dahulu. Jika pipa dinilai terlalu rapuh atau sudah pecah di dalam tanah, kami akan menginformasikan risikonya. Namun secara umum, putaran mesin kami didesain aman untuk pipa standar industri.'],
                    ['q' => 'Jenis pipa apa saja yang bisa ditangani?', 'a' => 'Kami menangani pipa pembuangan (air kotor), wastafel, bak kontrol, saluran air hujan (floor drain), hingga pipa limbah lemak (grease trap) di dapur komersial.'],
                    ['q' => 'Berapa lama waktu yang dibutuhkan untuk pengerjaan standar?', 'a' => 'Untuk satu titik mampet dengan tingkat kesulitan normal, biasanya memakan waktu 1-2 jam pengerjaan.'],
                    ['q' => 'Apakah metode ini menggunakan bahan kimia berbahaya?', 'a' => 'Tidak. Kami menggunakan sistem mekanik murni (kabel spiral) yang jauh lebih aman bagi kesehatan manusia dan keutuhan pipa dibandingkan cairan asam/kimia keras.'],
                    ['q' => 'Apakah teknisi membawa semua perlengkapan sendiri?', 'a' => 'Ya, tim kami datang lengkap dengan mesin, genset (jika diperlukan), dan alat kebersihan pendukung lainnya.'],
                    ['q' => 'Apakah RooterIn melayani jasa sedot tinja atau hanya mampet?', 'a' => 'Fokus utama kami adalah perbaikan saluran mampet dan pembersihan pipa. Namun, kami bekerja sama dengan mitra terpercaya jika Anda membutuhkan layanan sedot septic tank secara bersamaan.'],
                    ['q' => 'Apa perbedaan mesin Rooter dengan alat tembak angin biasa?', 'a' => 'Alat tembak angin hanya memberikan tekanan sesaat, sementara mesin Rooter kami mengikis habis kerak lemak dan kotoran di dinding pipa hingga bersih total kembali ke diameter semula.'],
                    ['q' => 'Berapa lama estimasi waktu kedatangan teknisi setelah pemesanan?', 'a' => 'Untuk jadwal darurat, kami mengusahakan teknisi sampai di lokasi dalam waktu 1-3 jam setelah konfirmasi (tergantung antrean dan kondisi lalu lintas).'],
                    ['q' => 'Apakah ada suara bising yang mengganggu saat pengerjaan?', 'a' => 'Mesin Rooter kami menggunakan motor listrik yang suaranya relatif halus, kurang lebih setara dengan suara mesin cuci, sehingga tidak akan mengganggu tetangga atau kenyamanan rumah.']
                ]
            ],
            [
                'name' => 'Harga & Pembayaran',
                'icon' => 'ri-price-tag-3-fill',
                'faqs' => [
                    ['q' => 'Bagaimana sistem penentuan harganya?', 'a' => 'Harga kami bersifat transparan. Biasanya ditentukan berdasarkan jumlah titik mampet dan tingkat kesulitan. Untuk pengerjaan skala besar/gedung, kami menggunakan hitungan per meter atau paket borongan tuntas.'],
                    ['q' => 'Apakah ada biaya jika survey dilakukan tapi pengerjaan batal?', 'a' => 'Untuk wilayah tertentu di area cakupan utama, survey awal adalah GRATIS. Jika ada biaya kunjungan untuk area jauh, akan kami informasikan di awal melalui WhatsApp.'],
                    ['q' => 'Metode pembayaran apa saja yang tersedia?', 'a' => 'Kami menerima Pembayaran Tunai (Cash), Transfer Bank, dan untuk klien korporat/bisnis bisa menggunakan sistem Invoice dengan termin yang disepakati.'],
                    ['q' => 'Apakah harga sudah termasuk biaya transport?', 'a' => 'Ya, untuk wilayah dalam cakupan utama (Jabodetabek, Bandung, Lampung), harga yang diberikan sudah termasuk biaya operasional tim.'],
                    ['q' => 'Apakah ada perbedaan biaya antar hari libur dan hari kerja?', 'a' => 'Harga kami tetap standar dan kompetitif baik di hari kerja maupun hari libur (Sabtu/Minggu) untuk layanan darurat.'],
                    ['q' => 'Apakah ada paket khusus untuk langganan rutin?', 'a' => 'Ada. Kami menawarkan paket kontrak maintenance untuk kustomer komersial dengan harga yang jauh lebih hemat dibanding pengerjaan per-panggilan.'],
                    ['q' => 'Apakah ada biaya tersembunyi seperti biaya alat atau bahan?', 'a' => 'Tidak ada. Harga yang disepakati di awal sudah mencakup penggunaan mesin, tenaga ahli, dan jaminan pengerjaan sampai tuntas.'],
                    ['q' => 'Bagaimana jika pengerjaan memakan waktu lebih lama dari estimasi?', 'a' => 'Biaya tetap sesuai kesepakatan awal meskipun pengerjaan memakan waktu lebih lama karena kerumitan di lapangan. Kami tidak menerapkan biaya per jam.'],
                    ['q' => 'Bagaimana saya mendapatkan informasi promo atau potongan harga?', 'a' => 'Anda bisa mengikuti akun Instagram kami atau bertanya langsung kepada admin WhatsApp saat melakukan konsultasi untuk mengetahui promo yang sedang berlangsung.'],
                    ['q' => 'Apakah ada diskon jika mengerjakan lebih dari 3 titik sekaligus?', 'a' => 'Tentu. Kami memberikan diskon volume bagi kustomer yang melakukan pengerjaan lebih dari 3 titik mampet dalam satu kali kunjungan.']
                ]
            ],
            [
                'name' => 'Garansi & Klaim',
                'icon' => 'ri-shield-check-fill',
                'faqs' => [
                    ['q' => 'Apa saja syarat untuk klaim garansi 7 hari?', 'a' => 'Cukup tunjukkan bukti nota pengerjaan atau riwayat chat WhatsApp. Garansi berlaku jika saluran mampet kembali pada titik yang sama dengan penyebab yang sama (misal: endapan lemak lama yang belum tuntas).'],
                    ['q' => 'Apa yang tidak ditanggung oleh garansi?', 'a' => 'Garansi gugur jika ditemukan benda asing "baru" yang masuk setelah teknisi selesai bekerja (misal: kain/mainan yang baru jatuh ke lubang pipa) atau jika terjadi kerusakan struktur tanah yang menyebabkan pipa patah.'],
                    ['q' => 'Berapa kali batas maksimal klaim garansi?', 'a' => 'Kami akan datang sampai masalah tuntas selama masih dalam masa garansi dan bukan disebabkan oleh sumbatan baru.'],
                    ['q' => 'Apakah garansi mencakup seluruh pipa di rumah?', 'a' => 'Garansi hanya mencakup titik/jalur pipa yang dikerjakan oleh teknisi kami sesuai dengan yang tertera di nota.'],
                    ['q' => 'Kapan masa garansi mulai dihitung?', 'a' => 'Masa garansi 7 hari dihitung tepat sejak pengerjaan dinyatakan selesai dan serah terima dilakukan kepada kustomer.'],
                    ['q' => 'Bagaimana cara cepat untuk klaim garansi?', 'a' => 'Anda bisa langsung menghubungi nomor WhatsApp admin kami dengan mengirimkan foto nota atau bukti transfer pengerjaan sebelumnya.'],
                    ['q' => 'Apakah garansi berlaku jika saya mencoba memperbaiki sendiri setelah teknisi pergi?', 'a' => 'Kami menyarankan untuk tidak memasukkan alat atau bahan kimia lain selama masa garansi agar kami bisa menganalisa penyebab mampet kembali secara akurat.'],
                    ['q' => 'Apakah biaya transportasi tetap gratis saat klaim garansi?', 'a' => 'Ya, kunjungan untuk klaim garansi di wilayah cakupan kami sepenuhnya gratis tanpa biaya transport tambahan.'],
                    ['q' => 'Berapa lama respon tim teknis untuk jadwal kunjungan garansi?', 'a' => 'Klaim garansi kami prioritaskan dan biasanya dijadwalkan dalam waktu maksimal 24 jam setelah laporan diterima.'],
                    ['q' => 'Apakah garansi 7 hari bisa diperpanjang?', 'a' => 'Untuk kustomer komersial (pabrik/restoran), kami memiliki kebijakan perpanjangan garansi khusus yang bisa dinegosiasikan sesuai kontrak.']
                ]
            ],
            [
                'name' => 'Bisnis & Gedung',
                'icon' => 'ri-hotel-fill',
                'faqs' => [
                    ['q' => 'Apakah RooterIn memiliki legalitas resmi untuk vendor perusahaan?', 'a' => 'Ya, kami berada di bawah naungan perusahaan resmi yang dapat mengeluarkan Invoice dan Faktur Pajak jika diperlukan untuk kebutuhan administrasi perusahaan atau pengelola gedung.'],
                    ['q' => 'Apakah tersedia layanan maintenance rutin?', 'a' => 'Tersedia. Kami memiliki program "Preventive Maintenance" bulanan atau per 3 bulan untuk Restoran, Hotel, dan Pabrik guna mencegah terjadinya mampet total yang bisa mengganggu operasional bisnis.'],
                    ['q' => 'Apakah sanggup mengerjakan pipa dengan diameter besar?', 'a' => 'Sanggup. Kami memiliki mesin Rooter industri yang mampu membersihkan pipa berdiameter besar yang biasa ditemukan di gedung bertingkat atau area publik.'],
                    ['q' => 'Dapatkah RooterIn bekerja di luar jam operasional bisnis?', 'a' => 'Bisa. Kami melayani pengerjaan malam hari (after hours) untuk restoran atau kantor agar tidak mengganggu jalannya bisnis Anda.'],
                    ['q' => 'Apakah ada laporan pengerjaan tertulis (Berita Acara)?', 'a' => 'Ya, untuk setiap pengerjaan komersial, kami menyediakan Berita Acara Pengerjaan dan dokumentasi sebelum/sesudah pengerjaan jika diminta.'],
                    ['q' => 'Apakah melayani survei teknis untuk tender proyek?', 'a' => 'Kami terbuka untuk survei teknis dan memberikan penawaran harga (Quotation) untuk pengadaan jasa vendor tahunan.'],
                    ['q' => 'Apakah teknisi memiliki APD lengkap untuk standar safety K3 di pabrik?', 'a' => 'Ya, teknisi kami dibekali dengan Alat Pelindung Diri (APD) standar seperti helm, rompi, sepatu safety, dan sarung tangan untuk memenuhi protokol keamanan area industri.'],
                    ['q' => 'Apakah tersedia kerja sama sistem kontrak tahunan dengan harga flat?', 'a' => 'Kami menyediakan opsi kontrak Fixed Rate tahunan bagi pengelola gedung yang ingin menjaga anggaran perbaikan tetap stabil sepanjang tahun.'],
                    ['q' => 'Apakah RooterIn melayani pengerjaan di area industri/pabrik luar kota?', 'a' => 'Ya, kami melayani proyek skala industri di seluruh wilayah Jawa dan sebagian Sumatera untuk kebutuhan pembersihan sistem plumbing pabrik.'],
                    ['q' => 'Apakah tersedia tim teknis yang standby 24 jam untuk gedung?', 'a' => 'Kami menyediakan layanan On-Call 24 Jam khusus untuk pengelola gedung yang memiliki kontrak kerjasama eksklusif dengan kami.']
                ]
            ]
        ];

        foreach ($data as $catData) {
            $category = FaqCategory::create([
                'name' => $catData['name'],
                'slug' => Str::slug($catData['name']),
                'icon' => $catData['icon']
            ]);

            foreach ($catData['faqs'] as $index => $faqItem) {
                Faq::create([
                    'faq_category_id' => $category->id,
                    'question' => $faqItem['q'],
                    'answer' => $faqItem['a'],
                    'placement' => 'about', // Default from complex faq is about
                    'order' => $index
                ]);
            }
        }

        // Add some for landing page if needed specifically, 
        // but user asked to separate. Usually landing faqs are simpler.
        // I'll add a few generic ones for landing specifically
        $landingCategory = FaqCategory::create([
            'name' => 'Umum (Landing)',
            'slug' => 'umum-landing',
            'icon' => 'ri-question-fill'
        ]);

        Faq::create([
            'faq_category_id' => $landingCategory->id,
            'question' => 'Berapa biaya perbaikan mampet?',
            'answer' => 'Harga mulai dari Rp 300.000,- tergantung tingkat kesulitan dan lokasi.',
            'placement' => 'landing',
            'order' => 0
        ]);

        Faq::create([
            'faq_category_id' => $landingCategory->id,
            'question' => 'Apakah pengerjaan bergaransi?',
            'answer' => 'Ya, kami memberikan garansi 7 hari setelah pengerjaan selesai.',
            'placement' => 'landing',
            'order' => 2
        ]);
        
        Faq::create([
            'faq_category_id' => $landingCategory->id,
            'question' => 'Area mana saja yang dilayani?',
            'answer' => 'Saat ini kami melayani Jabodetabek, Bandung, dan Lampung.',
            'placement' => 'landing',
            'order' => 1
        ]);
    }
}
