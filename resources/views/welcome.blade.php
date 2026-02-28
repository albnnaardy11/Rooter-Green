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
    <x-sections.services :services="$services" />

    {{-- 6. Gallery Section - Visual Proof of Completion --}}
    <x-sections.gallery :items="$projects" />

    {{-- 7. FAQ Section - Addressing Common Concerns --}}
    <x-sections.faq :faqs="$faqs" />

    {{-- 8. Coverage Section - Location Presence --}}
    <x-sections.coverage />

    {{-- Floating/Sticky Components --}}
    <x-sticky-footer />

</x-app-layout>
