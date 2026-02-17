<x-app-layout>
    <!-- Hero Section -->
    <section class="relative bg-secondary min-h-[85vh] flex items-center overflow-hidden pt-44 lg:pt-48 pb-20 sm:pb-32">
        <!-- Modern Pattern Overlay -->
        <div class="absolute inset-0 z-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-accent/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                <!-- Text Content -->
                <div class="lg:w-3/5 text-center lg:text-left">
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 mb-8 animate-fade-in-up">
                        <div class="inline-flex items-center px-4 py-2 rounded-full border border-primary/30 bg-primary/10 text-primary font-bold text-[10px] sm:text-xs uppercase tracking-[0.2em]">
                            Trusted Eco-Plumbing Service
                        </div>
                        <div class="inline-flex items-center px-4 py-2 rounded-full border border-white/10 bg-white/5 text-white/80 font-bold text-[10px] sm:text-xs uppercase tracking-[0.2em]">
                            <svg class="w-3 h-3 mr-2 text-accent" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
                            Jawa & Sumatera
                        </div>
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl md:text-7xl font-heading font-black text-white leading-[1.1] mb-8">
                        Solusi Pintar <br>
                        <span class="text-primary italic">Pipa Lancar</span> <br>
                        Tanpa Bongkar!
                    </h1>
                    
                    <p class="text-gray-300 text-lg sm:text-xl md:max-w-2xl mb-10 leading-relaxed font-medium">
                        Melayani dengan sepenuh hati di wilayah <span class="text-white font-bold">Jabodetabek, Bandung, Serang, Lampung, dan Metro.</span> Teknisi ahli, pengerjaan cepat, dan hasil maksimal.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start">
                        <x-button href="https://wa.me/6281234567890?text=Halo%20Kak%2C%20mau%20order%20jasa%20dong" variant="primary" class="!px-10 !py-5 shadow-2xl shadow-primary/40">
                            Pesan Sekarang - Plong!
                        </x-button>
                    </div>
                </div>

                <!-- Right Side Visual / Featured Card -->
                <div class="lg:w-2/5 relative animate-fade-in-up delay-150">
                    <div class="relative w-full aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl group border-8 border-white/5">
                        <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&q=80&w=1200" alt="Technician" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                        <div class="absolute inset-x-0 bottom-0 p-8 bg-gradient-to-t from-secondary via-secondary/20 to-transparent">
                            <div class="bg-white/10 backdrop-blur-xl p-6 rounded-3xl border border-white/20 shadow-2xl">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="2"/></svg>
                                    </div>
                                    <span class="text-white font-bold text-lg">Garansi Kepuasan</span>
                                </div>
                                <p class="text-gray-300 text-xs leading-relaxed">Pipa mampet mampet lagi dalam 7 hari? Kami perbaiki GRATIS tanpa biaya tambahan apapun.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Transition Curve (Improved Wave) -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0]">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-[80px] text-white fill-current">
                <path d="M0,0 C300,120 900,120 1200,0 L1200,120 L0,120 Z"></path>
            </svg>
        </div>
    </section>

    <!-- Premium USP / Trust Banner -->
    <section class="relative z-30 -mt-10 sm:-mt-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/70 backdrop-blur-2xl rounded-[3rem] p-8 sm:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-white/50 relative overflow-hidden">
                <!-- Decorative Background Element -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16 relative z-10">
                    <!-- Item 1: Eco-Safe -->
                    <div class="flex flex-col items-center group cursor-default">
                        <div class="w-20 h-20 mb-6 bg-white rounded-3xl flex items-center justify-center text-primary border border-gray-100 shadow-xl shadow-gray-200/50 transition-all duration-500 group-hover:-translate-y-2 group-hover:shadow-primary/20 group-hover:border-primary/20">
                            <i class="ri-leaf-fill text-4xl transition-transform duration-500 group-hover:scale-110"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-secondary font-black text-sm uppercase tracking-wider mb-1">100% Aman & Tanpa Kimia</div>
                            <div class="text-gray-400 text-[11px] font-bold font-sans italic">Pipa Awet, Tanpa Soda Api</div>
                        </div>
                    </div>

                    <!-- Item 2: Expert Team -->
                    <div class="flex flex-col items-center group cursor-default">
                        <div class="w-20 h-20 mb-6 bg-white rounded-3xl flex items-center justify-center text-accent border border-gray-100 shadow-xl shadow-gray-200/50 transition-all duration-500 group-hover:-translate-y-2 group-hover:shadow-accent/20 group-hover:border-accent/20">
                            <i class="ri-verified-badge-fill text-4xl transition-transform duration-500 group-hover:scale-110"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-secondary font-black text-sm uppercase tracking-wider mb-1">Teknisi Ahli Terlisensi</div>
                            <div class="text-gray-400 text-[11px] font-bold font-sans italic">Handal, Jujur, & Profesional</div>
                        </div>
                    </div>

                    <!-- Item 3: Fast Response -->
                    <div class="flex flex-col items-center group cursor-default">
                        <div class="w-20 h-20 mb-6 bg-white rounded-3xl flex items-center justify-center text-primary border border-gray-100 shadow-xl shadow-gray-200/50 transition-all duration-500 group-hover:-translate-y-2 group-hover:shadow-primary/20 group-hover:border-primary/20">
                            <i class="ri-flashlight-fill text-4xl transition-transform duration-500 group-hover:scale-110"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-secondary font-black text-sm uppercase tracking-wider mb-1">Pasti Tiba 15 Menit</div>
                            <div class="text-gray-400 text-[11px] font-bold font-sans italic">Garansi Respon Super Kilat</div>
                        </div>
                    </div>

                    <!-- Item 4: Langsung Chat -->
                    <div class="flex flex-col items-center group cursor-default">
                        <div class="w-20 h-20 mb-6 bg-white rounded-3xl flex items-center justify-center text-accent border border-gray-100 shadow-xl shadow-gray-200/50 transition-all duration-500 group-hover:-translate-y-2 group-hover:shadow-accent/20 group-hover:border-accent/20">
                            <i class="ri-chat-voice-fill text-4xl transition-transform duration-500 group-hover:scale-110"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-secondary font-black text-sm uppercase tracking-wider mb-1">Solusi Chat Sekarang</div>
                            <div class="text-gray-400 text-[11px] font-bold font-sans italic">Konsultasi Gratis Tanpa Biaya</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us / Problem Solver Section (Modular & Complex) -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-20 items-center">
                <div class="lg:w-1/2 order-2 lg:order-1 relative">
                    <!-- Layered Imagery -->
                    <div class="relative z-10 rounded-[2.5rem] overflow-hidden shadow-2xl skew-y-1 group">
                        <img src="https://images.unsplash.com/photo-1542013936693-884638332954?w=1200&fit=crop" class="w-full transition-transform duration-1000 group-hover:scale-105" alt="Plumbing Problem">
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-2/3 z-20 rounded-[2rem] overflow-hidden shadow-2xl border-8 border-white group animate-bounce-soft">
                        <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=800&fit=crop" alt="Work Process" class="w-full h-full object-cover">
                        <div class="absolute inset-x-0 bottom-0 p-4 bg-primary text-white font-bold text-center text-xs">PELAKSANAAN DI LOKASI</div>
                    </div>
                </div>
                <div class="lg:w-1/2 order-1 lg:order-2">
                    <x-section-heading title="Hadir Menjadi Solusi Terbaik Anda" subtitle="KENAPA HARUS KAMI?" align="left" />
                    
                    <p class="text-gray-600 text-lg mb-12 -mt-8 leading-relaxed">
                        Kami mengerti rasa frustrasi Anda saat saluran pipa mampet di rumah. Itulah kenapa tim Rooter Green hadir dengan standar pelayanan yang berbeda dari bengkel pipa biasa.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Ahli & Profesional -->
                        <div class="flex flex-col gap-5 p-8 bg-stone-50/50 rounded-[2rem] border border-gray-100 hover:bg-white hover:border-primary/20 hover:shadow-2xl hover:shadow-primary/5 transition-all duration-300 group">
                            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-500">
                                <i class="ri-medal-fill text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-secondary font-black text-xl mb-2 group-hover:text-primary transition-colors">Ahli & Profesional</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Teknisi tersertifikasi dengan jam terbang tinggi di bidang plumbing.</p>
                            </div>
                        </div>

                        <!-- Konsultasi Gratis -->
                        <div class="flex flex-col gap-5 p-8 bg-stone-50/50 rounded-[2rem] border border-gray-100 hover:bg-white hover:border-accent/20 hover:shadow-2xl hover:shadow-accent/5 transition-all duration-300 group">
                            <div class="w-14 h-14 bg-accent/10 rounded-2xl flex items-center justify-center text-accent group-hover:bg-accent group-hover:text-white transition-all duration-500">
                                <i class="ri-customer-service-2-line text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-secondary font-black text-xl mb-2 group-hover:text-accent transition-colors">Konsultasi Gratis</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Tanya masalah pipa Anda kapan saja tanpa dipungut biaya sepeserpun.</p>
                            </div>
                        </div>

                        <!-- Layanan Berkualitas -->
                        <div class="flex flex-col gap-5 p-8 bg-stone-50/50 rounded-[2rem] border border-gray-100 hover:bg-white hover:border-primary/20 hover:shadow-2xl hover:shadow-primary/5 transition-all duration-300 group">
                            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-500">
                                <i class="ri-shield-check-fill text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-secondary font-black text-xl mb-2 group-hover:text-primary transition-colors">Layanan Berkualitas</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Pengerjaan rapi, bersih, dan menggunakan standar teknologi terbaru.</p>
                            </div>
                        </div>

                        <!-- Harga Terbaik -->
                        <div class="flex flex-col gap-5 p-8 bg-stone-50/50 rounded-[2rem] border border-gray-100 hover:bg-white hover:border-accent/20 hover:shadow-2xl hover:shadow-accent/5 transition-all duration-300 group">
                            <div class="w-14 h-14 bg-accent/10 rounded-2xl flex items-center justify-center text-accent group-hover:bg-accent group-hover:text-white transition-all duration-500">
                                <i class="ri-wallet-3-fill text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-secondary font-black text-xl mb-2 group-hover:text-accent transition-colors">Harga Terbaik</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Penawaran harga paling kompetitif dengan kualitas hasil bintang lima.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    
        <!-- Mega CTA Section -->
    <section class="py-24 bg-primary relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/pinstriped-suit.png')]"></div>
        <div class="absolute -top-1/2 left-0 w-full h-full bg-gradient-to-b from-white/20 to-transparent"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl sm:text-6xl font-heading font-black text-white mb-8 leading-tight">
                Mau Tanya-Tanya Dulu? <br> <span class="text-secondary">Konsultasi Gratis, Kak!</span>
            </h2>
            <p class="text-white/90 text-xl font-medium mb-12 max-w-2xl mx-auto">
                Jangan tunggu air banjir ke dalam rumah. Teknisi kami siap siaga 24 jam untuk melayani Anda di wilayah Jabodetabek.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                 <x-button href="https://wa.me/6281234567890?text=Halo%20Rooter%20Green%2C%20mau%20dikirim%20teknisi%20sekarang" variant="secondary" class="!px-12 !py-6 text-xl shadow-2xl">
                     Kirim Teknisi Sekarang
                 </x-button>
                 <x-button variant="accent" class="bg-white !text-secondary !px-12 !py-6 text-xl hover:bg-neutral">
                     Cek Daftar Harga
                 </x-button>
            </div>
            <div class="mt-12 flex items-center justify-center gap-8 text-white/80 font-bold uppercase tracking-widest text-xs">
                 <span class="flex items-center gap-2"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg> NO TIPS POLICY</span>
                 <span class="flex items-center gap-2"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg> GARANSI 100% PLONG</span>
            </div>
        </div>
    </section>
    

    <!-- Services Section -->
    <section id="services" class="py-32 bg-stone-50 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <x-section-heading title="Pilih Layanan Yang Anda Butuhkan" subtitle="SOLUSI TERLENGKAP" />
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-12 mt-16">
                <!-- Service Card Template -->
                @foreach([
                    [
                        'title' => 'Pembersihan Saluran Wastafel',
                        'desc' => 'Wastafel bersih, lancar, dan bebas bau dalam hitungan menit.',
                        'img' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&fit=crop',
                        'color' => 'primary'
                    ],
                    [
                        'title' => 'Penanganan Saluran Floor Drain',
                        'desc' => 'Solusi tepat untuk saluran kamar mandi yang meluap dan tersumbat.',
                        'img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=800&fit=crop',
                        'color' => 'accent'
                    ],
                    [
                        'title' => 'Pembersihan Saluran WC/Closet',
                        'desc' => 'Penanganan WC mampet tanpa bongkar, bersih, dan higienis.',
                        'img' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800&fit=crop',
                        'color' => 'primary'
                    ],
                    [
                        'title' => 'Perawatan Saluran Dapur Restoran',
                        'desc' => 'Layanan khusus skala bisnis untuk memastikan operasional dapur tetap lancar.',
                        'img' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=800&fit=crop',
                        'color' => 'accent'
                    ],
                    [
                        'title' => 'Saluran Bak Cucian (Kitchen Sink)',
                        'desc' => 'Penghancuran lemak batu pada pipa dapur dengan teknologi modern.',
                        'img' => 'https://images.unsplash.com/photo-1525909002-1b05e0c869d8?w=800&fit=crop',
                        'color' => 'primary'
                    ],
                    [
                        'title' => 'Instalasi Pipa & Alat Sanitasi',
                        'desc' => 'Pemasangan kran, shower, dan pipa baru dengan presisi tinggi.',
                        'img' => 'https://images.unsplash.com/photo-1581244276891-6bc617f77bc7?w=800&fit=crop',
                        'color' => 'accent'
                    ]
                ] as $service)
                <div class="group relative bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-{{ $service['color'] }}/10 transition-all duration-500 hover:-translate-y-3">
                    <!-- Image Area -->
                    <div class="h-64 overflow-hidden relative">
                        <img src="{{ $service['img'] }}" alt="{{ $service['title'] }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-white to-transparent"></div>
                        
                        <!-- Floating Category Label -->
                        <div class="absolute top-6 left-6 px-4 py-1.5 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-black text-secondary uppercase tracking-widest border border-white/20 shadow-sm">
                            Premium Service
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="p-10 pt-4 relative">
                        <!-- Accent Line -->
                        <div class="w-12 h-1 bg-{{ $service['color'] }} rounded-full mb-6 group-hover:w-20 transition-all duration-500"></div>
                        
                        <h3 class="text-2xl font-heading font-black text-secondary mb-4 leading-tight group-hover:text-primary transition-colors">
                            {{ $service['title'] }}
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-8 opacity-80 group-hover:opacity-100 transition-opacity">
                            {{ $service['desc'] }}
                        </p>
                        
                        <!-- CTA Link -->
                        <a href="https://wa.me/6281234567890?text=Halo%20Rooter%20Green%2C%20mau%20order%20{{ urlencode($service['title']) }}" 
                           class="inline-flex items-center text-primary font-bold text-sm tracking-tight group/link">
                            <span class="border-b-2 border-primary/20 group-hover/link:border-primary pb-1 transition-all">Hubungi Sekarang</span>
                            <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-24 text-center">
                 <div class="inline-flex flex-col sm:flex-row items-center gap-6 p-2 bg-white rounded-full shadow-xl border border-gray-100 pr-8">
                     <div class="flex -space-x-3 pl-4">
                         <img src="https://images.unsplash.com/photo-1542013936693-884638332954?w=64&h=64&fit=crop" class="w-10 h-10 rounded-full border-2 border-white object-cover" alt="Tool">
                         <img src="https://images.unsplash.com/photo-1581244276891-6bc617f77bc7?w=64&h=64&fit=crop" class="w-10 h-10 rounded-full border-2 border-white object-cover" alt="Tool">
                     </div>
                     <p class="text-secondary font-bold text-sm">Masalah pipa lainnya? Teknisi kami siap memberikan diagnosa gratis.</p>
                     <x-button variant="outline" class="!px-6 !py-3 text-xs" href="https://wa.me/6281234567890">Lihat Semua Solusi</x-button>
                 </div>
            </div>
        </div>
    </section>

    <!-- Project Gallery Section (Unique Modular) -->
    <section class="py-24 bg-secondary text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-heading title="Galeri Pengerjaan Kami" subtitle="HASIL NYATA" dark="true" align="left" />
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 -mt-10 lg:-mt-8">
                <x-gallery-item image="https://images.unsplash.com/photo-1599661046289-e318878567c4?w=800&fit=crop" title="Penghancuran Lemak Batu" category="Kitchen Sink" />
                <x-gallery-item image="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&fit=crop" title="Pembersihan Floor Drain" category="Apartment" />
                <x-gallery-item image="https://images.unsplash.com/photo-1581244276891-6bc617f77bc7?w=800&fit=crop" title="Inspeksi Pipa Endoscope" category="Technology" />
                <x-gallery-item image="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=800&fit=crop" title="Peluncuran Rooter Spiral" category="Industrial" />
                <x-gallery-item image="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&fit=crop" title="Pipa Mampet Plafon" category="Residential" />
                <x-gallery-item image="https://images.unsplash.com/photo-1525909002-1b05e0c869d8?w=800&fit=crop" title="Wastafel Kembali Lancar" category="Kitchen" />
                <x-gallery-item image="https://images.unsplash.com/photo-1542013936693-884638332954?w=800&fit=crop" title="Alat Modern Terbaru" category="Equipment" />
                <x-gallery-item image="https://images.unsplash.com/photo-1531973576160-7125cd663d86?w=800&fit=crop" title="Kerja Tim Profesional" category="Our Team" />
            </div>
        </div>
    </section>


    <!-- Enhanced Coverage / Map Area (Modern Light Design) -->
    <section id="coverage" class="py-32 bg-white relative overflow-hidden">
        <!-- Technical Grid Background -->
        <div class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/grid-me.png')] pointer-events-none"></div>
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-stone-50 to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-24">
                <x-section-heading title="Melayani Seluruh Jantung Kota Anda" subtitle="PENYINGGAH TERDEKAT" align="center" />
                <p class="text-gray-500 max-w-2xl mx-auto -mt-8 text-lg font-medium">
                    Jaringan teknisi profesional kami tersebar luas untuk menjamin <span class="text-primary font-bold">Fast-Response 15 Menit</span> di setiap titik layanan.
                </p> 
            </div>

            <!-- City Network Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-24">
                @foreach([
                    [
                        'name' => 'JABODETABEK', 
                        'img' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=600&fit=crop', 
                        'tag' => 'Pusat Operasional'
                    ],
                    [
                        'name' => 'CIREBON', 
                        'img' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=600&fit=crop', 
                        'tag' => 'Jawa Barat Area'
                    ],
                    [
                        'name' => 'SEMARANG', 
                        'img' => 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=600&fit=crop', 
                        'tag' => 'Jawa Tengah Area'
                    ],
                    [
                        'name' => 'YOGYAKARTA', 
                        'img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=600&fit=crop', 
                        'tag' => 'D.I. Yogyakarta'
                    ],
                    [
                        'name' => 'LAMPUNG', 
                        'img' => 'https://images.unsplash.com/photo-1590602847861-f357a9332bbc?w=600&fit=crop', 
                        'tag' => 'Sumatera Area'
                    ],
                    [
                        'name' => 'METRO', 
                        'img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=600&fit=crop', 
                        'tag' => 'Sumatera Area'
                    ],
                ] as $city)
                <div class="group relative bg-white border border-gray-100 rounded-[2.5rem] p-6 flex items-center gap-6 shadow-xl shadow-gray-100/50 hover:shadow-2xl hover:shadow-primary/5 hover:border-primary/20 hover:-translate-y-1 transition-all duration-500">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden shadow-md flex-shrink-0 group-hover:scale-105 transition-transform duration-500 bg-gray-100">
                        <img src="{{ $city['img'] }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" alt="{{ $city['name'] }}">
                    </div>
                    <div>
                        <div class="text-primary font-bold text-[10px] uppercase tracking-widest mb-1">{{ $city['tag'] }}</div>
                        <h4 class="text-secondary font-black text-xl tracking-tight leading-none mb-1">{{ $city['name'] }}</h4>
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse shadow-[0_0_8px_#1FAF5A]"></span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-tight">Active Team</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Premium Coverage Visual -->
            <div class="relative bg-secondary rounded-[4rem] p-12 sm:p-20 overflow-hidden group shadow-3xl">
                <!-- Abstract Map Graphic (Static but Premium) -->
                <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?w=1600&fit=crop')] grayscale brightness-200 scale-110"></div>
                
                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-16">
                    <div class="lg:w-1/2 text-center lg:text-left">
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary/20 text-primary font-bold text-xs uppercase tracking-widest mb-6">
                            Jaringan Terluas
                        </div>
                        <h3 class="text-4xl sm:text-5xl font-heading font-black text-white mb-6 leading-tight">
                            Hadir Lebih Dekat <br> di <span class="text-primary italic">Setiap Sudut Kota</span>
                        </h3>
                        <p class="text-gray-400 text-lg leading-relaxed mb-10">
                            Kami menempatkan pangkalan teknisi di titik-titik strategis untuk memastikan pengerjaan tepat waktu. Tidak perlu menunggu lama, teknisi ahli kami siap meluncur ke lokasi Anda.
                        </p>
                        <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                            @foreach(['Sertifikasi Resmi', 'Alat Modern', 'Respon Cepat', 'Garansi Tuntas'] as $tag)
                            <div class="flex items-center gap-2 bg-white/5 border border-white/10 px-4 py-2 rounded-2xl">
                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="text-white font-bold text-xs uppercase tracking-tighter">{{ $tag }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Visual Side - Summary Badge -->
                    <div class="lg:w-2/5 relative">
                        <div class="bg-white/10 backdrop-blur-2xl border border-white/20 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden group/card hover:bg-white/15 transition-all duration-500">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/20 rounded-full blur-3xl"></div>
                            
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-14 h-14 bg-primary rounded-2xl flex items-center justify-center shadow-lg shadow-primary/30">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z" stroke-width="2"/></svg>
                                </div>
                                <h4 class="text-white font-black text-2xl leading-tight">Cakupannya <br> Jawa & Sumatera</h4>
                            </div>

                            <p class="text-white/60 text-sm mb-8 leading-relaxed">
                                Armada teknisi kami beroperasi penuh di wilayah <span class="text-white font-bold">Jabodetabek, Jawa Barat, hingga Lampung & Metro.</span>
                            </p>

                            <x-button href="https://wa.me/6281234567890?text=Halo%20Rooter%20Green%2C%20apakah%20melayani%20wilayah..." variant="primary" class="w-full !py-4 shadow-xl">
                                Tanya Wilayah Lainnya
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    
</x-app-layout>
