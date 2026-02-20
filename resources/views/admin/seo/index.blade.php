@extends('admin.layout')

@section('content')
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

            <!-- Tools Tab -->
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
