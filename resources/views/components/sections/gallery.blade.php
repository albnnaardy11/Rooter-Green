@props([
    'title' => 'Galeri Hasil Kerja Nyata',
    'subtitle' => 'DOKUMENTASI LAPANGAN',
    'items' => []
])

<section id="gallery" 
         x-data="{ 
            activeCategory: 'all', 
            items: {{ json_encode($items) }},
            modalOpen: false,
            currentIndex: 0,
            get filteredItems() {
                if (this.activeCategory === 'all') return this.items;
                return this.items.filter(item => item.category === this.activeCategory);
            },
            openModal(idx) {
                this.currentIndex = idx;
                this.modalOpen = true;
                document.body.style.overflow = 'hidden';
            },
            closeModal() {
                this.modalOpen = false;
                document.body.style.overflow = 'auto';
            },
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.filteredItems.length;
            },
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.filteredItems.length) % this.filteredItems.length;
            }
         }"
         @keydown.escape.window="closeModal()"
         @keydown.left.window="if(modalOpen) prev()"
         @keydown.right.window="if(modalOpen) next()"
         {{ $attributes->merge(['class' => 'py-32 bg-stone-50 overflow-hidden']) }}>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-10 mb-16 sm:mb-24">
            <div class="max-w-2xl">
                <x-section-heading :title="$title" :subtitle="$subtitle" align="left" />
            </div>
            
            <!-- Category Filters - Enhanced for Mobile -->
            <div class="flex items-center">
                <div class="inline-flex bg-white/40 backdrop-blur-xl p-1.5 rounded-2xl sm:rounded-full border border-gray-100/50 shadow-sm overflow-x-auto no-scrollbar max-w-full">
                    <div class="flex items-center gap-1 min-w-max">
                        @foreach(['all' => 'Terbaru', 'Residential' => 'Residential', 'Commercial' => 'Commercial'] as $key => $label)
                            <button @click="activeCategory = '{{ $key }}'" 
                                    :class="activeCategory === '{{ $key }}' ? 'text-white bg-primary shadow-lg shadow-primary/20 scale-105' : 'text-secondary/40 hover:text-primary hover:bg-primary/5'"
                                    class="relative px-6 sm:px-10 py-3 rounded-xl sm:rounded-full font-black text-[9px] uppercase tracking-[0.25em] transition-all duration-500 z-10 flex items-center gap-2 whitespace-nowrap">
                                <template x-if="activeCategory === '{{ $key }}'">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                </template>
                                {{ $label }}
                                
                                <!-- Active bar animation for mobile -->
                                <div x-show="activeCategory === '{{ $key }}'" 
                                     class="absolute inset-0 bg-primary -z-10 rounded-xl sm:rounded-full"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 scale-90"
                                     x-transition:enter-end="opacity-100 scale-100"></div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Grid - Bento Grid Style -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 lg:gap-8 auto-rows-[200px] sm:auto-rows-[300px]">
            <template x-for="(item, index) in filteredItems" :key="index">
                <div @click="openModal(index)"
                     class="group relative overflow-hidden rounded-[1.5rem] sm:rounded-[2.5rem] shadow-xl shadow-gray-200/50 hover:shadow-primary/30 transition-all duration-700 cursor-pointer bg-gray-100"
                     :class="{
                        'col-span-2 row-span-2': index === 0,
                        'col-span-1 row-span-1': index === 1 || index === 2 || index === 4 || index === 6 || index === 7 || index === 8 || index === 9,
                        'col-span-1 row-span-2': index === 3,
                        'col-span-2 row-span-1': index === 5
                     }">
                    
                    <img :src="item.img" :alt="item.title" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" loading="lazy">
                    
                    <!-- Premium Glass Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-secondary/95 via-secondary/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-4 sm:p-8">
                        <div class="transform translate-y-8 group-hover:translate-y-0 transition-transform duration-500">
                            <span class="inline-block px-3 py-1 bg-primary/20 backdrop-blur-md rounded-full text-primary text-[8px] sm:text-[10px] font-black uppercase tracking-widest mb-2 sm:mb-3" x-text="item.category"></span>
                            <h4 class="text-white font-heading font-black text-xs sm:text-xl tracking-tight leading-tight mb-2 sm:mb-4" x-text="item.title"></h4>
                            
                            <div class="flex items-center gap-2 sm:gap-3 text-white/60 text-[8px] sm:text-[11px] font-bold uppercase tracking-widest group/btn border-t border-white/10 pt-3 sm:pt-4">
                                <span class="w-6 sm:w-10 h-[1px] bg-white/20 group-hover/btn:w-16 transition-all duration-300"></span>
                                VIEW PROJECT
                            </div>
                        </div>
                    </div>

                    <!-- Visual Accent -->
                    <div class="absolute top-4 left-4 w-10 h-[1px] bg-white/30 transform -rotate-45 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                </div>
            </template>
        </div>

        <!-- Conversion Section - Enhanced -->
        <div class="mt-20 sm:mt-32 text-center relative">
             <div class="absolute left-1/2 -top-12 -translate-x-1/2 w-[1px] h-12 bg-gradient-to-b from-transparent to-gray-200 hidden sm:block"></div>
             
             <div class="inline-block relative group">
                <div class="absolute -inset-8 bg-primary/25 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                
                <x-button href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281246668749') }}?text=Halo%20Rooter%20Green%2C%20saya%20sudah%20melihat%20galeri%20hasil%20kerja%20Anda%20dan%20ingin%20pesan%20jasa..." variant="primary" class="relative z-10 !px-10 sm:!px-20 !py-4 sm:!py-7 !rounded-full shadow-2xl shadow-primary/30 text-sm sm:text-xl font-black hover:scale-105 transition-transform duration-500 overflow-hidden group/btn">
                    <span class="flex items-center gap-4">
                        Konsultasi Gratis Sekarang
                        <i class="ri-whatsapp-line text-xl sm:text-2xl animate-bounce-soft"></i>
                    </span>
                    <div class="absolute top-0 -left-full w-full h-full bg-white/20 skew-x-[45deg] group-hover/btn:left-[150%] transition-all duration-1000 ease-in-out"></div>
                </x-button>
             </div>
             
             <div class="mt-10 sm:mt-16 flex flex-col items-center gap-4">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.4em]">
                    Trusted by 1000+ Happy Customers
                </p>
                <div class="flex -space-x-3">
                    @for($i=1; $i<=5; $i++)
                        <img src="https://i.pravatar.cc/100?u={{ $i }}" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 sm:border-4 border-stone-50 shadow-sm" alt="User">
                    @endfor
                </div>
             </div>
        </div>
    </div>



    <!-- Lightbox Modal -->
    <template x-teleport="body">
        <div x-show="modalOpen" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-12"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-cloak>
            
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-secondary/95 backdrop-blur-2xl" @click="closeModal()"></div>
            
            <!-- Content -->
            <div class="relative w-full max-w-6xl h-full flex flex-col justify-center gap-8 z-10" x-show="modalOpen" x-transition:enter="transition ease-out duration-500 delay-100" x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                
                <!-- Modal Navigation & Info -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white shadow-lg">
                            <i class="ri-landscape-line text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-black text-xl leading-none mb-1" x-text="filteredItems[currentIndex]?.title"></h3>
                            <p class="text-primary text-[10px] font-black uppercase tracking-widest" x-text="filteredItems[currentIndex]?.category"></p>
                        </div>
                    </div>
                    <button @click="closeModal()" class="w-12 h-12 bg-white/10 hover:bg-white/20 border border-white/10 rounded-full flex items-center justify-center text-white transition-all group">
                        <i class="ri-close-line text-2xl group-hover:rotate-90 transition-transform"></i>
                    </button>
                </div>

                <!-- Slider Area -->
                <div class="flex-1 relative flex items-center justify-center px-4 sm:px-12 group/slider">
                    <!-- Prev -->
                    <button @click="prev()" class="absolute left-1 2xl:left-0 z-20 w-10 h-10 lg:w-14 lg:h-14 bg-white/20 2xl:bg-white/5 hover:bg-primary border border-white/20 2xl:border-white/10 rounded-full flex items-center justify-center text-white transition-all opacity-100 2xl:opacity-0 2xl:group-hover/slider:opacity-100 2xl:-translate-x-5 2xl:group-hover/slider:translate-x-10">
                        <i class="ri-arrow-left-s-line text-xl lg:text-3xl"></i>
                    </button>

                    <!-- Consistent 9:16 Portrait Container -->
                    <div class="h-[50vh] sm:h-[60vh] md:h-[65vh] lg:h-[70vh] aspect-[9/16] relative flex items-center justify-center overflow-hidden rounded-[2.5rem] shadow-[0_20px_60px_rgba(0,0,0,0.5)] border-2 border-white/20 bg-secondary">
                        <img :src="filteredItems[currentIndex]?.img" 
                                class="w-full h-full object-cover"
                                :key="currentIndex"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100">
                    </div>

                    <!-- Next -->
                    <button @click="next()" class="absolute right-1 2xl:right-0 z-20 w-10 h-10 lg:w-14 lg:h-14 bg-white/20 2xl:bg-white/5 hover:bg-primary border border-white/20 2xl:border-white/10 rounded-full flex items-center justify-center text-white transition-all opacity-100 2xl:opacity-0 2xl:group-hover/slider:opacity-100 2xl:translate-x-5 2xl:group-hover/slider:translate-x-10">
                        <i class="ri-arrow-right-s-line text-xl lg:text-3xl"></i>
                    </button>
                </div>

                <!-- Indicators -->
                <div class="flex flex-col items-center gap-4">
                    <div class="flex items-center gap-2">
                        <template x-for="(dot, i) in filteredItems" :key="i">
                            <button @click="currentIndex = i" 
                                    class="h-1.5 rounded-full transition-all duration-500"
                                    :class="currentIndex === i ? 'w-10 bg-primary' : 'w-2 bg-white/20 hover:bg-white/40'"></button>
                        </template>
                    </div>
                    <p class="text-white/40 text-[10px] font-bold uppercase tracking-[0.2em]">
                        Documentation <span class="text-white" x-text="currentIndex + 1"></span> / <span x-text="filteredItems.length"></span>
                    </p>
                </div>
            </div>
        </div>
    </template>
</section>
