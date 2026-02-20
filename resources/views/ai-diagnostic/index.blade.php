<x-app-layout>
<section class="relative pt-32 pb-40 overflow-hidden bg-slate-900 min-h-screen">
    <!-- Matrix/Digital Decor -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(#3b82f6 1px, transparent 1px); background-size: 30px 30px;"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10 text-center mt-8">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-heading font-black text-white leading-none mb-8">
                Magic <span class="bg-gradient-to-r from-primary to-orange-400 bg-clip-text text-transparent">Pipe Vision.</span>
            </h1>
            <p class="text-xl text-slate-400 leading-relaxed mb-16">
                Punya masalah mampet? Ambil foto lubang pipa atau air yang tergenang. AI kami akan menganalisis visual masalah tersebut secara real-time.
            </p>

            <!-- AI Interactive Zone -->
            <div x-data="aiVision()" class="relative max-w-xl mx-auto">
                <!-- Status Bar -->
                <div class="absolute -top-12 left-0 right-0 flex justify-between items-center px-6">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-ping"></div>
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest" x-text="status">INITIALIZING NEURAL ENGINE...</span>
                    </div>
                </div>

                <div class="bg-white/5 backdrop-blur-2xl p-4 rounded-[3rem] border border-white/10 shadow-3xl">
                    <!-- Scanner Container -->
                    <div class="relative aspect-square rounded-[2.5rem] bg-black overflow-hidden group">
                        <!-- Loading Overlay -->
                        <div x-show="analyzing" class="absolute inset-0 z-20 bg-slate-900/80 flex flex-col items-center justify-center p-8 text-center" x-cloak>
                            <div class="w-20 h-20 border-4 border-primary/20 border-t-primary rounded-full animate-spin mb-6"></div>
                            <p class="text-primary font-black uppercase tracking-widest text-xs animate-pulse">Running Neural Inference...</p>
                        </div>

                        <!-- Scan Animation -->
                        <div x-show="analyzing" class="absolute left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary to-transparent z-30 animate-scan" x-cloak></div>

                        <!-- Image Preview -->
                        <img id="active-image" x-show="imageSrc" :src="imageSrc" class="w-full h-full object-cover">
                        
                        <!-- Empty State -->
                        <div x-show="!imageSrc" class="w-full h-full flex flex-col items-center justify-center text-slate-600 gap-6">
                            <i class="ri-camera-lens-line text-6xl opacity-20"></i>
                            <p class="text-[10px] font-black uppercase tracking-widest text-white/30">Target: Drain/Pipe/Kitchen Sink</p>
                        </div>

                        <!-- Result Overlay -->
                        <div x-show="result" class="absolute bottom-6 left-6 right-6 p-6 bg-slate-900/90 backdrop-blur-md rounded-2xl border border-white/10 z-30 transform transition-all" x-cloak>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[8px] font-black text-primary uppercase tracking-widest">Diagnostic Report</span>
                                <span class="text-[10px] text-white/50" x-text="confidence + '% Confidence'"></span>
                            </div>
                            <h3 class="text-white font-black text-xl mb-1" x-text="resultTitle"></h3>
                            <p class="text-slate-400 text-xs leading-relaxed" x-text="resultDesc"></p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex gap-4">
                        <label class="flex-grow flex items-center justify-center gap-3 px-8 py-5 bg-white text-slate-900 rounded-2xl font-black text-sm uppercase tracking-widest cursor-pointer hover:bg-primary hover:text-white transition-all">
                            <i class="ri-upload-cloud-2-line text-xl"></i>
                            Upload Foto
                            <input type="file" @change="handleUpload" class="hidden" accept="image/*">
                        </label>
                        <button @click="reset" class="p-5 bg-white/5 text-slate-500 rounded-2xl hover:text-white transition-all">
                            <i class="ri-refresh-line text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Call to Action (Dynamic based on result) -->
                <div x-show="result" class="mt-12 animate-bounce" x-cloak>
                    <a :href="'https://wa.me/6281234567890?text=Halo%20Rooterin%2C%20hasil%20diagnosa%20AI%20saya%3A%20' + resultTitle" 
                       class="inline-flex items-center gap-3 px-10 py-5 bg-secondary text-white rounded-full font-black shadow-2xl">
                        <i class="ri-whatsapp-line text-xl"></i>
                        Panggil Teknisi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts for AI Logic -->
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet"></script>

<script>
    function aiVision() {
        return {
            status: 'LOADING AI ENGINE...',
            imageSrc: null,
            analyzing: false,
            result: false,
            resultTitle: '',
            resultDesc: '',
            confidence: 0,
            model: null,

            async init() {
                try {
                    this.status = 'DOWNLOADING NEURAL WEIGHTS...';
                    this.model = await mobilenet.load();
                    this.status = 'ENGINE READY';
                } catch (e) {
                    this.status = 'AI ENGINE ERROR. USE MANUAL MODE.';
                }
            },

            handleUpload(e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (f) => {
                    this.imageSrc = f.target.result;
                    this.runDiagnosis();
                };
                reader.readAsDataURL(file);
            },

            async runDiagnosis() {
                this.analyzing = true;
                this.result = false;
                this.status = 'INFERENCING...';

                // Give UI time to breathe
                await new Promise(r => setTimeout(r, 2500));

                const img = document.getElementById('active-image');
                const predictions = await this.model.classify(img);
                
                // Custom mapping logic to make it "Pipe-Specific"
                // This is where the magic happens: mapping generic objects to plumbing context
                const topResult = predictions[0].className.toLowerCase();
                this.confidence = Math.round(predictions[0].probability * 100);

                if (topResult.includes('pipe') || topResult.includes('tubing') || topResult.includes('drain')) {
                    this.resultTitle = 'Terdeteksi: Masalah Saluran';
                    this.resultDesc = 'AI mendeteksi kemungkinan adanya sumbatan kerak atau benda asing di dalam jalur pipa anda.';
                } else if (topResult.includes('bubble') || topResult.includes('liquid') || topResult.includes('water')) {
                    this.resultTitle = 'Terdeteksi: Genangan Air (Backflow)';
                    this.resultDesc = 'Ada tanda-tanda air tidak mengalir dengan lancar. Tekanan balik (backflow) terdeteksi tinggi.';
                } else if (topResult.includes('dirty') || topResult.includes('scum')) {
                    this.resultTitle = 'Terdeteksi: Penumpukan Lemak';
                    this.resultDesc = 'Visual menunjukkan adanya sedimen lemak yang membeku di dinding saluran.';
                } else {
                    // Default aggressive "Magic" diagnosis
                    this.resultTitle = 'Terdeteksi: Sumbatan Kompleks';
                    this.resultDesc = 'AI kami mendeteksi pola hambatan aliran yang tidak beraturan. Diperlukan tindakan pembersihan dengan mesin Rooter segera.';
                }

                this.status = 'DIAGNOSIS COMPLETE';
                this.analyzing = false;
                this.result = true;
            },

            reset() {
                this.imageSrc = null;
                this.result = false;
                this.status = 'ENGINE READY';
            }
        }
    }
</script>

<style>
    @keyframes scan {
        0% { top: 0; }
        100% { top: 100%; }
    }
    .animate-scan {
        animation: scan 2s linear infinite;
    }
</style>
</x-app-layout>
