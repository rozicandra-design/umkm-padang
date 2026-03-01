@extends('layouts.dashboard')
@section('title', 'Dashboard Pelanggan')
@section('page-title', 'Dashboard Pelanggan')

@section('dashboard-content')

{{-- STATS CARDS --}}
<div class="stats-grid">
  <div class="stat-card stat-card-blue">
    <div class="stat-icon"><i class="fa fa-shopping-cart"></i></div>
    <div class="stat-info">
      <div class="stat-num">{{ $stats['total_pesanan'] }}</div>
      <div class="stat-label">Total Pesanan</div>
    </div>
    <div class="stat-sub">{{ $stats['pesanan_aktif'] }} sedang diproses</div>
  </div>
  <div class="stat-card stat-card-gold">
    <div class="stat-icon"><i class="fa fa-clock"></i></div>
    <div class="stat-info">
      <div class="stat-num">{{ $stats['pesanan_menunggu'] }}</div>
      <div class="stat-label">Menunggu Konfirmasi</div>
    </div>
    <div class="stat-sub {{ $stats['pesanan_menunggu'] > 0 ? 'text-warning' : '' }}">
      Perlu perhatian
    </div>
  </div>
  <div class="stat-card stat-card-green">
    <div class="stat-icon"><i class="fa fa-check-circle"></i></div>
    <div class="stat-info">
      <div class="stat-num">{{ $stats['pesanan_selesai'] }}</div>
      <div class="stat-label">Pesanan Selesai</div>
    </div>
    <div class="stat-sub">Rp {{ number_format($stats['total_belanja'], 0, ',', '.') }} total</div>
  </div>
  <div class="stat-card stat-card-purple">
    <div class="stat-icon"><i class="fa fa-heart"></i></div>
    <div class="stat-info">
      <div class="stat-num">{{ $stats['wishlist'] }}</div>
      <div class="stat-label">Wishlist</div>
    </div>
    <div class="stat-sub">Produk disimpan</div>
  </div>
</div>

<div class="dashboard-row">
  {{-- PESANAN TERBARU --}}
  <div class="dashboard-col-lg">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-shopping-bag"></i> Pesanan Terbaru</h3>
        <a href="{{ route('customer.pesanan.index') }}" class="btn btn-sm btn-outline-blue">Lihat Semua</a>
      </div>
      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr>
              <th>No. Pesanan</th>
              <th>Toko</th>
              <th>Total</th>
              <th>Status</th>
              <th>Waktu</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pesananTerbaru as $order)
              <tr>
                <td><code>{{ $order->order_number }}</code></td>
                <td>{{ $order->umkm->name }}</td>
                <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                <td>
                  <span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span>
                </td>
                <td>{{ $order->created_at->diffForHumans() }}</td>
                <td>
                  <a href="{{ route('customer.pesanan.show', $order) }}" class="btn btn-sm btn-outline-blue">Detail</a>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted">Belum ada pesanan</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- INFO AKUN --}}
  <div class="dashboard-col-sm">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-user-circle"></i> Info Akun</h3>
        <a href="{{ route('customer.profil.edit') }}" class="btn btn-sm btn-outline-blue">Edit</a>
      </div>
      <div class="info-list">
        <div class="info-row"><span>Nama</span><strong>{{ auth()->user()->name }}</strong></div>
        <div class="info-row"><span>Email</span><strong>{{ auth()->user()->email }}</strong></div>
        <div class="info-row"><span>Telepon</span><strong>{{ auth()->user()->phone ?? '-' }}</strong></div>
        <div class="info-row"><span>Bergabung</span><strong>{{ auth()->user()->created_at->format('d M Y') }}</strong></div>
      </div>
    </div>

    {{-- PRODUK TERAKHIR DILIHAT --}}
    <div class="card mt-4">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-history"></i> Terakhir Dilihat</h3>
      </div>
      <div class="product-rank-list">
        @forelse($produkTerakhirDilihat as $prod)
          <div class="product-rank-item">
            <div class="rank-num">{{ $loop->iteration }}</div>
            <div class="rank-info">
              <div class="rank-name">{{ $prod->name }}</div>
              <div class="rank-price">Rp {{ number_format($prod->price, 0, ',', '.') }}</div>
            </div>
            <a href="{{ route('produk.show', $prod->slug) }}" class="btn btn-sm btn-outline-blue">Lihat</a>
          </div>
        @empty
          <p class="text-muted text-center">Belum ada riwayat</p>
        @endforelse
      </div>
    </div>
  </div>
</div>

{{-- QUICK ACTIONS --}}
<div class="quick-actions">
  <a href="{{ route('customer.pesanan.index') }}" class="quick-action-btn quick-action-blue">
    <i class="fa fa-list"></i>
    <span>Pesanan Saya</span>
  </a>
  <a href="{{ route('katalog') }}" class="quick-action-btn quick-action-gold">
    <i class="fa fa-store"></i>
    <span>Jelajahi Produk</span>
  </a>
  <a href="{{ route('customer.profil.edit') }}" class="quick-action-btn quick-action-green">
    <i class="fa fa-edit"></i>
    <span>Edit Profil</span>
  </a>
  <a href="{{ route('customer.wishlist.index') }}" class="quick-action-btn quick-action-purple">
    <i class="fa fa-heart"></i>
    <span>Wishlist ({{ $stats['wishlist'] }})</span>
  </a>
</div>
@endsection