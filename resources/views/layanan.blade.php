<x-app-layout title="Layanan Kami - Solusi Saluran Pipa Mampet & Plumbing">
    
    {{-- 1. Unique Service Hero --}}
    <x-sections.services.hero />

    {{-- 2. New Unique Service Catalog (Custom for this page) --}}
    <x-sections.services.catalog :services="$services" />

    {{-- 3. Methodology Reminder --}}
    <x-sections.tentang.methodology />

    {{-- 4. CTA --}}
    <x-sections.tentang.cta />

</x-app-layout>
