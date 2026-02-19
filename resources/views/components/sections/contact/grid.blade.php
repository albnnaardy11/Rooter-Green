<section class="py-32 bg-stone-50 relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[1px] bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-20 items-stretch">
            
            <!-- Contact Info Column -->
            <div class="lg:w-5/12 space-y-12">
                <div>
                    <div class="inline-flex items-center gap-4 mb-6">
                        <span class="w-10 h-[2px] bg-primary"></span>
                        <span class="text-primary font-black text-xs uppercase tracking-[0.4em]">Connect With Us</span>
                    </div>
                    <h2 class="text-4xl sm:text-5xl font-heading font-black text-secondary leading-tight tracking-tight">
                        Siap Melayani <br> <span class="text-primary italic">Masalah Pipa Anda.</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    @foreach([
                        ['icon' => 'ri-whatsapp-fill', 'title' => 'WhatsApp Desktop', 'value' => '0812-4666-8749', 'sub' => 'Fast Response 24/7', 'link' => 'https://wa.me/6281246668749'],
                        ['icon' => 'ri-phone-fill', 'title' => 'Emergency Call', 'value' => '0812-4666-8749', 'sub' => 'Siap Berangkat Sekarang', 'link' => 'tel:081246668749'],
                        ['icon' => 'ri-mail-send-fill', 'title' => 'Email Inquiry', 'value' => 'rooterin@gmail.com', 'sub' => 'Penawaran & Kerjasama Gedung', 'link' => 'mailto:rooterin@gmail.com'],
                        ['icon' => 'ri-map-pin-2-fill', 'title' => 'Wilayah Operasional', 'value' => 'Seluruh Jabodetabek', 'sub' => 'Jakarta, Bogor, Depok, Tangerang, Bekasi', 'link' => '#']
                    ] as $contact)
                        <a href="{{ $contact['link'] }}" class="group flex items-center gap-6 p-8 bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/20 hover:shadow-2xl hover:border-primary/20 transition-all duration-500">
                            <div class="w-16 h-16 rounded-2xl bg-stone-50 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-500 shadow-inner">
                                <i class="{{ $contact['icon'] }} text-3xl"></i>
                            </div>
                            <div>
                                <h4 class="text-secondary/40 font-black text-[10px] uppercase tracking-widest mb-1">{{ $contact['title'] }}</h4>
                                <p class="text-secondary font-black text-xl mb-1">{{ $contact['value'] }}</p>
                                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">{{ $contact['sub'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Contact Illustration / Map Area -->
            <div class="lg:w-7/12 relative">
                <div class="h-full min-h-[500px] w-full bg-secondary rounded-[3.5rem] overflow-hidden shadow-2xl relative border-8 border-white/5">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=1200" class="w-full h-full object-cover opacity-40 grayscale group-hover:grayscale-0 transition-all duration-1000" alt="Contact Context">
                    
                    <!-- Floating Engagement Card -->
                    <div class="absolute inset-x-8 bottom-8 p-10 bg-white/10 backdrop-blur-3xl border border-white/20 rounded-[2.5rem] shadow-2xl">
                        <i class="ri-chat-voice-fill text-primary text-5xl mb-6"></i>
                        <h3 class="text-white font-black text-2xl mb-4 tracking-tight">Konsultasi Gratis Sekarang!</h3>
                        <p class="text-gray-300 text-sm font-medium leading-relaxed mb-8">
                            Jangan biarkan masalah pipa mampet merusak kenyamanan rumah Anda. Tim kami siap memberikan solusi permanen tanpa bongkar.
                        </p>
                        <a href="https://wa.me/6281246668749" class="inline-flex items-center gap-4 bg-primary px-8 py-4 rounded-full text-white font-black text-xs uppercase tracking-widest hover:bg-white hover:text-primary transition-all duration-500">
                            Mulai Chat Sekarang
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>

                    <!-- Top Right Badge -->
                    <div class="absolute top-8 right-8 bg-accent p-4 rounded-2xl shadow-xl shadow-accent/20 border-4 border-secondary rotate-6">
                        <i class="ri-shield-check-fill text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
