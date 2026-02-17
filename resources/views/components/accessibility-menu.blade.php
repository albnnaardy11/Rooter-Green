<div x-data="accessibilityMenu()" 
     class="fixed bottom-6 z-[100] transition-all duration-500"
     :class="window.innerWidth < 640 ? 'right-6' : 'left-6'"
     id="accessibility-container">
    
    <!-- Toggle Button -->
    <button @click="open = !open" 
            class="w-14 h-14 rounded-full bg-secondary text-white shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all group relative overflow-hidden">
        <div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-20 transition-opacity"></div>
        <i class="ri-accessibility-fill text-2xl transition-transform duration-500" :class="open ? 'rotate-180' : ''"></i>
    </button>

    <!-- Accessibility Panel -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-90"
         class="absolute bottom-20 w-[90vw] sm:w-[400px] max-h-[80vh] bg-white rounded-[2.5rem] shadow-[0_20px_60px_rgba(0,0,0,0.15)] flex flex-col overflow-hidden border border-gray-100"
         :style="window.innerWidth < 640 ? 'right: 0' : 'left: 0'">
        
        <!-- Header -->
        <div class="bg-secondary p-8 flex items-center justify-between">
            <div class="flex items-center gap-4 text-white">
                <i class="ri-accessibility-fill text-lg text-primary"></i>
                <h3 class="font-black text-xs uppercase tracking-[0.3em]">Aksesibilitas Pro</h3>
            </div>
            <button @click="open = false" class="text-white/40 hover:text-white transition-colors">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-8 custom-scrollbar space-y-12">
            
            <!-- Panduan Pengguna Link -->
            <a href="{{ route('accessibility-guide') }}" class="relative overflow-hidden flex items-center justify-between p-5 bg-gradient-to-br from-secondary via-secondary to-[#1a2533] rounded-2xl shadow-lg group hover:scale-[1.02] transition-all duration-300 border border-white/10">
                <!-- Decorative BG -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
                
                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-sm border border-white/5">
                        <i class="ri-book-open-line text-white text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-black text-[10px] uppercase tracking-widest mb-0.5">Panduan Pengguna</h4>
                        <p class="text-white/50 text-[9px] font-medium">Cara menggunakan fitur ini</p>
                    </div>
                </div>
                
                <div class="relative z-10 w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shadow-lg group-hover:bg-white group-hover:text-secondary transition-colors">
                    <i class="ri-arrow-right-line group-hover:translate-x-0.5 transition-transform"></i>
                </div>
            </a>

            <!-- Profil Cerdas (Presets) -->
            <div>
                <h4 class="text-gray-400 font-black text-[9px] uppercase tracking-[0.3em] mb-6">Profil Cerdas (Presets)</h4>
                <div class="grid grid-cols-2 gap-3">
                    <template x-for="preset in presets" :key="preset.id">
                        <button @click="togglePreset(preset.id)"
                                :class="settings.preset === preset.id ? 'bg-secondary text-white shadow-xl rotate-1' : 'bg-white border-gray-100 text-gray-400 hover:border-gray-200'"
                                class="flex flex-col items-center p-6 rounded-2xl border transition-all duration-300 group">
                            <i :class="preset.icon" class="text-xl mb-3 transition-transform group-hover:scale-110"></i>
                            <span class="text-[9px] font-black uppercase tracking-widest text-center" x-text="preset.label"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Ukuran Teks (4 Levels) -->
            <div>
                <h4 class="text-gray-400 font-black text-[9px] uppercase tracking-[0.3em] mb-6">Ukuran Teks</h4>
                <div class="grid grid-cols-4 gap-2 bg-stone-50 p-2 rounded-2xl border border-gray-100">
                    <button @click="setTextSize(0)" 
                            :class="settings.textSize === 0 ? 'bg-white text-secondary shadow-md font-bold' : 'text-gray-400 hover:bg-white/50'"
                            class="py-3 rounded-xl text-[10px] uppercase tracking-widest transition-all">
                        Small
                    </button>
                    <button @click="setTextSize(1)" 
                            :class="settings.textSize === 1 ? 'bg-white text-secondary shadow-md font-bold' : 'text-gray-400 hover:bg-white/50'"
                            class="py-3 rounded-xl text-[10px] uppercase tracking-widest transition-all">
                        Med
                    </button>
                    <button @click="setTextSize(2)" 
                            :class="settings.textSize === 2 ? 'bg-white text-secondary shadow-md font-bold' : 'text-gray-400 hover:bg-white/50'"
                            class="py-3 rounded-xl text-[10px] uppercase tracking-widest transition-all">
                        Semi
                    </button>
                    <button @click="setTextSize(3)" 
                            :class="settings.textSize === 3 ? 'bg-white text-secondary shadow-md font-bold' : 'text-gray-400 hover:bg-white/50'"
                            class="py-3 rounded-xl text-[10px] uppercase tracking-widest transition-all">
                        Large
                    </button>
                </div>
            </div>

            <!-- Penyesuaian Konten -->
            <div>
                <h4 class="text-gray-400 font-black text-[9px] uppercase tracking-[0.3em] mb-6">Penyesuaian Konten</h4>
                <div class="grid grid-cols-3 gap-3">
                    <template x-for="opt in contentOpts" :key="opt.id">
                        <button @click="toggleOption(opt.id)"
                                :class="settings[opt.id] ? 'bg-secondary text-white border-secondary' : 'bg-white border-gray-100 text-gray-400'"
                                class="flex flex-col items-center justify-center p-4 h-24 rounded-2xl border transition-all">
                            <i x-show="opt.icon" :class="opt.icon" class="text-xl mb-2"></i>
                            <span x-show="opt.text" class="text-lg font-black leading-none mb-1" x-text="opt.text"></span>
                            <span class="text-[8px] font-black uppercase tracking-widest" x-text="opt.label"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Warna & Tampilan -->
            <div>
                <h4 class="text-gray-400 font-black text-[9px] uppercase tracking-[0.3em] mb-6">Warna & Tampilan</h4>
                <div class="grid grid-cols-2 gap-3">
                    <template x-for="opt in visualOpts" :key="opt.id">
                        <button @click="toggleOption(opt.id)"
                                :class="settings[opt.id] ? 'bg-secondary text-white border-secondary' : 'bg-white border-gray-100 text-gray-400'"
                                class="flex flex-col items-center p-6 rounded-2xl border transition-all">
                            <i :class="opt.icon" class="text-xl mb-3"></i>
                            <span class="text-[9px] font-black uppercase tracking-widest" x-text="opt.label"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Alat Bantu -->
            <div>
                <h4 class="text-gray-400 font-black text-[9px] uppercase tracking-[0.3em] mb-6">Alat Bantu</h4>
                <div class="space-y-3">
                    <button @click="toggleOption('tts')"
                            :class="settings.tts ? 'bg-secondary text-white' : 'bg-white border-gray-100 text-gray-400'"
                            class="w-full flex flex-col items-center gap-2 p-4 rounded-2xl border transition-all">
                        <div class="flex items-center gap-3">
                            <i class="ri-volume-up-fill text-lg"></i>
                            <span class="text-[8px] font-black uppercase tracking-widest">Suara (TTS)</span>
                        </div>
                        <span x-show="settings.tts" class="text-[9px] text-white/80 font-medium animate-pulse">
                            (Sorot / Blok teks untuk mendengarkan)
                        </span>
                    </button>
                </div>
            </div>

            <!-- Reset Button -->
            <button @click="reset()" class="w-full py-5 bg-stone-100 rounded-2xl text-gray-500 font-black text-[10px] uppercase tracking-[0.2em] hover:bg-red-50 hover:text-red-500 transition-all flex items-center justify-center gap-3">
                <i class="ri-restart-line text-lg animate-spin-slow"></i>
                Reset Pengaturan
            </button>
        </div>
    </div>
</div>

<script>
function accessibilityMenu() {
    return {
        open: false,
        mouseY: 0,
        ttsHandler: null,
        settings: {
            preset: null,
            textSize: 0,
            spacing: false,
            links: false,
            dyslexia: false,
            cursor: false,
            grayscale: false,
            highContrast: false,
            neonMode: false,
            hideImages: false,
            stopAnim: false,
            tts: false
        },
        presets: [
            { id: 'epilepsy', label: 'Aman Epilepsi', icon: 'ri-skull-line' },
            { id: 'visual', label: 'Gangguan Visual', icon: 'ri-eye-off-line' },
            { id: 'adhd', label: 'Fokus ADHD', icon: 'ri-mind-map' },
            { id: 'senior', label: 'Lansia Friendly', icon: 'ri-parent-line' }
        ],
        contentOpts: [
            { id: 'spacing', label: 'Spasi', icon: 'ri-text-spacing' },
            { id: 'links', label: 'Links', icon: 'ri-links-line' },
            { id: 'dyslexia', label: 'Dyslexia', text: 'DF' },
            { id: 'cursor', label: 'Kursor', icon: 'ri-cursor-fill' }
        ],
        visualOpts: [
            { id: 'grayscale', label: 'Grayscale', icon: 'ri-contrast-drop-2-line' },
            { id: 'highContrast', label: 'High Contrast', icon: 'ri-contrast-line' },
            { id: 'neonMode', label: 'Neon Mode', icon: 'ri-flashlight-line' },
            { id: 'hideImages', label: 'Sembunyi Gambar', icon: 'ri-image-off-line' },
            { id: 'stopAnim', label: 'Stop Animasi', icon: 'ri-play-line' }
        ],
        init() {
            // Load settings from localStorage
            const saved = localStorage.getItem('rooter_accessibility');
            if (saved) this.settings = JSON.parse(saved);
            
            this.applyAll();

            window.addEventListener('mousemove', (e) => {
                this.mouseY = e.clientY;
            });

            // Clean up TTS when leaving page
            window.addEventListener('beforeunload', () => {
                if (window.speechSynthesis) window.speechSynthesis.cancel();
            });
        },
        togglePreset(id) {
            this.settings.preset = (this.settings.preset === id) ? null : id;
            this.applyAll();
        },
        setTextSize(level) {
            this.settings.textSize = level;
            this.applyAll();
        },
        toggleOption(id) {
            this.settings[id] = !this.settings[id];
            
            this.applyAll();

            // Audio Feedback for TTS Activation
            if (id === 'tts' && this.settings.tts) {
                this.speak('Fitur Suara aktif. Silakan sorot teks untuk mendengarkan.');
            }
        },
        applyAll() {
            const body = document.body;
            const content = document.getElementById('site-content');
            
            // Clean up previous classes
            if (content) {
                content.classList.remove('acc-grayscale', 'acc-contrast', 'acc-neon', 'acc-hide-img');
            }
            body.classList.remove('acc-epilepsy', 'acc-visual', 'acc-adhd', 'acc-senior', 
                                'acc-text-1', 'acc-text-2', 'acc-text-3', 'acc-spacing', 'acc-links', 
                                'acc-dyslexia', 'acc-cursor', 'acc-stop-anim');

            // Apply global settings (Body)
            if (this.settings.preset) body.classList.add('acc-' + this.settings.preset);
            if (this.settings.textSize > 0) body.classList.add('acc-text-' + this.settings.textSize);
            if (this.settings.spacing) body.classList.add('acc-spacing');
            if (this.settings.links) body.classList.add('acc-links');
            if (this.settings.dyslexia) body.classList.add('acc-dyslexia');
            if (this.settings.cursor) body.classList.add('acc-cursor');
            if (this.settings.stopAnim) body.classList.add('acc-stop-anim');

            // Apply visual filters (Content Wrapper Only) to avoid breaking fixed positioning
            if (content) {
                if (this.settings.grayscale) content.classList.add('acc-grayscale');
                if (this.settings.highContrast) content.classList.add('acc-contrast');
                if (this.settings.neonMode) content.classList.add('acc-neon');
                if (this.settings.hideImages) content.classList.add('acc-hide-img');
            }

            localStorage.setItem('rooter_accessibility', JSON.stringify(this.settings));
            
            // Setup TTS
            this.setupTTS();
        },
        setupTTS() {
            if (!this.settings.tts) {
                if (window.speechSynthesis) window.speechSynthesis.cancel();
                document.removeEventListener('mouseup', this.handleTTSSelection);
                document.removeEventListener('touchend', this.handleTTSSelection); // Mobile support
                return;
            }
            
            // Define TTS Handler if not exists
            if (!this.handleTTSSelection) {
                this.handleTTSSelection = () => {
                    if (!this.settings.tts) return;
                    
                    // Small delay to ensure selection is completed
                    setTimeout(() => {
                        const selection = window.getSelection();
                        const text = selection.toString().trim();
                        
                        if (text.length > 0) {
                            this.speak(text);
                        }
                    }, 200);
                };
            }

            document.addEventListener('mouseup', this.handleTTSSelection);
            document.addEventListener('touchend', this.handleTTSSelection);
        },
        speak(text) {
            if (!window.speechSynthesis) return;
            
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID'; // Bahasa Indonesia
            utterance.rate = 0.9; // Slightly slower for clarity
            window.speechSynthesis.speak(utterance);
        },
        reset() {
            this.settings = {
                preset: null,
                textSize: 0,
                spacing: false,
                links: false,
                dyslexia: false,
                cursor: false,
                grayscale: false,
                highContrast: false,
                neonMode: false,
                hideImages: false,
                stopAnim: false,
                tts: false
            };
            this.applyAll();
        }
    }
}
</script>

<style>
/* --- 1. Text & Content Adjustments --- */
body.acc-text-1 * { font-size: 102% !important; }
body.acc-text-2 * { font-size: 104% !important; }
body.acc-text-3 * { font-size: 106% !important; }
.acc-spacing { letter-spacing: 0.1em !important; word-spacing: 0.2em !important; line-height: 2 !important; }
.acc-links a { text-decoration: underline !important; color: #16a34a !important; font-weight: 800 !important; }
.acc-dyslexia * { font-family: 'OpenDyslexic', 'Comic Sans MS', 'Chalkboard SE', sans-serif !important; }
.acc-cursor { cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="black" stroke="white" stroke-width="2"><path d="M7 2l12 11.2-5.8.8 3.3 5.4-2.5 1.6-3.3-5.4-3.7 3.4z"/></svg>'), auto !important; }

/* --- 2. Visual Filters (Applied to #site-content) --- */
#site-content.acc-grayscale { filter: grayscale(100%) !important; }
#site-content.acc-neon { filter: contrast(150%) brightness(120%) hue-rotate(90deg) !important; }
#site-content.acc-hide-img img, 
#site-content.acc-hide-img canvas,
#site-content.acc-hide-img video,
#site-content.acc-hide-img [style*="background-image"] { opacity: 0 !important; visibility: hidden !important; }

/* Robust High Contrast (Yellow on Black) */
#site-content.acc-contrast { background-color: #000 !important; color: #ffeb3b !important; }
#site-content.acc-contrast * { 
    background-color: #000 !important; 
    color: #ffeb3b !important; 
    border-color: #ffeb3b !important;
    box-shadow: none !important;
    text-shadow: none !important;
}
#site-content.acc-contrast img { filter: grayscale(100%) contrast(200%); }

/* --- 3. Presets Logic --- */

/* Aman Epilepsi: Desaturate & Stop Anim */
body.acc-epilepsy #site-content { filter: saturate(30%) !important; }
body.acc-epilepsy *, body.acc-stop-anim * { 
    animation: none !important; 
    transition: none !important; 
    scroll-behavior: auto !important;
}

/* Gangguan Visual: Scale & Contrast */
body.acc-visual { font-size: 1.25rem !important; }
body.acc-visual #site-content { filter: contrast(125%) !important; }

/* Fokus ADHD: Focus Highlight & Muted Colors */
body.acc-adhd #site-content { filter: saturate(80%); }
body.acc-adhd *:focus-visible, body.acc-adhd *:hover { 
    outline: 3px solid #f59e0b !important; 
    outline-offset: 2px !important;
}

/* Lansia Friendly: Larger Text & Readable Font */
body.acc-senior { font-size: 1.2rem !important; }
body.acc-senior * { font-family: 'Inter', sans-serif !important; letter-spacing: 0.05em; }

/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #eee; border-radius: 10px; }
</style>
