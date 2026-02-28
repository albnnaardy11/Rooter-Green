@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <!-- Header Architecture -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 animate-in fade-in slide-in-from-top duration-700">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white shadow-2xl shadow-primary/40">
                    <i class="ri-settings-5-line text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight">Site <span class="text-primary italic">Configurations.</span></h1>
                    <p class="text-slate-500 font-medium mt-1 uppercase text-[9px] tracking-[0.4em]">Integrated Core Parameters</p>
                </div>
            </div>
        </div>
        
        <div class="p-4 bg-slate-900/50 rounded-2xl border border-white/5 backdrop-blur-xl">
            <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1">Last System Sync</p>
            <p class="text-xs font-bold text-primary">{{ now()->format('d M Y - H:i') }} <span class="text-slate-600">UTC+7</span></p>
        </div>
    </div>

    @if(session('success'))
    <div class="p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-3xl text-emerald-500 text-sm font-bold animate-in zoom-in duration-300">
        <i class="ri-checkbox-circle-line mr-2"></i> {{ session('success') }}
    </div>
    @endif

    <!-- Configurations Matrix -->
    <form action="{{ route('admin.settings.bulk') }}" method="POST" class="space-y-12">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            @foreach($settings as $group => $items)
            <div class="space-y-6 group">
                <div class="flex items-center justify-between px-4">
                    <h3 class="text-sm font-black uppercase tracking-[0.2em] text-white flex items-center gap-3">
                        <span class="w-2 h-2 bg-primary rounded-full group-hover:scale-150 transition-transform"></span>
                        {{ $group }} <span class="text-slate-500">Parameters</span>
                    </h3>
                </div>
                
                <div class="bg-slate-900/40 rounded-[2.5rem] border border-white/5 divide-y divide-white/5 overflow-hidden backdrop-blur-2xl shadow-2xl group-hover:border-primary/20 transition-all duration-500">
                    @foreach($items as $setting)
                    <div class="p-8 sm:p-10 space-y-4 hover:bg-white/[0.02] transition-colors relative">
                        <div class="flex items-center justify-between">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ str_replace('_', ' ', $setting->key) }}</label>
                            <i class="ri-shield-keyhole-line text-slate-800 text-lg"></i>
                        </div>
                        
                        <div class="relative group/input">
                            <input 
                                type="text" 
                                name="settings[{{ $setting->id }}]" 
                                value="{{ $setting->value }}"
                                class="w-full bg-slate-950/50 border border-white/5 rounded-2xl px-6 py-4 text-white font-bold text-sm focus:outline-none focus:border-primary/50 transition-all placeholder-slate-800 shadow-inner"
                                placeholder="Configure {{ $setting->key }}..."
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none opacity-0 group-focus-within/input:opacity-100 transition-opacity">
                                <span class="bg-primary/20 text-primary text-[8px] font-black px-2 py-1 rounded">MODIFIED</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <span class="text-[8px] font-black text-slate-700 uppercase tracking-widest">Global Protocol</span>
                            <span class="h-px bg-white/5 flex-grow"></span>
                            <span class="text-[8px] font-black text-slate-700 uppercase tracking-widest">Secure Entry</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Submit Hub -->
        <div class="sticky bottom-8 z-40 px-4">
            <div class="max-w-7xl mx-auto flex items-center justify-between p-6 bg-slate-900/90 backdrop-blur-3xl border border-white/10 rounded-[2.5rem] shadow-3xl">
                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-widest">Configuration Console</h4>
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-1">Ready for cluster synchronization</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <button type="reset" class="px-8 py-4 bg-white/5 text-slate-400 hover:text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                        Reset Changes
                    </button>
                    <button type="submit" class="px-10 py-4 bg-primary text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:scale-105 active:scale-95 transition-all shadow-xl shadow-primary/20 flex items-center gap-3">
                        <i class="ri-refresh-line text-lg animate-spin-slow"></i>
                        Synchronize Core
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
    .shadow-3xl {
        box-shadow: 0 40px 100px -20px rgba(0,0,0,0.8);
    }
</style>
@endsection
