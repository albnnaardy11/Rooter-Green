@props([
    'title' => 'Saluran Pipa Masih Mampet? <br> <span class="text-accent italic">Plong-kan Sekarang!</span>',
    'ctaText' => 'Hubungi Teknisi via WhatsApp',
    'ctaLink' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp_number', '6281246668749')) . '?text=Halo%20Kak%2C%20mau%20order%20jasa%20dong',
    'infoTitle' => 'Konsultasi Gratis',
    'infoDesc' => 'Jangan biarkan mampet semakin parah. Hubungi kami untuk diagnosa awal tanpa biaya.',
    'bgImage' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=1600&fit=crop'
])

<section {{ $attributes->merge(['class' => 'relative bg-secondary py-12 sm:py-20 overflow-hidden group']) }}>
    <!-- Moving Background Graphic -->
    <div class="absolute inset-0 opacity-10 bg-[url(\'{{ $bgImage }}\')] scale-110 group-hover:scale-100 transition-transform duration-[10s] ease-linear brightness-50 grayscale"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-secondary via-secondary/80 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-24">
            <div class="lg:w-3/5 text-center lg:text-left">
                <h2 class="text-3xl sm:text-5xl lg:text-7xl font-heading font-black text-white leading-[1.1] mb-8 sm:mb-12">
                    {!! $title !!}
                </h2>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6 sm:gap-10">
                    <x-button href="{{ $ctaLink }}" variant="primary" class="relative z-10 !px-12 !py-6 shadow-2xl shadow-primary/40 !rounded-full overflow-hidden group/btn">
                        <span class="flex items-center gap-4">
                            <i class="ri-whatsapp-line text-2xl animate-bounce-soft"></i>
                            <span class="font-black uppercase tracking-widest text-sm lg:text-base">{{ $ctaText }}</span>
                            <i class="ri-arrow-right-line group-hover:translate-x-2 transition-transform duration-300"></i>
                        </span>
                        
                        <!-- Premium Shine Effect -->
                        <div class="absolute top-0 -left-full w-full h-full bg-white/20 skew-x-[45deg] group-hover/btn:left-[150%] transition-all duration-1000 ease-in-out"></div>
                    </x-button>
                    <div class="flex items-center gap-4 text-white/50">
                         <div class="w-2 h-2 bg-primary rounded-full animate-ping"></div>
                         <span class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.2em]">Tersedia 24 Jam - Fast Response</span>
                    </div>
                </div>
            </div>

            <!-- Side Card Info -->
            <div class="lg:w-2/5">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-10 rounded-[3rem] p-10 text-center lg:text-left">
                     <i class="ri-customer-service-2-fill text-primary text-5xl mb-6 inline-block"></i>
                     <h4 class="text-white font-black text-2xl mb-2">{{ $infoTitle }}</h4>
                     <p class="text-gray-400 text-sm leading-relaxed mb-8">{{ $infoDesc }}</p>
                     <div class="h-[1px] w-full bg-white/10 mb-8"></div>
                     <div class="flex items-center justify-center lg:justify-start gap-4">
                         <a href="{{ \App\Models\Setting::get('instagram', '#') }}" class="text-white hover:text-primary transition-colors"><i class="ri-instagram-line text-2xl"></i></a>
                         <a href="{{ \App\Models\Setting::get('facebook', '#') }}" class="text-white hover:text-primary transition-colors"><i class="ri-facebook-box-line text-2xl"></i></a>
                         <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp_number', '6281246668749')) }}" class="text-white hover:text-primary transition-colors"><i class="ri-whatsapp-line text-2xl"></i></a>
                     </div>
                </div>
            </div>
        </div>
    </div>
</section>
