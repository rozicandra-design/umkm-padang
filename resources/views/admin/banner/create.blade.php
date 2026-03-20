@extends('layouts.dashboard')
@section('title', 'Tambah Banner')
@section('page-title', 'Tambah Banner')

@section('dashboard-content')

<style>
    /* Layout utama */
    .banner-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
    }
    @media(max-width: 900px) {
        .banner-layout { grid-template-columns: 1fr; }
    }

    /* Card shared */
    .form-card, .preview-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
    }
    .card-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        display: flex; align-items: center; justify-content: space-between;
        background: #fafafa;
    }
    .card-header h3 {
        font-size: 14px; font-weight: 700; color: #111827;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .ch-icon {
        width: 28px; height: 28px;
        border-radius: 7px; display: flex;
        align-items: center; justify-content: center;
        font-size: 12px; color: #fff;
    }
    .ch-icon.blue { background: linear-gradient(135deg,#2563eb,#1d4ed8); }
    .ch-icon.purple { background: linear-gradient(135deg,#7c3aed,#6d28d9); }

    /* Form body */
    .form-body { padding: 20px; display: flex; flex-direction: column; gap: 18px; }

    .field-group { display: flex; flex-direction: column; gap: 5px; }
    .field-label {
        font-size: 12px; font-weight: 600; color: #374151;
        display: flex; align-items: center; gap: 5px;
    }
    .badge-opt {
        font-size: 10px; font-weight: 500; color: #9ca3af;
        background: #f3f4f6; padding: 1px 6px; border-radius: 99px;
    }
    .badge-req { font-size: 10px; color: #dc2626; }
    .form-input {
        width: 100%; padding: 9px 12px;
        border: 1.5px solid #e5e7eb; border-radius: 9px;
        font-size: 13px; color: #111827; background: #fff;
        transition: border-color .15s, box-shadow .15s;
        outline: none; box-sizing: border-box;
    }
    .form-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.1);
    }
    .form-input::placeholder { color: #b0b7c3; }
    .field-hint { font-size: 11px; color: #9ca3af; }
    .field-error { font-size: 11.5px; color: #dc2626; display: flex; align-items: center; gap: 3px; }

    /* Upload zone */
    .upload-zone {
        border: 2px dashed #d1d5db; border-radius: 10px;
        padding: 22px 16px; text-align: center; cursor: pointer;
        transition: all .2s; background: #fafafa; position: relative;
    }
    .upload-zone:hover, .upload-zone.dragover {
        border-color: #2563eb; background: #eff6ff;
    }
    .upload-zone input[type="file"] {
        position: absolute; inset: 0; opacity: 0;
        cursor: pointer; width: 100%; height: 100%;
    }
    .upload-icon {
        width: 40px; height: 40px; background: #e0e7ff;
        border-radius: 50%; display: flex;
        align-items: center; justify-content: center;
        margin: 0 auto 8px; color: #2563eb; font-size: 16px;
    }
    .upload-zone p { margin: 0; font-size: 12.5px; color: #6b7280; line-height: 1.5; }
    .upload-zone span { color: #2563eb; font-weight: 600; }

    /* Row 2 col */
    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    /* Toggle */
    .toggle-field {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 14px; background: #f9fafb;
        border: 1.5px solid #e5e7eb; border-radius: 9px;
    }
    .toggle-info strong { font-size: 12.5px; color: #111827; display: block; }
    .toggle-info span { font-size: 11.5px; color: #6b7280; }
    .switch { position: relative; width: 40px; height: 22px; flex-shrink: 0; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider {
        position: absolute; inset: 0;
        background: #d1d5db; border-radius: 99px;
        cursor: pointer; transition: background .2s;
    }
    .slider:before {
        content: ''; position: absolute;
        width: 16px; height: 16px; background: #fff;
        border-radius: 50%; top: 3px; left: 3px;
        transition: transform .2s;
        box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }
    .switch input:checked + .slider { background: #2563eb; }
    .switch input:checked + .slider:before { transform: translateX(18px); }

    .form-divider { border: none; border-top: 1px solid #f3f4f6; margin: 2px 0; }

    /* Footer */
    .form-footer {
        padding: 16px 20px; border-top: 1px solid #f3f4f6;
        display: flex; align-items: center; gap: 8px;
        background: #fafafa;
    }
    .btn-submit {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 20px;
        background: linear-gradient(135deg,#2563eb,#1d4ed8);
        color: #fff; border: none; border-radius: 9px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        transition: opacity .15s, transform .1s;
        box-shadow: 0 2px 8px rgba(37,99,235,.3);
    }
    .btn-submit:hover { opacity: .9; transform: translateY(-1px); }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 9px 16px; background: #fff; color: #374151;
        border: 1.5px solid #e5e7eb; border-radius: 9px;
        font-size: 13px; font-weight: 600; text-decoration: none;
        transition: background .15s;
    }
    .btn-cancel:hover { background: #f9fafb; }

    /* ── PREVIEW CARD ── */
    .preview-body { padding: 20px; }

    /* Browser mockup */
    .browser-mockup {
        border: 1.5px solid #e5e7eb;
        border-radius: 10px; overflow: hidden;
    }
    .browser-bar {
        background: #f3f4f6; padding: 8px 12px;
        display: flex; align-items: center; gap: 8px;
        border-bottom: 1px solid #e5e7eb;
    }
    .browser-dots { display: flex; gap: 5px; }
    .browser-dots span {
        width: 10px; height: 10px; border-radius: 50%;
    }
    .dot-red { background: #f87171; }
    .dot-yellow { background: #fbbf24; }
    .dot-green { background: #34d399; }
    .browser-url {
        flex: 1; background: #fff; border: 1px solid #e5e7eb;
        border-radius: 5px; padding: 3px 10px;
        font-size: 11px; color: #9ca3af;
    }

    /* Banner preview area */
    .banner-preview-area {
        width: 100%; aspect-ratio: 3/1;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        position: relative; overflow: hidden;
        min-height: 120px;
    }
    .banner-preview-area img {
        width: 100%; height: 100%; object-fit: cover;
        display: none;
    }
    .banner-placeholder {
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 8px; color: #9ca3af; text-align: center;
        padding: 16px;
    }
    .banner-placeholder i { font-size: 28px; opacity: .4; }
    .banner-placeholder p { font-size: 12px; margin: 0; }

    /* Banner overlay info */
    .banner-overlay {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: linear-gradient(to top, rgba(0,0,0,.55), transparent);
        padding: 16px 14px 10px;
        display: none;
    }
    .banner-overlay-title {
        color: #fff; font-size: 13px; font-weight: 700;
        text-shadow: 0 1px 3px rgba(0,0,0,.5);
    }
    .banner-overlay-link {
        color: rgba(255,255,255,.75); font-size: 11px;
        margin-top: 2px; display: flex; align-items: center; gap: 4px;
    }

    /* Status badge */
    .preview-meta {
        margin-top: 14px;
        display: flex; flex-direction: column; gap: 10px;
    }
    .meta-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 12px; background: #f9fafb;
        border: 1px solid #f3f4f6; border-radius: 8px;
        font-size: 12px;
    }
    .meta-row .meta-label { color: #6b7280; display: flex; align-items: center; gap: 5px; }
    .meta-row .meta-val { font-weight: 600; color: #111827; }
    .status-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: #34d399; display: inline-block;
        box-shadow: 0 0 0 3px rgba(52,211,153,.2);
    }
    .status-dot.inactive { background: #d1d5db; box-shadow: none; }

    /* Tip box */
    .tip-box {
        margin-top: 14px;
        background: #eff6ff; border: 1px solid #bfdbfe;
        border-radius: 9px; padding: 12px 14px;
        font-size: 12px; color: #1d4ed8; line-height: 1.6;
    }
    .tip-box strong { display: block; margin-bottom: 4px; }
</style>

<div class="banner-layout">

    {{-- ── KOLOM KIRI: FORM ── --}}
    <div class="form-card">
        <div class="card-header">
            <h3>
                <span class="ch-icon blue"><i class="fa fa-plus"></i></span>
                Tambah Banner Baru
            </h3>
            <a href="{{ route('admin.banner.index') }}" class="btn-cancel" style="padding:6px 12px;font-size:12px;">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data" id="bannerForm">
            @csrf
            <div class="form-body">

                {{-- Judul --}}
                <div class="field-group">
                    <label class="field-label">Judul Banner <span class="badge-req">*</span></label>
                    <input type="text" name="title" id="inputTitle"
                           value="{{ old('title') }}" class="form-input"
                           placeholder="Contoh: Promo Hari Raya 2025..."
                           oninput="updatePreviewTitle(this.value)">
                    @error('title')
                        <span class="field-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Upload --}}
                <div class="field-group">
                    <label class="field-label">
                        Gambar <span class="badge-req">*</span>
                        <span class="badge-opt">Maks. 2MB · JPG PNG WEBP</span>
                    </label>
                    <div class="upload-zone" id="uploadZone">
                        <input type="file" name="image" accept="image/*"
                               id="imageInput" onchange="handleImagePreview(event)">
                        <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                        <p><span>Klik untuk upload</span> atau drag & drop</p>
                        <p style="font-size:11px;margin-top:3px;color:#b0b7c3;">Rekomendasi: 1200 × 400 px</p>
                    </div>
                    @error('image')
                        <span class="field-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Link --}}
                <div class="field-group">
                    <label class="field-label">URL Link <span class="badge-opt">Opsional</span></label>
                    <input type="url" name="link" id="inputLink"
                           value="{{ old('link') }}" class="form-input"
                           placeholder="https://..."
                           oninput="updatePreviewLink(this.value)">
                    @error('link')
                        <span class="field-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <hr class="form-divider">

                {{-- Urutan & Expired --}}
                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">Urutan</label>
                        <input type="number" name="sort_order" id="inputOrder"
                               value="{{ old('sort_order', 0) }}" min="0"
                               class="form-input"
                               oninput="updatePreviewOrder(this.value)">
                        <p class="field-hint">Angka kecil tampil lebih dulu</p>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Kadaluarsa <span class="badge-opt">Opsional</span></label>
                        <input type="datetime-local" name="expired_at"
                               value="{{ old('expired_at') }}" class="form-input"
                               oninput="updatePreviewExpiry(this.value)">
                        <p class="field-hint">Kosongkan jika tidak ada batas</p>
                    </div>
                </div>

                {{-- Toggle --}}
                <div class="toggle-field">
                    <div class="toggle-info">
                        <strong>Aktifkan Banner</strong>
                        <span>Tampil langsung di halaman utama</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="is_active" value="1" id="toggleActive"
                               checked onchange="updatePreviewStatus(this.checked)">
                        <span class="slider"></span>
                    </label>
                </div>

            </div>
            <div class="form-footer">
                <button type="submit" class="btn-submit">
                    <i class="fa fa-save"></i> Simpan Banner
                </button>
                <a href="{{ route('admin.banner.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>

    {{-- ── KOLOM KANAN: LIVE PREVIEW ── --}}
    <div style="position:sticky;top:20px;">
        <div class="preview-card">
            <div class="card-header">
                <h3>
                    <span class="ch-icon purple"><i class="fa fa-eye"></i></span>
                    Live Preview
                </h3>
                <span style="font-size:11px;color:#9ca3af;background:#f3f4f6;padding:3px 9px;border-radius:99px;">
                    Auto update
                </span>
            </div>
            <div class="preview-body">

                {{-- Browser mockup --}}
                <div class="browser-mockup">
                    <div class="browser-bar">
                        <div class="browser-dots">
                            <span class="dot-red"></span>
                            <span class="dot-yellow"></span>
                            <span class="dot-green"></span>
                        </div>
                        <div class="browser-url">umkm-padang.com</div>
                    </div>
                    <div class="banner-preview-area" id="bannerPreviewArea">
                        <div class="banner-placeholder" id="bannerPlaceholder">
                            <i class="fa fa-image"></i>
                            <p>Upload gambar untuk melihat preview</p>
                        </div>
                        <img id="previewImg" src="#" alt="Banner Preview">
                        <div class="banner-overlay" id="bannerOverlay">
                            <div class="banner-overlay-title" id="overlayTitle"></div>
                            <div class="banner-overlay-link" id="overlayLink" style="display:none;">
                                <i class="fa fa-link" style="font-size:10px;"></i>
                                <span id="overlayLinkText"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Meta info --}}
                <div class="preview-meta">
                    <div class="meta-row">
                        <span class="meta-label"><i class="fa fa-circle-o"></i> Status</span>
                        <span class="meta-val" id="previewStatus">
                            <span class="status-dot"></span> Aktif
                        </span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label"><i class="fa fa-sort"></i> Urutan</span>
                        <span class="meta-val" id="previewOrder">#0</span>
                    </div>
                    <div class="meta-row" id="previewExpiryRow" style="display:none;">
                        <span class="meta-label"><i class="fa fa-clock-o"></i> Kadaluarsa</span>
                        <span class="meta-val" id="previewExpiry" style="color:#f59e0b;">-</span>
                    </div>
                </div>

                {{-- Tips --}}
                <div class="tip-box">
                    <strong><i class="fa fa-lightbulb-o"></i> Tips Banner yang Bagus</strong>
                    Gunakan gambar <b>1200×400px</b> agar tidak pecah. Tambahkan judul singkat &amp; link yang relevan untuk meningkatkan klik pengunjung.
                </div>

            </div>
        </div>
    </div>

</div>

<script>
// Image preview
function handleImagePreview(event) {
    const file = event.target.files[0];
    if (!file) return;
    const img = document.getElementById('previewImg');
    const placeholder = document.getElementById('bannerPlaceholder');
    const overlay = document.getElementById('bannerOverlay');
    img.src = URL.createObjectURL(file);
    img.style.display = 'block';
    placeholder.style.display = 'none';
    // Show overlay if there's a title
    const title = document.getElementById('inputTitle').value;
    if (title) {
        overlay.style.display = 'block';
    }
    // Update upload zone appearance
    document.getElementById('uploadZone').style.borderColor = '#2563eb';
    document.getElementById('uploadZone').style.background = '#eff6ff';
}

// Drag & drop
const zone = document.getElementById('uploadZone');
zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
zone.addEventListener('drop', e => {
    e.preventDefault(); zone.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const input = document.getElementById('imageInput');
        const dt = new DataTransfer();
        dt.items.add(file); input.files = dt.files;
        handleImagePreview({ target: input });
    }
});

// Update overlay title
function updatePreviewTitle(val) {
    const overlay = document.getElementById('bannerOverlay');
    const overlayTitle = document.getElementById('overlayTitle');
    const hasImage = document.getElementById('previewImg').style.display === 'block';
    overlayTitle.textContent = val;
    if (val && hasImage) {
        overlay.style.display = 'block';
    } else if (!val) {
        overlay.style.display = 'none';
    }
}

// Update overlay link
function updatePreviewLink(val) {
    const overlayLink = document.getElementById('overlayLink');
    const overlayLinkText = document.getElementById('overlayLinkText');
    if (val) {
        try {
            const url = new URL(val);
            overlayLinkText.textContent = url.hostname;
            overlayLink.style.display = 'flex';
        } catch(e) {
            overlayLink.style.display = 'none';
        }
    } else {
        overlayLink.style.display = 'none';
    }
}

// Update order
function updatePreviewOrder(val) {
    document.getElementById('previewOrder').textContent = '#' + (val || 0);
}

// Update expiry
function updatePreviewExpiry(val) {
    const row = document.getElementById('previewExpiryRow');
    const el = document.getElementById('previewExpiry');
    if (val) {
        const d = new Date(val);
        el.textContent = d.toLocaleDateString('id-ID', {day:'2-digit',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'});
        row.style.display = 'flex';
    } else {
        row.style.display = 'none';
    }
}

// Update status
function updatePreviewStatus(checked) {
    const el = document.getElementById('previewStatus');
    if (checked) {
        el.innerHTML = '<span class="status-dot"></span> Aktif';
    } else {
        el.innerHTML = '<span class="status-dot inactive"></span> <span style="color:#9ca3af">Nonaktif</span>';
    }
}
</script>

@endsection