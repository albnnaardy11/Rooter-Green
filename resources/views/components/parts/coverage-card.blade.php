@props([
    'mapImage' => 'https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?w=1600&fit=crop',
    'title' => 'Hadir Lebih Dekat <br> di <span class="text-primary italic">Setiap Sudut Kota</span>',
    'description' => 'Kami menempatkan pangkalan teknisi di titik-titik strategis untuk memastikan pengerjaan tepat waktu. Tidak perlu menunggu lama, teknisi ahli kami siap meluncur ke lokasi Anda.',
    'tags' => ['Sertifikasi Resmi', 'Alat Modern', 'Respon Cepat', 'Garansi Tuntas'],
    'badgeTitle' => 'Cakupannya <br> Jawa & Sumatera',
    'badgeDesc' => 'Armada teknisi kami beroperasi penuh di wilayah <span class="text-white font-bold">Jabodetabek, Jawa Barat, hingga Lampung & Metro.</span>'
])

<div {{ $attributes->merge(['class' => 'relative bg-secondary rounded-[2.5rem] sm:rounded-[4rem] p-6 sm:p-20 overflow-hidden group shadow-3xl']) }}>
    <!-- Abstract Map Graphic -->
    <div class="absolute inset-0 opacity-20 bg-[url(\'{{ $mapImage }}\')] grayscale brightness-200 scale-110"></div>
    
    <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-16">
        <div class="w-full lg:w-1/2 text-center lg:text-left pt-4 lg:pt-0">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary/20 text-primary font-bold text-[10px] sm:text-xs uppercase tracking-widest mb-6">
                Jaringan Terluas
            </div>
            <h3 class="text-2xl sm:text-5xl font-heading font-black text-white mb-6 leading-tight">
                {!! $title !!}
            </h3>
            <p class="text-gray-400 text-sm sm:text-lg leading-relaxed mb-10 max-w-2xl mx-auto lg:mx-0">
                {{ $description }}
            </p>
            <div class="grid grid-cols-2 sm:flex sm:flex-wrap justify-center lg:justify-start gap-3 sm:gap-4">
                @foreach($tags as $tag)
                <div class="flex items-center gap-2 bg-white/5 border border-white/10 px-3 sm:px-4 py-2 rounded-xl sm:rounded-2xl">
                    <i class="ri-checkbox-circle-fill text-primary text-xs sm:text-sm"></i>
                    <span class="text-white font-bold text-[8px] sm:text-xs uppercase tracking-tighter whitespace-nowrap">{{ $tag }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Visual Side - Summary Badge -->
        <div class="w-full lg:w-2/5 relative">
            <div class="bg-white/10 backdrop-blur-2xl border border-white/20 p-6 sm:p-10 rounded-[2rem] sm:rounded-[3rem] shadow-2xl relative overflow-hidden group/card hover:bg-white/15 transition-all duration-500">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/20 rounded-full blur-3xl"></div>
                
                <div class="flex items-center gap-4 mb-6 sm:mb-8 text-left">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-primary rounded-xl sm:rounded-2xl flex items-center justify-center shadow-lg shadow-primary/30 shrink-0">
                        <i class="ri-map-pin-fill text-white text-xl sm:text-2xl"></i>
                    </div>
                    <h4 class="text-white font-black text-lg sm:text-2xl leading-tight">{!! $badgeTitle !!}</h4>
                </div>

                <p class="text-white/60 text-[11px] sm:text-sm mb-8 leading-relaxed text-left">
                    {!! $badgeDesc !!}
                </p>

                <x-button href="https://wa.me/6281234567890?text=Halo%20Rooter%20Green%2C%20apakah%20melayani%20wilayah..." variant="primary" class="w-full !py-4 shadow-xl !rounded-xl sm:!rounded-2xl">
                    Tanya Wilayah Lainnya
                </x-button>
            </div>
        </div>
    </div>
</div>
