<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RooterIn Admin - Dashboard Hub</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-300">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 border-r border-white/5 flex flex-col">
            <div class="p-8 border-b border-white/5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/20">
                        <i class="ri-flashlight-fill text-2xl"></i>
                    </div>
                    <span class="font-heading font-black text-xl text-white tracking-widest">ROOTER<span class="text-primary">IN</span></span>
                </div>
                <p class="text-[9px] text-gray-500 font-black tracking-[0.4em] uppercase mt-2">CMS Control Hub</p>
            </div>

            <nav class="flex-grow p-4 space-y-2 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-dashboard-3-line text-xl"></i>
                    <span class="font-bold text-sm">Dashboard</span>
                </a>

                <div class="pt-4 pb-2 px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">Konten Utama</div>
                
                <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.posts.*') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-article-line text-xl"></i>
                    <span class="text-sm font-bold">Tips & Trik</span>
                </a>
                <a href="{{ route('admin.services.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.services.*') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-customer-service-2-line text-xl"></i>
                    <span class="text-sm font-bold">Layanan</span>
                </a>
                <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.projects.*') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-gallery-line text-xl"></i>
                    <span class="text-sm font-bold">Galeri Proyek</span>
                </a>
                <a href="{{ route('admin.media.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.media.*') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-image-2-line text-xl"></i>
                    <span class="text-sm font-bold">Media Library</span>
                </a>
                <a href="{{ route('admin.wiki.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.wiki.*') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-book-open-line text-xl"></i>
                    <span class="text-sm font-bold">WikiPipa Automator</span>
                </a>

                <div class="pt-4 pb-2 px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">Konfigurasi</div>
                
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-settings-4-line text-xl"></i>
                    <span class="text-sm font-bold">Site Settings</span>
                </a>
                <a href="{{ route('admin.seo.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.seo.*') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-search-eye-line text-xl"></i>
                    <span class="text-sm font-bold">SEO Central</span>
                </a>
                <a href="{{ route('admin.ai.intelligence.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.ai.intelligence.*') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-radar-box-line text-xl"></i>
                    <span class="text-sm font-bold font-heading">AI Intelligence</span>
                </a>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.messages.*') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-mail-line text-xl"></i>
                    <span class="font-bold text-sm">Messages</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-group-line text-xl"></i>
                    <span class="text-sm font-bold">Admin Users</span>
                </a>
                <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.activity-logs.*') ? 'bg-primary/10 text-primary border border-primary/20' : 'hover:bg-white/5' }}">
                    <i class="ri-radar-line text-xl"></i>
                    <span class="text-sm font-bold">System Logs</span>
                </a>
            </nav>

            <div class="p-6 border-t border-white/5">
                <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/5">
                    <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center">
                        <i class="ri-user-heart-line text-primary"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white">Admin RooterIn</p>
                        <p class="text-[10px] text-gray-500">Super Administrator</p>
                    </div>
                </div>
                <a href="/" target="_blank" class="mt-4 flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest hover:bg-primary hover:text-white transition-all">
                    <i class="ri-external-link-line"></i>
                    View Website
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow bg-slate-950 p-8 sm:p-12">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
