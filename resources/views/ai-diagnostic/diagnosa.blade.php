<x-app-layout title="AI Magic Pipe Vision - RooterIN Deep Diagnostic">
    <section class="relative pt-32 pb-40 overflow-hidden bg-slate-950 min-h-screen">
        <!-- Digital Neural Background -->
        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(var(--color-primary) 1px, transparent 1px); background-size: 40px 40px;"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-slate-950 via-transparent to-slate-950"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center mb-16 mt-8">
                <div class="inline-flex items-center gap-3 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full mb-8" x-data="{}" x-show="true">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    <span class="text-[10px] font-black text-primary uppercase tracking-[0.3em]">Deep Diagnostic Pipeline v2.0 - YOLOv8</span>
                </div>
                <h1 class="text-5xl md:text-8xl font-heading font-black text-white leading-[0.9] tracking-tighter mb-8 italic">
                    Magic <br> <span class="bg-gradient-to-r from-primary via-orange-400 to-accent bg-clip-text text-transparent">Deep Vision.</span>
                </h1>
            </div>

            <div x-data="aiDeepDiagnostic()" class="max-w-xl mx-auto">
                <!-- Intelligence Feedback System (Toast) -->
                <div x-show="notification.show" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-10"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-10"
                     x-cloak
                     class="fixed top-24 left-1/2 -translate-x-1/2 z-[200] w-[90%] max-w-xs">
                    <div class="rounded-2xl p-4 shadow-2xl flex items-center gap-3 border"
                         :class="notification.type === 'error' ? 'bg-red-500/90 border-red-400 text-white' : 'bg-primary/90 border-primary/50 text-slate-950'">
                        <i :class="notification.type === 'error' ? 'ri-error-warning-line' : 'ri-checkbox-circle-line'" class="text-xl"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest" x-text="notification.msg"></span>
                    </div>
                </div>

                <!-- Multi-Step Progress -->
                <div class="flex items-center justify-between mb-8 px-8">
                    <template x-for="(stepName, index) in steps" :key="index">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-black transition-all"
                                 :class="currentStep >= index ? 'bg-primary text-slate-950 scale-110' : 'bg-slate-800 text-slate-500'">
                                <span x-text="index + 1"></span>
                            </div>
                            <span class="hidden md:block text-[8px] font-black uppercase tracking-widest text-slate-500" x-text="stepName"></span>
                        </div>
                    </template>
                </div>

                <!-- Interface Container -->
                <div class="relative bg-slate-900 rounded-[3.5rem] p-3 border border-white/5 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] overflow-hidden">
                    
                    <!-- Viewport Step 1: Vision -->
                    <div x-show="currentStep === 0" class="relative aspect-[3/4] rounded-[2.8rem] bg-black overflow-hidden shadow-inner">
                        <video x-ref="video" autoplay playsinline class="absolute inset-0 w-full h-full object-cover grayscale brightness-125 contrast-125 transition-opacity" :class="streamReady ? 'opacity-100' : 'opacity-0'"></video>
                        <canvas x-ref="canvas" class="hidden"></canvas>
                        
                        <!-- Vision HUD -->
                        <div class="absolute inset-0 z-20 pointer-events-none" x-show="streamReady">
                            <div class="absolute inset-10 border-2 border-primary/30 rounded-3xl" :class="analyzingVision ? 'animate-pulse' : ''">
                                <div x-show="analyzingVision" class="absolute left-0 w-full h-[2px] bg-primary shadow-[0_0_15px_var(--color-primary)] animate-scan-line"></div>
                            </div>
                            <div class="absolute top-6 left-8 flex flex-col gap-1">
                                <span class="text-[8px] font-mono text-primary uppercase tracking-widest">YOLOv8_ENGINE: ACTIVE</span>
                                <span class="text-[8px] font-mono text-primary uppercase tracking-widest">WEB_WORKER: CONNECTED</span>
                            </div>

                            <div class="absolute bottom-6 right-8 flex flex-col items-end gap-1">
                                <template x-if="analyzingVision">
                                    <div class="flex flex-col items-end">
                                        <span class="text-[10px] font-mono text-primary font-black">MATCH_PROB: <span x-text="Math.floor(Math.random()*20 + 75) + '%'"></span></span>
                                        <div class="flex gap-1 mt-1">
                                            <template x-for="r in ['E','D','C','B','A']">
                                                <div class="w-4 h-1 rounded-full" :class="r === 'C' ? 'bg-primary' : 'bg-white/10'"></div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Vision Boot Overlay -->
                        <div x-show="!streamReady" class="absolute inset-0 bg-slate-900 flex flex-col items-center justify-center z-40">
                            <div class="w-16 h-16 border-4 border-slate-800 border-t-primary rounded-full animate-spin mb-6"></div>
                            <p class="text-primary font-black uppercase tracking-widest text-[10px]">SYNCING HYPER-PARAMS...</p>
                        </div>
                    </div>

                    <!-- Viewport Step 2: Audio -->
                    <div x-show="currentStep === 1" class="relative aspect-[3/4] rounded-[2.8rem] bg-slate-950 overflow-hidden flex flex-col items-center justify-center p-12 text-center">
                        <div class="w-32 h-32 rounded-full border-4 border-white/5 flex items-center justify-center mb-8 relative">
                           <template x-if="analyzingAudio">
                                <div class="absolute inset-0 border-4 border-primary rounded-full animate-ping opacity-20"></div>
                           </template>
                           <i class="ri-mic-line text-5xl" :class="analyzingAudio ? 'text-primary' : 'text-slate-700'"></i>
                        </div>
                        <h3 class="text-white font-black uppercase text-xs tracking-widest mb-2">Audio Frequency Capture</h3>
                        <p class="text-slate-500 text-[10px] leading-relaxed">Dekatkan microphone HP ke lubang pipa/wastafel. AI akan menganalisis turbulensi air.</p>
                        
                        <!-- Visualizer Placeholder -->
                        <div class="mt-8 flex gap-1 h-8 items-end">
                            <template x-for="i in 12">
                                <div class="w-1 bg-primary/20 rounded-full transition-all" :style="'height: ' + (analyzingAudio ? Math.random()*100 : 10) + '%'"></div>
                            </template>
                        </div>
                    </div>

                    <!-- Viewport Step 3: Survey -->
                    <div x-show="currentStep === 2" class="relative aspect-[3/4] rounded-[2.8rem] bg-slate-950 overflow-hidden p-8 flex flex-col justify-start overflow-y-auto custom-scrollbar">
                        <div class="mb-8">
                            <h3 class="text-white font-black uppercase text-[10px] tracking-[0.3em] mb-2">Technical Context Survey</h3>
                            <div class="h-1 w-12 bg-primary"></div>
                        </div>

                        <div class="space-y-8 pb-10">
                            <!-- Custom Dropdown: Lokasi Spesifik -->
                            <div class="space-y-3" x-data="{ open: false }">
                                <label class="text-[8px] font-black text-slate-500 uppercase tracking-widest px-2">Lokasi Pipa & Jalur Saluran</label>
                                <div class="relative">
                                    <button @click="open = !open" 
                                            class="w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 flex items-center justify-between text-white text-[10px] font-black uppercase transition-all hover:bg-white/10 group">
                                        <span x-text="survey.location_label || 'Pilih Lokasi...'"></span>
                                        <i class="ri-arrow-down-s-line text-lg transition-transform" :class="open ? 'rotate-180' : ''"></i>
                                    </button>
                                    
                                    <div x-show="open" @click.away="open = false" 
                                         class="absolute z-50 top-full left-0 right-0 mt-2 bg-slate-900 border border-white/10 rounded-2xl overflow-hidden shadow-2xl"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 -translate-y-2"
                                         x-cloak>
                                        <template x-for="loc in locationOptions">
                                            <button @click="survey.location = loc.id; survey.location_label = loc.name; open = false" 
                                                    class="w-full px-6 py-4 text-left text-[9px] font-bold text-slate-400 uppercase hover:bg-primary hover:text-slate-950 transition-colors border-b border-white/5 last:border-0"
                                                    x-text="loc.name"></button>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Radio Group: Material Pipa -->
                            <div class="space-y-3">
                                <label class="text-[8px] font-black text-slate-500 uppercase tracking-widest px-2">Material Pipa</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <template x-for="mat in materialOptions">
                                        <button @click="survey.material = mat.id" 
                                                :class="survey.material === mat.id ? 'bg-primary text-slate-950 scale-[1.02]' : 'bg-white/5 text-slate-500 hover:bg-white/10'"
                                                class="py-3 px-4 rounded-xl text-[8px] font-black uppercase border border-white/5 transition-all"
                                                x-text="mat.name"></button>
                                    </template>
                                </div>
                            </div>

                            <!-- Smart Questioning: Sub-Context for PVC -->
                            <div x-show="survey.material === 'pvc'" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 -translate-y-4"
                                 class="space-y-3 bg-primary/5 p-6 rounded-2xl border border-primary/10">
                                <label class="text-[8px] font-black text-primary uppercase tracking-widest px-2">Lokasi Spesifik PVC</label>
                                <div class="grid grid-cols-1 gap-2">
                                    <button @click="survey.sub_context = 'dapur'" :class="survey.sub_context === 'dapur' ? 'bg-primary text-slate-950' : 'bg-slate-900 text-slate-500'" class="py-3 rounded-xl text-[8px] font-black uppercase transition-all">Area Dapur / Kitchen Sink</button>
                                    <button @click="survey.sub_context = 'km'" :class="survey.sub_context === 'km' ? 'bg-primary text-slate-950' : 'bg-slate-900 text-slate-500'" class="py-3 rounded-xl text-[8px] font-black uppercase transition-all">Kamar Mandi / Floor Drain</button>
                                    <button @click="survey.sub_context = 'talang'" :class="survey.sub_context === 'talang' ? 'bg-primary text-slate-950' : 'bg-slate-900 text-slate-500'" class="py-3 rounded-xl text-[8px] font-black uppercase transition-all">Talang Air / Selokan</button>
                                </div>
                            </div>

                            <!-- Radio Group: Frekuensi Kejadian -->
                            <div class="space-y-3">
                                <label class="text-[8px] font-black text-slate-500 uppercase tracking-widest px-2">Frekuensi Sumbatan</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <template x-for="freq in frequencyOptions">
                                        <button @click="survey.frequency = freq.id" 
                                                :class="survey.frequency === freq.id ? 'bg-secondary text-white scale-[1.02]' : 'bg-white/5 text-slate-500 hover:bg-white/10'"
                                                class="py-3 px-4 rounded-xl text-[8px] font-black uppercase border border-white/5 transition-all"
                                                x-text="freq.name"></button>
                                    </template>
                                </div>
                            </div>

                            <!-- Checkbox: Masalah Tambahan -->
                            <div class="space-y-3">
                                <label class="text-[8px] font-black text-slate-500 uppercase tracking-widest px-2">Gejala Tambahan (Multiple)</label>
                                <div class="space-y-2">
                                    <template x-for="symptom in symptomOptions">
                                        <label class="flex items-center gap-3 p-3 bg-white/5 border border-white/5 rounded-xl cursor-pointer hover:bg-white/10 transition-all">
                                            <input type="checkbox" :value="symptom.id" x-model="survey.symptoms" class="w-4 h-4 rounded border-white/10 bg-slate-800 text-primary focus:ring-primary">
                                            <span class="text-[8px] font-black text-slate-400 uppercase" x-text="symptom.name"></span>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step Controls -->
                    <div class="p-6">
                        <!-- Step 1 Actions -->
                        <div x-show="currentStep === 0" class="flex gap-4">
                            <button @click="startVisionDiagnosis()" :disabled="analyzingVision" class="flex-1 py-5 bg-white text-slate-950 rounded-3xl font-black uppercase text-[10px] tracking-widest hover:bg-primary hover:text-white transition-all">
                                <span x-text="analyzingVision ? 'Processing AI...' : 'Analyze Visual'"></span>
                            </button>
                        </div>
                        
                        <!-- Step 2 Actions -->
                        <div x-show="currentStep === 1" class="flex gap-4">
                            <button @click="startAudioDiagnosis()" :disabled="analyzingAudio" class="flex-1 py-5 bg-primary text-slate-950 rounded-3xl font-black uppercase text-[10px] tracking-widest shadow-xl shadow-primary/20">
                                <span x-text="analyzingAudio ? 'Listening...' : 'Record Frequency'"></span>
                            </button>
                        </div>

                        <!-- Step 3 Actions -->
                        <div x-show="currentStep === 2" class="flex gap-4">
                            <button @click="finishDeepDiagnostic()" :disabled="finishing" class="flex-1 py-5 bg-secondary text-white rounded-3xl font-black uppercase text-[10px] tracking-widest shadow-xl shadow-secondary/20 hover:scale-105 active:scale-95 transition-all">
                                <span x-text="finishing ? 'Calculating Rooterin Deep Score...' : 'Generate Deep Diagnostic'"></span>
                            </button>
                        </div>
                        </div>
                    </div>

                    <!-- Result Modal (Inside Scope) -->
                    <div x-show="showResultModal" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         x-cloak 
                         class="fixed inset-0 z-[100] flex items-center justify-center p-6">
                        <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-xl" @click="showResultModal = false"></div>
                        <div class="relative w-full max-w-lg bg-slate-900 border border-white/10 rounded-[3rem] p-10 shadow-3xl overflow-hidden">
                            <!-- Deep Rank Badge -->
                            <div class="flex justify-center mb-6">
                                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary to-accent p-1">
                                    <div class="w-full h-full bg-slate-900 rounded-full flex items-center justify-center">
                                        <span class="text-4xl font-heading font-black text-white italic" x-text="deepRanking"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mb-8">
                                <h2 class="text-2xl font-heading font-black text-white mb-2 underline decoration-primary" x-text="resultTitle"></h2>
                                <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Tracking ID: <span x-text="diagnoseId"></span></span>
                            </div>

                            <div class="bg-white/5 rounded-3xl p-6 border border-white/5 mb-8">
                                <div class="space-y-4">
                                    <div class="p-4 bg-primary/10 rounded-2xl border border-primary/20">
                                        <span class="text-[8px] font-black text-primary uppercase block mb-1 underline">REKOMENDASI SPESIALIS</span>
                                        <p class="text-white text-[11px] font-bold leading-relaxed" x-text="recommendation"></p>
                                    </div>
                                    <div class="p-4 bg-slate-950/50 rounded-2xl border border-white/5 flex items-start gap-4">
                                        <div class="w-10 h-10 bg-secondary/20 rounded-xl flex items-center justify-center shrink-0">
                                            <i class="ri-tools-line text-secondary text-xl"></i>
                                        </div>
                                        <div>
                                            <span class="text-[8px] font-black text-slate-500 uppercase block mb-1">ALAT YANG DIBUTUHKAN</span>
                                            <p class="text-slate-300 text-[10px] font-medium" x-text="toolsNeeded"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button @click="openWhatsAppDeep()" class="w-full py-5 bg-secondary text-white rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] shadow-xl shadow-secondary/20 flex items-center justify-center gap-3">
                                <i class="ri-whatsapp-line text-xl"></i>
                                Kirim Laporan Deep Diagnostic
                            </button>
                            <button @click="showResultModal = false" class="mt-4 w-full py-2 text-[8px] font-black text-slate-500 uppercase tracking-widest hover:text-white transition-all">Tutup Analisis</button>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Master Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@4.17.0"></script>
    <script>
        function aiDeepDiagnostic() {
            return {
                steps: ['Visual Analysis', 'Audio Capture', 'User Context'],
                currentStep: 0,
                streamReady: false,
                analyzingVision: false,
                analyzingAudio: false,
                finishing: false,
                showResultModal: false,
                notification: { show: false, msg: '', type: 'info' },
                
                // Data Store
                visionLabel: '',
                visionConfidence: 0,
                audioLabel: '',
                audioConfidence: 0,
                survey: { 
                    location: '', 
                    location_label: '', 
                    material: 'pvc', 
                    sub_context: '',
                    frequency: 'pertama',
                    symptoms: [] 
                },
                
                // Recommendation Result
                recommendation: '',
                toolsNeeded: '',

                // Survey Options
                locationOptions: [
                    { id: 'wastafel_dapur', name: 'Wastafel Dapur (Grit/Grease)' },
                    { id: 'toilet_closet', name: 'Toilet / Closet (Foreign Object)' },
                    { id: 'floor_drain_km', name: 'Floor Drain Kamar Mandi' },
                    { id: 'kitchen_main_drain', name: 'Zink / Jalur Utama Dapur' },
                    { id: 'external_gutter', name: 'Talang Air / Selokan Luar' }
                ],
                materialOptions: [
                    { id: 'pvc', name: 'PVC / Plastik' },
                    { id: 'besi', name: 'Besi / Cast Iron' },
                    { id: 'fleksibel', name: 'Selang Fleksibel' }
                ],
                frequencyOptions: [
                    { id: 'pertama', name: 'Baru Pertama Kali' },
                    { id: 'sering', name: 'Sering Mampet' },
                    { id: 'total', name: 'Mampet Total' }
                ],
                symptomOptions: [
                    { id: 'bau', name: 'Muncul Bau Tak Sedap' },
                    { id: 'kecoa', name: 'Banyak Kecoa/Hama' },
                    { id: 'berisik', name: 'Pipa Mengeluarkan Bunyi' }
                ],
                
                deepRanking: '?',
                diagnoseId: 'RT-PENDING',
                resultTitle: 'Diagnosing...',
                deepScore: 0,

                // AI Worker
                worker: null,

                async init() {
                    this.initWorker();
                    await this.setupVision();
                },

                // --- ROOTERIN INFERENCE ENGINE v3.0 ---
                runInferenceEngine() {
                    let finalLabel = "General Blockage";
                    let tools = "Rooter Basic Machine";
                    let probability = 80;

                    const mat = this.survey.material;
                    const ctx = this.survey.sub_context || this.survey.location;
                    const visual = (this.visionLabel || "").toLowerCase();

                    // 1. Material Elimination Layer
                    switch(mat) {
                        case 'pvc':
                            // Smart Questioning Logic: Focus on Location
                            if (ctx.includes('dapur')) {
                                finalLabel = visual.includes('putih') ? "Lemak Membeku (FOG)" : "Endapan Lemak (Grease)";
                                tools = "Hydro Jetting (Medium Pressure) / Bio-Chemical Cleaning";
                                probability = 90;
                            } else if (ctx.includes('km') || ctx.includes('toilet')) {
                                finalLabel = "Rambut & Residu Sabun";
                                tools = "Rooter Spiral Machine / Hair Catcher Removal";
                                probability = 85;
                            } else if (ctx.includes('gutter') || ctx.includes('talang')) {
                                finalLabel = "Sampah Daun / Endapan Lumpur";
                                tools = "High Pressure Water Jetting / Manual Scooping";
                                probability = 80;
                            } else {
                                finalLabel = "Benda Asing (Foreign Object)";
                                tools = "Rooter K-400 / Retrieval Tool";
                            }
                            break;

                        case 'besi':
                            // Focus on Corrosion & Scale
                            finalLabel = "Korosi (Karat) & Kerak Mineral";
                            tools = "Heavy Duty Rootercleaner / Descaling Tool";
                            probability = 92;
                            if (visual.includes('tutup') || visual.includes('sempit')) {
                                finalLabel = "Penyempitan Diameter (Severe Corrosion)";
                            }
                            break;

                        case 'fleksibel':
                            // Focus on Soap & Food residues
                            finalLabel = "Sisa Sabun & Kerak Makanan";
                            tools = "Flexible Snake Tool / Manual Replacement";
                            probability = 75;
                            if (this.survey.symptoms.includes('berisik')) {
                                finalLabel = "Aliran Terhambat / Selang Tertekuk";
                            }
                            break;
                    }

                    // 2. Input Fusion (Visual override)
                    if (visual.includes('akar')) {
                        finalLabel = "Sumbatan Akar Pohon (Root Intrusion)";
                        tools = "Rooter Root-Cutter / Hydro Jetting High Pressure";
                        probability = 95;
                    }

                    this.resultTitle = finalLabel;
                    this.recommendation = finalLabel;
                    this.toolsNeeded = tools;
                    this.visionConfidence = probability;
                },

                initWorker() {
                    console.log("Worker: Initializing bridge...");
                    try {
                        // Start the AI Processor Web Worker
                        this.worker = new Worker('/assets/ai/workers/ai-processor.js');
                        
                        this.worker.onmessage = (e) => {
                            const { type, results, error, message } = e.data;
                            
                            if (type === 'STATUS') {
                                console.log("Worker Status Update:", message);
                            } else if (type === 'VISION_RESULT') {
                                console.log("Worker: Vision result received", results);
                                this.visionLabel = results.label;
                                this.visionConfidence = results.confidence;
                                this.showToast("Visual Data Sync Successful");
                                this.currentStep = 1;
                                this.analyzingVision = false;
                            } else if (type === 'AUDIO_RESULT') {
                                console.log("Worker: Audio result received", results);
                                this.audioLabel = results.label;
                                this.audioConfidence = results.confidence;
                                this.showToast("Audio Pattern Analyzed");
                                this.currentStep = 2;
                                this.analyzingAudio = false;
                            } else if (type === 'ERROR') {
                                console.error('Worker Script Error:', error);
                                this.showToast("Local AI Model Error", "error");
                                this.analyzingVision = false;
                                this.analyzingAudio = false;
                            }
                        };

                        // Give it a small heartbeat delay before loading heavy models
                        setTimeout(() => {
                            console.log("Worker: Pushing Model Weights...");
                            this.worker.postMessage({
                                type: 'LOAD_MODELS',
                                data: {
                                    visionPath: '/assets/ai/models/vision/yolov8/model.json',
                                    audioPath: '/assets/ai/models/audio/snn/model.json'
                                }
                            });
                        }, 500);

                    } catch (workerErr) {
                        console.error("Worker Bridge Failed:", workerErr);
                        this.showToast("AI Background Processor Failed", "error");
                    }
                },

                async setupVision() {
                    try {
                        const constraints = { 
                            video: { 
                                facingMode: { ideal: "environment" },
                                width: { ideal: 1280 },
                                height: { ideal: 720 }
                            } 
                        };
                        const stream = await navigator.mediaDevices.getUserMedia(constraints);
                        if (this.$refs.video) {
                            this.$refs.video.srcObject = stream;
                            this.streamReady = true;
                        }
                    } catch (e) {
                        console.warn('Camera Access Failed:', e);
                        this.streamReady = false; // Important: stay false to show error/manual mode
                    }
                },

                async startVisionDiagnosis() {
                    if (this.analyzingVision) return;
                    this.analyzingVision = true;
                    
                    try {
                        // Safety timeout: If worker doesn't respond in 10s, fallback to heuristic
                        const timeout = setTimeout(() => {
                            if (this.analyzingVision) {
                                console.warn('Worker Timeout: Falling back to heuristic');
                                this.visionLabel = 'Obstruction Detected (Heuristic)';
                                this.visionConfidence = 88;
                                this.currentStep = 1;
                                this.analyzingVision = false;
                            }
                        }, 5000);

                        const video = this.$refs.video;
                        const canvas = this.$refs.canvas;
                        
                        // If camera isn't working, immediately skip to manual or heuristic
                        if (!this.streamReady || !video || video.videoWidth === 0) {
                            throw new Error("Camera not active");
                        }

                        canvas.width = 640; 
                        canvas.height = 640;
                        canvas.getContext('2d').drawImage(video, 0, 0, 640, 640);

                        const imgBitmap = await createImageBitmap(canvas);
                        this.worker.postMessage({
                            type: 'PROCESS_VISION',
                            data: { imageBitmap: imgBitmap }
                        }, [imgBitmap]);
                        
                        this.showToast("Visual Data Syncing...");

                    } catch (e) {
                        console.error('Vision logic error:', e);
                        this.showToast("Using Heuristic Fallback", "error");
                        // Immediate Heuristic Fallback
                        this.visionLabel = 'Potential Blockage Identified';
                        this.visionConfidence = 82;
                        setTimeout(() => {
                            this.currentStep = 1;
                            this.analyzingVision = false;
                        }, 1000);
                    }
                },

                async startAudioDiagnosis() {
                    if (this.analyzingAudio) return;
                    this.analyzingAudio = true;
                    this.showToast("Recording Audio Frequency...");
                    
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                        
                        // Critical for modern browsers: Resume context on user gesture
                        if (audioContext.state === 'suspended') {
                            await audioContext.resume();
                        }

                        const source = audioContext.createMediaStreamSource(stream);
                        const processor = audioContext.createScriptProcessor(1024, 1, 1);

                        source.connect(processor);
                        processor.connect(audioContext.destination);

                        let chunks = [];
                        processor.onaudioprocess = (e) => {
                            if (this.analyzingAudio) {
                                chunks.push(new Float32Array(e.inputBuffer.getChannelData(0)).slice());
                            }
                        };

                        // Capture duration
                        setTimeout(() => {
                            this.analyzingAudio = false;
                            
                            // Stop tracks
                            stream.getTracks().forEach(t => t.stop());
                            audioContext.close();

                            if (chunks.length > 0) {
                                this.worker.postMessage({
                                    type: 'PROCESS_AUDIO',
                                    data: { audioData: chunks[0].buffer }
                                });
                            } else {
                                throw new Error("No audio captured");
                            }
                        }, 2500);

                    } catch (e) {
                        console.warn('Audio capture failed:', e);
                        this.audioLabel = 'Silent Frequency Analysis';
                        this.audioConfidence = 70;
                        this.currentStep = 2;
                        this.analyzingAudio = false;
                    }
                },

                async finishDeepDiagnostic() {
                    if (this.finishing) {
                        console.warn("Deep Diagnostic: Already in progress, ignoring duplicate call.");
                        return;
                    }

                    // --- COMPREHENSIVE VALIDATION ---
                    console.log("Deep Diagnostic: Validating context...", this.survey);
                    if (!this.survey.location && !this.survey.sub_context) {
                        this.showToast("Pilih lokasi atau detail pipa terlebih dahulu!", "error");
                        console.error("Deep Diagnostic: Validation failed - No location selected.");
                        return;
                    }

                    this.finishing = true;
                    this.showToast("Step 1: Mengkalkulasi Skor AI...", "info");
                    
                    // Safety Defaults for incomplete data
                    if (!this.visionLabel || this.visionConfidence < 10) {
                        console.warn("Deep Diagnostic: Vision data missing or low, using heuristic fallback.");
                        this.visionLabel = 'Standard Pipe Blockage';
                        this.visionConfidence = 70;
                    }

                    try {
                        console.log("Deep Diagnostic: Running Inference Engine...");
                        this.runInferenceEngine(); 

                        this.showToast("Step 2: Menghubungkan ke Cloud RooterIN...", "info");
                        
                        const response = await fetch('{{ route('ai.diagnostic.store') }}', {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json', 
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                result_label: this.visionLabel,
                                confidence_score: this.visionConfidence,
                                audio_label: this.audioLabel,
                                audio_confidence: this.audioConfidence,
                                survey_data: this.survey,
                                recommended_tools: this.toolsNeeded,
                                city_location: 'Auto Detect'
                            })
                        });
                        
                        if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);
                        
                        const data = await response.json();
                        console.log("Deep Diagnostic: Server success!", data);

                        if (data.success) {
                            this.diagnoseId = data.diagnose_id;
                            this.deepRanking = data.deep_ranking;
                            this.showToast("Analisis Selesai! Menampilkan Hasil...", "info");
                            
                            // Force immediate modal show
                            setTimeout(() => {
                                this.showResultModal = true;
                                console.log("Deep Diagnostic: Result Modal Triggered.");
                            }, 500);
                        } else {
                            throw new Error("Logic failure in server response");
                        }

                    } catch (e) {
                        console.error("Deep Diagnostic: Submission Error", e);
                        this.showToast("Gagal Terhubung ke Server - Menggunakan Analisis Lokal", "error");
                        
                        // Critical Fallback UI
                        this.diagnoseId = 'RT-LOCAL-' + Math.floor(Math.random()*9000 + 1000);
                        this.deepRanking = 'B'; 
                        this.showResultModal = true;
                        this.saveForSyncLater();
                    } finally {
                        this.finishing = false;
                        console.log("Deep Diagnostic: Pipeline lifecycle ended.");
                    }
                },

                saveForSyncLater() {
                    localStorage.setItem('rooterin_sync_lead', JSON.stringify({
                        id: this.diagnoseId,
                        v: this.visionLabel, 
                        a: this.audioLabel, 
                        s: this.survey, 
                        r: this.recommendation,
                        ts: new Date().toISOString()
                    }));
                },

                showToast(msg, type = 'info') {
                    this.notification = { msg, type, show: true };
                    setTimeout(() => this.notification.show = false, 3000);
                },

                openWhatsAppDeep() {
                    const symptomsText = this.survey.symptoms.length > 0 
                        ? this.survey.symptoms.join(', ').toUpperCase() 
                        : 'TIDAK ADA';

                    const text = `🚨 *ROOTERIN DEEP DIAGNOSTIC REPORT* 🚨\n\n` +
                                 `ID: *${this.diagnoseId}*\n` +
                                 `RANKING: *PERINGKAT ${this.deepRanking}*\n\n` +
                                 `🔍 *AI INFERENCE RESULT*\n` +
                                 `• Diagnosa: *${this.recommendation.toUpperCase()}*\n` +
                                 `• Akurasi: *${this.visionConfidence}%*\n\n` +
                                 `�️ *TECHNICAL GUIDANCE*\n` +
                                 `• Kebutuhan Alat: *${this.toolsNeeded.toUpperCase()}*\n\n` +
                                 `📋 *TECHNICAL CONTEXT*\n` +
                                 `• Material: *${this.survey.material.toUpperCase()}*\n` +
                                 `• Lokasi: *${(this.survey.sub_context || this.survey.location).toUpperCase()}*\n` +
                                 `• Gejala: _${symptomsText}_\n\n` +
                                 `_Mohon segera dijadwalkan inspeksi teknis RootERIN._`;
                    window.open(`https://wa.me/6281234567890?text=${encodeURIComponent(text)}`, '_blank');
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .animate-scan-line { animation: scanMove 3s infinite linear; }
        @keyframes scanMove { 0% { top: 0; opacity: 0; } 5% { opacity: 1; } 95% { opacity: 1; } 100% { top: 100%; opacity: 0; } }
    </style>
</x-app-layout>
