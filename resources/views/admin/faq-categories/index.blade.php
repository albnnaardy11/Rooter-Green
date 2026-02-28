@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <!-- Header & Intel -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 animate-in fade-in slide-in-from-top duration-700">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white shadow-2xl shadow-primary/40">
                    <i class="ri-folder-info-line text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight leading-none">Category <span class="text-primary italic">Matrix.</span></h1>
                    <p class="text-slate-500 font-medium mt-1 uppercase text-[9px] tracking-[0.4em]">Structured Knowledge Segments</p>
                </div>
            </div>
        </div>
        
        <div class="flex gap-4">
            <a href="{{ route('admin.faqs.index') }}" class="px-8 py-3 bg-white/5 text-white border border-white/10 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-white/10 transition-all">
                Project Dashboard
            </a>
            <a href="{{ route('admin.faq-categories.create') }}" class="px-8 py-3 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-all shadow-xl shadow-primary/20">
                <i class="ri-add-line mr-2"></i> New Matrix
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-3xl text-emerald-500 text-sm font-bold">
        {{ session('success') }}
    </div>
    @endif

    <!-- Category Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <div class="group relative bg-slate-900/50 rounded-[2.5rem] border border-white/5 p-10 overflow-hidden hover:border-primary/30 transition-all duration-500 backdrop-blur-xl">
            <!-- Background Glow -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary/5 blur-[80px] rounded-full group-hover:bg-primary/20 transition-all duration-700"></div>
            
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex items-start justify-between mb-8">
                    <div class="w-16 h-16 rounded-[1.5rem] bg-slate-950 border border-white/10 flex items-center justify-center text-3xl group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-500 group-hover:shadow-2xl group-hover:shadow-primary/40">
                        <i class="{{ $category->icon }}"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1">Index Position</p>
                        <p class="text-xl font-black text-white italic">#{{ $category->order }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-black text-white group-hover:text-primary transition-colors tracking-tight">{{ $category->name }}</h3>
                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-2">{{ $category->slug }}</p>
                    
                    <div class="mt-8 pt-8 border-t border-white/5 flex items-center justify-between">
                        <div>
                            <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1">Linked Entities</p>
                            <p class="text-sm font-black text-white">{{ $category->faqs_count ?? $category->faqs->count() }} <span class="text-slate-500 font-medium italic text-[10px]">Points</span></p>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.faq-categories.edit', $category->id) }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all shadow-lg">
                                <i class="ri-settings-4-line text-xl"></i>
                            </a>
                            <form action="{{ route('admin.faq-categories.destroy', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:bg-red-500 hover:text-white transition-all shadow-lg" onclick="return confirm('Securely delete this category matrix?')">
                                    <i class="ri-delete-bin-line text-xl"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
