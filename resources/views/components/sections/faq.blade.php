@props([
    'title' => 'Pertanyaan Yang <span class="text-primary italic">Sering Diajukan.</span>',
    'subtitle' => 'FAQ - BUTUH JAWABAN?',
    'faqs' => [
        [
            'q' => 'Apakah ada biaya untuk konsultasi awal?',
            'a' => 'Tidak ada biaya sama sekali. Kami memberikan layanan konsultasi dan estimasi biaya secara GRATIS melalui WhatsApp atau survey lokasi sebelum pengerjaan dimulai.'
        ],
        [
            'q' => 'Berapa lama waktu pengerjaan saluran mampet?',
            'a' => 'Rata-rata pengerjaan berkisar antara 1 hingga 3 jam saja, tergantung tingkat kesulitan dan panjang saluran, berkat penggunaan mesin Rooter modern berstandar internasional.'
        ],
        [
            'q' => 'Apakah metode pembersihan ini merusak pipa atau lantai?',
            'a' => 'Sama sekali tidak. Kami menggunakan teknologi Spiral Cable Flexible yang hanya menarik kotoran/lemak tanpa melukai dinding pipa. Kami bekerja "Tanpa Bongkar" lantai atau dinding Anda.'
        ],
        [
            'q' => 'Apa saja wilayah cakupan layanan RooterIn?',
            'a' => 'Saat ini tim kami siap melayani area Jabodetabek (Jakarta, Bogor, Depok, Tangerang, Bekasi), Bandung, Serang, hingga area Lampung dan Metro.'
        ],
        [
            'q' => 'Bagaimana jika saluran mampet lagi setelah diperbaiki?',
            'a' => 'RooterIn memberikan Garansi Kepuasan selama 7 hari. Jika dalam masa garansi saluran mampet kembali, tim kami akan datang dan memperbaikinya GRATIS tanpa biaya tambahan.'
        ],
        [
            'q' => 'Apakah bisa melayani restoran, pabrik, atau gedung kantor?',
            'a' => 'Sangat bisa. Kami memiliki paket layanan khusus untuk residensial (rumah tinggal) maupun komersial/korporat dengan peralatan yang disesuaikan untuk skala pipa besar dan limbah berat.'
        ]
    ]
])

<section id="faq" {{ $attributes->merge(['class' => 'py-24 sm:py-32 bg-white relative overflow-hidden']) }}>
    <!-- Decorative Background -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-[0.03] z-0">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs>
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 sm:mb-20">
            <x-section-heading 
                :title="$title" 
                :subtitle="$subtitle" 
                align="center" 
            />
        </div>

        <div class="space-y-4 sm:space-y-6" x-data="{ activeFaq: null }">
            @foreach($faqs as $index => $faq)
                <div 
                    class="group"
                    :class="activeFaq === {{ $index }} ? 'is-active' : ''"
                >
                    <div 
                        class="bg-stone-50 rounded-[2rem] border-2 transition-all duration-500 overflow-hidden"
                        :class="activeFaq === {{ $index }} ? 'border-primary bg-white shadow-2xl shadow-primary/5' : 'border-transparent hover:border-gray-200'"
                    >
                        <!-- Question Header -->
                        <button 
                            @click="activeFaq === {{ $index }} ? activeFaq = null : activeFaq = {{ $index }}"
                            class="w-full px-8 py-7 sm:px-10 sm:py-9 flex items-center justify-between text-left focus:outline-none"
                        >
                            <span 
                                class="text-lg sm:text-xl font-black transition-colors duration-300"
                                :class="activeFaq === {{ $index }} ? 'text-secondary' : 'text-gray-600 group-hover:text-secondary'"
                            >
                                {{ $faq['q'] }}
                            </span>
                            
                            <div 
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl flex items-center justify-center transition-all duration-500 shrink-0 ml-4"
                                :class="activeFaq === {{ $index }} ? 'bg-primary text-white rotate-90' : 'bg-white border border-gray-100 text-gray-400 group-hover:text-primary'"
                            >
                                <i :class="activeFaq === {{ $index }} ? 'ri-subtract-line' : 'ri-add-line'" class="text-xl sm:text-2xl"></i>
                            </div>
                        </button>

                        <!-- Answer Content (Alpine Collapse) -->
                        <div 
                            x-show="activeFaq === {{ $index }}" 
                            x-collapse
                            x-cloak
                        >
                            <div class="px-8 pb-8 sm:px-10 sm:pb-10 -mt-2">
                                <div class="w-full h-[1px] bg-gray-100 mb-6"></div>
                                <p class="text-gray-500 text-base sm:text-lg leading-relaxed font-medium">
                                    {{ $faq['a'] }}
                                </p>
                                
                                <div class="mt-8 flex items-center gap-4">
                                    <div class="w-2 h-2 rounded-full bg-primary/40"></div>
                                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-400">Diverifikasi oleh Tim Teknis RooterIn</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Bottom Callout -->
        <div class="mt-16 sm:mt-20 text-center">
            <p class="text-gray-400 font-bold text-xs uppercase tracking-[0.3em] mb-8">Punya pertanyaan lain yang belum terjawab?</p>
            <x-button variant="secondary" href="https://wa.me/6281234567890" class="!rounded-full !py-6 !px-12 group">
                <span class="flex items-center gap-4 text-xs font-black uppercase tracking-[0.2em]">
                    Tanya via WhatsApp
                    <i class="ri-whatsapp-line text-xl group-hover:scale-110 transition-transform text-primary"></i>
                </span>
            </x-button>
        </div>
    </div>
</section>
