@extends('layouts.dashboard')
@section('title', 'Dashboard UMKM')
@section('page-title', 'Dashboard Toko')

@push('styles')
<style>
/* ── Variables ── */
:root {
    --green:   #16a34a;
    --green-h: #15803d;
    --green-l: #f0fdf4;
    --green-m: #dcfce7;
    --blue:    #2563eb;
    --blue-l:  #eff6ff;
    --blue-m:  #dbeafe;
    --amber:   #d97706;
    --amber-l: #fffbeb;
    --amber-m: #fef3c7;
    --purple:  #7c3aed;
    --purple-l:#f5f3ff;
    --purple-m:#ede9fe;
    --red:     #dc2626;
    --red-l:   #fff5f5;
    --ink:     #111827;
    --gray:    #6b7280;
    --gray2:   #374151;
    --border:  #e5e7eb;
    --bg:      #f9fafb;
}

/* ── Stats Grid ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.stat-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    transition: transform .15s, box-shadow .15s;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,.08); }

.stat-card-top { display: flex; align-items: flex-start; justify-content: space-between; }
.stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.stat-card-green  .stat-icon { background: var(--green-m);  color: var(--green); }
.stat-card-blue   .stat-icon { background: var(--blue-m);   color: var(--blue); }
.stat-card-amber  .stat-icon { background: var(--amber-m);  color: var(--amber); }
.stat-card-purple .stat-icon { background: var(--purple-m); color: var(--purple); }

.stat-badge {
    font-size: 11px; font-weight: 700; padding: 3px 8px;
    border-radius: 99px; white-space: nowrap;
}
.stat-badge-green  { background: var(--green-m);  color: var(--green); }
.stat-badge-amber  { background: var(--amber-m);  color: var(--amber); }
.stat-badge-blue   { background: var(--blue-m);   color: var(--blue); }
.stat-badge-purple { background: var(--purple-m); color: var(--purple); }

.stat-num   { font-size: 28px; font-weight: 800; color: var(--ink); line-height: 1; }
.stat-num-sm { font-size: 20px; font-weight: 800; color: var(--ink); line-height: 1; }
.stat-label { font-size: 13px; color: var(--gray); font-weight: 500; margin-top: 4px; }
.stat-sub   { font-size: 12px; color: var(--gray); padding-top: 8px; border-top: 1px solid var(--border); }
.stat-sub strong { color: var(--ink); }

/* ── Status banner (pending verifikasi) ── */
.status-banner {
    display: flex; align-items: center; gap: 12px;
    background: var(--amber-l); border: 1px solid var(--amber-m);
    border-left: 4px solid var(--amber);
    border-radius: 12px; padding: 14px 18px;
    margin-bottom: 24px; font-size: 13.5px; color: #92400e;
}
.status-banner i { font-size: 16px; color: var(--amber); flex-shrink: 0; }
.status-banner strong { font-weight: 700; }

/* ── Dashboard row ── */
.dashboard-row {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 20px;
    margin-bottom: 24px;
}
@media (max-width: 1024px) { .dashboard-row { grid-template-columns: 1fr; } }

/* ── Cards ── */
.card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.card + .card { margin-top: 20px; }

.card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
}
.card-title {
    font-size: 14.5px; font-weight: 700; color: var(--ink);
    display: flex; align-items: center; gap: 8px;
}
.card-title i { color: var(--green); }

/* ── Buttons ── */
.btn { display: inline-flex; align-items: center; gap: 6px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; text-decoration: none; transition: all .15s; font-family: inherit; }
.btn-sm { font-size: 12px; padding: 6px 12px; }
.btn-md { font-size: 13px; padding: 9px 18px; }
.btn-green        { background: var(--green);  color: #fff; box-shadow: 0 2px 8px rgba(22,163,74,.25); }
.btn-green:hover  { background: var(--green-h); }
.btn-outline-green { background: var(--green-l); color: var(--green); border: 1px solid var(--green-m); }
.btn-outline-green:hover { background: var(--green-m); }
.btn-outline-gray  { background: #f3f4f6; color: var(--gray2); border: 1px solid var(--border); }
.btn-outline-gray:hover  { background: var(--border); }
.btn-outline-amber { background: var(--amber-l); color: var(--amber); border: 1px solid var(--amber-m); }
.btn-outline-blue  { background: var(--blue-l);  color: var(--blue);  border: 1px solid var(--blue-m); }

/* ── Table ── */
.table-wrap { overflow-x: auto; }
.table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.table thead th {
    padding: 10px 16px; text-align: left;
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .6px; color: var(--gray);
    background: var(--bg); border-bottom: 1px solid var(--border);
}
.table tbody td { padding: 12px 16px; border-bottom: 1px solid #f3f4f6; color: var(--gray2); vertical-align: middle; }
.table tbody tr:last-child td { border-bottom: none; }
.table tbody tr:hover td { background: var(--bg); }
.table code { background: #f3f4f6; padding: 2px 6px; border-radius: 5px; font-size: 12px; color: var(--ink); }
.text-center { text-align: center; }
.text-muted  { color: var(--gray); }

/* ── Badges ── */
.badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 99px; }
.badge-green  { background: var(--green-m);  color: var(--green); }
.badge-amber  { background: var(--amber-m);  color: var(--amber); }
.badge-blue   { background: var(--blue-m);   color: var(--blue); }
.badge-purple { background: var(--purple-m); color: var(--purple); }
.badge-red    { background: #fee2e2;          color: var(--red); }
.badge-gray   { background: #f3f4f6;          color: var(--gray); }

/* ── Produk Terlaris ── */
.product-rank-list { padding: 8px 0; }
.product-rank-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 20px; transition: background .15s;
}
.product-rank-item:hover { background: var(--bg); }
.rank-num {
    width: 24px; height: 24px; border-radius: 50%;
    background: var(--green-m); color: var(--green);
    font-size: 11px; font-weight: 800;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.rank-num.top { background: var(--amber-m); color: var(--amber); }
.rank-info { flex: 1; min-width: 0; }
.rank-name  { font-size: 13px; font-weight: 600; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rank-meta  { font-size: 11.5px; color: var(--gray); margin-top: 1px; }
.rank-sold  { font-size: 12px; font-weight: 700; color: var(--green); white-space: nowrap; }

/* ── Info toko ── */
.toko-info { padding: 16px 20px; }
.toko-header {
    display: flex; align-items: center; gap: 14px; margin-bottom: 16px;
    padding-bottom: 16px; border-bottom: 1px solid var(--border);
}
.toko-avatar {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--green-m); color: var(--green);
    font-size: 22px; font-weight: 800;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.toko-name  { font-size: 15px; font-weight: 800; color: var(--ink); }
.toko-cat   { font-size: 12px; color: var(--gray); margin-top: 2px; }
.toko-status { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 700; margin-top: 4px; }

.info-list { display: flex; flex-direction: column; }
.info-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 9px 0; border-bottom: 1px solid #f3f4f6; font-size: 13px;
}
.info-row:last-child { border-bottom: none; }
.info-row span   { color: var(--gray); }
.info-row strong { color: var(--ink); font-weight: 600; text-align: right; max-width: 60%; }

/* ── Quick Actions ── */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 12px;
    margin-bottom: 24px;
}
.quick-btn {
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;
    padding: 20px 16px; border-radius: 14px; text-decoration: none;
    font-size: 13px; font-weight: 600; transition: all .18s;
    border: 1.5px solid transparent;
}
.quick-btn i { font-size: 20px; }
.quick-btn:hover { transform: translateY(-2px); }
.quick-btn-green  { background: var(--green-l);  color: var(--green);  border-color: var(--green-m); }
.quick-btn-green:hover  { background: var(--green-m); }
.quick-btn-blue   { background: var(--blue-l);   color: var(--blue);   border-color: var(--blue-m); }
.quick-btn-blue:hover   { background: var(--blue-m); }
.quick-btn-amber  { background: var(--amber-l);  color: var(--amber);  border-color: var(--amber-m); }
.quick-btn-amber:hover  { background: var(--amber-m); }
.quick-btn-purple { background: var(--purple-l); color: var(--purple); border-color: var(--purple-m); }
.quick-btn-purple:hover { background: var(--purple-m); }

/* ── Omzet highlight ── */
.omzet-wrap {
    display: grid; grid-template-columns: 1fr 1fr; gap: 12px;
    padding: 16px 20px; border-bottom: 1px solid var(--border);
}
.omzet-item { text-align: center; }
.omzet-val  { font-size: 17px; font-weight: 800; color: var(--green); line-height: 1; }
.omzet-lbl  { font-size: 11px; color: var(--gray); margin-top: 4px; font-weight: 500; text-transform: uppercase; letter-spacing: .5px; }

/* ── Section title ── */
.section-title {
    font-size: 13px; font-weight: 700; color: var(--gray);
    text-transform: uppercase; letter-spacing: .8px;
    margin: 0 0 14px;
}
</style>
@endpush

@section('dashboard-content')

{{-- ── Status Banner (jika masih pending) ── --}}
@if($umkm->status === 'pending')
<div class="status-banner">
    <i class="fa fa-clock"></i>
    <div>
        <strong>Toko Anda sedang dalam proses verifikasi.</strong>
        Proses verifikasi membutuhkan 1–2 hari kerja. Anda sudah bisa menambahkan produk, namun toko belum tampil ke publik.
    </div>
</div>
@endif

{{-- ── Quick Actions ── --}}
<div class="quick-actions">
    <a href="{{ route('umkm.produk.create') }}" class="quick-btn quick-btn-green">
        <i class="fa fa-plus-circle"></i>
        <span>Tambah Produk</span>
    </a>
    <a href="{{ route('umkm.pesanan.index') }}" class="quick-btn quick-btn-blue">
        <i class="fa fa-shopping-bag"></i>
        <span>Pesanan Masuk
            @if($stats['pesanan_baru'] > 0)
                ({{ $stats['pesanan_baru'] }})
            @endif
        </span>
    </a>
    <a href="{{ route('umkm.produk.index') }}" class="quick-btn quick-btn-amber">
        <i class="fa fa-box"></i>
        <span>Produk Saya</span>
    </a>
    <a href="{{ route('umkm.profil.edit') }}" class="quick-btn quick-btn-purple">
        <i class="fa fa-store"></i>
        <span>Edit Toko</span>
    </a>
</div>

{{-- ── Stats Cards ── --}}
<div class="stats-grid">

    <div class="stat-card stat-card-green">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-box"></i></div>
            <span class="stat-badge stat-badge-green">{{ $stats['produk_aktif'] }} aktif</span>
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_produk'] }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
        <div class="stat-sub">
            <strong>{{ $stats['produk_aktif'] }}</strong> produk tampil ke publik
        </div>
    </div>

    <div class="stat-card stat-card-blue">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-shopping-bag"></i></div>
            @if($stats['pesanan_baru'] > 0)
                <span class="stat-badge stat-badge-amber">{{ $stats['pesanan_baru'] }} baru</span>
            @endif
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_pesanan'] }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
        <div class="stat-sub">
            <strong>{{ $stats['pesanan_baru'] }}</strong> menunggu konfirmasi
        </div>
    </div>

    <div class="stat-card stat-card-amber">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-chart-line"></i></div>
            <span class="stat-badge stat-badge-amber">Bulan ini</span>
        </div>
        <div>
            <div class="stat-num-sm">Rp {{ number_format($stats['omzet_bulan_ini'], 0, ',', '.') }}</div>
            <div class="stat-label">Omzet Bulan Ini</div>
        </div>
        <div class="stat-sub">
            Total: <strong>Rp {{ number_format($stats['omzet_total'], 0, ',', '.') }}</strong>
        </div>
    </div>

    <div class="stat-card stat-card-purple">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-star"></i></div>
        </div>
        <div>
            <div class="stat-num">{{ $umkm->status === 'active' ? 'Aktif' : ucfirst($umkm->status) }}</div>
            <div class="stat-label">Status Toko</div>
        </div>
        <div class="stat-sub">
            Bergabung <strong>{{ $umkm->created_at->format('M Y') }}</strong>
        </div>
    </div>

</div>

{{-- ── Main Content ── --}}
<div class="dashboard-row">

    {{-- Pesanan Terbaru --}}
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-shopping-bag"></i> Pesanan Terbaru</h3>
                <a href="{{ route('umkm.pesanan.index') }}" class="btn btn-sm btn-outline-green">Lihat Semua</a>
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Pembeli</th>
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
                                <td>{{ $order->customer->name ?? '-' }}</td>
                                <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $statusColor = match($order->status) {
                                            'pending'    => 'amber',
                                            'processing' => 'blue',
                                            'shipped'    => 'purple',
                                            'delivered'  => 'green',
                                            'cancelled'  => 'red',
                                            default      => 'gray',
                                        };
                                        $statusLabel = match($order->status) {
                                            'pending'    => 'Menunggu',
                                            'processing' => 'Diproses',
                                            'shipped'    => 'Dikirim',
                                            'delivered'  => 'Selesai',
                                            'cancelled'  => 'Dibatal',
                                            default      => ucfirst($order->status),
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $statusColor }}">{{ $statusLabel }}</span>
                                </td>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('umkm.pesanan.show', $order) }}" class="btn btn-sm btn-outline-green">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted" style="padding: 32px;">
                                    <i class="fa fa-inbox" style="font-size:24px; display:block; margin-bottom:8px; opacity:.4;"></i>
                                    Belum ada pesanan masuk
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Sidebar kanan --}}
    <div>

        {{-- Info Toko --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-store"></i> Info Toko</h3>
                <a href="{{ route('umkm.profil.edit') }}" class="btn btn-sm btn-outline-gray">Edit</a>
            </div>
            <div class="toko-info">
                <div class="toko-header">
                    <div class="toko-avatar">{{ strtoupper(substr($umkm->name, 0, 2)) }}</div>
                    <div>
                        <div class="toko-name">{{ $umkm->name }}</div>
                        <div class="toko-cat">{{ $umkm->category->name ?? '-' }}</div>
                        <div class="toko-status">
                            @if($umkm->status === 'active')
                                <span class="badge badge-green">✓ Terverifikasi</span>
                            @elseif($umkm->status === 'pending')
                                <span class="badge badge-amber">⏳ Menunggu Verifikasi</span>
                            @else
                                <span class="badge badge-red">✗ {{ ucfirst($umkm->status) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="info-list">
                    <div class="info-row">
                        <span>Kecamatan</span>
                        <strong>{{ $umkm->kecamatan ?? '-' }}</strong>
                    </div>
                    <div class="info-row">
                        <span>WhatsApp</span>
                        <strong>{{ $umkm->whatsapp ?? '-' }}</strong>
                    </div>
                    <div class="info-row">
                        <span>Alamat</span>
                        <strong>{{ Str::limit($umkm->address, 30) ?? '-' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- Produk Terlaris --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-fire"></i> Produk Terlaris</h3>
                <a href="{{ route('umkm.produk.index') }}" class="btn btn-sm btn-outline-green">Semua</a>
            </div>
            <div class="product-rank-list">
                @forelse($produkTerlaris as $prod)
                    <div class="product-rank-item">
                        <div class="rank-num {{ $loop->index < 3 ? 'top' : '' }}">{{ $loop->iteration }}</div>
                        <div class="rank-info">
                            <div class="rank-name">{{ $prod->name }}</div>
                            <div class="rank-meta">Rp {{ number_format($prod->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="rank-sold">{{ $prod->order_items_count }}x</div>
                    </div>
                @empty
                    <p class="text-muted text-center" style="padding: 24px; font-size:13px;">
                        Belum ada data penjualan
                    </p>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection