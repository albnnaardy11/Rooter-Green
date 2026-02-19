@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight">Article <span class="text-primary italic">Management.</span></h1>
            <p class="text-slate-500 font-medium mt-2 uppercase text-[10px] tracking-[0.3em]">Tips & Trik Content Hub</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="px-8 py-3 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-all shadow-xl shadow-primary/20">
            <i class="ri-add-line mr-2"></i> New Article
        </a>
    </div>

    <!-- Table -->
    <div class="bg-slate-900/50 rounded-[2rem] border border-white/5 overflow-hidden backdrop-blur-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 border-b border-white/5">
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Article</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Category</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Date</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($posts as $post)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <img src="{{ $post->featured_image }}" class="w-12 h-12 rounded-xl object-cover">
                            <div>
                                <p class="text-sm font-bold text-white">{{ $post->title }}</p>
                                <p class="text-[10px] text-slate-500">{{ $post->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-white/5 rounded-full text-[8px] font-black uppercase tracking-widest text-slate-400 border border-white/5">
                            {{ $post->category }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ $post->status == 'published' ? 'bg-primary shadow-[0_0_10px_#1FAF5A]' : 'bg-yellow-500' }}"></span>
                            <span class="text-[9px] font-black uppercase tracking-widest {{ $post->status == 'published' ? 'text-primary' : 'text-yellow-500' }}">
                                {{ $post->status }}
                            </span>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-[10px] font-bold text-slate-500 uppercase">
                        {{ $post->created_at->format('d M Y') }}
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:bg-white/10 transition-all">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:bg-red-500 hover:text-white transition-all" onclick="return confirm('Delete this article?')">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-8 border-t border-white/5">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
