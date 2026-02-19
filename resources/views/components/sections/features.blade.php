@props([
    'title' => 'Hadir Menjadi Solusi Terbaik Anda',
    'subtitle' => 'KENAPA HARUS KAMI?',
    'description' => 'Kami mengerti rasa frustrasi Anda saat saluran pipa mampet di rumah. Itulah kenapa tim RooterIn hadir dengan standar pelayanan yang berbeda dari bengkel pipa biasa.',
    'mainImage' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=1200&fit=crop',
    'secondaryImage' => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=800&fit=crop',
    'features' => [
        [
            'title' => 'Ahli & Profesional',
            'desc' => 'Teknisi tersertifikasi dengan jam terbang tinggi di bidang plumbing.',
            'icon' => 'ri-medal-fill',
            'variant' => 'primary'
        ],
        [
            'title' => 'Konsultasi Gratis',
            'desc' => 'Tanya masalah pipa Anda kapan saja tanpa dipungut biaya sepeserpun.',
            'icon' => 'ri-chat-smile-3-fill',
            'variant' => 'accent'
        ],
        [
            'title' => 'Layanan Berkualitas',
            'desc' => 'Pengerjaan rapi, bersih, dan menggunakan standar teknologi terbaru.',
            'icon' => 'ri-shield-check-fill',
            'variant' => 'primary'
        ],
        [
            'title' => 'Harga Terbaik',
            'desc' => 'Penawaran harga paling kompetitif dengan kualitas hasil bintang lima.',
            'icon' => 'ri-price-tag-3-fill',
            'variant' => 'accent'
        ]
    ]
])

<section {{ $attributes->merge(['class' => 'py-24 bg-white overflow-hidden']) }}>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-20 items-center">
            <!-- Left Side: Layered Imagery -->
            <div class="lg:w-1/2 order-2 lg:order-1 relative">
                <div class="relative z-10 rounded-[2.5rem] overflow-hidden shadow-2xl skew-y-1 group">
                    <img src="{{ $mainImage }}" class="w-full transition-transform duration-1000 group-hover:scale-105" alt="Feature Main">
                </div>
                <div class="absolute -bottom-10 -right-10 w-2/3 z-20 rounded-[2rem] overflow-hidden shadow-2xl border-8 border-white group animate-bounce-soft">
                    <img src="{{ $secondaryImage }}" alt="Feature Secondary" class="w-full h-full object-cover">
                    <div class="absolute inset-x-0 bottom-0 p-4 bg-primary text-white font-bold text-center text-xs uppercase tracking-widest">
                        Pelaksanaan di Lokasi
                    </div>
                </div>
            </div>

            <!-- Right Side: Content & Feature Grid -->
            <div class="lg:w-1/2 order-1 lg:order-2">
                <x-section-heading :title="$title" :subtitle="$subtitle" align="left" />
                
                <p class="text-gray-600 text-lg mb-12 -mt-8 leading-relaxed">
                    {{ $description }}
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($features as $feature)
                        <div @class([
                            'flex flex-col gap-5 p-8 bg-stone-50/50 rounded-[2rem] border border-gray-100 hover:bg-white transition-all duration-300 group',
                            'hover:border-primary/20 hover:shadow-2xl hover:shadow-primary/5' => ($feature['variant'] ?? 'primary') === 'primary',
                            'hover:border-accent/20 hover:shadow-2xl hover:shadow-accent/5' => ($feature['variant'] ?? 'primary') === 'accent',
                        ])>
                            <div @class([
                                'w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-500',
                                'bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white' => ($feature['variant'] ?? 'primary') === 'primary',
                                'bg-accent/10 text-accent group-hover:bg-accent group-hover:text-white' => ($feature['variant'] ?? 'primary') === 'accent',
                            ])>
                                <i class="{{ $feature['icon'] }} text-2xl"></i>
                            </div>
                            <div>
                                <h4 @class([
                                    'font-black text-xl mb-2 transition-colors',
                                    'text-secondary group-hover:text-primary' => ($feature['variant'] ?? 'primary') === 'primary',
                                    'text-secondary group-hover:text-accent' => ($feature['variant'] ?? 'primary') === 'accent',
                                ])>{{ $feature['title'] }}</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
