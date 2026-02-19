@props([
    'title', 
    'desc', 
    'img', 
    'color' => 'primary',
    'badge' => 'Premium Service'
])

<div {{ $attributes->merge(['class' => 'group relative bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-gray-200/50 hover:shadow-2xl transition-all duration-500 hover:-translate-y-3']) }}
     @class([
         'hover:shadow-primary/10' => $color === 'primary',
         'hover:shadow-accent/10' => $color === 'accent',
     ])>
    
    <!-- Image Area -->
    <div class="h-64 overflow-hidden relative">
        <img src="{{ $img }}" alt="{{ $title }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
        <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-white to-transparent"></div>
        
        <!-- Floating Category Label -->
        <div class="absolute top-6 left-6 px-4 py-1.5 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-black text-secondary uppercase tracking-widest border border-white/20 shadow-sm">
            {{ $badge }}
        </div>
    </div>

    <!-- Content Area -->
    <div class="p-6 sm:p-10 pt-4 relative">
        <!-- Accent Line -->
        <div @class([
            'w-12 h-1 rounded-full mb-6 group-hover:w-20 transition-all duration-500',
            'bg-primary' => $color === 'primary',
            'bg-accent' => $color === 'accent',
        ])></div>
        
        <h3 @class([
            'text-2xl font-heading font-black text-secondary mb-4 leading-tight transition-colors',
            'group-hover:text-primary' => $color === 'primary',
            'group-hover:text-accent' => $color === 'accent',
        ])>
            {{ $title }}
        </h3>
        <p class="text-gray-500 text-sm leading-relaxed mb-8 opacity-80 group-hover:opacity-100 transition-opacity">
            {{ $desc }}
        </p>
        
        <!-- CTA Link -->
        <a href="https://wa.me/6281234567890?text=Halo%20Rooter%20Green%2C%20mau%20order%20{{ urlencode($title) }}" 
           @class([
               'inline-flex items-center font-bold text-sm tracking-tight group/link',
               'text-primary' => $color === 'primary',
               'text-accent' => $color === 'accent',
           ])>
            <span @class([
                'border-b-2 pb-1 transition-all',
                'border-primary/20 group-hover/link:border-primary' => $color === 'primary',
                'border-accent/20 group-hover/link:border-accent' => $color === 'accent',
            ])>Hubungi Sekarang</span>
            <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </div>
</div>
