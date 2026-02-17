<!-- Unique Organic Footer -->
<footer class="bg-secondary text-white pt-24 pb-12 relative overflow-hidden">
    <!-- Abstract Background Elements -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[1px] bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-primary/10 rounded-full blur-[120px] pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-6 sm:px-10 relative z-10">
        <div class="flex flex-col lg:flex-row justify-between gap-20 mb-20">
            <!-- Brand & Big Statement -->
            <div class="lg:w-1/3">
                <div class="flex items-center gap-4 mb-8 group cursor-default">
                    <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center shadow-lg shadow-primary/20 transition-transform duration-500 group-hover:rotate-12">
                        <i class="ri-flashlight-fill text-white text-2xl"></i>
                    </div>
                    <span class="font-heading font-black text-3xl tracking-tighter uppercase">ROOTER<span class="text-primary italic">GREEN</span></span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-heading font-black text-white leading-tight mb-8">
                    Solusi <span class="text-primary italic">Pipa Lancar</span> <br>Tanpa <span class="text-gray-400 italic">Bongkar!</span>
                </h2>
                <p class="text-gray-400 text-base leading-relaxed mb-10 max-w-sm font-medium">
                    Layanan plumbing premium pertama di Indonesia yang menggabungkan teknologi modern dengan visi pelestarian alam.
                </p>
                <!-- Social Links with Animation -->
                <div class="flex gap-4">
                    <a href="#" class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-primary hover:border-primary transition-all duration-500 group">
                        <i class="ri-instagram-line text-xl text-gray-400 group-hover:text-white transition-colors"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-primary hover:border-primary transition-all duration-500 group">
                        <i class="ri-tiktok-fill text-xl text-gray-400 group-hover:text-white transition-colors"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-primary hover:border-primary transition-all duration-500 group">
                        <i class="ri-facebook-box-fill text-xl text-gray-400 group-hover:text-white transition-colors"></i>
                    </a>
                </div>
            </div>

            <!-- Links Grid -->
            <div class="lg:w-3/5 grid grid-cols-2 md:grid-cols-3 gap-12 sm:gap-16">
                <!-- Solutions -->
                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                        <span class="w-2 h-2 bg-primary rounded-full"></span> Solusi
                    </h4>
                    <ul class="space-y-5 text-gray-400 font-bold text-sm">
                        @foreach(['Pipa Dapur', 'Saluran Kamar Mandi', 'WC Mampet', 'Deteksi Kebocoran', 'Rooter Spiral'] as $item)
                        <li><a href="#" class="hover:text-primary transition-colors hover:translate-x-1 inline-block transition-transform duration-300">{{ $item }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!-- Support -->
                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                        <span class="w-2 h-2 bg-accent rounded-full"></span> Dukungan
                    </h4>
                    <ul class="space-y-5 text-gray-400 font-bold text-sm">
                        @foreach(['Jangkauan Wilayah', 'Daftar Harga', 'Promo Terbaru', 'Karir Teknisi'] as $item)
                        <li><a href="#" class="hover:text-accent transition-colors hover:translate-x-1 inline-block transition-transform duration-300">{{ $item }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!-- Contact (Unique Icon Style) -->
                <div class="col-span-2 md:col-span-1">
                    <h4 class="text-white font-black text-xs uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                        <span class="w-2 h-2 bg-white rounded-full"></span> Hotline
                    </h4>
                    <div class="flex flex-col gap-4">
                        <!-- WhatsApp Card -->
                        <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/5 hover:border-primary/30 transition-all duration-300 group cursor-pointer">
                            <div class="w-11 h-11 bg-primary/10 rounded-xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-500 shadow-sm">
                                <i class="ri-whatsapp-line text-xl"></i>
                            </div>
                            <div>
                                <div class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-0.5">Call & WA</div>
                                <div class="text-white font-black text-sm tracking-wide leading-none">0812-4666-8749</div>
                            </div>
                        </div>
                        <!-- Response Card -->
                        <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/5 hover:border-accent/30 transition-all duration-300 group cursor-pointer">
                            <div class="w-11 h-11 bg-accent/10 rounded-xl flex items-center justify-center text-accent group-hover:bg-accent group-hover:text-white transition-all duration-500 shadow-sm">
                                <i class="ri-timer-flash-fill text-xl"></i>
                            </div>
                            <div>
                                <div class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-0.5">Respon Cepat</div>
                                <div class="text-white font-black text-sm tracking-wide leading-none">15-30 Menit Tiba</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em]">© {{ date('Y') }} Rooter Green Indonesia • Developed by Ardy Albanna</p>
                <div class="hidden md:block w-1.5 h-1.5 bg-white/10 rounded-full"></div>
                <div class="flex gap-6 text-[10px] text-gray-500 font-black uppercase tracking-[0.2em]">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                    <a href="#" class="hover:text-white transition-colors">Cookies</a>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="text-[10px] text-gray-500 font-black uppercase tracking-[0.2em]">Proudly Made In</span>
                <span class="text-white font-black tracking-tighter text-sm flex items-center gap-1">
                    INDONESIA 
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                    </span>
                </span>
            </div>
        </div>
    </div>
</footer>
