<section class="py-24 bg-white relative overflow-hidden">
    <!-- Background Accents (Landing DNA) -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <x-section-heading 
            title="Sektor Wilayah Pelayanan Kami" 
            subtitle="JABODETABEK & SEKITARNYA" 
            align="center" 
        />

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6 mt-16">
            @foreach([
                ['icon' => 'ri-home-8-fill', 'label' => 'Hunian Rumah', 'color' => 'primary'],
                ['icon' => 'ri-hotel-fill', 'label' => 'Apartemen', 'color' => 'accent'],
                ['icon' => 'ri-store-2-fill', 'label' => 'Ruko Bisnis', 'color' => 'primary'],
                ['icon' => 'ri-building-4-fill', 'label' => 'Gedung Kantor', 'color' => 'accent'],
                ['icon' => 'ri-building-fill', 'label' => 'Area Industri', 'color' => 'primary'],
                ['icon' => 'ri-restaurant-fill', 'label' => 'Resto & Cafe', 'color' => 'accent']
            ] as $item)
                <div class="group relative">
                    <div class="relative z-10 bg-stone-50/50 border border-gray-100 p-6 sm:p-8 rounded-[2rem] flex flex-col items-center gap-4 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 hover:bg-white">
                        <div @class([
                            'w-16 h-16 rounded-2xl flex items-center justify-center transition-all duration-500 shadow-lg',
                            'bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white group-hover:shadow-primary/30' => $item['color'] === 'primary',
                            'bg-accent/10 text-accent group-hover:bg-accent group-hover:text-white group-hover:shadow-accent/30' => $item['color'] === 'accent',
                        ])>
                            <i class="{{ $item['icon'] }} text-3xl"></i>
                        </div>
                        <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-secondary group-hover:text-primary transition-colors text-center leading-tight">{{ $item['label'] }}</span>
                    </div>
                    <!-- Ambient Glow Beneath Cards -->
                    <div @class([
                        'absolute inset-0 blur-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-700',
                        'bg-primary' => $item['color'] === 'primary',
                        'bg-accent' => $item['color'] === 'accent',
                    ])></div>
                </div>
            @endforeach
        </div>

        <!-- High-Impact CTA Button Only -->
        <div class="mt-24 text-center">
             <a href="https://wa.me/6281234567890" class="inline-flex items-center gap-6 bg-primary px-12 py-6 rounded-full shadow-2xl shadow-primary/40 hover:bg-secondary transition-all duration-500 group active:scale-95">
                <span class="text-white font-black text-sm sm:text-xl uppercase tracking-[0.2em]">Pesan Sekarang</span>
                <i class="ri-whatsapp-line text-white text-3xl transition-transform group-hover:scale-110 group-hover:rotate-12"></i>
             </a>
        </div>
    </div>
</section>
