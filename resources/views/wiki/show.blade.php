<x-app-layout title="{{ $entity->title }} - Database Teknis WikiPipa">
    
    {{-- 0. Scroll Progress Tracker --}}
    <div x-data="{ 
        percent: 0,
        updateProgress() {
            const h = document.documentElement, 
                  st = 'scrollTop',
                  sh = 'scrollHeight';
            this.percent = (h[st]||document.body[st]) / ((h[sh]||document.body[sh]) - h.clientHeight) * 100;
        }
    }" @scroll.window="updateProgress()" class="fixed top-0 left-0 w-full h-1.5 z-[100] pointer-events-none">
        <div class="h-full bg-primary transition-all duration-150 shadow-[0_0_15px_rgba(var(--color-primary-rgb),0.5)]" :style="`width: ${percent}%`"></div>
    </div>

    <section class="bg-stone-50/50 pt-32 sm:pt-48 pb-40 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Breadcrumb & Back --}}
            <div class="flex items-center justify-between mb-16">
                <a href="{{ route('wiki.index') }}" class="group flex items-center gap-3 text-secondary font-black text-[11px] uppercase tracking-[0.3em] hover:text-primary transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-[0_10px_20px_rgba(0,0,0,0.02),0_0_20px_white] flex items-center justify-center text-primary group-hover:-translate-x-2 transition-transform border border-stone-100">
                        <i class="ri-arrow-left-line text-xl"></i>
                    </div>
                    <span class="ml-2">Kembali Ke Wiki Database</span>
                </a>
            </div>

            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
                
                {{-- Main Content - Contained Style --}}
                <div class="lg:w-2/3">
                    <article class="bg-white rounded-[4rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.04),0_0_60px_white] overflow-hidden border border-white/50">
                        
                        {{-- Integrated Header Image & Title --}}
                        <div class="relative min-h-[400px] flex items-center bg-secondary overflow-hidden group">
                            <!-- Background Patterns -->
                            <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>
                            <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-primary/20 rounded-full blur-[100px] pointer-events-none animate-pulse"></div>
                            
                            <div class="relative z-10 p-8 sm:p-20 w-full">
                                <span class="inline-block px-5 py-2 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-8 shadow-xl shadow-primary/20">
                                    {{ $entity->category }}
                                </span>
                                
                                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-heading font-black text-white leading-[1.1] mb-10 tracking-tighter">
                                    {{ $entity->title }}
                                </h1>

                                <div class="flex flex-wrap items-center gap-6">
                                    @if($entity->wikidata_id)
                                    <a href="https://www.wikidata.org/wiki/{{ $entity->wikidata_id }}" target="_blank" class="flex items-center gap-3 py-2.5 px-6 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all group/wiki">
                                        <i class="ri-database-2-line text-primary"></i>
                                        <div class="text-left">
                                            <p class="text-white font-black text-[9px] uppercase tracking-wider leading-none">Wikidata Verified</p>
                                            <p class="text-white/40 text-[8px] font-bold uppercase tracking-widest mt-1">{{ $entity->wikidata_id }}</p>
                                        </div>
                                    </a>
                                    @endif
                                    
                                    <div class="hidden sm:flex items-center gap-3 py-2.5 px-6 rounded-xl bg-white/5 border border-white/10">
                                        <i class="ri-shield-check-line text-green-400"></i>
                                        <div>
                                            <p class="text-white font-black text-[9px] uppercase tracking-wider leading-none">Technical Data</p>
                                            <p class="text-white/40 text-[8px] font-bold uppercase tracking-widest mt-1">Verified Expert Insight</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Article Body --}}
                        <div class="p-8 sm:p-20 pt-16">
                            <div class="prose prose-xl prose-slate max-w-none prose-headings:font-heading prose-headings:font-black prose-headings:text-secondary prose-headings:tracking-tight prose-p:text-gray-600 prose-p:leading-relaxed prose-strong:text-secondary prose-blockquote:border-l-primary prose-blockquote:bg-stone-50 prose-blockquote:p-10 prose-blockquote:rounded-[2.5rem] prose-blockquote:italic prose-blockquote:font-medium">
                                <p class="text-2xl font-medium text-secondary/80 leading-relaxed italic border-l-4 border-primary pl-8 mb-16">
                                    {{ $entity->description }}
                                </p>

                                @php
                                    $excludedKeys = ['meta_title', 'meta_desc', 'keywords', 'semantic_signals', 'schema', 'internal_link'];
                                    $specs = collect($entity->attributes)->except($excludedKeys);
                                @endphp

                                @if($specs->isNotEmpty())
                                <div class="my-20 p-10 sm:p-16 border border-stone-100 bg-stone-50/50 rounded-[4rem] relative overflow-hidden group/specs">
                                    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                                    
                                    <h3 class="text-2xl font-black text-secondary mb-12 flex items-center gap-4 !mt-0">
                                        <div class="w-12 h-12 rounded-2xl bg-primary flex items-center justify-center text-white shadow-lg shadow-primary/20">
                                            <i class="ri-list-settings-line"></i>
                                        </div>
                                        Spesifikasi Teknis
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                                        @foreach($specs as $key => $value)
                                        <div class="group/item pb-6 border-b border-stone-200/60 hover:border-primary/30 transition-colors">
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-hover/item:text-primary transition-colors">
                                                {{ str_replace('_', ' ', $key) }}
                                            </p>
                                            <p class="text-xl font-bold text-secondary tracking-tight">
                                                {{ is_array($value) ? implode(', ', $value) : $value }}
                                            </p>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                {{-- Automated Internal Linking Block --}}
                                @if(isset($entity->attributes['internal_link']))
                                <div class="my-16 p-8 bg-primary/5 rounded-3xl border border-primary/10 flex flex-col sm:flex-row items-center justify-between gap-6 group/link">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-primary text-white flex items-center justify-center text-xl shadow-lg shadow-primary/20 group-hover/link:rotate-12 transition-transform">
                                            <i class="ri-link"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-primary uppercase tracking-widest">Topical Authority Link</p>
                                            <h4 class="text-secondary font-bold">{{ $entity->attributes['internal_link']['text'] }}</h4>
                                        </div>
                                    </div>
                                    <a href="{{ $entity->attributes['internal_link']['url'] }}" class="px-8 py-3 bg-white text-secondary font-black text-[10px] uppercase tracking-widest rounded-xl border border-stone-200 hover:bg-secondary hover:text-white transition-all">
                                        Explore Equipment
                                    </a>
                                </div>
                                @endif

                                <div class="mt-24 p-12 bg-secondary rounded-[4rem] text-white relative overflow-hidden group/sos">
                                    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-transparent to-transparent opacity-0 group-hover/sos:opacity-100 transition-opacity duration-700"></div>
                                    
                                    <div class="relative z-10 text-center">
                                        <h3 class="text-white !mt-0 text-3xl sm:text-4xl mb-6 italic">Masalah {{ $entity->title }} Tak Kunjung Usai?</h3>
                                        <p class="text-gray-400 mb-10 max-w-xl mx-auto">Percayakan pada ahlinya. Tim RooterIn siap menangani masalah Anda dengan garansi tuntas dan tanpa bongkar.</p>
                                        <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281246668749') }}?text=Halo%20RooterIn%2C%20saya%20ingin%20konsultasi%20terkait%20{{ $entity->title }}" class="inline-flex items-center gap-4 px-12 py-5 bg-primary text-white rounded-full font-black uppercase text-xs tracking-widest shadow-2xl shadow-primary/30 hover:scale-105 active:scale-95 transition-all">
                                            <i class="ri-whatsapp-line text-2xl"></i>
                                            Panggil Teknisi Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                {{-- Sidebar - Premium Sidebar Style --}}
                <div class="lg:w-1/3">
                    <div class="sticky top-32 space-y-10">
                        
                        {{-- SOS Card --}}
                        <div class="bg-white rounded-[3rem] p-10 shadow-[0_30px_80px_rgba(0,0,0,0.03),0_0_50px_white] relative group overflow-hidden border border-stone-100">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/10 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                            <div class="relative z-10">
                                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-8 group-hover:rotate-12 transition-transform">
                                    <i class="ri-customer-service-2-line text-2xl"></i>
                                </div>
                                <h4 class="text-secondary font-black text-2xl mb-4 leading-tight">Bantuan Teknis <br><span class="text-primary italic">Ahli Plumbing</span></h4>
                                <p class="text-gray-400 text-sm mb-8 leading-relaxed">Jangan mengambil risiko pada instalasi pipa Anda. Percayakan pada profesional.</p>
                                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281246668749') }}" class="flex items-center justify-center gap-3 w-full py-5 bg-secondary text-white rounded-[2rem] font-black uppercase text-[10px] tracking-widest hover:bg-primary transition-all shadow-xl shadow-secondary/10">
                                    Fast Response WA
                                </a>
                            </div>
                        </div>

                        {{-- Trending Wiki --}}
                        <div class="bg-white rounded-[3rem] p-10 shadow-[0_30px_80px_rgba(0,0,0,0.03),0_0_50px_white] border border-stone-100">
                            <h4 class="text-secondary font-black text-xs uppercase tracking-[0.3em] mb-8 flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                                Entitas Populer
                            </h4>
                            <div class="space-y-6">
                                @foreach(\App\Models\WikiEntity::where('id', '!=', $entity->id)->inRandomOrder()->take(3)->get() as $trending)
                                    <a href="{{ route('wiki.detail', $trending->slug) }}" class="group block border-b border-gray-50 pb-6 last:border-0 last:pb-0">
                                        <p class="text-[9px] font-black text-primary uppercase tracking-widest mb-1">{{ $trending->category }}</p>
                                        <h5 class="text-secondary font-black text-sm leading-snug group-hover:text-primary transition-colors">{{ $trending->title }}</h5>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Massive Impact CTA --}}
    <section class="py-12 sm:py-20 bg-stone-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative w-full min-h-[500px] lg:min-h-0 lg:aspect-[21/9] xl:aspect-[21/8] rounded-[2.5rem] sm:rounded-[4rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.3)] group/cta">
                <img src="https://images.unsplash.com/photo-1585955123058-930415956a69?q=80&w=2000&auto=format&fit=crop" 
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2000ms] group-hover/cta:scale-110">
                <div class="absolute inset-0 bg-secondary/60 backdrop-blur-[2px]"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-secondary/40 via-secondary/80 to-secondary transition-colors duration-500"></div>
                <div class="absolute inset-0 p-6 sm:p-10 lg:p-16 flex flex-col justify-center items-center text-center">
                    <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-4 mb-6 sm:mb-10">
                        <div class="px-4 sm:px-6 py-2 sm:py-2.5 bg-primary text-white text-[8px] sm:text-[10px] font-black uppercase tracking-[0.3em] rounded-full shadow-xl shadow-primary/30">LATEST TECHNOLOGY</div>
                        <div class="px-4 sm:px-6 py-2 sm:py-2.5 bg-white/10 backdrop-blur-xl border border-white/20 rounded-full">
                            <span class="text-white text-[8px] sm:text-[10px] font-black uppercase tracking-[0.25em]">ZERO DAMAGE PLUMBING</span>
                        </div>
                    </div>
                    <h2 class="text-2xl sm:text-4xl lg:text-5xl xl:text-7xl font-heading font-black text-white leading-[1.1] sm:leading-[1] tracking-tight mb-8 sm:mb-12 max-w-5xl animate-fade-in-up">
                        Kembalikan Aliran <br> 
                        <span class="text-primary italic">Pipa Anda Sekarang.</span>
                    </h2>
                    <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6281246668749') }}" 
                       class="inline-flex items-center gap-4 sm:gap-6 bg-white px-8 sm:px-12 lg:px-16 py-4 sm:py-5 lg:py-7 rounded-full shadow-[0_30px_60px_rgba(0,0,0,0.4)] hover:bg-primary transition-all duration-500 group/btn active:scale-95">
                        <span class="text-primary group-hover/btn:text-white font-black text-xs sm:text-base lg:text-xl uppercase tracking-widest transition-colors flex items-center gap-3 sm:gap-4">
                            Minta Survey Gratis
                            <i class="ri-whatsapp-line text-lg lg:text-2xl transition-transform group-hover/btn:scale-125"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <x-sticky-footer />

    {{-- Inject Entity Schema --}}
    @if(isset($entitySchema))
        {!! $entitySchema !!}
    @endif

</x-app-layout>
