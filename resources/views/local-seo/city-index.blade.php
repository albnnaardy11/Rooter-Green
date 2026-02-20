<x-app-layout>
<section class="relative pt-36 sm:pt-48 pb-40 overflow-hidden bg-slate-900 min-h-screen">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2029" class="w-full h-full object-cover opacity-20 grayscale brightness-50" alt="{{ $city->name }}">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-stone-50"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10 text-center lg:text-left">
        <div class="max-w-4xl mx-auto lg:mx-0">
            <nav class="flex items-center justify-center lg:justify-start gap-2 text-[10px] font-black uppercase tracking-[0.4em] text-white/40 mb-10">
                <a href="{{ route('home') }}">Home</a>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-primary italic">Layanan Area</span>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-white">{{ $city->name }}</span>
            </nav>

            <h1 class="text-5xl md:text-7xl font-heading font-black text-white leading-none mb-8">
                Pusat Solusi Pipa <br><span class="text-primary italic">Mampet</span> {{ $city->name }}.
            </h1>

            @if($city->fresh_headline)
            <div class="mb-10 px-6 py-4 bg-primary/10 border-l-4 border-primary rounded-r-2xl flex items-center gap-4">
                <i class="ri-notification-3-line text-primary text-xl animate-pulse"></i>
                <span class="text-xs font-black text-white uppercase tracking-widest">{{ $city->fresh_headline }}</span>
            </div>
            @endif
            
            <p class="text-xl text-slate-400 leading-relaxed mb-12 max-w-2xl">
                Rooterin hadir sebagai mitra terpercaya warga <strong>{{ $city->name }}</strong> untuk menangani saluran pipa mampet, wastafel tersumbat, dan pembersihan drainase dengan teknologi tercanggih tanpa bongkar.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-6">
                <a href="https://wa.me/6281234567890?text=Halo%20Admin%20RooterIn%20{{ $city->name }}%2C%20saya%20butuh%20bantuan%20pipa%20mampet" class="w-full sm:w-auto px-10 py-5 bg-primary text-white rounded-full font-black text-lg hover:bg-[#e65a00] hover:scale-105 transition-all shadow-2xl shadow-primary/30 text-center">
                    Hubungi Teknisi {{ $city->name }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Service Selection Grid -->
<section class="py-32 bg-stone-50">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row justify-between items-end mb-20 gap-8">
            <div class="max-w-2xl">
                <span class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-4 inline-block">Specialized Local Services</span>
                <h2 class="text-4xl font-heading font-black text-slate-900 mb-6 leading-tight">Layanan Kami di {{ $city->name }}</h2>
                <p class="text-slate-500 text-lg leading-relaxed">Tim ahli kami di {{ $city->name }} dibekali peralatan berstandar internasional untuk menjamin hasil maksimal.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
            <a href="{{ route('local.service', [$city->slug, $service->slug]) }}" class="group p-8 bg-white border border-slate-100 rounded-[2.5rem] hover:bg-secondary hover:border-secondary transition-all duration-500 shadow-sm hover:shadow-2xl">
                <div class="w-16 h-16 bg-stone-50 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-white/10 transition-colors">
                    <i class="ri-flashlight-fill text-2xl text-primary group-hover:text-white"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-900 group-hover:text-white mb-4 transition-colors">{{ $service->name }}</h3>
                <p class="text-slate-500 group-hover:text-white/70 leading-relaxed mb-8 transition-colors">Layanan spesialis {{ $service->name }} di seluruh area {{ $city->name }} dengan estimasi waktu kedatangan 30 menit.</p>
                <div class="flex items-center gap-3 text-secondary group-hover:text-white font-black text-xs uppercase tracking-widest transition-colors">
                    Cek Detail & Harga
                    <i class="ri-arrow-right-line group-hover:translate-x-2 transition-transform"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Trust Architect Section -->
<section class="py-32 bg-white overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-20">
            <div class="lg:w-1/2">
                <div class="relative">
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl"></div>
                    <img src="https://images.unsplash.com/photo-1542013936693-88463833c16d?q=80&w=1974" class="relative rounded-[3rem] shadow-2xl grayscale" alt="Testimony">
                    
                    <!-- Floating Stat -->
                    <div class="absolute -bottom-8 -right-8 p-10 bg-secondary rounded-[3rem] shadow-2xl text-white">
                        <div class="text-4xl font-black mb-1">500+</div>
                        <div class="text-[10px] font-black uppercase tracking-widest opacity-60">Puas di {{ $city->name }}</div>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2">
                <span class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-4 inline-block">Real Customer Voice</span>
                <h2 class="text-4xl font-heading font-black text-slate-900 mb-10 leading-tight">Apa Kata Warga <br>{{ $city->name }}?</h2>
                
                <div class="space-y-8">
                    @forelse($cityReviews as $review)
                    <div class="p-8 bg-stone-50 rounded-3xl border border-slate-100">
                        <div class="flex gap-1 text-primary text-xs mb-4">
                            @for($i=0; $i<$review->rating; $i++) <i class="ri-star-fill"></i> @endfor
                        </div>
                        <p class="text-slate-600 text-lg italic mb-6">"{{ $review->review_text }}"</p>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center font-black text-slate-400 text-xs">
                                {{ substr($review->customer_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900 uppercase tracking-widest">{{ $review->customer_name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $review->location_suburb ?: 'Wilayah ' . $city->name }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-slate-400 italic">Belum ada review spesifik untuk area ini. Ribuan pelanggan di Indonesia telah mempercayai kami.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
</x-app-layout>
