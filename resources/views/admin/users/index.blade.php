@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight">Admin <span class="text-primary italic">Users.</span></h1>
            <p class="text-slate-500 font-medium mt-2 uppercase text-[10px] tracking-[0.3em]">System Access Management</p>
        </div>
        <a href="#" class="px-8 py-3 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-all shadow-xl shadow-primary/20">
            <i class="ri-add-line mr-2"></i> New User
        </a>
    </div>

    <!-- Table -->
    <div class="bg-slate-900/50 rounded-[2rem] border border-white/5 overflow-hidden backdrop-blur-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 border-b border-white/5">
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">User</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Email</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Role</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Joined</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($users as $user)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">{{ $user->name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-sm text-slate-300 font-medium">{{ $user->email }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-white/5 rounded-full text-[8px] font-black uppercase tracking-widest text-slate-400 border border-white/5">
                            Administrator
                        </span>
                    </td>
                    <td class="px-8 py-6 text-[10px] font-bold text-slate-500 uppercase">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="#" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:bg-white/10 transition-all">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <a href="#" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:bg-red-500 hover:text-white transition-all">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-8 border-t border-white/5">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
