@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight">Project <span class="text-primary italic">Gallery.</span></h1>
            <p class="text-slate-500 font-medium mt-2 uppercase text-[10px] tracking-[0.3em]">Portfolio Showcase Management</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="px-8 py-3 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-all shadow-xl shadow-primary/20">
            <i class="ri-add-line mr-2"></i> New Project
        </a>
    </div>

    <!-- Table -->
    <div class="bg-slate-900/50 rounded-[2rem] border border-white/5 overflow-hidden backdrop-blur-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 border-b border-white/5">
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Project</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Location</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Featured</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($projects as $project)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center text-primary border border-white/5">
                                <i class="ri-image-line text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">{{ $project->title }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest">{{ $project->category }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-xs text-slate-400">{{ $project->location ?? 'N/A' }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-2">
                            <i class="{{ $project->is_featured ? 'ri-star-fill text-yellow-500' : 'ri-star-line text-slate-700' }} text-lg"></i>
                            <span class="text-[9px] font-black uppercase tracking-widest {{ $project->is_featured ? 'text-white' : 'text-slate-600' }}">
                                {{ $project->is_featured ? 'Featured' : 'Standard' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:bg-white/10 transition-all">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:bg-red-500 hover:text-white transition-all" onclick="return confirm('Delete this project?')">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($projects->isEmpty())
        <div class="py-24 text-center">
            <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <i class="ri-gallery-line text-4xl text-slate-700"></i>
            </div>
            <p class="text-sm text-slate-500 font-black uppercase tracking-widest">No projects found</p>
        </div>
        @endif
        <div class="p-8 border-t border-white/5">
            {{ $projects->links() }}
        </div>
    </div>
</div>
@endsection
