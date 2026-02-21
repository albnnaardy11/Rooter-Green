@extends('admin.layout')

@section('content')
<div class="space-y-8">
    <!-- Header Hero -->
    <div class="relative overflow-hidden rounded-[32px] bg-slate-900 border border-white/5 p-12">
        <div class="absolute top-0 right-0 p-12 opacity-10">
            <i class="ri-shield-keyhole-fill text-[120px] text-primary"></i>
        </div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 bg-primary/20 text-primary text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-primary/20">SecOps v2.4</span>
                    @if($stats['masterpiece_active'])
                    <span class="px-3 py-1 bg-orange-500/20 text-orange-500 text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-orange-500/20">Masterpiece Active</span>
                    @endif
                    <span class="flex items-center gap-2 text-emerald-500 text-[10px] font-black uppercase tracking-[0.2em]">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Neural Shield Active
                    </span>
                </div>
                <h1 class="text-4xl font-black text-white font-heading mb-2 uppercase tracking-tighter">Security & Access <span class="text-primary tracking-normal">Vault</span></h1>
                <p class="text-slate-400 text-sm max-w-xl italic">Pusat pertahanan otonom RooterIN. Mendeteksi, mencegah, dan memulihkan celah keamanan secara real-time tanpa campur tangan manusia.</p>
            </div>
            
            <div class="flex items-center gap-4">
                @if($stats['lockdown_active'])
                <form action="{{ route('admin.vault.emergency-release') }}" method="POST">
                    @csrf
                    <button type="submit" class="group relative px-8 py-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl transition-all hover:bg-emerald-500 hover:text-white">
                        <div class="flex items-center gap-3">
                            <i class="ri-heart-pulse-line text-xl"></i>
                            <span class="font-bold uppercase text-xs tracking-widest">Emergency Release</span>
                        </div>
                    </button>
                </form>
                @endif
                
                <form action="{{ route('admin.vault.lockdown') }}" method="POST">
                    @csrf
                    <button type="submit" class="group relative px-8 py-4 bg-red-500/10 border border-red-500/20 rounded-2xl transition-all hover:bg-red-500 hover:text-white">
                        <div class="flex items-center gap-3">
                            <i class="ri-alarm-warning-line text-xl {{ $stats['lockdown_active'] ? 'animate-bounce text-red-500 group-hover:text-white' : '' }}"></i>
                            <span class="font-bold uppercase text-xs tracking-widest">{{ $stats['lockdown_active'] ? 'Disable Lockdown' : 'Emergency Lockdown' }}</span>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Security Pulse Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-slate-900/50 border border-white/5 p-6 rounded-[24px] group hover:border-primary/30 transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary border border-primary/10 group-hover:bg-primary group-hover:text-white transition-all">
                    <i class="ri-lock-password-line text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Environment</p>
                    <h3 class="text-white font-bold">{{ strtoupper($stats['env']) }}</h3>
                </div>
            </div>
            <div class="flex items-center justify-between text-[10px] font-bold">
                <span class="text-slate-500 uppercase">Debug Mode</span>
                <span class="{{ $stats['debug_mode'] ? 'text-red-500' : 'text-emerald-500' }}">{{ $stats['debug_mode'] ? 'ENABLED (DANGER)' : 'DISABLED (SECURE)' }}</span>
            </div>
        </div>

        <div class="bg-slate-900/50 border border-white/5 p-6 rounded-[24px] group hover:border-primary/30 transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary border border-primary/10 group-hover:bg-primary group-hover:text-white transition-all">
                    <i class="ri-shield-flash-line text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">SSL Heartbeat</p>
                    <h3 class="text-white font-bold">{{ is_bool($stats['ssl_days']) ? 'Verified' : $stats['ssl_days'] . ' Days' }}</h3>
                </div>
            </div>
            <div class="w-full bg-white/5 h-1 rounded-full overflow-hidden">
                <div class="bg-primary h-full transition-all" style="width: 100%"></div>
            </div>
        </div>

        <div class="bg-slate-900/50 border border-white/5 p-6 rounded-[24px] group hover:border-primary/30 transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary border border-primary/10 group-hover:bg-primary group-hover:text-white transition-all">
                    <i class="ri-fire-line text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Firewall Active</p>
                    <h3 class="text-white font-bold">{{ $stats['blocked_ips'] }} Blocked IPs</h3>
                </div>
            </div>
            <form action="{{ route('admin.vault.flush') }}" method="POST">
                @csrf
                <button type="submit" class="text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-primary transition-all flex items-center gap-2">
                    <i class="ri-refresh-line"></i> Flush Firewall Cache
                </button>
            </form>
        </div>

        <div class="bg-slate-900/50 border border-white/5 p-6 rounded-[24px] group hover:border-primary/30 transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary border border-primary/10 group-hover:bg-primary group-hover:text-white transition-all">
                    <i class="ri-radar-line text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Audit Trails</p>
                    <h3 class="text-white font-bold">{{ $stats['audit_logs'] }} Events</h3>
                </div>
            </div>
            <div class="space-y-3">
                <form action="{{ route('admin.vault.scan') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left text-[10px] font-black text-emerald-500 hover:text-white uppercase tracking-widest transition-all flex items-center gap-2">
                        <i class="ri-macbook-line"></i> Run Deep Holistic Scan
                    </button>
                </form>
                <a href="{{ route('admin.activity-logs.index') }}" class="text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-primary transition-all flex items-center gap-2">
                    <i class="ri-external-link-line"></i> View System Logs
                </a>
            </div>
        </div>
    </div>
    
    @if($latestAudit)
    <!-- Sentinel Immutability Engine: Holistic Scan Results -->
    <div class="bg-slate-900 border border-emerald-500/20 rounded-[32px] overflow-hidden p-8">
        <div class="flex items-center justify-between mb-8 pb-6 border-b border-white/5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 border border-emerald-500/10">
                    <i class="ri-pulse-line text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-white font-heading font-black uppercase tracking-widest text-sm">Sentinel Immutability Scan</h3>
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest">Verified at: {{ $latestAudit->created_at->format('Y-m-d H:i:s') }} GMT</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-500 text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-emerald-500/20">Elite Verified</span>
                <span class="px-3 py-1 bg-white/5 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-white/5">{{ $latestAudit->node_id }}</span>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Neural Assets</p>
                <p class="text-xs font-bold text-white uppercase">{{ $latestAudit->metrics['neural_assets'] ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">DB Pulse</p>
                <p class="text-xs font-bold text-emerald-500">{{ $latestAudit->metrics['db_latency'] ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Memory Baseline</p>
                <p class="text-xs font-bold text-white italic">{{ $latestAudit->metrics['memory_baseline'] ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Node Efficiency</p>
                <p class="text-xs font-bold text-primary">{{ $latestAudit->metrics['system_efficiency'] ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Platform Context</p>
                <p class="text-xs font-bold text-white uppercase">{{ $latestAudit->environment }} ({{ strtoupper($latestAudit->metrics['env_context']['php_version'] ?? 'N/A') }})</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Connectivity</p>
                <div class="flex flex-wrap gap-1">
                    @foreach($latestAudit->metrics['node_status'] ?? [] as $node => $status)
                        <span title="{{ $node }}" class="w-2 h-2 rounded-full {{ $status === 'Operational' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Defensive Strategies -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-slate-900 border border-white/5 rounded-[32px] overflow-hidden">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <h3 class="text-white font-heading font-black uppercase tracking-widest text-sm flex items-center gap-3">
                    <i class="ri-robot-2-line text-primary"></i>
                    Neural Asset Shield
                </h3>
            </div>
            <div class="p-8 space-y-4">
                <div class="flex items-center justify-between gap-4 p-4 rounded-2xl bg-white/5 border border-white/5">
                    <div class="flex items-center gap-4">
                        <i class="ri-file-code-line text-2xl text-primary"></i>
                        <div>
                            <p class="text-xs font-bold text-white">Vision Models Protection</p>
                            <p class="text-[10px] text-slate-500">Status: Token-Only Access (Active)</p>
                        </div>
                    </div>
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                </div>
                <div class="flex items-center justify-between gap-4 p-4 rounded-2xl bg-white/5 border border-white/5">
                    <div class="flex items-center gap-4">
                        <i class="ri-shield-user-line text-2xl text-primary"></i>
                        <div>
                            <p class="text-xs font-bold text-white">WikiPipa Scraper Blocker</p>
                            <p class="text-[10px] text-slate-500">Auto-Banning User-Agents: Python, Go-http-client, libcurl</p>
                        </div>
                    </div>
                    <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></span>
                </div>
            </div>
        </div>

        <div class="bg-slate-900 border border-white/5 rounded-[32px] overflow-hidden">
            <div class="p-8 border-b border-white/5">
                <h3 class="text-white font-heading font-black uppercase tracking-widest text-sm flex items-center gap-3">
                    <i class="ri-fingerprint-line text-primary"></i>
                    Kriptografi & Token
                </h3>
            </div>
            <div class="p-8 space-y-4">
                <div class="p-4 rounded-2xl bg-primary/5 border border-primary/10">
                    <p class="text-[10px] font-black text-primary uppercase tracking-[0.2em] mb-2">Protocol: PASETO v4.local</p>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">Menggunakan <b>Phantom Token Pattern</b> untuk menyembunyikan identitas asli di sisi publik.</p>
                    
                    <form action="{{ route('admin.vault.rotate') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-white/5 border border-white/10 rounded-xl text-[10px] font-black text-white uppercase tracking-widest hover:bg-primary hover:border-primary transition-all flex items-center justify-center gap-2">
                            <i class="ri-loop-right-line"></i> Rotate Global Tokens
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-slate-900 border border-white/5 rounded-[32px] overflow-hidden">
            <div class="p-8 border-b border-white/5">
                <h3 class="text-white font-heading font-black uppercase tracking-widest text-sm flex items-center gap-3">
                    <i class="ri-key-2-line text-primary"></i>
                    Role-Based Access (RBAC)
                </h3>
            </div>
            <div class="p-8 space-y-4">
                <p class="text-slate-400 text-xs italic mb-4">Pengaturan akses ketat untuk area sensitif platform.</p>
                <div class="space-y-3">
                    <div class="flex items-center justify-between px-4 py-2 bg-white/5 rounded-xl border border-white/5">
                        <span class="text-xs font-bold text-white">SEO Central</span>
                        <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">Super Admin Only</span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-2 bg-white/5 rounded-xl border border-white/5">
                        <span class="text-xs font-bold text-white">AI Intelligence</span>
                        <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">Super Admin Only</span>
                    </div>
                    <div class="flex items-center justify-between px-4 py-2 bg-white/5 rounded-xl border border-white/5">
                        <span class="text-xs font-bold text-white">System Sentinel</span>
                        <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">System / Root</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
