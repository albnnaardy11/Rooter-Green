{{-- 
    ARCHITECTURE OVERVIEW:
    This landing page follows a High-Level Modular System.
    - SECTIONS: Located in components/sections/, these are top-level containers for page logic.
    - PARTS: Located in components/parts/ or core components/, these are reusable atomic/molecular elements.
    - DATA FLOW: All content data is defined here or in a config file and passed via props to maintain SRP.
--}}
@php
    $servicesData = [
        [
            'title' => 'Tembak Saluran Mampet',
            'desc' => 'Solusi cepat untuk pipa dapur, wastafel, dan kamar mandi mampet dengan teknik tekanan tinggi.',
            'img' => 'https://images.unsplash.com/photo-1585955123058-930415956a69?w=800&fit=crop',
            'color' => 'primary'
        ],
        [
            'title' => 'Rooter Spiral Cleaner',
            'desc' => 'Pembersihan kerak lemak dan kotoran keras menggunakan mesin spiral modern tanpa bongkar pipa.',
            'img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=800&fit=crop',
            'color' => 'accent'
        ],
        [
            'title' => 'Deteksi Kebocoran Pipa',
            'desc' => 'Teknologi sensor untuk menemukan titik bocor pipa dalam dinding atau lantai secara akurat.',
            'img' => 'https://images.unsplash.com/photo-1538474705339-e51de814eaa3?w=800&fit=crop',
            'color' => 'primary'
        ],
        [
            'title' => 'Kurasi & Sedot WC',
            'desc' => 'Layanan sedot septic tank dan pelancaran kloset mampet dengan armada bersih dan profesional.',
            'img' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800&fit=crop',
            'color' => 'accent'
        ],
        [
            'title' => 'Instalasi Jalur Baru',
            'desc' => 'Pemasangan pipa air bersih dan air kotor dengan standar teknik terbaik untuk hunian & gedung.',
            'img' => 'https://images.unsplash.com/photo-1541123437800-1bb1317badc2?w=800&fit=crop',
            'color' => 'primary'
        ],
        [
            'title' => 'Perawatan Berkala',
            'desc' => 'Layanan maintenance rutin untuk resto, hotel, dan pabrik agar alur pipa selalu lancar.',
            'img' => 'https://images.unsplash.com/photo-1581244276891-6bc617f77bc7?w=800&fit=crop',
            'color' => 'accent'
        ]
    ];
@endphp

<x-app-layout title="Jasa Saluran Mampet & Pipe Cleaning Premium">
    
    {{-- 1. Hero Section - Primary Entry Point --}}
    <x-sections.hero />

    {{-- 2. Trust Banner - Unique Selling Propositions --}}
    <x-sections.trust-banner />

    {{-- 3. Features Section - Problem Solver Explanation --}}
    <x-sections.features />

    {{-- 4. Mega CTA - Urgent Problem Engagement --}}
    <x-sections.cta-mega />

    {{-- 5. Services Section - Detailed Solutions Offering --}}
    <x-sections.services :services="$servicesData" />

    {{-- 6. Gallery Section - Visual Proof of Completion --}}
    <x-sections.gallery :items="[
        ['img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=800&fit=crop', 'title' => 'Pipa Dapur Mampet', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&fit=crop', 'title' => 'Saluran Air Kamar Mandi', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1521207418485-99c705420785?w=800&fit=crop', 'title' => 'Wastafel Kantor', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800&fit=crop', 'title' => 'Pengerjaan Rooter Spiral', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&fit=crop', 'title' => 'Pipa Mampet Gedung', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1525909002-1b05e0c869d8?w=800&fit=crop', 'title' => 'Wastafel Kembali Lancar', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&fit=crop', 'title' => 'Alat Modern Terbaru', 'category' => 'Specialized'],
        ['img' => 'https://images.unsplash.com/photo-1531973576160-7125cd663d86?w=800&fit=crop', 'title' => 'Kerja Tim Profesional', 'category' => 'Residential'],
        ['img' => 'https://images.unsplash.com/photo-1599661046289-e318878567c4?w=800&fit=crop', 'title' => 'Bongkar Kerak Lemak', 'category' => 'Commercial'],
        ['img' => 'https://images.unsplash.com/photo-1581244276891-6bc617f77bc7?w=800&fit=crop', 'title' => 'Inspeksi Pipa Endoscope', 'category' => 'Specialized'],
    ]" />

    {{-- 7. Coverage Section - Location Presence --}}
    <x-sections.coverage />

    {{-- Floating/Sticky Components --}}
    <x-sticky-footer />

</x-app-layout>
