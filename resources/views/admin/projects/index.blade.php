@extends('admin.layout')

@section('content')
<div class="space-y-12 pb-20" x-data="{ activeTab: 'residential' }">
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div>
            <h1 class="text-4xl sm:text-5xl font-heading font-black text-white tracking-tighter">
                Project <span class="text-primary italic">Vault.</span>
            </h1>
            <p class="text-slate-500 font-medium mt-2 uppercase text-[11px] tracking-[0.4em] flex items-center gap-2">
                <span class="w-8 h-[1px] bg-primary/30"></span>
                Portfolio Intelligence Management
            </p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.projects.create') }}" class="group relative px-8 py-4 bg-primary text-white rounded-2xl font-black uppercase text-[11px] tracking-widest overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-primary/20">
                <span class="relative z-10 flex items-center gap-2">
                    <i class="ri-add-fill text-lg"></i>
                    Register New Project
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
            </a>
        </div>
    </div>

    <!-- Stats Intelligence Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="p-8 rounded-[2.5rem] bg-slate-900/40 border border-white/5 backdrop-blur-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:scale-110 transition-transform duration-500">
                <i class="ri-gallery-fill text-6xl text-white"></i>
            </div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Total Workforce</p>
            <h3 class="text-4xl font-heading font-black text-white tabular-nums">{{ $stats['total'] }}</h3>
            <div class="mt-4 flex items-center gap-2 text-[10px] text-primary font-bold">
                <span class="flex h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                Live Database
            </div>
        </div>

        <div class="p-8 rounded-[2.5rem] bg-slate-900/40 border border-white/5 backdrop-blur-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:scale-110 transition-transform duration-500">
                <i class="ri-home-4-fill text-6xl text-white"></i>
            </div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Residential</p>
            <h3 class="text-4xl font-heading font-black text-white tabular-nums">{{ $stats['residential'] }}</h3>
            <div class="mt-4 flex items-center gap-2 text-[10px] text-blue-400 font-bold">
                <span class="flex h-2 w-2 rounded-full bg-blue-400"></span>
                Sektor Perumahan
            </div>
        </div>

        <div class="p-8 rounded-[2.5rem] bg-slate-900/40 border border-white/5 backdrop-blur-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:scale-110 transition-transform duration-500">
                <i class="ri-building-2-fill text-6xl text-white"></i>
            </div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Commercial</p>
            <h3 class="text-4xl font-heading font-black text-white tabular-nums">{{ $stats['commercial'] }}</h3>
            <div class="mt-4 flex items-center gap-2 text-[10px] text-accent font-bold">
                <span class="flex h-2 w-2 rounded-full bg-accent"></span>
                Sektor Industri
            </div>
        </div>

        <div class="p-8 rounded-[2.5rem] bg-slate-900/40 border border-white/5 backdrop-blur-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:scale-110 transition-transform duration-500">
                <i class="ri-star-fill text-6xl text-white"></i>
            </div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">High Performance</p>
            <h3 class="text-4xl font-heading font-black text-white tabular-nums">{{ $stats['featured'] }}</h3>
            <div class="mt-4 flex items-center gap-2 text-[10px] text-yellow-500 font-bold">
                <span class="flex h-2 w-2 rounded-full bg-yellow-500"></span>
                Featured Masterpieces
            </div>
        </div>
    </div>

    <!-- Professional Tabbed Interface -->
    <div class="space-y-8">
        <div class="flex items-center justify-center sm:justify-start gap-2 p-1.5 bg-slate-900/60 rounded-3xl border border-white/5 w-fit">
            <button @click="activeTab = 'residential'" 
                    :class="activeTab === 'residential' ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-white'"
                    class="px-8 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all duration-500 flex items-center gap-3">
                <i class="ri-home-smile-fill text-lg"></i>
                Residential Segment
            </button>
            <button @click="activeTab = 'commercial'" 
                    :class="activeTab === 'commercial' ? 'bg-accent text-white shadow-xl shadow-accent/20' : 'text-slate-500 hover:text-white'"
                    class="px-8 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all duration-500 flex items-center gap-3">
                <i class="ri-building-4-fill text-lg"></i>
                Commercial Segment
            </button>
        </div>

        <!-- Tables Container -->
        <div class="relative min-h-[500px]">
            <!-- Residential Table -->
            <div x-show="activeTab === 'residential'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                @include('admin.projects.partials.table', ['projects' => $residential, 'type' => 'Residential'])
            </div>

            <!-- Commercial Table -->
            <div x-show="activeTab === 'commercial'" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                @include('admin.projects.partials.table', ['projects' => $commercial, 'type' => 'Commercial'])
            </div>
        </div>
    </div>
</div>
@endsection
