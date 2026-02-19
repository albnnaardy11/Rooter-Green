@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight">System <span class="text-primary italic">Overview.</span></h1>
            <p class="text-slate-500 font-medium mt-2 uppercase text-[10px] tracking-[0.3em]">Real-time operational statistics</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-6 py-3 bg-white/5 rounded-2xl border border-white/5 backdrop-blur-xl">
                <p class="text-[9px] text-gray-500 font-black uppercase tracking-widest mb-1">Current Status</p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-primary rounded-full animate-ping"></span>
                    <span class="text-white font-bold text-sm">System Healthy</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat Card -->
        <div class="bg-slate-900/50 p-8 rounded-[2rem] border border-white/5 hover:border-primary/30 transition-all group overflow-hidden relative">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-primary/5 rounded-full blur-3xl transition-all group-hover:bg-primary/10"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6 transition-transform group-hover:scale-110">
                    <i class="ri-article-line text-2xl"></i>
                </div>
                <p class="text-5xl font-heading font-black text-white mb-2">{{ $stats['total_posts'] }}</p>
                <p class="text-xs text-slate-500 font-black uppercase tracking-widest">Total Articles</p>
            </div>
        </div>

        <div class="bg-slate-900/50 p-8 rounded-[2rem] border border-white/5 hover:border-primary/30 transition-all group overflow-hidden relative">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-primary/5 rounded-full blur-3xl transition-all group-hover:bg-primary/10"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6 transition-transform group-hover:scale-110">
                    <i class="ri-customer-service-2-line text-2xl"></i>
                </div>
                <p class="text-5xl font-heading font-black text-white mb-2">{{ $stats['total_services'] }}</p>
                <p class="text-xs text-slate-500 font-black uppercase tracking-widest">Active Services</p>
            </div>
        </div>

        <div class="bg-slate-900/50 p-8 rounded-[2rem] border border-white/5 hover:border-primary/30 transition-all group overflow-hidden relative"">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-primary/5 rounded-full blur-3xl transition-all group-hover:bg-primary/10"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6 transition-transform group-hover:scale-110">
                    <i class="ri-gallery-line text-2xl"></i>
                </div>
                <p class="text-5xl font-heading font-black text-white mb-2">{{ $stats['total_projects'] }}</p>
                <p class="text-xs text-slate-500 font-black uppercase tracking-widest">Project Gallery</p>
            </div>
        </div>

        <div class="bg-primary p-8 rounded-[2rem] shadow-xl shadow-primary/20 transition-all group overflow-hidden relative animate-fade-in-up">
            <div class="absolute inset-0 bg-white/5 translate-y-[100%] group-hover:translate-y-0 transition-transform duration-500"></div>
            <div class="relative z-10 text-white">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                    <i class="ri-mail-star-line text-2xl"></i>
                </div>
                <p class="text-5xl font-heading font-black mb-2">{{ $stats['new_messages'] }}</p>
                <p class="text-xs text-white/70 font-black uppercase tracking-widest">New Messages</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activities -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-xl font-heading font-black text-white tracking-tight">Recent <span class="text-primary italic">Articles.</span></h3>
                <a href="{{ route('admin.posts.index') }}" class="text-[10px] font-black uppercase tracking-widest text-primary hover:underline">View All</a>
            </div>
            
            <div class="space-y-4">
                @foreach($stats['recent_posts'] as $post)
                <div class="bg-white/5 p-6 rounded-[2rem] border border-white/5 flex items-center gap-6 group hover:bg-white/[0.08] transition-all">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0">
                        <img src="{{ $post->featured_image }}" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-primary/10 text-primary text-[8px] font-black uppercase tracking-widest rounded-full">{{ $post->category }}</span>
                            <span class="text-[9px] text-slate-500 font-bold uppercase">{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <h4 class="text-white font-bold group-hover:text-primary transition-colors">{{ $post->title }}</h4>
                    </div>
                    <div class="hidden sm:flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full {{ $post->status == 'published' ? 'bg-primary shadow-[0_0_8px_#1FAF5A]' : 'bg-yellow-500' }}"></div>
                        <span class="text-[9px] font-black uppercase tracking-widest">{{ $post->status }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sidebar Activities -->
        <div class="space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-xl font-heading font-black text-white tracking-tight">Recent <span class="text-primary italic">Messages.</span></h3>
            </div>

            <div class="space-y-4">
                @foreach($stats['recent_messages'] as $msg)
                <div class="bg-slate-900/50 p-5 rounded-3xl border border-white/5 hover:border-primary/20 transition-all group">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                            <i class="ri-user-smile-line text-lg"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">{{ $msg->name }}</p>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tight">{{ $msg->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 line-clamp-2 italic leading-relaxed">{{ $msg->message }}</p>
                </div>
                @endforeach

                @if($stats['recent_messages']->isEmpty())
                <div class="py-12 text-center bg-white/5 rounded-[2rem] border border-white/5 border-dashed">
                    <i class="ri-mail-open-line text-4xl text-slate-700 block mb-4"></i>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">No new messages</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
