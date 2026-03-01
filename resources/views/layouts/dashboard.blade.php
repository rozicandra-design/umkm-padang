<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard') — UMKM Padang</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@stack('styles')
</head>
<body class="dashboard-body">

{{-- SIDEBAR --}}
<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <a href="{{ route('home') }}" class="sidebar-brand">
      <span class="brand-icon-sm">🏪</span>
      <span class="brand-text">UMKM Padang</span>
    </a>
    <button class="sidebar-close" onclick="toggleSidebar()"><i class="fa fa-times"></i></button>
  </div>

  <div class="sidebar-user">
    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
    <div class="user-info">
      <div class="user-name">{{ auth()->user()->name }}</div>
      <div class="user-role">
        @switch(auth()->user()->role)
          @case('admin') ⚙️ Administrator @break
          @case('umkm') 🏪 Pemilik UMKM @break
          @case('dinas') 🏛️ Dinas @break
          @default 👤 Pelanggan
        @endswitch
      </div>
    </div>
  </div>

  <nav class="sidebar-nav">
    @if(auth()->user()->isAdmin())
      <div class="nav-section-title">Admin Panel</div>
      <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
      <a href="{{ route('admin.verifikasi.index') }}" class="sidebar-link {{ request()->routeIs('admin.verifikasi*') ? 'active' : '' }}"><i class="fa fa-check-circle"></i> Verifikasi UMKM @if($pendingCount = \App\Models\UmkmProfile::pending()->count()) <span class="badge-count">{{ $pendingCount }}</span> @endif</a>
      <a href="{{ route('admin.umkm.index') }}" class="sidebar-link {{ request()->routeIs('admin.umkm*') ? 'active' : '' }}"><i class="fa fa-store"></i> Kelola UMKM</a>
      <a href="{{ route('admin.pengguna.index') }}" class="sidebar-link {{ request()->routeIs('admin.pengguna*') ? 'active' : '' }}"><i class="fa fa-users"></i> Pengguna</a>
      <a href="{{ route('admin.kategori.index') }}" class="sidebar-link {{ request()->routeIs('admin.kategori*') ? 'active' : '' }}"><i class="fa fa-tags"></i> Kategori</a>
      <a href="{{ route('admin.banner.index') }}" class="sidebar-link {{ request()->routeIs('admin.banner*') ? 'active' : '' }}"><i class="fa fa-image"></i> Banner</a>
      <a href="{{ route('admin.laporan') }}" class="sidebar-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }}"><i class="fa fa-chart-bar"></i> Laporan</a>
    @elseif(auth()->user()->isUmkm())
      <div class="nav-section-title">Toko Saya</div>
      <a href="{{ route('umkm.dashboard') }}" class="sidebar-link {{ request()->routeIs('umkm.dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
      <a href="{{ route('umkm.produk.index') }}" class="sidebar-link {{ request()->routeIs('umkm.produk*') ? 'active' : '' }}"><i class="fa fa-box"></i> Produk Saya</a>
      <a href="{{ route('umkm.pesanan.index') }}" class="sidebar-link {{ request()->routeIs('umkm.pesanan*') ? 'active' : '' }}"><i class="fa fa-shopping-bag"></i> Pesanan Masuk</a>
      <a href="{{ route('umkm.profil.edit') }}" class="sidebar-link {{ request()->routeIs('umkm.profil*') ? 'active' : '' }}"><i class="fa fa-store"></i> Profil Toko</a>
      <a href="{{ route('umkm.laporan') }}" class="sidebar-link {{ request()->routeIs('umkm.laporan') ? 'active' : '' }}"><i class="fa fa-chart-line"></i> Laporan</a>
    @elseif(auth()->user()->isDinas())
      <div class="nav-section-title">Dinas</div>
      <a href="{{ route('dinas.dashboard') }}" class="sidebar-link {{ request()->routeIs('dinas.dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
      <a href="{{ route('dinas.statistik') }}" class="sidebar-link"><i class="fa fa-chart-pie"></i> Statistik</a>
      <a href="{{ route('dinas.peta') }}" class="sidebar-link"><i class="fa fa-map"></i> Peta UMKM</a>
      <a href="{{ route('dinas.laporan') }}" class="sidebar-link"><i class="fa fa-file-alt"></i> Laporan</a>
    @else
      <div class="nav-section-title">Akun Saya</div>
      <a href="{{ route('customer.dashboard') }}" class="sidebar-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
      <a href="{{ route('customer.pesanan.index') }}" class="sidebar-link {{ request()->routeIs('customer.pesanan*') ? 'active' : '' }}"><i class="fa fa-shopping-bag"></i> Pesanan Saya</a>
      <a href="{{ route('customer.wishlist.index') }}" class="sidebar-link {{ request()->routeIs('customer.wishlist*') ? 'active' : '' }}"><i class="fa fa-heart"></i> Wishlist</a>
      <a href="{{ route('customer.profil.edit') }}" class="sidebar-link {{ request()->routeIs('customer.profil*') ? 'active' : '' }}"><i class="fa fa-user"></i> Profil Saya</a>
    @endif
  </nav>

  <div class="sidebar-footer">
    <a href="{{ route('home') }}" class="sidebar-link"><i class="fa fa-globe"></i> Lihat Website</a>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="sidebar-link sidebar-logout"><i class="fa fa-sign-out-alt"></i> Keluar</button>
    </form>
  </div>
</aside>

{{-- MAIN --}}
<div class="dashboard-main" id="dashMain">
  <header class="dashboard-topbar">
    <button class="topbar-toggle" onclick="toggleSidebar()"><i class="fa fa-bars"></i></button>
    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
    <div class="topbar-actions">
      <span class="topbar-user">{{ auth()->user()->name }}</span>
    </div>
  </header>

  <div class="dashboard-content">
    @if(session('success') || session('error') || session('info') || session('warning'))
      <div class="alerts-wrap">
        @foreach(['success'=>'check-circle','error'=>'times-circle','info'=>'info-circle','warning'=>'exclamation-triangle'] as $type => $icon)
          @if(session($type))
            <div class="alert alert-{{ $type }}">
              <i class="fa fa-{{ $icon }}"></i> {{ session($type) }}
              <button onclick="this.parentElement.remove()" class="alert-close">&times;</button>
            </div>
          @endif
        @endforeach
      </div>
    @endif

    @yield('dashboard-content')
  </div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<script>
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('sidebarOverlay').classList.toggle('show');
}
</script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@stack('scripts')
</body>
</html>
