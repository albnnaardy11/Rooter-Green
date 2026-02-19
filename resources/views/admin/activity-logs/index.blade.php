@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-8">
        <div>
            <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight">Audit <span class="text-primary italic">Trails.</span></h1>
            <p class="text-slate-500 font-medium mt-2 uppercase text-[10px] tracking-[0.3em]">System Monitoring & Security Logs</p>
        </div>
    </div>

    <div class="bg-slate-900/50 rounded-[3rem] border border-white/5 overflow-hidden backdrop-blur-xl shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/5">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">User</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Action</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">Entity</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-widest">IP Address</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($logs as $log)
                    <tr class="group hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-black text-xs border border-primary/20">
                                    {{ substr($log->user?->name ?? 'SYS', 0, 2) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-white">{{ $log->user?->name ?? 'System' }}</span>
                                    <span class="text-[10px] text-slate-500 font-medium tracking-wider">{{ $log->user?->email ?? 'no-email' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span @class([
                                'px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border',
                                'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' => $log->event === 'created',
                                'bg-amber-500/10 text-amber-500 border-amber-500/20' => $log->event === 'updated',
                                'bg-red-500/10 text-red-500 border-red-500/20' => $log->event === 'deleted',
                                'bg-blue-500/10 text-blue-500 border-blue-500/20' => !in_array($log->event, ['created', 'updated', 'deleted']),
                            ])>
                                {{ $log->event }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-300">{{ class_basename($log->auditable_type) }}</span>
                                <span class="text-[10px] text-slate-500 font-medium italic">ID: #{{ $log->auditable_id }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-mono text-slate-400 font-medium">{{ $log->ip_address }}</span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex flex-col items-end">
                                <span class="text-xs font-bold text-white">{{ $log->created_at->diffForHumans() }}</span>
                                <span class="text-[10px] text-slate-500 font-medium">{{ $log->created_at->format('M d, H:i:s') }}</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
        <div class="px-8 py-6 bg-white/5 border-t border-white/5">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
