@props(['model' => null])

<div class="bg-slate-900/50 p-8 sm:p-12 rounded-[3rem] border border-white/5 backdrop-blur-xl mt-12">
    <div class="flex items-center gap-4 mb-10">
        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary border border-primary/20">
            <i class="ri-search-eye-line text-xl"></i>
        </div>
        <div>
            <h3 class="text-xl font-heading font-black text-white tracking-tight">SEO <span class="text-primary italic">Engine.</span></h3>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Search Engine Optimization</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-6">
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">SEO Title</label>
                <input type="text" name="seo[title]" value="{{ old('seo.title', $model?->seo?->title) }}" placeholder="Meta title for Google..." 
                       class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-slate-600 focus:outline-none focus:border-primary/50 transition-all font-bold">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">SEO Keywords</label>
                <input type="text" name="seo[keywords]" value="{{ old('seo.keywords', $model?->seo?->keywords) }}" placeholder="keyword1, keyword2..." 
                       class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-slate-600 focus:outline-none focus:border-primary/50 transition-all font-bold">
            </div>
        </div>
        <div class="space-y-6">
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">SEO Description</label>
                <textarea name="seo[description]" rows="5" placeholder="Meta description..." 
                          class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder-slate-600 focus:outline-none focus:border-primary/50 transition-all font-medium leading-relaxed">{{ old('seo.description', $model?->seo?->description) }}</textarea>
            </div>
        </div>
    </div>
</div>
