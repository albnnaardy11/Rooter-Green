<x-app-layout title="Tips & Trik Perawatan Pipa - RooterIN">
    
    @php
        $categories = ['Semua', 'Dapur', 'Kamar Mandi', 'Pipa Industri', 'Tips Hemat'];
        $posts = [
            [
                'title' => 'Cara Darurat Atasi Wastafel Mampet Tanpa Bongkar',
                'excerpt' => 'Wastafel mampet di tengah malam? Jangan panik. Berikut adalah panduan langkah demi langkah menggunakan bahan rumahan sebelum memanggil teknisi profesional.',
                'category' => 'Dapur',
                'readTime' => '5 min read',
                'img' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=1200&q=80',
                'date' => '20 Feb 2024',
                'featured' => true
            ],
            [
                'title' => '5 Tanda Pipa Pembuangan Anda Mulai Berkerak',
                'excerpt' => 'Kenali tanda-tanda awal sebelum pipa benar-benar mampet total dan merusak lantai Anda.',
                'category' => 'Tips Hemat',
                'readTime' => '3 min read',
                'img' => 'https://images.unsplash.com/photo-1585955123058-930415956a69?w=800&q=80',
                'featured' => false
            ],
            [
                'title' => 'Mengapa Grease Trap Penting Untuk Restoran?',
                'excerpt' => 'Untuk pemilik bisnis kuliner, menjaga aliran pipa adalah kunci kelancaran operasional harian.',
                'category' => 'Pipa Industri',
                'readTime' => '4 min read',
                'img' => 'https://images.unsplash.com/photo-1521207418485-99c705420785?w=800&q=80',
                'featured' => false
            ],
            [
                'title' => 'Bahaya Menggunakan Soda Api Pada Pipa PVC',
                'excerpt' => 'Banyak yang mengira soda api adalah solusi, padahal bisa berakibat fatal bagi pipa plastik.',
                'category' => 'Kamar Mandi',
                'readTime' => '6 min read',
                'img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&q=80',
                'featured' => false
            ],
            [
                'title' => 'Cara Membersihkan Toren Air Agar Bebas Lumut',
                'excerpt' => 'Panduan sterilisasi tangki air untuk menjaga kesehatan air bersih keluarga Anda.',
                'category' => 'Tips Hemat',
                'readTime' => '4 min read',
                'img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=800&q=80',
                'featured' => false
            ],
            [
                'title' => 'Peralatan Plumbing Modern yang Digunakan RooterIN',
                'excerpt' => 'Mengetahui teknologi di balik layanan kami: dari kamera inspeksi hingga jetting machine.',
                'category' => 'Pipa Industri',
                'readTime' => '5 min read',
                'img' => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=800&q=80',
                'featured' => false
            ],
            [
                'title' => 'Mitos vs Fakta Seputar Saluran Pembuangan',
                'excerpt' => 'Apakah ampas kopi benar-benar bisa membersihkan pipa? Temukan jawabannya di sini.',
                'category' => 'Semua',
                'readTime' => '3 min read',
                'img' => 'https://images.unsplash.com/photo-1517646287270-a5a9ca602e5c?w=800&q=80',
                'featured' => false
            ],
            [
                'title' => 'Tips Memilih Kran Air Berkualitas untuk Kamar Mandi',
                'excerpt' => 'Jangan biarkan kebocoran kecil merusak dompet Anda. Pilih kran yang tahan lama.',
                'category' => 'Kamar Mandi',
                'readTime' => '4 min read',
                'img' => 'https://images.unsplash.com/photo-1584622781564-1d9876a13d10?w=800&q=80',
                'featured' => false
            ],
        ];
    @endphp

    {{-- 1. Hero Section - Brand DNA Style --}}
    <section class="relative bg-secondary min-h-[75vh] sm:min-h-[95vh] flex items-center overflow-hidden pt-20 sm:pt-46 lg:pt-42 pb-10 sm:pb-46 sm:pb-42">
        <!-- Background Visuals -->
        <div class="absolute inset-0 z-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-accent/10 rounded-full blur-[120px] pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-24">
                
                <!-- Left: Typography & Search -->
                <div class="lg:w-3/5 text-center lg:text-left order-2 lg:order-1">
                    <div class="flex items-center justify-center lg:justify-start gap-4 mb-8">
                        <span class="w-10 h-[2px] bg-primary"></span>
                        <span class="text-primary font-black text-xs uppercase tracking-[0.5em]">Knowledge Hub</span>
                    </div>
                    
                    <h1 class="text-4xl sm:text-6xl lg:text-7xl xl:text-8xl font-heading font-black text-white leading-[0.95] tracking-tighter mb-8">
                        Tips & Trik <br> 
                        <span class="text-primary italic relative">
                            Solusi Pipa.
                        </span>
                    </h1>

                    <p class="text-gray-400 text-lg sm:text-xl md:max-w-xl mb-12 leading-relaxed font-medium">
                        Cari solusi mandiri atau pelajari cara merawat instalasi pipa Anda dengan panduan dari para ahli plumbing RooterIN.
                    </p>

                    {{-- Search Bar Integrated --}}
                    <div class="max-w-xl mx-auto lg:mx-0 relative group animate-fade-in-up delay-150">
                        <input type="text" 
                               id="blogSearchInput"
                               placeholder="Cari Solusi Pipa Anda..." 
                               class="w-full bg-white/5 rounded-2xl py-6 px-8 text-white placeholder-gray-500 focus:outline-none focus:ring-2 ring-primary/50 focus:bg-white/10 transition-all text-lg font-medium shadow-[0_0_20px_rgba(255,255,255,0.05)]">
                        <button class="absolute right-4 top-1/2 -translate-y-1/2 w-14 h-14 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/20 hover:scale-110 active:scale-95 transition-all group-hover:rotate-6">
                            <i class="ri-search-line text-2xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Right: Featured Visual -->
                <div class="lg:w-2/5 order-1 lg:order-2 relative mt-12 lg:mt-0">
                    <div class="relative w-full max-w-[450px] mx-auto">
                        <div class="relative aspect-[4/5] rounded-[4rem] overflow-hidden shadow-[0_0_80px_rgba(255,255,255,0.1),0_50px_100px_-20px_rgba(0,0,0,0.5)] group">
                            <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=1200&auto=format&fit=crop" 
                                 class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-110" 
                                 alt="Plumbing Expert Tips">
                            <div class="absolute inset-0 bg-gradient-to-t from-secondary via-transparent to-transparent opacity-60"></div>
                            
                            <div class="absolute bottom-8 left-8 right-8 bg-white/10 backdrop-blur-2xl p-6 rounded-[2.5rem] shadow-[0_0_40px_rgba(255,255,255,0.1)]">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg shadow-primary/20">
                                        <i class="ri-lightbulb-flash-line text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-white font-black text-xs uppercase tracking-widest leading-none">Smart Guides</p>
                                        <p class="text-white/60 text-[10px] uppercase font-bold mt-1">Verified Expert Insight</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -top-12 -left-12 w-32 h-32 bg-primary rounded-full -z-10 blur-2xl opacity-30 animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Transition (Triple-Layered Premium Wave) -->
        <div class="absolute bottom-0 -left-[5%] w-[110%] overflow-hidden leading-[0] z-20 translate-y-[1px]">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-[120px] sm:h-[180px]">
                <path fill="var(--color-primary)" opacity="0.1" d="M0,40 C200,100 400,20 600,60 C800,100 1000,20 1200,40 L1200,120 L0,120 Z" class="animate-wave-slow"></path>
                <path fill="var(--color-primary)" opacity="0.2" d="M0,70 C300,120 600,20 900,70 C1050,95 1150,110 1200,80 L1200,120 L0,120 Z" class="animate-wave-mid"></path>
                <path fill="currentColor" class="text-stone-50" d="M0,100 C150,110 300,70 450,90 C600,110 750,130 900,110 C1050,90 1200,110 1200,110 L1200,120 L0,120 Z"></path>
            </svg>
        </div>
    </section>

    <style>
        @keyframes wave {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(-20px); }
        }
        .animate-wave-slow { animation: wave 10s ease-in-out infinite; }
        .animate-wave-mid { animation: wave 7s ease-in-out infinite; }
        
        /* Premium Hover System - Fixed */
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
            box-shadow: 0 15px 30px -10px rgba(var(--color-primary-rgb), 0.3), 0 0 30px white;
        }

        .nav-pill-active {
            background: var(--color-secondary) !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -10px rgba(var(--color-secondary-rgb), 0.4), 0 0 40px white;
        }

        /* Magnetic Circle Button */
        .btn-circle-premium {
            position: relative;
            z-index: 1;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .btn-circle-premium::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: var(--color-primary);
            border-radius: 40%;
            transform: translateY(100%) rotate(0deg);
            transition: transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
            z-index: -1;
        }
        .group:hover .btn-circle-premium::after {
            transform: translateY(0) rotate(180deg);
        }
        .group:hover .btn-circle-premium {
            transform: scale(1.1) rotate(5deg);
            color: white !important;
        }
        
        .hover-arrow {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .group:hover .hover-arrow-right {
            transform: translateX(8px) scale(1.2);
        }
        .group:hover .hover-arrow-up {
            transform: translate(5px, -5px) scale(1.1);
        }

        /* Card Shine Effect */
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

        /* Text Underline Animation */
        .link-premium {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        .link-premium::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: currentColor;
            transition: width 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .link-premium:hover::after {
            width: 100%;
        }
    </style>

    {{-- Main Content Layout --}}
    <div x-data="{
        activeCategory: 'Semua',
        searchQuery: '',
        currentPage: 1,
        postsPerPage: 5,
        allPosts: {{ json_encode($posts) }},
        init() {
            const searchInput = document.getElementById('blogSearchInput');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    this.searchQuery = e.target.value;
                    this.currentPage = 1;
                });
            }
        },
        get filteredPosts() {
            return this.allPosts.filter(post => {
                const matchesCategory = this.activeCategory === 'Semua' || post.category === this.activeCategory;
                const matchesSearch = post.title.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                   post.excerpt.toLowerCase().includes(this.searchQuery.toLowerCase());
                return matchesCategory && matchesSearch;
            });
        },
        get featuredPost() {
            const matches = this.filteredPosts;
            if (matches.length === 0) return null;
            const featured = matches.find(p => p.featured);
            return featured || matches[0];
        },
        get regularPosts() {
            const matches = this.filteredPosts;
            if (matches.length === 0) return [];
            
            const featured = this.featuredPost;
            const others = matches.filter(p => p !== featured);
            
            const start = (this.currentPage - 1) * this.postsPerPage;
            return others.slice(start, start + this.postsPerPage);
        },
        get totalPages() {
            const matches = this.filteredPosts;
            const featured = this.featuredPost;
            const othersCount = featured ? matches.length - 1 : matches.length;
            return Math.ceil(othersCount / this.postsPerPage) || 1;
        },
        setCategory(cat) {
            this.activeCategory = cat;
            this.currentPage = 1;
        }
    }" class="bg-stone-50 py-20 relative min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- 2. Category Filter --}}
            <div class="flex items-center gap-4 overflow-x-auto no-scrollbar pt-10 pb-12">
                @foreach($categories as $cat)
                    <button 
                        @click="setCategory('{{ $cat }}')"
                        :class="activeCategory === '{{ $cat }}' ? 'nav-pill-active' : 'bg-white text-gray-500 shadow-[0_0_40px_white]'"
                        class="nav-pill flex-shrink-0 px-10 py-4 rounded-full font-black text-[11px] uppercase tracking-widest transition-all">
                        <span class="relative z-10">{{ $cat }}</span>
                    </button>
                @endforeach
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                {{-- Left Side: Articles --}}
                <div class="lg:w-2/3 space-y-16">
                    
                    {{-- Featured Article --}}
                    <template x-if="featuredPost">
                        <div class="group relative bg-white rounded-[4rem] overflow-hidden shadow-[0_35px_80px_-20px_rgba(0,0,0,0.06),0_0_60px_white] transition-all duration-700 hover:-translate-y-2 hover:shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1),0_0_80px_white]">
                            <div class="flex flex-col lg:flex-row items-stretch">
                                <!-- Image Column -->
                                <div class="lg:w-[45%] h-[350px] lg:h-auto overflow-hidden relative">
                                    <img :src="featuredPost.img" class="w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-tr from-secondary/20 to-transparent"></div>
                                    <div class="absolute top-8 left-8">
                                        <span x-text="featuredPost.category" class="px-6 py-2.5 bg-white/90 backdrop-blur-xl text-primary text-[10px] font-black uppercase tracking-[0.2em] rounded-xl shadow-lg"></span>
                                    </div>
                                </div>
                                
                                <!-- Content Column -->
                                <div class="lg:w-[55%] p-10 lg:p-14 xl:p-20 flex flex-col">
                                    <div class="flex items-center gap-4 mb-10 text-gray-400 font-bold text-[10px] uppercase tracking-widest">
                                        <div class="flex items-center gap-2">
                                            <i class="ri-calendar-event-line text-primary"></i>
                                            <span x-text="featuredPost.date"></span>
                                        </div>
                                        <div class="w-1.5 h-1.5 rounded-full bg-gray-200"></div>
                                        <div class="flex items-center gap-2 text-secondary">
                                            <i class="ri-time-line text-primary"></i>
                                            <span x-text="featuredPost.readTime"></span>
                                        </div>
                                    </div>

                                    <h2 x-text="featuredPost.title" class="text-3xl lg:text-4xl xl:text-5xl font-heading font-black text-secondary leading-[1.15] mb-8 group-hover:text-primary transition-colors duration-500 tracking-tight"></h2>
                                    
                                    <p x-text="featuredPost.excerpt" class="text-gray-500 text-base lg:text-lg leading-relaxed mb-12 flex-grow"></p>
                                    
                                    <div class="flex items-center justify-between pt-10 border-t border-gray-50">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-stone-50 flex items-center justify-center text-secondary border border-gray-100">
                                                <i class="ri-user-star-line text-lg"></i>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-black uppercase tracking-widest text-secondary">Author</p>
                                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">RooterIN Expert</p>
                                            </div>
                                        </div>
                                        
                                        <a href="{{ route('tips.detail') }}" class="group/btn flex items-center gap-4 py-4 px-8 bg-secondary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-primary transition-all shadow-xl shadow-secondary/10 active:scale-95">
                                            <span>Baca Full Artikel</span>
                                            <div class="w-5 h-5 bg-white/10 rounded-full flex items-center justify-center group-hover/btn:translate-x-1 transition-transform">
                                                <i class="ri-arrow-right-line text-xs"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Empty State --}}
                    <template x-if="filteredPosts.length === 0">
                        <div class="py-24 text-center bg-white rounded-[4rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.05),0_0_60px_white] overflow-hidden relative group">
                            <div class="absolute inset-0 bg-gradient-to-b from-stone-50/50 to-transparent -z-10"></div>
                            <div class="w-28 h-28 bg-stone-50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 shadow-inner group-hover:rotate-12 transition-transform duration-500">
                                <i class="ri-search-eye-line text-5xl text-gray-300"></i>
                            </div>
                            <h3 class="text-3xl font-heading font-black text-secondary mb-3">Pencarian Tidak Ditemukan</h3>
                            <p class="text-gray-400 text-lg max-w-md mx-auto mb-10">Maaf, kami tidak menemukan artikel yang sesuai dengan kriteria Anda.</p>
                            <button @click="searchQuery = ''; activeCategory = 'Semua'; document.getElementById('blogSearchInput').value = ''" 
                                    class="px-10 py-4 bg-secondary text-white rounded-full font-black text-xs uppercase tracking-[0.2em] hover:bg-primary transition-all hover:scale-105 active:scale-95 shadow-xl shadow-secondary/20">
                                Hapus Semua Filter
                            </button>
                        </div>
                    </template>

                    {{-- Article Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <template x-for="(post, index) in regularPosts" :key="index">
                            <div class="group bg-white rounded-[3rem] overflow-hidden shadow-[0_20px_40px_-5px_rgba(0,0,0,0.03),0_0_40px_white] transition-all duration-700 hover:-translate-y-3 hover:shadow-[0_40px_80px_-15px_rgba(0,0,0,0.08),0_0_60px_white]">
                                <div class="h-72 relative overflow-hidden card-image-container">
                                    <img :src="post.img" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[2500ms]">
                                    <div class="absolute top-6 left-6">
                                        <span x-text="post.category" class="px-5 py-2 bg-white/95 backdrop-blur-md text-secondary text-[9px] font-black uppercase tracking-widest rounded-full shadow-xl"></span>
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-secondary/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                </div>
                                <div class="p-10">
                                    <h3 x-text="post.title" class="text-2xl font-heading font-black text-secondary mb-5 group-hover:text-primary transition-all duration-300 leading-tight"></h3>
                                    <p x-text="post.excerpt" class="text-gray-500 text-sm leading-relaxed mb-10 line-clamp-2 italic"></p>
                                    <div class="flex items-center justify-between pt-8 shadow-[0_-20px_40px_-10px_white]">
                                        <div class="flex items-center gap-2 text-gray-400 font-bold text-[9px] uppercase tracking-widest">
                                            <i class="ri-time-line text-primary text-base"></i>
                                            <span x-text="post.readTime"></span>
                                        </div>
                                        <a href="{{ route('tips.detail') }}" class="btn-circle-premium w-14 h-14 rounded-2xl bg-stone-50 flex items-center justify-center text-secondary shadow-[0_0_20px_white]">
                                            <i class="ri-arrow-right-up-line text-xl hover-arrow hover-arrow-up"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Pagination --}}
                    <template x-if="totalPages > 1">
                        <div class="flex justify-center pt-12">
                            <nav class="inline-flex gap-4 p-3 bg-white rounded-[2rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.03),0_0_40px_white]">
                                <template x-for="page in totalPages" :key="page">
                                    <button 
                                        @click="currentPage = page; window.scrollTo({top: 800, behavior: 'smooth'})"
                                        :class="currentPage === page ? 'bg-secondary text-white shadow-[0_10px_20px_-5px_rgba(var(--color-secondary-rgb),0.5)]' : 'text-gray-400 hover:text-primary hover:bg-stone-50 hover:shadow-[0_0_20px_white]'"
                                        class="w-14 h-14 rounded-2xl flex items-center justify-center font-black transition-all transform active:scale-90 text-[11px] tracking-widest"
                                        x-text="page">
                                    </button>
                                </template>
                            </nav>
                        </div>
                    </template>
                </div>

                {{-- Right Side: Sidebar --}}
                <div class="lg:w-1/3">
                    <div class="sticky top-32 space-y-8">
                        
                        {{-- Emergency Widget --}}
                        <div class="relative bg-secondary rounded-[3rem] p-10 overflow-hidden shadow-2xl group">
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                            <div class="relative z-10 text-center">
                                <div class="w-20 h-20 bg-primary/20 rounded-3xl mx-auto mb-8 flex items-center justify-center">
                                    <i class="ri-alarm-warning-fill text-primary text-4xl animate-pulse"></i>
                                </div>
                                <h3 class="text-white font-heading font-black text-2xl mb-4 leading-tight">Pipa Mampet Parah?<br><span class="text-primary italic">Jangan Bongkar Sendiri!</span></h3>
                                <p class="text-gray-400 text-sm mb-8">Tindakan salah bisa merusak struktur pipa. Hubungi teknisi ahli kami sekarang juga.</p>
                                <x-button href="https://wa.me/6281234567890" variant="primary" class="w-full !py-5 !rounded-2xl group/btn overflow-hidden transition-all hover:scale-[1.02] active:scale-95">
                                    <span class="flex items-center justify-center gap-3">
                                        <i class="ri-whatsapp-line text-xl"></i>
                                        <span class="font-black uppercase tracking-widest text-xs">Panggil Bantuan</span>
                                    </span>
                                </x-button>
                            </div>
                        </div>

                        {{-- Popular Tags --}}
                        <div class="bg-white rounded-[3rem] p-10 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.03),0_0_40px_white]">
                            <h4 class="text-secondary font-black text-xl mb-6 flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                                Topik Populer
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach(['#WC_Mampet', '#BlowerPipa', '#AntiLumut', '#PipaBocor', '#MesinSpiral'] as $tag)
                                    <button 
                                        @click="searchQuery = '{{ str_replace('#', '', $tag) }}'; document.getElementById('blogSearchInput').value = '{{ str_replace('#', '', $tag) }}'; currentPage = 1"
                                        class="px-4 py-2 bg-stone-50 rounded-xl text-gray-500 text-[10px] font-bold uppercase tracking-widest hover:bg-primary/10 hover:text-primary transition-all transform hover:scale-105 active:scale-95">
                                        {{ $tag }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <section class="py-12 sm:py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- The High-Impact CTA Card (Named Group for Isolation) -->
        <div class="relative w-full min-h-[500px] lg:min-h-0 lg:aspect-[21/9] xl:aspect-[21/8] rounded-[2.5rem] sm:rounded-[4rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.3)] group/cta">
            
            <!-- Background Image from Internet -->
            <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2000&auto=format&fit=crop" 
                 alt="RooterIn Professional" 
                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2000ms] group-hover/cta:scale-110">
            
            <!-- Darker Gradient Overlay for Maximum Impact -->
            <div class="absolute inset-0 bg-secondary/60 backdrop-blur-[2px]"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-secondary/40 via-secondary/80 to-secondary transition-colors duration-500"></div>
            
            <!-- Content Area: Centered & Powerful -->
            <div class="absolute inset-0 p-6 sm:p-10 lg:p-16 flex flex-col justify-center items-center text-center">
                
                <!-- Centered Badges -->
                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-4 mb-6 sm:mb-10">
                    <div class="px-4 sm:px-6 py-2 sm:py-2.5 bg-primary text-white text-[8px] sm:text-[10px] font-black uppercase tracking-[0.3em] rounded-full shadow-xl shadow-primary/30">
                        EMERGENCY
                    </div>
                    <div class="px-4 sm:px-6 py-2 sm:py-2.5 bg-white/10 backdrop-blur-xl border border-white/20 rounded-full">
                        <span class="text-white text-[8px] sm:text-[10px] font-black uppercase tracking-[0.25em]">SIAP MELAYANI 24/7</span>
                    </div>
                </div>

                <!-- Massive Impact Heading -->
                <h2 class="text-2xl sm:text-4xl lg:text-5xl xl:text-7xl font-heading font-black text-white leading-[1.1] sm:leading-[1] tracking-tight mb-8 sm:mb-12 max-w-5xl animate-fade-in-up">
                    Langkah Nyata Menuju <br> 
                    <span class="text-primary italic">Saluran Pipa Lancar.</span>
                </h2>
                
                <!-- Large Prominent White Pill Button (Separate Named Group) -->
                <a href="https://wa.me/6281234567890" 
                   class="inline-flex items-center gap-4 sm:gap-6 bg-white px-8 sm:px-12 lg:px-16 py-4 sm:py-5 lg:py-7 rounded-full shadow-[0_30px_60px_rgba(0,0,0,0.4)] hover:bg-primary transition-all duration-500 group/btn active:scale-95">
                    <span class="text-primary group-hover/btn:text-white font-black text-xs sm:text-base lg:text-xl uppercase tracking-widest transition-colors flex items-center gap-3 sm:gap-4">
                        Hubungi Tim Kami
                        <i class="ri-whatsapp-line text-lg lg:text-2xl transition-transform group-hover/btn:scale-125"></i>
                    </span>
                </a>

            </div>
        </div>
    </div>
</section>

</x-app-layout>
