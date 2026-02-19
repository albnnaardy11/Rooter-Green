<section class="py-32 bg-stone-50 overflow-hidden relative border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-20 items-start">
            
            <!-- Left Side: Company Profile & History -->
            <div class="lg:w-7/12">
                <div class="inline-flex items-center gap-4 mb-8">
                    <span class="w-12 h-[2px] bg-primary"></span>
                    <span class="text-primary font-black text-xs uppercase tracking-[0.4em]">Profil & Komitmen</span>
                </div>
                
                <h2 class="text-4xl sm:text-5xl font-heading font-black text-secondary leading-tight tracking-tight mb-12">
                    Dedikasi Pelayanan <br> <span class="text-primary italic">Lebih Dari 1Dekade.</span>
                </h2>

                <!-- Narrative Content - Standardized Typography -->
                <div class="space-y-8 text-gray-500 text-lg leading-relaxed">
                    <p>
                        <strong class="text-secondary font-black">RooterIn</strong> adalah layanan profesional pelancar saluran pipa mampet, perawatan drainase, serta instalasi perpipaan modern yang mengutamakan metode kerja ramah lingkungan, bersih, dan aman bagi penghuni maupun lingkungan.
                    </p>
                    <p>
                        Berada di bawah naungan <strong class="text-secondary font-bold">J&J Group (Jawa & Jaya Rooter)</strong> yang telah berpengalaman lebih dari 10 tahun di bidang plumbing dan drainase, RooterIn hadir sebagai pengembangan layanan modern dengan standar kerja lebih rapi, higienis, dan profesional.
                    </p>
                    <p class="p-6 bg-white rounded-3xl border-l-8 border-primary shadow-sm italic text-secondary font-medium">
                        "Kami mengedepankan teknik mekanis dan teknologi inspeksi tanpa merusak pipa serta sangat menghindari penggunaan bahan kimia keras seperti soda api."
                    </p>
                    <p class="font-black text-secondary tracking-tight">
                        RooterIn — solusi saluran mampet modern tanpa merusak alam, rumah, dan kesehatan penghuni.
                    </p>
                </div>
            </div>

            <!-- Right Side: Visi & Misi (Landing DNA Cards) -->
            <div class="lg:w-5/12 space-y-8">
                <!-- Visi Card -->
                <div class="group relative p-10 bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden hover:-translate-y-2 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="flex items-center gap-6 mb-8">
                        <div class="w-14 h-14 bg-primary text-white rounded-2xl flex items-center justify-center shadow-lg shadow-primary/20">
                            <i class="ri-eye-fill text-3xl"></i>
                        </div>
                        <h3 class="text-secondary font-black text-2xl uppercase tracking-tighter">Visi</h3>
                    </div>
                    <p class="text-secondary font-bold text-lg leading-snug italic">
                        "Menjadi perusahaan jasa plumbing modern terpercaya di Indonesia yang mengutamakan keselamatan, kebersihan, dan kelestarian lingkungan."
                    </p>
                </div>

                <!-- Misi Card -->
                <div class="group p-10 bg-secondary rounded-[2.5rem] shadow-2xl border border-white/5 hover:-translate-y-2 transition-all duration-500 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="flex items-center gap-6 mb-8 relative z-10">
                        <div class="w-14 h-14 bg-accent text-white rounded-2xl flex items-center justify-center shadow-lg shadow-accent/20">
                            <i class="ri-list-check-3 text-3xl"></i>
                        </div>
                        <h3 class="text-white font-black text-2xl uppercase tracking-tighter">Misi</h3>
                    </div>
                    <ul class="space-y-5 relative z-10">
                        @foreach([
                            'Memberikan layanan plumbing profesional dengan standar kerja tinggi',
                            'Mengutamakan metode ramah lingkungan tanpa bahan kimia berbahaya',
                            'Menyediakan teknisi ahli dan respons cepat',
                            'Mengedukasi masyarakat tentang perawatan saluran pipa yang benar',
                            'Mengembangkan teknologi inspeksi dan perawatan saluran modern'
                        ] as $misi)
                            <li class="flex items-start gap-4 group/item">
                                <div class="w-6 h-6 shrink-0 bg-accent/20 text-accent rounded-full flex items-center justify-center mt-1 group-hover/item:bg-accent group-hover/item:text-white transition-colors">
                                    <i class="ri-check-fill font-bold"></i>
                                </div>
                                <span class="text-gray-300 text-sm font-bold leading-tight">{{ $misi }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>
