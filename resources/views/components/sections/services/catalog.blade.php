@props(['services'])

<section x-data="{ 
    activeCategory: null,
    categories: {{ json_encode($services->map(function($s, $index) {
        $colors = ['primary', 'accent', 'secondary'];
        return [
            'id' => chr(65 + $index),
            'title' => $s->name,
            'icon' => $s->icon,
            'color' => $colors[$index % 3],
            'items' => $s->items ?? [],
            'pricing' => $s->pricing ?? []
        ];
    })) }}
}" class="py-32 bg-white relative overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute top-1/2 left-0 w-72 h-72 bg-primary/5 rounded-full blur-3xl -translate-x-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent/5 rounded-full blur-3xl translate-x-1/3"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="mb-24 flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-4 mb-6">
                    <span class="w-12 h-[2px] bg-primary"></span>
                    <span class="text-primary font-black text-xs uppercase tracking-[0.4em]">Katalog Layanan</span>
                </div>
                <h2 class="text-4xl sm:text-6xl font-heading font-black text-secondary leading-tight tracking-tighter">
                    Solusi Tuntas <br> <span class="text-primary italic">Masalah Saluran.</span>
                </h2>
            </div>
            <div class="hidden md:block">
                <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest text-right">Premium Standards • Modern Tools • Guaranteed Results</p>
                <div class="flex gap-1 justify-end mt-4">
                    <div class="w-8 h-1 bg-primary rounded-full"></div>
                    <div class="w-2 h-1 bg-primary/20 rounded-full"></div>
                    <div class="w-2 h-1 bg-primary/20 rounded-full"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <template x-for="cat in categories" :key="cat.id">
                <div @click="activeCategory = (activeCategory === cat.id ? null : cat.id)"
                     class="group relative bg-stone-50 rounded-[3rem] p-10 cursor-pointer overflow-hidden transition-all duration-700 hover:-translate-y-4 border border-transparent"
                     :class="{
                        'border-primary/20 bg-white shadow-2xl shadow-primary/10 ring-4 ring-primary/5': activeCategory === cat.id,
                        'hover:border-gray-200': activeCategory !== cat.id
                     }">
                    
                    <!-- Card Background Decor -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>

                    <div class="relative z-10">
                        <!-- Icon & Badge -->
                        <div class="flex items-center justify-between mb-12">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl shadow-xl transition-all duration-500"
                                 :class="{
                                    'bg-primary text-white scale-110 rotate-6': activeCategory === cat.id,
                                    'bg-white text-gray-400 group-hover:text-primary group-hover:scale-110': activeCategory !== cat.id
                                 }">
                                <i :class="cat.icon"></i>
                            </div>
                            <span class="px-5 py-2 rounded-full bg-white text-[9px] font-black uppercase tracking-widest text-gray-400 border border-gray-100 shadow-sm" x-text="cat.pricing[0]?.price || 'Custom'"></span>
                        </div>

                        <!-- Content -->
                        <h3 class="text-2xl font-heading font-black text-secondary tracking-tight mb-4 group-hover:text-primary transition-colors" x-text="cat.title"></h3>
                        <p class="text-gray-500 text-sm font-medium leading-relaxed mb-8">Pengerjaan profesional menggunakan alat modern tanpa harus membongkar struktur bangunan.</p>
                        
                        <!-- List Snippet -->
                        <div class="flex flex-wrap gap-2 mb-8">
                            <template x-for="item in cat.items.slice(0, 3)" :key="item">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest" x-text="item + ' • '"></span>
                            </template>
                            <span class="text-[10px] font-bold text-primary uppercase tracking-widest">+ More</span>
                        </div>

                        <!-- Action Button -->
                        <button class="w-full py-4 rounded-2xl flex items-center justify-center gap-4 text-[10px] font-black uppercase tracking-widest transition-all duration-500 shadow-lg"
                                :class="activeCategory === cat.id ? 'bg-secondary text-white' : 'bg-white text-secondary group-hover:bg-primary group-hover:text-white'">
                            <span x-text="activeCategory === cat.id ? 'Tutup Detail' : 'Lihat Detail Layanan'"></span>
                            <i class="ri-arrow-right-line" :class="activeCategory === cat.id ? 'rotate-90' : ''"></i>
                        </button>
                    </div>

                    <!-- Scanline Effect -->
                    <div class="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent h-1 transition-all duration-1000 ease-linear pointer-events-none"
                         :class="activeCategory === cat.id ? 'translate-y-[400px]' : '-translate-y-full'"></div>
                </div>
            </template>
        </div>

        <!-- Immersive Service Modal -->
        <template x-teleport="body">
            <template x-for="cat in categories" :key="'modal-' + cat.id">
                <div x-show="activeCategory === cat.id"
                     class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-10"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     x-cloak>
                    
                    <!-- Backdrop -->
                    <div @click="activeCategory = null" class="absolute inset-0 bg-secondary/90 backdrop-blur-2xl"></div>
                    
                    <!-- Modal Container -->
                    <div class="w-full max-w-5xl bg-secondary rounded-[2.5rem] sm:rounded-[4rem] overflow-hidden shadow-2xl relative z-10 flex flex-col h-fit max-h-[92vh]">
                        
                        <!-- Close Button -->
                        <button @click="activeCategory = null" 
                                class="absolute top-4 sm:top-8 right-4 sm:right-8 z-50 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center text-white hover:bg-primary hover:scale-110 transition-all duration-300 shadow-xl group">
                            <i class="ri-close-line text-xl sm:text-2xl group-hover:rotate-90 transition-transform duration-500"></i>
                        </button>

                        <div class="p-8 sm:p-16 lg:p-20 text-white relative overflow-y-auto no-scrollbar">
                            <!-- Drawer Decor -->
                            <div class="absolute top-0 right-0 w-[60%] h-full bg-white/5 skew-x-12 -translate-y-1/2 pointer-events-none"></div>
                            
                            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
                                <!-- Left: Scope -->
                                <div>
                                    <div class="inline-flex items-center gap-4 mb-6 sm:mb-8">
                                        <div class="w-12 h-12 rounded-2xl bg-primary/20 flex items-center justify-center text-primary text-2xl">
                                            <i :class="cat.icon"></i>
                                        </div>
                                        <span class="text-primary font-black text-[10px] uppercase tracking-[0.4em]">Service Standards</span>
                                    </div>
                                    <h4 class="text-3xl sm:text-4xl lg:text-5xl font-heading font-black mb-8 sm:mb-12 tracking-tight leading-none" x-text="cat.title"></h4>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                        <template x-for="item in cat.items" :key="item">
                                            <div class="group flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/20 transition-all cursor-default">
                                                <div class="w-2 h-2 rounded-full bg-primary shadow-[0_0_15px_var(--color-primary)]"></div>
                                                <span class="text-[11px] sm:text-xs font-bold tracking-wide" x-text="item"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Right: Pricing & CTA -->
                                <div class="flex flex-col justify-between">
                                    <div>
                                        <div class="inline-flex items-center gap-4 mb-8">
                                            <span class="w-10 h-[1px] bg-primary"></span>
                                            <span class="text-primary font-black text-[10px] uppercase tracking-[0.4em]">Investment Info</span>
                                        </div>
                                        <div class="space-y-6">
                                            <template x-for="price in cat.pricing" :key="price.type">
                                                <div class="p-8 rounded-[2.5rem] bg-white text-secondary group shadow-2xl">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <p class="text-[9px] font-black uppercase tracking-widest text-primary/60" x-text="price.type"></p>
                                                        <div class="flex items-center gap-1">
                                                            <div class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></div>
                                                            <span class="text-[8px] font-black uppercase tracking-widest text-gray-400">Guaranteed</span>
                                                        </div>
                                                    </div>
                                                    <p class="text-4xl sm:text-5xl font-heading font-black text-secondary mb-4 tracking-tighter" x-text="price.price"></p>
                                                    <p class="text-[11px] font-bold text-gray-400 italic leading-relaxed" x-text="price.note"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="mt-12 pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center gap-6">
                                        <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281246668749') }}" class="w-full flex-1 bg-primary py-5 sm:py-6 rounded-2xl flex items-center justify-center gap-4 text-white font-black uppercase tracking-widest text-xs hover:scale-105 active:scale-95 transition-all shadow-xl shadow-primary/20">
                                            <i class="ri-whatsapp-line text-xl"></i>
                                            <span>Start Solution Now</span>
                                        </a>
                                        <div class="hidden sm:block w-px h-12 bg-white/10"></div>
                                        <p class="text-[9px] font-bold text-white/40 uppercase tracking-[0.2em] max-w-[150px] leading-relaxed">Modern Tech • No Digging • Full Warranty</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </template>
    </div>
</section>
