@extends('admin.layout')

@section('content')
    @if($autoHeals['interlinks'] > 0 || $autoHeals['404_fixes'] > 0)
    <div class="mb-8" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)" x-transition x-cloak>
        <div class="bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/30 text-green-400 px-6 py-4 rounded-[2rem] backdrop-blur-xl flex items-center justify-between shadow-2xl shadow-green-900/10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-green-500 text-slate-900 flex items-center justify-center shadow-lg shadow-green-500/20 scale-90">
                    <i class="ri-magic-line text-2xl animate-pulse"></i>
                </div>
                <div>
                    <h4 class="font-black text-xs uppercase tracking-[0.2em] mb-1">SEO Auto-Heal: System Self-Repaired</h4>
                    <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest">
                        Successfully anchored {{ $autoHeals['interlinks'] }} orphans and re-routed {{ $autoHeals['404_fixes'] }} broken paths into your network.
                    </p>
                </div>
            </div>
            <button @click="show = false" class="text-green-500/50 hover:text-green-500 transition-colors"><i class="ri-close-circle-fill text-2xl"></i></button>
        </div>
    </div>
    @endif
<div class="space-y-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-heading font-black text-white tracking-tight">SEO <span class="text-primary italic">Central.</span></h1>
            <p class="text-slate-500 font-medium uppercase text-[10px] tracking-[0.3em]">Technical Search Engine Optimization Control</p>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.seo.rocket') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-full border border-white/20 hover:scale-105 transition-all shadow-lg shadow-orange-900/20 group">
                    <i class="ri-rocket-2-fill text-xl group-hover:animate-bounce"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest">Instant Indexing Rocket</span>
                </button>
            </form>
            <div class="flex items-center gap-2 px-4 py-2 bg-primary/10 rounded-full border border-primary/20">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-[10px] font-black text-primary uppercase tracking-widest">Masterpiece Mode Active</span>
            </div>
        </div>
    </div>

    <!-- Unicorn Sentinel: War Room Telemetry -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-slate-900 border border-white/5 rounded-3xl p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 border border-orange-500/20">
                <i class="ri-cpu-line text-xl"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest leading-none mb-1">AI Inference Engine</p>
                <p class="text-xs font-black text-white flex items-center gap-2">
                    {{ $healthData['ai_integrity']['performance']['fps'] }}
                    <span class="w-1.5 h-1.5 rounded-full {{ ($healthData['ai_integrity']['performance']['status'] ?? '') === 'Operational' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                </p>
            </div>
        </div>
        <div class="bg-slate-900 border border-white/5 rounded-3xl p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary border border-primary/20">
                <i class="ri-database-2-line text-xl"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest leading-none mb-1">Server RAM Stats</p>
                <p class="text-xs font-black text-white">{{ $healthData['infrastructure']['compute']['usage'] }} <span class="text-[9px] text-slate-500 font-normal">/ {{ $healthData['infrastructure']['compute']['limit'] }}</span></p>
            </div>
        </div>
        <div class="bg-slate-900 border border-white/5 rounded-3xl p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 border border-indigo-500/20">
                <i class="ri-rocket-line text-xl"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest leading-none mb-1">Indexing Rocket Quota</p>
                <p class="text-xs font-black text-white">{{ $healthData['seo_api_audit']['google_indexing']['quota_left'] }} <span class="text-[9px] text-slate-500 font-normal">Today</span></p>
            </div>
        </div>
        <div class="bg-slate-900 border border-white/5 rounded-3xl p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center text-green-500 border border-green-500/20">
                <i class="ri-shield-check-line text-xl"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest leading-none mb-1">Technical Integrity</p>
                <p class="text-xs font-black text-white uppercase italic">100% Operational</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-primary/20 border border-primary/50 p-4 rounded-2xl text-primary text-xs font-bold flex items-center gap-3">
        <i class="ri-checkbox-circle-line text-xl"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-4 gap-12" x-data="{ tab: 'global' }">
        <!-- Sidebar Tabs -->
        <div class="space-y-2 col-span-1">
            <button @click="tab = 'global'" :class="tab === 'global' ? 'bg-primary text-white' : 'bg-white/5 text-slate-400 hover:bg-white/10'" 
                    class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-bold text-left">
                <i class="ri-global-line text-xl"></i>
                <span class="text-sm">Global Settings</span>
            </button>
            <button @click="tab = 'schema'" :class="tab === 'schema' ? 'bg-primary text-white' : 'bg-white/5 text-slate-400 hover:bg-white/10'" 
                    class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-bold text-left">
                <i class="ri-node-tree text-xl"></i>
                <span class="text-sm">Schema Markup</span>
            </button>
            <button @click="tab = 'authority'" :class="tab === 'authority' ? 'bg-primary text-white' : 'bg-white/5 text-slate-400 hover:bg-white/10'" 
                    class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-bold text-left">
                <i class="ri-link-m text-xl"></i>
                <span class="text-sm">Authority Builder</span>
            </button>
            <button @click="tab = 'cities'" :class="tab === 'cities' ? 'bg-primary text-white' : 'bg-white/5 text-slate-400 hover:bg-white/10'" 
                    class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-bold text-left">
                <i class="ri-map-pin-range-line text-xl"></i>
                <span class="text-sm">City Dominator</span>
            </button>
            <button @click="tab = 'trust'" :class="tab === 'trust' ? 'bg-primary text-white' : 'bg-white/5 text-slate-400 hover:bg-white/10'" 
                    class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-bold text-left">
                <i class="ri-shield-user-line text-xl"></i>
                <span class="text-sm">Trust Architect</span>
            </button>
            <button @click="tab = 'tracker'" :class="tab === 'tracker' ? 'bg-primary text-white' : 'bg-white/5 text-slate-400 hover:bg-white/10'" 
                    class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-bold text-left">
                <i class="ri-line-chart-line text-xl"></i>
                <span class="text-sm">Conversion Tracker</span>
            </button>
            <button @click="tab = '404'" :class="tab === '404' ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/20' : 'bg-white/5 text-slate-400 hover:bg-white/10'" 
                    class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-bold text-left mt-4 border border-rose-500/20">
                <i class="ri-error-warning-line text-xl"></i>
                <span class="text-sm">404 Guard</span>
            </button>
            <button @click="tab = 'gsc'" :class="tab === 'gsc' ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/20' : 'bg-white/5 text-slate-400 hover:bg-white/10'" 
                    class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-bold text-left border border-indigo-500/20">
                <i class="ri-google-fill text-xl"></i>
                <span class="text-sm">GSC Sync</span>
            </button>
            <button @click="tab = 'orphan'" :class="tab === 'orphan' ? 'bg-yellow-500 text-white shadow-lg shadow-yellow-500/20' : 'bg-white/5 text-slate-400 hover:bg-white/10'" 
                    class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-bold text-left border border-yellow-500/20">
                <i class="ri-links-line text-xl"></i>
                <span class="text-sm">Orphan Radar</span>
            </button>
            <button @click="tab = 'ghost'" :class="tab === 'ghost' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'bg-white/5 text-slate-400 hover:bg-white/10'" 
                    class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-bold text-left border border-emerald-500/20 mb-4">
                <i class="ri-radar-fill text-xl"></i>
                <span class="text-sm">Ghost-Crawl Monitor</span>
            </button>
            <button @click="tab = 'tools'" :class="tab === 'tools' ? 'bg-primary text-white' : 'bg-white/5 text-slate-400 hover:bg-white/10'" 
                    class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-bold text-left">
                <i class="ri-hammer-line text-xl"></i>
                <span class="text-sm">SEO Tools</span>
            </button>
        </div>

        <!-- Main Panel -->
        <div class="xl:col-span-3">
            <!-- Global Settings Tab -->
            <div x-show="tab === 'global'" class="bg-slate-900/50 p-8 sm:p-12 rounded-[3rem] border border-white/5 backdrop-blur-xl">
                <form action="{{ route('admin.seo.settings.update') }}" method="POST" class="space-y-8">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Site Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Market Urgency Injection (Competitor Sniffer)</label>
                        <input type="text" name="market_urgency" value="{{ $settings['market_urgency'] ?? '' }}" placeholder="Diskon 20% & Garansi 1 Tahun" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white">
                        <p class="mt-2 text-[8px] text-slate-500 uppercase font-bold tracking-widest">This will be automatically appended to meta titles to boost CTR.</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Google Cloud Service Account JSON (Indexing API)</label>
                        <textarea name="google_indexing_key" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white font-mono text-xs h-32" placeholder='{"type": "service_account", ...}'>{{ $settings['google_indexing_key'] ?? '' }}</textarea>
                        <p class="mt-2 text-[8px] text-slate-500 uppercase font-bold tracking-widest italic">Paste your Service Account Key JSON here to activate the Indexing Rocket.</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Global Meta Description</label>
                        <textarea name="meta_description" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white h-32">{{ $settings['meta_description'] ?? '' }}</textarea>
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="px-8 py-4 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-all">Save Global Strategy</button>
                    </div>
                </form>
            </div>

            <!-- Schema Tab -->
            <div x-show="tab === 'schema'" class="bg-slate-900/50 p-8 sm:p-12 rounded-[3rem] border border-white/5 backdrop-blur-xl" x-cloak>
                <form action="{{ route('admin.seo.settings.update') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Opening Hours</label>
                            <input type="text" name="schema_opening_hours" value="{{ $settings['schema_opening_hours'] ?? 'Mo-Fr 09:00-17:00' }}" placeholder="Mo-Su 00:00-23:59" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Price Range</label>
                            <input type="text" name="schema_price_range" value="{{ $settings['schema_price_range'] ?? '$$' }}" placeholder="$$, $$$, etc" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Business Address</label>
                        <input type="text" name="schema_address" value="{{ $settings['schema_address'] ?? '' }}" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white">
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="px-8 py-4 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-all">Update Schema.org</button>
                    </div>
                </form>
            </div>

            <!-- Authority Builder -->
            <div x-show="tab === 'authority'" class="space-y-8" x-cloak>
                <div class="bg-slate-900/50 p-8 rounded-[3rem] border border-white/5 backdrop-blur-xl">
                    <h3 class="text-white font-bold mb-6">Internal Link Automator</h3>
                    <form action="{{ route('admin.seo.keywords.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        @csrf
                        <div class="md:col-span-1">
                            <input type="text" name="keyword" placeholder="Money Keyword" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <input type="text" name="target_url" placeholder="Target URL Path" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm">
                        </div>
                        <button type="submit" class="bg-primary text-white rounded-xl px-6 font-black uppercase text-[10px] tracking-widest py-3 hover:scale-105 transition-all">Add Keyword</button>
                    </form>
                </div>

                <div class="bg-slate-900/50 rounded-[3rem] border border-white/5 backdrop-blur-xl overflow-hidden text-white/80">
                    <table class="w-full text-left">
                        <thead class="border-b border-white/5">
                            <tr>
                                <th class="px-8 py-4 text-[8px] font-black uppercase tracking-widest text-slate-500">Keyword</th>
                                <th class="px-8 py-4 text-[8px] font-black uppercase tracking-widest text-slate-500">Path</th>
                                <th class="px-8 py-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keywords as $k)
                            <tr class="border-b border-white/5">
                                <td class="px-8 py-4 text-sm font-bold text-white">{{ $k->keyword }}</td>
                                <td class="px-8 py-4 text-xs font-mono text-slate-500">{{ $k->target_url }}</td>
                                <td class="px-8 py-4 text-right">
                                    <form action="{{ route('admin.seo.keywords.destroy', $k->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400"><i class="ri-delete-bin-line"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- City Dominator -->
            <div x-show="tab === 'cities'" class="space-y-8" x-cloak>
                <div class="bg-slate-900/50 p-8 rounded-[3rem] border border-white/5 backdrop-blur-xl">
                    <h3 class="text-white font-bold mb-6 italic">Hyper-Local Expansion Engine</h3>
                    <form action="{{ route('admin.seo.cities.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        @csrf
                        <div class="md:col-span-1">
                            <input type="text" name="name" placeholder="City Name" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <input type="text" name="region" placeholder="Region/Province" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm">
                        </div>
                        <button type="submit" class="bg-primary text-white rounded-xl font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-all">Establish Presence</button>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    @foreach($cities as $city)
                    <div class="bg-slate-900/50 p-6 rounded-3xl border border-white/5 backdrop-blur-xl flex items-center gap-6">
                        <div class="w-12 h-12 rounded-2xl bg-primary/20 flex items-center justify-center text-primary font-black">
                            {{ substr($city->name, 0, 1) }}
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-white font-bold">{{ $city->name }}</h4>
                            <p class="text-[10px] text-slate-500 font-mono tracking-widest uppercase">/area/{{ $city->slug }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <form action="{{ route('admin.seo.cities.update', $city->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PUT')
                                <input type="text" name="lsi_keywords" value="{{ $city->lsi_keywords }}" placeholder="LSI Keywords (comma separated)" class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-[10px] text-white w-64">
                                <button type="submit" class="p-2 bg-white/5 text-slate-400 rounded-lg hover:text-white"><i class="ri-save-line text-lg"></i></button>
                            </form>
                            <form action="{{ route('admin.seo.cities.destroy', $city->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-500/10 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition-all"><i class="ri-delete-bin-line"></i></button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Trust Architect (Reviews) -->
            <div x-show="tab === 'trust'" class="space-y-8" x-cloak>
                <div class="bg-slate-900/50 p-8 rounded-[3rem] border border-white/5 backdrop-blur-xl">
                    <h3 class="text-white font-bold mb-6">Aggregate Trust Architect</h3>
                    <form action="{{ route('admin.seo.reviews.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <input type="text" name="customer_name" placeholder="Customer Name" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm">
                            <input type="text" name="location_suburb" placeholder="Suburb (e.g. Menteng)" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm">
                            <select name="seo_city_id" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-slate-400 text-sm">
                                <option value="">Global/General Review</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}">Specific for {{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <textarea name="review_text" placeholder="The trust-building testimony..." required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm h-24"></textarea>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-slate-500 font-black uppercase tracking-widest">Rating:</span>
                                @for($i=1;$i<=5;$i++)
                                <input type="radio" name="rating" value="{{ $i }}" {{ $i==5 ? 'checked' : '' }} class="accent-primary">
                                <span class="text-primary">★</span>
                                @endfor
                            </div>
                            <button type="submit" class="px-8 py-3 bg-secondary text-white rounded-xl font-black uppercase text-[10px] tracking-widest hover:scale-110 transition-all">Publish Testimony</button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($reviews as $review)
                    <div class="bg-slate-900/50 p-6 rounded-3xl border border-white/5 backdrop-blur-xl relative group">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="text-primary text-sm">
                                @for($i=1;$i<=$review->rating;$i++) ★ @endfor
                            </div>
                            @if($review->city)
                            <span class="text-[8px] bg-primary/10 text-primary px-2 py-0.5 rounded font-black uppercase tracking-widest">{{ $review->city->name }} Overlay</span>
                            @endif
                        </div>
                        <p class="text-white font-bold text-sm mb-1">{{ $review->customer_name }}</p>
                        <p class="text-xs text-slate-500 italic mb-4">"{{ $review->review_text }}"</p>
                        <form action="{{ route('admin.seo.reviews.destroy', $review->id) }}" method="POST" class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transition-opacity">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500/50 hover:text-red-500"><i class="ri-delete-bin-line"></i></button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Conversion Tracker -->
            <div x-show="tab === 'tracker'" class="space-y-12" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-slate-900/50 p-8 rounded-[3rem] border border-white/5 backdrop-blur-xl">
                        <h3 class="text-white font-bold mb-6 flex items-center gap-2">
                            <i class="ri-whatsapp-line text-green-500"></i>
                            Top Converting Pages
                        </h3>
                        <div class="space-y-4">
                            @foreach($topPages as $page)
                            <div class="flex items-center justify-between p-4 rounded-xl bg-white/5">
                                <span class="text-xs text-slate-400 truncate max-w-[200px]">{{ $page->page_url }}</span>
                                <span class="text-sm font-black text-primary">{{ $page->total }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-slate-900/50 p-8 rounded-[3rem] border border-white/5 backdrop-blur-xl">
                        <h3 class="text-white font-bold mb-6 italic">Device Traffic</h3>
                        <div class="space-y-4">
                            @foreach($deviceStats as $stat)
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ $stat->device_type }}</span>
                                <div class="flex-grow mx-4 h-1.5 bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary" style="width: 70%"></div>
                                </div>
                                <span class="text-white font-bold text-xs">{{ $stat->total }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- 404 Monitor Guard -->
            <div x-show="tab === '404'" class="space-y-8" x-cloak>
                <div class="bg-slate-900/50 p-8 rounded-[3rem] border border-white/5 backdrop-blur-xl">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-white font-black text-xl flex items-center gap-3">
                                <i class="ri-error-warning-fill text-rose-500"></i>
                                404 Loss Prevention
                            </h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-2">Recover dead traffic into leads.</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-rose-500/10 flex items-center justify-center text-rose-500 border border-rose-500/20">
                            {{ $errorLogs->count() }}
                        </div>
                    </div>
                    
                    <div class="overflow-hidden rounded-3xl border border-white/5 bg-slate-950/50">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-white/5">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Broken Path</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-center text-slate-500">Hits</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Last Seen</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-right text-slate-500">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($errorLogs as $log)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 font-mono text-rose-400 truncate max-w-xs">{{ $log->url }}</td>
                                    <td class="px-6 py-4 font-black text-white text-center">{{ $log->hits }}</td>
                                    <td class="px-6 py-4 text-xs text-slate-500">{{ $log->last_hit->diffForHumans() }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="px-4 py-2 bg-primary/20 text-primary hover:bg-primary hover:text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">
                                            Redirect 301
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500 text-sm font-bold">
                                        <i class="ri-shield-check-line text-3xl mb-2 block text-green-500"></i>
                                        No broken links detected. Shield is fully operational.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- GSC Meta Sync -->
            <div x-show="tab === 'gsc'" class="space-y-8" x-cloak>
                @if(!$gscService->isConfigured())
                <!-- GSC Setup Screen -->
                <div class="bg-indigo-900/10 p-12 rounded-[3rem] border border-indigo-500/20 backdrop-blur-3xl text-center space-y-8">
                    <div class="w-24 h-24 bg-white/5 rounded-[2rem] border border-white/10 flex items-center justify-center mx-auto shadow-2xl shadow-indigo-500/10 animate-pulse">
                        <i class="ri-google-fill text-6xl text-white opacity-20"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-heading font-black text-white tracking-tight italic">Connect <span class="text-indigo-500">Search Console.</span></h2>
                        <p class="text-slate-400 font-medium text-xs mt-4 leading-relaxed max-w-xl mx-auto uppercase tracking-widest leading-loose">
                            To unlock real search performance meta-data, you must provide your <span class="text-indigo-400 font-black underline decoration-indigo-500/30 decoration-2">Google Service Account</span> JSON key.
                            This will sync live clicks, impressions, and ranking positions directly into your Rooter-Green dashboard.
                        </p>
                    </div>
                    
                    <form action="{{ route('admin.seo.settings.update') }}" method="POST" class="max-w-2xl mx-auto bg-slate-950 p-8 rounded-[2rem] border border-white/5 space-y-4">
                        @csrf
                        <div class="space-y-2 text-left">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                <i class="ri-key-2-line text-indigo-500"></i>
                                Service Account JSON Key
                            </label>
                            <textarea name="google_search_console_key" rows="6" class="w-full bg-slate-900 border-none rounded-2xl text-indigo-400 font-mono text-xs p-5 focus:ring-2 focus:ring-indigo-500/50 transition-all placeholder:text-slate-700" placeholder='{ "type": "service_account", ... }'></textarea>
                        </div>
                        <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all shadow-xl shadow-indigo-900/40 flex items-center justify-center gap-3 group">
                            <i class="ri-plug-2-line text-xl group-hover:rotate-12 transition-transform"></i>
                            Activate Real-Time Intelligence
                        </button>
                        <p class="text-[8px] text-slate-600 font-bold uppercase tracking-widest">Secured via Phantom Shield & Google Cloud IAM</p>
                    </form>
                </div>
                @elseif(!$gscData)
                <!-- GSC Loading / Error Screen -->
                <div class="bg-indigo-900/10 p-12 rounded-[3rem] border border-indigo-500/20 backdrop-blur-3xl text-center">
                    <div class="space-y-6">
                        <i class="ri-radar-line text-6xl text-indigo-400 animate-spin flex justify-center"></i>
                        <h3 class="text-xl font-black text-white uppercase tracking-widest italic">Scanning Google Cloud Radar...</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">
                            Configuration detected. If you don't see results, ensure your Service Account has "Viewer" permission on the site <span class="text-indigo-400">{{ config('app.url') }}</span>.
                        </p>
                    </div>
                </div>
                @else
                <!-- GSC Dashboard Screen -->
                <div class="bg-indigo-900/10 p-8 rounded-[3rem] border border-indigo-500/20 backdrop-blur-xl">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-white font-black text-xl flex items-center gap-3">
                                <i class="ri-google-fill text-indigo-500"></i>
                                Real Search Intelligence
                            </h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-2 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                Live Sync ({{ now()->format('H:i') }})
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($gscData as $data)
                        <div class="bg-slate-950/50 border border-white/5 rounded-2xl p-6 hover:border-indigo-500/50 transition-colors group">
                            <h4 class="text-xs font-black text-indigo-400 truncate mb-4" title="{{ $data['query'] }}">{{ $data['query'] }}</h4>
                            <div class="flex items-end justify-between">
                                <div>
                                    <div class="text-2xl font-black text-white leading-none">{{ $data['clicks'] }}</div>
                                    <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-1">Clicks</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-black text-green-400">Pos {{ $data['position'] }}</div>
                                    <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-1">CTR: {{ $data['ctr'] }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Orphan Radar Scanner -->
            <div x-show="tab === 'orphan'" class="space-y-8" x-cloak>
                <div class="bg-yellow-900/10 p-8 rounded-[3rem] border border-yellow-500/20 backdrop-blur-xl">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-white font-black text-xl flex items-center gap-3">
                                <i class="ri-radar-line text-yellow-500"></i>
                                Orphan Node Radar
                            </h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-2">Entities disconnected from the main crawl network.</p>
                        </div>
                        <form action="{{ route('admin.seo.scan-orphans') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-yellow-500/20 hover:bg-yellow-500 text-yellow-500 hover:text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                Run Deep Scan
                            </button>
                        </form>
                    </div>

                    <div class="space-y-4">
                        @forelse($orphanPages as $page)
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-6 rounded-2xl bg-slate-950/50 border border-white/5 gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-yellow-500/10 flex items-center justify-center text-yellow-500">
                                    <i class="ri-page-separator"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold text-sm">{{ $page['title'] }}</h4>
                                    <p class="text-[10px] font-mono text-slate-500 mt-1">{{ $page['url'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="px-3 py-1 bg-white/5 rounded-lg text-[9px] font-black uppercase tracking-widest text-slate-400">{{ $page['type'] }}</span>
                                <a href="{{ $page['url'] }}" target="_blank" class="w-8 h-8 rounded-lg bg-yellow-500 border border-yellow-400 flex items-center justify-center text-slate-900 hover:scale-110 transition-transform">
                                    <i class="ri-arrow-right-up-line"></i>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center text-slate-500">
                            <i class="ri-rocket-2-line text-4xl mb-4 text-green-500 block"></i>
                            <p class="font-bold">Perfect Architecture!</p>
                            <p class="text-xs">All {{ \App\Models\WikiEntity::count() + \App\Models\Service::count() }} entities are perfectly interlinked.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Ghost-Crawl Monitor Panel -->
            <div x-show="tab === 'ghost'" class="space-y-8" x-cloak>
                <div class="bg-slate-900/50 p-8 rounded-[3rem] border border-white/5 backdrop-blur-xl">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-white font-black text-xl flex items-center gap-3">
                                <i class="ri-radar-fill text-emerald-500"></i>
                                Ghost-Crawl Monitor
                            </h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-2">Real-time detection of Googlebot on non-indexed URLs.</p>
                        </div>
                        <div class="flex items-center gap-4 text-right">
                            <div>
                                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest leading-none mb-1">Budget Waste</p>
                                <p class="text-xl font-black text-rose-500 italic">{{ $orphanCrawlCount }} Crawls</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-3xl border border-white/5 bg-slate-950/50">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-white/5">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Crawled URL (Internal/Ghost)</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-center text-slate-500">Status</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Sitemap</th>
                                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-right text-slate-500">Sentinel Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($crawlLogs as $log)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 font-mono text-emerald-400 truncate max-w-sm" title="{{ $log->url }}">{{ $log->url }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 rounded text-[10px] font-black {{ $log->status_code >= 400 ? 'bg-rose-500/10 text-rose-500' : 'bg-emerald-500/10 text-emerald-500' }}">
                                            {{ $log->status_code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 uppercase">
                                        @if($log->is_in_sitemap)
                                            <span class="text-emerald-500 font-black text-[10px] tracking-widest">Valid</span>
                                        @else
                                            <span class="text-rose-500 font-black text-[10px] tracking-widest italic animate-pulse">Ghost-Page</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex flex-col items-end">
                                            <span class="text-[8px] font-black uppercase tracking-widest text-slate-400 mb-1">{{ $log->action_taken ?: 'Monitoring Only' }}</span>
                                            @if($log->metadata && isset($log->metadata['ai_analysis']))
                                              <span class="text-[7px] text-emerald-500 font-medium">Quality Score: {{ $log->metadata['ai_analysis']['quality'] }}%</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500 text-sm font-bold">
                                        <i class="ri-ghost-smile-line text-3xl mb-2 block text-indigo-500"></i>
                                        No Ghost-Crawl detected in the last 24h cycle.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div x-show="tab === 'tools'" class="bg-slate-900/50 p-8 rounded-[3rem] border border-white/5 backdrop-blur-xl grid grid-cols-1 md:grid-cols-2 gap-8" x-cloak>
                <div class="p-8 rounded-3xl bg-white/5 border border-white/5 text-center">
                    <i class="ri-radar-fill text-4xl text-indigo-500 mb-4 inline-block"></i>
                    <h4 class="text-white font-bold mb-4">Sitemap Resubmit</h4>
                    <form action="{{ route('admin.seo.ping') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-all">Trigger Re-crawl</button>
                    </form>
                </div>
                <div class="p-8 rounded-3xl bg-white/5 border border-white/5 text-center">
                    <i class="ri-refresh-line text-4xl text-primary mb-4 inline-block"></i>
                    <h4 class="text-white font-bold mb-4">SEO Cache Flush</h4>
                    <form action="{{ route('admin.seo.clear-cache') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-8 py-3 bg-primary text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-all">Wipe Cache</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
