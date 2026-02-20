<?php

namespace Database\Seeders;

use App\Models\WikiEntity;
use Illuminate\Database\Seeder;

class WikiEntitySeeder extends Seeder
{
    public function run(): void
    {
        $entities = [
            [
                'title' => 'Pipa PVC (Polyvinyl Chloride)',
                'category' => 'Material Pipa',
                'description' => 'Pipa PVC adalah jenis pipa plastik yang paling umum digunakan untuk sistem pembuangan air kotor dan air hujan. Keunggulannya adalah tahan korosi dan ringan.',
                'wikidata_id' => 'Q146338',
                'attributes' => [
                    'Massa_Jenis' => '1.38 g/cm3',
                    'Ketahanan_Suhu' => 'Hingga 60°C',
                    'Aplikasi_Utama' => 'Drainase, Limbah, Air Hujan',
                    'Standar_SNI' => 'SNI 06-0084-2002'
                ]
            ],
            [
                'title' => 'Spiral Pipe Cleaning Machine',
                'category' => 'Alat Teknisi',
                'description' => 'Mesin pembersih pipa dengan kabel spiral baja fleksibel yang mampu menembus sumbatan lemak, rambut, dan benda asing lainnya tanpa merusak dinding pipa.',
                'wikidata_id' => 'Q7211153',
                'attributes' => [
                    'Jangkauan_Kabel' => '20 - 50 Meter',
                    'Kapasitas_Diameter' => '2 - 6 Inchi',
                    'Tipe_Motor' => 'Electric High Torque',
                    'Fungsi' => 'Rooter Service'
                ]
            ],
            [
                'title' => 'Bak Kontrol (Check Chamber)',
                'category' => 'Infrastruktur',
                'description' => 'Titik akses pada saluran pembuangan yang digunakan untuk memeriksa aliran air dan memudahkan proses pembersihan jika terjadi penyumbatan di jalur utama.',
                'wikidata_id' => 'Q1861214',
                'attributes' => [
                    'Tipe' => 'Concrete / Plastic Overlay',
                    'Fungsi_SEO' => 'Maintenance Access Point',
                    'Dimensi_Ideal' => '40x40 cm atau 60x60 cm'
                ]
            ]
        ];

        foreach ($entities as $entity) {
            WikiEntity::create($entity);
        }
    }
}
