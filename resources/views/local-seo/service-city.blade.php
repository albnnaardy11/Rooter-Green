<x-app-layout>
<section class="relative pt-36 sm:pt-48 pb-40 overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-0 w-full h-full bg-slate-900"></div>
        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2070" class="absolute w-full h-full object-cover opacity-20 mix-blend-overlay" alt="Rooter Service {{ $city->name }}">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/50 via-slate-900 to-stone-50"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row gap-20 items-center">
            <div class="lg:w-2/3 text-center lg:text-left">
                <nav class="flex items-center justify-center lg:justify-start gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-white/50 mb-10">
                    <a href="{{ route('home') }}">Home</a>
                    <i class="ri-arrow-right-s-line"></i>
                    <a href="{{ route('local.city', $city->slug) }}">Layanan di {{ $city->name }}</a>
                    <i class="ri-arrow-right-s-line"></i>
                    <span class="text-primary">{{ $service->name }}</span>
                </nav>

                <h1 class="text-5xl md:text-7xl font-heading font-black text-white leading-[1.1] mb-8">
                    {{ $service->name }} <br><span class="text-primary italic">Handal</span> di {{ $city->name }}.
                </h1>

                <div class="p-8 rounded-[2rem] bg-white/5 backdrop-blur-xl border border-white/10 text-white/80 text-lg leading-relaxed mb-12">
                    <p class="mb-4">Masalah <strong>{{ $service->name }}</strong> di wilayah <strong>{{ $city->name }}</strong>? Kami teknisi lokal berpengalaman siap memberikan solusi tuntas tanpa bongkar lantai di area {{ $city->name }} dan sekitarnya.</p>
                </div>

                <!-- LSI Injector Cloud -->
                @if(!empty($lsiCloud))
                <div class="mb-12 flex flex-wrap justify-center lg:justify-start gap-2">
                    @foreach($lsiCloud as $tag)
                    <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-[9px] font-bold text-slate-400 uppercase tracking-widest hover:text-primary hover:border-primary/50 cursor-default transition-all">
                        {{ $tag }}
                    </span>
                    @endforeach
                </div>
                @endif

                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20RooterIn%20{{ $city->name }}%2C%20saya%20butuh%20{{ $service->name }}" 
                       onclick="trackWhatsAppClick('local-service-page')"
                       class="w-full sm:w-auto px-10 py-5 bg-primary text-white rounded-full font-black text-lg hover:bg-[#e65a00] hover:scale-105 transition-all shadow-2xl shadow-primary/30 text-center">
                        Panggil Teknisi Sekarang
                    </a>
                </div>
            </div>

            <div class="lg:w-1/3 w-full">
                <!-- Trust Architect: Localized Reviews -->
                <div class="space-y-6">
                    @foreach($cityReviews->take(3) as $review)
                    <div class="p-8 bg-white rounded-3xl shadow-xl border border-slate-100 transform {{ $loop->index % 2 == 0 ? 'translate-x-2' : '-translate-x-2' }}">
                        <div class="flex gap-1 text-primary text-xs mb-3">
                            @for($i=1;$i<=$review->rating;$i++) ★ @endfor
                        </div>
                        <p class="text-slate-600 italic text-sm mb-4">"{{ $review->review_text }}"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-black text-slate-400 text-[10px]">
                                {{ substr($review->customer_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-900 uppercase tracking-widest">{{ $review->customer_name }}</p>
                                <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">{{ $review->location_suburb ?: $city->name }} Client</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($cityReviews->isEmpty())
                    <div class="p-8 bg-white/5 border border-white/10 rounded-3xl text-center text-white/30 italic text-xs">
                        Be the first to trust RooterIn in {{ $city->name }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Technician Availability Map (Simulated) -->
<section class="py-32 bg-stone-50 overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row gap-20 items-center">
            <div class="lg:w-1/2">
                <span class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-4 inline-block">Sinyal Lokal Aktif</span>
                <h2 class="text-4xl font-heading font-black text-slate-900 mb-8 leading-tight">Teknisi Terdekat di {{ $city->name }}</h2>
                <p class="text-slate-500 leading-relaxed mb-10">Peta ini menunjukkan persebaran teknisi RooterIn yang sedang bertugas di area <strong>{{ $city->name }}</strong>. Kami menjamin kedatangan paling tepat waktu karena kedekatan tim lapangan kami dengan lokasi Anda.</p>
                
                <div class="flex items-center gap-6 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center text-green-600">
                        <i class="ri-pulse-line text-2xl animate-pulse"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-widest">3 Teknisi Standby di {{ $city->name }}</p>
                </div>
            </div>
            
            <div class="lg:w-1/2 w-full">
                <!-- Simulated Interactive Map -->
                <div class="relative aspect-video bg-slate-200 rounded-[3rem] overflow-hidden border-8 border-white shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=2070" class="w-full h-full object-cover opacity-50 grayscale" alt="Map">
                    <!-- Tech Pins -->
                    <div class="absolute top-1/4 left-1/3 w-8 h-8 flex items-center justify-center">
                        <span class="absolute w-full h-full bg-primary/40 rounded-full animate-ping"></span>
                        <i class="ri-map-pin-2-fill text-2xl text-primary relative"></i>
                    </div>
                    <div class="absolute bottom-1/3 right-1/4 w-8 h-8 flex items-center justify-center">
                        <span class="absolute w-full h-full bg-secondary/40 rounded-full animate-ping"></span>
                        <i class="ri-map-pin-2-fill text-2xl text-secondary relative"></i>
                    </div>
                    <div class="absolute top-1/2 left-1/2 w-8 h-8 flex items-center justify-center">
                        <span class="absolute w-full h-full bg-primary/40 rounded-full animate-ping"></span>
                        <i class="ri-map-pin-2-fill text-2xl text-primary relative"></i>
                    </div>
                    
                    <div class="absolute inset-0 flex items-center justify-center bg-slate-900/10 backdrop-blur-[2px]">
                        <div class="px-6 py-3 bg-white/90 rounded-full shadow-lg border border-slate-200 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            Live Local Signals: {{ $city->name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</x-app-layout>
