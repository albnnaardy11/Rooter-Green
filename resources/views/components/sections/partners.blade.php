@php
    $partners = \App\Models\Partner::where('is_active', true)->orderBy('order')->get();
@endphp

@if($partners->count() > 0)
<section class="py-24 sm:py-32 bg-secondary relative overflow-hidden group/section">
    <!-- Architectural Background with improved depth -->
    <div class="absolute inset-0 z-0 select-none pointer-events-none">
        <div class="absolute inset-0 opacity-[0.03] sm:opacity-[0.05]" 
             style="background-image: linear-gradient(#ffffff 1px, transparent 1px), linear-gradient(90deg, #ffffff 1px, transparent 1px); background-size: 60px 60px;"></div>
        
        <!-- Premium Glows -->
        <div class="absolute -top-[10%] -right-[10%] w-[60%] h-[60%] bg-primary/20 rounded-full blur-[160px] opacity-40 animate-pulse-slow"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[50%] h-[50%] bg-accent/10 rounded-full blur-[140px] opacity-30"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:grid lg:grid-cols-12 gap-16 lg:gap-20 items-center">
            
            <!-- Left Side: Authority & Hook Heading -->
            <div class="lg:col-span-5 space-y-10 w-full">
                <div class="max-w-xl">
                    <h2 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-heading font-black text-white mb-6 sm:mb-8 tracking-tighter leading-[0.85] md:leading-[0.9]">
                        Kerjasama<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-br from-primary via-primary-light to-primary-dark italic">Mitra<span class="text-white">.</span></span>
                    </h2>
                    
                    <p class="text-gray-400 font-medium text-base sm:text-lg md:text-xl leading-relaxed max-w-lg mb-4 border-l-2 border-primary/30 pl-4">
                        Membangun ekosistem integritas yang menggerakkan standar baru infrastruktur pipa di seluruh penjuru Indonesia.
                    </p>
                </div>

                <!-- Strategic Stats List: Proportional & Responsive grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4 sm:gap-6 w-full max-w-xl lg:max-w-none">
                    <div class="group/stat flex items-center gap-4 sm:gap-5 p-4 sm:p-7 rounded-[1.5rem] sm:rounded-[2rem] bg-white/[0.03] border border-white/10 hover:border-primary/40 hover:bg-white/[0.06] transition-all duration-500 shadow-xl">
                        <div class="shrink-0 w-12 h-12 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl bg-primary/10 flex items-center justify-center text-primary text-2xl sm:text-3xl group-hover/stat:scale-110 group-hover/stat:bg-primary group-hover/stat:text-white transition-all duration-500 shadow-inner">
                            <i class="ri-building-line"></i>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-heading font-black text-white leading-none mb-1 tabular-nums tracking-tight">{{ $partners->count() }}+</div>
                            <div class="text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-[0.15em] leading-tight">Korporasi<br class="hidden sm:block"> Terakreditasi</div>
                        </div>
                    </div>
                    
                    <div class="group/stat flex items-center gap-4 sm:gap-5 p-4 sm:p-7 rounded-[1.5rem] sm:rounded-[2rem] bg-white/[0.03] border border-white/10 hover:border-accent/40 hover:bg-white/[0.06] transition-all duration-500 shadow-xl">
                        <div class="shrink-0 w-12 h-12 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl bg-accent/10 flex items-center justify-center text-accent text-2xl sm:text-3xl group-hover/stat:scale-110 group-hover/stat:bg-accent group-hover/stat:text-white transition-all duration-500 shadow-inner">
                            <i class="ri-shield-flash-line"></i>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-heading font-black text-white leading-none mb-1 tabular-nums tracking-tight">99.9%</div>
                            <div class="text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-[0.15em] leading-tight">Integritas<br class="hidden sm:block"> Layanan SLA</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: The Wall of Trust (Enhanced Marquee Panel) -->
            <div class="lg:col-span-7 relative w-full lg:w-auto">
                <!-- Abstract Background Blobs for Panel -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4/5 h-4/5 bg-primary/10 blur-[100px] rounded-full opacity-30 group-hover/section:scale-110 transition-transform duration-1000"></div>

                <div class="relative bg-white/[0.02] backdrop-blur-2xl rounded-[2.5rem] sm:rounded-[3.5rem] border border-white/10 overflow-hidden shadow-[0_32px_80px_-20px_rgba(0,0,0,0.5)]">
                    <!-- Glass Shine Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-white/[0.08] to-transparent pointer-events-none"></div>
                    
                    <div class="flex flex-col py-4 sm:py-12">
                        <!-- Horizontal Marquee Rows with Masks -->
                        <div class="relative group/marquee overflow-hidden">
                            <!-- Row 1 -->
                            <div class="py-4 sm:py-6 flex overflow-hidden">
                                <div class="flex animate-marquee-premium items-center group-hover/marquee:pause-marquee">
                                    @php 
                                        $loopPartners = $partners->concat($partners)->concat($partners);
                                    @endphp
                                    @foreach($loopPartners as $partner)
                                    <div class="flex-shrink-0 px-4 sm:px-6 group/logo">
                                        <div class="flex items-center justify-center w-32 h-16 sm:w-48 sm:h-28 rounded-2xl transition-all duration-700
                                                    bg-white/[0.03] hover:bg-white border border-white/5 hover:border-white
                                                    shadow-lg hover:shadow-[0_15px_40px_rgba(31,175,90,0.2)]
                                                    hover:-translate-y-2 group-hover/marquee:opacity-70 hover:!opacity-100 overflow-hidden">
                                            <img src="{{ asset($partner->logo_path) }}" 
                                                 alt="{{ $partner->name }}" 
                                                 class="w-full h-full p-2 sm:p-4 object-contain transition-all duration-700
                                                        group-hover/logo:scale-110">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Row 2 (Reverse) -->
                            <div class="py-4 sm:py-6 flex overflow-hidden border-t border-white/5">
                                <div class="flex animate-marquee-premium-reverse items-center group-hover/marquee:pause-marquee">
                                    @foreach($loopPartners->reverse() as $partner)
                                    <div class="flex-shrink-0 px-4 sm:px-6 group/logo">
                                        <div class="flex items-center justify-center w-32 h-16 sm:w-48 sm:h-28 rounded-2xl transition-all duration-700
                                                    bg-white/[0.03] hover:bg-white border border-white/5 hover:border-white
                                                    shadow-lg hover:shadow-[0_15px_40px_rgba(31,175,90,0.2)]
                                                    hover:-translate-y-2 group-hover/marquee:opacity-70 hover:!opacity-100 overflow-hidden">
                                            <img src="{{ asset($partner->logo_path) }}" 
                                                 alt="{{ $partner->name }}" 
                                                 class="w-full h-full p-2 sm:p-4 object-contain transition-all duration-700
                                                        group-hover/logo:scale-110">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Badge: Hooks the user -->
                <div class="absolute -bottom-4 sm:-bottom-6 left-1/2 -translate-x-1/2 px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl bg-gradient-to-r from-primary to-primary-dark text-white text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em] sm:tracking-[0.3em] shadow-[0_10px_30px_rgba(31,175,90,0.3)] z-30 flex items-center gap-2 sm:gap-3 whitespace-nowrap">
                    <i class="ri-verified-badge-fill text-base sm:text-lg"></i>
                    Trust by Industry
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes marquee-premium {
        0% { transform: translateX(0); }
        100% { transform: translateX(-33.33%); }
    }
    @keyframes marquee-premium-reverse {
        0% { transform: translateX(-33.33%); }
        100% { transform: translateX(0); }
    }
    .animate-marquee-premium {
        animation: marquee-premium 40s linear infinite;
    }
    .animate-marquee-premium-reverse {
        animation: marquee-premium-reverse 50s linear infinite;
    }
    .pause-marquee {
        animation-play-state: paused;
    }
    .animate-pulse-slow {
        animation: pulse 8s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 0.4; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.05); }
    }
</style>
@endif
