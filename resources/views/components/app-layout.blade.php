<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! \Artesaos\SEOTools\Facades\SEOTools::generate() !!}
    
    {{-- Hreflang Automator --}}
    {!! $hreflangTags ?? '' !!}
    
    {{-- Headless Semantic Entity Graph --}}
    {!! $semanticSchema ?? '' !!}

    <script>
        function trackWhatsAppClick(source = 'general') {
            fetch('/api/track-whatsapp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    url: window.location.href,
                    source: source
                })
            });
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Local Edge Pre-Rendering (Speculative Rules API) --}}
    <script type="speculationrules">
    {
      "prerender": [{
        "source": "list",
        "urls": ["{{ route('home') }}", "{{ route('services') }}", "{{ route('ai.diagnostic') }}"]
      }, {
        "source": "document",
        "where": { "and": [
          { "href_matches": "/area/*" },
          { "not": { "href_matches": "/admin/*" }}
        ]},
        "eagerness": "moderate"
      }]
    }
    </script>
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

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => {
                        console.log('Service Worker Registered');
                        // NOTE: Auto-reload disabled to prevent interrupting AI Diagnostic modal
                        // reg.onupdatefound fires but we DON'T force reload anymore
                        reg.onupdatefound = () => {
                            const installingWorker = reg.installing;
                            installingWorker.onstatechange = () => {
                                if (installingWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    console.log('New SW version available (manual refresh to apply).');
                                    // DO NOT auto-reload — would disrupt AI modal result display
                                }
                            };
                        };
                    })
                    .catch(err => console.log('Service Worker Failed', err));
            });
        }
    </script>
</body>
</html>
