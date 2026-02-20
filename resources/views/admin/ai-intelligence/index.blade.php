@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <!-- Header with Seasonal Alert -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-heading font-black text-white tracking-tighter italic">
                AI <span class="text-primary">Intelligence</span> Center.
            </h1>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-widest mt-2">Neural Analysis & Logistics Optimization</p>
        </div>
        
        @if($trends['alert_triggered'])
        <div class="flex items-center gap-4 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl animate-pulse">
            <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-red-500/20">
                <i class="ri-alarm-warning-line text-2xl"></i>
            </div>
            <div>
                <p class="text-red-500 font-black text-[10px] uppercase tracking-[0.2em]">Prediksi Urgensi Terdeteksi</p>
                <p class="text-white text-xs font-bold mt-1">Tren Lemak naik di akhir pekan (+{{ $trends['increase_percent'] }}%). Siapkan armada Hydro-Jetting ekstra!</p>
            </div>
        </div>
        @endif

        <div class="flex gap-2">
            <a href="{{ route('admin.ai.intelligence.export', ['type' => 'csv']) }}" class="px-6 py-4 bg-white text-slate-950 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-primary transition-all flex items-center gap-3">
                <i class="ri-file-excel-2-line text-lg"></i>
                Export Logistics (Priority A/B)
            </a>
        </div>
    </div>

    <!-- Top Grid: Map & Conversion -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Geographical Heatmap (The Battle Map) -->
        <div class="lg:col-span-2 bg-slate-900 rounded-[2.5rem] border border-white/5 p-2 min-h-[500px] relative overflow-hidden group">
            <div class="absolute top-6 left-8 z-[1000] pointer-events-none">
                <span class="px-3 py-1 bg-primary/20 backdrop-blur-md text-primary text-[8px] font-black uppercase tracking-[0.3em] rounded-full border border-primary/30">Live Deployment Map</span>
            </div>
            <div id="battleMap" class="w-full h-full rounded-[2rem] z-10"></div>
        </div>

        <!-- Conversion Tracker (Radial Gauge) -->
        <div class="bg-slate-900 rounded-[2.5rem] border border-white/5 p-8 flex flex-col justify-center items-center text-center">
            <h3 class="text-slate-500 font-black uppercase text-[10px] tracking-[0.3em] mb-8">AI Conversion Rate</h3>
            <div class="relative w-48 h-48">
                <canvas id="conversionGauge"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-4xl font-heading font-black text-white italic">{{ $conversion['conversion_rate'] }}%</span>
                    <span class="text-[8px] font-bold text-slate-500 uppercase tracking-widest">Lead Sync Rate</span>
                </div>
            </div>
            <div class="mt-8 grid grid-cols-2 gap-4 w-full">
                <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                    <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Total Diagnoses</p>
                    <p class="text-xl font-heading font-black text-white">{{ $conversion['total_diagnoses'] }}</p>
                </div>
                <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                    <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest">WA Leads</p>
                    <p class="text-xl font-heading font-black text-secondary">{{ $conversion['total_clicks'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Grid: Business Intelligence -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Material Distribution -->
        <div class="bg-slate-900 rounded-[2.5rem] border border-white/5 p-10">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-white font-heading font-black text-xl italic underline decoration-primary">Material Analytics.</h3>
                <i class="ri-copper-diamond-line text-2xl text-slate-700"></i>
            </div>
            <div class="h-64">
                <canvas id="materialChart"></canvas>
            </div>
        </div>

        <!-- Contextual Stats -->
        <div class="bg-slate-900 rounded-[2.5rem] border border-white/5 p-10">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-white font-heading font-black text-xl italic underline decoration-secondary">Contextual Density.</h3>
                <i class="ri-bar-chart-box-line text-2xl text-slate-700"></i>
            </div>
            <div class="h-64">
                <canvas id="contextChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Geographical Heatmap (Leaflet)
        const map = L.map('battleMap', {
            zoomControl: false,
            attributionControl: false
        }).setView([-6.2088, 106.8456], 10); // Center on Jakarta/HQ

        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19
        }).addTo(map);

        const markers = L.markerClusterGroup({
            showCoverageOnHover: false,
            spiderfyOnMaxZoom: true
        });

        const heatmapData = @json($heatmapData);
        
        heatmapData.forEach(point => {
            const color = point.final_deep_score === 'A' ? '#FF0000' : 
                         (point.final_deep_score === 'B' ? '#FFA500' : '#00FF00');
            
            const circleMarker = L.circleMarker([point.latitude, point.longitude], {
                radius: 8,
                fillColor: color,
                color: color,
                weight: 1,
                opacity: 0.8,
                fillOpacity: 0.6
            }).bindPopup(`<strong>ID: ${point.diagnose_id}</strong><br>Severity Rank: ${point.final_deep_score}`);
            
            markers.addLayer(circleMarker);
        });

        map.addLayer(markers);

        // 2. Conversion Radial Gauge (Chart.js hack)
        const ctxGauge = document.getElementById('conversionGauge').getContext('2d');
        new Chart(ctxGauge, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [{{ $conversion['conversion_rate'] }}, {{ 100 - $conversion['conversion_rate'] }}],
                    backgroundColor: ['#22c55e', 'rgba(255,255,255,0.05)'],
                    borderWidth: 0,
                    circumference: 270,
                    rotation: 225,
                    cutout: '85%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { enabled: false } }
            }
        });

        // 3. Material Distribution (Pie)
        const ctxMaterial = document.getElementById('materialChart').getContext('2d');
        const materialsData = @json($materials);
        new Chart(ctxMaterial, {
            type: 'pie',
            data: {
                labels: materialsData.map(m => m.material_type ? m.material_type.toUpperCase() : 'UNKNOWN'),
                datasets: [{
                    data: materialsData.map(m => m.total),
                    backgroundColor: ['#22c55e', '#f97316', '#3b82f6', '#a855f7'],
                    borderColor: 'rgba(15, 23, 42, 1)',
                    borderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: '#94a3b8', font: { weight: 'bold', size: 10 }, usePointStyle: true }
                    }
                }
            }
        });

        // 4. Contextual Stats (Bar)
        const ctxContext = document.getElementById('contextChart').getContext('2d');
        const contextData = @json($contextStats);
        new Chart(ctxContext, {
            type: 'bar',
            data: {
                labels: [...new Set(contextData.map(c => c.location_context?.toUpperCase() || 'GENERAL'))],
                datasets: [{
                    label: 'Anomalies Detected',
                    data: contextData.map(c => c.total),
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    borderColor: '#22c55e',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#64748b' } },
                    x: { grid: { display: false }, ticks: { color: '#64748b' } }
                }
            }
        });
    });
</script>
@endpush
@endsection
