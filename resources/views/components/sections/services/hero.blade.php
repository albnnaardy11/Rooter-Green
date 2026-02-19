<section class="relative bg-secondary min-h-[70vh] flex items-center overflow-hidden pt-36 sm:pt-44 pb-24 sm:pb-32 sm:pb-48">
    <!-- 1. Background Visuals (Matched to Home Hero) -->
    <div class="absolute inset-0 z-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>
    <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-accent/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="flex flex-col items-center text-center">
            
            <!-- Badge -->
            <div class="inline-flex items-center gap-3 px-5 py-2.1 rounded-full border border-primary/30 bg-primary/10 text-primary font-black text-[10px] uppercase tracking-[0.4em] mb-10 animate-fade-in-up">
                <i class="ri-settings-5-fill animate-spin-slow"></i>
                Service Excellence
            </div>
            
            <!-- Massive Centered Heading -->
            <h1 class="text-3xl sm:text-5xl md:text-7xl lg:text-8xl font-heading font-black text-white leading-[0.9] tracking-tighter mb-6 sm:mb-10 max-w-5xl animate-fade-in-up">
                Layanan <span class="text-primary italic">Plumbing</span> <br> Profesional & Bergaransi.
            </h1>

            <p class="text-gray-400 text-lg sm:text-xl max-w-2xl mb-16 leading-relaxed font-medium animate-fade-in-up delay-150">
                Dari deteksi kebocoran hingga pembersihan pipa kerak lemak, kami menangani setiap masalah dengan standar teknis tertinggi.
            </p>

            <!-- Floating Tool Indicators (Unique to Service) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 w-full max-w-4xl animate-fade-in-up delay-300">
                @foreach([
                    ['icon' => 'ri-drop-fill', 'label' => 'Leak Detection'],
                    ['icon' => 'ri-water-flash-fill', 'label' => 'Hydro Jetting'],
                    ['icon' => 'ri-camera-lens-fill', 'label' => 'Pipe Inspection'],
                    ['icon' => 'ri-tools-fill', 'label' => 'Rooter Auger']
                ] as $tool)
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-[2rem] flex flex-col items-center gap-4 hover:bg-primary/20 transition-all duration-500 group">
                        <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="{{ $tool['icon'] }} text-2xl"></i>
                        </div>
                        <span class="text-white font-black text-[9px] uppercase tracking-[0.2em]">{{ $tool['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Section Transition (Triple-Layered Fluid Wave - Premium Service Version) -->
    <div class="absolute bottom-0 -left-[5%] w-[110%] overflow-hidden leading-[0] z-20">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-[120px] sm:h-[180px]">
            <!-- Layer 1: Deep Blue Shadow -->
            <path fill="var(--color-primary)" opacity="0.05" d="M0,0 C200,80 400,0 600,40 C800,80 1000,0 1200,20 L1200,120 L0,120 Z" class="animate-wave-very-slow"></path>
            
            <!-- Layer 2: Primary Tint -->
            <path fill="var(--color-primary)" opacity="0.15" d="M0,40 C300,100 600,20 900,80 C1100,110 1200,90 1200,90 L1200,120 L0,120 Z" class="animate-wave-mid"></path>
            
            <!-- Layer 3: Main Surface (Stone-50) -->
            <path fill="currentColor" class="text-stone-50" d="M0,80 C150,120 350,40 550,80 C750,120 1000,80 1200,100 L1200,120 L0,120 Z"></path>
        </svg>
    </div>
</section>

<style>
    @keyframes wave-flow {
        0%, 100% { transform: translateX(0) skewY(0deg); }
        50% { transform: translateX(-30px) skewY(0.5deg); }
    }
    .animate-wave-very-slow {
        animation: wave-flow 15s ease-in-out infinite;
    }
    .animate-wave-mid {
        animation: wave-flow 10s ease-in-out infinite;
    }
</style>
