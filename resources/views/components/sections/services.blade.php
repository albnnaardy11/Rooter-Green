@props([
    'title' => 'Pilih Layanan Yang Anda Butuhkan',
    'subtitle' => 'SOLUSI TERLENGKAP',
    'services' => []
])

<section id="services" {{ $attributes->merge(['class' => 'py-16 sm:py-32 bg-stone-50 relative overflow-hidden']) }}>
    <!-- Background Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <x-section-heading :title="$title" :subtitle="$subtitle" />
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-12 mt-16">
            @foreach($services as $service)
                <x-service-card 
                    :title="$service['title']"
                    :desc="$service['desc']"
                    :img="$service['img']"
                    :color="$service['color']"
                />
            @endforeach
        </div>
        
        <!-- Bottom Callout -->
        <div class="mt-24 text-center">
             <div class="inline-flex flex-col sm:flex-row items-center gap-6 p-2 bg-white rounded-full shadow-xl border border-gray-100 pr-8">
                 <div class="flex -space-x-3 pl-4">
                     <img src="https://images.unsplash.com/photo-1542013936693-884638332954?w=64&h=64&fit=crop" class="w-10 h-10 rounded-full border-2 border-white object-cover" alt="Tool 1">
                     <img src="https://images.unsplash.com/photo-1581244276891-6bc617f77bc7?w=64&h=64&fit=crop" class="w-10 h-10 rounded-full border-2 border-white object-cover" alt="Tool 2">
                 </div>
                 <p class="text-secondary font-bold text-sm">Masalah pipa lainnya? Teknisi kami siap memberikan diagnosa gratis.</p>
                 <x-button variant="outline" class="!px-6 !py-3 text-xs" href="https://wa.me/6281234567890">Lihat Semua Solusi</x-button>
             </div>
        </div>
    </div>
</section>
