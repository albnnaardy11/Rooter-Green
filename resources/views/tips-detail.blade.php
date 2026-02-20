<x-app-layout title="Cara Darurat Atasi Wastafel Mampet - Tips & Trik RooterIN">
    
@php
    // $post is passed from controller
@endphp

    {{-- 0. Scroll Progress Tracker --}}
    <div x-data="{ 
        percent: 0,
        updateProgress() {
            const h = document.documentElement, 
                  st = 'scrollTop',
                  sh = 'scrollHeight';
            this.percent = (h[st]||document.body[st]) / ((h[sh]||document.body[sh]) - h.clientHeight) * 100;
        }
    }" @scroll.window="updateProgress()" class="fixed top-0 left-0 w-full h-1.5 z-[100] pointer-events-none">
        <div class="h-full bg-primary transition-all duration-150 shadow-[0_0_15px_rgba(var(--color-primary-rgb),0.5)]" :style="`width: ${percent}%`"></div>
    </div>

    <section class="bg-stone-50/50 pt-32 sm:pt-48 pb-40 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Breadcrumb & Back --}}
            <div class="flex items-center justify-between mb-16">
                <a href="{{ route('tips') }}" class="group flex items-center gap-3 text-secondary font-black text-[11px] uppercase tracking-[0.3em] hover:text-primary transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-[0_10px_20px_rgba(0,0,0,0.02),0_0_20px_white] flex items-center justify-center text-primary group-hover:-translate-x-2 transition-transform">
                        <i class="ri-arrow-left-line text-xl"></i>
                    </div>
                    <span class="ml-2">Kembali Ke Hub</span>
                </a>
                <div class="hidden sm:flex gap-3">
                    @foreach(['ri-whatsapp-line', 'ri-facebook-fill', 'ri-twitter-line'] as $icon)
                        <button class="w-12 h-12 rounded-2xl bg-white shadow-[0_10px_20px_rgba(0,0,0,0.02),0_0_20px_white] flex items-center justify-center text-secondary hover:text-primary hover:shadow-lg hover:shadow-primary/5 transition-all">
                            <i class="{{ $icon }} text-lg"></i>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
                
                {{-- Main Content - Contained Style --}}
                <div class="lg:w-2/3">
                    <article class="bg-white rounded-[4rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.04),0_0_60px_white] overflow-hidden border border-white/50">
                        
                        {{-- Integrated Header Image & Title --}}
                        <div class="relative h-[400px] sm:h-[550px] overflow-hidden group">
                            <img src="{{ $post->featured_image }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-[3000ms]">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                            
                            <div class="absolute bottom-12 left-8 right-8 sm:left-16 sm:right-16">
                                <span class="inline-block px-5 py-2 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-6 shadow-xl shadow-primary/20">
                                    {{ $post->category }}
                                </span>
                                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-heading font-black text-white leading-[1.1] mb-8 tracking-tighter">
                                    {{ $post->title }}
                                </h1>
                                <div class="flex items-center gap-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white font-black">
                                            {{ substr($post->author ?? 'R', 0, 1) }}
                                        </div>
                                        <div class="text-left">
                                            <p class="text-white font-black text-[10px] uppercase tracking-wider leading-none">{{ $post->author ?? 'RooterIn Team' }}</p>
                                            <p class="text-white/60 text-[8px] font-bold uppercase tracking-widest mt-1">Plumbing Expert</p>
                                        </div>
                                    </div>
                                    <div class="w-[1px] h-6 bg-white/20"></div>
                                    <div class="text-white/80 font-black text-[9px] uppercase tracking-[0.2em] flex items-center gap-2">
                                        <i class="ri-calendar-event-line text-primary"></i>
                                        {{ $post->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-white/80 font-black text-[9px] uppercase tracking-[0.2em] hidden sm:flex items-center gap-2">
                                        <i class="ri-time-line text-primary"></i>
                                        {{ ceil(str_word_count($post->content) / 200) }} min read
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Article Body --}}
                        <div class="p-8 sm:p-20 pt-16">
                            <div class="prose prose-xl prose-slate max-w-none prose-headings:font-heading prose-headings:font-black prose-headings:text-secondary prose-headings:tracking-tight prose-p:text-gray-600 prose-p:leading-relaxed prose-strong:text-secondary prose-img:rounded-[2.5rem] prose-blockquote:border-l-primary prose-blockquote:bg-stone-50 prose-blockquote:p-10 prose-blockquote:rounded-[2.5rem] prose-blockquote:italic prose-blockquote:font-medium">
                                {!! nl2br(e($post->content)) !!}
                                
                                <div class="mt-20 p-10 bg-secondary rounded-[3rem] text-white">
                                    <h3 class="text-white !mt-0">Butuh Bantuan Lebih Lanjut?</h3>
                                    <p class="text-gray-400 mb-8">Jika langkah di atas belum berhasil, kemungkinan ada benda keras yang menyangkut. Tim RooterIN siap membantu dengan alat spiral modern.</p>
                                    <a href="https://wa.me/6281234567890" class="inline-flex items-center gap-3 px-8 py-4 bg-primary text-white rounded-2xl font-black uppercase text-[11px] tracking-widest shadow-xl shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
                                        <i class="ri-whatsapp-line text-xl"></i>
                                        Panggil Teknisi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                {{-- Sidebar - Simplified & Professional --}}
                <div class="lg:w-1/3">
                    <div class="sticky top-32 space-y-10">
                        
                        {{-- SOS Card Slim --}}
                        <div class="bg-white rounded-[3rem] p-10 shadow-[0_30px_80px_rgba(0,0,0,0.03),0_0_50px_white] relative group overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/10 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                            <div class="relative z-10">
                                <h4 class="text-secondary font-black text-xl mb-4 leading-tight">Konsultasi Gratis <br><span class="text-primary italic">Masalah Pipa</span></h4>
                                <p class="text-gray-400 text-sm mb-8 leading-relaxed">Tanya teknisi kami langsung lewat WhatsApp untuk estimasi biaya dan solusi.</p>
                                <a href="https://wa.me/6281234567890" class="flex items-center justify-center gap-3 w-full py-5 bg-secondary text-white rounded-[2rem] font-black uppercase text-[10px] tracking-widest hover:bg-primary transition-all shadow-xl shadow-secondary/10">
                                    <i class="ri-customer-service-2-line text-xl"></i>
                                    Chat Sekarang
                                </a>
                            </div>
                        </div>

                        {{-- Trending Section --}}
                        <div class="bg-white rounded-[3rem] p-10 shadow-[0_30px_80px_rgba(0,0,0,0.03),0_0_50px_white]">
                            <h4 class="text-secondary font-black text-xs uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                                Tips Terpopuler
                            </h4>
                            <div class="space-y-6">
                                @foreach([
                                    'Bahaya Menggunakan Soda Api Pada Pipa PVC',
                                    '5 Tanda Pipa Pembuangan Mulai Berkerak',
                                    'Cara Membersihkan Toren Air Agar Bebas Lumut'
                                ] as $title)
                                    <a href="#" class="group block border-b border-gray-50 pb-6 last:border-0 last:pb-0">
                                        <p class="text-[9px] font-black text-primary uppercase tracking-widest mb-1">Trending</p>
                                        <h5 class="text-secondary font-black text-sm leading-snug group-hover:text-primary transition-colors">{{ $title }}</h5>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- Newsletter Card --}}
                        <div class="bg-secondary p-10 rounded-[3rem] text-white overflow-hidden relative">
                            <div class="absolute inset-0 bg-primary/5 -z-0"></div>
                            <div class="relative z-10">
                                <h4 class="text-white font-black text-xl mb-2">Smart Mail</h4>
                                <p class="text-white/40 text-xs mb-8">Berlangganan tips perawatan pipa hemat biaya.</p>
                                <div class="space-y-3">
                                    <input type="email" placeholder="Email Anda..." class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 focus:ring-2 ring-primary transition-all text-sm font-medium text-white placeholder-white/30">
                                    <button class="w-full bg-primary text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">Daftar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section class="py-12 sm:py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- The High-Impact CTA Card (Named Group for Isolation) -->
        <div class="relative w-full min-h-[500px] lg:min-h-0 lg:aspect-[21/9] xl:aspect-[21/8] rounded-[2.5rem] sm:rounded-[4rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.3)] group/cta">
            
            <!-- Background Image from Internet -->
            <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2000&auto=format&fit=crop" 
                 alt="RooterIn Professional" 
                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2000ms] group-hover/cta:scale-110">
            
            <!-- Darker Gradient Overlay for Maximum Impact -->
            <div class="absolute inset-0 bg-secondary/60 backdrop-blur-[2px]"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-secondary/40 via-secondary/80 to-secondary transition-colors duration-500"></div>
            
            <!-- Content Area: Centered & Powerful -->
            <div class="absolute inset-0 p-6 sm:p-10 lg:p-16 flex flex-col justify-center items-center text-center">
                
                <!-- Centered Badges -->
                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-4 mb-6 sm:mb-10">
                    <div class="px-4 sm:px-6 py-2 sm:py-2.5 bg-primary text-white text-[8px] sm:text-[10px] font-black uppercase tracking-[0.3em] rounded-full shadow-xl shadow-primary/30">
                        EMERGENCY
                    </div>
                    <div class="px-4 sm:px-6 py-2 sm:py-2.5 bg-white/10 backdrop-blur-xl border border-white/20 rounded-full">
                        <span class="text-white text-[8px] sm:text-[10px] font-black uppercase tracking-[0.25em]">SIAP MELAYANI 24/7</span>
                    </div>
                </div>

                <!-- Massive Impact Heading -->
                <h2 class="text-2xl sm:text-4xl lg:text-5xl xl:text-7xl font-heading font-black text-white leading-[1.1] sm:leading-[1] tracking-tight mb-8 sm:mb-12 max-w-5xl animate-fade-in-up">
                    Langkah Nyata Menuju <br> 
                    <span class="text-primary italic">Saluran Pipa Lancar.</span>
                </h2>
                
                <!-- Large Prominent White Pill Button (Separate Named Group) -->
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281246668749') }}" 
                   class="inline-flex items-center gap-4 sm:gap-6 bg-white px-8 sm:px-12 lg:px-16 py-4 sm:py-5 lg:py-7 rounded-full shadow-[0_30px_60px_rgba(0,0,0,0.4)] hover:bg-primary transition-all duration-500 group/btn active:scale-95">
                    <span class="text-primary group-hover/btn:text-white font-black text-xs sm:text-base lg:text-xl uppercase tracking-widest transition-colors flex items-center gap-3 sm:gap-4">
                        Hubungi Tim Kami
                        <i class="ri-whatsapp-line text-lg lg:text-2xl transition-transform group-hover/btn:scale-125"></i>
                    </span>
                </a>

            </div>
        </div>
    </div>
</section>

</x-app-layout>
