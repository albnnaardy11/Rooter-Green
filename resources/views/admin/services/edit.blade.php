@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.services.index') }}" class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all border border-white/5">
            <i class="ri-arrow-left-line text-2xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-heading font-black text-white tracking-tight">Edit <span class="text-primary italic">Service.</span></h1>
            <p class="text-slate-500 font-medium uppercase text-[10px] tracking-[0.3em]">Update offering details</p>
        </div>
    </div>

    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        @csrf
        @method('PUT')
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-slate-900/50 p-8 sm:p-12 rounded-[3rem] border border-white/5 backdrop-blur-xl space-y-8">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Service Name</label>
                    <input type="text" name="name" required value="{{ old('name', $service->name) }}" 
                           class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-bold">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Short Description</label>
                    <textarea name="description_short" rows="3" required 
                              class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-medium">{{ old('description_short', $service->description_short) }}</textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Full Description</label>
                    <textarea name="description_full" rows="6" required 
                              class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-medium leading-relaxed">{{ old('description_full', $service->description_full) }}</textarea>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-slate-900/50 p-10 rounded-[3rem] border border-white/5 space-y-10">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-1 h-1 bg-primary rounded-full"></span>
                        Remix Icon Class
                    </label>
                    <input type="text" name="icon" required value="{{ old('icon', $service->icon) }}"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-bold">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-1 h-1 bg-primary rounded-full"></span>
                        Base Price (IDR)
                    </label>
                    <input type="number" name="price" value="{{ old('price', $service->price) }}" 
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-bold">
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
