<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'UMKM Padang') — Platform UMKM Kota Padang</title>
<meta name="description" content="@yield('meta_desc', 'Temukan produk terbaik dari UMKM Kota Padang')">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stack('styles')
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar">
  <div class="container navbar-inner">
    <a href="{{ route('home') }}" class="navbar-brand">
      <div class="brand-icon">🏪</div>
      <div>
        <div class="brand-name">UMKM Padang</div>
        <div class="brand-sub">Kota Padang</div>
      </div>
    </a>
    <div class="navbar-menu" id="navMenu">
      <a href="{{ route('katalog') }}" class="nav-link {{ request()->routeIs('katalog*') ? 'active' : '' }}">Katalog</a>
      <a href="{{ route('umkm.index') }}" class="nav-link {{ request()->routeIs('umkm*') ? 'active' : '' }}">UMKM</a>
      <a href="{{ route('peta') }}" class="nav-link {{ request()->routeIs('peta') ? 'active' : '' }}">Peta</a>
      <a href="{{ route('tentang') }}" class="nav-link">Tentang</a>
    </div>
    <div class="navbar-actions">
      @auth
        <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="btn btn-outline-white">
          <i class="fa fa-tachometer-alt"></i> Dashboard
        </a>
      @else
        <a href="{{ route('login') }}" class="btn btn-outline-white">Masuk</a>
        <a href="{{ route('register') }}" class="btn btn-gold">Daftar</a>
      @endauth
    </div>
    <button class="nav-toggle" onclick="document.getElementById('navMenu').classList.toggle('open')">
      <i class="fa fa-bars"></i>
    </button>
  </div>
</nav>

{{-- FLASH MESSAGES --}}
@if(session('success') || session('error') || session('info') || session('warning'))
<div class="flash-container">
  @foreach(['success'=>'check-circle','error'=>'times-circle','info'=>'info-circle','warning'=>'exclamation-triangle'] as $type => $icon)
    @if(session($type))
      <div class="flash flash-{{ $type }}">
        <i class="fa fa-{{ $icon }}"></i> {{ session($type) }}
        <button onclick="this.parentElement.remove()" class="flash-close">&times;</button>
      </div>
    @endif
  @endforeach
</div>
@endif

{{-- MAIN CONTENT --}}
@yield('content')

{{-- FOOTER --}}
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="footer-logo">
          <div class="brand-icon">🏪</div>
          <div class="brand-name" style="color:#fff">UMKM Padang</div>
        </div>
        <p class="footer-desc">Platform digital resmi untuk mendukung UMKM Kota Padang. Dikelola oleh Dinas Koperasi & UMKM Kota Padang.</p>
        <div class="social-links">
          <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
      <div>
        <h4 class="footer-heading">Platform</h4>
        <ul class="footer-links">
          <li><a href="{{ route('home') }}">Beranda</a></li>
          <li><a href="{{ route('katalog') }}">Katalog Produk</a></li>
          <li><a href="{{ route('umkm.index') }}">Daftar UMKM</a></li>
          <li><a href="{{ route('peta') }}">Peta UMKM</a></li>
          <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
        </ul>
      </div>
      <div>
        <h4 class="footer-heading">Daftar</h4>
        <ul class="footer-links">
          <li><a href="{{ route('register') }}">Daftar sebagai Pelanggan</a></li>
          <li><a href="{{ route('register.umkm') }}">Daftarkan UMKM Anda</a></li>
          <li><a href="{{ route('login') }}">Masuk ke Akun</a></li>
        </ul>
      </div>
      <div>
        <h4 class="footer-heading">Kontak</h4>
        <ul class="footer-links">
          <li><i class="fa fa-map-marker-alt"></i> Jl. Bagindo Aziz Chan, Padang</li>
          <li><i class="fa fa-phone"></i> (0751) 123-4567</li>
          <li><i class="fa fa-envelope"></i> info@umkmpadang.id</li>
          <li><i class="fa fa-clock"></i> Sen–Jum 08.00–16.00</li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© {{ date('Y') }} UMKM Padang · Dinas Koperasi & UMKM Kota Padang</span>
      <span><a href="#">Kebijakan Privasi</a> · <a href="#">Syarat & Ketentuan</a></span>
    </div>
  </div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
