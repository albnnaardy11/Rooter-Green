@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div>
        <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight">Site <span class="text-primary italic">Configurations.</span></h1>
        <p class="text-slate-500 font-medium mt-2 uppercase text-[10px] tracking-[0.3em]">Global System Settings</p>
    </div>

    <div class="grid grid-cols-1 gap-12">
        @foreach($settings as $group => $items)
        <div class="space-y-6">
            <h3 class="text-xl font-heading font-black text-white tracking-tight flex items-center gap-3">
                <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                {{ ucfirst($group) }} Settings
            </h3>
            
            <div class="bg-slate-900/50 rounded-[2.5rem] border border-white/5 divide-y divide-white/5 overflow-hidden">
                @foreach($items as $setting)
                <div class="p-8 sm:p-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6 group hover:bg-white/[0.02] transition-colors">
                    <div class="max-w-md w-full">
                        <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-1">{{ str_replace('_', ' ', $setting->key) }}</p>
                        <div x-data="{ editing: false, value: '{{ $setting->value }}' }" class="w-full">
                            <div x-show="!editing" class="flex items-center justify-between gap-6">
                                <p class="text-white font-bold text-lg" x-text="value"></p>
                                <button @click="editing = true" class="px-6 py-2 bg-white/5 hover:bg-white/10 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all border border-white/5 opacity-0 group-hover:opacity-100">
                                    Edit
                                </button>
                            </div>
                            <form x-show="editing" x-cloak action="{{ route('admin.settings.update', $setting->id) }}" method="POST" class="flex items-center gap-3">
                                @csrf
                                @method('PUT')
                                <input type="text" name="value" x-model="value" 
                                       class="flex-grow bg-white/10 border border-primary/30 rounded-xl px-4 py-2 text-white focus:outline-none font-bold text-lg">
                                <button type="submit" class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center shadow-lg shadow-primary/20">
                                    <i class="ri-check-line text-xl"></i>
                                </button>
                                <button type="button" @click="editing = false" class="w-10 h-10 bg-white/5 text-slate-400 rounded-xl flex items-center justify-center">
                                    <i class="ri-close-line text-xl"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
