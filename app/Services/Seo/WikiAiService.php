<?php

namespace App\Services\Seo;

class WikiAiService
{
    /**
     * "Neural Automator": Automatically generates technical descriptions and attributes.
     */
    public function generate(string $name)
    {
        $nameLower = strtolower($name);
        
        // Knowledge Base for AI Simulation (150+ Technical Keywords)
        $kb = [
            // PIPING MATERIALS
            'pvc' => [
                'desc' => 'Polimer termoplastik yang tahan korosi dan ringan, umum digunakan untuk sistem drainase limbah domestik.',
                'attrs' => ['Standar' => 'SNI 06-0084', 'Durabilitas' => '50+ Tahun', 'Tipe' => 'Termoplastik']
            ],
            'hdpe' => [
                'desc' => 'High Density Polyethylene, pipa PE-100 yang fleksibel dan tahan benturan, sering digunakan untuk distribusi air bersih tekanan tinggi.',
                'attrs' => ['Fleksibilitas' => 'Tinggi', 'Ketahanan_Kimia' => 'Luar Biasa', 'Penyambungan' => 'Butt Fusion / Electrofusion']
            ],
            'ppr' => [
                'desc' => 'Polypropylene Random, pipa khusus untuk air panas dan dingin bertekanan dengan sistem penyambungan pemanasan (Heat Fusion).',
                'attrs' => ['Suhu_Maks' => '95 Derajat Celcius', 'Sistem' => 'PN-10 / PN-20', 'Higiene' => 'Food Grade']
            ],
            'pex' => [
                'desc' => 'Cross-linked Polyethylene, pipa fleksibel yang tahan suhu ekstrem, sering digunakan untuk sistem pemanas lantai dan distribusi air rumah tangga.',
                'attrs' => ['Radius_Tekuk' => 'Lentur', 'Ketahanan' => 'Anti-Karat', 'Instalasi' => 'Fast-Fit']
            ],
            'galvanis' => [
                'desc' => 'Pipa besi yang dilapisi lapisan seng (zinc) untuk mencegah karat, biasanya digunakan pada instalasi air bersih bangunan lama.',
                'attrs' => ['Material' => 'Zinc-Coated Steel', 'Kekuatan' => 'Tinggi', 'Kelemahan' => 'Scaling setelah 15 tahun']
            ],
            'tembaga' => [
                'desc' => 'Pipa logam dengan konduktivitas panas tinggi, tahan terhadap pertumbuhan bakteri, umum digunakan untuk jalur AC dan gas.',
                'attrs' => ['Material' => 'Copper', 'Antibakteri' => 'Alami', 'Aplikasi' => 'Medical & AC']
            ],
            'besi cor' => [
                'desc' => 'Cast Iron, pipa berat yang tahan api dan memiliki tingkat peredaman suara tinggi, ideal untuk instalasi gedung bertingkat.',
                'attrs' => ['Fitur' => 'Sound-Proofing', 'Standar' => 'ASTM A888', 'Ketahanan' => 'Heavy Duty']
            ],
            'stainless steel' => [
                'desc' => 'Pipa baja tahan karat yang sangat higienis, digunakan dalam industri makanan, farmasi, dan instalasi air mewah.',
                'attrs' => ['Grade' => 'SS304 / SS316', 'Visual' => 'Premium Look', 'Higiene' => 'Steril']
            ],
            'u-pvc' => [
                'desc' => 'Unplasticized Polyvinyl Chloride, versi kaku dari PVC yang lebih kuat dan tahan tekanan, sering untuk jalur distribusi kota.',
                'attrs' => ['Kekakuan' => 'Maksimal', 'UV_Resistance' => 'Moderate', 'Aplikasi' => 'Industrial']
            ],
            'cpvc' => [
                'desc' => 'Chlorinated Polyvinyl Chloride, modifikasi PVC yang tahan terhadap suhu lebih tinggi hingga 90 derajat celcius.',
                'attrs' => ['Suhu_Kerja' => 'Tinggi', 'Ketahanan_API' => 'Self-Extinguishing', 'Tipe' => 'Industrial Grade']
            ],

            // TOOLS & EQUIPMENT
            'spiral' => [
                'desc' => 'Alat mekanis dengan kabel baja fleksibel yang mampu menembus hambatan padat dalam pipa tanpa proses pembongkaran.',
                'attrs' => ['Material' => 'High Carbon Steel', 'Jangkauan' => '30 Meter', 'Power' => 'Electric High-Torque']
            ],
            'jetting' => [
                'desc' => 'Sistem pembersihan pipa menggunakan tekanan air ekstrem untuk merontokkan kerak lemak yang membeku di dinding saluran.',
                'attrs' => ['Tekanan' => '200-500 Bar', 'Flow' => 'High Pressure', 'Fungsi' => 'Hydro Jetting']
            ],
            'kamera pipa' => [
                'desc' => 'Alat inspeksi visual (Endoscope/Borescope) untuk melihat kondisi bagian dalam pipa secara real-time guna menemukan titik kerusakan atau sumbatan.',
                'attrs' => ['Resolusi' => 'Full HD', 'Fitur' => 'Recording & Snapshot', 'Jangkauan' => '20 - 60 Meter']
            ],
            'drain cleaner' => [
                'desc' => 'Mesin pembersih saluran yang variatif, mulai dari hand-tool hingga mesin generator bertenaga besar untuk sumbatan berat.',
                'attrs' => ['Tipe' => 'Hand / Electric', 'Sektor' => 'Domestic & Industrial', 'Blade' => 'Interchangeable']
            ],
            'kunci pipa' => [
                'desc' => 'Pipe Wrench, alat berat untuk mencengkeram dan memutar pipa besi atau fitting dengan rahang bergerigi tajam.',
                'attrs' => ['Size' => '10 - 48 Inch', 'Rahang' => 'Hardened Steel', 'Adjustable' => 'Yes']
            ],
            'flaring tool' => [
                'desc' => 'Alat untuk melebarkan ujung pipa tembaga agar bisa disambungkan dengan fitting sistem flare (tekan).',
                'attrs' => ['Akurasi' => 'Presisi', 'Material' => 'Chromed Steel', 'Tujuan' => 'Leak-Free Joint']
            ],
            'welding machine' => [
                'desc' => 'Mesin las HDPE atau PPR yang menggunakan panas untuk melelehkan dua ujung pipa agar menyatu secara permanen.',
                'attrs' => ['Kontrol' => 'Digital Temperature', 'Plat' => 'Teflon Coated', 'Kecepatan' => 'Real-time Heating']
            ],
            'pressure test' => [
                'desc' => 'Alat pompa manual atau elektrik untuk menguji kebocoran pada instalasi pipa baru dengan tekanan udara atau air.',
                'attrs' => ['Indikator' => 'Manometer', 'Maks_Tekanan' => '60 Bar', 'Fungsi' => 'Quality Control']
            ],
            'pipe cutter' => [
                'desc' => 'Alat pemotong pipa yang memberikan hasil potongan tegak lurus dan bersih tanpa meninggalkan bram (serpihan).',
                'attrs' => ['Wheel' => 'Circular Blade', 'Material' => 'Aluminum Case', 'Cleanliness' => 'Burr-Free']
            ],
            'hand auger' => [
                'desc' => 'Versi manual dari mesin spiral, digunakan untuk masalah sumbatan ringan pada wastafel atau floor drain kamar mandi.',
                'attrs' => ['Manual' => 'Crank Handle', 'Aplikasi' => 'Rumah Tangga', 'Panjang' => '3 - 7 Meter']
            ],

            // SANITARY FIXTURES
            'wastafel' => [
                'desc' => 'Titik buang air kotor yang sering mengalami penyumbatan akibat akumulasi sisa makanan dan lemak sabun.',
                'attrs' => ['Diameter_Ideal' => '1.5 - 2 Inchi', 'Material' => 'Keramik / Stainless', 'Penyebab_Mampet' => 'Lemak & Rambut']
            ],
            'closet' => [
                'desc' => 'Perangkat sanitasi utama untuk pembuangan tinja, memiliki sistem flush dan trap untuk menahan bau dari septic tank.',
                'attrs' => ['Tipe' => 'Duduk / Jongkok', 'Sistem' => 'Siphonic / Washdown', 'Water_Usage' => 'Dual Flush']
            ],
            'urinal' => [
                'desc' => 'Tempat buang air kecil khusus pria yang efisien dalam penggunaan air, sering menggunakan sensor otomatis.',
                'attrs' => ['Fitur' => 'Auto-Flush', 'Instalasi' => 'Wall-Hung', 'Maintenance' => 'Cek Kerak Urine']
            ],
            'bidet' => [
                'desc' => 'Alat pembersih setelah buang air besar yang menyatu dengan closet (ecowasher) atau berdiri sendiri.',
                'attrs' => ['Higiene' => 'Sangat Tinggi', 'Tekanan' => 'Soft Flow', 'Tipe' => 'Electronic / Manual']
            ],
            'floor drain' => [
                'desc' => 'Saringan saluran air di lantai kamar mandi yang dilengkapi penutup otomatis atau jebakan air untuk mencegah kecoa dan bau.',
                'attrs' => ['Fitur' => 'Anti-Bau / Anti-Serangga', 'Material' => 'Brass / Stainless Steel', 'Desain' => 'Elegant Slot']
            ],
            'bathtub' => [
                'desc' => 'Wadah mandi besar yang memerlukan instalasi pembuangan khusus (overflow) dan keran pengisi volume besar.',
                'attrs' => ['Material' => 'Acrylic / Marble', 'Sistem' => 'Pop-up Waste', 'Drainase' => 'Self-Draining']
            ],
            'kitchen sink' => [
                'desc' => 'Bak cuci piring dapur yang paling rentan terhadap penumpukan lemak beku di saluran pembuangannya.',
                'attrs' => ['Depth' => 'Deep Bowl', 'Noise' => 'Sound Deadening Pad', 'Accessories' => 'Drain Basket']
            ],
            'shower' => [
                'desc' => 'Sistem pemandian dengan pancuran air yang memerlukan tekanan stabil untuk kenyamanan maksimal.',
                'attrs' => ['Head' => 'Rain Shower / Hand Shower', 'Nozzle' => 'Easy-Clean Silicon', 'Valve' => 'Mixer Hot/Cold']
            ],
            'kran air' => [
                'desc' => 'Faucet, titik akhir distribusi air yang mengontrol laju aliran, tersedia dalam berbagai desain estetika.',
                'attrs' => ['Cartridge' => 'Ceramic Disc', 'Material' => 'Solid Brass', 'Aerator' => 'Honeycomb Water Saving']
            ],
            'water heater' => [
                'desc' => 'Pemanas air yang menggunakan listrik, gas, atau tenaga surya untuk menyediakan air hangat instan.',
                'attrs' => ['Energy' => 'Gas / Electric / Solar', 'Safety' => 'ELCB / Thermostat', 'Tank' => 'Glass-Lined']
            ],

            // INFRASTRUCTURE
            'septic tank' => [
                'desc' => 'Unit pengolahan limbah domestik kedap air yang berfungsi mengolah limbah tinja melalui proses dekomposisi anaerobik.',
                'attrs' => ['Material' => 'Beton / Fiberglass', 'Proses' => 'Anaerobik Digestion', 'Output' => 'Effluent']
            ],
            'grease trap' => [
                'desc' => 'Alat penyaring yang dirancang untuk menangkap lemak, minyak, dan lemak (FOG) agar tidak masuk ke sistem saluran pembuangan utama.',
                'attrs' => ['Material' => 'Stainless Steel / PVC', 'Fungsi' => 'FOG Reduction', 'Maintenance' => 'Pembersihan Berkala']
            ],
            'toren' => [
                'desc' => 'Tangki penyimpanan air di atas bangunan untuk menjaga ketersediaan air dan mengatur tekanan air secara gravitasi ke seluruh instalasi.',
                'attrs' => ['Kapasitas' => '500L - 5000L', 'Lapisan' => 'Anti-Lumut & UV Protection', 'Material' => 'MDPE / Stainless']
            ],
            'bak kontrol' => [
                'desc' => 'Check Chamber, titik akses pada sistem drainase untuk melakukan pengecekan, pembersihan, dan pemeliharaan saluran.',
                'attrs' => ['Ukuran' => 'Standar 40x40 - 60x60', 'Fitur' => 'Removable Cover', 'Lokasi' => 'Setiap Belokan Saluran']
            ],
            'manhole' => [
                'desc' => 'Lubang masuk berukuran manusia untuk akses ke sistem gorong-gorong atau pipa induk perkotaan di bawah jalan.',
                'attrs' => ['Cover' => 'Heavy Duty Ductile Iron', 'Diameter' => '600mm - 800mm', 'Load_Class' => 'D400 (30-40 Ton)']
            ],
            'sumur resapan' => [
                'desc' => 'Sistem infiltrasi air hujan atau air limbah yang sudah diolah ke dalam tanah untuk menjaga cadangan air tanah.',
                'attrs' => ['Kedalaman' => '3 - 10 Meter', 'Material' => 'Pipa Berlubang / Kerikil', 'Tujuan' => 'Eco-Friendly Drainage']
            ],
            'bio septic' => [
                'desc' => 'Septic tank modern yang menggunakan media filter bakteri untuk memproses limbah menjadi cairan yang lebih aman dibuang langsung.',
                'attrs' => ['Media' => 'Bioball / Honeycomb', 'Efisiensi' => '90% BOD Removal', 'Ramah_Lingkungan' => 'Sangat Baik']
            ],
            'pipa induk' => [
                'desc' => 'Main Line, jalur pipa utama berdiameter besar yang mendistribusikan air dari pusat ke berbagai cabang bangunan.',
                'attrs' => ['Diameter' => '4 - 24 Inch', 'Tekanan' => 'High Pressure', 'Maintenance' => 'Hydrant Access']
            ],
            'vent stack' => [
                'desc' => 'Pipa vertikal yang terbuka ke udara untuk mengatur tekanan dalam pipa dan mencegah hilangnya air pada P-Trap.',
                'attrs' => ['Fungsi' => 'Air Balancing', 'Lokasi' => 'Atap Bangunan', 'Prinsip' => 'Atmospheric Pressure']
            ],
            'gorong-gorong' => [
                'desc' => 'Culvert, saluran air besar yang melintasi bawah jalan atau jembatan untuk mengalirkan air hujan skala kota.',
                'attrs' => ['Bentuk' => 'Kotak / Lingkaran', 'Material' => 'Precast Concrete', 'Kapasitas' => 'Sangat Besar']
            ],

            // PLUMBING PROBLEMS
            'mampet' => [
                'desc' => 'Kondisi tersumbatnya aliran air akibat akumulasi kotoran padat, lemak, atau benda asing di dalam jalur pipa.',
                'attrs' => ['Penyebab' => 'Lemak / Rambut / Tisu', 'Solusi' => 'Spiral Machine', 'Tingkat' => 'Ringan - Berat']
            ],
            'bocor' => [
                'desc' => 'Rematun air keluar dari sambungan pipa atau dinding pipa yang pecah, mengakibatkan pemborosan dan kerusakan struktur.',
                'attrs' => ['Indikasi' => 'Tagihan Air Naik', 'Deteksi' => 'Pressure Test', 'Perbaikan' => 'Fitting Replacement']
            ],
            'scaling' => [
                'desc' => 'Penumpukan kerak kapur atau mineral di dalam pipa, biasanya terjadi pada pipa logam akibat air tanah dengan kesadahan tinggi.',
                'attrs' => ['Efek' => 'Diameter Mengecil', 'Penyebab' => 'Hard Water', 'Solusi' => 'Chemical Cleaning / Jetting']
            ],
            'korosi' => [
                'desc' => 'Proses pengkaratan pada pipa logam akibat reaksi kimia dengan oksigen dan air, yang lama kelamaan membuat pipa berlubang.',
                'attrs' => ['Material_Rentan' => 'Besi / Baja', 'Warna' => 'Coklat Karat', 'Penyegahan' => 'Galvanisasi / Coating']
            ],
            'backflow' => [
                'desc' => 'Kondisi di mana air kotor mengalir kembali ke sumber air bersih akibat perbedaan tekanan, sangat berbahaya bagi kesehatan.',
                'attrs' => ['Resiko' => 'Kontaminasi Bakteri', 'Alat_Cegah' => 'Check Valve', 'Penyakit' => 'Diare / Kolera']
            ],
            'water hammer' => [
                'desc' => 'Goncangan keras pada pipa saat keran ditutup mendadak, menghasilkan dentuman yang bisa merusak sambungan pipa.',
                'attrs' => ['Suara' => 'Benturan Logam', 'Efek' => 'Sudden Shock', 'Solusi' => 'Arrestor / Air Chamber']
            ],
            'bau drainase' => [
                'desc' => 'Munculnya aroma tidak sedap dari lubang pembuangan, biasanya akibat P-Trap kering atau kebocoran gas septic tank.',
                'attrs' => ['Penyebab' => 'Seal Rusak', 'Lokasi' => 'KM / Dapur', 'Gas' => 'H2S / Metana']
            ],
            'pipa berisik' => [
                'desc' => 'Suara bising saat air mengalir, seringkali karena pipa tidak dijepit dengan kuat atau tekanan air yang terlalu tinggi (turbulensi).',
                'attrs' => ['Penyebab' => 'Loose Support', 'Level' => 'Moderate', 'Mitigasi' => 'Pipe Clamp / Buffer']
            ],
            'rembes dinding' => [
                'desc' => 'Dinding lembab atau berjamur akibat adanya pipa bocor halus di dalam tembok yang tidak terdeteksi langsung.',
                'attrs' => ['Efek_Samping' => 'Lumut / Jamur', 'Struktur' => 'Kerapuhan Beton', 'Deteksi' => 'Thermal Imaging']
            ],
            'tekanan rendah' => [
                'desc' => 'Aliran air yang keluar sangat kecil, bisa disebabkan oleh penyumbatan di filter kran atau masalah pada pompa booster.',
                'attrs' => ['Lokasi' => 'Kran / Shower', 'Check' => 'Pebersihan Aerator', 'Solusi_Teknis' => 'Pompa Pendorong']
            ],

            // VALVES & PUMPS
            'ball valve' => [
                'desc' => 'Stop kran dengan mekanisme bola berlubang yang bisa dibuka-tutup dengan putaran 90 derajat secara cepat.',
                'attrs' => ['Operation' => 'Quarter-Turn', 'Durabilitas' => 'Tinggi', 'Material' => 'Kuningan / PVC']
            ],
            'gate valve' => [
                'desc' => 'Katup gerbang yang naik-turun perlahan untuk membuka aliran, cocok untuk jalur utama agar tidak terjadi water hammer.',
                'attrs' => ['Sistem' => 'On/Off Slow', 'Resistansi' => 'Rendah', 'Grade' => 'Industrial']
            ],
            'check valve' => [
                'desc' => 'Katup satu arah yang hanya memperbolehkan air mengalir ke satu sisi dan menutup otomatis saat air berbalik.',
                'attrs' => ['Fungsi' => 'Anti-Backflow', 'Tipe' => 'Swing / Spring', 'Aplikasi' => 'Output Pompa']
            ],
            'float valve' => [
                'desc' => 'Klep pelampung yang menutup otomatis saat level air di toren penuh, mencegah air meluber sia-sia.',
                'attrs' => ['Material' => 'Plastic / Brass', 'Sensitivitas' => 'Tinggi', 'Kegunaan' => 'Tandon Air']
            ],
            'pressure reducer' => [
                'desc' => 'Alat untuk menurunkan tekanan air yang terlalu tinggi dari supplier (PDAM) agar tidak merusak instalasi pipa rumah.',
                'attrs' => ['Input' => 'High Pressure', 'Output' => 'Stable 2-3 Bar', 'Keamanan' => 'Sangat Penting']
            ],
            'pompa pendorong' => [
                'desc' => 'Booster Pump, pompa yang dipasang di jalur distribusi untuk menambah tekanan air pada shower dan kran.',
                'attrs' => ['Fitur' => 'Auto Flow Switch', 'Silent' => 'Lapis Peredam', 'Power' => '125W - 500W']
            ],
            'pompa celup' => [
                'desc' => 'Submersible Pump, pompa yang diletakkan di dalam air (sumur atau basement) untuk membuang genangan atau banjir.',
                'attrs' => ['Lokasi' => 'Terendam Air', 'Cooling' => 'Water Cooled', 'Float' => 'Integrated Switch']
            ],
            'air release valve' => [
                'desc' => 'Katup otomatis untuk membuang udara yang terjebak di dalam pipa agar aliran air tetap stabil dan tidak tersendat.',
                'attrs' => ['Fungsi' => 'Air Bleeding', 'Penempatan' => 'Titik Tertinggi Pipa', 'Material' => 'Nylon / Metal']
            ],
            'pompa limbah' => [
                'desc' => 'Sewage Pump, pompa khusus yang mampu mencacah kotoran padat agar bisa dipompa ke sistem pembuangan yang lebih tinggi.',
                'attrs' => ['Blade' => 'Grinder / Cutter', 'Solids' => 'Up to 50mm', 'Tipe' => 'Heavy Duty']
            ],
            'expansion tank' => [
                'desc' => 'Tangki tekanan kecil untuk meredam lonjakan tekanan air panas maupun dingin agar pompa tidak sering hidup-mati.',
                'attrs' => ['Membran' => 'Butyl Rubber', 'Pre-Charge' => 'Nitrogen / Air', 'Fungsi' => 'Pump Ciclyng Reduction']
            ],

            // FITTINGS & JOINTS
            'elbow' => [
                'desc' => 'Fitting berbentuk tikungan (L) untuk mengubah arah laju aliran pipa 45 atau 90 derajat.',
                'attrs' => ['Sudut' => '45 / 90 Derajat', 'Jenis' => 'Plain / Threaded', 'Material' => 'Match with Pipe']
            ],
            'tee' => [
                'desc' => 'Fitting berbentuk huruf T untuk membuat percabangan jalur pipa menjadi dua arah yang berbeda.',
                'attrs' => ['Bentuk' => 'T-Shape', 'Tipe' => 'Equal / Reducing', 'Cabang' => 'Single']
            ],
            'socket' => [
                'desc' => 'Penyambung lurus untuk menghubungkan dua batang pipa yang memiliki diameter sama.',
                'attrs' => ['Bentuk' => 'Straight', 'Connection' => 'Slip / Glue', 'Symmetry' => 'Equal']
            ],
            'reducer' => [
                'desc' => 'Fitting untuk menghubungkan dua pipa yang memiliki ukuran diameter berbeda (dari besar ke kecil).',
                'attrs' => ['Transisi' => 'Size Change', 'Tipe' => 'Concentric / Eccentric', 'Fungsi' => 'Velocity Control']
            ],
            'union' => [
                'desc' => 'Alat penyambung pipa yang bisa dilepas-pasang dengan mudah tanpa harus memotong pipa, sangat berguna untuk pemeliharaan pompa.',
                'attrs' => ['Maintenance' => 'Quick Disconnect', 'Seal' => 'O-Ring', 'Tujuan' => 'Serviceability']
            ],
            'flange' => [
                'desc' => 'Piringan logam atau plastik di ujung pipa untuk menyambungkan dua sistem pipa menggunakan baut dan gasket.',
                'attrs' => ['Sistem' => 'Bolted Connection', 'Seal' => 'Gasket Required', 'Grade' => 'Heavy Industrial']
            ],
            'cross' => [
                'desc' => 'Fitting berbentuk salib (+) yang membagi aliran air menjadi tiga arah percabangan sekaligus.',
                'attrs' => ['Bentuk' => 'X-Shape', 'Cabang' => 'Triple', 'Aplikasi' => 'Multi-Distribution']
            ],
            'plug' => [
                'desc' => 'Penutup ujung pipa dengan sistem ulir (drat) luar untuk menutup jalur pipa secara permanen atau sementara.',
                'attrs' => ['Bentuk' => 'Male Thread', 'Fungsi' => 'End Sealing', 'Removable' => 'Yes']
            ],
            'cap' => [
                'desc' => 'Penutup ujung pipa dengan sistem slip (lem) atau ulir dalam untuk mengakhiri sebuah jalur instalasi.',
                'attrs' => ['Bentuk' => 'Female / Slip', 'Fungsi' => 'Terminal Point', 'Material' => 'PVC / Brass']
            ],
            'bush' => [
                'desc' => 'Fitting sisipan untuk mengubah ukuran drat pada kran atau sambungan pipa lainnya.',
                'attrs' => ['Tipe' => 'Bushing Reducer', 'Drat' => 'Outer/Inner Thread', 'Versatility' => 'Adaptor']
            ],

            // ADDITIONAL 50+ SPECIALIZED TERMS
            'y-strainer' => [
                'desc' => 'Penyaring kotoran fisik berwujud huruf Y yang melindungi pompa dan kran dari pasir atau serpihan logam.',
                'attrs' => ['Mesh' => 'Stainless Screen', 'Maintenance' => 'Flush Port', 'Position' => 'Inlet Line']
            ],
            'seal tape' => [
                'desc' => 'Isolasi tipis putih dari bahan PTFE yang dililitkan pada drat pipa untuk mencegah kebocoran air.',
                'attrs' => ['Material' => 'PTFE', 'Fungsi' => 'Thread Sealing', 'Tahan_Kimia' => 'Sangat Baik']
            ],
            'lem pipa' => [
                'desc' => 'Solvent cement khusus yang melarutkan sebagian permukaan PVC agar kedua bagian menyatu secara molekuler (bersenyawa).',
                'attrs' => ['Setting_Time' => '15 - 30 Detik', 'Kekuatan' => 'Maksimal setelah 2 Jam', 'Warna' => 'Clear / Blue']
            ],
            'rubber gasket' => [
                'desc' => 'Karet penyekat yang dipasang di antara dua flange atau sambungan baut untuk memastikan tidak ada celah air.',
                'attrs' => ['Material' => 'EPDM / NBR', 'Elastisitas' => 'Tinggi', 'Ketebalan' => '2mm - 5mm']
            ],
            'p-trap koper' => [
                'desc' => 'Trap khusus wastafel mewah yang terbuat dari kuningan berlapis krom, memberikan nilai estetika tinggi.',
                'attrs' => ['Visual' => 'Glossy Chrome', 'Material' => 'Brass', 'Cleaning' => 'Bottom Plug']
            ],
            'clean out' => [
                'desc' => 'Titik bukaan dengan penutup drat di jalur pipa drainase untuk akses memasukkan kabel mesin spiral.',
                'attrs' => ['Akses' => 'Easy Open', 'Ukuran' => '3 - 4 Inch', 'Lokasi' => 'Setiap 10-15 Meter']
            ],
            'floor sink' => [
                'desc' => 'Bak cuci yang tertanam di lantai, biasanya di dapur komersial, untuk menampung buangan air dari mesin es atau prep-sink.',
                'attrs' => ['Kapasitas' => 'Deep Basin', 'Grate' => 'Heavy Duty Metal', 'Material' => 'Cast Iron / Porcelain']
            ],
            'grease interceptor' => [
                'desc' => 'Versi raksasa dari grease trap yang ditanam di luar gedung, mampu memisahkan lemak dalam volume ribuan liter.',
                'attrs' => ['Sektor' => 'Komersial (Restoran Besar)', 'Maintenance' => 'Vacuum Truck Service', 'Retention' => 'High Capacity']
            ],
            'vacuum breaker' => [
                'desc' => 'Alat pengaman yang mencegah air tersedot kembali ke pipa bersih saat terjadi penurunan tekanan mendadak.',
                'attrs' => ['Safety' => 'Anti-Siphon', 'Mekanisme' => 'Air Gap', 'Aplikasi' => 'Kran Taman / Irigasi']
            ],
            'water meter' => [
                'desc' => 'Alat ukur volume penggunaan air yang lewat dalam galon atau meter kubik, dasar penagihan biaya air.',
                'attrs' => ['Akurasi' => 'Meter Log', 'Material' => 'Bronze / Plastic', 'Dial' => 'Analog / Digital']
            ],
            'hydrostatic pump' => [
                'desc' => 'Pompa tangan untuk menekan air ke sistem pipa tertutup guna mendeteksi kebocoran melalui penurunan jarum manometer.',
                'attrs' => ['Pressure' => 'Adjustable', 'Tujuan' => 'Leak Hunting', 'Portable' => 'Yes']
            ],
            'pipe tracer' => [
                'desc' => 'Alat elektronik untuk melacak jalur pipa yang tertanam di dalam tanah atau dinding tanpa membongkar.',
                'attrs' => ['Sinyal' => 'Electromagnetic', 'Kedalaman' => 'Hingga 3 Meter', 'Ketepatan' => 'Sangat Tinggi']
            ],
            'smoke test' => [
                'desc' => 'Metode pengujian kebocoran gas metana pada saluran limbah dengan meniupkan asap ke dalam sistem.',
                'attrs' => ['Visual' => 'Smoky Output', 'Tujuan' => 'Gas Odor Detection', 'Status' => 'Professional Grade']
            ],
            'jetter hose' => [
                'desc' => 'Selang khusus tekanan tinggi dengan ujung nozzle berlubang laser yang mampu mendorong dirinya sendiri ke dalam pipa.',
                'attrs' => ['Tekanan' => 'Maks 10.000 PSI', 'Nozzle' => 'Rear Jet Propelled', 'Flex' => 'Reinforced Steel']
            ],
            'root cutter' => [
                'desc' => 'Mata pisau bergigi yang dipasang pada ujung mesin spiral untuk memotong akar pohon yang masuk ke dalam pipa.',
                'attrs' => ['Action' => 'Sawing / Cutting', 'Target' => 'Root Intrusion', 'Sharpness' => 'Extremely Sharp']
            ],
            'bio ball' => [
                'desc' => 'Media plastik berongga tempat bersarangnya bakteri pengurai di dalam sistem bio septic tank.',
                'attrs' => ['Luas_Permukaan' => 'Maksimal', 'Life_Span' => 'Permanen', 'Fungsi' => 'Bacterial House']
            ],
            'chlorine injector' => [
                'desc' => 'Alat untuk menyuntikkan kaporit secara otomatis ke aliran air bersih guna membunuh kuman dan bakteri.',
                'attrs' => ['Sistem' => 'Automatic Dosing', 'Higiene' => 'Sanitization', 'Adjustable' => 'PPM Levels']
            ],
            'sand filter' => [
                'desc' => 'Tabung filter berisi pasir silika untuk menyaring partikel kasar, lumpur, dan kekeruhan pada air tanah.',
                'attrs' => ['Media' => 'Silica Sand', 'Backwash' => 'Manual / Auto Valve', 'Body' => 'FRP / Stainless']
            ],
            'carbon filter' => [
                'desc' => 'Filter berisi karbon aktif untuk menyerap bau kaporit, rasa logam, dan polutan kimia pada air.',
                'attrs' => ['Media' => 'Activated Carbon', 'Fungsi' => 'Odor Removal', 'Maintenance' => 'Isi Ulang 1-2 Tahun']
            ],
            'manganese filter' => [
                'desc' => 'Filter khusus untuk menetralisir kandungan zat besi dan mangan yang menyebabkan air berwarna kuning atau berminyak.',
                'attrs' => ['Penyebab' => 'Iron & Manganese', 'Visual' => 'Yellowish Water Solution', 'Efficiency' => 'High']
            ],
            'pompa jet pump' => [
                'desc' => 'Pompa air sumur dalam yang menggunakan sistem ejector untuk menghisap air dari kedalaman lebih dari 9 meter.',
                'attrs' => ['Kedalaman' => '20 - 50 Meter', 'Pipa' => 'Double Pipe (Suction & Jet)', 'Daya' => '250W - 1000W']
            ],
            'pompa semi jet' => [
                'desc' => 'Pompa sumur dangkal yang memiliki daya dorong lebih kuat dibanding pompa biasa, cocok untuk distribusi rumah 2 lantai.',
                'attrs' => ['Kedalaman' => '9 - 11 Meter', 'Daya_Dorong' => 'Kuat', 'Pressure' => 'Stable']
            ],
            'foot valve' => [
                'desc' => 'Tusen Klep, katup satu arah di ujung pipa hisap pompa yang menjaga agar air tidak turun kembali ke sumur (pancingan tetap isi).',
                'attrs' => ['Fungsi' => 'Priming Retention', 'Material' => 'Brass / PVC', 'Feature' => 'Built-in Strainer']
            ],
            'automatic switch' => [
                'desc' => 'Otomatis pompa yang bekerja berdasarkan tekanan air (pressure switch) atau aliran air (flow switch).',
                'attrs' => ['Tipe' => 'Pressure / Flow', 'Durability' => 'Heavy Duty Contact', 'Adjustment' => 'On/Off Pressure Range']
            ],
            'radar air' => [
                'desc' => 'Saklar pelampung elektrik yang dipasang di dalam toren untuk menghidupkan dan mematikan pompa air secara otomatis.',
                'attrs' => ['Mechanic' => 'Double Weighted Ball', 'Safety' => 'Isolated Circuit', 'Life' => 'Long Lasting']
            ],
            'shock drat luar' => [
                'desc' => 'Fitting socket PVC yang salah satu ujungnya memiliki ulir (drat) keluar untuk menyambung ke kran atau fitting logam.',
                'attrs' => ['Thread' => 'Male', 'Socket' => 'Glue Joint', 'Material' => 'PVC AW Class']
            ],
            'shock drat dalam' => [
                'desc' => 'Fitting socket PVC dengan ulir dalam, biasanya digunakan sebagai titik akhir untuk pemasangan kran air.',
                'attrs' => ['Thread' => 'Female', 'Strong' => 'Usually Brass Reinforced', 'Application' => 'Faucet Point']
            ],
            'double nipple' => [
                'desc' => 'Penyambung pendek dengan ulir luar di kedua ujungnya untuk menghubungkan dua fitting yang memiliki ulir dalam.',
                'attrs' => ['Shape' => 'Hexagonal Middle', 'Material' => 'Brass / PVC / Stainless', 'Function' => 'Male-to-Male Link']
            ],
            'water mur' => [
                'desc' => 'Satu set penyambung pipa yang terdiri dari tiga bagian, memungkinkan pelepasan sambungan hanya dengan memutar mur besar di tengah.',
                'attrs' => ['Utility' => 'Disconnection Kit', 'Ease' => 'No Cutting Required', 'Seal' => 'Conical / O-Ring']
            ],
            'clamping saddle' => [
                'desc' => 'Fitting berbentuk pelana untuk membuat percabangan baru pada pipa utama yang sudah terpasang tanpa memutus pipa tersebut.',
                'attrs' => ['Application' => 'Tapping Branch', 'Seal' => 'Rubber Saddle', 'Fastening' => 'Bolted']
            ],
            'expansion joint' => [
                'desc' => 'Sambungan pipa fleksibel yang bisa memanjang-memendek untuk meredam pemuaian pipa akibat perubahan suhu ekstrem.',
                'attrs' => ['Material' => 'EPDM / Stainless Bellows', 'Fungsi' => 'Thermal Expansion', 'Stress' => 'Absorber']
            ],
            'mechanical joint' => [
                'desc' => 'Sistem penyambungan pipa tanpa lem, menggunakan ring karet dan mur pengunci, sangat umum pada pipa HDPE ukuran kecil.',
                'attrs' => ['Type' => 'Compression Fitting', 'Seal' => 'Grip Ring', 'Reusable' => 'Yes']
            ],
            'electro fusion' => [
                'desc' => 'Teknologi penyambungan HDPE tercanggih menggunakan fitting yang memiliki kawat pemanas di dalamnya.',
                'attrs' => ['Control' => 'Computerized Barcode', 'Strength' => 'Molecular Fusion', 'Usage' => 'Gas & Critical Water']
            ],
            'butt fusion' => [
                'desc' => 'Metode menyatukan dua ujung pipa HDPE dengan memanaskan kedua permukaannya lalu menekan keduanya hingga menyatu.',
                'attrs' => ['Tools' => 'Heating Plate', 'Integrity' => 'Same Strength as Pipe', 'Aplikasi' => 'Large Diameter Pipe']
            ],
            'solvent cement' => [
                'desc' => 'Cairan perekat pipa PVC yang bekerja dengan cara mengelas dingin permukaan pipa agar menyatu secara kimiawi.',
                'attrs' => ['Chemical' => 'THF / Methyl Ethyl Ketone', 'Bond' => 'Permanent', 'Viscosity' => 'Medium Body']
            ],
            'drain cleaner liquid' => [
                'desc' => 'Cairan pembersih mampet berbasis asam atau basa kuat, harus digunakan dengan sangat hati-hati agar tidak merusak pipa PVC.',
                'attrs' => ['Chemical' => 'Sulfuric Acid / Soda Api', 'Danger' => 'Corrosive', 'Warning' => 'Can Damage Old PVC']
            ],
            'soda api' => [
                'desc' => 'Sodium Hidroksida (NaOH), zat kimia yang sering digunakan untuk melarutkan lemak di saluran, namun beresiko membuat pipa PVC meleyot.',
                'attrs' => ['Heat' => 'Highly Exothermic', 'State' => 'Flakes / Powder', 'Risk' => 'Pipe Deformation']
            ],
            'bak cuci piring' => [
                'desc' => 'Kitchen Sink, titik awal utama limbah domestik yang mengandung lemak tinggi, memerlukan perawatan trap rutin.',
                'attrs' => ['Drain' => 'Large Basket', 'P trap' => 'Essential', 'Noise' => 'Deadened']
            ],
            'toilet wax ring' => [
                'desc' => 'Gasket lilin yang diletakkan di bawah closet duduk untuk memastikan tidak ada kebocoran air dan gas di sambungan lantai.',
                'attrs' => ['Material' => 'Wax / Rubber', 'Function' => 'Gas & Liquid Seal', 'Life' => 'One-time Use']
            ],
            'closet flange' => [
                'desc' => 'Fitting lantai tempat closet duduk dibautkan, menyediakan sambungan kedap air antara kshoset dan pipa PVC 4 inch.',
                'attrs' => ['Diameter' => '4 Inch', 'Anchor' => 'Bolt Slots', 'Material' => 'PVC / Brass']
            ],
            'urinal sensor' => [
                'desc' => 'Sistem kran otomatis menggunakan sensor infrared untuk membilas urinal setelah digunakan, meningkatkan higienitas.',
                'attrs' => ['Sensor' => 'Infrared', 'Power' => 'Battery / AC Adapter', 'Efficiency' => 'Water Saving']
            ],
            'auto air vent' => [
                'desc' => 'Kran pembuangan udara otomatis untuk radiator atau sistem air panas agar tidak terjadi hambatan bantalan udara (air lock).',
                'attrs' => ['Action' => 'Continuous Bleeding', 'Float' => 'Internal Mechanism', 'Pressure' => 'Up to 10 Bar']
            ],
            'thermal insulation' => [
                'desc' => 'Pembungkus pipa (foam atau glasswool) untuk menjaga suhu air di dalam pipa ppr atau tembaga agar tidak boros energi.',
                'attrs' => ['Material' => 'Closed-Cell Foam', 'UV' => 'Coated', 'Purpose' => 'Heat Retention']
            ],
            'pipe clamp' => [
                'desc' => 'Gantungan atau klem besi untuk menahan posisi pipa agar tidak bergeser, berisik, atau melengkung karena beban air.',
                'attrs' => ['Material' => 'Galvanized Steel', 'Lining' => 'Rubber Anti-Vibration', 'Mount' => 'Threaded Rod']
            ],
            'hammer arrestor' => [
                'desc' => 'Tabung kecil berisi bantalan udara yang menyerap kejutan air saat kran ditutup, mencegah pipa pecah.',
                'attrs' => ['Fungsi' => 'Shock Absorber', 'Spring' => 'Piston Loaded', 'Standard' => 'PDI-WH 201']
            ],
            'mixing valve' => [
                'desc' => 'Keran pencampur yang menggabungkan air panas dan dingin untuk mencapai suhu mandi yang diinginkan secara presisi.',
                'attrs' => ['Tech' => 'Thermostatic', 'Safety' => 'Anti-Scald', 'Cartridge' => 'Ceramic']
            ],
            'pressure gauge' => [
                'desc' => 'Manometer, alat jarum penunjuk yang menampilkan besaran tekanan air di dalam sistem pipa secara real-time.',
                'attrs' => ['Unit' => 'Bar / PSI', 'Dial' => 'Analog', 'Range' => '0 - 16 Bar']
            ],
            'float switch' => [
                'desc' => 'Saklar pelampung kabel untuk pompa celup yang secara otomatis mematikan pompa ketika air di bak penampungan habis.',
                'attrs' => ['Action' => 'Empty / Fill', 'Cable' => 'Neoprene / PVC', 'Load' => 'Up to 16A']
            ],
            't-manifold' => [
                'desc' => 'Pipa kolektor dengan banyak percabangan untuk membagi air ke berbagai ruangan dari satu titik distribusi pusat.',
                'attrs' => ['Ports' => '2 - 12 Outlets', 'Material' => 'PEX / Brass', 'Control' => 'Individual Valves']
            ],
            'pumping station' => [
                'desc' => 'Rumah pompa yang berisi rangkaian pompa besar untuk mendistribusikan air atau membuang limbah dalam skala satu wilayah.',
                'attrs' => ['Complexity' => 'System Grade', 'Panels' => 'Smart Inverter / VFD', 'Redundancy' => 'N+1']
            ],

            // NEW SPECIALIZED TERMS (Expanding to 150+)
            'sifon' => [
                'desc' => 'Perangkap air berbentuk leher angsa di bawah wastafel yang berfungsi mencegah gas berbau dari saluran masuk ke ruangan.',
                'attrs' => ['Tipe' => 'Bottle / P-Trap', 'Material' => 'PVC / Brass', 'Fungsi' => 'Odor Seal']
            ],
            'flexible hose' => [
                'desc' => 'Selang lentur berlapis anyaman stainless steel untuk menghubungkan pipa suplai air ke kran atau tangki closet.',
                'attrs' => ['Panjang' => '30 - 60 cm', 'Material' => 'EPDM with SS Braiding', 'Koneksi' => 'Nut 1/2 Inch']
            ],
            'silikon sealant' => [
                'desc' => 'Bahan pengisi celah elastis yang digunakan untuk menyumbat sambungan antara plumbing fixture dengan dinding atau lantai.',
                'attrs' => ['Sifat' => 'Waterproof & Antijamur', 'Base' => 'Acetic / Neutral', 'Warna' => 'Clear / White']
            ],
            'pipa conduit' => [
                'desc' => 'Pipa pelindung kabel listrik yang sering dipasang bersamaan dengan sistem plumbing pada area plafon atau dalam beton.',
                'attrs' => ['Penyebutan' => 'Pipa Listrik', 'Material' => 'High Impact PVC', 'Warna' => 'Putih / Abu-abu']
            ],
            'elbow 45' => [
                'desc' => 'Fitting penyambung pipa untuk membelokkan aliran dengan sudut tumpul 45 derajat, lebih lancar dibanding elbow 90.',
                'attrs' => ['Sudut' => '45 Degree', 'Hambatan' => 'Rendah', 'Aliran' => 'Smooth Flow']
            ],
            'tee equal' => [
                'desc' => 'Cabang pipa berbentuk T dengan ketiga lubang memiliki diameter yang sama besar.',
                'attrs' => ['Bentuk' => 'Equal Tee', 'Aplikasi' => 'Distribusi Cabang', 'Standar' => 'SNI / JIS']
            ],
            'tee reducing' => [
                'desc' => 'Cabang pipa T di mana lubang cabangnya memiliki diameter lebih kecil dari jalur utamanya.',
                'attrs' => ['Fungsi' => 'Branch Connection', 'Tipe' => 'Reducer Tee', 'Efficiency' => 'Flow Control']
            ],
            'cross equal' => [
                'desc' => 'Fitting simpang empat yang membagi aliran ke empat arah dengan ukuran lubang yang seragam.',
                'attrs' => ['Bentuk' => '4-Way', 'Symmetry' => 'Equal', 'Aplikasi' => 'Header Pipe']
            ],
            'union socket' => [
                'desc' => 'Fitting penyambung lepasan dengan sistem lem (slip) yang memudahkan bongkar pasang tanpa pemotongan.',
                'attrs' => ['Maintenance' => 'Very Easy', 'Sistem' => 'Water Mur Glue', 'Kelas' => 'AW']
            ],
            'flange blind' => [
                'desc' => 'Piringan penutup (buta) yang digunakan untuk menutup ujung jalur pipa sistem flange secara permanen namun mudah dibuka.',
                'attrs' => ['Fungsi' => 'End Termination', 'Sistem' => 'Bolted', 'Rating' => 'ANSI / DIN / JIS']
            ],
            'gasket spiral wound' => [
                'desc' => 'Gasket teknis tinggi dengan lilitan logam dan pengisi (filler) untuk sambungan flange tekanan tinggi dan suhu ekstrem.',
                'attrs' => ['Material' => 'SS316 / Graphite', 'Rating' => 'Class 150 - 2500', 'Aplikasi' => 'Industrial / Steam']
            ],
            'pressure tank' => [
                'desc' => 'Tangki tekan yang berfungsi menjaga kestabilan tekanan air dan memperpanjang umur pompa dengan mengurangi frekuensi start-stop.',
                'attrs' => ['Volume' => '19L - 1000L', 'Membran' => 'Butyl', 'Pre-Charge' => 'Nitrogen']
            ],
            'safety valve' => [
                'desc' => 'Katup pengaman yang akan terbuka secara otomatis jika tekanan dalam sistem melebihi batas aman guna mencegah ledakan pipa atau tangki.',
                'attrs' => ['Set_Pressure' => 'Adjustable', 'Fungsi' => 'Overpressure Protection', 'Media' => 'Water / Steam / Gas']
            ],
            'strainer basket' => [
                'desc' => 'Filter industri berukuran besar dengan wadah saringan berbentuk keranjang yang bisa dilepas untuk dibersihkan.',
                'attrs' => ['Capacity' => 'High Flow', 'Mesh' => 'Stainless Steel', 'Body' => 'Cast Iron / Steel']
            ],
            'water meter induk' => [
                'desc' => 'Meteran air berukuran besar yang dipasang pada pipa utama untuk mencatat total konsumsi air satu gedung atau kawasan.',
                'attrs' => ['Ukuran' => '2 - 8 Inch', 'Tipe' => 'Woltman', 'Akurasi' => 'Class B / C']
            ],
            'pipa sch 40' => [
                'desc' => 'Pipa baja atau PVC dengan ketebalan dinding Schedule 40, standar umum untuk aplikasi perpipaan industri dan komersial.',
                'attrs' => ['Standar' => 'ASTM A53 / ASTM D1785', 'Pressure' => 'Medium', 'Dinding' => 'Standard Weight']
            ],
            'pipa sch 80' => [
                'desc' => 'Pipa dengan dinding lebih tebal dibanding SCH 40, digunakan untuk cairan kimia berbahaya atau tekanan yang lebih tinggi.',
                'attrs' => ['Durabilitas' => 'Ekstrem', 'Pressure' => 'High', 'Aplikasi' => 'Chemical / Industrial']
            ],
            'pipa kelas aw' => [
                'desc' => 'Pipa PVC standar SNI kelas paling tebal yang mampu menahan tekanan air hingga 10 kg/cm2, ideal untuk jalur air bersih.',
                'attrs' => ['Working_Pressure' => '10 Bar', 'Aplikasi' => 'Air Bersih', 'Ketebalan' => 'Maksimal (SNI)']
            ],
            'pipa kelas d' => [
                'desc' => 'Pipa PVC standar SNI untuk aplikasi pembuangan air limbah (drainase) tanpa tekanan tinggi.',
                'attrs' => ['Working_Pressure' => '5 Bar', 'Aplikasi' => 'Drainage / Air Hujan', 'Budget' => 'Ekonomis']
            ],
            'grey water' => [
                'desc' => 'Air limbah domestik yang tidak mengandung kotoran manusia, seperti air bekas mandi dan cuci piring.',
                'attrs' => ['Sumber' => 'Shower / Sink', 'Treatment' => 'Filtrasi / Recycling', 'Beban' => 'Sabun & Lemak']
            ],
            'black water' => [
                'desc' => 'Air limbah yang mengandung kotoran manusia dari closet atau urinal, memerlukan pengolahan biologis di septic tank.',
                'attrs' => ['Sumber' => 'Toilet', 'Treatment' => 'Anaerobic Digestion', 'Resiko' => 'Patogen Tinggi']
            ],
            'vacuum truck' => [
                'desc' => 'Truk tangki spesialis yang dilengkapi pompa vacuum bertenaga besar untuk menyedot limbah septic tank atau lumpur saluran.',
                'attrs' => ['Kapasitas' => '3000L - 8000L', 'Fungsi' => 'Sedot WC / Drain Cleaning', 'Sistem' => 'Vacuum High Power']
            ],
            'roof drain' => [
                'desc' => 'Saringan saluran air di dak beton atau atap gedung yang dirancang untuk mencegah sampah daun masuk ke pipa vertikal.',
                'attrs' => ['Bentuk' => 'Dome / Flat', 'Material' => 'Cast Iron / Aluminium', 'Fungsi' => 'Rainwater Outlet']
            ],
            'jet washer' => [
                'desc' => 'Semprotan air kecil (bidet spray) di samping closet yang digunakan untuk pembilasan setelah buang air.',
                'attrs' => ['Material' => 'ABS / Chrome', 'Hose' => 'Flexible Spiral', 'Operation' => 'Trigger Squeeze']
            ],
            'angle valve' => [
                'desc' => 'Stop kran kecil berbentuk siku yang biasanya dipasang di bawah wastafel untuk mengontrol aliran ke kran atau closet.',
                'attrs' => ['Inlet' => '1/2 Inch', 'Outlet' => '1/2 Inch', 'Material' => 'Chrome Brass']
            ],
            'stop kran' => [
                'desc' => 'Istilah umum untuk katup yang berfungsi menghentikan atau membuka aliran air pada titik tertentu dalam instalasi.',
                'attrs' => ['Fungsi' => 'Isolation Valve', 'Aplikasi' => 'Rumah Tangga', 'Mechanism' => 'Ball / Gate']
            ],
            'check valve swing' => [
                'desc' => 'Katup satu arah dengan piringan yang berayun untuk menutup saat ada aliran balik, cocok untuk posisi horizontal.',
                'attrs' => ['Tipe' => 'Swing Check', 'Hambatan' => 'Sangat Rendah', 'Media' => 'Clear Water']
            ],
            'check valve spring' => [
                'desc' => 'Katup satu arah yang menggunakan pegas untuk menutup piringan secara cepat, mencegah benturan water hammer.',
                'attrs' => ['Tipe' => 'Spring Loaded', 'Posisi' => 'Vertical / Horizontal', 'Resistansi' => 'Sedang']
            ],
            'foot valve brass' => [
                'desc' => 'Tusen klep berbahan kuningan untuk pipa hisap pompa sumur dalam agar pancingan air tidak hilang.',
                'attrs' => ['Material' => 'Heavy Duty Brass', 'Strainer' => 'Stainless Steel Mesh', 'Kualitas' => 'Premium']
            ],
            'pipa pex-al-pex' => [
                'desc' => 'Pipa komposit Cross-linked Polyethylene dengan lapisan aluminium di tengahnya, tahan tekanan dan suhu sangat tinggi.',
                'attrs' => ['Lapisan' => 'Multilayer', 'Tahan_Suhu' => 'Hingga 110 C', 'Bentuk' => 'Roll / Koil']
            ],
            'sealant tape' => [
                'desc' => 'Plester perekat khusus untuk menambal kebocoran halus pada pipa atau tangki secara darurat.',
                'attrs' => ['Fungsi' => 'Emergency Leak Fix', 'Material' => 'Rubber / Silicone', 'Stretch' => 'High Elasticity']
            ],
            'pipe bracket' => [
                'desc' => 'Penyangga pipa yang menempel di dinding untuk memastikan pipa tetap lurus dan tidak melorot.',
                'attrs' => ['Material' => 'Galvanized Metal', 'Sistem' => 'Dyna-bolt', 'Size' => '1/2 - 4 Inch']
            ],
            'trap door' => [
                'desc' => 'Bukaan akses pada plafon atau dinding untuk memudahkan teknisi menjangkau pipa yang tertanam (pipa shaft).',
                'attrs' => ['Fungsi' => 'Maintenance Access', 'Bentuk' => 'Hatch', 'Material' => 'Gypsum / Aluminium']
            ]
        ];

        // Match based on keywords
        foreach ($kb as $key => $data) {
            if (str_contains($nameLower, $key)) {
                return $data;
            }
        }

        // Default "AI Inference" if no match
        return [
            'desc' => "Komponen infrastruktur saluran air '{$name}' merupakan bagian penting dalam sistem plumbing modern yang memerlukan perawatan rutin.",
            'attrs' => ['Kategori' => 'General Plumbing', 'Maintenance' => 'Required', 'Expertise_Level' => 'Professional']
        ];
    }
}
