@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto py-12">
    <div class="mb-12">
        <a href="{{ route('admin.users.index') }}" class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] hover:text-primary transition-all flex items-center gap-2 mb-6">
            <i class="ri-arrow-left-line"></i> Back to Fleet
        </a>
        <h1 class="text-4xl font-heading font-black text-white tracking-tight uppercase italic">Modify <span class="text-primary tracking-normal not-italic">Operator.</span></h1>
        <p class="text-slate-500 text-sm mt-3 italic">Perbarui parameter akses untuk personel administrasi {!! explode(' ', $user->name)[0] !!}.</p>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div class="bg-slate-900/50 border border-white/5 rounded-[2.5rem] p-10 backdrop-blur-xl space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Name -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                        placeholder="e.g. John Doe">
                    @error('name') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Clearance Level</label>
                    <select name="role" required
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all appearance-none">
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Admin / Root</option>
                    </select>
                </div>
            </div>

            <!-- Email -->
            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Gateway Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                    placeholder="name@rooterin.com">
                @error('email') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tight">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 border-t border-white/5 mt-6">
                <div class="flex items-center gap-3 mb-6">
                    <i class="ri-shield-keyhole-line text-primary text-xl"></i>
                    <div>
                        <p class="text-xs font-black text-white uppercase tracking-widest">Security Override</p>
                        <p class="text-[10px] text-slate-500 italic">Kosongkan jika tidak ingin mengubah password akses saat ini.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Password -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">New Access Password</label>
                        <input type="password" name="password"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                            placeholder="Leave blank to keep current">
                        @error('password') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Confirm Identity Override</label>
                        <input type="password" name="password_confirmation"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-sm focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                            placeholder="Repeat new password">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-6">
            <button type="submit" class="group relative px-10 py-5 bg-white text-slate-950 rounded-2xl font-black uppercase text-[11px] tracking-widest hover:bg-primary hover:text-white transition-all shadow-2xl active:scale-95">
                Update Identity Matrix
            </button>
        </div>
    </form>
</div>
@endsection
