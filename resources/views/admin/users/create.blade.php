@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto py-12">
    <div class="mb-12">
        <a href="{{ route('admin.users.index') }}" class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] hover:text-primary transition-all flex items-center gap-2 mb-6">
            <i class="ri-arrow-left-line"></i> Back to Fleet
        </a>
        <h1 class="text-4xl font-heading font-black text-white tracking-tight uppercase italic">Deploy New <span class="text-primary tracking-normal not-italic">Operator.</span></h1>
        <p class="text-slate-500 text-sm mt-3 italic">Konfigurasi parameter akses untuk personel administrasi baru.</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="bg-slate-900/50 border border-white/5 rounded-[2.5rem] p-10 backdrop-blur-xl space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Name -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                        placeholder="e.g. John Doe">
                    @error('name') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Clearance Level</label>
                    <select name="role" required
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all appearance-none">
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin / Root</option>
                    </select>
                </div>
            </div>

            <!-- Email -->
            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Gateway Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                    placeholder="name@rooterin.com">
                @error('email') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tight">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                <!-- Password -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Access Password</label>
                    <input type="password" name="password" required
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                        placeholder="••••••••">
                    @error('password') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Confirm Identity</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                        placeholder="••••••••">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-6">
            <button type="reset" class="text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-white transition-all">
                Reset Form
            </button>
            <button type="submit" class="group relative px-10 py-5 bg-white text-slate-950 rounded-2xl font-black uppercase text-[11px] tracking-widest hover:bg-primary hover:text-white transition-all shadow-2xl active:scale-95">
                Initialize Access Protocol
            </button>
        </div>
    </form>
</div>
@endsection
