@extends('admin.layout')

@section('content')
<div class="space-y-12" x-data="{ 
    activeTab: 'about',
    searchQuery: '',
    selectedCategory: 'all'
}">
    <!-- Header & Intelligence Stats -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 animate-in fade-in slide-in-from-top duration-700">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white shadow-2xl shadow-primary/40 animate-pulse">
                    <i class="ri-brain-line text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight leading-none">FAQ <span class="text-primary italic">Intelligence.</span></h1>
                    <p class="text-slate-500 font-medium mt-1 uppercase text-[9px] tracking-[0.4em]">Integrated Knowledge Management System</p>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 flex-grow max-w-4xl">
            <div class="group bg-slate-900/40 p-5 rounded-3xl border border-white/5 backdrop-blur-2xl hover:border-primary/30 transition-all duration-500">
                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                    <span class="w-1 h-1 bg-slate-500 rounded-full group-hover:bg-primary transition-all"></span>
                    Total Logic
                </p>
                <div class="flex items-center justify-between">
                    <p class="text-2xl font-black text-white group-hover:scale-110 transition-transform origin-left">{{ $stats['total'] }}</p>
                    <i class="ri-database-2-line text-slate-700 text-xl group-hover:text-primary/50 transition-colors"></i>
                </div>
            </div>
            <div class="group bg-slate-900/40 p-5 rounded-3xl border border-white/5 backdrop-blur-2xl border-l-primary/30 hover:bg-primary/5 transition-all duration-500">
                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2 text-primary">
                    <span class="w-1 h-1 bg-primary rounded-full"></span>
                    About Page
                </p>
                <div class="flex items-center justify-between">
                    <p class="text-2xl font-black text-white tracking-tighter">{{ $stats['about'] }}</p>
                    <i class="ri-building-line text-primary/30 text-xl"></i>
                </div>
            </div>
            <div class="group bg-slate-900/40 p-5 rounded-3xl border border-white/5 backdrop-blur-2xl border-l-accent/30 hover:bg-accent/5 transition-all duration-500">
                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2 text-accent">
                    <span class="w-1 h-1 bg-accent rounded-full"></span>
                    Landing Page
                </p>
                <div class="flex items-center justify-between">
                    <p class="text-2xl font-black text-white tracking-tighter">{{ $stats['landing'] }}</p>
                    <i class="ri-rocket-2-line text-accent/30 text-xl"></i>
                </div>
            </div>
            <div class="group bg-slate-900/40 p-5 rounded-3xl border border-white/5 backdrop-blur-2xl hover:border-red-500/30 transition-all duration-500">
                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                    <span class="w-1 h-1 bg-red-500 rounded-full"></span>
                    Offline
                </p>
                <div class="flex items-center justify-between">
                    <p class="text-2xl font-black text-white">{{ $stats['inactive'] }}</p>
                    <i class="ri-error-warning-line text-red-500/30 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- UI Control Bar -->
    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 bg-slate-900/50 p-6 rounded-[2.5rem] border border-white/5 backdrop-blur-xl">
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <!-- Tab Switcher -->
            <div class="flex p-1.5 bg-slate-950 rounded-2xl border border-white/5 w-full sm:w-auto overflow-x-auto no-scrollbar">
                <button 
                    @click="activeTab = 'about'"
                    :class="activeTab === 'about' ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-105' : 'text-slate-500 hover:text-slate-300'"
                    class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap"
                >
                    <i class="ri-layout-top-line mr-2"></i> About Us Section
                </button>
                <button 
                    @click="activeTab = 'landing'"
                    :class="activeTab === 'landing' ? 'bg-accent text-white shadow-xl shadow-accent/20 scale-105' : 'text-slate-500 hover:text-slate-300'"
                    class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap"
                >
                    <i class="ri-layout-bottom-line mr-2"></i> Landing Section
                </button>
            </div>
            
            <!-- Category Filter (Simplified for Blade/Alpine interaction) -->
            <div class="relative w-full sm:w-64 group">
                <i class="ri-filter-3-line absolute left-6 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-primary transition-colors"></i>
                <select 
                    x-model="selectedCategory"
                    class="w-full bg-slate-950 border border-white/5 rounded-2xl pl-14 pr-6 py-3.5 text-xs font-bold text-white focus:outline-none focus:border-primary/50 transition-all appearance-none"
                >
                    <option value="all">All Categories</option>
                    @foreach(\App\Models\FaqCategory::all() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <i class="ri-arrow-down-s-line absolute right-6 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none"></i>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <!-- Search -->
            <div class="relative w-full sm:w-80 group">
                <i class="ri-search-line absolute left-6 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-primary transition-colors"></i>
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    placeholder="Search intelligence database..." 
                    class="w-full bg-slate-950 border border-white/5 rounded-2xl pl-14 pr-6 py-3.5 text-xs font-bold text-white placeholder-slate-600 focus:outline-none focus:border-primary/50 transition-all"
                >
            </div>

            <a href="{{ route('admin.faqs.create') }}" class="flex items-center justify-center w-14 h-14 bg-primary text-white rounded-2xl shadow-xl shadow-primary/20 hover:scale-110 active:scale-95 transition-all group">
                <i class="ri-add-line text-2xl group-hover:rotate-90 transition-transform duration-500"></i>
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-3xl text-emerald-500 text-sm font-bold animate-in zoom-in duration-300">
        <i class="ri-checkbox-circle-line mr-2"></i> {{ session('success') }}
    </div>
    @endif

    <!-- Tables Container with Multi-Table Logic -->
    <div class="grid grid-cols-1 gap-12">
        <!-- TABLE 1: ABOUT SECTION -->
        <div 
            x-show="activeTab === 'about'" 
            x-transition:enter="transition ease-out duration-500" 
            x-transition:enter-start="opacity-0 translate-y-10" 
            x-transition:enter-end="opacity-100 translate-y-0"
            class="space-y-6"
        >
            <div class="bg-slate-900/60 rounded-[3rem] border border-white/5 overflow-hidden backdrop-blur-3xl shadow-2xl">
                <div class="px-10 py-8 border-b border-white/5 flex items-center justify-between bg-gradient-to-r from-primary/5 to-transparent">
                    <div class="flex items-center gap-4">
                        <div class="w-2 h-8 bg-primary rounded-full"></div>
                        <div>
                            <h3 class="text-sm font-black uppercase tracking-[0.2em] text-white">About Us <span class="text-primary italic">FAQ Cluster</span></h3>
                            <p class="text-[10px] text-slate-500 font-bold tracking-widest mt-1">PRIMARY KNOWLEDGE BASE</p>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-950/50 text-[9px] font-black uppercase text-slate-500 tracking-widest">
                                <th class="px-10 py-5">Intel Content & Logic</th>
                                <th class="px-10 py-5 text-center">Category System</th>
                                <th class="px-10 py-5 text-center">Protocol Status</th>
                                <th class="px-10 py-5 text-right whitespace-nowrap">Execution</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($aboutFaqs as $faq)
                            <tr 
                                x-show="(searchQuery === '' || '{{ strtolower($faq->question) }}'.includes(searchQuery.toLowerCase())) && (selectedCategory === 'all' || selectedCategory === '{{ $faq->faq_category_id }}')"
                                class="hover:bg-primary/[0.03] transition-all duration-300 group"
                            >
                                <td class="px-10 py-8 max-w-xl">
                                    <div class="flex items-start gap-4">
                                        <span class="text-[10px] font-black text-slate-700 mt-1 pointer-events-none uppercase">ID/{{ str_pad($faq->id, 3, '0', STR_PAD_LEFT) }}</span>
                                        <div>
                                            <p class="text-sm font-black text-slate-200 group-hover:text-primary transition-colors leading-relaxed tracking-tight underline-offset-8 decoration-primary/30 group-hover:underline">{{ $faq->question }}</p>
                                            <p class="text-xs text-slate-500 mt-3 line-clamp-2 leading-relaxed font-medium transition-colors group-hover:text-slate-400">
                                                {{ $faq->answer }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-10 h-10 rounded-xl bg-slate-950 border border-white/5 flex items-center justify-center text-slate-400 group-hover:text-primary group-hover:border-primary/20 transition-all duration-500">
                                            <i class="{{ $faq->category->icon }} text-xl"></i>
                                        </div>
                                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-500 mt-3">
                                            {{ $faq->category->name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <div class="flex items-center justify-center">
                                        @if($faq->is_active)
                                            <div class="flex flex-col items-center gap-2">
                                                <div class="w-2 h-2 rounded-full bg-primary animate-pulse shadow-[0_0_15px_#1FAF5A]"></div>
                                                <span class="text-[8px] font-black uppercase tracking-widest text-primary">Live</span>
                                            </div>
                                        @else
                                            <div class="flex flex-col items-center gap-2">
                                                <div class="w-2 h-2 rounded-full bg-slate-800 border border-white/10"></div>
                                                <span class="text-[8px] font-black uppercase tracking-widest text-slate-600">Offline</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 -translate-x-4 group-hover:translate-x-0">
                                        <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="flex items-center gap-2 px-5 py-2.5 bg-white/5 text-[9px] font-black text-slate-300 uppercase tracking-widest rounded-xl hover:bg-primary hover:text-white transition-all">
                                            <i class="ri-edit-2-line"></i> EDIT
                                        </a>
                                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 bg-red-500/10 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all flex items-center justify-center" onclick="return confirm('Initiate secure deletion of this logic entry?')">
                                                <i class="ri-delete-bin-4-line text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TABLE 2: LANDING SECTION -->
        <div 
            x-show="activeTab === 'landing'" 
            x-transition:enter="transition ease-out duration-500" 
            x-transition:enter-start="opacity-0 translate-y-10" 
            x-transition:enter-end="opacity-100 translate-y-0"
            class="space-y-6"
        >
            <div class="bg-slate-900/60 rounded-[3rem] border border-white/5 overflow-hidden backdrop-blur-3xl shadow-2xl">
                <div class="px-10 py-8 border-b border-white/5 flex items-center justify-between bg-gradient-to-r from-accent/5 to-transparent">
                    <div class="flex items-center gap-4">
                        <div class="w-2 h-8 bg-accent rounded-full"></div>
                        <div>
                            <h3 class="text-sm font-black uppercase tracking-[0.2em] text-white">Landing Page <span class="text-accent italic">FAQ Cluster</span></h3>
                            <p class="text-[10px] text-slate-500 font-bold tracking-widest mt-1">CONVERSION ORIENTED LOGIC</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-950/50 text-[9px] font-black uppercase text-slate-500 tracking-widest">
                                <th class="px-10 py-5">Visual Question</th>
                                <th class="px-10 py-5 text-center">Category</th>
                                <th class="px-10 py-5 text-center">Status</th>
                                <th class="px-10 py-5 text-right whitespace-nowrap">Manage</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($landingFaqs as $faq)
                            <tr 
                                x-show="(searchQuery === '' || '{{ strtolower($faq->question) }}'.includes(searchQuery.toLowerCase())) && (selectedCategory === 'all' || selectedCategory === '{{ $faq->faq_category_id }}')"
                                class="hover:bg-accent/[0.03] transition-all duration-300 group"
                            >
                                <td class="px-10 py-8 max-w-xl">
                                    <p class="text-sm font-black text-slate-200 group-hover:text-accent transition-colors leading-tight tracking-tight underline-offset-8 decoration-accent/30 group-hover:underline">{{ $faq->question }}</p>
                                    <div class="mt-4 flex items-center gap-6">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[8px] font-black text-slate-600 uppercase">Order Priority</span>
                                            <span class="w-6 h-6 rounded-lg bg-slate-950 border border-white/5 flex items-center justify-center text-[10px] font-black text-accent">{{ $faq->order }}</span>
                                        </div>
                                        <div class="h-4 w-px bg-white/5"></div>
                                        <p class="text-[10px] text-slate-600 font-medium italic truncate max-w-[250px]">{{ $faq->answer }}</p>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-10 h-10 rounded-xl bg-slate-950 border border-white/5 flex items-center justify-center text-slate-400 group-hover:text-accent group-hover:border-accent/20 transition-all duration-500">
                                            <i class="{{ $faq->category->icon }} text-xl"></i>
                                        </div>
                                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-500 mt-3">
                                            {{ $faq->category->name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-10 py-8 text-center">
                                    <span class="px-4 py-1.5 rounded-full text-[8px] font-black uppercase tracking-widest {{ $faq->is_active ? 'bg-accent/10 text-accent border border-accent/20 shadow-[0_0_15px_rgba(253,186,116,0.1)]' : 'bg-slate-900 text-slate-600 border border-white/5' }}">
                                        {{ $faq->is_active ? 'ACTIVE' : 'OFFLINE' }}
                                    </span>
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500">
                                        <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="flex items-center gap-2 px-5 py-2 calc bg-white/5 text-[9px] font-black text-slate-300 uppercase tracking-widest rounded-xl hover:bg-accent hover:text-white transition-all shadow-lg hover:shadow-accent/20">
                                            <i class="ri-settings-5-line"></i> CONFIGURE
                                        </a>
                                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 bg-red-500/10 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all flex items-center justify-center shadow-lg hover:shadow-red-500/20" onclick="return confirm('Purge this intelligence entry from production?')">
                                                <i class="ri-delete-bin-line text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
