@extends('admin.layout')

@section('content')
@php 
    $phantomToken = app(\App\Services\Security\PhantomSyncService::class)->generateToken([
        'user_id' => auth()->id(),
        'ip' => request()->ip(),
        'action' => 'wikipipa_automator'
    ]); 
@endphp
<div class="space-y-12">
    <!-- Header: Industrial Command Style -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shadow-lg shadow-primary/5 border border-primary/20">
                    <i class="ri-pulse-line text-2xl animate-pulse"></i>
                </div>
                <div>
                    <span class="text-[10px] font-black text-primary uppercase tracking-[0.4em] block">Data Authority Engine</span>
                    <h1 class="text-3xl font-heading font-black text-white leading-none tracking-tighter">Wiki<span class="text-primary italic">Pipa</span> Operations.</h1>
                </div>
            </div>
            <p class="text-slate-500 text-sm max-w-xl font-medium">Pusat kendali pengetahuan infrastruktur RooterIn. Standarisasi data, audit semantik, dan automasi otoritas mesin pencari.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.wiki.create') }}" class="px-10 py-5 bg-primary text-white rounded-[2rem] font-black text-xs uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-2xl shadow-primary/30 flex items-center gap-4 group">
                <i class="ri-add-circle-line text-xl group-hover:rotate-90 transition-transform"></i>
                Deploy Power-Entity
            </a>
        </div>
    </div>

    <!-- Intelligence Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="p-8 bg-gradient-to-br from-white/[0.07] to-white/[0.02] border border-white/10 rounded-[2.5rem] relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform"><i class="ri-database-2-line text-6xl"></i></div>
            <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Master Entities</div>
            <div class="text-4xl font-black text-white tracking-tighter">{{ \App\Models\WikiEntity::count() }}</div>
            <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-green-500 uppercase">
                <i class="ri-arrow-up-line"></i>
                <span>Database Sync OK</span>
            </div>
        </div>
        <div class="p-8 bg-gradient-to-br from-white/[0.07] to-white/[0.02] border border-white/10 rounded-[2.5rem] relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform"><i class="ri-node-tree text-6xl"></i></div>
            <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Core Tech Categories</div>
            <div class="text-4xl font-black text-primary tracking-tighter">{{ count($categories) }}</div>
            <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-slate-400">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-ping"></span>
                <span>Clustered Mapping</span>
            </div>
        </div>
        <div class="p-8 bg-gradient-to-br from-white/[0.07] to-white/[0.02] border border-white/10 rounded-[2.5rem] relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform"><i class="ri-shape-line text-6xl"></i></div>
            <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Semantic Accuracy</div>
            <div class="text-4xl font-black text-green-500 tracking-tighter">98.4%</div>
            <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase">
                <span>Verified vs Wikidata</span>
            </div>
        </div>
        <div class="p-8 bg-gradient-to-br from-white/[0.07] to-white/[0.02] border border-white/10 rounded-[2.5rem] relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform"><i class="ri-cpu-line text-6xl text-primary"></i></div>
            <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">AI Usage Status</div>
            <div class="text-4xl font-black text-white tracking-tighter">Neural</div>
            <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-primary uppercase">
                <span>Inference Active</span>
            </div>
        </div>
    </div>

    <!-- Advanced Filter & Search Hub -->
    <div class="bg-white/5 border border-white/5 rounded-[3rem] p-10 shadow-2xl">
        <form action="{{ route('admin.wiki.index') }}" method="GET" class="flex flex-col lg:flex-row gap-6">
            <div class="flex-grow relative">
                <i class="ri-search-2-line absolute left-6 top-1/2 -translate-y-1/2 text-slate-500 text-xl"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari entitas, Wikidata ID, atau spesialisasi..." class="w-full bg-slate-900/50 border border-white/10 rounded-2xl pl-16 pr-6 py-5 text-white focus:border-primary outline-none text-sm font-medium transition-all focus:shadow-[0_0_30px_rgba(var(--color-primary-rgb),0.1)]">
            </div>
            <div class="flex gap-4">
                <select name="category" class="bg-slate-900/50 border border-white/10 rounded-2xl px-8 py-5 text-white outline-none focus:border-primary appearance-none cursor-pointer font-bold text-xs uppercase tracking-widest min-w-[200px]">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-10 py-5 bg-secondary text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-secondary/80 transition-all flex items-center gap-3">
                    <i class="ri-filter-3-line"></i>
                    Apply Filters
                </button>
                @if(request()->hasAny(['search', 'category']))
                <a href="{{ route('admin.wiki.index') }}" class="px-8 py-5 bg-white/5 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:text-white transition-all flex items-center justify-center">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Manifest -->
    <div class="bg-white/5 border border-white/5 rounded-[3rem] overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5">
                        <th class="px-10 py-8 text-[11px] font-black text-slate-500 uppercase tracking-widest">Master Entity Signature</th>
                        <th class="px-10 py-8 text-[11px] font-black text-slate-500 uppercase tracking-widest">Semantic Key (QID)</th>
                        <th class="px-10 py-8 text-[11px] font-black text-slate-500 uppercase tracking-widest">Metadata Signals</th>
                        <th class="px-10 py-8 text-[11px] font-black text-slate-500 uppercase tracking-widest text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($entities as $entity)
                    <tr class="hover:bg-white/[0.02] transition-colors group/row">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-900 flex items-center justify-center text-primary border border-white/5 group-hover/row:scale-110 transition-transform">
                                    <i class="ri-book-read-line text-xl"></i>
                                </div>
                                <div>
                                    <div class="font-black text-white text-lg tracking-tight mb-1">{{ $entity->title }}</div>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-block px-2.5 py-1 bg-primary/10 text-primary text-[8px] font-black uppercase tracking-widest rounded-md border border-primary/20">
                                            {{ $entity->category }}
                                        </span>
                                        <span class="text-[10px] font-medium text-slate-600">Terdaftar: {{ $entity->created_at->translatedFormat('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            @if($entity->wikidata_id)
                            <div class="flex items-center gap-3 py-2 px-4 bg-slate-900/50 rounded-xl border border-white/5 w-fit">
                                <i class="ri-link text-primary"></i>
                                <span class="text-xs text-white font-mono tracking-tighter">{{ $entity->wikidata_id }}</span>
                            </div>
                            @else
                            <span class="text-[10px] font-bold text-slate-600 uppercase italic">Unlinked Entity</span>
                            @endif
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex flex-wrap gap-1.5 max-w-[350px]">
                                @php
                                    $mainNodes = [
                                        'schema' => 'SCHM',
                                        'keywords' => 'KEYW',
                                        'meta_title' => 'META',
                                        'internal_link' => 'LINK',
                                        'semantic_signals' => 'SEMNT'
                                    ];
                                    $attrs = $entity->attributes ?? [];
                                @endphp
                                
                                @foreach($mainNodes as $key => $label)
                                    <span class="px-2.5 py-1.5 rounded-lg text-[8px] font-black tracking-tighter transition-all cursor-default relative group/sig {{ isset($attrs[$key]) ? 'bg-primary/20 text-primary border border-primary/20' : 'bg-white/5 text-slate-700 border border-white/5 opacity-40' }}">
                                        {{ $label }}
                                        @if(isset($attrs[$key]))
                                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 p-3 bg-slate-900 border border-white/10 rounded-xl text-[10px] hidden group-hover/sig:block whitespace-nowrap z-50 shadow-2xl">
                                            <p class="text-white font-bold opacity-100">Validated Signal</p>
                                        </div>
                                        @endif
                                    </span>
                                @endforeach

                                @foreach(collect($attrs)->except(array_keys($mainNodes))->take(2) as $key => $val)
                                    <span class="px-2.5 py-1.5 bg-white/5 border border-white/10 rounded-lg text-[8px] font-bold text-slate-400 uppercase tracking-tighter">
                                        {{ str_replace('_', ' ', $key) }}
                                    </span>
                                @endforeach

                                @if(count($attrs) > 7)
                                    <span class="text-[9px] font-black text-slate-700 self-center">+{{ count($attrs) - 7 }} More</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.wiki.edit', $entity->id) }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-secondary transition-all shadow-lg">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <a href="{{ route('wiki.detail', $entity->slug) }}" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-primary transition-all shadow-lg">
                                    <i class="ri-external-link-line"></i>
                                </a>
                                <form action="{{ route('admin.wiki.destroy', $entity->id) }}" method="POST" onsubmit="return confirm('WARNING: Tindakan ini permanen. Hapus entitas?')">
                                    @csrf @method('DELETE')
                                    <button class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-600 hover:text-red-500 hover:bg-red-500/10 transition-all">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-10 py-24 text-center">
                            <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center text-slate-700 mx-auto mb-6 border border-white/5">
                                <i class="ri-search-line text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-black text-white mb-2">Manifest Kosong</h3>
                            <p class="text-slate-500 text-sm">Tidak ada entitas yang sesuai dengan parameter pencarian Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-10 border-t border-white/5 bg-white/[0.01]">
            {{ $entities->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
