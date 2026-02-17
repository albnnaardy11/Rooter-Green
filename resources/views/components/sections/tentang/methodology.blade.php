<section class="py-32 bg-stone-50 overflow-hidden relative">
    <!-- Eco-Friendly Background DNA -->
    <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary/10 rounded-full blur-[120px] -translate-x-1/2 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row gap-20 items-stretch">
            
            <!-- 1. Left: Massive Premium Imagery (Balanced Height) -->
            <div class="w-full lg:w-5/12 relative min-h-[600px] lg:min-h-full flex">
                <div class="relative w-full group overflow-hidden rounded-[3rem] shadow-2xl border-8 border-white">
                    <img src="https://images.unsplash.com/photo-1542013936693-884638332954?q=80&w=1200&auto=format&fit=crop" 
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-[3000ms] group-hover:scale-110" 
                         alt="Rooter Green Professional Methodology">
                    
                    <!-- High Contrast Benefit Box -->
                    <div class="absolute inset-x-0 bottom-0 p-8 sm:p-12 bg-gradient-to-t from-secondary via-secondary/90 to-transparent">
                        <div class="bg-secondary/80 backdrop-blur-3xl p-10 rounded-[2.5rem] border border-white/10 shadow-2xl">
                            <h5 class="text-white font-heading font-black text-2xl mb-8 uppercase tracking-widest border-l-4 border-primary pl-6">
                                Keuntungan Untuk Anda
                            </h5>
                            <div class="space-y-5">
                                @foreach([
                                    'Aman untuk septic tank & pipa rumah', 
                                    'Tanpa penggunaan bahan kimia keras', 
                                    'Proses pengerjaan ramah kesehatan', 
                                    'Hasil pembersihan jauh lebih tahan lama'
                                ] as $benefit)
                                    <div class="flex items-center gap-5 group/item">
                                        <div class="w-7 h-7 shrink-0 rounded-full bg-primary flex items-center justify-center text-white shadow-lg shadow-primary/30 group-hover/item:scale-110 transition-transform">
                                            <i class="ri-check-line text-sm font-bold"></i>
                                        </div>
                                        <span class="text-white font-bold text-sm sm:text-base leading-tight">{{ $benefit }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Modernized Eco Badge (Consistent Green Palette) -->
                    <div class="absolute top-10 right-10 flex items-center gap-3">
                        <div class="px-6 py-3 bg-primary text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full shadow-2xl shadow-primary/40 border border-white/20">
                            100% Eco-Friendly
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Right: Content & Redesigned Hierarchy -->
            <div class="w-full lg:w-7/12 flex flex-col justify-center">
                <!-- Clean Professional Heading -->
                <div class="mb-16">
                    <div class="inline-flex items-center gap-4 mb-6">
                        <span class="w-12 h-[2px] bg-primary"></span>
                        <span class="text-primary font-black text-xs uppercase tracking-[0.5em]">Metode & Keunggulan</span>
                    </div>
                    <h2 class="text-4xl sm:text-6xl font-heading font-black text-secondary leading-[1.1] tracking-tight">
                        Pengerjaan Modern <br> <span class="text-primary italic">Ramah Lingkungan.</span>
                    </h2>
                </div>

                <div class="space-y-16">
                    <!-- Section A: Technical Methods -->
                    <div class="space-y-8">
                        <h4 class="text-secondary/40 font-black text-xs uppercase tracking-[0.4em] flex items-center gap-4">
                            Teknik Profesional Kami
                            <span class="flex-grow h-[1px] bg-gray-200"></span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach([
                                ['icon' => 'ri-settings-4-fill', 'title' => 'Mesin Rooter / Auger', 'desc' => 'Pembersihan pipa mekanik tanpa bongkar.'],
                                ['icon' => 'ri-water-flash-fill', 'title' => 'Jet Cleaner High Pressure', 'desc' => 'Semprotan air tekanan tinggi untuk lemak.'],
                                ['icon' => 'ri-clockwise-2-fill', 'title' => 'Spiral Manual Teknis', 'desc' => 'Pembersihan detail untuk celah sempit.'],
                                ['icon' => 'ri-camera-3-fill', 'title' => 'Kamera Inspeksi Pipa', 'desc' => 'Mendeteksi titik mampet dengan akurat.']
                            ] as $tech)
                                <div class="flex gap-5 p-6 rounded-3xl bg-white border border-gray-100 shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-500">
                                    <div class="w-14 h-14 shrink-0 bg-stone-50 text-primary rounded-2xl flex items-center justify-center shadow-inner group-hover:bg-primary group-hover:text-white transition-colors">
                                        <i class="{{ $tech['icon'] }} text-2xl"></i>
                                    </div>
                                    <div>
                                        <h5 class="text-secondary font-black text-sm uppercase mb-1">{{ $tech['title'] }}</h5>
                                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest leading-relaxed">{{ $tech['desc'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="bg-primary/5 p-6 rounded-2xl border border-primary/10 flex items-center gap-4">
                             <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white shrink-0">
                                <i class="ri-forbid-2-fill text-xl"></i>
                             </div>
                             <p class="text-secondary font-bold text-xs">
                                <span class="text-primary font-black uppercase tracking-widest mr-2">Garansi Keamanan :</span>
                                Tanpa soda api & minim bahan kimia keras bagi penghuni rumah.
                             </p>
                        </div>
                    </div>

                    <!-- Section B: Keunggulan Utama (The Hero Row) -->
                    <div class="space-y-8 pt-8 border-t border-gray-100">
                        <h4 class="text-secondary/40 font-black text-xs uppercase tracking-[0.4em] flex items-center gap-4">
                            Kenapa Rooter Green?
                            <span class="flex-grow h-[1px] bg-gray-200"></span>
                        </h4>
                        <!-- Large, Wide Icon Layout for Dominance -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                            @foreach([
                                ['icon' => 'ri-leaf-fill', 'text' => 'Ramah Lingkungan'],
                                ['icon' => 'ri-sparkling-fill', 'text' => 'Pengerjaan Bersih & Rapi'],
                                ['icon' => 'ri-user-star-fill', 'text' => 'Teknisi Profesional'],
                                ['icon' => 'ri-heart-pulse-fill', 'text' => 'Aman & Sehat'],
                                ['icon' => 'ri-cpu-fill', 'text' => 'Teknologi Modern'],
                                ['icon' => 'ri-flashlight-fill', 'text' => 'Respons Cepat 24 Jam'],
                                ['icon' => 'ri-money-dollar-circle-fill', 'text' => 'Harga Transparan'],
                                ['icon' => 'ri-shield-check-fill', 'text' => 'Hasil Tahan Lama']
                            ] as $item)
                                <div class="group flex flex-col items-center p-6 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 text-center">
                                    <div class="w-16 h-16 bg-primary/5 text-primary rounded-full flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-all shadow-lg shadow-primary/5">
                                        <i class="{{ $item['icon'] }} text-3xl"></i>
                                    </div>
                                    <span class="text-secondary font-black text-[9px] sm:text-[10px] uppercase tracking-widest leading-tight">{{ $item['text'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
