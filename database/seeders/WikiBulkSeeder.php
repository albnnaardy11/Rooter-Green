<?php

namespace Database\Seeders;

use App\Models\WikiEntity;
use Illuminate\Database\Seeder;

class WikiBulkSeeder extends Seeder
{
    public function run(): void
    {
        $entities = array (
  0 => 
  array (
    'title' => 'Pvc',
    'category' => 'Material Pipa',
    'description' => 'Polimer termoplastik yang tahan korosi dan ringan, umum digunakan untuk sistem drainase limbah domestik.',
    'attributes' => 
    array (
      'Standar' => 'SNI 06-0084',
      'Durabilitas' => '50+ Tahun',
      'Tipe' => 'Termoplastik',
    ),
  ),
  1 => 
  array (
    'title' => 'Hdpe',
    'category' => 'Material Pipa',
    'description' => 'High Density Polyethylene, pipa PE-100 yang fleksibel dan tahan benturan, sering digunakan untuk distribusi air bersih tekanan tinggi.',
    'attributes' => 
    array (
      'Fleksibilitas' => 'Tinggi',
      'Ketahanan_Kimia' => 'Luar Biasa',
      'Penyambungan' => 'Butt Fusion / Electrofusion',
    ),
  ),
  2 => 
  array (
    'title' => 'Ppr',
    'category' => 'Material Pipa',
    'description' => 'Polypropylene Random, pipa khusus untuk air panas dan dingin bertekanan dengan sistem penyambungan pemanasan (Heat Fusion).',
    'attributes' => 
    array (
      'Suhu_Maks' => '95 Derajat Celcius',
      'Sistem' => 'PN-10 / PN-20',
      'Higiene' => 'Food Grade',
    ),
  ),
  3 => 
  array (
    'title' => 'Pex',
    'category' => 'Material Pipa',
    'description' => 'Cross-linked Polyethylene, pipa fleksibel yang tahan suhu ekstrem, sering digunakan untuk sistem pemanas lantai dan distribusi air rumah tangga.',
    'attributes' => 
    array (
      'Radius_Tekuk' => 'Lentur',
      'Ketahanan' => 'Anti-Karat',
      'Instalasi' => 'Fast-Fit',
    ),
  ),
  4 => 
  array (
    'title' => 'Galvanis',
    'category' => 'Material Pipa',
    'description' => 'Pipa besi yang dilapisi lapisan seng (zinc) untuk mencegah karat, biasanya digunakan pada instalasi air bersih bangunan lama.',
    'attributes' => 
    array (
      'Material' => 'Zinc-Coated Steel',
      'Kekuatan' => 'Tinggi',
      'Kelemahan' => 'Scaling setelah 15 tahun',
    ),
  ),
  5 => 
  array (
    'title' => 'Tembaga',
    'category' => 'Material Pipa',
    'description' => 'Pipa logam dengan konduktivitas panas tinggi, tahan terhadap pertumbuhan bakteri, umum digunakan untuk jalur AC dan gas.',
    'attributes' => 
    array (
      'Material' => 'Copper',
      'Antibakteri' => 'Alami',
      'Aplikasi' => 'Medical & AC',
    ),
  ),
  6 => 
  array (
    'title' => 'Besi Cor',
    'category' => 'Material Pipa',
    'description' => 'Cast Iron, pipa berat yang tahan api dan memiliki tingkat peredaman suara tinggi, ideal untuk instalasi gedung bertingkat.',
    'attributes' => 
    array (
      'Fitur' => 'Sound-Proofing',
      'Standar' => 'ASTM A888',
      'Ketahanan' => 'Heavy Duty',
    ),
  ),
  7 => 
  array (
    'title' => 'Stainless Steel',
    'category' => 'Material Pipa',
    'description' => 'Pipa baja tahan karat yang sangat higienis, digunakan dalam industri makanan, farmasi, dan instalasi air mewah.',
    'attributes' => 
    array (
      'Grade' => 'SS304 / SS316',
      'Visual' => 'Premium Look',
      'Higiene' => 'Steril',
    ),
  ),
  8 => 
  array (
    'title' => 'U-pvc',
    'category' => 'Material Pipa',
    'description' => 'Unplasticized Polyvinyl Chloride, versi kaku dari PVC yang lebih kuat dan tahan tekanan, sering untuk jalur distribusi kota.',
    'attributes' => 
    array (
      'Kekakuan' => 'Maksimal',
      'UV_Resistance' => 'Moderate',
      'Aplikasi' => 'Industrial',
    ),
  ),
  9 => 
  array (
    'title' => 'Cpvc',
    'category' => 'Material Pipa',
    'description' => 'Chlorinated Polyvinyl Chloride, modifikasi PVC yang tahan terhadap suhu lebih tinggi hingga 90 derajat celcius.',
    'attributes' => 
    array (
      'Suhu_Kerja' => 'Tinggi',
      'Ketahanan_API' => 'Self-Extinguishing',
      'Tipe' => 'Industrial Grade',
    ),
  ),
  10 => 
  array (
    'title' => 'Spiral',
    'category' => 'Alat Teknisi',
    'description' => 'Alat mekanis dengan kabel baja fleksibel yang mampu menembus hambatan padat dalam pipa tanpa proses pembongkaran.',
    'attributes' => 
    array (
      'Material' => 'High Carbon Steel',
      'Jangkauan' => '30 Meter',
      'Power' => 'Electric High-Torque',
    ),
  ),
  11 => 
  array (
    'title' => 'Jetting',
    'category' => 'Alat Teknisi',
    'description' => 'Sistem pembersihan pipa menggunakan tekanan air ekstrem untuk merontokkan kerak lemak yang membeku di dinding saluran.',
    'attributes' => 
    array (
      'Tekanan' => '200-500 Bar',
      'Flow' => 'High Pressure',
      'Fungsi' => 'Hydro Jetting',
    ),
  ),
  12 => 
  array (
    'title' => 'Kamera Pipa',
    'category' => 'Alat Teknisi',
    'description' => 'Alat inspeksi visual (Endoscope/Borescope) untuk melihat kondisi bagian dalam pipa secara real-time guna menemukan titik kerusakan atau sumbatan.',
    'attributes' => 
    array (
      'Resolusi' => 'Full HD',
      'Fitur' => 'Recording & Snapshot',
      'Jangkauan' => '20 - 60 Meter',
    ),
  ),
  13 => 
  array (
    'title' => 'Drain Cleaner',
    'category' => 'Alat Teknisi',
    'description' => 'Mesin pembersih saluran yang variatif, mulai dari hand-tool hingga mesin generator bertenaga besar untuk sumbatan berat.',
    'attributes' => 
    array (
      'Tipe' => 'Hand / Electric',
      'Sektor' => 'Domestic & Industrial',
      'Blade' => 'Interchangeable',
    ),
  ),
  14 => 
  array (
    'title' => 'Kunci Pipa',
    'category' => 'Alat Teknisi',
    'description' => 'Pipe Wrench, alat berat untuk mencengkeram dan memutar pipa besi atau fitting dengan rahang bergerigi tajam.',
    'attributes' => 
    array (
      'Size' => '10 - 48 Inch',
      'Rahang' => 'Hardened Steel',
      'Adjustable' => 'Yes',
    ),
  ),
  15 => 
  array (
    'title' => 'Flaring Tool',
    'category' => 'Alat Teknisi',
    'description' => 'Alat untuk melebarkan ujung pipa tembaga agar bisa disambungkan dengan fitting sistem flare (tekan).',
    'attributes' => 
    array (
      'Akurasi' => 'Presisi',
      'Material' => 'Chromed Steel',
      'Tujuan' => 'Leak-Free Joint',
    ),
  ),
  16 => 
  array (
    'title' => 'Welding Machine',
    'category' => 'Alat Teknisi',
    'description' => 'Mesin las HDPE atau PPR yang menggunakan panas untuk melelehkan dua ujung pipa agar menyatu secara permanen.',
    'attributes' => 
    array (
      'Kontrol' => 'Digital Temperature',
      'Plat' => 'Teflon Coated',
      'Kecepatan' => 'Real-time Heating',
    ),
  ),
  17 => 
  array (
    'title' => 'Pressure Test',
    'category' => 'Alat Teknisi',
    'description' => 'Alat pompa manual atau elektrik untuk menguji kebocoran pada instalasi pipa baru dengan tekanan udara atau air.',
    'attributes' => 
    array (
      'Indikator' => 'Manometer',
      'Maks_Tekanan' => '60 Bar',
      'Fungsi' => 'Quality Control',
    ),
  ),
  18 => 
  array (
    'title' => 'Pipe Cutter',
    'category' => 'Alat Teknisi',
    'description' => 'Alat pemotong pipa yang memberikan hasil potongan tegak lurus dan bersih tanpa meninggalkan bram (serpihan).',
    'attributes' => 
    array (
      'Wheel' => 'Circular Blade',
      'Material' => 'Aluminum Case',
      'Cleanliness' => 'Burr-Free',
    ),
  ),
  19 => 
  array (
    'title' => 'Hand Auger',
    'category' => 'Alat Teknisi',
    'description' => 'Versi manual dari mesin spiral, digunakan untuk masalah sumbatan ringan pada wastafel atau floor drain kamar mandi.',
    'attributes' => 
    array (
      'Manual' => 'Crank Handle',
      'Aplikasi' => 'Rumah Tangga',
      'Panjang' => '3 - 7 Meter',
    ),
  ),
  20 => 
  array (
    'title' => 'Wastafel',
    'category' => 'Infrastruktur',
    'description' => 'Titik buang air kotor yang sering mengalami penyumbatan akibat akumulasi sisa makanan dan lemak sabun.',
    'attributes' => 
    array (
      'Diameter_Ideal' => '1.5 - 2 Inchi',
      'Material' => 'Keramik / Stainless',
      'Penyebab_Mampet' => 'Lemak & Rambut',
    ),
  ),
  21 => 
  array (
    'title' => 'Closet',
    'category' => 'Infrastruktur',
    'description' => 'Perangkat sanitasi utama untuk pembuangan tinja, memiliki sistem flush dan trap untuk menahan bau dari septic tank.',
    'attributes' => 
    array (
      'Tipe' => 'Duduk / Jongkok',
      'Sistem' => 'Siphonic / Washdown',
      'Water_Usage' => 'Dual Flush',
    ),
  ),
  22 => 
  array (
    'title' => 'Urinal',
    'category' => 'Infrastruktur',
    'description' => 'Tempat buang air kecil khusus pria yang efisien dalam penggunaan air, sering menggunakan sensor otomatis.',
    'attributes' => 
    array (
      'Fitur' => 'Auto-Flush',
      'Instalasi' => 'Wall-Hung',
      'Maintenance' => 'Cek Kerak Urine',
    ),
  ),
  23 => 
  array (
    'title' => 'Bidet',
    'category' => 'Infrastruktur',
    'description' => 'Alat pembersih setelah buang air besar yang menyatu dengan closet (ecowasher) atau berdiri sendiri.',
    'attributes' => 
    array (
      'Higiene' => 'Sangat Tinggi',
      'Tekanan' => 'Soft Flow',
      'Tipe' => 'Electronic / Manual',
    ),
  ),
  24 => 
  array (
    'title' => 'Floor Drain',
    'category' => 'Infrastruktur',
    'description' => 'Saringan saluran air di lantai kamar mandi yang dilengkapi penutup otomatis atau jebakan air untuk mencegah kecoa dan bau.',
    'attributes' => 
    array (
      'Fitur' => 'Anti-Bau / Anti-Serangga',
      'Material' => 'Brass / Stainless Steel',
      'Desain' => 'Elegant Slot',
    ),
  ),
  25 => 
  array (
    'title' => 'Bathtub',
    'category' => 'Infrastruktur',
    'description' => 'Wadah mandi besar yang memerlukan instalasi pembuangan khusus (overflow) dan keran pengisi volume besar.',
    'attributes' => 
    array (
      'Material' => 'Acrylic / Marble',
      'Sistem' => 'Pop-up Waste',
      'Drainase' => 'Self-Draining',
    ),
  ),
  26 => 
  array (
    'title' => 'Kitchen Sink',
    'category' => 'Infrastruktur',
    'description' => 'Bak cuci piring dapur yang paling rentan terhadap penumpukan lemak beku di saluran pembuangannya.',
    'attributes' => 
    array (
      'Depth' => 'Deep Bowl',
      'Noise' => 'Sound Deadening Pad',
      'Accessories' => 'Drain Basket',
    ),
  ),
  27 => 
  array (
    'title' => 'Shower',
    'category' => 'Infrastruktur',
    'description' => 'Sistem pemandian dengan pancuran air yang memerlukan tekanan stabil untuk kenyamanan maksimal.',
    'attributes' => 
    array (
      'Head' => 'Rain Shower / Hand Shower',
      'Nozzle' => 'Easy-Clean Silicon',
      'Valve' => 'Mixer Hot/Cold',
    ),
  ),
  28 => 
  array (
    'title' => 'Kran Air',
    'category' => 'Infrastruktur',
    'description' => 'Faucet, titik akhir distribusi air yang mengontrol laju aliran, tersedia dalam berbagai desain estetika.',
    'attributes' => 
    array (
      'Cartridge' => 'Ceramic Disc',
      'Material' => 'Solid Brass',
      'Aerator' => 'Honeycomb Water Saving',
    ),
  ),
  29 => 
  array (
    'title' => 'Water Heater',
    'category' => 'Infrastruktur',
    'description' => 'Pemanas air yang menggunakan listrik, gas, atau tenaga surya untuk menyediakan air hangat instan.',
    'attributes' => 
    array (
      'Energy' => 'Gas / Electric / Solar',
      'Safety' => 'ELCB / Thermostat',
      'Tank' => 'Glass-Lined',
    ),
  ),
  30 => 
  array (
    'title' => 'Septic Tank',
    'category' => 'Infrastruktur',
    'description' => 'Unit pengolahan limbah domestik kedap air yang berfungsi mengolah limbah tinja melalui proses dekomposisi anaerobik.',
    'attributes' => 
    array (
      'Material' => 'Beton / Fiberglass',
      'Proses' => 'Anaerobik Digestion',
      'Output' => 'Effluent',
    ),
  ),
  31 => 
  array (
    'title' => 'Grease Trap',
    'category' => 'Infrastruktur',
    'description' => 'Alat penyaring yang dirancang untuk menangkap lemak, minyak, dan lemak (FOG) agar tidak masuk ke sistem saluran pembuangan utama.',
    'attributes' => 
    array (
      'Material' => 'Stainless Steel / PVC',
      'Fungsi' => 'FOG Reduction',
      'Maintenance' => 'Pembersihan Berkala',
    ),
  ),
  32 => 
  array (
    'title' => 'Toren',
    'category' => 'Infrastruktur',
    'description' => 'Tangki penyimpanan air di atas bangunan untuk menjaga ketersediaan air dan mengatur tekanan air secara gravitasi ke seluruh instalasi.',
    'attributes' => 
    array (
      'Kapasitas' => '500L - 5000L',
      'Lapisan' => 'Anti-Lumut & UV Protection',
      'Material' => 'MDPE / Stainless',
    ),
  ),
  33 => 
  array (
    'title' => 'Bak Kontrol',
    'category' => 'Infrastruktur',
    'description' => 'Check Chamber, titik akses pada sistem drainase untuk melakukan pengecekan, pembersihan, dan pemeliharaan saluran.',
    'attributes' => 
    array (
      'Ukuran' => 'Standar 40x40 - 60x60',
      'Fitur' => 'Removable Cover',
      'Lokasi' => 'Setiap Belokan Saluran',
    ),
  ),
  34 => 
  array (
    'title' => 'Manhole',
    'category' => 'Infrastruktur',
    'description' => 'Lubang masuk berukuran manusia untuk akses ke sistem gorong-gorong atau pipa induk perkotaan di bawah jalan.',
    'attributes' => 
    array (
      'Cover' => 'Heavy Duty Ductile Iron',
      'Diameter' => '600mm - 800mm',
      'Load_Class' => 'D400 (30-40 Ton)',
    ),
  ),
  35 => 
  array (
    'title' => 'Sumur Resapan',
    'category' => 'Infrastruktur',
    'description' => 'Sistem infiltrasi air hujan atau air limbah yang sudah diolah ke dalam tanah untuk menjaga cadangan air tanah.',
    'attributes' => 
    array (
      'Kedalaman' => '3 - 10 Meter',
      'Material' => 'Pipa Berlubang / Kerikil',
      'Tujuan' => 'Eco-Friendly Drainage',
    ),
  ),
  36 => 
  array (
    'title' => 'Bio Septic',
    'category' => 'Infrastruktur',
    'description' => 'Septic tank modern yang menggunakan media filter bakteri untuk memproses limbah menjadi cairan yang lebih aman dibuang langsung.',
    'attributes' => 
    array (
      'Media' => 'Bioball / Honeycomb',
      'Efisiensi' => '90% BOD Removal',
      'Ramah_Lingkungan' => 'Sangat Baik',
    ),
  ),
  37 => 
  array (
    'title' => 'Pipa Induk',
    'category' => 'Infrastruktur',
    'description' => 'Main Line, jalur pipa utama berdiameter besar yang mendistribusikan air dari pusat ke berbagai cabang bangunan.',
    'attributes' => 
    array (
      'Diameter' => '4 - 24 Inch',
      'Tekanan' => 'High Pressure',
      'Maintenance' => 'Hydrant Access',
    ),
  ),
  38 => 
  array (
    'title' => 'Vent Stack',
    'category' => 'Infrastruktur',
    'description' => 'Pipa vertikal yang terbuka ke udara untuk mengatur tekanan dalam pipa dan mencegah hilangnya air pada P-Trap.',
    'attributes' => 
    array (
      'Fungsi' => 'Air Balancing',
      'Lokasi' => 'Atap Bangunan',
      'Prinsip' => 'Atmospheric Pressure',
    ),
  ),
  39 => 
  array (
    'title' => 'Gorong-gorong',
    'category' => 'Infrastruktur',
    'description' => 'Culvert, saluran air besar yang melintasi bawah jalan atau jembatan untuk mengalirkan air hujan skala kota.',
    'attributes' => 
    array (
      'Bentuk' => 'Kotak / Lingkaran',
      'Material' => 'Precast Concrete',
      'Kapasitas' => 'Sangat Besar',
    ),
  ),
  40 => 
  array (
    'title' => 'Mampet',
    'category' => 'Masalah Plumbing',
    'description' => 'Kondisi tersumbatnya aliran air akibat akumulasi kotoran padat, lemak, atau benda asing di dalam jalur pipa.',
    'attributes' => 
    array (
      'Penyebab' => 'Lemak / Rambut / Tisu',
      'Solusi' => 'Spiral Machine',
      'Tingkat' => 'Ringan - Berat',
    ),
  ),
  41 => 
  array (
    'title' => 'Bocor',
    'category' => 'Masalah Plumbing',
    'description' => 'Rematun air keluar dari sambungan pipa atau dinding pipa yang pecah, mengakibatkan pemborosan dan kerusakan struktur.',
    'attributes' => 
    array (
      'Indikasi' => 'Tagihan Air Naik',
      'Deteksi' => 'Pressure Test',
      'Perbaikan' => 'Fitting Replacement',
    ),
  ),
  42 => 
  array (
    'title' => 'Scaling',
    'category' => 'Masalah Plumbing',
    'description' => 'Penumpukan kerak kapur atau mineral di dalam pipa, biasanya terjadi pada pipa logam akibat air tanah dengan kesadahan tinggi.',
    'attributes' => 
    array (
      'Efek' => 'Diameter Mengecil',
      'Penyebab' => 'Hard Water',
      'Solusi' => 'Chemical Cleaning / Jetting',
    ),
  ),
  43 => 
  array (
    'title' => 'Korosi',
    'category' => 'Masalah Plumbing',
    'description' => 'Proses pengkaratan pada pipa logam akibat reaksi kimia dengan oksigen dan air, yang lama kelamaan membuat pipa berlubang.',
    'attributes' => 
    array (
      'Material_Rentan' => 'Besi / Baja',
      'Warna' => 'Coklat Karat',
      'Penyegahan' => 'Galvanisasi / Coating',
    ),
  ),
  44 => 
  array (
    'title' => 'Backflow',
    'category' => 'Masalah Plumbing',
    'description' => 'Kondisi di mana air kotor mengalir kembali ke sumber air bersih akibat perbedaan tekanan, sangat berbahaya bagi kesehatan.',
    'attributes' => 
    array (
      'Resiko' => 'Kontaminasi Bakteri',
      'Alat_Cegah' => 'Check Valve',
      'Penyakit' => 'Diare / Kolera',
    ),
  ),
  45 => 
  array (
    'title' => 'Water Hammer',
    'category' => 'Masalah Plumbing',
    'description' => 'Goncangan keras pada pipa saat keran ditutup mendadak, menghasilkan dentuman yang bisa merusak sambungan pipa.',
    'attributes' => 
    array (
      'Suara' => 'Benturan Logam',
      'Efek' => 'Sudden Shock',
      'Solusi' => 'Arrestor / Air Chamber',
    ),
  ),
  46 => 
  array (
    'title' => 'Bau Drainase',
    'category' => 'Masalah Plumbing',
    'description' => 'Munculnya aroma tidak sedap dari lubang pembuangan, biasanya akibat P-Trap kering atau kebocoran gas septic tank.',
    'attributes' => 
    array (
      'Penyebab' => 'Seal Rusak',
      'Lokasi' => 'KM / Dapur',
      'Gas' => 'H2S / Metana',
    ),
  ),
  47 => 
  array (
    'title' => 'Pipa Berisik',
    'category' => 'Masalah Plumbing',
    'description' => 'Suara bising saat air mengalir, seringkali karena pipa tidak dijepit dengan kuat atau tekanan air yang terlalu tinggi (turbulensi).',
    'attributes' => 
    array (
      'Penyebab' => 'Loose Support',
      'Level' => 'Moderate',
      'Mitigasi' => 'Pipe Clamp / Buffer',
    ),
  ),
  48 => 
  array (
    'title' => 'Rembes Dinding',
    'category' => 'Masalah Plumbing',
    'description' => 'Dinding lembab atau berjamur akibat adanya pipa bocor halus di dalam tembok yang tidak terdeteksi langsung.',
    'attributes' => 
    array (
      'Efek_Samping' => 'Lumut / Jamur',
      'Struktur' => 'Kerapuhan Beton',
      'Deteksi' => 'Thermal Imaging',
    ),
  ),
  49 => 
  array (
    'title' => 'Tekanan Rendah',
    'category' => 'Masalah Plumbing',
    'description' => 'Aliran air yang keluar sangat kecil, bisa disebabkan oleh penyumbatan di filter kran atau masalah pada pompa booster.',
    'attributes' => 
    array (
      'Lokasi' => 'Kran / Shower',
      'Check' => 'Pebersihan Aerator',
      'Solusi_Teknis' => 'Pompa Pendorong',
    ),
  ),
  50 => 
  array (
    'title' => 'Ball Valve',
    'category' => 'Alat Teknisi',
    'description' => 'Stop kran dengan mekanisme bola berlubang yang bisa dibuka-tutup dengan putaran 90 derajat secara cepat.',
    'attributes' => 
    array (
      'Operation' => 'Quarter-Turn',
      'Durabilitas' => 'Tinggi',
      'Material' => 'Kuningan / PVC',
    ),
  ),
  51 => 
  array (
    'title' => 'Gate Valve',
    'category' => 'Alat Teknisi',
    'description' => 'Katup gerbang yang naik-turun perlahan untuk membuka aliran, cocok untuk jalur utama agar tidak terjadi water hammer.',
    'attributes' => 
    array (
      'Sistem' => 'On/Off Slow',
      'Resistansi' => 'Rendah',
      'Grade' => 'Industrial',
    ),
  ),
  52 => 
  array (
    'title' => 'Check Valve',
    'category' => 'Alat Teknisi',
    'description' => 'Katup satu arah yang hanya memperbolehkan air mengalir ke satu sisi dan menutup otomatis saat air berbalik.',
    'attributes' => 
    array (
      'Fungsi' => 'Anti-Backflow',
      'Tipe' => 'Swing / Spring',
      'Aplikasi' => 'Output Pompa',
    ),
  ),
  53 => 
  array (
    'title' => 'Float Valve',
    'category' => 'Alat Teknisi',
    'description' => 'Klep pelampung yang menutup otomatis saat level air di toren penuh, mencegah air meluber sia-sia.',
    'attributes' => 
    array (
      'Material' => 'Plastic / Brass',
      'Sensitivitas' => 'Tinggi',
      'Kegunaan' => 'Tandon Air',
    ),
  ),
  54 => 
  array (
    'title' => 'Pressure Reducer',
    'category' => 'Alat Teknisi',
    'description' => 'Alat untuk menurunkan tekanan air yang terlalu tinggi dari supplier (PDAM) agar tidak merusak instalasi pipa rumah.',
    'attributes' => 
    array (
      'Input' => 'High Pressure',
      'Output' => 'Stable 2-3 Bar',
      'Keamanan' => 'Sangat Penting',
    ),
  ),
  55 => 
  array (
    'title' => 'Pompa Pendorong',
    'category' => 'Alat Teknisi',
    'description' => 'Booster Pump, pompa yang dipasang di jalur distribusi untuk menambah tekanan air pada shower dan kran.',
    'attributes' => 
    array (
      'Fitur' => 'Auto Flow Switch',
      'Silent' => 'Lapis Peredam',
      'Power' => '125W - 500W',
    ),
  ),
  56 => 
  array (
    'title' => 'Pompa Celup',
    'category' => 'Alat Teknisi',
    'description' => 'Submersible Pump, pompa yang diletakkan di dalam air (sumur atau basement) untuk membuang genangan atau banjir.',
    'attributes' => 
    array (
      'Lokasi' => 'Terendam Air',
      'Cooling' => 'Water Cooled',
      'Float' => 'Integrated Switch',
    ),
  ),
  57 => 
  array (
    'title' => 'Air Release Valve',
    'category' => 'Alat Teknisi',
    'description' => 'Katup otomatis untuk membuang udara yang terjebak di dalam pipa agar aliran air tetap stabil dan tidak tersendat.',
    'attributes' => 
    array (
      'Fungsi' => 'Air Bleeding',
      'Penempatan' => 'Titik Tertinggi Pipa',
      'Material' => 'Nylon / Metal',
    ),
  ),
  58 => 
  array (
    'title' => 'Pompa Limbah',
    'category' => 'Alat Teknisi',
    'description' => 'Sewage Pump, pompa khusus yang mampu mencacah kotoran padat agar bisa dipompa ke sistem pembuangan yang lebih tinggi.',
    'attributes' => 
    array (
      'Blade' => 'Grinder / Cutter',
      'Solids' => 'Up to 50mm',
      'Tipe' => 'Heavy Duty',
    ),
  ),
  59 => 
  array (
    'title' => 'Expansion Tank',
    'category' => 'Alat Teknisi',
    'description' => 'Tangki tekanan kecil untuk meredam lonjakan tekanan air panas maupun dingin agar pompa tidak sering hidup-mati.',
    'attributes' => 
    array (
      'Membran' => 'Butyl Rubber',
      'Pre-Charge' => 'Nitrogen / Air',
      'Fungsi' => 'Pump Ciclyng Reduction',
    ),
  ),
  60 => 
  array (
    'title' => 'Elbow',
    'category' => 'Material Pipa',
    'description' => 'Fitting berbentuk tikungan (L) untuk mengubah arah laju aliran pipa 45 atau 90 derajat.',
    'attributes' => 
    array (
      'Sudut' => '45 / 90 Derajat',
      'Jenis' => 'Plain / Threaded',
      'Material' => 'Match with Pipe',
    ),
  ),
  61 => 
  array (
    'title' => 'Tee',
    'category' => 'Material Pipa',
    'description' => 'Fitting berbentuk huruf T untuk membuat percabangan jalur pipa menjadi dua arah yang berbeda.',
    'attributes' => 
    array (
      'Bentuk' => 'T-Shape',
      'Tipe' => 'Equal / Reducing',
      'Cabang' => 'Single',
    ),
  ),
  62 => 
  array (
    'title' => 'Socket',
    'category' => 'Material Pipa',
    'description' => 'Penyambung lurus untuk menghubungkan dua batang pipa yang memiliki diameter sama.',
    'attributes' => 
    array (
      'Bentuk' => 'Straight',
      'Connection' => 'Slip / Glue',
      'Symmetry' => 'Equal',
    ),
  ),
  63 => 
  array (
    'title' => 'Reducer',
    'category' => 'Material Pipa',
    'description' => 'Fitting untuk menghubungkan dua pipa yang memiliki ukuran diameter berbeda (dari besar ke kecil).',
    'attributes' => 
    array (
      'Transisi' => 'Size Change',
      'Tipe' => 'Concentric / Eccentric',
      'Fungsi' => 'Velocity Control',
    ),
  ),
  64 => 
  array (
    'title' => 'Union',
    'category' => 'Material Pipa',
    'description' => 'Alat penyambung pipa yang bisa dilepas-pasang dengan mudah tanpa harus memotong pipa, sangat berguna untuk pemeliharaan pompa.',
    'attributes' => 
    array (
      'Maintenance' => 'Quick Disconnect',
      'Seal' => 'O-Ring',
      'Tujuan' => 'Serviceability',
    ),
  ),
  65 => 
  array (
    'title' => 'Flange',
    'category' => 'Material Pipa',
    'description' => 'Piringan logam atau plastik di ujung pipa untuk menyambungkan dua sistem pipa menggunakan baut dan gasket.',
    'attributes' => 
    array (
      'Sistem' => 'Bolted Connection',
      'Seal' => 'Gasket Required',
      'Grade' => 'Heavy Industrial',
    ),
  ),
  66 => 
  array (
    'title' => 'Cross',
    'category' => 'Material Pipa',
    'description' => 'Fitting berbentuk salib (+) yang membagi aliran air menjadi tiga arah percabangan sekaligus.',
    'attributes' => 
    array (
      'Bentuk' => 'X-Shape',
      'Cabang' => 'Triple',
      'Aplikasi' => 'Multi-Distribution',
    ),
  ),
  67 => 
  array (
    'title' => 'Plug',
    'category' => 'Material Pipa',
    'description' => 'Penutup ujung pipa dengan sistem ulir (drat) luar untuk menutup jalur pipa secara permanen atau sementara.',
    'attributes' => 
    array (
      'Bentuk' => 'Male Thread',
      'Fungsi' => 'End Sealing',
      'Removable' => 'Yes',
    ),
  ),
  68 => 
  array (
    'title' => 'Cap',
    'category' => 'Material Pipa',
    'description' => 'Penutup ujung pipa dengan sistem slip (lem) atau ulir dalam untuk mengakhiri sebuah jalur instalasi.',
    'attributes' => 
    array (
      'Bentuk' => 'Female / Slip',
      'Fungsi' => 'Terminal Point',
      'Material' => 'PVC / Brass',
    ),
  ),
  69 => 
  array (
    'title' => 'Bush',
    'category' => 'Material Pipa',
    'description' => 'Fitting sisipan untuk mengubah ukuran drat pada kran atau sambungan pipa lainnya.',
    'attributes' => 
    array (
      'Tipe' => 'Bushing Reducer',
      'Drat' => 'Outer/Inner Thread',
      'Versatility' => 'Adaptor',
    ),
  ),
  70 => 
  array (
    'title' => 'Y-strainer',
    'category' => 'Spesialis',
    'description' => 'Penyaring kotoran fisik berwujud huruf Y yang melindungi pompa dan kran dari pasir atau serpihan logam.',
    'attributes' => 
    array (
      'Mesh' => 'Stainless Screen',
      'Maintenance' => 'Flush Port',
      'Position' => 'Inlet Line',
    ),
  ),
  71 => 
  array (
    'title' => 'Seal Tape',
    'category' => 'Spesialis',
    'description' => 'Isolasi tipis putih dari bahan PTFE yang dililitkan pada drat pipa untuk mencegah kebocoran air.',
    'attributes' => 
    array (
      'Material' => 'PTFE',
      'Fungsi' => 'Thread Sealing',
      'Tahan_Kimia' => 'Sangat Baik',
    ),
  ),
  72 => 
  array (
    'title' => 'Lem Pipa',
    'category' => 'Spesialis',
    'description' => 'Solvent cement khusus yang melarutkan sebagian permukaan PVC agar kedua bagian menyatu secara molekuler (bersenyawa).',
    'attributes' => 
    array (
      'Setting_Time' => '15 - 30 Detik',
      'Kekuatan' => 'Maksimal setelah 2 Jam',
      'Warna' => 'Clear / Blue',
    ),
  ),
  73 => 
  array (
    'title' => 'Rubber Gasket',
    'category' => 'Spesialis',
    'description' => 'Karet penyekat yang dipasang di antara dua flange atau sambungan baut untuk memastikan tidak ada celah air.',
    'attributes' => 
    array (
      'Material' => 'EPDM / NBR',
      'Elastisitas' => 'Tinggi',
      'Ketebalan' => '2mm - 5mm',
    ),
  ),
  74 => 
  array (
    'title' => 'P-trap Koper',
    'category' => 'Spesialis',
    'description' => 'Trap khusus wastafel mewah yang terbuat dari kuningan berlapis krom, memberikan nilai estetika tinggi.',
    'attributes' => 
    array (
      'Visual' => 'Glossy Chrome',
      'Material' => 'Brass',
      'Cleaning' => 'Bottom Plug',
    ),
  ),
  75 => 
  array (
    'title' => 'Clean Out',
    'category' => 'Spesialis',
    'description' => 'Titik bukaan dengan penutup drat di jalur pipa drainase untuk akses memasukkan kabel mesin spiral.',
    'attributes' => 
    array (
      'Akses' => 'Easy Open',
      'Ukuran' => '3 - 4 Inch',
      'Lokasi' => 'Setiap 10-15 Meter',
    ),
  ),
  76 => 
  array (
    'title' => 'Floor Sink',
    'category' => 'Spesialis',
    'description' => 'Bak cuci yang tertanam di lantai, biasanya di dapur komersial, untuk menampung buangan air dari mesin es atau prep-sink.',
    'attributes' => 
    array (
      'Kapasitas' => 'Deep Basin',
      'Grate' => 'Heavy Duty Metal',
      'Material' => 'Cast Iron / Porcelain',
    ),
  ),
  77 => 
  array (
    'title' => 'Grease Interceptor',
    'category' => 'Spesialis',
    'description' => 'Versi raksasa dari grease trap yang ditanam di luar gedung, mampu memisahkan lemak dalam volume ribuan liter.',
    'attributes' => 
    array (
      'Sektor' => 'Komersial (Restoran Besar)',
      'Maintenance' => 'Vacuum Truck Service',
      'Retention' => 'High Capacity',
    ),
  ),
  78 => 
  array (
    'title' => 'Vacuum Breaker',
    'category' => 'Spesialis',
    'description' => 'Alat pengaman yang mencegah air tersedot kembali ke pipa bersih saat terjadi penurunan tekanan mendadak.',
    'attributes' => 
    array (
      'Safety' => 'Anti-Siphon',
      'Mekanisme' => 'Air Gap',
      'Aplikasi' => 'Kran Taman / Irigasi',
    ),
  ),
  79 => 
  array (
    'title' => 'Water Meter',
    'category' => 'Spesialis',
    'description' => 'Alat ukur volume penggunaan air yang lewat dalam galon atau meter kubik, dasar penagihan biaya air.',
    'attributes' => 
    array (
      'Akurasi' => 'Meter Log',
      'Material' => 'Bronze / Plastic',
      'Dial' => 'Analog / Digital',
    ),
  ),
  80 => 
  array (
    'title' => 'Hydrostatic Pump',
    'category' => 'Spesialis',
    'description' => 'Pompa tangan untuk menekan air ke sistem pipa tertutup guna mendeteksi kebocoran melalui penurunan jarum manometer.',
    'attributes' => 
    array (
      'Pressure' => 'Adjustable',
      'Tujuan' => 'Leak Hunting',
      'Portable' => 'Yes',
    ),
  ),
  81 => 
  array (
    'title' => 'Pipe Tracer',
    'category' => 'Spesialis',
    'description' => 'Alat elektronik untuk melacak jalur pipa yang tertanam di dalam tanah atau dinding tanpa membongkar.',
    'attributes' => 
    array (
      'Sinyal' => 'Electromagnetic',
      'Kedalaman' => 'Hingga 3 Meter',
      'Ketepatan' => 'Sangat Tinggi',
    ),
  ),
  82 => 
  array (
    'title' => 'Smoke Test',
    'category' => 'Spesialis',
    'description' => 'Metode pengujian kebocoran gas metana pada saluran limbah dengan meniupkan asap ke dalam sistem.',
    'attributes' => 
    array (
      'Visual' => 'Smoky Output',
      'Tujuan' => 'Gas Odor Detection',
      'Status' => 'Professional Grade',
    ),
  ),
  83 => 
  array (
    'title' => 'Jetter Hose',
    'category' => 'Spesialis',
    'description' => 'Selang khusus tekanan tinggi dengan ujung nozzle berlubang laser yang mampu mendorong dirinya sendiri ke dalam pipa.',
    'attributes' => 
    array (
      'Tekanan' => 'Maks 10.000 PSI',
      'Nozzle' => 'Rear Jet Propelled',
      'Flex' => 'Reinforced Steel',
    ),
  ),
  84 => 
  array (
    'title' => 'Root Cutter',
    'category' => 'Spesialis',
    'description' => 'Mata pisau bergigi yang dipasang pada ujung mesin spiral untuk memotong akar pohon yang masuk ke dalam pipa.',
    'attributes' => 
    array (
      'Action' => 'Sawing / Cutting',
      'Target' => 'Root Intrusion',
      'Sharpness' => 'Extremely Sharp',
    ),
  ),
  85 => 
  array (
    'title' => 'Bio Ball',
    'category' => 'Spesialis',
    'description' => 'Media plastik berongga tempat bersarangnya bakteri pengurai di dalam sistem bio septic tank.',
    'attributes' => 
    array (
      'Luas_Permukaan' => 'Maksimal',
      'Life_Span' => 'Permanen',
      'Fungsi' => 'Bacterial House',
    ),
  ),
  86 => 
  array (
    'title' => 'Chlorine Injector',
    'category' => 'Spesialis',
    'description' => 'Alat untuk menyuntikkan kaporit secara otomatis ke aliran air bersih guna membunuh kuman dan bakteri.',
    'attributes' => 
    array (
      'Sistem' => 'Automatic Dosing',
      'Higiene' => 'Sanitization',
      'Adjustable' => 'PPM Levels',
    ),
  ),
  87 => 
  array (
    'title' => 'Sand Filter',
    'category' => 'Spesialis',
    'description' => 'Tabung filter berisi pasir silika untuk menyaring partikel kasar, lumpur, dan kekeruhan pada air tanah.',
    'attributes' => 
    array (
      'Media' => 'Silica Sand',
      'Backwash' => 'Manual / Auto Valve',
      'Body' => 'FRP / Stainless',
    ),
  ),
  88 => 
  array (
    'title' => 'Carbon Filter',
    'category' => 'Spesialis',
    'description' => 'Filter berisi karbon aktif untuk menyerap bau kaporit, rasa logam, dan polutan kimia pada air.',
    'attributes' => 
    array (
      'Media' => 'Activated Carbon',
      'Fungsi' => 'Odor Removal',
      'Maintenance' => 'Isi Ulang 1-2 Tahun',
    ),
  ),
  89 => 
  array (
    'title' => 'Manganese Filter',
    'category' => 'Spesialis',
    'description' => 'Filter khusus untuk menetralisir kandungan zat besi dan mangan yang menyebabkan air berwarna kuning atau berminyak.',
    'attributes' => 
    array (
      'Penyebab' => 'Iron & Manganese',
      'Visual' => 'Yellowish Water Solution',
      'Efficiency' => 'High',
    ),
  ),
  90 => 
  array (
    'title' => 'Pompa Jet Pump',
    'category' => 'Spesialis',
    'description' => 'Pompa air sumur dalam yang menggunakan sistem ejector untuk menghisap air dari kedalaman lebih dari 9 meter.',
    'attributes' => 
    array (
      'Kedalaman' => '20 - 50 Meter',
      'Pipa' => 'Double Pipe (Suction & Jet)',
      'Daya' => '250W - 1000W',
    ),
  ),
  91 => 
  array (
    'title' => 'Pompa Semi Jet',
    'category' => 'Spesialis',
    'description' => 'Pompa sumur dangkal yang memiliki daya dorong lebih kuat dibanding pompa biasa, cocok untuk distribusi rumah 2 lantai.',
    'attributes' => 
    array (
      'Kedalaman' => '9 - 11 Meter',
      'Daya_Dorong' => 'Kuat',
      'Pressure' => 'Stable',
    ),
  ),
  92 => 
  array (
    'title' => 'Foot Valve',
    'category' => 'Spesialis',
    'description' => 'Tusen Klep, katup satu arah di ujung pipa hisap pompa yang menjaga agar air tidak turun kembali ke sumur (pancingan tetap isi).',
    'attributes' => 
    array (
      'Fungsi' => 'Priming Retention',
      'Material' => 'Brass / PVC',
      'Feature' => 'Built-in Strainer',
    ),
  ),
  93 => 
  array (
    'title' => 'Automatic Switch',
    'category' => 'Spesialis',
    'description' => 'Otomatis pompa yang bekerja berdasarkan tekanan air (pressure switch) atau aliran air (flow switch).',
    'attributes' => 
    array (
      'Tipe' => 'Pressure / Flow',
      'Durability' => 'Heavy Duty Contact',
      'Adjustment' => 'On/Off Pressure Range',
    ),
  ),
  94 => 
  array (
    'title' => 'Radar Air',
    'category' => 'Spesialis',
    'description' => 'Saklar pelampung elektrik yang dipasang di dalam toren untuk menghidupkan dan mematikan pompa air secara otomatis.',
    'attributes' => 
    array (
      'Mechanic' => 'Double Weighted Ball',
      'Safety' => 'Isolated Circuit',
      'Life' => 'Long Lasting',
    ),
  ),
  95 => 
  array (
    'title' => 'Shock Drat Luar',
    'category' => 'Spesialis',
    'description' => 'Fitting socket PVC yang salah satu ujungnya memiliki ulir (drat) keluar untuk menyambung ke kran atau fitting logam.',
    'attributes' => 
    array (
      'Thread' => 'Male',
      'Socket' => 'Glue Joint',
      'Material' => 'PVC AW Class',
    ),
  ),
  96 => 
  array (
    'title' => 'Shock Drat Dalam',
    'category' => 'Spesialis',
    'description' => 'Fitting socket PVC dengan ulir dalam, biasanya digunakan sebagai titik akhir untuk pemasangan kran air.',
    'attributes' => 
    array (
      'Thread' => 'Female',
      'Strong' => 'Usually Brass Reinforced',
      'Application' => 'Faucet Point',
    ),
  ),
  97 => 
  array (
    'title' => 'Double Nipple',
    'category' => 'Spesialis',
    'description' => 'Penyambung pendek dengan ulir luar di kedua ujungnya untuk menghubungkan dua fitting yang memiliki ulir dalam.',
    'attributes' => 
    array (
      'Shape' => 'Hexagonal Middle',
      'Material' => 'Brass / PVC / Stainless',
      'Function' => 'Male-to-Male Link',
    ),
  ),
  98 => 
  array (
    'title' => 'Water Mur',
    'category' => 'Spesialis',
    'description' => 'Satu set penyambung pipa yang terdiri dari tiga bagian, memungkinkan pelepasan sambungan hanya dengan memutar mur besar di tengah.',
    'attributes' => 
    array (
      'Utility' => 'Disconnection Kit',
      'Ease' => 'No Cutting Required',
      'Seal' => 'Conical / O-Ring',
    ),
  ),
  99 => 
  array (
    'title' => 'Clamping Saddle',
    'category' => 'Spesialis',
    'description' => 'Fitting berbentuk pelana untuk membuat percabangan baru pada pipa utama yang sudah terpasang tanpa memutus pipa tersebut.',
    'attributes' => 
    array (
      'Application' => 'Tapping Branch',
      'Seal' => 'Rubber Saddle',
      'Fastening' => 'Bolted',
    ),
  ),
  100 => 
  array (
    'title' => 'Expansion Joint',
    'category' => 'Spesialis',
    'description' => 'Sambungan pipa fleksibel yang bisa memanjang-memendek untuk meredam pemuaian pipa akibat perubahan suhu ekstrem.',
    'attributes' => 
    array (
      'Material' => 'EPDM / Stainless Bellows',
      'Fungsi' => 'Thermal Expansion',
      'Stress' => 'Absorber',
    ),
  ),
  101 => 
  array (
    'title' => 'Mechanical Joint',
    'category' => 'Spesialis',
    'description' => 'Sistem penyambungan pipa tanpa lem, menggunakan ring karet dan mur pengunci, sangat umum pada pipa HDPE ukuran kecil.',
    'attributes' => 
    array (
      'Type' => 'Compression Fitting',
      'Seal' => 'Grip Ring',
      'Reusable' => 'Yes',
    ),
  ),
  102 => 
  array (
    'title' => 'Electro Fusion',
    'category' => 'Spesialis',
    'description' => 'Teknologi penyambungan HDPE tercanggih menggunakan fitting yang memiliki kawat pemanas di dalamnya.',
    'attributes' => 
    array (
      'Control' => 'Computerized Barcode',
      'Strength' => 'Molecular Fusion',
      'Usage' => 'Gas & Critical Water',
    ),
  ),
  103 => 
  array (
    'title' => 'Butt Fusion',
    'category' => 'Spesialis',
    'description' => 'Metode menyatukan dua ujung pipa HDPE dengan memanaskan kedua permukaannya lalu menekan keduanya hingga menyatu.',
    'attributes' => 
    array (
      'Tools' => 'Heating Plate',
      'Integrity' => 'Same Strength as Pipe',
      'Aplikasi' => 'Large Diameter Pipe',
    ),
  ),
  104 => 
  array (
    'title' => 'Solvent Cement',
    'category' => 'Spesialis',
    'description' => 'Cairan perekat pipa PVC yang bekerja dengan cara mengelas dingin permukaan pipa agar menyatu secara kimiawi.',
    'attributes' => 
    array (
      'Chemical' => 'THF / Methyl Ethyl Ketone',
      'Bond' => 'Permanent',
      'Viscosity' => 'Medium Body',
    ),
  ),
  105 => 
  array (
    'title' => 'Drain Cleaner Liquid',
    'category' => 'Spesialis',
    'description' => 'Cairan pembersih mampet berbasis asam atau basa kuat, harus digunakan dengan sangat hati-hati agar tidak merusak pipa PVC.',
    'attributes' => 
    array (
      'Chemical' => 'Sulfuric Acid / Soda Api',
      'Danger' => 'Corrosive',
      'Warning' => 'Can Damage Old PVC',
    ),
  ),
  106 => 
  array (
    'title' => 'Soda Api',
    'category' => 'Spesialis',
    'description' => 'Sodium Hidroksida (NaOH), zat kimia yang sering digunakan untuk melarutkan lemak di saluran, namun beresiko membuat pipa PVC meleyot.',
    'attributes' => 
    array (
      'Heat' => 'Highly Exothermic',
      'State' => 'Flakes / Powder',
      'Risk' => 'Pipe Deformation',
    ),
  ),
  107 => 
  array (
    'title' => 'Bak Cuci Piring',
    'category' => 'Spesialis',
    'description' => 'Kitchen Sink, titik awal utama limbah domestik yang mengandung lemak tinggi, memerlukan perawatan trap rutin.',
    'attributes' => 
    array (
      'Drain' => 'Large Basket',
      'P trap' => 'Essential',
      'Noise' => 'Deadened',
    ),
  ),
  108 => 
  array (
    'title' => 'Toilet Wax Ring',
    'category' => 'Spesialis',
    'description' => 'Gasket lilin yang diletakkan di bawah closet duduk untuk memastikan tidak ada kebocoran air dan gas di sambungan lantai.',
    'attributes' => 
    array (
      'Material' => 'Wax / Rubber',
      'Function' => 'Gas & Liquid Seal',
      'Life' => 'One-time Use',
    ),
  ),
  109 => 
  array (
    'title' => 'Closet Flange',
    'category' => 'Spesialis',
    'description' => 'Fitting lantai tempat closet duduk dibautkan, menyediakan sambungan kedap air antara kshoset dan pipa PVC 4 inch.',
    'attributes' => 
    array (
      'Diameter' => '4 Inch',
      'Anchor' => 'Bolt Slots',
      'Material' => 'PVC / Brass',
    ),
  ),
  110 => 
  array (
    'title' => 'Urinal Sensor',
    'category' => 'Spesialis',
    'description' => 'Sistem kran otomatis menggunakan sensor infrared untuk membilas urinal setelah digunakan, meningkatkan higienitas.',
    'attributes' => 
    array (
      'Sensor' => 'Infrared',
      'Power' => 'Battery / AC Adapter',
      'Efficiency' => 'Water Saving',
    ),
  ),
  111 => 
  array (
    'title' => 'Auto Air Vent',
    'category' => 'Spesialis',
    'description' => 'Kran pembuangan udara otomatis untuk radiator atau sistem air panas agar tidak terjadi hambatan bantalan udara (air lock).',
    'attributes' => 
    array (
      'Action' => 'Continuous Bleeding',
      'Float' => 'Internal Mechanism',
      'Pressure' => 'Up to 10 Bar',
    ),
  ),
  112 => 
  array (
    'title' => 'Thermal Insulation',
    'category' => 'Spesialis',
    'description' => 'Pembungkus pipa (foam atau glasswool) untuk menjaga suhu air di dalam pipa ppr atau tembaga agar tidak boros energi.',
    'attributes' => 
    array (
      'Material' => 'Closed-Cell Foam',
      'UV' => 'Coated',
      'Purpose' => 'Heat Retention',
    ),
  ),
  113 => 
  array (
    'title' => 'Pipe Clamp',
    'category' => 'Spesialis',
    'description' => 'Gantungan atau klem besi untuk menahan posisi pipa agar tidak bergeser, berisik, atau melengkung karena beban air.',
    'attributes' => 
    array (
      'Material' => 'Galvanized Steel',
      'Lining' => 'Rubber Anti-Vibration',
      'Mount' => 'Threaded Rod',
    ),
  ),
  114 => 
  array (
    'title' => 'Hammer Arrestor',
    'category' => 'Spesialis',
    'description' => 'Tabung kecil berisi bantalan udara yang menyerap kejutan air saat kran ditutup, mencegah pipa pecah.',
    'attributes' => 
    array (
      'Fungsi' => 'Shock Absorber',
      'Spring' => 'Piston Loaded',
      'Standard' => 'PDI-WH 201',
    ),
  ),
  115 => 
  array (
    'title' => 'Mixing Valve',
    'category' => 'Spesialis',
    'description' => 'Keran pencampur yang menggabungkan air panas dan dingin untuk mencapai suhu mandi yang diinginkan secara presisi.',
    'attributes' => 
    array (
      'Tech' => 'Thermostatic',
      'Safety' => 'Anti-Scald',
      'Cartridge' => 'Ceramic',
    ),
  ),
  116 => 
  array (
    'title' => 'Pressure Gauge',
    'category' => 'Spesialis',
    'description' => 'Manometer, alat jarum penunjuk yang menampilkan besaran tekanan air di dalam sistem pipa secara real-time.',
    'attributes' => 
    array (
      'Unit' => 'Bar / PSI',
      'Dial' => 'Analog',
      'Range' => '0 - 16 Bar',
    ),
  ),
  117 => 
  array (
    'title' => 'Float Switch',
    'category' => 'Spesialis',
    'description' => 'Saklar pelampung kabel untuk pompa celup yang secara otomatis mematikan pompa ketika air di bak penampungan habis.',
    'attributes' => 
    array (
      'Action' => 'Empty / Fill',
      'Cable' => 'Neoprene / PVC',
      'Load' => 'Up to 16A',
    ),
  ),
  118 => 
  array (
    'title' => 'T-manifold',
    'category' => 'Spesialis',
    'description' => 'Pipa kolektor dengan banyak percabangan untuk membagi air ke berbagai ruangan dari satu titik distribusi pusat.',
    'attributes' => 
    array (
      'Ports' => '2 - 12 Outlets',
      'Material' => 'PEX / Brass',
      'Control' => 'Individual Valves',
    ),
  ),
  119 => 
  array (
    'title' => 'Pumping Station',
    'category' => 'Spesialis',
    'description' => 'Rumah pompa yang berisi rangkaian pompa besar untuk mendistribusikan air atau membuang limbah dalam skala satu wilayah.',
    'attributes' => 
    array (
      'Complexity' => 'System Grade',
      'Panels' => 'Smart Inverter / VFD',
      'Redundancy' => 'N+1',
    ),
  ),
  120 => 
  array (
    'title' => 'Sifon',
    'category' => 'Spesialis',
    'description' => 'Perangkap air berbentuk leher angsa di bawah wastafel yang berfungsi mencegah gas berbau dari saluran masuk ke ruangan.',
    'attributes' => 
    array (
      'Tipe' => 'Bottle / P-Trap',
      'Material' => 'PVC / Brass',
      'Fungsi' => 'Odor Seal',
    ),
  ),
  121 => 
  array (
    'title' => 'Flexible Hose',
    'category' => 'Spesialis',
    'description' => 'Selang lentur berlapis anyaman stainless steel untuk menghubungkan pipa suplai air ke kran atau tangki closet.',
    'attributes' => 
    array (
      'Panjang' => '30 - 60 cm',
      'Material' => 'EPDM with SS Braiding',
      'Koneksi' => 'Nut 1/2 Inch',
    ),
  ),
  122 => 
  array (
    'title' => 'Silikon Sealant',
    'category' => 'Spesialis',
    'description' => 'Bahan pengisi celah elastis yang digunakan untuk menyumbat sambungan antara plumbing fixture dengan dinding atau lantai.',
    'attributes' => 
    array (
      'Sifat' => 'Waterproof & Antijamur',
      'Base' => 'Acetic / Neutral',
      'Warna' => 'Clear / White',
    ),
  ),
  123 => 
  array (
    'title' => 'Pipa Conduit',
    'category' => 'Spesialis',
    'description' => 'Pipa pelindung kabel listrik yang sering dipasang bersamaan dengan sistem plumbing pada area plafon atau dalam beton.',
    'attributes' => 
    array (
      'Penyebutan' => 'Pipa Listrik',
      'Material' => 'High Impact PVC',
      'Warna' => 'Putih / Abu-abu',
    ),
  ),
  124 => 
  array (
    'title' => 'Elbow 45',
    'category' => 'Spesialis',
    'description' => 'Fitting penyambung pipa untuk membelokkan aliran dengan sudut tumpul 45 derajat, lebih lancar dibanding elbow 90.',
    'attributes' => 
    array (
      'Sudut' => '45 Degree',
      'Hambatan' => 'Rendah',
      'Aliran' => 'Smooth Flow',
    ),
  ),
  125 => 
  array (
    'title' => 'Tee Equal',
    'category' => 'Spesialis',
    'description' => 'Cabang pipa berbentuk T dengan ketiga lubang memiliki diameter yang sama besar.',
    'attributes' => 
    array (
      'Bentuk' => 'Equal Tee',
      'Aplikasi' => 'Distribusi Cabang',
      'Standar' => 'SNI / JIS',
    ),
  ),
  126 => 
  array (
    'title' => 'Tee Reducing',
    'category' => 'Spesialis',
    'description' => 'Cabang pipa T di mana lubang cabangnya memiliki diameter lebih kecil dari jalur utamanya.',
    'attributes' => 
    array (
      'Fungsi' => 'Branch Connection',
      'Tipe' => 'Reducer Tee',
      'Efficiency' => 'Flow Control',
    ),
  ),
  127 => 
  array (
    'title' => 'Cross Equal',
    'category' => 'Spesialis',
    'description' => 'Fitting simpang empat yang membagi aliran ke empat arah dengan ukuran lubang yang seragam.',
    'attributes' => 
    array (
      'Bentuk' => '4-Way',
      'Symmetry' => 'Equal',
      'Aplikasi' => 'Header Pipe',
    ),
  ),
  128 => 
  array (
    'title' => 'Union Socket',
    'category' => 'Spesialis',
    'description' => 'Fitting penyambung lepasan dengan sistem lem (slip) yang memudahkan bongkar pasang tanpa pemotongan.',
    'attributes' => 
    array (
      'Maintenance' => 'Very Easy',
      'Sistem' => 'Water Mur Glue',
      'Kelas' => 'AW',
    ),
  ),
  129 => 
  array (
    'title' => 'Flange Blind',
    'category' => 'Spesialis',
    'description' => 'Piringan penutup (buta) yang digunakan untuk menutup ujung jalur pipa sistem flange secara permanen namun mudah dibuka.',
    'attributes' => 
    array (
      'Fungsi' => 'End Termination',
      'Sistem' => 'Bolted',
      'Rating' => 'ANSI / DIN / JIS',
    ),
  ),
  130 => 
  array (
    'title' => 'Gasket Spiral Wound',
    'category' => 'Spesialis',
    'description' => 'Gasket teknis tinggi dengan lilitan logam dan pengisi (filler) untuk sambungan flange tekanan tinggi dan suhu ekstrem.',
    'attributes' => 
    array (
      'Material' => 'SS316 / Graphite',
      'Rating' => 'Class 150 - 2500',
      'Aplikasi' => 'Industrial / Steam',
    ),
  ),
  131 => 
  array (
    'title' => 'Pressure Tank',
    'category' => 'Spesialis',
    'description' => 'Tangki tekan yang berfungsi menjaga kestabilan tekanan air dan memperpanjang umur pompa dengan mengurangi frekuensi start-stop.',
    'attributes' => 
    array (
      'Volume' => '19L - 1000L',
      'Membran' => 'Butyl',
      'Pre-Charge' => 'Nitrogen',
    ),
  ),
  132 => 
  array (
    'title' => 'Safety Valve',
    'category' => 'Spesialis',
    'description' => 'Katup pengaman yang akan terbuka secara otomatis jika tekanan dalam sistem melebihi batas aman guna mencegah ledakan pipa atau tangki.',
    'attributes' => 
    array (
      'Set_Pressure' => 'Adjustable',
      'Fungsi' => 'Overpressure Protection',
      'Media' => 'Water / Steam / Gas',
    ),
  ),
  133 => 
  array (
    'title' => 'Strainer Basket',
    'category' => 'Spesialis',
    'description' => 'Filter industri berukuran besar dengan wadah saringan berbentuk keranjang yang bisa dilepas untuk dibersihkan.',
    'attributes' => 
    array (
      'Capacity' => 'High Flow',
      'Mesh' => 'Stainless Steel',
      'Body' => 'Cast Iron / Steel',
    ),
  ),
  134 => 
  array (
    'title' => 'Water Meter Induk',
    'category' => 'Spesialis',
    'description' => 'Meteran air berukuran besar yang dipasang pada pipa utama untuk mencatat total konsumsi air satu gedung atau kawasan.',
    'attributes' => 
    array (
      'Ukuran' => '2 - 8 Inch',
      'Tipe' => 'Woltman',
      'Akurasi' => 'Class B / C',
    ),
  ),
  135 => 
  array (
    'title' => 'Pipa Sch 40',
    'category' => 'Spesialis',
    'description' => 'Pipa baja atau PVC dengan ketebalan dinding Schedule 40, standar umum untuk aplikasi perpipaan industri dan komersial.',
    'attributes' => 
    array (
      'Standar' => 'ASTM A53 / ASTM D1785',
      'Pressure' => 'Medium',
      'Dinding' => 'Standard Weight',
    ),
  ),
  136 => 
  array (
    'title' => 'Pipa Sch 80',
    'category' => 'Spesialis',
    'description' => 'Pipa dengan dinding lebih tebal dibanding SCH 40, digunakan untuk cairan kimia berbahaya atau tekanan yang lebih tinggi.',
    'attributes' => 
    array (
      'Durabilitas' => 'Ekstrem',
      'Pressure' => 'High',
      'Aplikasi' => 'Chemical / Industrial',
    ),
  ),
  137 => 
  array (
    'title' => 'Pipa Kelas Aw',
    'category' => 'Spesialis',
    'description' => 'Pipa PVC standar SNI kelas paling tebal yang mampu menahan tekanan air hingga 10 kg/cm2, ideal untuk jalur air bersih.',
    'attributes' => 
    array (
      'Working_Pressure' => '10 Bar',
      'Aplikasi' => 'Air Bersih',
      'Ketebalan' => 'Maksimal (SNI)',
    ),
  ),
  138 => 
  array (
    'title' => 'Pipa Kelas D',
    'category' => 'Spesialis',
    'description' => 'Pipa PVC standar SNI untuk aplikasi pembuangan air limbah (drainase) tanpa tekanan tinggi.',
    'attributes' => 
    array (
      'Working_Pressure' => '5 Bar',
      'Aplikasi' => 'Drainage / Air Hujan',
      'Budget' => 'Ekonomis',
    ),
  ),
  139 => 
  array (
    'title' => 'Grey Water',
    'category' => 'Spesialis',
    'description' => 'Air limbah domestik yang tidak mengandung kotoran manusia, seperti air bekas mandi dan cuci piring.',
    'attributes' => 
    array (
      'Sumber' => 'Shower / Sink',
      'Treatment' => 'Filtrasi / Recycling',
      'Beban' => 'Sabun & Lemak',
    ),
  ),
  140 => 
  array (
    'title' => 'Black Water',
    'category' => 'Spesialis',
    'description' => 'Air limbah yang mengandung kotoran manusia dari closet atau urinal, memerlukan pengolahan biologis di septic tank.',
    'attributes' => 
    array (
      'Sumber' => 'Toilet',
      'Treatment' => 'Anaerobic Digestion',
      'Resiko' => 'Patogen Tinggi',
    ),
  ),
  141 => 
  array (
    'title' => 'Vacuum Truck',
    'category' => 'Spesialis',
    'description' => 'Truk tangki spesialis yang dilengkapi pompa vacuum bertenaga besar untuk menyedot limbah septic tank atau lumpur saluran.',
    'attributes' => 
    array (
      'Kapasitas' => '3000L - 8000L',
      'Fungsi' => 'Sedot WC / Drain Cleaning',
      'Sistem' => 'Vacuum High Power',
    ),
  ),
  142 => 
  array (
    'title' => 'Roof Drain',
    'category' => 'Spesialis',
    'description' => 'Saringan saluran air di dak beton atau atap gedung yang dirancang untuk mencegah sampah daun masuk ke pipa vertikal.',
    'attributes' => 
    array (
      'Bentuk' => 'Dome / Flat',
      'Material' => 'Cast Iron / Aluminium',
      'Fungsi' => 'Rainwater Outlet',
    ),
  ),
  143 => 
  array (
    'title' => 'Jet Washer',
    'category' => 'Spesialis',
    'description' => 'Semprotan air kecil (bidet spray) di samping closet yang digunakan untuk pembilasan setelah buang air.',
    'attributes' => 
    array (
      'Material' => 'ABS / Chrome',
      'Hose' => 'Flexible Spiral',
      'Operation' => 'Trigger Squeeze',
    ),
  ),
  144 => 
  array (
    'title' => 'Angle Valve',
    'category' => 'Spesialis',
    'description' => 'Stop kran kecil berbentuk siku yang biasanya dipasang di bawah wastafel untuk mengontrol aliran ke kran atau closet.',
    'attributes' => 
    array (
      'Inlet' => '1/2 Inch',
      'Outlet' => '1/2 Inch',
      'Material' => 'Chrome Brass',
    ),
  ),
  145 => 
  array (
    'title' => 'Stop Kran',
    'category' => 'Spesialis',
    'description' => 'Istilah umum untuk katup yang berfungsi menghentikan atau membuka aliran air pada titik tertentu dalam instalasi.',
    'attributes' => 
    array (
      'Fungsi' => 'Isolation Valve',
      'Aplikasi' => 'Rumah Tangga',
      'Mechanism' => 'Ball / Gate',
    ),
  ),
  146 => 
  array (
    'title' => 'Check Valve Swing',
    'category' => 'Spesialis',
    'description' => 'Katup satu arah dengan piringan yang berayun untuk menutup saat ada aliran balik, cocok untuk posisi horizontal.',
    'attributes' => 
    array (
      'Tipe' => 'Swing Check',
      'Hambatan' => 'Sangat Rendah',
      'Media' => 'Clear Water',
    ),
  ),
  147 => 
  array (
    'title' => 'Check Valve Spring',
    'category' => 'Spesialis',
    'description' => 'Katup satu arah yang menggunakan pegas untuk menutup piringan secara cepat, mencegah benturan water hammer.',
    'attributes' => 
    array (
      'Tipe' => 'Spring Loaded',
      'Posisi' => 'Vertical / Horizontal',
      'Resistansi' => 'Sedang',
    ),
  ),
  148 => 
  array (
    'title' => 'Foot Valve Brass',
    'category' => 'Spesialis',
    'description' => 'Tusen klep berbahan kuningan untuk pipa hisap pompa sumur dalam agar pancingan air tidak hilang.',
    'attributes' => 
    array (
      'Material' => 'Heavy Duty Brass',
      'Strainer' => 'Stainless Steel Mesh',
      'Kualitas' => 'Premium',
    ),
  ),
  149 => 
  array (
    'title' => 'Pipa Pex-al-pex',
    'category' => 'Spesialis',
    'description' => 'Pipa komposit Cross-linked Polyethylene dengan lapisan aluminium di tengahnya, tahan tekanan dan suhu sangat tinggi.',
    'attributes' => 
    array (
      'Lapisan' => 'Multilayer',
      'Tahan_Suhu' => 'Hingga 110 C',
      'Bentuk' => 'Roll / Koil',
    ),
  ),
  150 => 
  array (
    'title' => 'Sealant Tape',
    'category' => 'Spesialis',
    'description' => 'Plester perekat khusus untuk menambal kebocoran halus pada pipa atau tangki secara darurat.',
    'attributes' => 
    array (
      'Fungsi' => 'Emergency Leak Fix',
      'Material' => 'Rubber / Silicone',
      'Stretch' => 'High Elasticity',
    ),
  ),
  151 => 
  array (
    'title' => 'Pipe Bracket',
    'category' => 'Spesialis',
    'description' => 'Penyangga pipa yang menempel di dinding untuk memastikan pipa tetap lurus dan tidak melorot.',
    'attributes' => 
    array (
      'Material' => 'Galvanized Metal',
      'Sistem' => 'Dyna-bolt',
      'Size' => '1/2 - 4 Inch',
    ),
  ),
  152 => 
  array (
    'title' => 'Trap Door',
    'category' => 'Spesialis',
    'description' => 'Bukaan akses pada plafon atau dinding untuk memudahkan teknisi menjangkau pipa yang tertanam (pipa shaft).',
    'attributes' => 
    array (
      'Fungsi' => 'Maintenance Access',
      'Bentuk' => 'Hatch',
      'Material' => 'Gypsum / Aluminium',
    ),
  ),
);

        foreach ($entities as $entity) {
            WikiEntity::updateOrCreate(['title' => $entity['title']], $entity);
        }
    }
}
