<x-app-layout title="AI Deep Diagnostic - RooterIN">

{{-- Inline meta buat page-level SEO --}}
@push('head')
<meta name="description" content="Gunakan teknologi AI RooterIN untuk mendeteksi masalah pipa Anda secara otomatis dan akurat.">
@endpush

<div x-data="aiDiag()" x-init="init()" class="relative min-h-screen bg-slate-950 pt-28 pb-20 overflow-x-hidden">

    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image: radial-gradient(#22c55e 1px, transparent 1px); background-size: 36px 36px;"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-slate-950 via-transparent to-slate-950 pointer-events-none"></div>

    {{-- TOAST NOTIFICATION --}}
    <div x-show="toast.show"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         x-cloak
         class="fixed top-24 left-1/2 -translate-x-1/2 z-[500] w-[92%] max-w-sm">
        <div class="rounded-2xl px-5 py-4 shadow-2xl flex items-center gap-3 border backdrop-blur-xl"
             :class="toast.type==='error' ? 'bg-red-600/90 border-red-500 text-white' : 'bg-green-500/90 border-green-400 text-slate-950'">
            <i :class="toast.type==='error' ? 'ri-error-warning-fill' : 'ri-checkbox-circle-fill'" class="text-xl shrink-0"></i>
            <span class="text-[10px] font-black uppercase tracking-widest leading-tight" x-text="toast.msg"></span>
        </div>
    </div>

    {{-- RESULT MODAL --}}
    <div x-show="showModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak
         class="fixed inset-0 z-[999] flex items-center justify-center p-5">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-slate-950/95 backdrop-blur-2xl" @click="showModal=false"></div>
        {{-- Card --}}
        <div class="relative w-full max-w-md bg-slate-900 border border-white/10 rounded-[3rem] p-8 shadow-[0_0_80px_rgba(34,197,94,0.15)] overflow-y-auto max-h-[90vh]">

            {{-- Rank Badge --}}
            <div class="flex justify-center mb-6">
                <div class="w-28 h-28 rounded-full bg-gradient-to-br from-green-400 via-orange-400 to-orange-600 p-1">
                    <div class="w-full h-full bg-slate-950 rounded-full flex flex-col items-center justify-center">
                        <span class="text-5xl font-black text-white italic leading-none" x-text="result.ranking"></span>
                        <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest mt-1">AI Score</span>
                    </div>
                </div>
            </div>

            {{-- Title --}}
            <div class="text-center mb-6">
                <h2 class="text-xl font-black text-white mb-2 leading-tight" x-text="result.title"></h2>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 rounded-full border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-ping"></span>
                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">ID: <span x-text="result.id"></span></span>
                </div>
            </div>

            {{-- Recommendation --}}
            <div class="space-y-3 mb-6">
                <div class="p-5 bg-green-500/5 rounded-2xl border border-green-500/20">
                    <span class="text-[9px] font-black text-green-500 uppercase block mb-2 tracking-widest">Strategi Penanganan</span>
                    <p class="text-white text-sm font-semibold leading-relaxed" x-text="result.recommendation"></p>
                </div>
                <div class="p-5 bg-slate-950/80 rounded-2xl border border-white/5 flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-500/10 rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-tools-line text-orange-500 text-xl"></i>
                    </div>
                    <div>
                        <span class="text-[9px] font-black text-slate-500 uppercase block mb-1 tracking-widest">Alat Spesifik</span>
                        <p class="text-slate-200 text-xs font-semibold leading-relaxed" x-text="result.tools"></p>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            <button @click="openWA()"
                    class="w-full py-5 bg-green-500 text-slate-950 rounded-2xl font-black uppercase text-[10px] tracking-widest flex items-center justify-center gap-3 hover:bg-green-400 transition-all mb-3">
                <i class="ri-whatsapp-line text-lg"></i>
                Panggil Bantuan Ahli Sekarang
            </button>
            <button @click="showModal=false"
                    class="w-full py-3 text-[9px] font-black text-slate-600 uppercase tracking-widest hover:text-white transition-colors">
                Tutup
            </button>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="container mx-auto px-4 relative z-10">

        {{-- Hero Header --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-full mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-[9px] font-black text-green-500 uppercase tracking-[0.3em]">Deep Diagnostic Pipeline v2.0</span>
            </div>
            <h1 class="text-4xl md:text-7xl font-black text-white leading-[0.9] tracking-tighter italic mb-4">
                Magic <br><span class="bg-gradient-to-r from-green-400 via-orange-400 to-orange-500 bg-clip-text text-transparent">Deep Vision.</span>
            </h1>
            <p class="text-slate-500 text-sm max-w-md mx-auto">Analisis AI multi-sensor untuk mendeteksi jenis sumbatan pipa secara presisi.</p>
        </div>

        {{-- Step Indicator --}}
        <div class="max-w-sm mx-auto mb-8">
            <div class="flex items-center justify-between px-4">
                <template x-for="(s, i) in ['Visual', 'Audio', 'Survey']" :key="i">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-black transition-all duration-300"
                             :class="step >= i ? 'bg-green-500 text-slate-950' : 'bg-slate-800 text-slate-500'">
                            <span x-text="i+1"></span>
                        </div>
                        <span class="text-[8px] font-black uppercase tracking-widest hidden sm:block"
                              :class="step >= i ? 'text-green-500' : 'text-slate-600'"
                              x-text="s"></span>
                        <div x-show="i < 2" class="w-8 h-px ml-2" :class="step > i ? 'bg-green-500' : 'bg-slate-800'"></div>
                    </div>
                </template>
            </div>
        </div>

        {{-- CARD CONTAINER --}}
        <div class="max-w-sm mx-auto">
            <div class="bg-slate-900 rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">

                {{-- === STEP 0: VISION === --}}
                <div x-show="step === 0">
                    <div class="relative aspect-[3/4] bg-black">
                        <video x-ref="video" autoplay playsinline muted
                               class="absolute inset-0 w-full h-full object-cover"
                               :class="cameraOn ? 'opacity-100' : 'opacity-0'"></video>
                        <canvas x-ref="canvas" class="hidden"></canvas>

                        {{-- Camera Not Available Overlay --}}
                        <div x-show="!cameraOn" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-900 p-8 text-center">
                            <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center mb-4">
                                <i class="ri-camera-off-line text-3xl text-slate-600"></i>
                            </div>
                            <p class="text-slate-500 text-xs font-semibold mb-2">Kamera tidak aktif</p>
                            <p class="text-slate-600 text-[10px]">Mode analisis heuristik akan digunakan sebagai ganti</p>
                        </div>

                        {{-- Camera Active HUD --}}
                        <div x-show="cameraOn" class="absolute inset-0 pointer-events-none">
                            <div class="absolute inset-6 border-2 border-green-500/30 rounded-3xl"
                                 :class="scanning ? 'animate-pulse' : ''">
                                <div x-show="scanning" class="absolute left-0 w-full h-0.5 bg-green-500 shadow-lg shadow-green-500/50" style="animation: scanMove 2s infinite linear;"></div>
                            </div>
                            <div class="absolute top-4 left-5">
                                <span class="text-[7px] font-mono text-green-500 uppercase block">CAM: ACTIVE</span>
                                <span class="text-[7px] font-mono text-green-500/60 uppercase block" x-show="scanning">SCANNING...</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <button @click="doVision()"
                                :disabled="scanning"
                                class="w-full py-4 bg-white text-slate-950 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-green-400 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            <span x-text="scanning ? 'Menganalisa...' : 'Analyze Visual'"></span>
                        </button>
                    </div>
                </div>

                {{-- === STEP 1: AUDIO === --}}
                <div x-show="step === 1">
                    <div class="aspect-[3/4] bg-slate-950 flex flex-col items-center justify-center p-10 text-center">
                        <div class="w-28 h-28 rounded-full border-4 border-slate-800 flex items-center justify-center mb-6 relative">
                            <div x-show="recording" class="absolute inset-0 border-4 border-green-500 rounded-full animate-ping opacity-30"></div>
                            <i class="ri-mic-2-line text-5xl" :class="recording ? 'text-green-500' : 'text-slate-700'"></i>
                        </div>
                        <h3 class="text-white font-black uppercase text-xs tracking-widest mb-2">Audio Frequency Capture</h3>
                        <p class="text-slate-500 text-[10px] leading-relaxed">Dekatkan HP ke lubang pipa. AI akan menganalisis frekuensi aliran air.</p>
                        <div class="mt-6 flex gap-1 h-6 items-end">
                            <template x-for="i in 14">
                                <div class="w-1 rounded-full transition-all duration-150"
                                     :style="recording ? 'height:'+Math.floor(Math.random()*100)+'%;background:#22c55e' : 'height:15%;background:#334155'"></div>
                            </template>
                        </div>
                    </div>
                    <div class="p-5">
                        <button @click="doAudio()"
                                :disabled="recording"
                                class="w-full py-4 bg-green-500 text-slate-950 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-green-400 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            <span x-text="recording ? 'Mendengarkan... (2.5s)' : 'Record Frequency'"></span>
                        </button>
                    </div>
                </div>

                {{-- === STEP 2: SURVEY === --}}
                <div x-show="step === 2">
                    <div class="p-6 pb-2 border-b border-white/5">
                        <h3 class="text-white font-black text-xs uppercase tracking-widest">Technical Context Survey</h3>
                        <div class="h-0.5 w-10 bg-green-500 mt-2"></div>
                    </div>
                    <div class="p-6 space-y-6 max-h-[420px] overflow-y-auto">

                        {{-- Lokasi --}}
                        <div x-data="{open:false}" class="relative">
                            <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-2">Lokasi Pipa</p>
                            <button @click="open=!open"
                                    class="w-full bg-white/5 border border-white/5 rounded-xl py-3 px-4 flex items-center justify-between text-white text-[10px] font-bold uppercase hover:bg-white/10 transition-all">
                                <span x-text="survey.location_label || 'Pilih Lokasi...'"></span>
                                <i class="ri-arrow-down-s-line transition-transform" :class="open?'rotate-180':''"></i>
                            </button>
                            <div x-show="open" @click.away="open=false" x-cloak
                                 class="absolute z-50 top-full left-0 right-0 mt-1 bg-slate-800 border border-white/10 rounded-xl overflow-hidden shadow-2xl">
                                <template x-for="loc in locationOpts">
                                    <button @click="survey.location=loc.id; survey.location_label=loc.name; open=false"
                                            class="w-full text-left px-4 py-3 text-[9px] font-bold text-slate-400 uppercase hover:bg-green-500 hover:text-slate-950 transition-colors border-b border-white/5 last:border-0"
                                            x-text="loc.name"></button>
                                </template>
                            </div>
                        </div>

                        {{-- Material --}}
                        <div>
                            <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-2">Material Pipa</p>
                            <div class="grid grid-cols-2 gap-2">
                                <template x-for="m in materialOpts">
                                    <button @click="survey.material=m.id"
                                            :class="survey.material===m.id ? 'bg-green-500 text-slate-950' : 'bg-white/5 text-slate-500 hover:bg-white/10'"
                                            class="py-3 rounded-xl text-[8px] font-black uppercase transition-all"
                                            x-text="m.name"></button>
                                </template>
                            </div>
                        </div>

                        {{-- Sub-context (PVC only) --}}
                        <div x-show="survey.material==='pvc'" class="bg-green-500/5 border border-green-500/15 rounded-xl p-4">
                            <p class="text-[8px] font-black text-green-500 uppercase tracking-widest mb-2">Lokasi Spesifik PVC</p>
                            <div class="space-y-2">
                                <button @click="survey.sub_context='dapur'"
                                        :class="survey.sub_context==='dapur' ? 'bg-green-500 text-slate-950' : 'bg-slate-800 text-slate-400'"
                                        class="w-full py-2.5 rounded-lg text-[8px] font-black uppercase transition-all">Area Dapur / Kitchen Sink</button>
                                <button @click="survey.sub_context='km'"
                                        :class="survey.sub_context==='km' ? 'bg-green-500 text-slate-950' : 'bg-slate-800 text-slate-400'"
                                        class="w-full py-2.5 rounded-lg text-[8px] font-black uppercase transition-all">Kamar Mandi / Floor Drain</button>
                                <button @click="survey.sub_context='talang'"
                                        :class="survey.sub_context==='talang' ? 'bg-green-500 text-slate-950' : 'bg-slate-800 text-slate-400'"
                                        class="w-full py-2.5 rounded-lg text-[8px] font-black uppercase transition-all">Talang Air / Selokan</button>
                            </div>
                        </div>

                        {{-- Frekuensi --}}
                        <div>
                            <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-2">Frekuensi Sumbatan</p>
                            <div class="grid grid-cols-2 gap-2">
                                <template x-for="f in freqOpts">
                                    <button @click="survey.frequency=f.id"
                                            :class="survey.frequency===f.id ? 'bg-orange-500 text-white' : 'bg-white/5 text-slate-500 hover:bg-white/10'"
                                            class="py-3 rounded-xl text-[8px] font-black uppercase transition-all"
                                            x-text="f.name"></button>
                                </template>
                            </div>
                        </div>

                        {{-- Gejala --}}
                        <div>
                            <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-2">Gejala Tambahan</p>
                            <div class="space-y-2">
                                <template x-for="s in symptomOpts">
                                    <label class="flex items-center gap-3 p-3 bg-white/5 border border-white/5 rounded-xl cursor-pointer hover:bg-white/10 transition-all">
                                        <input type="checkbox" :value="s.id" x-model="survey.symptoms"
                                               class="w-4 h-4 rounded accent-green-500">
                                        <span class="text-[8px] font-bold text-slate-400 uppercase" x-text="s.name"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 border-t border-white/5">
                        <button @click="doGenerate()"
                                :disabled="busy"
                                id="btn-generate"
                                class="w-full py-4 bg-orange-500 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-orange-400 disabled:opacity-50 disabled:cursor-not-allowed transition-all flex items-center justify-center gap-2">
                            <i x-show="busy" class="ri-loader-4-line animate-spin"></i>
                            <span x-text="busy ? 'Menghitung...' : 'Generate Deep Diagnostic'"></span>
                        </button>
                    </div>
                </div>

            </div>{{-- end card --}}
        </div>{{-- end max-w-sm --}}
    </div>{{-- end container --}}

    {{-- Processing full-screen overlay --}}
    <div x-show="busy && step === 2"
         x-cloak
         class="fixed inset-0 z-[900] bg-slate-950/80 backdrop-blur-md flex flex-col items-center justify-center pointer-events-none">
        <div class="relative w-20 h-20 mb-5">
            <div class="absolute inset-0 border-4 border-green-500 border-t-transparent rounded-full animate-spin"></div>
            <div class="absolute inset-3 border-4 border-orange-500 border-b-transparent rounded-full" style="animation: spinReverse 0.8s linear infinite;"></div>
        </div>
        <p class="text-white font-black text-sm uppercase tracking-widest">Mengkalkulasi...</p>
        <p class="text-slate-500 text-[10px] mt-1">Neural Fusion Processing</p>
    </div>

</div>{{-- end x-data --}}

<script>
function aiDiag() {
    return {
        step: 0,
        busy: false,
        scanning: false,
        recording: false,
        cameraOn: false,
        showModal: false,
        toast: { show: false, msg: '', type: 'info' },

        visionLabel: '',
        visionScore: 85,
        audioLabel: '',
        audioScore: 0,

        survey: {
            location: '',
            location_label: '',
            material: 'pvc',
            sub_context: '',
            frequency: 'pertama',
            symptoms: []
        },

        result: {
            id: 'RT-PENDING',
            ranking: '?',
            title: '',
            recommendation: '',
            tools: ''
        },

        locationOpts: [
            { id: 'wastafel_dapur', name: 'Wastafel Dapur (Grit/Grease)' },
            { id: 'toilet_closet', name: 'Toilet / Closet (Foreign Object)' },
            { id: 'floor_drain_km', name: 'Floor Drain Kamar Mandi' },
            { id: 'kitchen_main_drain', name: 'Zink / Jalur Utama Dapur' },
            { id: 'external_gutter', name: 'Talang Air / Selokan Luar' }
        ],
        materialOpts: [
            { id: 'pvc', name: 'PVC / Plastik' },
            { id: 'besi', name: 'Besi / Cast Iron' },
            { id: 'fleksibel', name: 'Selang Fleksibel' }
        ],
        freqOpts: [
            { id: 'pertama', name: 'Baru Pertama' },
            { id: 'sering', name: 'Sering Mampet' },
            { id: 'total', name: 'Mampet Total' }
        ],
        symptomOpts: [
            { id: 'bau', name: 'Muncul Bau Tak Sedap' },
            { id: 'kecoa', name: 'Banyak Kecoa/Hama' },
            { id: 'berisik', name: 'Pipa Berbunyi' }
        ],

        async init() {
            await this.startCamera();
        },

        async startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: { ideal: 'environment' } }
                });
                if (this.$refs.video) {
                    this.$refs.video.srcObject = stream;
                    this.cameraOn = true;
                }
            } catch(e) {
                console.warn('Camera blocked:', e.message);
                this.cameraOn = false;
            }
        },

        toast_show(msg, type = 'info') {
            this.toast = { msg, type, show: true };
            setTimeout(() => this.toast.show = false, 3500);
        },

        // STEP 1
        async doVision() {
            this.scanning = true;
            this.toast_show('Menganalisa Visual...', 'info');
            await new Promise(r => setTimeout(r, 2000)); // simulate scan
            this.visionLabel = 'Potential Blockage Detected';
            this.visionScore = 85;
            this.scanning = false;
            this.toast_show('Visual selesai - lanjut Audio!', 'info');
            setTimeout(() => { this.step = 1; }, 600);
        },

        // STEP 2
        async doAudio() {
            this.recording = true;
            this.toast_show('Merekam frekuensi audio...', 'info');
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                await new Promise(r => setTimeout(r, 2500));
                stream.getTracks().forEach(t => t.stop());
                this.audioLabel = 'Turbulent Flow Detected';
                this.audioScore = 72;
            } catch(e) {
                this.audioLabel = 'Silent / No Mic Access';
                this.audioScore = 0;
            }
            this.recording = false;
            this.toast_show('Audio selesai - lengkapi survey!', 'info');
            setTimeout(() => { this.step = 2; }, 400);
        },

        // STEP 3 — CORE
        async doGenerate() {
            if (this.busy) return;
            this.busy = true;
            this.toast_show('Menjalankan Inference Engine...', 'info');

            // Run local inference
            this.runInference();

            try {
                const res = await fetch('{{ route("ai.diagnostic.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        result_label: this.visionLabel || 'General Blockage',
                        confidence_score: parseInt(this.visionScore) || 85,
                        audio_label: this.audioLabel || 'Standard Flow',
                        audio_confidence: parseInt(this.audioScore) || 0,
                        survey_data: this.survey,
                        recommended_tools: this.result.tools || 'Rooter Machine',
                        city_location: 'Auto Detect'
                    })
                });

                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();

                if (data.success) {
                    this.result.id = data.diagnose_id;
                    this.result.ranking = data.deep_ranking;
                }
            } catch(e) {
                console.error('API error:', e.message);
                this.result.id = 'RT-LOCAL-' + Math.floor(Math.random() * 9000 + 1000);
                this.result.ranking = this.visionScore > 80 ? 'A' : 'B';
            }

            this.busy = false;
            this.toast_show('Diagnosis selesai!', 'info');
            setTimeout(() => { this.showModal = true; }, 300);
        },

        runInference() {
            const mat = this.survey.material;
            const ctx = (this.survey.sub_context || this.survey.location || '').toLowerCase();
            let label = 'Sumbatan Umum';
            let tools = 'Rooter Basic Machine';

            if (mat === 'pvc') {
                if (ctx.includes('dapur')) {
                    label = 'Endapan Lemak / Grease FOG';
                    tools = 'Hydro Jetting Medium / Bio-Chemical Cleaning';
                } else if (ctx.includes('km') || ctx.includes('toilet') || ctx.includes('floor')) {
                    label = 'Rambut & Residu Sabun';
                    tools = 'Rooter Spiral Machine / Hair Catcher Removal';
                } else if (ctx.includes('talang') || ctx.includes('gutter')) {
                    label = 'Sampah Daun / Endapan Lumpur';
                    tools = 'High Pressure Water Jetting';
                } else {
                    label = 'Benda Asing (Foreign Object)';
                    tools = 'Rooter K-400 / Retrieval Tool';
                }
            } else if (mat === 'besi') {
                label = 'Korosi & Kerak Mineral';
                tools = 'Heavy Duty Rootercleaner / Descaling Tool';
            } else {
                label = 'Sisa Sabun & Kerak Makanan';
                tools = 'Flexible Snake Tool / Manual Replacement';
            }

            this.result.title = label;
            this.result.recommendation = label;
            this.result.tools = tools;
        },

        openWA() {
            const text = `🚨 *ROOTERIN DEEP DIAGNOSTIC*\n\nID: ${this.result.id}\nRanking: ${this.result.ranking}\nDiagnosa: ${this.result.title}\nAlat: ${this.result.tools}\n\nMohon segera dijadwalkan inspeksi.`;
            window.open(`https://wa.me/6281234567890?text=${encodeURIComponent(text)}`, '_blank');
        }
    }
}
</script>

<style>
[x-cloak] { display: none !important; }
@keyframes scanMove {
    0% { top: 0; opacity: 0; }
    5% { opacity: 1; }
    95% { opacity: 1; }
    100% { top: 100%; opacity: 0; }
}
@keyframes spinReverse {
    from { transform: rotate(0deg); }
    to { transform: rotate(-360deg); }
}
</style>

</x-app-layout>
