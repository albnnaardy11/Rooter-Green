@props([
    'items' => [
        [
            'title' => '100% Aman & Tanpa Kimia',
            'desc' => 'Pipa Awet, Tanpa Soda Api',
            'icon' => 'ri-leaf-fill',
            'variant' => 'primary'
        ],
        [
            'title' => 'Teknisi Ahli Terlisensi',
            'desc' => 'Handal, Jujur, & Profesional',
            'icon' => 'ri-verified-badge-fill',
            'variant' => 'accent'
        ],
        [
            'title' => 'Pasti Tiba 15 Menit',
            'desc' => 'Garansi Respon Super Kilat',
            'icon' => 'ri-flashlight-fill',
            'variant' => 'primary'
        ],
        [
            'title' => 'Solusi Chat Sekarang',
            'desc' => 'Konsultasi Gratis Tanpa Biaya',
            'icon' => 'ri-chat-voice-fill',
            'variant' => 'accent'
        ]
    ]
])

<section {{ $attributes->merge(['class' => 'relative z-30 -mt-10 sm:-mt-14']) }}>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/70 backdrop-blur-2xl rounded-[2rem] sm:rounded-[3rem] p-5 sm:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-white/50 relative overflow-hidden">
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16 relative z-10">
                @foreach($items as $item)
                    <div class="flex flex-col items-center group cursor-default">
                        <div @class([
                            'w-20 h-20 mb-6 bg-white rounded-3xl flex items-center justify-center border border-gray-100 shadow-xl shadow-gray-200/50 transition-all duration-500 group-hover:-translate-y-2',
                            'text-primary group-hover:shadow-primary/20 group-hover:border-primary/20' => ($item['variant'] ?? 'primary') === 'primary',
                            'text-accent group-hover:shadow-accent/20 group-hover:border-accent/20' => ($item['variant'] ?? 'primary') === 'accent',
                        ])>
                            <i class="{{ $item['icon'] }} text-4xl transition-transform duration-500 group-hover:scale-110"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-secondary font-black text-sm uppercase tracking-wider mb-1">{{ $item['title'] }}</div>
                            <div class="text-gray-400 text-[11px] font-bold font-sans italic">{{ $item['desc'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
