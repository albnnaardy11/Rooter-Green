<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rooter Green - Jasa Plumbing Premium') }} - Ahlinya Pipa Mampet</title>
    <meta name="description" content="Jasa pelancaran pipa mampet tanpa bongkar pertama di Indonesia. Menggunakan teknologi modern, ramah lingkungan, dan bergaransi.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-stone-50 text-slate-800">
    <div id="site-content" class="min-h-screen flex flex-col transition-all duration-300">
        @include('layouts.navigation')

        <main class="flex-grow">
            {{ $slot }}
        </main>

        @include('layouts.footer')
        
        <x-sticky-footer />
    </div>
    
    <x-accessibility-menu />
</body>
</html>
