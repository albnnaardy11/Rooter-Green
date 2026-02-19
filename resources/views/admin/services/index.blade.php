@extends('admin.layout')

@section('content')
<div class="space-y-12">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl sm:text-4xl font-heading font-black text-white tracking-tight">Service <span class="text-primary italic">Catalog.</span></h1>
            <p class="text-slate-500 font-medium mt-2 uppercase text-[10px] tracking-[0.3em]">Core Offerings Management</p>
        </div>
        <a href="#" class="px-8 py-3 bg-primary text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:scale-105 transition-all shadow-xl shadow-primary/20">
            <i class="ri-add-line mr-2"></i> New Service
        </a>
    </div>

    <!-- Table -->
    <div class="bg-slate-900/50 rounded-[2rem] border border-white/5 overflow-hidden backdrop-blur-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 border-b border-white/5">
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Service</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Price</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase text-slate-500 tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($services as $service)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                <i class="{{ $service->icon ?? 'ri-customer-service-2-line' }} text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">{{ $service->name }}</p>
                                <p class="text-[10px] text-slate-500 italic line-clamp-1">{{ $service->description_short }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-sm font-bold text-white">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-white/5 rounded-full text-[8px] font-black uppercase tracking-widest {{ $service->is_active ? 'text-primary' : 'text-slate-500' }} border border-white/5">
                            {{ $service->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="#" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 hover:bg-white/10 transition-all">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-8 border-t border-white/5">
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection
