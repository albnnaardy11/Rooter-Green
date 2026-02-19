<!-- Modern Floating Navbar -->
<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 50)"
     class="fixed top-0 left-0 right-0 z-50 pt-4 sm:pt-10 px-3 sm:px-4 transition-all duration-500 ease-in-out">
    
    <div :class="scrolled ? 'max-w-7xl py-3' : 'max-w-[90rem] py-5'"
         class="mx-auto bg-secondary/80 backdrop-blur-2xl border border-white/10 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all duration-500 px-6 sm:px-10 flex items-center justify-between relative">
        
        <!-- Logo Area with Aura -->
        <div class="flex-shrink-0 flex items-center gap-4 group cursor-pointer relative">
            <div class="absolute inset-0 bg-primary/20 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative w-11 h-11 sm:w-12 sm:h-12 bg-primary flex items-center justify-center rounded-2xl shadow-lg shadow-primary/20 rotate-3 group-hover:rotate-0 transition-all duration-500">
                <i class="ri-flashlight-fill text-white text-2xl sm:text-3xl"></i>
            </div>
            <div class="relative flex flex-col">
                <span class="font-heading font-black text-xl sm:text-2xl text-white tracking-widest leading-none">ROOTER<span class="text-primary italic">IN</span></span>
                <div class="hidden sm:flex items-center gap-2 mt-1">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                    <span class="text-[10px] text-gray-400 font-extrabold tracking-[0.2em] uppercase">Organic Plumbing Hub</span>
                </div>
            </div>
        </div>

        <!-- Desktop Menu: Minimal Tech Style -->
        <div class="hidden lg:flex items-center space-x-4 xl:space-x-8">
            @foreach(['Home' => route('home'), 'Tentang' => route('about'), 'Layanan' => route('services'), 'Galeri' => route('gallery'), 'Kontak' => route('contact')] as $label => $link)
                <a href="{{ $link }}" 
                   class="relative px-5 py-2 text-[11px] xl:text-xs font-extra-black uppercase tracking-[0.25em] transition-all duration-500 group whitespace-nowrap {{ request()->url() == $link ? 'text-white' : 'text-gray-400 hover:text-white' }}">
                    <span class="relative z-10">{{ $label }}</span>
                    
                    <!-- Background Soft Pill -->
                    <span class="absolute inset-x-0 inset-y-[-4px] bg-white/5 rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-500 border border-white/0 group-hover:border-white/5 backdrop-blur-sm"></span>
                    
                    <!-- Tech Indicator Dot -->
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 transition-all duration-500 {{ request()->url() == $link ? 'opacity-100 -bottom-2' : 'opacity-0 group-hover:opacity-100 group-hover:-bottom-2' }}">
                        <span class="w-1 h-1 bg-primary rounded-full shadow-[0_0_10px_#1FAF5A]"></span>
                        <span class="w-8 h-[1px] bg-gradient-to-r from-transparent via-primary/50 to-transparent"></span>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Action Area -->
        <div class="flex items-center gap-4 sm:gap-8">
            <a href="https://wa.me/6281234567890" 
               class="hidden md:flex group relative items-center gap-4 bg-white/5 hover:bg-primary border border-white/10 hover:border-primary px-6 py-3.5 rounded-2xl transition-all duration-500 whitespace-nowrap overflow-hidden">
                <div class="text-left relative z-10">
                    <div class="text-[10px] text-gray-400 group-hover:text-white/80 font-black uppercase tracking-[0.1em] leading-none mb-1">Butuh Bantuan?</div>
                    <div class="text-white font-black text-base uppercase tracking-widest leading-none">SOS WhatsApp</div>
                </div>
                <div class="w-10 h-10 bg-primary/20 group-hover:bg-white/20 rounded-xl flex items-center justify-center transition-colors relative z-10">
                    <i class="ri-whatsapp-line text-primary group-hover:text-white text-xl"></i>
                </div>
            </a>

            <!-- Pop-out Hamburger -->
            <button @click="open = ! open" 
                    class="relative lg:hidden w-11 h-11 flex items-center justify-center rounded-2xl transition-all duration-500 z-[70]"
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
            @foreach(['Home' => route('home'), 'About Us' => route('about'), 'Service' => route('services'), 'Gallery' => route('gallery'), 'Contact' => route('contact')] as $label => $link)
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-600 delay-[{{ $index * 150 }}ms]"
                     x-transition:enter-start="opacity-0 translate-x-10 rotate-3"
                     x-transition:enter-end="opacity-100 translate-x-0 rotate-0">
                    <a @click="open = false" href="{{ $link }}" 
                       class="text-3xl font-black text-white py-5 flex items-center justify-between border-b border-white/5 group">
                        <span class="group-hover:text-primary transition-all duration-300 group-hover:translate-x-2">{{ $label }}</span>
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center group-hover:bg-primary transition-all duration-500 shadow-sm group-hover:shadow-primary/30">
                            <i class="ri-arrow-right-line text-gray-400 group-hover:text-white text-xl transition-transform group-hover:translate-x-1"></i>
                        </div>
                    </a>
                </div>
                @php $index++; @endphp
            @endforeach
            
            <div class="mt-8 pt-8 flex flex-col gap-5"
                 x-show="open"
                 x-transition:enter="transition ease-out duration-600 delay-[750ms]"
                 x-transition:enter-start="opacity-0 translate-y-10"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 bg-primary rounded-full animate-ping"></div>
                    <span class="text-xs text-gray-400 font-black tracking-[0.25em] uppercase">Emergency Support Hub</span>
                </div>
                <a href="tel:081246668749" class="text-4xl font-black text-white hover:text-primary transition-all duration-300 inline-block tracking-tight">0812-4666-8749</a>
            </div>
        </div>
    </div>
</nav>
