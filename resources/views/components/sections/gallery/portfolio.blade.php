<section class="py-32 bg-stone-50 relative overflow-hidden" x-data="{ 
    filter: 'All',
    items: {{ json_encode($items) }},
    activeItem: null,
    get filteredItems() {
        if (this.filter === 'All') return this.items;
        return this.items.filter(i => i.category === this.filter);
    }
}">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-[50%] h-[50%] bg-white rounded-full blur-[150px] -translate-y-1/2 translate-x-1/2"></div>
    
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 lg:gap-12 mb-12 lg:mb-20">
            <div class="max-w-2xl">
                <div class="flex items-center gap-4 mb-4 sm:mb-6">
                    <span class="w-10 sm:w-12 h-[2px] bg-primary"></span>
                    <span class="text-primary font-black text-[10px] sm:text-xs uppercase tracking-[0.4em]">Dokumentasi Lapangan</span>
                </div>
                <h2 class="text-3xl sm:text-5xl lg:text-6xl xl:text-7xl font-heading font-black text-secondary leading-none tracking-tighter">
                    Galeri Hasil <br class="hidden sm:block"> <span class="text-primary italic">Kerja Nyata.</span>
                </h2>
            </div>

            <!-- Custom Filter Tabs -->
            <div class="w-full lg:w-auto mt-8 lg:mt-0">
                <div class="bg-white p-1.5 sm:p-2 rounded-2xl sm:rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 flex items-center overflow-x-auto no-scrollbar focus-within:ring-2 ring-primary/10">
                    <div class="flex items-center gap-1.5 sm:gap-2 px-1">
                        <template x-for="cat in ['All', 'Residential', 'Commercial', 'Specialized']">
                            <button 
                                @click="filter = cat"
                                :class="filter === cat ? 'bg-secondary text-white shadow-lg' : 'text-gray-400 hover:text-secondary hover:bg-stone-50'"
                                class="flex-shrink-0 px-5 sm:px-8 py-2.5 sm:py-3.5 rounded-xl sm:rounded-2xl text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-500"
                                x-text="cat">
                            </button>
                        </template>
                    </div>
                </div>
                <!-- Mini Scroll Hint for Mobile -->
                <div class="flex lg:hidden justify-center mt-3">
                    <div class="flex gap-1">
                        <div class="w-1 h-1 rounded-full bg-primary/20"></div>
                        <div class="w-4 h-1 rounded-full bg-primary/40"></div>
                        <div class="w-1 h-1 rounded-full bg-primary/20"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bento-Style Dense Grid (Fixed Gaps) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 grid-flow-dense gap-6 lg:gap-8">
            <template x-for="(item, index) in filteredItems" :key="index">
                <div 
                    x-show="true"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    @click="activeItem = item"
                    class="group relative cursor-pointer"
                    :class="{ 
                        'lg:col-span-2 lg:row-span-2': index % 10 === 0, 
                        'lg:col-span-2': index % 10 === 3 || index % 10 === 7,
                        'lg:row-span-2': index % 10 === 5
                    }">
                    
                    <div class="relative w-full h-full min-h-[300px] lg:min-h-0 rounded-[2.5rem] overflow-hidden bg-secondary shadow-2xl transition-all duration-700 group-hover:-translate-y-4">
                        <!-- Main Image -->
                        <img :src="item.img" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 opacity-80 group-hover:opacity-100">
                        
                        <!-- Premium Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary via-secondary/20 to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-500"></div>
                        
                        <!-- Content Overlay -->
                        <div class="absolute inset-0 p-10 flex flex-col justify-end translate-y-6 group-hover:translate-y-0 transition-transform duration-500">
                            <div class="flex items-center gap-3 mb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                                <span class="px-4 py-1.5 rounded-full bg-primary text-white text-[9px] font-black uppercase tracking-widest" x-text="item.category"></span>
                                <div class="w-10 h-[1px] bg-white/30"></div>
                            </div>
                            <h3 class="text-white text-2xl font-heading font-black leading-tight tracking-tight mb-2 group-hover:text-primary transition-colors" x-text="item.title"></h3>
                            <div class="flex items-center gap-2 overflow-hidden max-h-0 group-hover:max-h-20 transition-all duration-700">
                                <p class="text-gray-400 text-xs font-medium italic">Lihat detail pengerjaan</p>
                                <i class="ri-arrow-right-line text-primary"></i>
                            </div>
                        </div>

                        <!-- Scanline Effect -->
                        <div class="absolute inset-x-0 top-0 h-[1px] bg-white/20 -translate-y-full group-hover:translate-y-[500%] transition-all duration-[3000ms] ease-linear"></div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty State -->
        <div x-show="filteredItems.length === 0" class="py-40 text-center">
            <i class="ri-search-eye-line text-8xl text-gray-200 mb-8 block"></i>
            <h3 class="text-2xl font-heading font-black text-secondary tracking-tight">Tidak ada dokumentasi ditemukan.</h3>
            <p class="text-gray-400 mt-2">Coba pilih kategori dokumentasi lapangan lainnya.</p>
        </div>
    </div>

    <!-- Immersive Modal Lightbox -->
    <template x-teleport="body">
        <div x-show="activeItem" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-10"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @keydown.escape.window="activeItem = null">
            
            <div @click="activeItem = null" class="absolute inset-0 bg-secondary/90 backdrop-blur-2xl"></div>
            
            <div class="w-full max-w-6xl bg-white rounded-[2.5rem] sm:rounded-[4rem] overflow-hidden shadow-2xl relative z-10 flex flex-col lg:flex-row h-fit max-h-[92vh]">
                
                <!-- Close Button -->
                <button @click="activeItem = null" 
                        class="absolute top-4 sm:top-6 right-4 sm:right-6 z-50 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/10 lg:bg-secondary/10 backdrop-blur-xl border border-white/20 lg:border-secondary/10 flex items-center justify-center text-white lg:text-secondary hover:bg-primary hover:text-white hover:border-primary hover:scale-110 transition-all duration-300 shadow-xl group">
                    <i class="ri-close-line text-xl sm:text-2xl group-hover:rotate-90 transition-transform duration-500"></i>
                </button>

                <!-- Image Area -->
                <div class="w-full lg:w-7/12 aspect-video lg:aspect-auto bg-stone-900 flex items-center justify-center overflow-hidden relative min-h-[250px] lg:min-h-0">
                    <img :src="activeItem?.img" class="w-full h-full object-cover" :alt="activeItem?.title">
                    
                    <!-- Category Badge -->
                    <div class="absolute bottom-6 left-6 flex items-center gap-3">
                        <span class="px-4 sm:px-5 py-2 rounded-full bg-primary/90 backdrop-blur-md text-white text-[9px] sm:text-[10px] font-black uppercase tracking-widest shadow-xl" x-text="activeItem?.category"></span>
                    </div>
                </div>
                
                <!-- Details Area -->
                <div class="w-full lg:w-5/12 p-8 sm:p-12 lg:p-16 flex flex-col justify-between overflow-y-auto no-scrollbar bg-white">
                    <div>
                        <div class="flex items-center gap-4 mb-6 sm:mb-8">
                            <span class="w-10 h-[2px] bg-primary"></span>
                            <span class="text-primary font-black text-[10px] sm:text-xs uppercase tracking-[0.3em]">Project Overview</span>
                        </div>
                        
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-heading font-black text-secondary leading-tight tracking-tighter mb-6 sm:mb-8" x-text="activeItem?.title"></h2>
                        
                        <div class="space-y-4 sm:space-y-6">
                            <div class="flex items-start gap-4 p-4 rounded-2xl sm:rounded-3xl bg-stone-50 border border-gray-100 hover:border-primary/20 transition-colors">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-primary/10 flex items-center justify-center text-primary shrink-0 shadow-inner">
                                    <i class="ri-checkbox-circle-fill text-lg sm:text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-secondary font-black text-[10px] sm:text-xs uppercase tracking-wider mb-1">Metode Modern</h4>
                                    <p class="text-gray-500 text-[11px] sm:text-[13px] leading-relaxed font-medium">Pengerjaan modern tanpa merusak struktur pipa bangunan Anda.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4 p-4 rounded-2xl sm:rounded-3xl bg-stone-50 border border-gray-100 hover:border-accent/20 transition-colors">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-accent/10 flex items-center justify-center text-accent shrink-0 shadow-inner">
                                    <i class="ri-shield-check-fill text-lg sm:text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-secondary font-black text-[10px] sm:text-xs uppercase tracking-wider mb-1">Garansi Penuh</h4>
                                    <p class="text-gray-500 text-[11px] sm:text-[13px] leading-relaxed font-medium">Garansi pelancaran kembali jika terjadi mampet di masa garansi.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 sm:mt-12 pt-6 sm:pt-8 border-t border-gray-100 flex flex-col gap-4">
                        <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281246668749') }}" class="w-full flex items-center justify-center gap-4 bg-secondary py-4 sm:py-5 rounded-xl sm:rounded-2xl text-white font-black uppercase tracking-widest text-[10px] sm:text-xs hover:bg-primary transition-all duration-300 group shadow-xl shadow-secondary/10 hover:shadow-primary/20">
                             <i class="ri-whatsapp-line text-lg sm:text-xl"></i>
                             <span>Konsultasi Serupa</span>
                             <i class="ri-arrow-right-line group-hover:translate-x-2 transition-transform"></i>
                        </a>
                        <p class="text-center text-[9px] sm:text-[10px] text-gray-400 font-bold uppercase tracking-widest italic opacity-60">Gratis Konsultasi & Estimasi Biaya</p>
                    </div>
                </div>
            </div>
        </div>
    </template>
</section>
