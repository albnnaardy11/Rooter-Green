@extends('admin.layout')

@section('content')
<div class="min-h-screen bg-[#020617] text-slate-300 font-sans selection:bg-primary/30">
    <!-- Header: War Room Style -->
    <div class="relative overflow-hidden bg-slate-950 border-b border-white/5 px-8 py-6">
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(#3b82f6 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                    <h1 class="text-2xl font-black text-white tracking-tighter uppercase italic">AI Central Ops <span class="text-blue-500/70">v2.0</span></h1>
                </div>
                <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500">Neural Pool & Inference Gatekeeper (Kamar Otak)</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-[9px] font-black text-slate-500 uppercase leading-none">Max Capacity Limits</p>
                    <p class="text-xs font-mono text-blue-500 mt-1">{{ number_format($aiMetrics['max_capacity']) }} REQ / DAY</p>
                </div>
                <button class="px-6 py-2.5 bg-blue-500/10 text-blue-500 border border-blue-500/20 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-500 hover:text-white transition-all shadow-lg flex items-center gap-2">
                    <i class="ri-restart-line text-sm"></i> Flush Node Memory
                </button>
            </div>
        </div>
    </div>

    <div class="p-8 space-y-8">
        <!-- TOP METRICS (Layer 1 Gatekeeper) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-slate-900/50 border border-white/5 rounded-3xl p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <i class="ri-shield-check-line text-4xl text-blue-500"></i>
                </div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Lead Filter Rate</p>
                <div class="flex items-end gap-3">
                    <span class="text-3xl font-black text-white italic tracking-tighter">{{ $aiMetrics['lead_filter_rate'] }}%</span>
                    <span class="text-[10px] font-bold text-blue-500 mb-2">VERIFIED</span>
                </div>
            </div>
            
            <div class="bg-slate-900/50 border border-white/5 rounded-3xl p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <i class="ri-database-2-line text-4xl text-green-500"></i>
                </div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Cache Hit Rate</p>
                <div class="flex items-end gap-3">
                    <span class="text-3xl font-black text-white italic tracking-tighter">{{ $aiMetrics['cache_hit_rate'] }}%</span>
                    <span class="text-[10px] font-bold text-green-500 mb-2">ZERO REDUNDANCY</span>
                </div>
            </div>

            <div class="bg-slate-900/50 border border-white/5 rounded-3xl p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <i class="ri-alarm-warning-line text-4xl text-orange-500"></i>
                </div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">429 Quota Exhausted</p>
                <div class="flex items-end gap-3">
                    <span class="text-3xl font-black text-{{ $aiMetrics['quota_errors'] > 0 ? 'orange-500' : 'white' }} italic tracking-tighter">{{ $aiMetrics['quota_errors'] }}</span>
                    <span class="text-[10px] font-bold text-slate-500 mb-2">BLOCKS AVERTED</span>
                </div>
            </div>

            <div class="bg-slate-900/50 border border-white/5 rounded-3xl p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <i class="ri-focus-3-line text-4xl text-purple-500"></i>
                </div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Today's Inferences</p>
                <div class="flex items-end gap-3">
                    <span class="text-3xl font-black text-white italic tracking-tighter">{{ $aiMetrics['today_inferences'] }}</span>
                    <span class="text-[10px] font-bold text-purple-500 mb-2">TOTAL OPS</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Neural Pool Balancer (Left Column) -->
            <div class="bg-slate-900/50 border border-white/5 rounded-3xl p-8 flex flex-col">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xs font-black text-white uppercase tracking-widest flex items-center gap-2">
                        <i class="ri-node-tree text-blue-500 text-lg"></i> Neural Pool Nodes
                    </h3>
                    <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase bg-blue-500/10 text-blue-500 border border-blue-500/20">
                        {{ $aiMetrics['pool_size'] }} ACTIVE / 10
                    </span>
                </div>

                <div class="space-y-3 flex-1 overflow-y-auto pr-2 custom-scrollbar" style="max-height: 400px;">
                    @foreach($aiMetrics['keys_status'] as $keyIndex => $node)
                    <div class="p-4 bg-white/5 border border-white/5 rounded-2xl flex items-center justify-between hover:border-blue-500/30 transition-all cursor-crosshair">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-slate-950 flex items-center justify-center border border-white/10 shadow-inner">
                                <span class="text-[10px] font-black italic">{{ $keyIndex + 1 }}</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-white uppercase tracking-wider">{{ $node['node'] }}</p>
                                <p class="text-[8px] text-slate-500 font-mono mt-0.5 max-w-[120px] truncate group-hover:whitespace-normal">gemini-2.0-flash (Round-Robin)</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-black {{ $node['status'] == 'ACTIVE' ? 'text-green-500' : 'text-orange-500' }} italic">{{ $node['status'] }}</p>
                            <p class="text-[8px] font-bold text-slate-500 uppercase flex items-center justify-end gap-1 mt-0.5">
                                @if($node['status'] == 'ACTIVE')
                                    <i class="ri-speed-up-line text-blue-400"></i> {{ $node['latency'] }} | {{ $node['rpm_limit'] }}
                                @else
                                    <i class="ri-timer-flash-line text-orange-500"></i> {{ $node['rpm_limit'] }}
                                @endif
                            </p>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Inactive visual placeholders to always show 10 slots -->
                    @for($i = count($aiMetrics['keys_status']) + 1; $i <= 10; $i++)
                    <div class="p-4 bg-transparent border border-white/5 border-dashed rounded-2xl flex items-center justify-between opacity-30">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-slate-950 flex items-center justify-center border border-white/10 shadow-inner">
                                <span class="text-[10px] font-black italic">{{ $i }}</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-white uppercase tracking-wider">NODE-{{ $i }} (UNPLUGGED)</p>
                                <p class="text-[8px] text-slate-500 font-mono mt-0.5">Missing GEMINI_API_KEY_{{ $i }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-slate-500 italic">OFFLINE</p>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Recent Inference Transmissions (Right 2 Columns) -->
            <div class="lg:col-span-2 bg-slate-900/50 border border-white/5 rounded-3xl p-8 relative overflow-hidden flex flex-col">
                <div class="absolute inset-0 opacity-5 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                
                <div class="flex items-center justify-between mb-8 relative z-10">
                    <h3 class="text-xs font-black text-white uppercase tracking-widest flex items-center gap-2">
                        <i class="ri-radar-scan-line text-primary text-lg"></i> Neural Inference Logs
                    </h3>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        <span class="text-[9px] font-black text-green-500 uppercase tracking-widest">Live Feed</span>
                    </div>
                </div>

                <div class="flex-1 overflow-x-auto relative z-10">
                    <table class="w-full text-left border-collapse min-w-[600px]">
                        <thead>
                            <tr class="border-b border-white/5 text-[8px] uppercase tracking-widest text-slate-500 font-black">
                                <th class="pb-3 pl-4">Op ID</th>
                                <th class="pb-3">Timestamp</th>
                                <th class="pb-3">Engine Node</th>
                                <th class="pb-3">Confidence</th>
                                <th class="pb-3">Verdict</th>
                                <th class="pb-3 text-right pr-4">L1 Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($aiMetrics['recent_ops'] as $op)
                            <tr class="border-b border-white/5 hover:bg-white/5 transition-all text-[11px] group">
                                <td class="py-4 pl-4 font-mono text-slate-400">#{{ substr($op->diagnose_id, -6) }}</td>
                                <td class="py-4 font-bold text-white">
                                    {{ $op->created_at->format('H:i:s') }}
                                    <span class="text-[8px] block text-slate-500 uppercase font-black">{{ $op->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="py-4">
                                    <span class="px-2 py-1 bg-blue-500/10 text-blue-400 text-[8px] font-black rounded border border-blue-500/20 uppercase">
                                        {{ $op->metadata['performance']['key_used'] ?? 'PRIMARY NODE' }}
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 h-1.5 bg-white/5 rounded-full overflow-hidden">
                                            <div class="h-full bg-{{ ($op->confidence_score ?? 0) > 80 ? 'green-500' : 'orange-500' }}" style="width: {{ $op->confidence_score ?? 0 }}%"></div>
                                        </div>
                                        <span class="font-black italic text-white">{{ $op->confidence_score ?? 0 }}%</span>
                                    </div>
                                </td>
                                <td class="py-4 font-bold text-white uppercase max-w-[150px] truncate" title="{{ $op->result_label }}">
                                    {{ $op->result_label ?: 'Evaluating...' }}
                                </td>
                                <td class="py-4 text-right pr-4">
                                    @if($op->image_hash)
                                        <span class="text-[9px] font-black text-green-500 uppercase flex items-center justify-end gap-1"><i class="ri-check-double-line"></i> CACHED</span>
                                    @elseif($op->status == 'pending')
                                        <span class="text-[9px] font-black text-orange-500 uppercase flex items-center justify-end gap-1"><i class="ri-loader-4-line animate-spin"></i> QUEUED</span>
                                    @else
                                        <span class="text-[9px] font-black text-purple-500 uppercase flex items-center justify-end gap-1"><i class="ri-brain-line"></i> INFERRED</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if(count($aiMetrics['recent_ops']) === 0)
                            <tr>
                                <td colspan="6" class="py-12 text-center opacity-40">
                                    <i class="ri-ghost-line text-4xl mb-3 block"></i>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">No recent inference telemetry.</span>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- System Settings Integrity Map -->
        <div class="bg-slate-900/50 border border-white/5 rounded-3xl p-8 mt-8">
            <h3 class="text-xs font-black text-white uppercase tracking-widest flex items-center gap-2 mb-6">
                <i class="ri-cpu-line text-primary text-lg"></i> Layer 1 Sentinel Verification (Gatekeeper Logic)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Zero-Redundancy Metric -->
                <div class="border-l-2 border-green-500/30 pl-4">
                    <p class="text-[8px] font-black text-slate-500 uppercase mb-2 tracking-widest">Hashing Engine (Zero-Redundancy)</p>
                    <div class="flex items-center gap-2">
                        <i class="ri-checkbox-circle-fill text-green-500 text-xl"></i>
                        <p class="text-sm font-black text-white uppercase">SHA-256 Collision Avoidance</p>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2 font-mono">Bypasses API calls for exact duplicate image uploads.</p>
                </div>

                <!-- Verified Lead Protection -->
                <div class="border-l-2 border-blue-500/30 pl-4">
                    <p class="text-[8px] font-black text-slate-500 uppercase mb-2 tracking-widest">Lead Enforcement Firewall</p>
                    <div class="flex items-center gap-2">
                        <i class="ri-checkbox-circle-fill text-blue-500 text-xl"></i>
                        <p class="text-sm font-black text-white uppercase">WhatsApp Verification Required</p>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2 font-mono">Prevents anonymous bots from exhausting API quota boundaries.</p>
                </div>

                <!-- API Rate Limit Protection -->
                <div class="border-l-2 border-orange-500/30 pl-4">
                    <p class="text-[8px] font-black text-slate-500 uppercase mb-2 tracking-widest">Failover Protection (Fallback)</p>
                    <div class="flex items-center gap-2">
                        <i class="ri-checkbox-circle-fill text-orange-500 text-xl"></i>
                        <p class="text-sm font-black text-white uppercase">Graceful 429 Error Handling</p>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2 font-mono">Reverts to expert-ruleset survey if Node Pool is entirely depleted.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(59, 130, 246, 0.4); }
</style>
@endsection
