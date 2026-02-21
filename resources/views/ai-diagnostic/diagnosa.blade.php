<x-app-layout title="AI Deep Diagnostic - RooterIN">

<script>
var _diag = {
    step: 0, busy: false, camOn: false, barTimer: null,
    vLabel: 'Potential Blockage', vScore: 85,
    aLabel: 'Standard Flow', aScore: 0,
    lat: null, lng: null,
    survey: { location:'', location_label:'', material:'pvc', sub_context:'dapur', frequency:'pertama', symptoms:[] },
    result: { id:'RT-PENDING', rank:'?', title:'', rec:'', tools:'' }
};

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        function(p){ _diag.lat = p.coords.latitude; _diag.lng = p.coords.longitude; },
        function(e){ console.warn('GPS:', e.message); },
        { timeout: 8000 }
    );
}

function _el(id){ return document.getElementById(id); }

function _toast(msg, isErr) {
    var t = _el('rt-toast');
    t.innerHTML = msg;
    t.style.display = 'block';
    t.style.opacity = '1';
    t.style.cssText = [
        'position:fixed;bottom:2.5rem;left:50%;transform:translateX(-50%) translateY(0);',
        'z-index:9999;padding:.6rem 1.25rem;border-radius:2rem;',
        'font-size:.6rem;font-weight:900;text-transform:uppercase;letter-spacing:.15em;',
        'box-shadow:0 10px 30px rgba(0,0,0,0.5); backdrop-filter:blur(10px);',
        'transition:all .4s cubic-bezier(0.175, 0.885, 0.32, 1.275); max-width:20rem; width:fit-content; text-align:center;',
        isErr
            ? 'background:rgba(220,38,38,0.9); color:#fff; border:1px solid rgba(239,68,68,0.3);'
            : 'background:rgba(34,197,94,0.9); color:#0f172a; border:1px solid rgba(74,222,128,0.3);'
    ].join('');
    
    clearTimeout(_diag._tt);
    _diag._tt = setTimeout(function(){ 
        t.style.opacity = '0';
        t.style.transform = 'translateX(-50%) translateY(20px)';
        setTimeout(function(){ t.style.display = 'none'; }, 400);
    }, 2800);
}

function _goStep(n) {
    _diag.step = n;
    
    var s0 = document.getElementById('s0');
    var s2 = document.getElementById('s2');
    if(s0) s0.style.display = (n === 0) ? 'block' : 'none';
    if(s2) s2.style.display = (n === 2) ? 'block' : 'none';

    var d0 = document.getElementById('d0');
    if(d0) { d0.style.background = '#22c55e'; d0.style.color = '#0f172a'; }

    var d2 = document.getElementById('d2');
    var dl0 = document.getElementById('dl0');

    if (n >= 2) {
        if(d2) { d2.style.background = '#22c55e'; d2.style.color = '#0f172a'; }
        if(dl0) { dl0.style.background = '#22c55e'; }
    } else {
        if(d2) { d2.style.background = '#1e293b'; d2.style.color = '#64748b'; }
        if(dl0) { dl0.style.background = '#1e293b'; }
    }
}

function _btnState(id, disabled, html) {
    var b = _el(id);
    b.disabled = disabled;
    b.innerHTML = html;
}

async function rtVision() {
    if (_diag.busy) return;
    _diag.busy = true;
    _btnState('btn-v', true, 'Handshake...');
    
    try {
        const hResp = await fetch('{{ route("ai.diagnostic.handshake") }}');
        const hData = await hResp.json();
        _diag.handshake = hData.token;
        _toast('Neural Handshake Active: Verified');
    } catch (e) {
        _toast('Handshake Failure: Using Local Cache', true);
    }

    _btnState('btn-v', true, 'Menangkap Visual...');
    _toast('Menyimpan frame observasi...');
    if (_diag.camOn) {
        _el('scan-ln').style.display = 'block';
    }

    setTimeout(function() {
        var v = _el('rt-vid');
        var c = _el('rt-cvs');
        if (_diag.uploadedBase64) {
             _diag.imageBase64 = _diag.uploadedBase64;
             _toast('Menggunakan gambar yang diunggah...');
        } else if (_diag.camOn && v && v.videoWidth > 0) {
            c.width = v.videoWidth;
            c.height = v.videoHeight;
            var ctx = c.getContext('2d');
            ctx.drawImage(v, 0, 0, c.width, c.height);
            _diag.imageBase64 = c.toDataURL('image/jpeg', 0.85); // Capture Real Base64 Image
        } else {
            // Fallback base64 transparent
            c.width = 640; c.height = 480;
            var ctx = c.getContext('2d');
            ctx.fillStyle = "#A9A9A9";
            ctx.fillRect(0, 0, 640, 480);
            ctx.fillStyle = "#ffffff";
            ctx.font = "30px Arial";
            ctx.fillText("Simulated Degradation Frame", 100, 240);
            _diag.imageBase64 = c.toDataURL('image/jpeg', 0.85);
        }

        _diag.vScore = 85; 
        if (_diag.camOn) _el('scan-ln').style.display = 'none';
        _diag.busy = false;

        _btnState('btn-v', false, '✓ Frame Captured');
        _toast('Frame visual disimpan! Lanjut Isi Survei ›');
        setTimeout(function(){ _goStep(2); }, 700);
    }, 600); 
}

function rtUploadFile(e) {
    var file = e.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(evt) {
            _diag.uploadedBase64 = evt.target.result;
            _diag.camOn = false;
            
            var v = _el('rt-vid');
            if (v) {
                if (v.srcObject) { v.srcObject.getTracks().forEach(function(t){ t.stop(); }); }
                v.srcObject = null;
                v.style.opacity = '0';
                v.style.display = 'none';
            }

            var hud = _el('cam-hud');
            if (hud) hud.style.display = 'none';

            var nc = _el('no-cam');
            if (nc) {
                nc.style.cssText = 'position:absolute;inset:0;display:flex;align-items:center;justify-content:center;z-index:5;background:#000;';
                nc.innerHTML = '<img src="' + evt.target.result + '" style="width:100%;height:100%;object-fit:cover;">';
            }
            
            _toast('\u2713 Foto berhasil diunggah! Klik Analyze Visual');
            _btnState('btn-v', false, '\u25b6 Analyze Visual');
        };
        reader.readAsDataURL(file);
    }
}

function rtLocToggle(){
    var d = _el('loc-d');
    d.style.display = d.style.display === 'block' ? 'none' : 'block';
}
function rtLocSel(id, lbl){
    _diag.survey.location = id;
    _diag.survey.location_label = lbl;
    _el('loc-lbl').textContent = lbl;
    _el('loc-d').style.display = 'none';
}

function rtMat(id){
    _diag.survey.material = id;
    ['pvc','besi','flex'].forEach(function(m){
        var b = _el('mat-'+m);
        var active = m === id || (m==='flex' && id==='fleksibel') || (m==='pvc' && id==='pvc') || (m==='besi' && id==='besi');
        if ((m==='pvc' && id==='pvc')||(m==='besi' && id==='besi')||(m==='flex' && id==='fleksibel')) {
            b.style.background = '#22c55e'; b.style.color = '#0f172a';
        } else {
            b.style.background = 'rgba(255,255,255,.05)'; b.style.color = '#64748b';
        }
    });
    _el('sub-pvc').style.display = id==='pvc' ? 'block' : 'none';
}
function rtSub(id){
    _diag.survey.sub_context = id;
    ['dapur','km','talang'].forEach(function(s){
        var b = _el('sub-'+s);
        b.style.background = s===id ? '#22c55e' : '#1e293b';
        b.style.color = s===id ? '#0f172a' : '#64748b';
    });
}
function rtFreq(id){
    _diag.survey.frequency = id;
    ['pt','se','to'].forEach(function(s){
        var fmap = {pt:'pertama', se:'sering', to:'total'};
        var b = _el('fr-'+s);
        b.style.background = fmap[s]===id ? '#f97316' : 'rgba(255,255,255,.05)';
        b.style.color = fmap[s]===id ? '#fff' : '#64748b';
    });
}

function rtInfer(){
    var mat = _diag.survey.material;
    var ctx = (_diag.survey.sub_context||_diag.survey.location||'').toLowerCase();
    var lbl, tools;
    if (mat==='pvc'){
        if (ctx.includes('dapur')||ctx.includes('wastafel')||ctx.includes('grease')||ctx.includes('sink')){
            lbl='Endapan Lemak Beku / Grease FOG'; tools='Hydro Jetting Medium + Bio-Chemical Enzyme Cleaner';
        } else if (ctx.includes('km')||ctx.includes('floor')||ctx.includes('toilet')||ctx.includes('closet')){
            lbl='Gumpalan Rambut & Residu Sabun'; tools='Rooter Spiral Machine + Hair Catcher Removal';
        } else if (ctx.includes('talang')||ctx.includes('gutter')||ctx.includes('selokan')){
            lbl='Sampah Daun & Endapan Lumpur'; tools='High Pressure Water Jetting + Manual Scooping';
        } else {
            lbl='Benda Asing (Foreign Object)'; tools='Rooter K-400 + CCTV Pipe Inspection';
        }
    } else if (mat==='besi'){
        lbl='Korosi & Kerak Mineral (Scale)'; tools='Heavy-Duty Descaling + Chemical Pipe Relining';
    } else {
        lbl='Sisa Sabun & Kerak Lemak'; tools='Flexible Snake + Manual Section Replacement';
    }
    _diag.result.title = lbl;
    _diag.result.rec   = lbl;
    _diag.result.tools = tools;
    _diag.result.rank  = _diag.vScore > 85 ? 'A' : 'B';
}

function rtGenerate(){
    if (_diag.busy) return;

    // ── GUARD: Require camera or uploaded photo ──
    if (!_diag.imageBase64 && !_diag.uploadedBase64) {
        _toast('\u26a0\ufe0f Anda harus mengambil foto atau upload gambar pipa atau saluran terlebih dahulu!', true);
        return;
    }

    // Collect symptoms
    _diag.survey.symptoms = [];
    document.querySelectorAll('.rt-sym:checked').forEach(function(cb){ _diag.survey.symptoms.push(cb.value); });

    _diag.busy = true;
    _el('proc-ov').style.display = 'flex';
    _btnState('btn-g', true, 'ForensicAI Active...');
    _toast('<i class="ri-brain-line"></i> Inisiasi Gemini ForensicGuard v2.0...');
    
    var msgs = [
        'Layer 1: Memverifikasi subjek gambar pipa...',
        'Layer 2: Menganalisis kualitas & kejernihan foto...',
        'Layer 3: Cross-checking material vs visual...',
        'Layer 4: Diagnosis forensik mendalam ASTM D2321...',
        'Layer 5: Menyusun rekomendasi layanan...'
    ];
    msgs.forEach(function(m, i){
        setTimeout(function(){
            if (_diag.busy && _el('proc-msg')) _el('proc-msg').textContent = m;
        }, i * 2500);
    });

    var payload = {
        image_base64:      _diag.imageBase64 || null,
        result_label:      _diag.vLabel || 'Pending Engine Inference',
        city_location:     _diag.city || 'Auto Detect',
        material_type:     _diag.survey.material || 'unknown',
        location_context:  _diag.survey.location || 'umum',
        confidence_score:  parseInt(_diag.vScore) || 85,
        survey_data:       _diag.survey,
        recommended_tools: 'Professional Diagnostics Rooter Equipment',
        metadata: {
            symptoms: _diag.survey.symptoms || [],
            sub_context: _diag.survey.sub_context || ''
        }
    };
    if (_diag.lat !== null) { payload.latitude = _diag.lat; payload.longitude = _diag.lng; }

    fetch('{{ route("ai.diagnostic.store") }}', {
        method: 'POST',
        headers: { 
            'Content-Type':'application/json', 
            'X-CSRF-TOKEN':'{{ csrf_token() }}', 
            'Accept':'application/json',
            'X-Phantom-Token': _diag.handshake || ''
        },
        body: JSON.stringify(payload)
    })
    .then(function(r){ 
        return r.json().then(function(data){ 
            return { ok: r.ok, status: r.status, data: data }; 
        });
    })
    .then(function(res){
        _el('proc-ov').style.display = 'none';
        _btnState('btn-g', false, 'Generate Ulang');
        _diag.busy = false;

        if (!res.ok) {
            // ── Forensic Guard Rejection Handling ──
            var err = res.data;
            var code = err.error_code || '';
            
            if (code === 'NOT_PIPE') {
                // Layer 1: Not a pipe image — show full-screen rejection
                rtShowRejection(
                    'ri-error-warning-fill',
                    'Bukan Foto Pipa!',
                    err.message || 'Gambar tidak menampilkan pipa atau saluran.',
                    'Arahkan kamera ke pipa, saluran, atau area perpipaan yang bermasalah.',
                    '#ef4444'
                );
            } else if (code === 'POOR_IMAGE_QUALITY') {
                // Layer 2: Poor photo quality
                var iconClass = err.quality_type === 'TOO_DARK' ? 'ri-flashlight-line' : 'ri-camera-lens-line';
                rtShowRejection(
                    iconClass,
                    'Kualitas Foto Tidak Memadai',
                    err.message || 'Foto tidak cukup jelas untuk analisis forensik.',
                    'Ambil ulang foto dengan pencahayaan yang baik dan kamera yang stabil.',
                    '#f97316'
                );
            } else if (code === 'RATE_LIMIT_EXCEEDED') {
                rtShowRejection(
                    'ri-timer-flash-line',
                    'Limit Harian Tercapai',
                    err.message,
                    'Gunakan kuota diagnosa Anda secara bijak atau hubungi teknisi kami untuk bantuan langsung.',
                    '#3b82f6'
                );
            } else {
                _toast('<i class="ri-close-circle-line"></i> Terjadi kesalahan: ' + (err.message || 'Server Error'), true);
            }
            return;
        }
        
        // Success — pass correct data object and optional material warning
        rtShowResult(res.data || null, res.data.material_warning || null);
    })
    .catch(function(e){
        console.error('API Error:', e);
        _el('proc-ov').style.display = 'none';
        _btnState('btn-g', false, 'Generate Ulang');
        _diag.busy = false;
        rtShowResult(null, null);
    });
}

// ── FORENSIC REJECTION UI ─────────────────────────────────
function rtShowRejection(iconClass, title, reason, hint, color) {
    var m = _el('rt-modal');
    if (!m) return;

    // Temporarily use modal for rejection display
    m.innerHTML = `
    <div onclick="event.stopPropagation()" style="position:relative;width:100%;max-width:34rem;background:#0f172a;border:2px solid ${color};border-radius:2rem;padding:2.5rem;text-align:center;box-shadow:0 0 60px ${color}33">
        <div style="font-size:3.5rem;margin-bottom:1rem;color:${color}"><i class="${iconClass}"></i></div>
        <h2 style="color:#fff;font-size:1.1rem;font-weight:900;margin:0 0 1rem;line-height:1.3">${title}</h2>
        <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:1rem;padding:1.1rem;margin-bottom:.85rem">
            <p style="color:#e2e8f0;font-size:.85rem;line-height:1.6;margin:0">${reason}</p>
        </div>
        <div style="background:rgba(34,197,94,.05);border:1px solid rgba(34,197,94,.2);border-radius:1rem;padding:.9rem;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:center;gap:.5rem">
            <i class="ri-lightbulb-line" style="color:#4ade80"></i>
            <p style="color:#4ade80;font-size:.75rem;font-weight:700;margin:0">${hint}</p>
        </div>
        <button onclick="rtCloseModal(event); rtResetToStep0();" style="width:100%;padding:1rem;background:${color};color:#fff;border:none;border-radius:1rem;font-weight:900;font-size:.7rem;text-transform:uppercase;letter-spacing:.12em;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem">
            <i class="ri-camera-fill"></i> Ambil Foto Ulang
        </button>
    </div>`;

    m.style.setProperty('display', 'flex', 'important');
    m.style.setProperty('opacity', '1', 'important');
    m.style.setProperty('visibility', 'visible', 'important');
}

// Reset to step 0 for retake
function rtResetToStep0() {
    _diag.imageBase64    = null;
    _diag.uploadedBase64 = null;
    _diag.camOn          = false;
    _goStep(0);
    _btnState('btn-v', false, 'Analyze Visual');
    
    // Reset video element visibility
    var v = _el('rt-vid');
    if (v) { v.style.display = ''; v.style.opacity = '0'; }
    var nc = _el('no-cam');
    if (nc) { nc.style.cssText = 'position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:2rem;z-index:2;background:#0f172a;'; }

    // Rebuild modal innerHTML for next use
    _el('rt-modal').innerHTML = document.getElementById('rt-modal-template').innerHTML;
}

function rtShowResult(res, materialWarning){
    console.log('[DEBUG] AI Response Received:', res);
    _el('proc-ov').style.display = 'none';
    _btnState('btn-g', false, 'Generate Ulang');
    _diag.busy = false;

    if (!res) {
        console.warn('[DEBUG] Using Fallback - Server response missing or error.');
    }

    // Use server result if available, otherwise fallback to local diag structure
    const finalData = res || {};
    const modelData = res.data || {}; // Handle lead model if present

    try {
        _el('m-id').textContent    = res.diagnose_id || modelData.diagnose_id || 'RT-UNKNOWN';
        _el('m-rank').textContent  = res.deep_ranking || modelData.final_deep_score || '?';
        _el('m-title').textContent = modelData.result_label || 'Analysis Complete';
        _el('m-rec').textContent   = modelData.result_label || 'Analisis Selesai';
        
        var toolsText = modelData.recommended_tools || 'Pemeriksaan manual dibutuhkan.';
        _el('m-tools').innerHTML   = toolsText.replace(/\. /g, '.<br><br>');
        
        // Integrated Service Link
        const meta = modelData.metadata || {};
        const serviceSlug = meta.recommended_service_slug || 'saluran-pembuangan-mampet';
        const serviceName = meta.recommended_service_name || 'Saluran Pembuangan Mampet';
        _diag.targetServiceUrl = '/layanan/' + serviceSlug;
        
        if (_el('m-service')) _el('m-service').textContent = serviceName;

        // Visual Updates
        const colors = { 'A':'#ef4444', 'B':'#f97316', 'C':'#eab308', 'D':'#22c55e', 'E':'#3b82f6' };
        const colorCode = res.deep_ranking || modelData.final_deep_score || 'B';
        const color = colors[colorCode] || '#64748b';
        _el('m-rank').style.color = color;

        // ── LAYER 3: Material Mismatch Warning Banner
        var warnEl = _el('m-material-warn');
        if (warnEl) {
            if (materialWarning) {
                warnEl.style.display = 'block';
                warnEl.innerHTML = '<i class="ri-alert-line" style="font-size:.85rem"></i> ' + materialWarning;
            } else {
                warnEl.style.display = 'none';
            }
        }
        
        _toast(res ? '<i class="ri-checkbox-circle-fill"></i> Diagnosis ForensicAI Selesai!' : 'Diagnosis Fallback Aktif (Offline)', !res);
        
        // Final Display Trigger
        setTimeout(function(){ 
            var m = _el('rt-modal');
            if (m) {
                m.style.setProperty('display', 'flex', 'important');
                m.style.setProperty('opacity', '1', 'important');
                m.style.setProperty('visibility', 'visible', 'important');
                console.log('[DEBUG] Modal Display Triggered Successfully');
            }
        }, 100);
    } catch (err) {
        console.error('[FATAL] Modal Injection Error:', err);
        _toast('Gagal memproses data laporan', true);
    }
}


function rtCloseModal(e){ 
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    // Hard hide
    var m = _el('rt-modal');
    if (m) {
        m.style.setProperty('display', 'none', 'important');
        m.style.setProperty('opacity', '0', 'important');
    }
}

function rtPesanLayanan(){
    window.location.href = _diag.targetServiceUrl || '/services';
}

function rtWA(){
    const url = '/admin/api/track-whatsapp';
    const data = new URLSearchParams();
    data.append('url', window.location.href);
    data.append('source', 'ai_diagnostic_result');

    // Attempt tracking with multiple layers of reliability
    if (navigator.sendBeacon) {
        navigator.sendBeacon(url, data);
    } else {
        fetch(url, { method: 'POST', body: data, keepalive: true });
    }

    var text = '*ROOTERIN DEEP DIAGNOSTIC*\n\n'+
        'ID: *'+_diag.result.id+'*\nRanking: *'+_diag.result.rank+'*\n\n'+
        'Diagnosa: *'+_diag.result.title+'*\n'+
        'Alat: '+_diag.result.tools+'\n\n'+
        'Material: '+(_diag.survey.material||'-').toUpperCase()+'\n'+
        'Lokasi: '+(_diag.survey.sub_context||_diag.survey.location||'umum').toUpperCase()+'\n\n'+
        '_Mohon segera dijadwalkan inspeksi._';
    
    // Tiny delay to allow tracking to initiate
    setTimeout(function(){
        window.open('https://wa.me/6281234567890?text=' + encodeURIComponent(text), '_blank');
    }, 100);
}

// Close loc dropdown on outside click
document.addEventListener('click', function(e){
    var w = _el('loc-wrap');
    if (w && !w.contains(e.target)) {
        var d = _el('loc-d');
        if (d) d.style.display = 'none';
    }
});

// Block Escape key from closing modal via Alpine.js or other handlers
document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') {
        var m = _el('rt-modal');
        if (m && m.style.display !== 'none') {
            e.stopImmediatePropagation();
            e.preventDefault();
        }
    }
}, true); // capture phase = blocks before Alpine.js sees it

// NOTE: Vite HMR guard removed — import.meta is not available in Blade classic scripts.
</script>

{{-- ============================================================
     TOAST (rendered before everything)
     ============================================================ --}}
<div id="rt-toast" style="display:none;opacity:0"></div>

{{-- ============================================================
     PROCESSING OVERLAY
     ============================================================ --}}
<div id="proc-ov" style="display:none;position:fixed;inset:0;z-index:8888;background:rgba(2,6,23,.88);backdrop-filter:blur(14px);flex-direction:column;align-items:center;justify-content:center">
    <div style="position:relative;width:5rem;height:5rem;margin-bottom:1.5rem">
        <div style="position:absolute;inset:0;width:5rem;height:5rem;border:4px solid #22c55e;border-top-color:transparent;border-radius:50%;animation:rtspin .8s linear infinite"></div>
        <div style="position:absolute;inset:.75rem;border:4px solid #f97316;border-bottom-color:transparent;border-radius:50%;animation:rtspinr .6s linear infinite"></div>
    </div>
    <p style="color:#fff;font-size:.85rem;font-weight:900;text-transform:uppercase;letter-spacing:.2em;margin:0">Mengkalkulasi...</p>
    <p id="proc-msg" style="color:#64748b;font-size:.65rem;margin:.3rem 0 0">Neural Fusion Processing</p>
    <style>@keyframes rtspin{to{transform:rotate(360deg)}}@keyframes rtspinr{to{transform:rotate(-360deg)}}</style>
</div>

{{-- ============================================================
     RESULT MODAL
     ============================================================ --}}
<div id="rt-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(2,6,23,.97);backdrop-filter:blur(24px);align-items:center;justify-content:center;padding:1rem">
    <div onclick="event.stopPropagation()" style="position:relative;width:100%;max-width:38rem;background:#0f172a;border:1px solid rgba(255,255,255,.08);border-radius:2.5rem;padding:2.5rem;max-height:85vh;overflow-y:auto;box-shadow:0 0 100px rgba(34,197,94,.15);scrollbar-width:thin;scrollbar-color:#1e293b transparent">
        
        {{-- Close btn --}}
        <button id="rt-close-x" onclick="rtCloseModal(event)" style="position:absolute;top:1.5rem;right:1.5rem;background:rgba(255,255,255,.05);border:none;width:2.5rem;height:2.5rem;border-radius:50%;color:#64748b;display:flex;align-items:center;justify-content:center;cursor:pointer;z-index:10;font-size:1.2rem;transition:all .3s"><i class="ri-close-line"></i></button>

        {{-- Rank --}}
        <div style="display:flex;justify-content:center;margin-bottom:1.5rem">
            <div style="width:7rem;height:7rem;border-radius:50%;padding:.2rem;background:linear-gradient(135deg,#4ade80,#fb923c,#ea580c)">
                <div style="width:100%;height:100%;background:#020617;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center">
                    <span id="m-rank" style="font-size:3.5rem;font-weight:900;color:#fff;font-style:italic;line-height:1">?</span>
                    <span style="font-size:.55rem;font-weight:900;color:#475569;text-transform:uppercase;letter-spacing:.15em;margin-top:.2rem">AI Score</span>
                </div>
            </div>
        </div>              
    
        {{-- Title & ID --}}
        <div style="text-align:center;margin-bottom:1.25rem">
            <h2 id="m-title" style="font-size:1.05rem;font-weight:900;color:#fff;margin:0 0 .75rem;line-height:1.3">Menganalisa...</h2>
            <div style="display:inline-flex;align-items:center;gap:.5rem;padding:.3rem .85rem;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:5rem">
                <span style="width:.5rem;height:.5rem;background:#22c55e;border-radius:50%;display:inline-block"></span>
                <span style="font-size:.6rem;font-weight:900;color:#475569;text-transform:uppercase;letter-spacing:.12em">ID: <span id="m-id">—</span></span>
            </div>
        </div>                                                                          

        {{-- Recommendation --}}
        <div style="background:rgba(34,197,94,.04);border:1px solid rgba(34,197,94,.15);border-radius:1.2rem;padding:1.4rem;margin-bottom:.85rem">
            <div style="font-size:.6rem;font-weight:900;color:#22c55e;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.6rem">Diagnosa Utama</div>
            <p id="m-rec" style="color:#fff;font-size:.95rem;font-weight:700;line-height:1.5;margin:0;letter-spacing:-0.01em">—</p>
        </div>
        {{-- Layer 3: Material Mismatch Warning Banner --}}
        <div id="m-material-warn" style="display:none;background:rgba(234,179,8,.1);border:1px solid rgba(234,179,8,.3);color:#eab308;font-size:.7rem;padding:.75rem;border-radius:.75rem;margin-bottom:1rem;font-weight:700;line-height:1.4"></div>

        <div style="background:rgba(2,6,23,.8);border:1px solid rgba(255,255,255,.05);border-radius:1rem;padding:1.1rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.85rem">
            <div style="width:2.75rem;height:2.75rem;background:rgba(249,115,22,.1);border-radius:.65rem;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" style="width:1.2rem;height:1.2rem"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
            </div>
            <div>
                <div style="font-size:.6rem;font-weight:900;color:#475569;text-transform:uppercase;letter-spacing:.12em;margin-bottom:.3rem">Alat Teknis</div>
                <p id="m-tools" style="color:#e2e8f0;font-size:.75rem;font-weight:600;line-height:1.4;margin:0">—</p>
            </div>
        </div>

        {{-- CTA --}}
        <button onclick="rtPesanLayanan()" style="width:100%;padding:1.1rem;background:#fff;color:#0f172a;border:none;border-radius:1.2rem;font-weight:900;font-size:.7rem;text-transform:uppercase;letter-spacing:.15em;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;margin-bottom:.6rem;box-shadow:0 10px 30px rgba(255,255,255,0.1)">
            PESAN LAYANAN SEKARANG
        </button>
        {{-- WhatsApp CTA --}}
        <a id="m-wa" href="#" target="_blank" style="width:100%;padding:1rem;background:#22c55e;color:#fff;text-decoration:none;border-radius:1.2rem;font-weight:900;font-size:.7rem;text-transform:uppercase;letter-spacing:.15em;display:flex;align-items:center;justify-content:center;gap:.6rem;transition:all .3s">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:1.2rem;height:1.2rem"><path d="M12.011 2c-5.511 0-9.989 4.478-9.989 9.989 0 1.762.459 3.415 1.259 4.856l-1.281 4.673 4.783-1.255c1.405.748 3.003 1.177 4.703 1.177 5.511 0 9.989-4.478 9.989-9.989S17.521 2 12.011 2zm0 16.5c-1.579 0-3.056-.445-4.312-1.215l-.31-.188-2.613.685.698-2.541-.212-.338c-.859-1.371-1.351-2.99-1.351-4.724 0-4.68 3.809-8.489 8.489-8.489s8.489 3.809 8.489 8.489-3.809 8.489-8.489 8.489z"/></svg>
            Konsultasi WhatsApp
        </a>
    </div>
</div>

{{-- Template to restore modal state after rejection --}}
<script id="rt-modal-template" type="text/template">
    <div onclick="event.stopPropagation()" style="position:relative;width:100%;max-width:38rem;background:#0f172a;border:1px solid rgba(255,255,255,.08);border-radius:2.5rem;padding:2.5rem;max-height:85vh;overflow-y:auto;box-shadow:0 0 100px rgba(34,197,94,.15);">
        <button id="rt-close-x" onclick="rtCloseModal(event)" style="position:absolute;top:1.5rem;right:1.5rem;background:rgba(255,255,255,.05);border:none;width:2.5rem;height:2.5rem;border-radius:50%;color:#64748b;display:flex;align-items:center;justify-content:center;cursor:pointer;z-index:10;font-size:1.2rem;"><i class="ri-close-line"></i></button>
        <div style="display:flex;justify-content:center;margin-bottom:1.5rem">
            <div style="width:7rem;height:7rem;border-radius:50%;padding:.2rem;background:linear-gradient(135deg,#4ade80,#fb923c,#ea580c)">
                <div style="width:100%;height:100%;background:#020617;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center">
                    <span id="m-rank" style="font-size:3.5rem;font-weight:900;color:#fff;font-style:italic;line-height:1">?</span>
                    <span style="font-size:.55rem;font-weight:900;color:#475569;text-transform:uppercase;letter-spacing:.15em;margin-top:.2rem">AI Score</span>
                </div>
            </div>
        </div>
        <div style="text-align:center;margin-bottom:1.25rem">
            <h2 id="m-title" style="font-size:1.05rem;font-weight:900;color:#fff;margin:0 0 .75rem;line-height:1.3">Menganalisa...</h2>
            <div style="display:inline-flex;align-items:center;gap:.5rem;padding:.3rem .85rem;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:5rem">
                <span style="width:.5rem;height:.5rem;background:#22c55e;border-radius:50%;display:inline-block"></span>
                <span style="font-size:.6rem;font-weight:900;color:#475569;text-transform:uppercase;letter-spacing:.12em">ID: <span id="m-id">&mdash;</span></span>
            </div>
        </div>
        <div style="background:rgba(34,197,94,.04);border:1px solid rgba(34,197,94,.15);border-radius:1.2rem;padding:1.4rem;margin-bottom:.85rem">
            <div style="font-size:.6rem;font-weight:900;color:#22c55e;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.6rem">Diagnosa Utama</div>
            <p id="m-rec" style="color:#fff;font-size:.95rem;font-weight:700;line-height:1.5;margin:0;">&mdash;</p>
        </div>
        <div style="background:rgba(59,130,246,.04);border:1px solid rgba(59,130,246,.15);border-radius:1rem;padding:1.1rem;margin-bottom:.75rem">
            <div style="font-size:.6rem;font-weight:900;color:#3b82f6;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.5rem">Layanan RooterIN</div>
            <p id="m-service" style="color:#fff;font-size:1rem;font-weight:900;line-height:1.3;margin:0">Saluran Pembuangan Mampet</p>
        </div>
        <div id="m-material-warn" style="display:none;background:rgba(234,179,8,.1);border:1px solid rgba(234,179,8,.3);color:#eab308;font-size:.7rem;padding:.75rem;border-radius:.75rem;margin-bottom:1rem;font-weight:700;line-height:1.4"></div>
        <div style="background:rgba(2,6,23,.8);border:1px solid rgba(255,255,255,.05);border-radius:1rem;padding:1.1rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.85rem">
            <div style="width:2.75rem;height:2.75rem;background:rgba(249,115,22,.1);border-radius:.65rem;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" style="width:1.2rem;height:1.2rem"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
            </div>
            <div>
                <div style="font-size:.6rem;font-weight:900;color:#475569;text-transform:uppercase;letter-spacing:.12em;margin-bottom:.3rem">Alat Teknis</div>
                <p id="m-tools" style="color:#e2e8f0;font-size:.75rem;font-weight:600;line-height:1.4;margin:0;">&mdash;</p>
            </div>
        </div>
        <button onclick="rtPesanLayanan()" style="width:100%;padding:1.1rem;background:#fff;color:#0f172a;border:none;border-radius:1.2rem;font-weight:900;font-size:.7rem;text-transform:uppercase;letter-spacing:.15em;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;margin-bottom:.6rem;">PESAN LAYANAN SEKARANG</button>
        <a id="m-wa" href="#" target="_blank" style="width:100%;padding:1rem;background:#22c55e;color:#fff;text-decoration:none;border-radius:1.2rem;font-weight:900;font-size:.7rem;text-transform:uppercase;letter-spacing:.15em;display:flex;align-items:center;justify-content:center;gap:.6rem;">Konsultasi WhatsApp</a>
    </div>
</script>

{{-- ============================================================
     MAIN PAGE
     ============================================================ --}}
<section style="background:#020617;min-height:100vh;padding-top:7rem;padding-bottom:5rem;position:relative;overflow-x:hidden">
    <div style="position:absolute;inset:0;opacity:.04;pointer-events:none;background-image:radial-gradient(#22c55e 1px,transparent 1px);background-size:36px 36px"></div>
    <div style="position:absolute;inset:0;background:linear-gradient(to bottom,#020617 0%,transparent 30%,transparent 70%,#020617 100%);pointer-events:none"></div>

    <div class="container mx-auto" style="padding:0 1rem;position:relative;z-index:1">

        {{-- Header --}}
        <div style="text-align:center;margin-bottom:2.5rem">
            <h1 style="font-size:clamp(2.8rem,8vw,5.5rem);font-weight:900;color:#fff;line-height:.9;letter-spacing:-.04em;font-style:italic;margin:3.5rem 0 1rem 0">
                Magic <br><span style="background:linear-gradient(135deg,#4ade80,#fb923c,#ea580c);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Deep Vision.</span>
            </h1>
            <p style="color:#64748b;font-size:.85rem;max-width:28rem;margin:0 auto">Analisis AI multi-sensor untuk mendeteksi jenis sumbatan pipa secara presisi.</p>
        </div>

        {{-- Step Dots --}}
        <div style="max-width:18rem;margin:0 auto 2rem;display:flex;align-items:center;justify-content:space-between">
            <div id="d0" style="width:2.5rem;height:2.5rem;border-radius:50%;background:#22c55e;color:#0f172a;display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:900;flex-shrink:0;transition:all .3s">1</div>
            <div id="dl0" style="flex:1;height:2px;background:#1e293b;margin:0 1rem;transition:background .3s"></div>
            <div id="d2" style="width:2.5rem;height:2.5rem;border-radius:50%;background:#1e293b;color:#64748b;display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:900;flex-shrink:0;transition:all .3s">2</div>
        </div>
        <div style="max-width:18rem;margin:-1.5rem auto 2rem;display:flex;justify-content:space-between;padding:0 1rem">
            <span style="font-size:.65rem;font-weight:900;color:#22c55e;text-transform:uppercase;letter-spacing:.1em;transform:translateX(-25%)">Pemindai Visual</span>
            <span style="font-size:.65rem;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:.1em;transform:translateX(15%)">Data Kondisi</span>
        </div>

        {{-- CARD --}}
        <div style="max-width:22rem;margin:0 auto">
            <div style="background:#0f172a;border:1px solid rgba(255,255,255,.06);border-radius:2rem;overflow:hidden;box-shadow:0 40px 80px rgba(0,0,0,.5)">

                {{-- ── STEP 0: VISION ── --}}
                <div id="s0" style="display:block">
                    <div style="position:relative;aspect-ratio:3/4;background:#000;overflow:hidden">
                        <video id="rt-vid" autoplay playsinline muted style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0;transition:opacity .5s"></video>
                        <canvas id="rt-cvs" style="display:none"></canvas>

                        {{-- No cam state / Upload Frame --}}
                        <div id="no-cam" style="position:absolute;inset:0;background:#0f172a;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:2rem;z-index:2">
                            <div style="width:3.5rem;height:3.5rem;background:#1e293b;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1rem">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" style="width:1.5rem;height:1.5rem"><line x1="1" y1="1" x2="23" y2="23"/><path d="M21 21H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h3m3-3h6l2 3h4a2 2 0 0 1 2 2v9.34m-7.72-2.06a4 4 0 1 1-5.56-5.56"/></svg>
                            </div>
                            <p style="color:#64748b;font-size:.75rem;font-weight:600;margin:0 0 .25rem">Kamera tidak aktif</p>
                            <label style="cursor:pointer;color:#22c55e;font-size:.6rem;font-weight:900;text-transform:uppercase;margin:0;padding:.3rem .8rem;background:rgba(34,197,94,.1);border-radius:.3rem;margin-top:.4rem;display:inline-block">
                                ATAU UPLOAD FOTO PIPA LOKAL
                                <input type="file" accept="image/*" style="display:none" onchange="rtUploadFile(this)">
                            </label>
                        </div>

                        {{-- Cam HUD --}}
                        <div id="cam-hud" style="position:absolute;inset:0;pointer-events:none;display:none">
                            <div style="position:absolute;inset:1.5rem;border:2px solid rgba(34,197,94,.3);border-radius:1.2rem;overflow:hidden">
                                <div id="scan-ln" style="position:absolute;left:0;width:100%;height:2px;background:#22c55e;box-shadow:0 0 10px #22c55e;display:none;animation:rtscanmv 2s linear infinite"></div>
                            </div>
                            <div style="position:absolute;top:.85rem;left:1.1rem">
                                <div style="font-family:monospace;font-size:.6rem;color:#22c55e;font-weight:700">CAM: LIVE</div>
                            </div>
                        </div>
                    </div>
                    <div style="padding:1.1rem;display:flex;flex-direction:column;gap:.5rem">
                        <button id="btn-v" onclick="rtVision()"
                                style="width:100%;padding:1rem;background:#fff;color:#0f172a;border:none;border-radius:.85rem;font-weight:900;font-size:.65rem;text-transform:uppercase;letter-spacing:.15em;cursor:pointer">
                            Analyze Visual
                        </button>
                        <label style="cursor:pointer;color:#94a3b8;font-size:.6rem;font-weight:900;text-transform:uppercase;margin:0;padding:.8rem;background:rgba(255,255,255,.05);border-radius:.85rem;text-align:center;display:block">
                            ATAU UPLOAD FOTO SENDIRI
                            <input type="file" accept="image/*" style="display:none" onchange="rtUploadFile(this)">
                        </label>
                    </div>
                </div>

                {{-- ── STEP 2: SURVEY ── --}}
                <div id="s2" style="display:none">
                    <div style="padding:1.1rem 1.1rem .5rem;border-bottom:1px solid rgba(255,255,255,.05)">
                        <h3 style="color:#fff;font-weight:900;font-size:.7rem;text-transform:uppercase;letter-spacing:.2em;margin:0 0 .4rem">Technical Context Survey</h3>
                        <div style="width:2rem;height:.2rem;background:#22c55e;border-radius:.1rem"></div>
                    </div>
                    <div style="padding:1.1rem;max-height:25rem;overflow-y:auto">

                        {{-- Lokasi --}}
                        <div id="loc-wrap" style="margin-bottom:1.1rem;position:relative">
                            <div style="font-size:.58rem;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.4rem">Lokasi Pipa</div>
                            <button onclick="rtLocToggle()"
                                    style="width:100%;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06);border-radius:.65rem;padding:.7rem .9rem;display:flex;align-items:center;justify-content:space-between;color:#fff;font-size:.62rem;font-weight:700;text-transform:uppercase;cursor:pointer">
                                <span id="loc-lbl">Pilih Lokasi...</span>
                                <i class="ri-arrow-down-s-line"></i>
                            </button>
                            <div id="loc-d" style="display:none;position:absolute;z-index:50;top:100%;left:0;right:0;margin-top:.2rem;background:#1e293b;border:1px solid rgba(255,255,255,.1);border-radius:.75rem;overflow:hidden;box-shadow:0 20px 40px rgba(0,0,0,.5)">
                                <button onclick="rtLocSel('wastafel_dapur','Wastafel Dapur (Grease/FOG)')" style="width:100%;text-align:left;padding:.6rem .9rem;font-size:.58rem;font-weight:700;color:#94a3b8;text-transform:uppercase;cursor:pointer;border:none;background:transparent;border-bottom:1px solid rgba(255,255,255,.04);display:block">Wastafel Dapur (Grease/FOG)</button>
                                <button onclick="rtLocSel('toilet_closet','Toilet / Closet (Foreign Object)')" style="width:100%;text-align:left;padding:.6rem .9rem;font-size:.58rem;font-weight:700;color:#94a3b8;text-transform:uppercase;cursor:pointer;border:none;background:transparent;border-bottom:1px solid rgba(255,255,255,.04);display:block">Toilet / Closet (Foreign Object)</button>
                                <button onclick="rtLocSel('floor_drain_km','Floor Drain Kamar Mandi')" style="width:100%;text-align:left;padding:.6rem .9rem;font-size:.58rem;font-weight:700;color:#94a3b8;text-transform:uppercase;cursor:pointer;border:none;background:transparent;border-bottom:1px solid rgba(255,255,255,.04);display:block">Floor Drain Kamar Mandi</button>
                                <button onclick="rtLocSel('kitchen_main','Jalur Utama Dapur / Sink')" style="width:100%;text-align:left;padding:.6rem .9rem;font-size:.58rem;font-weight:700;color:#94a3b8;text-transform:uppercase;cursor:pointer;border:none;background:transparent;border-bottom:1px solid rgba(255,255,255,.04);display:block">Jalur Utama Dapur / Sink</button>
                                <button onclick="rtLocSel('external_gutter','Talang Air / Selokan Luar')" style="width:100%;text-align:left;padding:.6rem .9rem;font-size:.58rem;font-weight:700;color:#94a3b8;text-transform:uppercase;cursor:pointer;border:none;background:transparent;display:block">Talang Air / Selokan Luar</button>
                            </div>
                        </div>

                        {{-- Material --}}
                        <div style="margin-bottom:1.1rem">
                            <div style="font-size:.58rem;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.4rem">Material Pipa</div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.4rem">
                                <button id="mat-pvc" onclick="rtMat('pvc')" style="padding:.65rem;background:#22c55e;color:#0f172a;border:none;border-radius:.6rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer">PVC / Plastik</button>
                                <button id="mat-besi" onclick="rtMat('besi')" style="padding:.65rem;background:rgba(255,255,255,.05);color:#64748b;border:none;border-radius:.6rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer">Besi / Cast Iron</button>
                                <button id="mat-flex" onclick="rtMat('fleksibel')" style="padding:.65rem;background:rgba(255,255,255,.05);color:#64748b;border:none;border-radius:.6rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer;grid-column:1/-1">Selang Fleksibel</button>
                            </div>
                        </div>

                        {{-- Sub-context (PVC) --}}
                        <div id="sub-pvc" style="margin-bottom:1.1rem;background:rgba(34,197,94,.04);border:1px solid rgba(34,197,94,.12);border-radius:.85rem;padding:.85rem">
                            <div style="font-size:.58rem;font-weight:900;color:#22c55e;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.4rem">Lokasi Spesifik PVC</div>
                            <button id="sub-dapur" onclick="rtSub('dapur')" style="width:100%;padding:.6rem;background:#22c55e;color:#0f172a;border:none;border-radius:.55rem;font-weight:900;font-size:.58rem;text-transform:uppercase;cursor:pointer;margin-bottom:.35rem;display:block">Area Dapur / Kitchen Sink</button>
                            <button id="sub-km" onclick="rtSub('km')" style="width:100%;padding:.6rem;background:#1e293b;color:#64748b;border:none;border-radius:.55rem;font-weight:900;font-size:.58rem;text-transform:uppercase;cursor:pointer;margin-bottom:.35rem;display:block">Kamar Mandi / Floor Drain</button>
                            <button id="sub-talang" onclick="rtSub('talang')" style="width:100%;padding:.6rem;background:#1e293b;color:#64748b;border:none;border-radius:.55rem;font-weight:900;font-size:.58rem;text-transform:uppercase;cursor:pointer;display:block">Talang Air / Selokan</button>
                        </div>

                        {{-- Frekuensi --}}
                        <div style="margin-bottom:1.1rem">
                            <div style="font-size:.58rem;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.4rem">Frekuensi Sumbatan</div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.4rem">
                                <button id="fr-pt" onclick="rtFreq('pertama')" style="padding:.65rem;background:#f97316;color:#fff;border:none;border-radius:.6rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer">Baru Pertama</button>
                                <button id="fr-se" onclick="rtFreq('sering')" style="padding:.65rem;background:rgba(255,255,255,.05);color:#64748b;border:none;border-radius:.6rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer">Sering Mampet</button>
                                <button id="fr-to" onclick="rtFreq('total')" style="padding:.65rem;background:rgba(255,255,255,.05);color:#64748b;border:none;border-radius:.6rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer;grid-column:1/-1">Mampet Total</button>
                            </div>
                        </div>

                        {{-- Gejala --}}
                        <div>
                            <div style="font-size:.58rem;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.4rem">Gejala Tambahan</div>
                            <label style="display:flex;align-items:center;gap:.65rem;padding:.6rem .75rem;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05);border-radius:.65rem;cursor:pointer;margin-bottom:.3rem">
                                <input type="checkbox" value="bau" class="rt-sym" style="accent-color:#22c55e;width:.9rem;height:.9rem;flex-shrink:0">
                                <span style="font-size:.58rem;font-weight:700;color:#94a3b8;text-transform:uppercase">Muncul Bau Tak Sedap</span>
                            </label>
                            <label style="display:flex;align-items:center;gap:.65rem;padding:.6rem .75rem;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05);border-radius:.65rem;cursor:pointer;margin-bottom:.3rem">
                                <input type="checkbox" value="kecoa" class="rt-sym" style="accent-color:#22c55e;width:.9rem;height:.9rem;flex-shrink:0">
                                <span style="font-size:.58rem;font-weight:700;color:#94a3b8;text-transform:uppercase">Banyak Kecoa / Hama</span>
                            </label>
                            <label style="display:flex;align-items:center;gap:.65rem;padding:.6rem .75rem;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05);border-radius:.65rem;cursor:pointer">
                                <input type="checkbox" value="berisik" class="rt-sym" style="accent-color:#22c55e;width:.9rem;height:.9rem;flex-shrink:0">
                                <span style="font-size:.58rem;font-weight:700;color:#94a3b8;text-transform:uppercase">Pipa Mengeluarkan Bunyi</span>
                            </label>
                        </div>
                    </div>

                    {{-- Generate button — completely outside scroll area --}}
                    <div style="padding:1.1rem;border-top:1px solid rgba(255,255,255,.05)">
                        <button id="btn-g" onclick="rtGenerate()"
                                style="width:100%;padding:1rem;background:#f97316;color:#fff;border:none;border-radius:.85rem;font-weight:900;font-size:.65rem;text-transform:uppercase;letter-spacing:.15em;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.4rem">
                            Generate Deep Diagnostic
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<style>
@keyframes rtscanmv {
    0%   { top:0;     opacity:0 }
    5%   { opacity:1 }
    95%  { opacity:1 }
    100% { top:100%;  opacity:0 }
}
</style>

{{-- Camera startup — deferred so DOM is ready --}}
<script>
(function(){
    var v = document.getElementById('rt-vid');
    if (!v || !navigator.mediaDevices) return;
    navigator.mediaDevices.getUserMedia({ video:{ facingMode:{ ideal:'environment' } } })
        .then(function(s){
            v.srcObject = s;
            v.style.opacity = '1';
            document.getElementById('no-cam').style.display = 'none';
            document.getElementById('cam-hud').style.display = 'block';
            _diag.camOn = true;
        })
        .catch(function(e){ console.warn('Cam:', e.message); });
})();
</script>

</x-app-layout>
