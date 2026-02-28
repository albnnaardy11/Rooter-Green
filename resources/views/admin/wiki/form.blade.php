@extends('admin.layout')

@section('title', $isEdit ? 'Refine Neural Asset: ' . $entity->title : 'Deploy New Neural Entity')

@section('content')
@php 
    $phantomToken = app(\App\Services\Security\PhantomSyncService::class)->generateToken([
        'user_id' => auth()->id(),
        'ip' => request()->ip(),
        'action' => 'wikipipa_automator'
    ]); 
@endphp
<div class="space-y-12" x-data="wikiForm()">
    <!-- Header: Industrial Command Style -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shadow-lg shadow-primary/5 border border-primary/20">
                    <i class="ri-{{ $isEdit ? 'edit-box-line' : 'add-circle-line' }} text-2xl"></i>
                </div>
                <div>
                    <span class="text-[10px] font-black text-primary uppercase tracking-[0.4em] block">WikiPipa Authority Builder</span>
                    <h1 class="text-3xl font-heading font-black text-white leading-none tracking-tighter">
                        {{ $isEdit ? 'Refine' : 'Deploy' }} <span class="text-primary italic">Neural Entity</span>.
                    </h1>
                </div>
            </div>
            <p class="text-slate-500 text-sm max-w-xl font-medium">
                {{ $isEdit ? 'Lakukan optimasi mendalam pada aspek semantik dan data teknis entitas eksisting.' : 'Inisialisasi entitas pengetahuan geofisika baru dengan standar E-E-A-T tertinggi.' }}
            </p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.wiki.index') }}" class="px-8 py-4 bg-white/5 text-slate-500 rounded-[2rem] font-black text-xs uppercase tracking-widest hover:text-white transition-all border border-white/5">
                Back to Manifest
            </a>
        </div>
    </div>

    <form action="{{ $isEdit ? route('admin.wiki.update', $entity->id) : route('admin.wiki.store') }}" method="POST" class="space-y-10">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Left Column: Primary Config -->
            <div class="lg:col-span-1 space-y-10">
                <div class="bg-white/5 border border-white/5 rounded-[2.5rem] p-8 space-y-8">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Entity Master Title</label>
                        <div class="relative group space-y-4">
                            <input type="text" x-model="name" name="title" value="{{ old('title', $entity->title) }}" placeholder="e.g. Ultrasonic Flow Meter" class="w-full bg-slate-800/50 border border-white/10 rounded-2xl px-6 py-5 text-white focus:border-primary outline-none text-sm transition-all shadow-inner">
                            <textarea x-model="context" placeholder="Konteks AI Spesifik (Opsional) e.g. Fokus pada deteksi kebocoran..." class="w-full bg-slate-800/30 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-primary outline-none text-xs transition-all shadow-inner h-24 resize-none"></textarea>
                            <button type="button" @click="autoInference" class="w-full py-4 bg-primary text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-primary/20 disabled:opacity-50" :disabled="loading">
                                <span x-show="!loading" class="flex items-center justify-center gap-2"><i class="ri-magic-line text-lg"></i> AI Automate Authority</span>
                                <span x-show="loading" class="flex items-center justify-center gap-2"><i class="ri-refresh-line animate-spin text-lg"></i> Neural Processing...</span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Domain Category</label>
                        <select name="category" class="w-full bg-slate-800/50 border border-white/10 rounded-2xl px-6 py-5 text-white appearance-none focus:border-primary outline-none transition-all font-bold text-xs uppercase tracking-widest cursor-pointer">
                            @foreach(['Material Pipa', 'Alat Teknisi', 'Infrastruktur', 'Kimia', 'Audit Geofisika', 'Masalah Plumbing', 'Spesialis'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $entity->category) == $cat ? 'selected' : '' }} class="bg-slate-900 uppercase">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Wikidata Semantic QID</label>
                        <div class="relative">
                            <i class="ri-database-2-line absolute left-6 top-1/2 -translate-y-1/2 text-slate-600"></i>
                            <input type="text" name="wikidata_id" x-model="wikidata_id" value="{{ old('wikidata_id', $entity->wikidata_id) }}" placeholder="Q123456" class="w-full bg-slate-800/50 border border-white/10 rounded-2xl pl-12 pr-6 py-5 text-white outline-none focus:border-primary font-mono text-xs transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Structural Data (JSON Manifest)</label>
                        <div class="relative">
                            <textarea x-model="attributes" name="attributes_json" class="w-full bg-slate-950 border border-white/10 rounded-2xl px-6 py-5 text-primary font-mono text-[11px] h-64 focus:border-primary outline-none shadow-inner resize-none">{{ old('attributes_json', json_encode($entity->attributes, JSON_PRETTY_PRINT)) }}</textarea>
                            <div class="absolute bottom-4 right-6 text-[8px] font-black text-slate-700 uppercase">Schema Compliant</div>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-primary/5 border border-primary/10 rounded-[2.5rem]">
                    <h4 class="text-[10px] font-bold text-primary uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i class="ri-information-line text-lg"></i>
                        Industrial Standard Tip
                    </h4>
                    <p class="text-slate-500 text-xs leading-relaxed">
                        Gunakan **AI Automator** untuk merumuskan definisi operasional berbasis fisika dan menyusun tabel spesifikasi 3-kolom (**Atribut | Parameter | Analisis RooterIn**) yang dioptimalkan untuk Google Featured Snippets.
                    </p>
                </div>
            </div>

            <!-- Right Column: Rich Text Editor -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white/5 border border-white/5 rounded-[3rem] p-1 shadow-2xl h-full flex flex-col">
                    <div class="p-8 pb-4">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 font-heading">In-Depth Technical Discourse (Authority Markdown)</label>
                        <p class="text-slate-600 text-[10px] font-medium mb-4">Gunakan heading H3 untuk seksi utama guna memperkuat struktur hierarki SEO.</p>
                    </div>
                    <div class="flex-grow p-4 min-h-[600px] bg-slate-950/30 rounded-[2.5rem]">
                        <x-admin.rich-editor name="description" :value="old('description', $entity->description)" />
                    </div>
                </div>

                <div class="flex gap-6 items-center">
                    <button type="submit" class="flex-grow py-6 bg-primary text-white rounded-[2.5rem] font-black uppercase tracking-[0.4em] hover:scale-[1.01] active:scale-95 transition-all shadow-2xl shadow-primary/30 text-xs">
                        {{ $isEdit ? 'Finalize & Sync Changes' : 'Inject & Deploy to Knowledge Base' }}
                    </button>
                    <a href="{{ route('admin.wiki.index') }}" class="px-12 py-6 bg-white/5 text-slate-500 rounded-[2.5rem] font-black text-xs uppercase tracking-widest hover:text-white transition-all border border-white/5">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function wikiForm() {
    return {
        name: '{{ old('title', $entity->title) }}',
        context: '',
        wikidata_id: '{{ old('wikidata_id', $entity->wikidata_id) }}',
        @php
            $attrs = old('attributes_json', json_encode($entity->attributes, JSON_PRETTY_PRINT));
            if ($attrs === 'null' || !$attrs) $attrs = '{}';
        @endphp
        attributes: {!! json_encode($attrs) !!},
        loading: false,

        async autoInference() {
            if (!this.name) return alert('Identitas objek master diperlukan sebelum pemrosesan neural.');
            
            this.loading = true;
            try {
                const response = await fetch('{{ route('admin.wiki.generate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Phantom-Token': '{{ $phantomToken }}'
                    },
                    body: JSON.stringify({ 
                        name: this.name,
                        context: this.context
                    })
                });
                
                const data = await response.json();
                this.wikidata_id = data.wikidata_id;
                
                if (window.cmsEditors && window.cmsEditors['description']) {
                    window.cmsEditors['description'].setData(data.description);
                }
                this.attributes = JSON.stringify(data.attributes, null, 4);
            } catch (e) {
                alert('Neural Network Disruption. Sceduling manual input protocol.');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endsection
