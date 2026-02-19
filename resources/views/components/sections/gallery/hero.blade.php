<section class="relative bg-secondary min-h-[97vh] flex items-center overflow-hidden pt-36 sm:pt-44 pb-24 sm:pb-40 sm:pb-40">
    <!-- 1. Background Visuals (Standard Brand DNA) -->
    <div class="absolute inset-0 z-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>
    <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-accent/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="flex flex-col items-center text-center relative">
            
            <!-- Floating Decorative Images (Left & Right) -->
            <div class="absolute -left-16 lg:-left-44 top-0 w-44 lg:w-64 aspect-[3/4] rounded-[2.5rem] overflow-hidden border-4 border-white/10 shadow-2xl rotate-[-15deg] hidden sm:block animate-bounce-soft">
                <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=600&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="absolute -right-16 lg:-right-44 bottom-0 w-44 lg:w-64 aspect-[3/4] rounded-[2.5rem] overflow-hidden border-4 border-white/10 shadow-2xl rotate-[15deg] hidden sm:block animate-bounce-soft delay-700">
                <img src="https://images.unsplash.com/photo-1542013936693-884638332954?w=600&fit=crop" class="w-full h-full object-cover">
            </div>

            <!-- Content Area -->
            <div class="max-w-4xl px-4">
                <div class="inline-flex items-center gap-3 mb-8 px-6 py-2 rounded-full border border-accent/30 bg-accent/10">
                    <i class="ri-gallery-fill text-accent"></i>
                    <span class="text-accent font-black text-[10px] uppercase tracking-[0.4em]">Works Portfolio</span>
                </div>
                
                <h1 class="text-4xl sm:text-6xl md:text-8xl font-heading font-black text-white leading-[0.85] tracking-tighter mb-8 sm:mb-12">
                    Lensa <span class="text-primary italic underline decoration-accent/30 underline-offset-[12px]">Kerja</span> <br> Nyata Kami.
                </h1>

                <p class="text-gray-400 text-lg sm:text-xl font-medium leading-relaxed max-w-2xl mx-auto mb-16">
                    Kumpulan dokumentasi pengerjaan solusi plumbing profesional dari ribuan titik di seluruh Jabodetabek.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-10">
                    <div class="flex flex-col items-center">
                        <span class="text-white text-5xl font-black tracking-tighter mb-1">2.4k+</span>
                        <span class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em]">Pipa Lancar</span>
                    </div>
                    <div class="w-[1px] h-12 bg-white/10 hidden md:block"></div>
                    <div class="flex flex-col items-center">
                        <span class="text-white text-5xl font-black tracking-tighter mb-1">98%</span>
                        <span class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em]">Repeat Order</span>
                    </div>
                </div>

                <!-- Primary CTA Button -->
                <div class="relative group inline-block mt-9">
                    <div class="absolute inset-0 bg-primary/20 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <a href="https://wa.me/6281234567890" class="relative inline-flex items-center gap-4 bg-gradient-to-r from-primary to-accent px-10 py-5 rounded-2xl text-white font-black uppercase tracking-[0.2em] text-sm shadow-2xl shadow-primary/20 hover:scale-105 active:scale-95 transition-all duration-300">
                        <i class="ri-whatsapp-line text-2xl"></i>
                        <span>Pesan Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Transition (Ultra-Smooth Fluid Wave) -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0] z-20 translate-y-[1px]">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-[120px] sm:h-[180px]">
            <!-- Layer 1: Soft Accent Ambient -->
            <path fill="var(--color-accent)" opacity="0.1" d="M0,60 C300,120 900,0 1200,60 L1200,120 L0,120 Z" class="animate-wave-very-slow"></path>
            
            <!-- Layer 2: Soft Primary Ambient -->
            <path fill="var(--color-primary)" opacity="0.1" d="M0,80 C400,140 800,20 1200,80 L1200,120 L0,120 Z" class="animate-wave-mid"></path>
            
            <!-- Layer 3: Main Surface (Stone-50) -->
            <path fill="currentColor" class="text-stone-50" d="M0,100 C200,60 400,60 600,100 C800,140 1000,100 1200,60 L1200,120 L0,120 Z"></path>
        </svg>
    </div>
</section>
