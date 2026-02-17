@props(['title', 'subtitle' => '', 'align' => 'center', 'dark' => false])

<div class="{{ $align === 'center' ? 'text-center' : ($align === 'right' ? 'text-right' : 'text-left') }} mb-16">
    @if($subtitle)
        <span class="{{ $dark ? 'text-accent' : 'text-primary' }} font-bold tracking-widest uppercase text-xs sm:text-sm block mb-3 animate-fade-in-up">
            {{ $subtitle }}
        </span>
    @endif
    <h2 class="text-3xl sm:text-4xl md:text-5xl font-heading font-extrabold {{ $dark ? 'text-white' : 'text-secondary' }} leading-tight">
        {!! $title !!}
    </h2>
    <div class="mt-4 flex {{ $align === 'center' ? 'justify-center' : ($align === 'right' ? 'justify-end' : 'justify-start') }}">
        <div class="h-1.5 w-20 bg-primary rounded-full"></div>
    </div>
</div>
