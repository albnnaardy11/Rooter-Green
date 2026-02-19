<!-- Modern Floating Navbar -->
<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 50)"
     class="fixed top-0 left-0 right-0 z-50 pt-4 sm:pt-10 px-3 sm:px-4 transition-all duration-500 ease-in-out">
    
    <div :class="scrolled ? 'max-w-7xl py-3' : 'max-w-[85rem] py-4.5 sm:py-5.5'"
          class="mx-auto bg-secondary/95 backdrop-blur-xl border border-white/10 rounded-2xl sm:rounded-[1.75rem] shadow-[0_25px_50px_rgba(0,0,0,0.35)] transition-all duration-500 px-6 lg:px-9 flex items-center justify-between relative">
        
        <!-- Logo Area -->
        <div class="flex-shrink-0 flex items-center gap-4 group cursor-pointer relative">
            <div class="relative w-10 h-10 sm:w-12 sm:h-12 bg-primary flex items-center justify-center rounded-2xl shadow-lg shadow-primary/20 transition-all duration-500 group-hover:scale-105">
                <i class="ri-flashlight-fill text-white text-2xl sm:text-2xl"></i>
            </div>
            <div class="relative flex flex-col">
                <span class="font-heading font-black text-xl sm:text-2xl text-white tracking-widest leading-none">ROOTER<span class="text-primary">IN</span></span>
                <span class="hidden sm:block text-[9px] text-gray-500 font-black tracking-[0.4em] uppercase mt-1.5">Organic Plumbing Hub</span>
            </div>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden xl:flex items-center space-x-2">
            @foreach(['Home' => route('home'), 'Tentang' => route('about'), 'Layanan' => route('services'), 'Galeri' => route('gallery'), 'Tips & Trik' => route('tips'), 'Kontak' => route('contact')] as $label => $link)
                <a href="{{ $link }}" 
                   class="relative px-4 py-2 text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300 {{ request()->url() == $link ? 'text-primary' : 'text-gray-400 hover:text-white' }}">
                    {{ $label }}
                    @if(request()->url() == $link)
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-4 h-[2px] bg-primary rounded-full"></span>
                    @endif
                </a>
            @endforeach
        </div>

        <!-- Action Area -->
        <div class="flex items-center gap-3 sm:gap-5">
            <a href="https://wa.me/6281234567890" 
               class="hidden md:flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 px-4 xl:px-6 py-2.5 xl:py-3 rounded-2xl transition-all duration-300 group">
                <div class="hidden xl:block text-right">
                    <div class="text-[9px] text-gray-400 font-black uppercase tracking-widest leading-none mb-1.5">Butuh Bantuan?</div>
                    <div class="text-white font-black text-[11px] uppercase tracking-widest leading-none">WhatsApp SOS</div>
                </div>
                <div class="w-8 h-8 xl:w-9 xl:h-9 bg-primary/20 rounded-xl flex items-center justify-center group-hover:bg-primary transition-all duration-300">
                    <i class="ri-whatsapp-line text-base xl:text-lg text-primary group-hover:text-white transition-colors"></i>
                </div>
            </a>

            <!-- Pop-out Hamburger -->
            <button @click="open = ! open" 
                    class="relative xl:hidden w-11 h-11 flex items-center justify-center rounded-2xl transition-all duration-500 z-[70]"
                    :class="open ? 'bg-primary scale-110 shadow-[0_10px_25px_rgba(31,175,90,0.4)]' : 'bg-white/10'">
                <div class="relative w-6 h-5 flex items-center justify-center">
                    <span class="absolute h-[3px] bg-white rounded-full transition-all duration-500 ease-[cubic-bezier(0.68,-0.6,0.32,1.6)]"
                          :class="open ? 'w-6 rotate-45' : 'w-6 -translate-y-2'"></span>
                    <span class="absolute h-[3px] bg-white rounded-full transition-all duration-300"
                          :class="open ? 'w-0 opacity-0 translate-x-4' : 'w-4 translate-x-1.5'"></span>
                    <span class="absolute h-[3px] bg-white rounded-full transition-all duration-500 ease-[cubic-bezier(0.68,-0.6,0.32,1.6)]"
                          :class="open ? 'w-6 -rotate-45' : 'w-6 translate-y-2'"></span>
                </div>
            </button>
        </div>
    </div>

    <!-- Smooth Mobile Menu Overlay: Hub & Landscape Optimized -->
    <div x-show="open" 
         x-transition:enter="transition ease-[cubic-bezier(0.34,1.56,0.64,1)] duration-700"
         x-transition:enter-start="opacity-0 translate-y-20 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-400"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="xl:hidden absolute top-[90px] sm:top-[120px] left-4 right-4 sm:left-8 sm:right-8 bg-secondary/98 backdrop-blur-3xl border border-white/10 rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-8 shadow-[0_40px_100px_rgba(0,0,0,0.5)] max-h-[calc(100vh-140px)] overflow-y-auto no-scrollbar">
        
        <div class="relative flex flex-col gap-1 z-20">
            @php $index = 1; @endphp
            @foreach(['Home' => route('home'), 'About Us' => route('about'), 'Service' => route('services'), 'Gallery' => route('gallery'), 'Tips & Trik' => route('tips'), 'Contact' => route('contact')] as $label => $link)
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-600 delay-[{{ $index * 120 }}ms]"
                     x-transition:enter-start="opacity-0 translate-x-10 rotate-3"
                     x-transition:enter-end="opacity-100 translate-x-0 rotate-0">
                    <a @click="open = false" href="{{ $link }}" 
                       class="text-base sm:text-lg font-black text-white py-2.5 sm:py-3.5 flex items-center justify-between border-b border-white/5 group">
                        <span class="group-hover:text-primary transition-all duration-300 group-hover:translate-x-2">{{ $label }}</span>
                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-primary transition-all duration-500 shadow-sm group-hover:shadow-primary/30">
                            <i class="ri-arrow-right-line text-gray-400 group-hover:text-white text-base transition-transform group-hover:translate-x-1"></i>
                        </div>
                    </a>
                </div>
                @php $index++; @endphp
            @endforeach
            
            <div class="mt-4 pt-4 flex flex-col gap-1 border-t border-white/5"
                 x-show="open"
                 x-transition:enter="transition ease-out duration-600 delay-[600ms]"
                 x-transition:enter-start="opacity-0 translate-y-10"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-1.5 bg-primary rounded-full animate-ping shadow-[0_0_8px_#1FAF5A]"></div>
                    <span class="text-[8px] text-gray-400 font-black tracking-[0.3em] uppercase">Emergency Support Hub</span>
                </div>
                <div class="pl-4">
                    <a href="tel:081246668749" class="text-xl sm:text-2xl font-black text-white hover:text-primary transition-all duration-300 inline-block tracking-tighter">0812-4666-8749</a>
                </div>
            </div>
        </div>
    </div>
</nav>
