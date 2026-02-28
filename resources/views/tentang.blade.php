<x-app-layout title="Tentang Kami - Solusi Jasa Saluran Pipa Mampet Premium">
    
    {{-- 1. Tentang Hero - The Vision Statement --}}
    <x-sections.tentang.hero />

    {{-- 2. Company Profile - History, Visi & Misi --}}
    <x-sections.tentang.profile />

    {{-- 3. Service Scope - Property Types Covered --}}
    <x-sections.tentang.scope />

    {{-- 4. Working Methodology - Techniques & Advantages --}}
    <x-sections.tentang.methodology />

    {{-- 5. FAQ Section - Detailed Information --}}
    <x-sections.tentang.faq-complex :categories="$categories" />



    {{-- 6. Final CTA --}}
    <x-sections.tentang.cta />

</x-app-layout>
