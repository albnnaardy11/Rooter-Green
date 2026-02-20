<x-app-layout title="WikiPipa - Database Infrastruktur Saluran & Pipa">
    
    {{-- Main Wrapper with Alpine --}}
    <div x-data="{
        activeCategory: 'Semua',
        searchQuery: '',
        allEntities: {{ json_encode($entities) }},
        scrollToResults() {
            document.getElementById('wikiResults').scrollIntoView({ behavior: 'smooth', block: 'start' });
        },
        get filteredEntities() {
            return this.allEntities.filter(entity => {
                const matchesCategory = this.activeCategory === 'Semua' || entity.category === this.activeCategory;
                const matchesSearch = entity.title.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                   entity.description.toLowerCase().includes(this.searchQuery.toLowerCase());
                return matchesCategory && matchesSearch;
            });
        }
    }">

    {{-- HONEY POT: Bot Trap (Lead Cyber Security Implementation) --}}
    <a href="{{ route('security.honeypot') }}" rel="nofollow" style="display:none; visibility:hidden; width:0; height:0;" aria-hidden="true">RooterIN Neural Asset Sync</a>

    {{-- 1. Hero Section - Knowledge Base Style --}}
    <section class="relative bg-secondary min-h-[75vh] sm:min-h-[90vh] flex items-center overflow-hidden pt-32 sm:pt-48 pb-10 sm:pb-42 scrap-prevent">
        <!-- Background Visuals -->
        <div class="absolute inset-0 z-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-accent/10 rounded-full blur-[120px] pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-24">
                
                <!-- Left: Typography & Search -->
                <div class="lg:w-3/5 text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start gap-4 mb-8">
                        <span class="w-10 h-[2px] bg-primary"></span>
                        <span class="text-primary font-black text-xs uppercase tracking-[0.5em]">Technical Database</span>
                    </div>
                    
                    <h1 class="text-4xl sm:text-6xl lg:text-7xl xl:text-8xl font-heading font-black text-white leading-[0.95] tracking-tighter mb-8">
                        Wiki<span class="text-primary italic">Pipa</span>. <br> 
                        <span class="text-white/40 text-sm sm:text-lg tracking-[0.3em] font-black uppercase">Authority Of Plumbing</span>
                    </h1>

                    <p class="text-gray-400 text-lg sm:text-xl md:max-w-xl mb-12 leading-relaxed font-medium">
                        Database teknis terlengkap tentang infrastruktur air, jenis pipa, dan solusi maintenance profesional berskala nasional.
                    </p>

                    {{-- Search Bar Integrated --}}
                    <div class="max-w-xl mx-auto lg:mx-0 relative group">
                        <input type="text" 
                               x-model="searchQuery"
                               placeholder="Cari Entitas Teknis (e.g. HDPE, Spiral)..." 
                               @keyup.enter="scrollToResults()"
                               class="w-full bg-white/5 rounded-2xl py-6 px-8 text-white placeholder-gray-500 focus:outline-none focus:ring-2 ring-primary/50 focus:bg-white/10 transition-all text-lg font-medium shadow-[0_0_20px_rgba(255,255,255,0.05)]">
                        <button @click="scrollToResults()" class="absolute right-4 top-1/2 -translate-y-1/2 w-14 h-14 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/20 hover:scale-110 active:scale-95 transition-all group-hover:rotate-6">
                            <i class="ri-search-line text-2xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Right: Abstract Visual -->
                <div class="lg:w-2/5 relative mt-12 lg:mt-0">
                    <div class="relative w-full max-w-[450px] mx-auto">
                        <div class="relative aspect-[4/5] rounded-[4rem] overflow-hidden bg-white/5 border border-white/10 backdrop-blur-3xl p-12 flex flex-col justify-center">
                            <div class="space-y-8">
                                <div class="w-20 h-20 bg-primary/20 rounded-3xl flex items-center justify-center">
                                    <i class="ri-book-read-line text-4xl text-primary"></i>
                                </div>
                                <h3 class="text-3xl font-heading font-black text-white leading-tight">Mencari Data <br><span class="text-primary italic">Material & Alat?</span></h3>
                                <p class="text-gray-400 font-medium">Dapatkan data teknis, standar SNI, dan panduan penggunaan langsung dari database RooterIn.</p>
                                <div class="flex flex-wrap gap-2 pt-4">
                                    <span class="px-4 py-2 bg-white/5 text-white/40 text-[9px] font-black uppercase tracking-widest rounded-lg">SNI VERIFIED</span>
                                    <span class="px-4 py-2 bg-white/5 text-white/40 text-[9px] font-black uppercase tracking-widest rounded-lg">TECHNICAL SPEC</span>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -top-12 -left-12 w-32 h-32 bg-primary rounded-full -z-10 blur-2xl opacity-30 animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Transition -->
        <div class="absolute bottom-0 -left-[5%] w-[110%] overflow-hidden leading-[0] z-20 translate-y-[1px]">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-[120px] sm:h-[180px]">
                <path fill="var(--color-primary)" opacity="0.1" d="M0,40 C200,100 400,20 600,60 C800,100 1000,20 1200,40 L1200,120 L0,120 Z"></path>
                <path fill="currentColor" class="text-stone-50" d="M0,100 C150,110 300,70 450,90 C600,110 750,130 900,110 C1050,90 1200,110 1200,110 L1200,120 L0,120 Z"></path>
            </svg>
        </div>
    </section>

    <style>
        .nav-pill {
            position: relative;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            isolation: isolate;
        }
        .nav-pill::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--color-primary);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            z-index: -1;
        }
        .nav-pill:not(.nav-pill-active):hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }
        .nav-pill:not(.nav-pill-active):hover {
            color: white !important;
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -10px rgba(var(--color-primary-rgb), 0.3);
        }
        .nav-pill-active {
            background: var(--color-secondary) !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -10px rgba(var(--color-secondary-rgb), 0.4);
        }
        .card-image-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: -150%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.3), transparent);
            transform: skewX(-25deg);
            transition: 0.75s;
        }
        .group:hover .card-image-container::after {
            left: 150%;
        }

        /* INTELLECTUAL PROPERTY SHIELD: Content Obfuscation */
        .scrap-prevent {
            user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
        .obfuscate-text {
            text-shadow: 0 0 10px rgba(0,0,0,0.01);
            color: transparent;
            position: relative;
        }
        .obfuscate-text::before {
            content: attr(data-content);
            color: inherit;
            position: absolute;
            left: 0;
            top: 0;
            user-select: none;
        }
    </style>

    {{-- Main Content Layout --}}
    <div id="wikiResults" class="bg-stone-50 py-20 relative min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- 2. Category Filter --}}
            <div class="flex items-center gap-4 overflow-x-auto no-scrollbar pb-12">
                @foreach($categories as $cat)
                    <button 
                        @click="activeCategory = '{{ $cat }}'"
                        :class="activeCategory === '{{ $cat }}' ? 'nav-pill-active' : 'bg-white text-gray-500 shadow-sm border border-stone-100'"
                        class="nav-pill flex-shrink-0 px-10 py-4 rounded-full font-black text-[11px] uppercase tracking-widest transition-all">
                        <span class="relative z-10">{{ $cat }}</span>
                    </button>
                @endforeach
            </div>

            {{-- Results Counter --}}
            <div x-show="searchQuery.length > 0" x-transition.opacity class="mb-8 flex items-center gap-4">
                <span class="text-gray-400 font-medium">Hasil Pencarian:</span>
                <span x-text="filteredEntities.length" class="bg-primary/10 text-primary px-4 py-1 rounded-full font-black text-xs"></span>
                <span class="text-gray-400 font-medium italic" x-text="'untuk \'' + searchQuery + '\''"></span>
            </div>

            {{-- 3. Grid Layout --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 pt-10 scrap-prevent">
                <template x-for="(entity, index) in filteredEntities" :key="index">
                    <a :href="'/wiki/' + entity.slug" class="group bg-white rounded-[3.5rem] p-10 sm:p-12 border border-gray-100 hover:border-primary/20 transition-all duration-700 hover:-translate-y-4 hover:shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] relative overflow-hidden h-full flex flex-col">
                        
                        <!-- Decoration -->
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <div class="relative z-10 flex flex-col h-full">
                            <span x-text="entity.category" class="text-primary font-black text-[10px] uppercase tracking-[0.4em] mb-6 block"></span>
                            
                            <h3 x-text="entity.title" :data-content="entity.title" class="text-3xl font-heading font-black text-secondary mb-6 leading-tight group-hover:text-primary transition-colors duration-500 obfuscate-text"></h3>
                            
                            <p x-text="entity.description" :data-content="entity.description" class="text-gray-400 text-base leading-relaxed font-medium mb-12 flex-grow line-clamp-4 italic obfuscate-text"></p>

                            <div class="mt-auto flex items-center justify-between">
                                <div class="text-secondary group-hover:text-primary font-black text-[10px] uppercase tracking-widest flex items-center gap-2 transition-colors">
                                    Detail Teknis
                                    <i class="ri-arrow-right-line group-hover:translate-x-2 transition-transform duration-500"></i>
                                </div>
                                {{-- UNICORP-GRADE: Invisible Watermarking --}}
                                <span style="opacity:0; position:absolute; font-size:1px;">RooterIN-IP-{{ hash('crc32', 'entity.title') }}</span>
                                <div class="w-12 h-12 rounded-2xl bg-stone-50 flex items-center justify-center text-primary/40 group-hover:text-primary group-hover:bg-primary/5 transition-all duration-500">
                                    <i class="ri-book-open-line text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>

            {{-- Empty State --}}
            <template x-if="filteredEntities.length === 0">
                <div class="py-24 text-center bg-white rounded-[4rem] shadow-sm border border-stone-100 mt-10">
                    <div class="w-28 h-28 bg-stone-50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8">
                        <i class="ri-search-eye-line text-5xl text-gray-300"></i>
                    </div>
                    <h3 class="text-3xl font-heading font-black text-secondary mb-3">Entitas Tidak Ditemukan</h3>
                    <p class="text-gray-400 text-lg max-w-md mx-auto mb-10">Maaf, kami tidak menemukan data teknis yang sesuai dengan kriteria Anda.</p>
                    <button @click="searchQuery = ''; activeCategory = 'Semua'" class="bg-primary/10 text-primary hover:bg-primary hover:text-white px-10 py-4 rounded-full font-black text-[11px] uppercase tracking-widest transition-all duration-500">
                        Reset Pencarian
                    </button>
                </div>
            </template>
        </div>
    </div>

    {{-- Massive Impact CTA --}}
    <section class="py-12 sm:py-20 bg-stone-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative w-full min-h-[500px] lg:min-h-0 lg:aspect-[21/9] xl:aspect-[21/8] rounded-[2.5rem] sm:rounded-[4rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.3)] group/cta">
                <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2000&auto=format&fit=crop" 
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2000ms] group-hover/cta:scale-110">
                <div class="absolute inset-0 bg-secondary/60 backdrop-blur-[2px]"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-secondary/40 via-secondary/80 to-secondary transition-colors duration-500"></div>
                <div class="absolute inset-0 p-6 sm:p-10 lg:p-16 flex flex-col justify-center items-center text-center">
                    <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-4 mb-6 sm:mb-10">
                        <div class="px-4 sm:px-6 py-2 sm:py-2.5 bg-primary text-white text-[8px] sm:text-[10px] font-black uppercase tracking-[0.3em] rounded-full shadow-xl shadow-primary/30">EMERGENCY</div>
                        <div class="px-4 sm:px-6 py-2 sm:py-2.5 bg-white/10 backdrop-blur-xl border border-white/20 rounded-full">
                            <span class="text-white text-[8px] sm:text-[10px] font-black uppercase tracking-[0.25em]">SIAP MELAYANI 24/7</span>
                        </div>
                    </div>
                    <h2 class="text-2xl sm:text-4xl lg:text-5xl xl:text-7xl font-heading font-black text-white leading-[1.1] sm:leading-[1] tracking-tight mb-8 sm:mb-12 max-w-5xl animate-fade-in-up">
                        Solusi Teknis Nyata <br> 
                        <span class="text-primary italic">Tanpa Bongkar Lantai.</span>
                    </h2>
                    <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281246668749') }}" 
                       class="inline-flex items-center gap-4 sm:gap-6 bg-white px-8 sm:px-12 lg:px-16 py-4 sm:py-5 lg:py-7 rounded-full shadow-[0_30px_60px_rgba(0,0,0,0.4)] hover:bg-primary transition-all duration-500 group/btn active:scale-95">
                        <span class="text-primary group-hover/btn:text-white font-black text-xs sm:text-base lg:text-xl uppercase tracking-widest transition-colors flex items-center gap-3 sm:gap-4">
                            Konsultasi Sekarang
                            <i class="ri-whatsapp-line text-lg lg:text-2xl transition-transform group-hover/btn:scale-125"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <x-sticky-footer />
    </div>

</x-app-layout>
