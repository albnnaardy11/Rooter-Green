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
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-12 mb-20">
            <div class="max-w-2xl">
                <x-section-heading :title="$title" :subtitle="$subtitle" align="left" />
            </div>
            
            <!-- Category Filters -->
            <div class="relative bg-white/50 backdrop-blur-md p-1.5 rounded-full border border-gray-100 flex flex-wrap items-center gap-1 shadow-sm">
                @foreach(['all' => 'Terbaru', 'Residential' => 'Residential', 'Commercial' => 'Commercial'] as $key => $label)
                    <button @click="activeCategory = '{{ $key }}'" 
                            :class="activeCategory === '{{ $key }}' ? 'text-white bg-primary shadow-lg shadow-primary/20 scale-105' : 'text-gray-400 hover:text-primary hover:bg-primary/5'"
                            class="relative px-6 py-2 rounded-full font-black text-[10px] uppercase tracking-[0.2em] transition-all duration-500 z-10 flex items-center gap-2">
                        <template x-if="activeCategory === '{{ $key }}'">
                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                        </template>
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Gallery Grid - Portrait 9:16 -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-10">
            <template x-for="(item, index) in filteredItems.slice(0, 4)" :key="index">
                <div @click="openModal(index)"
                     class="group relative overflow-hidden rounded-[2.5rem] aspect-[9/16] shadow-2xl shadow-gray-200/30 hover:shadow-primary/20 transition-all duration-700 cursor-pointer bg-gray-200">
                    
                    <img :src="item.img" :alt="item.title" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" loading="lazy">
                    
                    <!-- Hover Content Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-secondary/90 via-secondary/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-6">
                        <span class="text-accent text-[10px] font-black uppercase tracking-widest mb-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500" x-text="item.category"></span>
                        <h4 class="text-white font-heading font-black text-sm sm:text-lg tracking-tight leading-tight transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-75" x-text="item.title"></h4>
                        
                        <div class="mt-4 flex items-center gap-2 text-white/40 text-[9px] font-bold uppercase tracking-widest transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-100">
                            <i class="ri-zoom-in-line"></i>
                            View Detail
                        </div>
                    </div>

                    <!-- Top Right Badge -->
                    <div class="absolute top-4 right-4 w-10 h-10 bg-primary/90 backdrop-blur-md rounded-2xl flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-xl scale-75 group-hover:scale-100">
                        <i class="ri-gallery-upload-line text-lg"></i>
                    </div>
                </div>
            </template>
        </div>

        <!-- Conversion Section -->
        <div class="mt-24 text-center">
             <div class="inline-block relative group">
                <div class="absolute -inset-6 bg-primary/20 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                
                <x-button href="https://wa.me/6281234567890?text=Halo%20Rooter%20Green%2C%20saya%20sudah%20melihat%20galeri%20hasil%20kerja%20Anda%20dan%20ingin%20pesan%20jasa..." variant="primary" class="relative z-10 !px-16 !py-6 !rounded-full shadow-2xl shadow-primary/30 text-lg hover:scale-105 transition-transform duration-500">
                    <span class="flex items-center gap-4">
                        Pesan Jasa Sekarang!
                        <i class="ri-whatsapp-line text-2xl animate-bounce-soft"></i>
                    </span>
                </x-button>
             </div>
             <p class="mt-10 text-gray-400 text-[10px] font-bold uppercase tracking-[0.3em] flex items-center justify-center gap-4">
                 <span class="w-12 h-[1px] bg-gray-200"></span>
                 Fast Response 24/7 Team
                 <span class="w-12 h-[1px] bg-gray-200"></span>
             </p>
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
                    <button @click="prev()" class="absolute left-0 z-20 w-14 h-14 bg-white/5 hover:bg-primary border border-white/10 rounded-full flex items-center justify-center text-white transition-all opacity-0 group-hover/slider:opacity-100 -translate-x-5 group-hover/slider:translate-x-10">
                        <i class="ri-arrow-left-s-line text-3xl"></i>
                    </button>

                    <!-- Consistent 9:16 Portrait Container (Fixed Height for Floating Look) -->
                    <div class="h-[65vh] sm:h-[70vh] aspect-[9/16] relative flex items-center justify-center overflow-hidden rounded-[2.5rem] shadow-[0_40px_100px_rgba(0,0,0,0.5)] border-2 border-white/20 bg-secondary">
                        <img :src="filteredItems[currentIndex]?.img" 
                                class="w-full h-full object-cover"
                                :key="currentIndex"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100">
                    </div>

                    <!-- Next -->
                    <button @click="next()" class="absolute right-0 z-20 w-14 h-14 bg-white/5 hover:bg-primary border border-white/10 rounded-full flex items-center justify-center text-white transition-all opacity-0 group-hover/slider:opacity-100 translate-x-5 group-hover/slider:translate-x-10">
                        <i class="ri-arrow-right-s-line text-3xl"></i>
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
