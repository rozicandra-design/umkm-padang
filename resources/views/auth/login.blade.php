@extends('layouts.public')
@section('title', 'Masuk')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ── Reset & Hide Footer ── */
.footer { display: none !important; }
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ── CSS Variables ── */
:root {
    --green:   #16a34a;
    --green-h: #15803d;
    --green-l: #f0fdf4;
    --green-m: #dcfce7;
    --ink:     #111827;
    --gray:    #6b7280;
    --gray2:   #374151;
    --border:  #e5e7eb;
    --red:     #dc2626;
}

/* ── Navbar Override ── */
.navbar {
    background: #fff !important;
    border-bottom: 1px solid var(--border) !important;
    box-shadow: none !important;
}

/* Sembunyikan emoji icon kotak, tampilkan teks saja */
.navbar .brand-icon { display: none !important; }

/* Brand / Logo teks */
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

/* Nav links */
.navbar .nav-link {
    color: var(--gray2) !important;
    font-weight: 500 !important;
    font-size: 14px !important;
}
.navbar .nav-link.active {
    color: var(--green) !important;
    font-weight: 600 !important;
}

/* Tombol Masuk */
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

/* Tombol Daftar */
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

/* ── Animations ── */
@keyframes pulse {
    0%, 100% { transform: scale(1);   opacity: .6; }
    50%       { transform: scale(1.6); opacity: 0;  }
}
@keyframes fadeup {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Layout ── */
.auth-wrap {
    display: grid;
    grid-template-columns: 1fr 440px;
    min-height: calc(100vh - 64px);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* ── Hero Side (Left) ── */
.hero-side {
    background: linear-gradient(150deg, #f4fef6 0%, #edfbf1 50%, #e5f8ec 100%);
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 56px 60px;
    position: relative;
    overflow: hidden;
}
.hero-side::after {
    content: '';
    position: absolute;
    width: 380px; height: 380px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(22,163,74,.07) 0%, transparent 70%);
    right: -80px; bottom: -80px;
    pointer-events: none;
}

/* Badge */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 100px;
    padding: 6px 16px 6px 10px;
    margin-bottom: 28px;
    width: fit-content;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.bdot {
    width: 8px; height: 8px;
    background: var(--green);
    border-radius: 50%;
    position: relative;
    flex-shrink: 0;
}
.bdot::after {
    content: '';
    position: absolute; inset: -3px;
    border-radius: 50%;
    border: 1.5px solid rgba(22,163,74,.35);
    animation: pulse 2s infinite;
}
.badge span { font-size: 13px; font-weight: 600; color: var(--ink); }

/* Headline */
.htitle {
    font-size: 40px;
    font-weight: 800;
    color: var(--ink);
    line-height: 1.15;
    letter-spacing: -.5px;
    margin-bottom: 14px;
}
.htitle .acc { color: var(--green); display: block; }

.hdesc {
    font-size: 14.5px;
    color: var(--gray);
    line-height: 1.75;
    max-width: 38ch;
    margin-bottom: 32px;
}

/* Stats */
.stats { display: flex; gap: 14px; margin-bottom: 32px; flex-wrap: wrap; }
.stat  {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 14px 20px;
    box-shadow: 0 1px 5px rgba(0,0,0,.05);
}
.stat-n { font-size: 20px; font-weight: 800; color: var(--ink); line-height: 1; margin-bottom: 4px; }
.stat-n sup { color: var(--green); font-size: 15px; }
.stat-l { font-size: 9.5px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--gray); }

/* Benefits */
.benefits { display: flex; flex-direction: column; gap: 11px; }
.benefit  { display: flex; align-items: flex-start; gap: 11px; }
.bico {
    width: 28px; height: 28px;
    background: var(--green-m);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}
.bico svg { width: 14px; height: 14px; stroke: var(--green); stroke-width: 2.5; fill: none; stroke-linecap: round; stroke-linejoin: round; }
.btxt { font-size: 13.5px; color: var(--gray2); font-weight: 500; line-height: 1.4; }
.btxt small { display: block; font-size: 12px; color: var(--gray); font-weight: 400; margin-top: 1px; }

/* ── Form Side (Right) ── */
.auth-form-side {
    background: #f0fdf4;
    border-left: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 48px 40px;
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: none;
}
.auth-form-side::-webkit-scrollbar { display: none; }

.auth-form-inner {
    animation: fadeup .45s ease both;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,.09), 0 2px 8px rgba(0,0,0,.05);
    padding: 36px 36px 30px;
    width: 100%;
    max-width: 380px;
    margin-top: 24px;
    margin-right: 24px;
}

/* Form Header */
.fh { margin-bottom: 20px; }
.fh h2 { font-size: 22px; font-weight: 800; color: var(--ink); margin-bottom: 4px; letter-spacing: -.3px; }
.fh p  { font-size: 13px; color: var(--gray); }
.fh a  { color: var(--green); font-weight: 600; text-decoration: none; }
.fh a:hover { text-decoration: underline; }

/* Error */
.err {
    background: #fff5f5;
    border: 1px solid #fecaca;
    border-left: 3px solid var(--red);
    border-radius: 10px;
    padding: 10px 13px;
    font-size: 13px; color: var(--red);
    margin-bottom: 16px;
    display: flex; align-items: flex-start; gap: 8px;
    line-height: 1.6;
}

/* Fields */
.fields { display: flex; flex-direction: column; gap: 13px; }
.field  { display: flex; flex-direction: column; gap: 4px; }
.fl { font-size: 13px; font-weight: 700; color: var(--ink); }
.fw { position: relative; display: flex; align-items: center; }
.fi {
    position: absolute; left: 13px;
    color: #9ca3af; font-size: 12px;
    pointer-events: none; width: 14px; text-align: center;
    transition: color .2s;
}
.finput {
    width: 100%;
    padding: 11px 14px 11px 38px;
    font-size: 14px; font-weight: 500;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--ink);
    background: #f9fafb;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    outline: none;
    transition: all .2s;
}
.finput::placeholder { color: #9ca3af; font-weight: 400; }
.finput:focus { border-color: var(--green); background: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
.fw:focus-within .fi { color: var(--green); }
.finput.is-invalid { border-color: #f87171; }
.ftog {
    position: absolute; right: 11px;
    background: none; border: none;
    color: #9ca3af; cursor: pointer;
    padding: 5px; font-size: 13px;
    display: flex; align-items: center;
    transition: color .15s;
}
.ftog:hover { color: var(--green); }
.ferr { font-size: 12px; color: var(--red); display: flex; align-items: center; gap: 4px; }

/* Remember + Forgot */
.field-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.check-label {
    display: flex; align-items: center; gap: 7px;
    font-size: 13px; color: var(--gray2);
    cursor: pointer; font-weight: 500;
}
.check-label input[type=checkbox] { width: 15px; height: 15px; accent-color: var(--green); cursor: pointer; }
.forgot-link { font-size: 13px; color: var(--green); font-weight: 600; text-decoration: none; }
.forgot-link:hover { text-decoration: underline; }

/* Submit Button */
.bsub {
    width: 100%;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    background: var(--green);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 13px 24px;
    font-size: 14.5px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    transition: all .18s;
    margin-top: 4px;
    box-shadow: 0 4px 14px rgba(22,163,74,.28);
}
.bsub:hover  { background: var(--green-h); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(22,163,74,.35); }
.bsub:active { transform: translateY(0); }

/* Divider */
.divider { display: flex; align-items: center; gap: 12px; margin: 16px 0 12px; }
.dline   { flex: 1; height: 1px; background: var(--border); }
.dtxt    { font-size: 11.5px; color: #9ca3af; white-space: nowrap; }

/* Demo Buttons */
.demo-label { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .7px; margin-bottom: 8px; }
.demo-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.demo-btn {
    display: flex; align-items: center; gap: 7px;
    padding: 9px 12px;
    background: #f9fafb;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 13px; font-weight: 600; color: var(--gray2);
    cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all .18s;
}
.demo-btn:hover { border-color: var(--green); background: var(--green-l); color: var(--green); transform: translateY(-1px); }

/* Footer Note */
.fnote { text-align: center; font-size: 13px; color: var(--gray); margin-top: 16px; line-height: 1.7; }
.fnote a { color: var(--green); font-weight: 600; text-decoration: none; }
.fnote a:hover { text-decoration: underline; }

/* ── Responsive ── */
@media (max-width: 900px) {
    .auth-wrap       { grid-template-columns: 1fr; height: auto; overflow: visible; }
    .hero-side       { padding: 36px 24px; overflow: visible; }
    .auth-form-side  { border-left: none; border-top: 1px solid var(--border); padding: 24px; align-items: flex-start; }
    .auth-form-inner { margin-top: 0; margin-right: 0; }
    .htitle          { font-size: 28px; }
}
</style>
@endpush

@section('content')
<div class="auth-wrap">

    {{-- ══ LEFT: Hero ══ --}}
    <div class="hero-side">

        <div class="badge">
            <span class="bdot"></span>
            <span>Marketplace Resmi UMKM Kota Padang</span>
        </div>

        <h1 class="htitle">
            Selamat Datang
            <span class="acc">Kembali!</span>
        </h1>

        <p class="hdesc">
            Masuk ke akun Anda dan temukan ribuan produk terbaik dari UMKM unggulan Kota Padang.
        </p>

        <div class="stats">
            <div class="stat">
                <div class="stat-n">{{ number_format($stats['total_umkm'] ?? 0) }}<sup>+</sup></div>
                <div class="stat-l">UMKM Terdaftar</div>
            </div>
            <div class="stat">
                <div class="stat-n">{{ number_format($stats['total_produk'] ?? 0) }}<sup>+</sup></div>
                <div class="stat-l">Produk Tersedia</div>
            </div>
            <div class="stat">
                <div class="stat-n">{{ number_format($stats['total_customer'] ?? 0) }}<sup>+</sup></div>
                <div class="stat-l">Pelanggan Aktif</div>
            </div>
        </div>

        <div class="benefits">
            <div class="benefit">
                <div class="bico">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="btxt">
                    Akses Ratusan Produk UMKM Terverifikasi
                    <small>Dari seluruh kecamatan di Kota Padang</small>
                </div>
            </div>
            <div class="benefit">
                <div class="bico">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 15"/></svg>
                </div>
                <div class="btxt">
                    Pesan &amp; Lacak Status Real-time
                    <small>Notifikasi update langsung di akun Anda</small>
                </div>
            </div>
            <div class="benefit">
                <div class="bico">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="btxt">
                    100% Gratis &amp; Dikelola Resmi
                    <small>Oleh Dinas Koperasi &amp; UMKM Kota Padang</small>
                </div>
            </div>
        </div>

    </div>

    {{-- ══ RIGHT: Form ══ --}}
    <div class="auth-form-side">
        <div class="auth-form-inner">

            {{-- Header --}}
            <div class="fh">
                <h2>Masuk ke Akun</h2>
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a></p>
            </div>

            {{-- Session Error --}}
            @if (session('error'))
                <div class="err">
                    <i class="fa fa-exclamation-circle" style="flex-shrink:0; margin-top:1px;"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('login') }}" method="POST" class="fields">
                @csrf

                {{-- Email --}}
                <div class="field">
                    <label class="fl" for="email">Email</label>
                    <div class="fw">
                        <i class="fa fa-envelope fi"></i>
                        <input type="email" name="email" id="email"
                            class="finput @error('email') is-invalid @enderror"
                            placeholder="email@contoh.com"
                            value="{{ old('email') }}"
                            required autofocus autocomplete="email">
                    </div>
                    @error('email')
                        <div class="ferr"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="field">
                    <label class="fl" for="password">Password</label>
                    <div class="fw">
                        <i class="fa fa-lock fi"></i>
                        <input type="password" name="password" id="password"
                            class="finput @error('password') is-invalid @enderror"
                            placeholder="Masukkan password"
                            required autocomplete="current-password">
                        <button type="button" class="ftog" onclick="togPw('password', 'eyeIcon')">
                            <i class="fa fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="ferr"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember & Forgot --}}
                <div class="field-row">
                    <label class="check-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Ingat saya
                    </label>
                    <a href="#" class="forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="bsub">
                    <i class="fa fa-sign-in-alt"></i> Masuk
                </button>

            </form>

            <p class="fnote">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar Pelanggan</a> atau
                <a href="{{ route('register.umkm') }}">Daftarkan UMKM</a>
            </p>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function togPw(inputId, iconId) {
    const input  = document.getElementById(inputId);
    const icon   = document.getElementById(iconId);
    const isHidden = input.type === 'password';
    input.type     = isHidden ? 'text'            : 'password';
    icon.className = isHidden ? 'fa fa-eye-slash' : 'fa fa-eye';
}
</script>
@endpush