@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                <p class="text-slate-500 font-black uppercase text-[10px] tracking-[0.3em]">Access Control Center</p>
            </div>
            <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight uppercase italic">Admin <span class="text-primary tracking-normal not-italic">Users.</span></h1>
        </div>
        <a href="{{ route('admin.users.create') }}" class="group relative px-8 py-4 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-all shadow-xl shadow-primary/20 overflow-hidden">
            <span class="relative z-10 flex items-center gap-2">
                <i class="ri-user-add-line text-lg"></i>
                New User
            </span>
            <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 p-4 rounded-2xl flex items-center gap-3 text-emerald-500 text-xs font-bold uppercase tracking-widest">
        <i class="ri-checkbox-circle-line text-xl"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-500/10 border border-red-500/20 p-4 rounded-2xl flex items-center gap-3 text-red-500 text-xs font-bold uppercase tracking-widest">
        <i class="ri-error-warning-line text-xl"></i>
        {{ session('error') }}
    </div>
    @endif

    <!-- Table -->
    <div class="bg-slate-900/50 rounded-[2.5rem] border border-white/5 overflow-hidden backdrop-blur-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 border-b border-white/5">
                        <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-500 tracking-widest">Identity & Designation</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-500 tracking-widest">Gateway Email</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-500 tracking-widest">Clearance Level</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-500 tracking-widest">Initialization</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-500 tracking-widest text-right">Ops</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($users as $user)
                    <tr class="hover:bg-white/[0.03] transition-colors group">
                        <td class="px-8 py-7">
                            <div class="flex items-center gap-5">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center text-primary font-black text-xl border border-primary/20 group-hover:scale-110 transition-transform">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-emerald-500 border-2 border-slate-900"></div>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-white tracking-tight">{{ $user->name }}</p>
                                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">Active Session</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-7">
                            <p class="text-xs text-slate-300 font-bold font-mono">{{ $user->email }}</p>
                        </td>
                        <td class="px-8 py-7">
                            <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $user->role === 'super_admin' ? 'bg-primary/10 text-primary border-primary/20' : 'bg-white/5 text-slate-400 border-white/10' }}">
                                {{ $user->role === 'super_admin' ? 'Super Admin / Root' : 'Administrator' }}
                            </span>
                        </td>
                        <td class="px-8 py-7 text-[10px] font-bold text-slate-500 font-mono">
                            {{ $user->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-8 py-7 text-right">
                            <div class="flex items-center justify-end gap-3 translate-x-4 group-hover:translate-x-0 opacity-0 group-hover:opacity-100 transition-all">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:bg-white/10 hover:text-white transition-all border border-white/5">
                                    <i class="ri-edit-2-line text-lg"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Terminate this access permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition-all border border-red-500/20">
                                        <i class="ri-delete-bin-7-line text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-white/5 bg-white/[0.01]">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
