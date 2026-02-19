@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <!-- Header -->
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.posts.index') }}" class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all border border-white/5">
            <i class="ri-arrow-left-line text-2xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-heading font-black text-white tracking-tight">Edit <span class="text-primary italic">Article.</span></h1>
            <p class="text-slate-500 font-medium uppercase text-[10px] tracking-[0.3em]">Update your content</p>
        </div>
    </div>

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        @csrf
        @method('PUT')
        <!-- Left: Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-slate-900/50 p-8 sm:p-12 rounded-[3rem] border border-white/5 backdrop-blur-xl space-y-8">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Article Title</label>
                    <input type="text" name="title" required value="{{ old('title', $post->title) }}" placeholder="Enter article title..." 
                           class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-slate-600 focus:outline-none focus:border-primary/50 transition-all font-bold">
                    @error('title') <p class="text-red-500 text-[10px] mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Content</label>
                    <x-admin.rich-editor name="content" :value="old('content', $post->content)" />
                    @error('content') <p class="text-red-500 text-[10px] mt-2 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            <x-admin.seo-fields :model="$post" />
        </div>

        <!-- Right: Sidebar Settings -->
        <div class="space-y-8">
            <div class="bg-slate-900/50 p-10 rounded-[3rem] border border-white/5 space-y-10">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-1 h-1 bg-primary rounded-full"></span>
                        Category
                    </label>
                    <select name="category" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-bold appearance-none">
                        <option value="Tips & Trik" {{ old('category', $post->category) == 'Tips & Trik' ? 'selected' : '' }}>Tips & Trik</option>
                        <option value="Tutorial" {{ old('category', $post->category) == 'Tutorial' ? 'selected' : '' }}>Tutorial</option>
                        <option value="Pipa Mampet" {{ old('category', $post->category) == 'Pipa Mampet' ? 'selected' : '' }}>Pipa Mampet</option>
                        <option value="Sanitary" {{ old('category', $post->category) == 'Sanitary' ? 'selected' : '' }}>Sanitary</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-1 h-1 bg-primary rounded-full"></span>
                        Status
                    </label>
                    <div class="flex gap-4">
                        <label class="flex-1 cursor-pointer group">
                            <input type="radio" name="status" value="published" class="hidden" {{ old('status', $post->status) == 'published' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border border-white/5 bg-white/5 text-center group-hover:bg-white/10 transition-all group-[input:checked]:bg-primary/20 group-[input:checked]:border-primary/50 group-[input:checked]:text-primary">
                                <span class="text-[10px] font-black uppercase tracking-widest">Published</span>
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer group">
                            <input type="radio" name="status" value="draft" class="hidden" {{ old('status', $post->status) == 'draft' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border border-white/5 bg-white/5 text-center group-hover:bg-white/10 transition-all group-[input:checked]:bg-yellow-500/20 group-[input:checked]:border-yellow-500/50 group-[input:checked]:text-yellow-500">
                                <span class="text-[10px] font-black uppercase tracking-widest">Draft</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-1 h-1 bg-primary rounded-full"></span>
                        Featured Image
                    </label>
                    @if($post->featured_image)
                    <div class="mb-6 rounded-2xl overflow-hidden border border-white/10">
                        <img src="{{ $post->featured_image }}" class="w-full h-40 object-cover">
                    </div>
                    @endif
                    <div class="relative group">
                        <input type="file" name="featured_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="p-8 border-2 border-dashed border-white/10 rounded-2xl text-center group-hover:border-primary/50 transition-all">
                            <i class="ri-image-edit-line text-3xl text-slate-600 group-hover:text-primary mb-2"></i>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Change Cover</p>
                        </div>
                    </div>
                    @error('featured_image') <p class="text-red-500 text-[10px] mt-2 font-bold">{{ $message }}</p> @enderror
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
