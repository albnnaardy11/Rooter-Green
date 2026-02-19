@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-8">
        <div>
            <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight">Media <span class="text-primary italic">Library.</span></h1>
            <p class="text-slate-500 font-medium mt-2 uppercase text-[10px] tracking-[0.3em]">Manage all your assets</p>
        </div>
        
        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="flex gap-4">
            @csrf
            <input type="file" name="file" required class="hidden" id="fileInput" onchange="this.form.submit()">
            <button type="button" onclick="document.getElementById('fileInput').click()" class="px-8 py-4 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 active:scale-95 transition-all shadow-xl shadow-primary/20 flex items-center gap-3">
                <i class="ri-upload-cloud-2-line text-lg"></i>
                Upload New File
            </button>
        </form>
    </div>

    @if($files->isEmpty())
    <div class="py-32 text-center bg-slate-900/50 rounded-[3rem] border-2 border-dashed border-white/5">
        <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-600">
            <i class="ri-image-line text-4xl"></i>
        </div>
        <h3 class="text-white font-bold text-lg mb-2">No media found</h3>
        <p class="text-slate-500 text-sm">Upload your first image to get started.</p>
    </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @foreach($files as $file)
        <div class="group relative bg-slate-900/50 rounded-3xl border border-white/5 overflow-hidden aspect-square hover:border-primary/50 transition-all">
            <img src="{{ Storage::disk($file->disk)->url($file->path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent opacity-0 group-hover:opacity-100 transition-all flex flex-col justify-end p-4">
                <p class="text-[10px] font-bold text-white truncate mb-2">{{ $file->original_name }}</p>
                <div class="flex items-center gap-2">
                    <form action="{{ route('admin.media.destroy', $file->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 bg-red-500/20 text-red-500 rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-12">
        {{ $files->links() }}
    </div>
    @endif
</div>
@endsection
