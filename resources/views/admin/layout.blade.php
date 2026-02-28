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
        <!-- Sidebar (Fixed) -->
        <aside class="w-64 bg-slate-925 border-r border-white/5 flex flex-col fixed top-0 left-0 h-screen z-50 overflow-hidden bg-slate-900 shadow-2xl">
            <!-- Pinned Header -->
            <div class="p-8 border-b border-white/5 flex-shrink-0 bg-slate-900">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/20">
                        <i class="ri-flashlight-fill text-2xl"></i>
                    </div>
                    <span class="font-heading font-black text-xl text-white tracking-widest">ROOTER<span class="text-primary">IN</span></span>
                </div>
                <p class="text-[9px] text-gray-500 font-black tracking-[0.4em] uppercase mt-2">CMS Control Hub</p>
            </div>

            <!-- Scrollable Navigation Area -->
            <nav class="flex-grow p-4 space-y-1 overflow-y-auto no-scrollbar scroll-smooth">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-dashboard-3-line text-xl"></i>
                    <span class="font-bold text-sm">Dashboard</span>
                </a>

                <!-- GROUP A: KONTEN UTAMA -->
                <div class="pt-6 pb-2 px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                    <i class="ri-folder-open-line"></i> Core Assets
                </div>
                
                <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.posts.*') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-article-line text-xl"></i>
                    <span class="text-sm font-bold">Tips & Trik</span>
                </a>
                <a href="{{ route('admin.services.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.services.*') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-customer-service-2-line text-xl"></i>
                    <span class="text-sm font-bold">Layanan</span>
                </a>
                <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.projects.*') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-gallery-line text-xl"></i>
                    <span class="text-sm font-bold">Galeri Proyek</span>
                </a>
                <a href="{{ route('admin.media.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.media.*') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-image-2-line text-xl"></i>
                    <span class="text-sm font-bold">Media Library</span>
                </a>
                <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.faqs.*') || request()->routeIs('admin.faq-categories.*') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-question-answer-line text-xl"></i>
                    <span class="text-sm font-bold">Pusat FAQ</span>
                </a>
                <div class="py-2">
                    <a href="{{ route('admin.wiki.index') }}" class="flex items-center justify-between gap-4 px-4 py-3 rounded-xl transition-all border {{ request()->routeIs('admin.wiki.*') ? 'bg-accent/10 border-accent/50 text-accent shadow-lg shadow-accent/20' : 'bg-gradient-to-r from-slate-900 to-slate-800 border-white/5 hover:border-accent text-slate-300' }}">
                        <div class="flex items-center gap-4">
                            <i class="ri-book-read-line text-xl {{ request()->routeIs('admin.wiki.*') ? 'animate-pulse' : 'text-accent' }}"></i>
                            <span class="text-sm font-bold font-heading">WikiPipa Automator</span>
                        </div>
                        <i class="ri-magic-line text-xs opacity-50"></i>
                    </a>
                </div>

                <!-- GROUP B: KONFIGURASI -->
                <div class="pt-6 pb-2 px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                    <i class="ri-settings-3-line"></i> Systems
                </div>
                
                <a href="{{ route('admin.partners.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.partners.*') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-building-2-line text-xl"></i>
                    <span class="text-sm font-bold">Industrial Alliances</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-global-line text-xl"></i>
                    <span class="text-sm font-bold">Site Settings</span>
                </a>
                <a href="{{ route('admin.seo.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.seo.*') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-search-eye-line text-xl"></i>
                    <span class="text-sm font-bold">SEO Central</span>
                </a>
                <a href="{{ route('admin.ai.intelligence.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.ai.intelligence.*') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-radar-box-line text-xl"></i>
                    <span class="text-sm font-bold font-heading">AI Business Analytics</span>
                </a>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.messages.*') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-mail-line text-xl"></i>
                    <span class="text-sm font-bold">Messages</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.users.*') ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-group-line text-xl"></i>
                    <span class="text-sm font-bold">Admin Users</span>
                </a>

                <!-- GROUP C: KEAMANAN & LOG -->
                <div class="pt-6 pb-2 px-4 text-[10px] font-black text-rose-800 uppercase tracking-widest flex items-center gap-2">
                    <i class="ri-shield-keyhole-line"></i> Security Vault
                </div>
                
                <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.activity-logs.*') ? 'bg-rose-900/20 text-rose-500 border-l-4 border-rose-500' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-history-line text-xl"></i>
                    <span class="text-sm font-bold">System Logs</span>
                </a>
                <a href="{{ route('admin.vault.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.vault.*') ? 'bg-rose-900/20 text-rose-500 border-l-4 border-rose-500' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-lock-2-line text-xl"></i>
                    <span class="text-sm font-bold">Vault Access</span>
                </a>
                <a href="{{ route('admin.ai.central.ops.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.ai.central.ops.*') ? 'bg-rose-900/20 text-rose-500 border-l-4 border-rose-500' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-brain-line text-xl"></i>
                    <span class="text-sm font-bold">AI Central Ops</span>
                </a>
                <a href="{{ route('admin.sentinel.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.sentinel.*') ? 'bg-rose-900/20 text-rose-500 border-l-4 border-rose-500' : 'hover:bg-white/5 text-slate-400 hover:text-white' }}">
                    <i class="ri-radar-line text-xl"></i>
                    <span class="text-sm font-bold">System Sentinel</span>
                </a>
                
                <!-- Spacer for bottom scroll -->
                <div class="h-6"></div>
            </nav>

            <!-- Pinned Footer -->
            <div class="p-6 border-t border-white/5 bg-slate-900 flex-shrink-0">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-950 shadow-inner">
                    <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center">
                        <i class="ri-user-settings-fill text-primary"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white">Admin RooterIn</p>
                        <p class="text-[9px] text-gray-500 font-black uppercase">Super Admin</p>
                    </div>
                </div>
                <a href="/" target="_blank" class="mt-4 flex items-center justify-center gap-2 w-full py-2 rounded-lg bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest hover:bg-primary hover:text-white transition-all border border-primary/20 hover:border-primary">
                    <i class="ri-external-link-line"></i>
                    View Live Site
                </a>
            </div>
        </aside>

        <!-- Main Content Area (Offset by Sidebar Width) -->
        <main class="flex-grow bg-slate-950 p-8 sm:p-12 ml-64 min-h-screen">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
