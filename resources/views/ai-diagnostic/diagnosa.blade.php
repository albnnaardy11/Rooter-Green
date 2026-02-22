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
    var d2 = document.getElementById('d2');
    var dl0 = document.getElementById('dl0');

    if(d0) {
        d0.style.background = '#22c55e';
        d0.style.color = '#0f172a';
        d0.style.boxShadow = '0 0 30px rgba(34,197,94,.3)';
    }

    if (n >= 2) {
        if(d2) {
            d2.style.background = '#22c55e';
            d2.style.color = '#0f172a';
            d2.style.boxShadow = '0 0 30px rgba(34,197,94,.3)';
        }
        if(dl0) { dl0.style.background = '#22c55e'; dl0.style.boxShadow = '0 0 15px rgba(34,197,94,.2)'; }
    } else {
        if(d2) { 
            d2.style.background = '#1e293b'; 
            d2.style.color = '#475569';
            d2.style.boxShadow = 'none';
        }
        if(dl0) { dl0.style.background = '#1e293b'; dl0.style.boxShadow = 'none'; }
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
            // STOP! Do not generate a fake image. Force user to upload.
            _toast('⚠️ Anda harus mengambil foto atau mengunggah gambar terlebih dahulu!', true);
            _diag.busy = false;
            _btnState('btn-v', false, '▶ Analyze Visual');
            return;
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

    // ── LAYER 1: LEAD FILTERING (Verified Leads Only) ──
    var isVerified = _el('wa-verify').checked;
    if (!isVerified) {
        _toast('\u26a0\ufe0f Centang verifikasi WhatsApp untuk melanjutkan diagnosa mendalam.', true);
        return;
    }

    // Collect symptoms
    _diag.survey.symptoms = [];
    _diag.survey.wa_verified = true;
    document.querySelectorAll('.rt-sym:checked').forEach(function(cb){ _diag.survey.symptoms.push(cb.value); });

    // ── STRICT SURVEY GUARD ──
    if (!_diag.survey.location || !_diag.survey.material || !_diag.survey.frequency) {
        _toast('\u26a0\ufe0f Analisis ditolak! Anda wajib melengkapi bagian Lokasi, Material, dan Frekuensi pada Technical Survey.', true);
        return;
    }

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

    m.innerHTML = `
    <div onclick="event.stopPropagation()" style="position:relative;width:100%;max-width:32rem;background:#0f172a;border:1px solid ${color}44;border-radius:2.5rem;padding:3rem;text-align:center;box-shadow:0 30px 60px rgba(0,0,0,.8), 0 0 100px ${color}11">
        <div style="width:5rem;height:5rem;background:${color}11;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;border:1px solid ${color}22">
            <i class="${iconClass}" style="font-size:3rem;color:${color}"></i>
        </div>
        <h2 style="color:#fff;font-size:1.4rem;font-weight:900;margin:0 0 .75rem;line-height:1.2;letter-spacing:-0.02em">${title}</h2>
        
        <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:1.5rem;padding:1.5rem;margin-bottom:1.25rem">
            <p style="color:#94a3b8;font-size:.85rem;line-height:1.7;margin:0">${reason}</p>
        </div>

        <div style="background:rgba(34,197,94,.04);border:1px solid rgba(34,197,94,.1);border-radius:1.2rem;padding:1.2rem;margin-bottom:2rem;display:flex;gap:1rem;text-align:left;align-items:flex-start">
            <div style="width:1.8rem;height:1.8rem;background:rgba(34,197,94,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:.1rem">
                <i class="ri-lightbulb-flash-line" style="color:#4ade80;font-size:1rem"></i>
            </div>
            <p style="color:#4ade80;font-size:.78rem;font-weight:700;line-height:1.6;margin:0">${hint}</p>
        </div>

        <button type="button" onclick="rtCloseModal(event); rtResetToStep0();" style="width:100%;padding:1.2rem;background:${color};color:#fff;border:none;border-radius:1.2rem;font-weight:900;font-size:.75rem;text-transform:uppercase;letter-spacing:.15em;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.75rem;box-shadow:0 10px 30px ${color}44;transition:all .3s">
            <i class="ri-camera-lens-fill" style="font-size:1.2rem"></i> Ambil Foto Ulang
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

    // Inject template into modal BEFORE accessing elements
    const template = _el('rt-modal-template');
    const modal = _el('rt-modal');
    if (template && modal) {
        modal.innerHTML = template.innerHTML;
    }

    // Defensive data handling
    const modelData = (res && res.data) ? res.data : {};
    const finalRes = res || {};

    try {
        const meta = modelData.metadata || {};
        _el('m-id').textContent    = finalRes.diagnose_id || modelData.diagnose_id || 'RT-UNKNOWN';
        _el('m-rank').textContent  = finalRes.deep_ranking || modelData.final_deep_score || '?';
        _el('m-title').textContent = modelData.result_label || 'Analysis Complete';
        _el('m-rec').textContent   = finalRes.result_label || modelData.result_label || 'Analisis Selesai';
        
        // Show Deep Problem Explanation (User Friendly)
        var explanation = (modelData.metadata && modelData.metadata.problem_explanation) || meta.problem_explanation || 'Analisis mendalam selesai. Teknisi kami siap membantu investigasi lapangan.';
        _el('m-explanation').innerHTML = explanation.replace(/\. /g, '.<br><br>');
        
        // Show Deep Technical Report (Professional)
        var report = modelData.recommended_tools || meta.technical_report || 'Prosedur pembersihan mekanis dengan teknologi Rooter diperlukan.';
        _el('m-tools').innerHTML   = report.replace(/\n/g, '<br>').replace(/\. /g, '.<br><br>');
        
        // Integrated Service Link
        const serviceName = (modelData.metadata && modelData.metadata.recommended_service_name) || meta.recommended_service_name || 'Saluran Pembuangan Mampet';
        _diag.targetServiceUrl = '/layanan';
        
        if (_el('m-service')) _el('m-service').textContent = serviceName;

        // Visual Updates
        const colors = { 'A':'#ef4444', 'B':'#f97316', 'C':'#eab308', 'D':'#22c55e', 'E':'#3b82f6' };
        const colorCode = finalRes.deep_ranking || modelData.final_deep_score || 'B';
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
        
        // Final Display Trigger - Added 300ms safety buffer to ensure stability
        setTimeout(function(){ 
            var m = _el('rt-modal');
            if (m) {
                console.log('[SRE] Modal State: HIDDEN - Triggering FORCE_DISPLAY');
                m.style.setProperty('display', 'flex', 'important');
                m.style.setProperty('opacity', '1', 'important');
                m.style.setProperty('visibility', 'visible', 'important');
                console.log('[SRE] Modal Display: SUCCESS');
            } else {
                console.error('[SRE] Modal Element not found in DOM!');
            }
        }, 300);
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
    window.location.href = '/layanan';
}

function rtWA(e){
    if (e) e.preventDefault();
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
<div id="rt-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(2,6,23,.98);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);align-items:center;justify-content:center;padding:1.5rem;overflow:hidden">
    {{-- Content injected via rt-modal-template --}}
</div>

{{-- ============================================================
     RESULT MODAL TEMPLATE (Used for JS Injection)
     ============================================================ --}}
<script id="rt-modal-template" type="text/template">
    <div onclick="event.stopPropagation()" style="position:relative;width:100%;max-width:38rem;background:#0f172a;border:1px solid rgba(255,255,255,.05);border-radius:2.5rem;max-height:90vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 0 80px rgba(0,0,0,0.5);">
        <div style="padding:2.5rem;overflow-y:auto" class="custom-scrollbar">
            <button type="button" id="rt-close-x" onclick="rtCloseModal(event)" style="position:absolute;top:1.5rem;right:1.5rem;background:rgba(255,255,255,.03);border:none;width:2.2rem;height:2.2rem;border-radius:50%;color:#475569;display:flex;align-items:center;justify-content:center;cursor:pointer;z-index:10;font-size:1.1rem;"><i class="ri-close-line"></i></button>
        
        {{-- AI Score Badge --}}
        <div style="display:flex;justify-content:center;margin-bottom:1.8rem">
            <div style="width:7.5rem;height:7.5rem;border-radius:50%;padding:.25rem;background:linear-gradient(135deg,#22c55e,#f97316,#ef4444)">
                <div style="width:100%;height:100%;background:#0f172a;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center">
                    <span id="m-rank" style="font-size:3.8rem;font-weight:900;color:#fff;font-style:italic;line-height:1;letter-spacing:-0.05em">E</span>
                    <span style="font-size:.5rem;font-weight:900;color:#475569;text-transform:uppercase;letter-spacing:.2em;margin-top:.2rem">AI Score</span>
                </div>
            </div>
        </div>

        {{-- Main Title --}}
        <div style="text-align:center;margin-bottom:1.5rem">
            <h2 id="m-title" style="font-size:1.15rem;font-weight:900;color:#fff;margin:0 0 .85rem;line-height:1.4;padding:0 1rem">Menganalisa...</h2>
            
            {{-- ID Pill Badge --}}
            <div style="display:inline-flex;align-items:center;gap:.6rem;padding:.4rem 1rem;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05);border-radius:5rem">
                <span style="width:.45rem;height:.45rem;background:#22c55e;border-radius:50%;display:inline-block;box-shadow:0 0 10px #22c55e"></span>
                <span style="font-size:.65rem;font-weight:800;color:#475569;text-transform:uppercase;letter-spacing:.12em">ID: <span id="m-id" style="color:#64748b">#RT-2026-XXXX</span></span>
            </div>
        </div>

        {{-- Diagnosa Utama Section --}}
        <div style="background:rgba(34,197,94,.03);border:1px solid rgba(255,255,255,.03);border-radius:1.5rem;padding:1.5rem;margin-bottom:.85rem">
            <div style="font-size:.6rem;font-weight:900;color:#22c55e;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.75rem">Diagnosa Utama</div>
            <p id="m-rec" style="color:#fff;font-size:1rem;font-weight:700;line-height:1.5;margin:0;letter-spacing:-0.01em">&mdash;</p>
        </div>

        {{-- Analisis Masalah (NEW) --}}
        <div id="m-explanation-card" style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,.03);border-radius:1.5rem;padding:1.5rem;margin-bottom:.85rem">
            <div style="font-size:.6rem;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.75rem">Analisis Masalah</div>
            <p id="m-explanation" style="color:#94a3b8;font-size:.85rem;font-weight:500;line-height:1.6;margin:0">&mdash;</p>
        </div>

        {{-- Layanan Section --}}
        <div style="background:rgba(59,130,246,.03);border:1px solid rgba(255,255,255,.03);border-radius:1.5rem;padding:1.5rem;margin-bottom:.85rem">
            <div style="font-size:.6rem;font-weight:900;color:#3b82f6;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.75rem">Layanan RooterIN</div>
            <p id="m-service" style="color:#fff;font-size:1.05rem;font-weight:800;line-height:1.4;margin:0">Instalasi Sanitary & Pipa</p>
        </div>

        <div id="m-material-warn" style="display:none;background:rgba(234,179,8,.08);border:1px solid rgba(234,179,8,.2);color:#eab308;font-size:.75rem;padding:1rem;border-radius:1rem;margin-bottom:.85rem;font-weight:700;line-height:1.4"></div>

        {{-- Technical Report Section (Rencana Penanganan) --}}
        <div style="background:rgba(249,115,22,0.03);border:1px solid rgba(255,255,255,.03);border-radius:1.5rem;padding:1.5rem;margin-bottom:.85rem;position:relative">
            <div style="font-size:.6rem;font-weight:900;color:#f97316;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.75rem">Rencana Penanganan</div>
            <div id="m-tools" style="color:#fff;font-size:1rem;font-weight:700;line-height:1.5;margin:0;letter-spacing:-0.01em">
                &mdash;
            </div>
        </div>

        {{-- Actions --}}
        <div style="display:grid;gap:.75rem">
            <button type="button" onclick="rtPesanLayanan()" style="width:100%;padding:1.2rem;background:#fff;color:#0f172a;border:none;border-radius:1.2rem;font-weight:900;font-size:.75rem;text-transform:uppercase;letter-spacing:.15em;cursor:pointer;box-shadow:0 10px 20px rgba(255,255,255,0.05)">PESAN LAYANAN SEKARANG</button>
            <button type="button" onclick="rtWA(event)" style="width:100%;padding:1.1rem;background:#22c55e;color:#fff;border:none;border-radius:1.2rem;font-weight:900;font-size:.75rem;text-transform:uppercase;letter-spacing:.15em;display:flex;align-items:center;justify-content:center;gap:.6rem;cursor:pointer;transition:all .3s"><i class="ri-whatsapp-line" style="font-size:1.1rem"></i> Konsultasi WhatsApp</button>
        </div>
        </div>
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
        <div style="max-width:20rem;margin:0 auto 3rem;display:flex;align-items:center;justify-content:center;gap:1.5rem">
            <div style="display:flex;flex-direction:column;align-items:center;gap:.75rem">
                <div id="d0" style="width:3rem;height:3rem;border-radius:1rem;background:#22c55e;color:#0f172a;display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:900;box-shadow:0 0 30px rgba(34,197,94,.3);transition:all .3s"><i class="ri-camera-lens-line"></i></div>
                <span style="font-size:.6rem;font-weight:900;color:#22c55e;text-transform:uppercase;letter-spacing:.15em">Visual</span>
            </div>
            <div id="dl0" style="width:4rem;height:2px;background:#1e293b;border-radius:1px;margin-bottom:1.5rem;transition:all .3s"></div>
            <div style="display:flex;flex-direction:column;align-items:center;gap:.75rem">
                <div id="d2" style="width:3rem;height:3rem;border-radius:1rem;background:#1e293b;color:#475569;display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:900;transition:all .3s"><i class="ri-survey-line"></i></div>
                <span style="font-size:.6rem;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:.15em">Kondisi</span>
            </div>
        </div>

        {{-- CARD --}}
        <div style="max-width:26rem;margin:0 auto">
            <div style="background:rgba(15,23,42,.8);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.08);border-radius:3rem;overflow:hidden;box-shadow:0 40px 80px rgba(0,0,0,.6)">

                {{-- ── STEP 0: VISION ── --}}
                <div id="s0" style="display:block">
                    <div style="position:relative;aspect-ratio:1/1;background:#000;overflow:hidden;border-bottom:1px solid rgba(255,255,255,.05)">
                        <video id="rt-vid" autoplay playsinline muted style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0;transition:opacity .5s"></video>
                        <canvas id="rt-cvs" style="display:none"></canvas>

                        {{-- No cam state / Upload Frame --}}
                        <div id="no-cam" style="position:absolute;inset:0;background:#0f172a;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:2rem;z-index:2">
                            <div style="width:4.5rem;height:4.5rem;background:rgba(30,41,59,.5);border:1px dashed rgba(255,255,255,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem">
                                <i class="ri-camera-off-line" style="font-size:1.5rem;color:#475569"></i>
                            </div>
                            <p style="color:#64748b;font-size:.8rem;font-weight:600;margin:0 0 .5rem">Sistem Kamera Offline</p>
                            <label style="cursor:pointer;color:#22c55e;font-size:.65rem;font-weight:900;text-transform:uppercase;margin:0;padding:.6rem 1.2rem;background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);border-radius:2rem;margin-top:.5rem;display:inline-block;transition:all .3s">
                                <i class="ri-upload-cloud-2-line"></i> Upload Foto Lokal
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
                    <div style="padding:1.5rem;display:flex;flex-direction:column;gap:.75rem">
                        <button type="button" id="btn-v" onclick="rtVision()"
                                style="width:100%;padding:1.1rem;background:#fff;color:#0f172a;border:none;border-radius:1.2rem;font-weight:900;font-size:.75rem;text-transform:uppercase;letter-spacing:.15em;cursor:pointer;box-shadow:0 10px 30px rgba(255,255,255,.1)">
                            Mulai Analisis Visual
                        </button>
                        <label style="cursor:pointer;color:#94a3b8;font-size:.65rem;font-weight:900;text-transform:uppercase;margin:0;padding:.9rem;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05);border-radius:1.2rem;text-align:center;display:block;transition:all .3s">
                            <i class="ri-folder-upload-line"></i> Pilih File Gambar
                            <input type="file" accept="image/*" style="display:none" onchange="rtUploadFile(this)">
                        </label>
                    </div>
                </div>

                {{-- ── STEP 2: SURVEY ── --}}

                <div id="s2" style="display:none">
                    <div style="padding:1.5rem 1.5rem .75rem;border-bottom:1px solid rgba(255,255,255,.05)">
                        <h3 style="color:#fff;font-weight:900;font-size:.75rem;text-transform:uppercase;letter-spacing:.2em;margin:0 0 .5rem">Technical Survey</h3>
                        <div style="width:2.5rem;height:.25rem;background:linear-gradient(to right,#22c55e,#4ade80);border-radius:.1rem"></div>
                    </div>
                    <div style="padding:1.5rem;max-height:28rem;overflow-y:auto;scrollbar-width:thin;scrollbar-color:rgba(255,255,255,0.1) transparent">

                        {{-- Lokasi --}}
                        <div id="loc-wrap" style="margin-bottom:1.5rem;position:relative">
                            <div style="font-size:.6rem;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.6rem">Lokasi Perpipaan</div>
                            <button type="button" onclick="rtLocToggle()"
                                    style="width:100%;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:1rem;padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;color:#fff;font-size:.7rem;font-weight:700;text-transform:uppercase;cursor:pointer;transition:all .3s">
                                <span id="loc-lbl">Konfigurasi Jalur...</span>
                                <i class="ri-arrow-down-s-line" style="font-size:1rem;color:#22c55e"></i>
                            </button>
                            <div id="loc-d" style="display:none;position:absolute;z-index:50;top:100%;left:0;right:0;margin-top:.5rem;background:#0f172a;border:1px solid rgba(255,255,255,.1);border-radius:1.2rem;overflow:hidden;box-shadow:0 30px 60px rgba(0,0,0,.8);backdrop-filter:blur(30px)">
                                <button type="button" onclick="rtLocSel('wastafel_dapur','Wastafel Dapur')" style="width:100%;text-align:left;padding:1rem 1.25rem;font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;cursor:pointer;border:none;background:transparent;border-bottom:1px solid rgba(255,255,255,.03)">Wastafel Dapur (Grease)</button>
                                <button type="button" onclick="rtLocSel('toilet_closet','Toilet / Closet')" style="width:100%;text-align:left;padding:1rem 1.25rem;font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;cursor:pointer;border:none;background:transparent;border-bottom:1px solid rgba(255,255,255,.03)">Toilet / Closet</button>
                                <button type="button" onclick="rtLocSel('floor_drain_km','Floor Drain KM')" style="width:100%;text-align:left;padding:1rem 1.25rem;font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;cursor:pointer;border:none;background:transparent;border-bottom:1px solid rgba(255,255,255,.03)">Floor Drain KM</button>
                                <button type="button" onclick="rtLocSel('kitchen_main','Jalur Utama Sink')" style="width:100%;text-align:left;padding:1rem 1.25rem;font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;cursor:pointer;border:none;background:transparent;border-bottom:1px solid rgba(255,255,255,.03)">Jalur Utama Sink</button>
                                <button type="button" onclick="rtLocSel('external_gutter','Talang / Selokan')" style="width:100%;text-align:left;padding:1rem 1.25rem;font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;cursor:pointer;border:none;background:transparent">Talang / Selokan</button>
                            </div>
                        </div>

                        {{-- Material --}}
                        <div style="margin-bottom:1.5rem">
                            <div style="font-size:.6rem;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.6rem">Material Instalasi</div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem">
                                <button type="button" id="mat-pvc" onclick="rtMat('pvc')" style="padding:.9rem;background:#22c55e;color:#0f172a;border:none;border-radius:.85rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer;transition:all .3s">PVC / Plastik</button>
                                <button type="button" id="mat-besi" onclick="rtMat('besi')" style="padding:.9rem;background:rgba(255,255,255,.04);color:#64748b;border:1px solid rgba(255,255,255,.06);border-radius:.85rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer;transition:all .3s">Cast Iron / Besi</button>
                                <button type="button" id="mat-flex" onclick="rtMat('fleksibel')" style="padding:.9rem;background:rgba(255,255,255,.04);color:#64748b;border:1px solid rgba(255,255,255,.06);border-radius:.85rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer;grid-column:1/-1;transition:all .3s">Selang Fleksibel</button>
                            </div>
                        </div>

                        {{-- Sub-context (PVC) --}}
                        <div id="sub-pvc" style="margin-bottom:1.5rem;background:rgba(34,197,94,.03);border:1px solid rgba(34,197,94,.1);border-radius:1.2rem;padding:1.2rem">
                            <div style="font-size:.6rem;font-weight:900;color:#22c55e;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.5rem">Konfigurasi PVC</div>
                            <button type="button" id="sub-dapur" onclick="rtSub('dapur')" style="width:100%;padding:.75rem;background:#22c55e;color:#0f172a;border:none;border-radius:.75rem;font-weight:900;font-size:.63rem;text-transform:uppercase;cursor:pointer;margin-bottom:.5rem;display:block">Kitchen Sink Area</button>
                            <button type="button" id="sub-km" onclick="rtSub('km')" style="width:100%;padding:.75rem;background:#1e293b;color:#475569;border:none;border-radius:.75rem;font-weight:900;font-size:.63rem;text-transform:uppercase;cursor:pointer;margin-bottom:.5rem;display:block">Kamar Mandi / Drain</button>
                            <button type="button" id="sub-talang" onclick="rtSub('talang')" style="width:100%;padding:.75rem;background:#1e293b;color:#475569;border:none;border-radius:.75rem;font-weight:900;font-size:.63rem;text-transform:uppercase;cursor:pointer;display:block">Talang Air Utama</button>
                        </div>

                        {{-- Frekuensi --}}
                        <div style="margin-bottom:1.5rem">
                            <div style="font-size:.6rem;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.6rem">Deep Analysis History</div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem">
                                <button type="button" id="fr-pt" onclick="rtFreq('pertama')" style="padding:.9rem;background:#f97316;color:#fff;border:none;border-radius:.85rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer;transition:all .3s">Baru Pertama</button>
                                <button type="button" id="fr-se" onclick="rtFreq('sering')" style="padding:.9rem;background:rgba(255,255,255,.04);color:#64748b;border:1px solid rgba(255,255,255,.06);border-radius:.85rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer;transition:all .3s">Sering Mampet</button>
                                <button type="button" id="fr-to" onclick="rtFreq('total')" style="padding:.9rem;background:rgba(255,255,255,.04);color:#64748b;border:1px solid rgba(255,255,255,.06);border-radius:.85rem;font-weight:900;font-size:.6rem;text-transform:uppercase;cursor:pointer;grid-column:1/-1;transition:all .3s">Mampet Total</button>
                            </div>
                        </div>

                        {{-- Gejala --}}
                        <div>
                            <div style="font-size:.6rem;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:.15em;margin-bottom:.6rem">Observasi Lapangan</div>
                            <label style="display:flex;align-items:center;gap:.75rem;padding:1rem;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.04);border-radius:1rem;cursor:pointer;margin-bottom:.5rem;transition:all .3s">
                                <input type="checkbox" value="bau" class="rt-sym" style="accent-color:#22c55e;width:1.1rem;height:1.1rem;flex-shrink:0">
                                <span style="font-size:.63rem;font-weight:700;color:#64748b;text-transform:uppercase">Aroma Tidak Sedap Kuat</span>
                            </label>
                            <label style="display:flex;align-items:center;gap:.75rem;padding:1rem;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.04);border-radius:1rem;cursor:pointer;margin-bottom:.5rem;transition:all .3s">
                                <input type="checkbox" value="kecoa" class="rt-sym" style="accent-color:#22c55e;width:1.1rem;height:1.1rem;flex-shrink:0">
                                <span style="font-size:.63rem;font-weight:700;color:#64748b;text-transform:uppercase">Aktivitas Hama / Kecoa</span>
                            </label>
                            <label style="display:flex;align-items:center;gap:.75rem;padding:1rem;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.04);border-radius:1rem;cursor:pointer;transition:all .3s">
                                <input type="checkbox" value="berisik" class="rt-sym" style="accent-color:#22c55e;width:1.1rem;height:1.1rem;flex-shrink:0">
                                <span style="font-size:.63rem;font-weight:700;color:#64748b;text-transform:uppercase">Pipa Berbunyi (Gurgling)</span>
                            </label>
                        </div>
                        
                        {{-- Verified Lead Gatekeeper --}}
                        <div style="margin-top:1.25rem;padding:1.1rem;background:rgba(34,197,94,0.05);border:1px solid rgba(34,197,94,0.1);border-radius:1rem">
                            <label style="display:flex;align-items:flex-start;gap:.6rem;cursor:pointer">
                                <input type="checkbox" id="wa-verify" style="accent-color:#22c55e;width:1.1rem;height:1.1rem;margin-top:.1rem;flex-shrink:0">
                                <span style="font-size:.62rem;font-weight:700;color:#22c55e;line-height:1.4;text-transform:uppercase;letter-spacing:0.01em">Saya bersedia dihubungi teknisi via WhatsApp untuk verifikasi hasil diagnosa.</span>
                            </label>
                        </div>
                    </div>

                    {{-- Generate button — completely outside scroll area --}}
                    <div style="padding:1.5rem;border-top:1px solid rgba(255,255,255,.05);background:rgba(15,23,42,.4)">
                        <button type="button" id="btn-g" onclick="rtGenerate()"
                                style="width:100%;padding:1.15rem;background:linear-gradient(135deg,#f97316,#ea580c);color:#fff;border:none;border-radius:1.2rem;font-weight:900;font-size:.75rem;text-transform:uppercase;letter-spacing:.2em;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.6rem;box-shadow:0 10px 30px rgba(249,115,22,.2)">
                            Generate Forensic AI
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

/* Premium Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
    margin: 1.5rem 0; /* Keeps thumb away from edges */
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.2);
}
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
    overflow-x: hidden;
}
#rt-modal {
    padding: 2rem;
}
@media (max-width: 640px) {
    #rt-modal { padding: 1rem; }
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
