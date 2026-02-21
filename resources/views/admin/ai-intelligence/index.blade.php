@extends('admin.layout')

@section('content')
<div class="space-y-6 pb-12">
    <!-- 1. HEADER HUD (Refined Spacing) -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-white/5 pb-6">
        <div>
            <div class="flex items-center gap-3">
                <span class="w-2 h-2 bg-primary rounded-full animate-ping"></span>
                <h1 class="text-3xl font-heading font-black text-white tracking-tighter italic uppercase">
                    Neural <span class="text-primary">Command</span> Center.
                </h1>
            </div>
            <p class="text-slate-500 text-[9px] font-black uppercase tracking-[0.4em] mt-1">Global Logistics Optimization — v2.2-stable</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Compact Health Index -->
            <div class="pl-4 pr-6 py-2 bg-slate-900 border border-white/5 rounded-full flex items-center gap-4 shadow-xl">
                 <div class="relative w-8 h-8">
                    <svg class="w-full h-full transform -rotate-90">
                        <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="2" fill="transparent" class="text-slate-800" />
                        <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="2" fill="transparent" class="text-primary" 
                            stroke-dasharray="{{ $conversion['health_score'] * 0.88 }}, 88" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center text-[8px] font-black text-white italic">
                        {{ $conversion['health_score'] }}
                    </div>
                </div>
                <div>
                    <p class="text-slate-500 text-[7px] font-black uppercase tracking-widest leading-none">Global Health</p>
                    <p class="text-white text-[10px] font-bold uppercase italic mt-0.5">@if($conversion['health_score'] > 80) Stable @else Risk @endif</p>
                </div>
            </div>

            <a href="{{ route('admin.ai.intelligence.export', ['type' => 'csv']) }}" class="px-5 py-3 bg-white text-slate-950 rounded-full font-black uppercase text-[10px] tracking-widest hover:bg-primary transition-all flex items-center gap-2 shadow-lg">
                <i class="ri-download-2-line"></i>
                Export
            </a>
        </div>
    </div>

    <!-- 2. HERO GRID: MAP & RECENT ACTIVITY (Balanced) -->
    <div class="grid grid-cols-12 gap-6 h-[550px]">
        <!-- Map (8 Columns) -->
        <div class="col-span-12 lg:col-span-8 bg-slate-900 rounded-[2rem] border border-white/5 p-2 relative shadow-2xl overflow-hidden group">
            <div class="absolute top-6 left-8 z-[1000] flex flex-col gap-1">
                <span class="px-3 py-1.5 bg-slate-950/90 backdrop-blur-md text-primary text-[7px] font-black uppercase tracking-[0.3em] rounded-lg border border-primary/20 flex items-center gap-2">
                    <span class="w-1 h-1 bg-primary rounded-full animate-pulse"></span>
                    Live Neural Map
                </span>
            </div>
            <div id="battleMap" class="w-full h-full rounded-[1.8rem] z-10"></div>
        </div>

        <!-- Recent Logs Sidebar (4 Columns) -->
        <div class="col-span-12 lg:col-span-4 bg-slate-900 rounded-[2rem] border border-white/5 p-8 flex flex-col shadow-2xl overflow-hidden relative">
            <!-- Decorative Scanline -->
            <div class="absolute inset-0 pointer-events-none opacity-10 bg-[radial-gradient(circle_at_50%_0%,rgba(74,222,128,0.1),transparent)]"></div>
            
            <h3 class="text-white font-heading font-black text-md italic mb-6 flex items-center justify-between border-b border-white/10 pb-4 relative z-10">
                Neural Activity.
                <span class="text-[7px] font-black text-slate-500 uppercase flex items-center gap-2">
                    <span class="w-1 h-1 bg-green-500 rounded-full animate-pulse"></span>
                    Operational
                </span>
            </h3>

            <!-- Neural System Status Widget (To Fill Space) -->
            <div class="mb-6 p-4 bg-slate-950 rounded-2xl border border-white/5 flex items-center gap-4 relative z-10 overflow-hidden">
                <div class="flex gap-0.5 items-end h-6 shrink-0">
                    <div class="w-1 bg-primary/20 h-2 animate-[pulse_1.2s_infinite]"></div>
                    <div class="w-1 bg-primary/40 h-4 animate-[pulse_1s_infinite]"></div>
                    <div class="w-1 bg-primary/60 h-6 animate-[pulse_0.8s_infinite]"></div>
                    <div class="w-1 bg-primary/40 h-3 animate-[pulse_1.1s_infinite]"></div>
                    <div class="w-1 bg-primary/20 h-5 animate-[pulse_0.9s_infinite]"></div>
                </div>
                <div class="min-w-0">
                    <p class="text-[7px] font-black text-slate-500 uppercase tracking-widest leading-none">Neural Stability Ratio</p>
                    <p class="text-[11px] font-black text-white italic mt-1 uppercase">{{ $conversion['conversion_rate'] }}% Conversion Index</p>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto space-y-4 pr-2 custom-scrollbar relative z-10">
                @forelse($recent as $item)
                <div class="p-4 bg-white/5 rounded-2xl border border-white/5 hover:border-primary/20 transition-all cursor-default group relative overflow-hidden">
                    <!-- Background Decoration -->
                    <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="ri-radar-line text-2xl text-white"></i>
                    </div>

                    <div class="flex gap-4 items-start mb-3">
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-slate-950 flex flex-col items-center justify-center border border-white/10 shadow-inner group-hover:border-primary/40 transition-all">
                            <span class="text-[12px] font-black text-white italic group-hover:text-primary">{{ $item->final_deep_score }}</span>
                            <span class="text-[6px] text-slate-500 font-bold uppercase tracking-tighter">Severity</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[7px] font-black text-primary/50 uppercase tracking-widest">ID: #{{ substr($item->diagnose_id, -8) }}</span>
                                <span class="text-[6px] text-slate-500 font-bold italic">{{ $item->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-white text-[10px] font-black truncate uppercase tracking-tight mt-0.5">{{ $item->result_label ?: 'Evaluating Anomalies...' }}</p>
                        </div>
                    </div>

                    <!-- Visual Density: Progress Bar + Badges -->
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-[7px] text-slate-500 font-black uppercase tracking-tighter">Neural Precision</span>
                                <span class="text-[8px] text-primary font-black italic">{{ $item->confidence_score ?? 0 }}%</span>
                            </div>
                            <div class="h-1 w-full bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full transition-all duration-1000" style="width:{{ $item->confidence_score ?? 0 }}%"></div>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="px-2 py-0.5 bg-slate-950 text-slate-400 text-[7px] font-black rounded uppercase border border-white/5">{{ ($item->material_type ?? 'unknown') == 'unknown' ? 'STD' : strtoupper($item->material_type) }}</span>
                            <span class="px-2 py-0.5 bg-white/5 text-slate-500 text-[7px] font-black rounded uppercase border border-white/5">{{ $item->city_location ?: 'Detecting...' }}</span>
                            @if(isset($item->metadata['ai_engine']))
                                <span class="px-2 py-0.5 bg-primary/10 text-primary text-[7px] font-black rounded uppercase border border-primary/20"><i class="ri-brain-line mr-1"></i> {{ $item->metadata['ai_engine'] }}</span>
                            @endif
                            @if(isset($item->metadata['degradation_percentage']))
                                <span class="px-2 py-0.5 bg-orange-500/10 text-orange-400 text-[7px] font-black rounded uppercase border border-orange-500/20">Degradation: {{ $item->metadata['degradation_percentage'] }}%</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="h-full flex flex-col items-center justify-center opacity-30">
                    <i class="ri-pulse-line text-4xl mb-2"></i>
                    <p class="text-[10px] uppercase font-black tracking-widest text-center">Neural buffers empty.<br>Awaiting input...</p>
                </div>
                @endforelse
            </div>
            
            <!-- Quick Link Buttons (To Fill Bottom Space) -->
            <div class="mt-6 pt-6 border-t border-white/10 grid grid-cols-2 gap-3 relative z-10">
                <div class="p-3 bg-white text-slate-950 rounded-xl text-center flex flex-col items-center justify-center shadow-lg hover:bg-primary transition-all cursor-pointer">
                    <p class="text-[14px] font-heading font-black italic italic">{{ $conversion['total_clicks'] }}</p>
                    <p class="text-[6px] font-black uppercase tracking-widest opacity-60">Leads Generated</p>
                </div>
                <div class="p-3 bg-slate-950 text-white rounded-xl text-center border border-white/10 flex flex-col items-center justify-center hover:border-primary/40 transition-all cursor-pointer">
                    <p class="text-[14px] font-heading font-black italic text-primary italic">{{ $conversion['conversion_rate'] }}%</p>
                    <p class="text-[6px] font-black uppercase tracking-widest text-slate-500 leading-none">Sync Accuracy</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. SECONDARY GRID: TIMELINE & REGIONAL (Balanced) -->
    <div class="grid grid-cols-12 gap-6">
        <!-- Timeline (8 Columns) -->
        <div class="col-span-12 lg:col-span-8 bg-slate-900 rounded-[2rem] border border-white/5 p-8 shadow-2xl relative overflow-hidden">
             <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-white font-heading font-black text-xl italic uppercase">Temporal Trends.</h3>
                    <p class="text-slate-500 text-[8px] font-black uppercase tracking-[0.3em] mt-1">Anomaly Detection Waves — 30D</p>
                </div>
                <div class="text-right">
                    <p class="text-primary text-lg font-heading font-black italic">{{ $trends['increase_percent'] }}%</p>
                    <p class="text-slate-500 text-[7px] font-black uppercase tracking-widest mt-0.5">Growth Velocity</p>
                </div>
            </div>
            <div class="h-48">
                <canvas id="timelineChart"></canvas>
            </div>
        </div>

        <!-- Regional Leaders (4 Columns) -->
        <div class="col-span-12 lg:col-span-4 bg-slate-900 rounded-[2rem] border border-white/5 p-8 shadow-2xl flex flex-col">
            <h3 class="text-white font-heading font-black text-xl italic uppercase mb-6 flex items-center gap-3">
                <span class="w-1 h-5 bg-secondary rounded-full"></span>
                Area Priority.
            </h3>
            <div class="space-y-3 flex-1">
                @foreach($regions as $region)
                <div class="flex items-center justify-between bg-white/5 px-5 py-3 rounded-2xl border border-white/5 group hover:bg-white/10 transition-all">
                    <div class="min-w-0">
                        <p class="text-white text-[10px] font-black uppercase tracking-tight truncate">{{ $region->city_location ?: 'GENERAL' }}</p>
                        <p class="text-[8px] font-bold text-slate-500 italic mt-0.5">{{ $region->total }} Deep Diagnostics</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-xs font-black italic text-secondary">{{ $region->high_severity }} Crits</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 4. BOTTOM ANALYTICS: MATERIAL & CONTEXT (Balanced 50:50) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-slate-900 rounded-[2rem] border border-white/5 p-10 shadow-2xl">
            <h3 class="text-white font-heading font-black text-xl italic mb-10 border-l-4 border-primary pl-4 uppercase">Material Matrix.</h3>
            <div class="h-64 flex items-center">
                <canvas id="materialChart"></canvas>
            </div>
        </div>
        <div class="bg-slate-900 rounded-[2rem] border border-white/5 p-10 shadow-2xl">
            <h3 class="text-white font-heading font-black text-xl italic mb-10 border-l-4 border-secondary pl-4 uppercase">Context Analytics.</h3>
            <div class="h-64">
                <canvas id="contextChart"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(var(--primary-rgb), 0.3); }
</style>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart defaults
        Chart.defaults.color = '#64748b';
        Chart.defaults.font.family = 'inherit';

        // 1. Geographical Heatmap
        const map = L.map('battleMap', { zoomControl: false, attributionControl: false }).setView([-6.2088, 106.8456], 11);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png').addTo(map);

        const markers = L.markerClusterGroup({ showCoverageOnHover: false });
        const heatmapData = @json($heatmapData);
        
        heatmapData.forEach(p => {
            const color = p.final_deep_score === 'A' ? '#ff3b3b' : (p.final_deep_score === 'B' ? '#ff9f43' : '#22c55e');
            const marker = L.circleMarker([p.latitude, p.longitude], {
                radius: 8, fillColor: color, color: color, weight: 1, opacity: 0.8, fillOpacity: 0.5
            }).bindPopup(`<strong>ID: ${p.diagnose_id}</strong><br>Area: ${p.city_location || 'Detecting...'}<br>Severity: ${p.final_deep_score}`);
            markers.addLayer(marker);
        });
        map.addLayer(markers);

        // 2. Timeline Line Chart
        const timelineData = @json($timeline);
        new Chart(document.getElementById('timelineChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: timelineData.map(d => d.date),
                datasets: [{
                    label: 'Anomalies',
                    data: timelineData.map(d => d.total),
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,0.05)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    borderWidth: 4
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: 'rgba(255,255,255,0.03)' }, ticks: { color: '#64748b', font: { size: 9, weight: '900'} } },
                    x: { grid: { display : false }, ticks: { color: '#64748b', font: { size: 9, weight: '900'} } }
                }
            }
        });

        // 3. Material Distribution (Doughnut)
        const materialsData = @json($materials);
        new Chart(document.getElementById('materialChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: materialsData.map(m => m.material_type?.toUpperCase() || 'UNKNOWN'),
                datasets: [{
                    data: materialsData.map(m => m.total),
                    backgroundColor: ['#22c55e', '#3b82f6', '#f97316', '#a855f7'],
                    borderWidth: 0,
                    cutout: '80%'
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'right', labels: { color: '#94a3b8', usePointStyle: true, boxWidth: 6, font: { weight: 'black', size: 10 } } } }
            }
        });

        // 4. Contextual Stats (Bar)
        const contextData = @json($contextStats);
        new Chart(document.getElementById('contextChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: [...new Set(contextData.map(c => c.location_context?.toUpperCase() || 'GENERAL'))],
                datasets: [{
                    label: 'Density',
                    data: contextData.map(c => c.total),
                    backgroundColor: 'rgba(34, 197, 94, 0.15)',
                    borderColor: '#22c55e',
                    borderWidth: 2,
                    borderRadius: 12
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: 'rgba(255,255,255,0.03)' }, ticks: { color: '#64748b', font: { size: 9, weight: '900' } } },
                    x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 9, weight: '900' } } }
                }
            }
        });
    });
</script>
@endpush
@endsection
