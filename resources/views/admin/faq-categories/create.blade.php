@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.faq-categories.index') }}" class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all border border-white/5">
            <i class="ri-arrow-left-line text-2xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-heading font-black text-white tracking-tight">Create <span class="text-primary italic">Category.</span></h1>
            <p class="text-slate-500 font-medium uppercase text-[10px] tracking-[0.3em]">Add new FAQ group</p>
        </div>
    </div>

    <form action="{{ route('admin.faq-categories.store') }}" method="POST" class="max-w-2xl">
        @csrf
        <div class="bg-slate-900/50 p-8 sm:p-12 rounded-[3rem] border border-white/5 backdrop-blur-xl space-y-8">
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Category Name</label>
                <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g. Teknis & Layanan" 
                       class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-slate-600 focus:outline-none focus:border-primary/50 transition-all font-bold">
                @error('name') <p class="text-red-500 text-[10px] mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Icon (RemixIcon Class)</label>
                <input type="text" name="icon" required value="{{ old('icon', 'ri-question-fill') }}" placeholder="e.g. ri-tools-fill" 
                       class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-slate-600 focus:outline-none focus:border-primary/50 transition-all font-bold">
                <p class="text-[9px] text-slate-500 mt-2">Use names from <a href="https://remixicon.com/" target="_blank" class="text-primary underline">RemixIcon</a></p>
                @error('icon') <p class="text-red-500 text-[10px] mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Order</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" 
                       class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-slate-600 focus:outline-none focus:border-primary/50 transition-all font-bold">
                @error('order') <p class="text-red-500 text-[10px] mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 border-t border-white/5">
                <button type="submit" class="w-full py-5 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-primary/20">
                    Create Category
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
