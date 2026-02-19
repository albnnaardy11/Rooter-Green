@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.projects.index') }}" class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all border border-white/5">
            <i class="ri-arrow-left-line text-2xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-heading font-black text-white tracking-tight">Edit <span class="text-primary italic">Project.</span></h1>
            <p class="text-slate-500 font-medium uppercase text-[10px] tracking-[0.3em]">Update showcase item</p>
        </div>
    </div>

    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        @csrf
        @method('PUT')
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-slate-900/50 p-8 sm:p-12 rounded-[3rem] border border-white/5 backdrop-blur-xl space-y-8">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Project Title</label>
                    <input type="text" name="title" required value="{{ old('title', $project->title) }}" 
                           class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-bold">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Location</label>
                    <input type="text" name="location" value="{{ old('location', $project->location) }}" 
                           class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-bold">
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-slate-900/50 p-10 rounded-[3rem] border border-white/5 space-y-10">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-1 h-1 bg-primary rounded-full"></span>
                        Category
                    </label>
                    <select name="category" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-bold appearance-none">
                        <option value="Residential" {{ $project->category == 'Residential' ? 'selected' : '' }}>Residential</option>
                        <option value="Commercial" {{ $project->category == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                        <option value="Specialized" {{ $project->category == 'Specialized' ? 'selected' : '' }}>Specialized</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-1 h-1 bg-primary rounded-full"></span>
                        Project Image
                    </label>
                    @if($project->image_url)
                    <div class="mb-6 rounded-2xl overflow-hidden border border-white/10">
                        <img src="{{ $project->image_url }}" class="w-full h-40 object-cover">
                    </div>
                    @endif
                    <div class="relative group">
                        <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="p-8 border-2 border-dashed border-white/10 rounded-2xl text-center group-hover:border-primary/50 transition-all">
                            <i class="ri-image-edit-line text-3xl text-slate-600 group-hover:text-primary mb-2"></i>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Change Photo</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/5">
                    <button type="submit" class="w-full py-5 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-primary/20">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
