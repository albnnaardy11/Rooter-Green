<section class="py-16 sm:py-32 bg-stone-50 relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[1px] bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-stretch">
            
            <!-- Contact Info Column -->
            <div class="w-full lg:w-5/12 space-y-8 sm:space-y-12">
                <div>
                    <div class="flex items-center gap-4 mb-4 sm:mb-6">
                        <span class="w-8 sm:w-10 h-[2px] bg-primary"></span>
                        <span class="text-primary font-black text-[10px] sm:text-xs uppercase tracking-[0.4em]">Connect With Us</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-heading font-black text-secondary leading-tight tracking-tight">
                        Siap Melayani <br class="hidden sm:block"> <span class="text-primary italic">Masalah Pipa Anda.</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:gap-6">
                    @foreach([
                        ['icon' => 'ri-whatsapp-fill', 'title' => 'WhatsApp Desktop', 'value' => \App\Models\Setting::get('whatsapp_number', '0812-4666-8749'), 'sub' => 'Fast Response 24/7', 'link' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp_number', '6281246668749'))],
                        ['icon' => 'ri-phone-fill', 'title' => 'Emergency Call', 'value' => \App\Models\Setting::get('whatsapp_number', '0812-4666-8749'), 'sub' => 'Siap Berangkat Sekarang', 'link' => 'tel:' . preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp_number', '6281246668749'))],
                        ['icon' => 'ri-mail-send-fill', 'title' => 'Email Inquiry', 'value' => \App\Models\Setting::get('email', 'rooterin@gmail.com'), 'sub' => 'Penawaran & Kerjasama Gedung', 'link' => 'mailto:' . \App\Models\Setting::get('email', 'rooterin@gmail.com')],
                        ['icon' => 'ri-map-pin-2-fill', 'title' => 'Wilayah Operasional', 'value' => \App\Models\Setting::get('address', 'Seluruh Jabodetabek'), 'sub' => 'Jakarta, Bogor, Depok, Tangerang, Bekasi', 'link' => '#']
                    ] as $contact)
                        <a href="{{ $contact['link'] }}" class="group flex items-center gap-4 sm:gap-6 p-5 sm:p-8 bg-white rounded-[2rem] sm:rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/20 hover:shadow-2xl hover:border-primary/20 transition-all duration-500">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl bg-stone-50 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-500 shadow-inner flex-shrink-0">
                                <i class="{{ $contact['icon'] }} text-2xl sm:text-3xl"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-secondary/40 font-black text-[8px] sm:text-[10px] uppercase tracking-widest mb-0.5 sm:mb-1">{{ $contact['title'] }}</h4>
                                <p class="text-secondary font-black text-base sm:text-xl mb-0.5 sm:mb-1 truncate">{{ $contact['value'] }}</p>
                                <p class="text-gray-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest truncate">{{ $contact['sub'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Contact Illustration / Map Area -->
            <div class="w-full lg:w-7/12 relative mt-8 lg:mt-0">
                <div class="h-full min-h-[400px] sm:min-h-[500px] w-full bg-secondary rounded-[2.5rem] sm:rounded-[3.5rem] overflow-hidden shadow-2xl relative border-4 sm:border-8 border-white/5">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=1200" class="w-full h-full object-cover opacity-40 grayscale group-hover:grayscale-0 transition-all duration-1000" alt="Contact Context">
                    
                    <!-- Floating Engagement Card -->
                    <div class="absolute inset-x-4 sm:inset-x-8 bottom-4 sm:bottom-8 p-6 sm:p-10 bg-white/10 backdrop-blur-3xl border border-white/20 rounded-[2rem] sm:rounded-[2.5rem] shadow-2xl">
                        <i class="ri-chat-voice-fill text-primary text-3xl sm:text-5xl mb-4 sm:mb-6"></i>
                        <h3 class="text-white font-heading font-black text-xl sm:text-2xl mb-2 sm:mb-4 tracking-tight">Konsultasi Gratis Sekarang!</h3>
                        <p class="text-gray-300 text-xs sm:text-sm font-medium leading-relaxed mb-6 sm:mb-8">
                            Jangan biarkan masalah pipa mampet merusak kenyamanan rumah Anda. Tim kami siap memberikan solusi permanen.
                        </p>
                        <a href="https://wa.me/6281246668749" class="inline-flex items-center justify-center gap-3 sm:gap-4 bg-primary px-6 sm:px-8 py-3 sm:py-4 rounded-full text-white font-black text-[10px] sm:text-xs uppercase tracking-widest hover:bg-white hover:text-primary transition-all duration-500 w-full sm:w-auto">
                            Mulai Chat Sekarang
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>

                    <!-- Top Right Badge -->
                    <div class="absolute top-4 sm:top-8 right-4 sm:right-8 bg-accent p-3 sm:p-4 rounded-xl sm:rounded-2xl shadow-xl shadow-accent/20 border-2 sm:border-4 border-secondary rotate-6">
                        <i class="ri-shield-check-fill text-white text-xl sm:text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
