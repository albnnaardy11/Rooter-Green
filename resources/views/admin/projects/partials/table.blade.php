<div class="bg-slate-900/40 rounded-[2.5rem] border border-white/5 overflow-hidden backdrop-blur-xl">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-white/5 border-b border-white/5">
                <th class="px-10 py-6 text-[11px] font-black uppercase text-slate-500 tracking-[0.2em]">Asset Information</th>
                <th class="px-10 py-6 text-[11px] font-black uppercase text-slate-500 tracking-[0.2em]">Operational Zone</th>
                <th class="px-10 py-6 text-[11px] font-black uppercase text-slate-500 tracking-[0.2em]">Priority Status</th>
                <th class="px-10 py-6 text-[11px] font-black uppercase text-slate-500 tracking-[0.2em] text-right">Execution</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($projects as $project)
            <tr class="hover:bg-white/[0.03] transition-all group duration-500">
                <td class="px-10 py-8">
                    <div class="flex items-center gap-6">
                        <div class="relative w-16 h-16 shrink-0 group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-primary/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <img src="{{ asset($project->images[0] ?? 'images/placeholder.jpg') }}" 
                                 class="w-full h-full rounded-2xl object-cover border border-white/10 relative z-10" 
                                 alt="">
                        </div>
                        <div>
                            <p class="text-sm font-black text-white group-hover:text-primary transition-colors">{{ $project->title }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest bg-white/5 text-slate-500 border border-white/5 italic">ID-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-[9px] text-slate-600 font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-10 py-8">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-500">
                            <i class="ri-map-pin-2-fill"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $project->location ?? 'Global / Remote' }}</p>
                    </div>
                </td>
                <td class="px-10 py-8">
                    @if($project->is_featured)
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-yellow-500/10 border border-yellow-500/20">
                        <i class="ri-star-fill text-yellow-500 text-xs"></i>
                        <span class="text-[9px] font-black uppercase tracking-widest text-yellow-500">Platinum Tier</span>
                    </div>
                    @else
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/5">
                        <i class="ri-star-line text-slate-700 text-xs"></i>
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-600">Standard Tier</span>
                    </div>
                    @endif
                </td>
                <td class="px-10 py-8 text-right">
                    <div class="flex items-center justify-end gap-3 opacity-40 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white hover:scale-110 transition-all duration-300 shadow-lg">
                            <i class="ri-edit-2-fill text-lg"></i>
                        </a>
                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:bg-red-500 hover:text-white hover:scale-110 transition-all duration-300 shadow-lg" onclick="return confirm('Initiate archival sequence for this asset?')">
                                <i class="ri-delete-bin-7-fill text-lg"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-32 text-center">
                    <div class="w-24 h-24 bg-white/5 rounded-[2rem] flex items-center justify-center mx-auto mb-8 animate-pulse">
                        <i class="ri-database-2-line text-5xl text-slate-700"></i>
                    </div>
                    <p class="text-sm text-slate-500 font-black uppercase tracking-[0.4em]">Zero Assets Detected in {{ $type }}</p>
                    <a href="{{ route('admin.projects.create') }}" class="inline-block mt-8 text-[10px] font-black text-primary uppercase tracking-widest hover:underline">Add First Project →</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-10 border-t border-white/5 bg-white/[0.01]">
        {{ $projects->appends(['active_tab' => strtolower($type)])->links() }}
    </div>
</div>
