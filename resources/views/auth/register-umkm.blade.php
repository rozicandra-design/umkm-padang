@extends('layouts.public')
@section('title', 'Daftar UMKM')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700&display=swap" rel="stylesheet">
<style>
/* ── Reset & Utilities ── */
.footer { display: none !important; }
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ── Navbar Override ── */
.navbar {
    background: #fff !important;
    border-bottom: 1px solid var(--border) !important;
    box-shadow: none !important;
}
.navbar .brand-icon { display: none !important; }
.navbar-brand {
    text-decoration: none !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
}
.navbar-brand .brand-name {
    color: var(--ink) !important;
    font-weight: 800 !important;
    font-size: 17px !important;
    line-height: 1.2 !important;
}
.navbar-brand .brand-sub {
    color: var(--gray) !important;
    font-size: 11px !important;
    font-weight: 500 !important;
}
.navbar .nav-link { color: var(--gray2) !important; font-weight: 500 !important; font-size: 14px !important; }
.navbar .nav-link.active { color: var(--green) !important; font-weight: 600 !important; }
.navbar .btn-outline-white {
    background: none !important;
    border: 1px solid var(--border) !important;
    color: var(--gray2) !important;
    font-weight: 500 !important;
    font-size: 14px !important;
    border-radius: 10px !important;
    padding: 8px 16px !important;
    box-shadow: none !important;
}
.navbar .btn-gold {
    background: var(--green) !important;
    color: #fff !important;
    border: none !important;
    border-radius: 10px !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    padding: 10px 24px !important;
    box-shadow: none !important;
}

/* ── CSS Variables ── */
:root {
    --green:   #16a34a;
    --green-h: #15803d;
    --green-l: #f0fdf4;
    --green-m: #dcfce7;
    --ink:     #0f1a13;
    --gray:    #6b7280;
    --gray2:   #374151;
    --border:  #e5e7eb;
    --bg:      #ffffff;
    --ember:   #dc2626;
}

/* ── Animations ── */
@keyframes reveal {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes pulse-ring {
    0%, 100% { transform: scale(1);   opacity: .6; }
    50%       { transform: scale(1.5); opacity: 0;  }
}

/* ── Layout ── */
.auth-wrap {
    display: grid;
    grid-template-columns: 1fr 500px;
    min-height: calc(100vh - 64px);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* ── Hero Side (Left) ── */
.hero-side {
    background: linear-gradient(160deg, #f8fff9 0%, #f0fdf4 60%, #e8f9ee 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    padding: 100px clamp(40px, 6vw, 88px) 48px;
    position: relative;
    overflow: hidden;
}
.hero-side::before {
    content: '';
    position: absolute;
    width: 480px; height: 480px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(22,163,74,.07) 0%, transparent 70%);
    right: -80px; bottom: -80px;
    pointer-events: none;
}

/* Badge */
.hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: #fff; border: 1px solid var(--border); border-radius: 100px;
    padding: 6px 16px 6px 10px; margin-bottom: 28px; width: fit-content;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.badge-dot {
    width: 8px; height: 8px; background: var(--green);
    border-radius: 50%; position: relative;
}
.badge-dot::after {
    content: ''; position: absolute; inset: -3px; border-radius: 50%;
    border: 1.5px solid rgba(22,163,74,.3); animation: pulse-ring 2s infinite;
}
.hero-badge span { font-size: 13px; font-weight: 600; color: var(--ink); }

/* Headline */
.hero-title {
    font-size: clamp(28px, 3vw, 44px);
    font-weight: 800; color: var(--ink);
    line-height: 1.15; letter-spacing: -.5px; margin-bottom: 16px;
}
.hero-title .accent { color: var(--green); }
.hero-desc {
    font-size: 15px; color: var(--gray); line-height: 1.75;
    max-width: 38ch; margin-bottom: 36px;
}

/* Step cards */
.hero-steps { display: flex; flex-direction: column; gap: 14px; margin-bottom: 36px; }
.step-card {
    display: flex; align-items: flex-start; gap: 14px;
    background: #fff; border: 1px solid var(--border);
    border-radius: 14px; padding: 14px 18px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.step-num {
    width: 30px; height: 30px; background: var(--green); color: #fff;
    border-radius: 50%; font-size: 13px; font-weight: 800;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.step-txt { font-size: 13.5px; font-weight: 600; color: var(--ink); line-height: 1.4; }
.step-txt small { display: block; font-size: 12px; color: var(--gray); font-weight: 400; margin-top: 2px; }

/* Benefits */
.hero-benefits { display: flex; flex-direction: column; gap: 10px; }
.benefit-pill  { display: flex; align-items: center; gap: 10px; font-size: 13.5px; color: #374151; font-weight: 500; }
.benefit-pill-ico {
    width: 28px; height: 28px; background: var(--green-m); border-radius: 8px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.benefit-pill-ico svg { width: 14px; height: 14px; stroke: var(--green); stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
.benefit-pill small { display: block; font-size: 11.5px; color: var(--gray); font-weight: 400; }

/* ── Form Side (Right) ── */
.auth-form-side {
    background: #f0fdf4;
    border-left: 1px solid var(--border);
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 60px 48px 40px;
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: none;
}
.auth-form-side::-webkit-scrollbar { display: none; }

.auth-form-inner {
    width: 100%;
    max-width: 400px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,.09), 0 2px 8px rgba(0,0,0,.05);
    padding: 36px 36px 30px;
    animation: reveal .5s ease both;
    margin-top: 24px;
    margin-right: 24px;
}

/* Tabs */
.auth-tabs {
    display: grid; grid-template-columns: 1fr 1fr;
    background: var(--green-l); border-radius: 12px;
    padding: 4px; gap: 4px; margin-bottom: 28px;
}
.auth-tab {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    padding: 9px 12px; border-radius: 9px;
    font-size: 13px; font-weight: 600; color: #6b9e78;
    text-decoration: none; transition: all .2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
    border: none; background: transparent; cursor: pointer;
}
.auth-tab.active { background: var(--green); color: #fff; box-shadow: 0 2px 8px rgba(22,163,74,.25); }
.auth-tab:hover:not(.active) { color: var(--green); }

/* Form Header */
.form-header { margin-bottom: 22px; }
.form-header h2 { font-size: 22px; font-weight: 800; color: var(--ink); margin-bottom: 5px; letter-spacing: -.3px; }
.form-header p  { font-size: 13.5px; color: var(--gray); }
.form-header p a { color: var(--green); font-weight: 600; text-decoration: none; }
.form-header p a:hover { text-decoration: underline; }

/* Section divider */
.section-divider {
    display: flex; align-items: center; gap: 10px;
    margin: 18px 0 14px;
}
.section-divider-line { flex: 1; height: 1px; background: var(--border); }
.section-divider-label {
    font-size: 11px; font-weight: 700; color: #9ca3af;
    text-transform: uppercase; letter-spacing: .8px; white-space: nowrap;
}

/* Alert */
.alert-error {
    background: #fff5f5; border: 1px solid #fecaca;
    border-left: 3px solid var(--ember); border-radius: 10px;
    padding: 11px 14px; font-size: 13px; color: var(--ember);
    margin-bottom: 18px; display: flex; align-items: flex-start; gap: 8px; line-height: 1.6;
}

/* Fields */
.form-body  { display: flex; flex-direction: column; gap: 14px; }
.field      { display: flex; flex-direction: column; gap: 5px; }
.field-label { font-size: 13px; font-weight: 700; color: var(--ink); }
.field-wrap  { position: relative; display: flex; align-items: center; }
.field-ico   { position: absolute; left: 13px; color: #9ca3af; font-size: 13px; pointer-events: none; width: 14px; text-align: center; transition: color .2s; }
.field-input {
    width: 100%; padding: 11px 14px 11px 38px;
    font-size: 14px; font-weight: 500;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--ink); background: #f9fafb;
    border: 1.5px solid var(--border); border-radius: 10px;
    outline: none; transition: all .2s;
}
.field-input::placeholder { color: #9ca3af; font-weight: 400; }
.field-input:focus { border-color: var(--green); background: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
.field-wrap:focus-within .field-ico { color: var(--green); }
.field-input.is-invalid { border-color: #f87171; }

/* Select */
.field-select {
    width: 100%; padding: 11px 36px 11px 38px;
    font-size: 14px; font-weight: 500;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--ink); background: #f9fafb;
    border: 1.5px solid var(--border); border-radius: 10px;
    outline: none; transition: all .2s;
    appearance: none; cursor: pointer;
}
.field-select:focus { border-color: var(--green); background: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
.field-select.is-invalid { border-color: #f87171; }
.field-wrap:focus-within .field-ico { color: var(--green); }
.select-arrow {
    position: absolute; right: 13px; color: #9ca3af;
    font-size: 11px; pointer-events: none;
}

/* Textarea */
.field-textarea {
    width: 100%; padding: 11px 14px 11px 38px;
    font-size: 14px; font-weight: 500;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--ink); background: #f9fafb;
    border: 1.5px solid var(--border); border-radius: 10px;
    outline: none; transition: all .2s; resize: none;
}
.field-textarea::placeholder { color: #9ca3af; font-weight: 400; }
.field-textarea:focus { border-color: var(--green); background: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
.field-textarea.is-invalid { border-color: #f87171; }
.field-wrap.textarea-wrap { align-items: flex-start; }
.field-wrap.textarea-wrap .field-ico { top: 13px; }

/* Toggle password */
.field-toggle { position: absolute; right: 11px; background: none; border: none; color: #9ca3af; cursor: pointer; padding: 5px; font-size: 13px; display: flex; align-items: center; transition: color .15s; }
.field-toggle:hover { color: var(--green); }
.field-error { font-size: 12px; color: var(--ember); display: flex; align-items: center; gap: 4px; }

/* Password Strength */
.pw-strength { display: flex; align-items: center; gap: 8px; margin-top: 7px; }
.pw-bars     { display: flex; gap: 4px; flex: 1; }
.pw-bar      { flex: 1; height: 3px; background: #e5e7eb; border-radius: 99px; transition: background .25s; }
.pw-bar.weak   { background: #f87171; }
.pw-bar.medium { background: #fbbf24; }
.pw-bar.strong { background: var(--green); }
.pw-hint { font-size: 11px; color: #9ca3af; white-space: nowrap; text-align: right; }

/* Info note */
.field-note {
    font-size: 11.5px; color: var(--gray);
    background: var(--green-l); border: 1px solid var(--green-m);
    border-radius: 8px; padding: 8px 12px;
    display: flex; align-items: flex-start; gap: 7px; line-height: 1.6;
}

/* Terms */
.terms-label { display: flex; align-items: flex-start; gap: 9px; font-size: 13px; color: #374151; cursor: pointer; line-height: 1.6; }
.terms-label input[type=checkbox] { width: 15px; height: 15px; accent-color: var(--green); cursor: pointer; flex-shrink: 0; margin-top: 2px; }
.terms-label a { color: var(--green); font-weight: 600; text-decoration: none; }
.terms-label a:hover { text-decoration: underline; }

/* Submit */
.btn-submit {
    width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;
    background: var(--green); color: #fff; border: none; border-radius: 10px;
    padding: 13px 24px; font-size: 14.5px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
    transition: all .18s; margin-top: 4px;
    box-shadow: 0 4px 14px rgba(22,163,74,.3);
}
.btn-submit:hover  { background: var(--green-h); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(22,163,74,.35); }
.btn-submit:active { transform: translateY(0); }

/* Footer */
.form-divider { display: flex; align-items: center; gap: 12px; margin-top: 18px; }
.form-divider-line { flex: 1; height: 1px; background: var(--border); }
.form-divider-text { font-size: 11.5px; color: #9ca3af; white-space: nowrap; }
.form-footer   { text-align: center; font-size: 13px; color: var(--gray); margin-top: 16px; }
.form-footer a { color: var(--green); font-weight: 600; text-decoration: none; }
.form-footer a:hover { text-decoration: underline; }

/* ── Responsive ── */
@media (max-width: 900px) {
    .auth-wrap      { grid-template-columns: 1fr; }
    .hero-side      { padding: 40px 28px 36px; min-height: auto; }
    .auth-form-side { border-left: none; border-top: 1px solid var(--border); padding: 40px 28px 52px; align-items: flex-start; }
    .auth-form-inner { margin-top: 0; margin-right: 0; }
}
</style>
@endpush

@section('content')
<div class="auth-wrap">

    {{-- ══ LEFT: Hero ══ --}}
    <div class="hero-side">

        <div class="hero-badge">
            <span class="badge-dot"></span>
            <span>Marketplace Resmi UMKM Kota Padang</span>
        </div>

        <h1 class="hero-title">
            Daftarkan UMKM &amp;<br>
            <span class="accent">Jangkau Lebih Banyak Pembeli</span>
        </h1>

        <p class="hero-desc">
            Bergabunglah dengan ratusan UMKM lokal Kota Padang. Tampilkan produk Anda dan raih pelanggan baru secara digital.
        </p>

        <div class="hero-steps">
            <div class="step-card">
                <div class="step-num">1</div>
                <div class="step-txt">
                    Isi Formulir Pendaftaran
                    <small>Data akun &amp; profil UMKM Anda</small>
                </div>
            </div>
            <div class="step-card">
                <div class="step-num">2</div>
                <div class="step-txt">
                    Tunggu Verifikasi Admin
                    <small>Proses verifikasi 1–2 hari kerja</small>
                </div>
            </div>
            <div class="step-card">
                <div class="step-num">3</div>
                <div class="step-txt">
                    Mulai Kelola Toko &amp; Produk
                    <small>Upload produk &amp; terima pesanan</small>
                </div>
            </div>
        </div>

        <div class="hero-benefits">
            <div class="benefit-pill">
                <div class="benefit-pill-ico">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div>
                    Gratis Selamanya, Tanpa Komisi
                    <small>Tidak ada potongan dari setiap transaksi</small>
                </div>
            </div>
            <div class="benefit-pill">
                <div class="benefit-pill-ico">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 9h18M9 21V9"/></svg>
                </div>
                <div>
                    Dashboard Manajemen Lengkap
                    <small>Kelola produk, pesanan &amp; laporan penjualan</small>
                </div>
            </div>
            <div class="benefit-pill">
                <div class="benefit-pill-ico">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 15"/></svg>
                </div>
                <div>
                    Dukungan Resmi Dinas UMKM
                    <small>Didukung penuh oleh Pemerintah Kota Padang</small>
                </div>
            </div>
        </div>

    </div>

    {{-- ══ RIGHT: Form ══ --}}
    <div class="auth-form-side">
        <div class="auth-form-inner">

            {{-- Tabs --}}
            <div class="auth-tabs">
                <a href="{{ route('register') }}"      class="auth-tab">👤 Pelanggan</a>
                <a href="{{ route('register.umkm') }}" class="auth-tab active">🏪 Pemilik UMKM</a>
            </div>

            {{-- Header --}}
            <div class="form-header">
                <h2>Daftar sebagai UMKM</h2>
                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a></p>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert-error">
                    <i class="fa fa-exclamation-circle" style="flex-shrink:0; margin-top:1px;"></i>
                    <div>
                        @foreach ($errors->all() as $e)
                            <div>{{ $e }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('register.umkm') }}" method="POST" class="form-body">
                @csrf

                {{-- ── AKUN ── --}}
                <div class="section-divider">
                    <div class="section-divider-line"></div>
                    <div class="section-divider-label">Data Akun</div>
                    <div class="section-divider-line"></div>
                </div>

                {{-- Nama Pemilik --}}
                <div class="field">
                    <label class="field-label" for="name">Nama Pemilik</label>
                    <div class="field-wrap">
                        <i class="fa fa-user field-ico"></i>
                        <input type="text" name="name" id="name"
                            class="field-input @error('name') is-invalid @enderror"
                            placeholder="Nama lengkap pemilik"
                            value="{{ old('name') }}"
                            required autofocus autocomplete="name">
                    </div>
                    @error('name')
                        <div class="field-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="field">
                    <label class="field-label" for="email">Email</label>
                    <div class="field-wrap">
                        <i class="fa fa-envelope field-ico"></i>
                        <input type="email" name="email" id="email"
                            class="field-input @error('email') is-invalid @enderror"
                            placeholder="email@contoh.com"
                            value="{{ old('email') }}"
                            required autocomplete="email">
                    </div>
                    @error('email')
                        <div class="field-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="field">
                    <label class="field-label" for="password">Password</label>
                    <div class="field-wrap">
                        <i class="fa fa-lock field-ico"></i>
                        <input type="password" name="password" id="password"
                            class="field-input @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter"
                            required autocomplete="new-password"
                            oninput="checkStrength(this.value)">
                        <button type="button" class="field-toggle" onclick="togglePw('password', 'eye1')">
                            <i class="fa fa-eye" id="eye1"></i>
                        </button>
                    </div>
                    <div class="pw-strength">
                        <div class="pw-bars">
                            <div class="pw-bar" id="bar1"></div>
                            <div class="pw-bar" id="bar2"></div>
                            <div class="pw-bar" id="bar3"></div>
                            <div class="pw-bar" id="bar4"></div>
                        </div>
                        <div class="pw-hint" id="pwHint">Masukkan password</div>
                    </div>
                    @error('password')
                        <div class="field-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="field">
                    <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
                    <div class="field-wrap">
                        <i class="fa fa-lock field-ico"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="field-input"
                            placeholder="Ulangi password"
                            required autocomplete="new-password">
                        <button type="button" class="field-toggle" onclick="togglePw('password_confirmation', 'eye2')">
                            <i class="fa fa-eye" id="eye2"></i>
                        </button>
                    </div>
                </div>

                {{-- ── PROFIL UMKM ── --}}
                <div class="section-divider">
                    <div class="section-divider-line"></div>
                    <div class="section-divider-label">Profil UMKM</div>
                    <div class="section-divider-line"></div>
                </div>

                {{-- Nama UMKM --}}
                <div class="field">
                    <label class="field-label" for="umkm_name">Nama UMKM</label>
                    <div class="field-wrap">
                        <i class="fa fa-store field-ico"></i>
                        <input type="text" name="umkm_name" id="umkm_name"
                            class="field-input @error('umkm_name') is-invalid @enderror"
                            placeholder="Nama usaha Anda"
                            value="{{ old('umkm_name') }}"
                            required>
                    </div>
                    @error('umkm_name')
                        <div class="field-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="field">
                    <label class="field-label" for="category_id">Kategori Usaha</label>
                    <div class="field-wrap">
                        <i class="fa fa-tag field-ico"></i>
                        <select name="category_id" id="category_id"
                            class="field-select @error('category_id') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fa fa-chevron-down select-arrow"></i>
                    </div>
                    @error('category_id')
                        <div class="field-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- No. WhatsApp --}}
                <div class="field">
                    <label class="field-label" for="whatsapp">Nomor WhatsApp</label>
                    <div class="field-wrap">
                        <i class="fa fa-phone field-ico"></i>
                        <input type="text" name="whatsapp" id="whatsapp"
                            class="field-input @error('whatsapp') is-invalid @enderror"
                            placeholder="08xx-xxxx-xxxx"
                            value="{{ old('whatsapp') }}"
                            autocomplete="tel">
                    </div>
                    @error('whatsapp')
                        <div class="field-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- ── LOKASI ── --}}
                <div class="section-divider">
                    <div class="section-divider-line"></div>
                    <div class="section-divider-label">Lokasi</div>
                    <div class="section-divider-line"></div>
                </div>

                {{-- Kecamatan --}}
                <div class="field">
                    <label class="field-label" for="kecamatan">Kecamatan</label>
                    <div class="field-wrap">
                        <i class="fa fa-map-marker-alt field-ico"></i>
                        <select name="kecamatan" id="kecamatan"
                            class="field-select @error('kecamatan') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ([
                                'Bungus Teluk Kabung','Koto Tangah','Kuranji','Lubuk Begalung',
                                'Lubuk Kilangan','Nanggalo','Padang Barat','Padang Selatan',
                                'Padang Timur','Padang Utara','Pauh'
                            ] as $kec)
                                <option value="{{ $kec }}" {{ old('kecamatan') == $kec ? 'selected' : '' }}>
                                    {{ $kec }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fa fa-chevron-down select-arrow"></i>
                    </div>
                    @error('kecamatan')
                        <div class="field-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat Lengkap --}}
                <div class="field">
                    <label class="field-label" for="address">Alamat Lengkap</label>
                    <div class="field-wrap textarea-wrap">
                        <i class="fa fa-map field-ico"></i>
                        <textarea name="address" id="address" rows="2"
                            class="field-textarea @error('address') is-invalid @enderror"
                            placeholder="Jl. Nama Jalan No. XX, Kelurahan"
                            required>{{ old('address') }}</textarea>
                    </div>
                    @error('address')
                        <div class="field-error"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Info verifikasi --}}
                <div class="field-note">
                    <i class="fa fa-info-circle" style="color:var(--green); margin-top:1px; flex-shrink:0;"></i>
                    Akun UMKM Anda akan diverifikasi admin dalam <strong>1–2 hari kerja</strong> setelah pendaftaran.
                </div>

                {{-- Terms --}}
                <div class="field">
                    <label class="terms-label">
                        <input type="checkbox" name="terms" required>
                        Saya menyetujui <a href="#">Syarat &amp; Ketentuan</a> dan
                        <a href="#">Kebijakan Privasi</a> UMKM Padang
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa fa-store"></i> Daftarkan UMKM Saya
                </button>

            </form>

            <div class="form-divider">
                <div class="form-divider-line"></div>
                <div class="form-divider-text">atau</div>
                <div class="form-divider-line"></div>
            </div>

            <p class="form-footer">
                Daftar sebagai pelanggan? <a href="{{ route('register') }}">Daftar di sini →</a>
            </p>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function togglePw(inputId, iconId) {
    const input    = document.getElementById(inputId);
    const icon     = document.getElementById(iconId);
    const isHidden = input.type === 'password';
    input.type     = isHidden ? 'text'            : 'password';
    icon.className = isHidden ? 'fa fa-eye-slash' : 'fa fa-eye';
}

function checkStrength(pw) {
    const bars = ['bar1', 'bar2', 'bar3', 'bar4'].map(id => document.getElementById(id));
    const hint = document.getElementById('pwHint');

    bars.forEach(b => b.className = 'pw-bar');

    if (!pw) {
        hint.textContent = 'Masukkan password';
        hint.style.color = '#9ca3af';
        return;
    }

    let score = 0;
    if (pw.length >= 8)           score++;
    if (/[A-Z]/.test(pw))         score++;
    if (/[0-9]/.test(pw))         score++;
    if (/[^A-Za-z0-9]/.test(pw))  score++;

    const levels = [
        { cls: 'weak',   text: 'Terlalu lemah', color: '#f87171' },
        { cls: 'weak',   text: 'Lemah',          color: '#f87171' },
        { cls: 'medium', text: 'Cukup kuat',     color: '#d97706' },
        { cls: 'strong', text: 'Kuat',            color: '#16a34a' },
        { cls: 'strong', text: 'Sangat kuat!',    color: '#16a34a' },
    ];

    const level = levels[score];
    bars.slice(0, score).forEach(b => b.classList.add(level.cls));
    hint.textContent = level.text;
    hint.style.color = level.color;
}
</script>
@endpush