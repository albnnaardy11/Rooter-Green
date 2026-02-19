<x-app-layout title="Galeri Kerja - Portofolio Jasa Saluran Mampet">
    
    {{-- 1. Unique Gallery Hero --}}
    <x-sections.gallery.hero />

    {{-- 2. New Unique Portfolio Showcase (Custom for this page) --}}
    <x-sections.gallery.portfolio :items="$projects" />

    {{-- 3. Final Engagement --}}
    <x-sections.tentang.cta />

</x-app-layout>
