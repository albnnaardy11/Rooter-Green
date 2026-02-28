@extends('admin.layout')

@section('content')
<div class="space-y-12" x-data="{ 
    question: '{{ old('question', '') }}', 
    answer: '{{ old('answer', '') }}',
    placement: '{{ old('placement', 'about') }}'
}">
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.faqs.index') }}" class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all border border-white/5">
            <i class="ri-arrow-left-line text-2xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-heading font-black text-white tracking-tight italic">Intelligence <span class="text-primary not-italic">Infusion.</span></h1>
            <p class="text-slate-500 font-medium uppercase text-[10px] tracking-[0.3em]">Deploying New Logic Entry</p>
        </div>
    </div>

    <form action="{{ route('admin.faqs.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        @csrf
        <!-- Left Column: Input -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-slate-900/50 p-8 sm:p-12 rounded-[3rem] border border-white/5 backdrop-blur-xl space-y-10">
                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-2">Human Question</label>
                    <div class="relative group">
                        <i class="ri-questionnaire-line absolute left-6 top-5 text-slate-600 group-focus-within:text-primary transition-colors text-xl"></i>
                        <input type="text" name="question" x-model="question" required placeholder="What are the users asking?" 
                               class="w-full bg-slate-950 border border-white/5 rounded-[2rem] pl-16 pr-8 py-5 text-white placeholder-slate-700 focus:outline-none focus:border-primary/50 transition-all font-bold text-lg shadow-inner">
                    </div>
                    @error('question') <p class="text-red-500 text-[10px] mt-2 font-bold ml-6 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-2">Intelligence Response</label>
                    <div class="relative group">
                        <i class="ri-message-3-line absolute left-6 top-6 text-slate-600 group-focus-within:text-primary transition-colors text-xl"></i>
                        <textarea name="answer" x-model="answer" required rows="8" placeholder="Enter the detailed logical response..." 
                                  class="w-full bg-slate-950 border border-white/5 rounded-[2.5rem] pl-16 pr-8 py-6 text-white placeholder-slate-700 focus:outline-none focus:border-primary/50 transition-all font-medium text-base shadow-inner leading-relaxed"></textarea>
                    </div>
                    @error('answer') <p class="text-red-500 text-[10px] mt-2 font-bold ml-6 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Intelligence Preview -->
            <div class="bg-slate-900/40 p-10 rounded-[3rem] border border-white/5 border-dashed relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 flex items-center gap-2">
                    <span class="w-2 h-2 bg-primary rounded-full animate-ping"></span>
                    <span class="text-[8px] font-black uppercase tracking-widest text-slate-500">Live Simulation</span>
                </div>
                
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8 border-b border-white/5 pb-4">Output Rendering</h3>
                
                <div class="bg-white/2 border border-white/5 p-8 rounded-3xl transition-all duration-500 group-hover:scale-[1.01]">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-lg font-black text-white" x-text="question || 'Draft Question appears here...'"></h4>
                        <div class="w-8 h-8 rounded-lg bg-primary/20 text-primary flex items-center justify-center">
                            <i class="ri-add-line"></i>
                        </div>
                    </div>
                    <div class="h-px bg-white/5 w-full mb-6"></div>
                    <p class="text-slate-400 leading-relaxed" x-text="answer || 'Draft response logic will render here in real-time.'"></p>
                </div>
            </div>
        </div>

        <!-- Right Column: Settings -->
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-slate-900/50 p-10 rounded-[3rem] border border-white/5 space-y-10 sticky top-12">
                <div class="space-y-6">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                        Category Path
                    </label>
                    <div class="relative group">
                        <select name="faq_category_id" required 
                                class="w-full bg-slate-950 border border-white/5 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-black uppercase text-[10px] tracking-widest appearance-none cursor-pointer">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('faq_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <i class="ri-arrow-down-s-line absolute right-6 top-1/2 -translate-y-1/2 text-primary pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-6">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-accent rounded-full"></span>
                        Placement Zone
                    </label>
                    <div class="relative group">
                        <select name="placement" x-model="placement" required 
                                class="w-full bg-slate-950 border border-white/5 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-accent/50 transition-all font-black uppercase text-[10px] tracking-widest appearance-none cursor-pointer">
                            <option value="about">About Page</option>
                            <option value="landing">Landing Page</option>
                            <option value="both">Synchronized (Both)</option>
                        </select>
                        <i class="ri-compass-3-line absolute right-6 top-1/2 -translate-y-1/2 text-accent pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-6">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Display Priority (Order)</label>
                    <div class="relative group">
                        <i class="ri-list-ordered-2 absolute left-6 top-1/2 -translate-y-1/2 text-slate-600 group-focus-within:text-primary transition-colors"></i>
                        <input type="number" name="order" value="{{ old('order', 0) }}" 
                               class="w-full bg-slate-950 border border-white/5 rounded-2xl pl-14 pr-6 py-4 text-white focus:outline-none focus:border-primary/50 transition-all font-bold">
                    </div>
                </div>

                <div class="space-y-6">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                        Protocol Status
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer group">
                            <input type="radio" name="is_active" value="1" class="hidden" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                            <div class="py-4 rounded-xl border border-white/5 bg-slate-950 text-center group-hover:bg-white/5 transition-all group-[input:checked]:bg-primary/20 group-[input:checked]:border-primary/50 group-[input:checked]:text-primary border-transparent">
                                <span class="text-[9px] font-black uppercase tracking-widest">Active</span>
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" name="is_active" value="0" class="hidden" {{ old('is_active') == '0' ? 'checked' : '' }}>
                            <div class="py-4 rounded-xl border border-white/5 bg-slate-950 text-center group-hover:bg-white/5 transition-all group-[input:checked]:bg-red-500/20 group-[input:checked]:border-red-500/50 group-[input:checked]:text-red-500 border-transparent">
                                <span class="text-[9px] font-black uppercase tracking-widest">Offline</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-10 border-t border-white/5">
                    <button type="submit" class="w-full py-6 bg-primary text-white rounded-[2rem] font-black uppercase text-[10px] tracking-[0.3em] hover:scale-[1.02] active:scale-95 transition-all shadow-2xl shadow-primary/30">
                        Commit Logic
                    </button>
                    <p class="text-center text-[8px] font-black text-slate-600 uppercase tracking-widest mt-6">Secure Transaction Protocol 2.0</p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
