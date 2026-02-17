<div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3 animate-fade-in-up" x-data="{ showTop: false }" @scroll.window="showTop = (window.pageYOffset > 300)">
    
    <!-- Back to Top Button -->
    <button @click="window.scrollTo({top: 0, behavior: 'smooth'})" 
            x-show="showTop"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-10 scale-75"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-10 scale-75"
            class="w-12 h-12 bg-white text-secondary hover:bg-secondary hover:text-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center transition-all duration-300 group">
        <i class="ri-arrow-up-line text-xl group-hover:-translate-y-1 transition-transform"></i>
    </button>

    <div class="flex items-center gap-3">
        <div class="hidden md:block bg-white text-secondary py-2 px-4 rounded-full shadow-lg border border-gray-100 font-medium text-sm animate-bounce-soft">
            Konsultasi Gratis, Kak 👋
        </div>
        <a href="https://wa.me/6281234567890?text=Halo%20Kak%2C%20mau%20tanya%20jasa%20pipa%20dong" 
           target="_blank"
           class="flex items-center justify-center w-14 h-14 bg-[#25D366] hover:bg-[#20b85a] text-white rounded-full shadow-[0_4px_20px_rgba(37,211,102,0.4)] transition-all duration-300 transform hover:scale-110 group relative">
            <span class="absolute inline-flex h-full w-full rounded-full bg-[#25D366] opacity-30 animate-ping group-hover:opacity-50"></span>
            <i class="ri-whatsapp-line text-3xl relative z-10"></i>
        </a>
    </div>
</div>
