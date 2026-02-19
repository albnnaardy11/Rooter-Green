@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.projects.index') }}" class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all border border-white/5">
            <i class="ri-arrow-left-line text-2xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-heading font-black text-white tracking-tight">Add <span class="text-primary italic">Project.</span></h1>
            <p class="text-slate-500 font-medium uppercase text-[10px] tracking-[0.3em]">Showcase your work</p>
        </div>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        @csrf
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-slate-900/50 p-8 sm:p-12 rounded-[3rem] border border-white/5 backdrop-blur-xl space-y-8">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Project Title</label>
                    <input type="text" name="title" required value="{{ old('title') }}" placeholder="e.g. Pelancaran Wastafel Apartemen" 
                           class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-bold">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Location</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Denpasar, Bali" 
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
                        <option value="Residential">Residential</option>
                        <option value="Commercial">Commercial</option>
                        <option value="Specialized">Specialized</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-1 h-1 bg-primary rounded-full"></span>
                        Project Image
                    </label>
                    <div class="relative group">
                        <input type="file" name="image" required accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="p-8 border-2 border-dashed border-white/10 rounded-2xl text-center group-hover:border-primary/50 transition-all">
                            <i class="ri-image-add-line text-3xl text-slate-600 group-hover:text-primary mb-2"></i>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Upload Photo</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/5">
                    <button type="submit" class="w-full py-5 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-primary/20">
                        Add to Gallery
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
