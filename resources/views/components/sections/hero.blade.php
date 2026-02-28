@props([
    'title' => 'Solusi Pintar <br> <span class="text-primary italic">Pipa Lancar</span> <br> Tanpa Bongkar!',
    'subtitle' => 'Trusted Eco-Plumbing Service',
    'locationTag' => \App\Models\Setting::get('address', 'Jawa & Sumatera'),
    'description' => 'Melayani dengan sepenuh hati di wilayah <span class="text-white font-bold">Jabodetabek, Bandung, Serang, Lampung, dan Metro.</span> Teknisi ahli, pengerjaan cepat, dan hasil maksimal.',
    'ctaText' => 'Pesan Sekarang - Plong!',
    'ctaLink' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp_number', '6281246668749')) . '?text=Halo%20Kak%2C%20mau%20order%20jasa%20dong',
    'featureImage' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&q=80&w=1200',
    'guaranteeTitle' => 'Garansi Kepuasan',
    'guaranteeDesc' => 'Pipa mampet mampet lagi dalam 7 hari? Kami perbaiki GRATIS tanpa biaya tambahan apapun.'
])

<section {{ $attributes->merge(['class' => 'relative bg-secondary min-h-[85vh] flex items-center overflow-hidden pt-36 sm:pt-44 lg:pt-48 pb-16 sm:pb-32']) }}>
    <!-- Modern Pattern Overlay -->
    <div class="absolute inset-0 z-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>
    <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-accent/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            <!-- Text Content -->
            <div class="lg:w-3/5 text-center lg:text-left">
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2 sm:gap-4 mb-4 sm:mb-8 animate-fade-in-up">
                    <div class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border border-primary/30 bg-primary/10 text-primary font-bold text-[9px] sm:text-xs uppercase tracking-[0.2em]">
                        {{ $subtitle }}
                    </div>
                    <div class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border border-white/10 bg-white/5 text-white/80 font-bold text-[9px] sm:text-xs uppercase tracking-[0.2em]">
                        <i class="ri-map-pin-2-fill mr-1 sm:mr-2 text-accent"></i>
                        {{ $locationTag }}
                    </div>
                </div>
                
                <h1 class="text-3xl sm:text-5xl md:text-7xl font-heading font-black text-white leading-[1.1] mb-6 sm:mb-8">
                    {!! $title !!}
                </h1>
                
                <p class="text-gray-300 text-lg sm:text-xl md:max-w-2xl mb-10 leading-relaxed font-medium">
                    {!! $description !!}
                </p>
                
                <div class="flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start">
                    <x-button href="{{ $ctaLink }}" variant="primary" class="relative z-10 !px-12 !py-6 shadow-2xl shadow-primary/40 !rounded-full overflow-hidden group/btn">
                        <span class="flex items-center gap-4">
                            <i class="ri-whatsapp-line text-2xl animate-bounce-soft"></i>
                            <span class="font-black uppercase tracking-widest text-sm lg:text-base">{{ $ctaText }}</span>
                            <i class="ri-arrow-right-line group-hover:translate-x-2 transition-transform duration-300"></i>
                        </span>
                        
                        <!-- Premium Shine Effect -->
                        <div class="absolute top-0 -left-full w-full h-full bg-white/20 skew-x-[45deg] group-hover/btn:left-[150%] transition-all duration-1000 ease-in-out"></div>
                    </x-button>
                </div>
            </div>

            <!-- Right Side Visual / Featured Card -->
            <div class="lg:w-2/5 relative animate-fade-in-up delay-150">
                <div class="relative w-full aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl group border-8 border-white/5">
                    <img src="{{ $featureImage }}" alt="Technician" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                    <div class="absolute inset-x-0 bottom-0 p-8 bg-gradient-to-t from-secondary via-secondary/20 to-transparent">
                        <div class="bg-white/10 backdrop-blur-xl p-6 rounded-3xl border border-white/20 shadow-2xl">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="ri-shield-check-fill text-white text-xl"></i>
                                </div>
                                <span class="text-white font-bold text-lg">{{ $guaranteeTitle }}</span>
                            </div>
                            <p class="text-gray-300 text-xs leading-relaxed">{{ $guaranteeDesc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Transition Curve (Improved Wave) -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0]">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-[80px] text-white fill-current">
            <path d="M0,0 C300,120 900,120 1200,0 L1200,120 L0,120 Z"></path>
        </svg>
    </div>
</section>
