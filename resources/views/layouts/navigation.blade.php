<!-- Modern Floating Navbar -->
<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 50)"
     class="fixed top-0 left-0 right-0 z-50 pt-4 sm:pt-10 px-3 sm:px-4 transition-all duration-500 ease-in-out">
    
    <div :class="scrolled ? 'max-w-6xl py-3' : 'max-w-7xl py-5'"
         class="mx-auto bg-secondary/80 backdrop-blur-2xl border border-white/10 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all duration-500 px-6 sm:px-10 flex items-center justify-between relative">
        
        <!-- Logo Area with Aura -->
        <div class="flex-shrink-0 flex items-center gap-4 group cursor-pointer relative">
            <div class="absolute inset-0 bg-primary/20 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative w-11 h-11 sm:w-12 sm:h-12 bg-primary flex items-center justify-center rounded-2xl shadow-lg shadow-primary/20 rotate-3 group-hover:rotate-0 transition-all duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div class="relative flex flex-col">
                <span class="font-heading font-black text-xl sm:text-2xl text-white tracking-widest leading-none">ROOTER<span class="text-primary italic">GREEN</span></span>
                <div class="hidden sm:flex items-center gap-2 mt-1">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                    <span class="text-[9px] text-gray-400 font-black tracking-widest uppercase">Organic Plumbing Hub</span>
                </div>
            </div>
        </div>

        <!-- Desktop Menu: Minimal Tech Style -->
        <div class="hidden lg:flex items-center space-x-2">
            @foreach(['Tentang' => '#about', 'Layanan' => '#services', 'Teknologi' => '#technology', 'Wilayah' => '#coverage'] as $label => $link)
                <a href="{{ $link }}" class="relative px-5 py-2 text-sm font-black text-gray-300 hover:text-white uppercase tracking-widest transition-all duration-300 group">
                    <span class="relative z-10">{{ $label }}</span>
                    <span class="absolute bottom-0 left-1/2 w-0 h-[2px] bg-primary transition-all duration-300 group-hover:w-full group-hover:left-0 rounded-full"></span>
                </a>
            @endforeach
        </div>

        <!-- Action Area -->
        <div class="flex items-center gap-3 sm:gap-6">
            <a href="https://wa.me/6281234567890" 
               class="hidden md:flex group relative items-center gap-4 bg-white/5 hover:bg-primary border border-white/10 hover:border-primary px-6 py-3 rounded-2xl transition-all duration-500 whitespace-nowrap overflow-hidden">
                <div class="text-left relative z-10">
                    <div class="text-[9px] text-gray-400 group-hover:text-white/80 font-bold uppercase tracking-widest leading-none mb-1">Butuh Bantuan?</div>
                    <div class="text-white font-black text-sm uppercase tracking-widest leading-none">SOS WhatsApp</div>
                </div>
                <div class="w-9 h-9 bg-primary/20 group-hover:bg-white/20 rounded-xl flex items-center justify-center transition-colors relative z-10">
                    <svg class="w-5 h-5 text-primary group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                </div>
            </a>

            <!-- Pop-out Hamburger -->
            <button @click="open = ! open" 
                    class="relative lg:hidden w-12 h-12 flex items-center justify-center rounded-2xl transition-all duration-500 z-[70]"
                    :class="open ? 'bg-primary scale-110 shadow-[0_10px_25px_rgba(31,175,90,0.4)]' : 'bg-white/10'">
                <div class="relative w-6 h-5 flex items-center justify-center">
                    <span class="absolute h-[2.5px] bg-white rounded-full transition-all duration-500 ease-[cubic-bezier(0.68,-0.6,0.32,1.6)]"
                          :class="open ? 'w-6 rotate-45' : 'w-6 -translate-y-2'"></span>
                    <span class="absolute h-[2.5px] bg-white rounded-full transition-all duration-300"
                          :class="open ? 'w-0 opacity-0 translate-x-4' : 'w-4 translate-x-1.5'"></span>
                    <span class="absolute h-[2.5px] bg-white rounded-full transition-all duration-500 ease-[cubic-bezier(0.68,-0.6,0.32,1.6)]"
                          :class="open ? 'w-6 -rotate-45' : 'w-6 translate-y-2'"></span>
                </div>
            </button>
        </div>
    </div>

    <!-- Smooth Mobile Menu Overlay -->
    <div x-show="open" 
         x-transition:enter="transition ease-[cubic-bezier(0.34,1.56,0.64,1)] duration-700"
         x-transition:enter-start="opacity-0 translate-y-20 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-400"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="lg:hidden absolute top-[110px] left-4 right-4 bg-secondary/98 backdrop-blur-3xl border border-white/10 rounded-[2.5rem] p-10 shadow-[0_40px_100px_rgba(0,0,0,0.5)] overflow-hidden">
        
        <div class="relative flex flex-col gap-8 z-20">
            @php $index = 1; @endphp
            @foreach(['Tentang' => '#about', 'Layanan' => '#services', 'Teknologi' => '#technology', 'Wilayah' => '#coverage'] as $label => $link)
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-600 delay-[{{ $index * 150 }}ms]"
                     x-transition:enter-start="opacity-0 translate-x-10 rotate-3"
                     x-transition:enter-end="opacity-100 translate-x-0 rotate-0">
                    <a @click="open = false" href="{{ $link }}" 
                       class="text-2xl font-black text-white py-4 flex items-center justify-between border-b border-white/5 group">
                        <span class="group-hover:text-primary transition-all duration-300 group-hover:translate-x-2">{{ $label }}</span>
                        <div class="w-11 h-11 rounded-2xl bg-white/5 flex items-center justify-center group-hover:bg-primary transition-all duration-500 shadow-sm group-hover:shadow-primary/30">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </a>
                </div>
                @php $index++; @endphp
            @endforeach
            
            <div class="mt-8 pt-8 flex flex-col gap-4"
                 x-show="open"
                 x-transition:enter="transition ease-out duration-600 delay-[750ms]"
                 x-transition:enter-start="opacity-0 translate-y-10"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 bg-primary rounded-full animate-ping"></div>
                    <span class="text-xs text-gray-400 font-bold tracking-[0.2em] uppercase">Emergency Support Hub</span>
                </div>
                <a href="tel:081246668749" class="text-3xl font-black text-white hover:text-primary transition-all duration-300 inline-block">0812-4666-8749</a>
            </div>
        </div>
    </div>
</nav>
