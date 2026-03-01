@extends('layouts.dashboard')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@push('styles')
<style>
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
    --red-m:   #fee2e2;
    --ink:     #111827;
    --gray:    #6b7280;
    --gray2:   #374151;
    --border:  #e5e7eb;
    --bg:      #f9fafb;
}

/* ── Stats Grid ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.stat-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 20px;
    display: flex; flex-direction: column; gap: 12px;
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
.stat-card-red    .stat-icon { background: var(--red-m);    color: var(--red); }

.stat-badge { font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 99px; white-space: nowrap; }
.stat-badge-green  { background: var(--green-m);  color: var(--green); }
.stat-badge-amber  { background: var(--amber-m);  color: var(--amber); }
.stat-badge-blue   { background: var(--blue-m);   color: var(--blue); }
.stat-badge-red    { background: var(--red-m);    color: var(--red); }

.stat-num    { font-size: 28px; font-weight: 800; color: var(--ink); line-height: 1; }
.stat-num-sm { font-size: 19px; font-weight: 800; color: var(--ink); line-height: 1; }
.stat-label  { font-size: 13px; color: var(--gray); font-weight: 500; margin-top: 4px; }
.stat-sub    { font-size: 12px; color: var(--gray); padding-top: 8px; border-top: 1px solid var(--border); }
.stat-sub strong { color: var(--ink); }

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
    padding: 16px 20px; border-bottom: 1px solid var(--border);
}
.card-title { font-size: 14.5px; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: 8px; }
.card-title i { color: var(--green); }

/* ── Buttons ── */
.btn { display: inline-flex; align-items: center; gap: 6px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; text-decoration: none; transition: all .15s; font-family: inherit; }
.btn-sm { font-size: 12px; padding: 6px 12px; }
.btn-outline-green  { background: var(--green-l); color: var(--green); border: 1px solid var(--green-m); }
.btn-outline-green:hover  { background: var(--green-m); }
.btn-outline-amber  { background: var(--amber-l); color: var(--amber); border: 1px solid var(--amber-m); }
.btn-outline-amber:hover  { background: var(--amber-m); }
.btn-outline-blue   { background: var(--blue-l);  color: var(--blue);  border: 1px solid var(--blue-m); }
.btn-outline-blue:hover   { background: var(--blue-m); }
.btn-outline-gray   { background: #f3f4f6; color: var(--gray2); border: 1px solid var(--border); }
.btn-outline-gray:hover   { background: var(--border); }
.btn-green { background: var(--green); color: #fff; box-shadow: 0 2px 8px rgba(22,163,74,.25); }
.btn-green:hover { background: var(--green-h); }

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
.text-muted  { color: var(--gray); font-size: 13px; }

/* ── Badges ── */
.badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 99px; }
.badge-green  { background: var(--green-m);  color: var(--green); }
.badge-amber  { background: var(--amber-m);  color: var(--amber); }
.badge-blue   { background: var(--blue-m);   color: var(--blue); }
.badge-purple { background: var(--purple-m); color: var(--purple); }
.badge-red    { background: var(--red-m);    color: var(--red); }
.badge-gray   { background: #f3f4f6;         color: var(--gray); }

/* ── Dashboard row ── */
.dashboard-row {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
    margin-bottom: 24px;
}
@media (max-width: 1100px) { .dashboard-row { grid-template-columns: 1fr; } }

/* ── Chart ── */
.chart-wrap { padding: 20px; }
.chart-bars {
    display: flex; align-items: flex-end; gap: 8px;
    height: 160px; padding-bottom: 8px;
    border-bottom: 2px solid var(--border);
}
.chart-bar-wrap { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; height: 100%; justify-content: flex-end; }
.chart-bar {
    width: 100%; background: var(--green-m); border-radius: 6px 6px 0 0;
    transition: background .2s; min-height: 4px; position: relative;
}
.chart-bar:hover { background: var(--green); }
.chart-bar-val { font-size: 10px; font-weight: 700; color: var(--gray); }
.chart-labels { display: flex; gap: 8px; margin-top: 8px; }
.chart-label  { flex: 1; text-align: center; font-size: 10px; color: var(--gray); font-weight: 600; }

/* ── UMKM Pending list ── */
.pending-list { padding: 4px 0; }
.pending-item {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 20px; transition: background .15s;
}
.pending-item:hover { background: var(--bg); }
.pending-avatar {
    width: 38px; height: 38px; border-radius: 10px;
    background: var(--amber-m); color: var(--amber);
    font-size: 13px; font-weight: 800;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.pending-info { flex: 1; min-width: 0; }
.pending-name  { font-size: 13px; font-weight: 700; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.pending-meta  { font-size: 11.5px; color: var(--gray); margin-top: 1px; }

/* ── Quick Actions ── */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 12px;
    margin-bottom: 24px;
}
.quick-btn {
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;
    padding: 18px 14px; border-radius: 14px; text-decoration: none;
    font-size: 13px; font-weight: 600; transition: all .18s;
    border: 1.5px solid transparent;
}
.quick-btn i { font-size: 20px; }
.quick-btn:hover { transform: translateY(-2px); }
.quick-btn-green  { background: var(--green-l);  color: var(--green);  border-color: var(--green-m); }
.quick-btn-green:hover  { background: var(--green-m); }
.quick-btn-amber  { background: var(--amber-l);  color: var(--amber);  border-color: var(--amber-m); }
.quick-btn-amber:hover  { background: var(--amber-m); }
.quick-btn-blue   { background: var(--blue-l);   color: var(--blue);   border-color: var(--blue-m); }
.quick-btn-blue:hover   { background: var(--blue-m); }
.quick-btn-purple { background: var(--purple-l); color: var(--purple); border-color: var(--purple-m); }
.quick-btn-purple:hover { background: var(--purple-m); }
.quick-btn-red    { background: var(--red-l);    color: var(--red);    border-color: var(--red-m); }
.quick-btn-red:hover    { background: var(--red-m); }
</style>
@endpush

@section('dashboard-content')

{{-- ── Quick Actions ── --}}
<div class="quick-actions">
    <a href="{{ route('admin.verifikasi.index') }}" class="quick-btn quick-btn-amber">
        <i class="fa fa-check-circle"></i>
        <span>Verifikasi UMKM
            @if($stats['umkm_pending'] > 0)
                ({{ $stats['umkm_pending'] }})
            @endif
        </span>
    </a>
    <a href="{{ route('admin.umkm.index') }}" class="quick-btn quick-btn-green">
        <i class="fa fa-store"></i>
        <span>Kelola UMKM</span>
    </a>
    <a href="{{ route('admin.pengguna.index') }}" class="quick-btn quick-btn-blue">
        <i class="fa fa-users"></i>
        <span>Pengguna</span>
    </a>
    <a href="{{ route('admin.kategori.index') }}" class="quick-btn quick-btn-purple">
        <i class="fa fa-tags"></i>
        <span>Kategori</span>
    </a>
    <a href="{{ route('admin.laporan') }}" class="quick-btn quick-btn-red">
        <i class="fa fa-chart-bar"></i>
        <span>Laporan</span>
    </a>
</div>

{{-- ── Stats Cards ── --}}
<div class="stats-grid">

    <div class="stat-card stat-card-green">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-store"></i></div>
            @if($stats['umkm_pending'] > 0)
                <span class="stat-badge stat-badge-amber">{{ $stats['umkm_pending'] }} pending</span>
            @endif
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_umkm'] }}</div>
            <div class="stat-label">Total UMKM</div>
        </div>
        <div class="stat-sub"><strong>{{ $stats['umkm_aktif'] }}</strong> aktif · <strong>{{ $stats['umkm_pending'] }}</strong> menunggu</div>
    </div>

    <div class="stat-card stat-card-blue">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-box"></i></div>
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_produk'] }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
        <div class="stat-sub">Dari semua UMKM terdaftar</div>
    </div>

    <div class="stat-card stat-card-purple">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-users"></i></div>
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_customer'] }}</div>
            <div class="stat-label">Total Pelanggan</div>
        </div>
        <div class="stat-sub">Pengguna terdaftar</div>
    </div>

    <div class="stat-card stat-card-amber">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-shopping-bag"></i></div>
            <span class="stat-badge stat-badge-blue">+{{ $stats['pesanan_hari_ini'] }} hari ini</span>
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_pesanan'] }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
        <div class="stat-sub"><strong>{{ $stats['pesanan_hari_ini'] }}</strong> pesanan masuk hari ini</div>
    </div>

    <div class="stat-card stat-card-green" style="grid-column: span 1;">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-chart-line"></i></div>
            <span class="stat-badge stat-badge-green">Bulan ini</span>
        </div>
        <div>
            <div class="stat-num-sm">Rp {{ number_format($stats['omzet_bulan_ini'], 0, ',', '.') }}</div>
            <div class="stat-label">Omzet Platform</div>
        </div>
        <div class="stat-sub">Total transaksi selesai bulan {{ now()->translatedFormat('F Y') }}</div>
    </div>

</div>

{{-- ── Main Row ── --}}
<div class="dashboard-row">

    {{-- Chart + Pesanan Terbaru --}}
    <div>

        {{-- Chart Pesanan per Bulan --}}
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-chart-bar"></i> Pesanan per Bulan — {{ now()->year }}</h3>
            </div>
            <div class="chart-wrap">
                @php
                    $bulanLabel = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
                    $maxVal = $chartData->max() ?: 1;
                @endphp
                <div class="chart-bars">
                    @for($i = 1; $i <= 12; $i++)
                        @php $val = $chartData->get($i, 0); @endphp
                        <div class="chart-bar-wrap">
                            <div class="chart-bar-val">{{ $val > 0 ? $val : '' }}</div>
                            <div class="chart-bar" style="height: {{ max(4, ($val / $maxVal) * 130) }}px;"
                                title="{{ $bulanLabel[$i-1] }}: {{ $val }} pesanan"></div>
                        </div>
                    @endfor
                </div>
                <div class="chart-labels">
                    @foreach($bulanLabel as $lbl)
                        <div class="chart-label">{{ $lbl }}</div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Pesanan Terbaru --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-shopping-bag"></i> Pesanan Terbaru</h3>
                <a href="#" class="btn btn-sm btn-outline-green">Lihat Semua</a>
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Pembeli</th>
                            <th>UMKM</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesananTerbaru as $order)
                            <tr>
                                <td><code>{{ $order->order_number }}</code></td>
                                <td>{{ $order->customer->name ?? '-' }}</td>
                                <td>{{ $order->umkm->name ?? '-' }}</td>
                                <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $color = match($order->status) {
                                            'pending'    => 'amber',
                                            'processing' => 'blue',
                                            'shipped'    => 'purple',
                                            'delivered'  => 'green',
                                            'cancelled'  => 'red',
                                            default      => 'gray',
                                        };
                                        $label = match($order->status) {
                                            'pending'    => 'Menunggu',
                                            'processing' => 'Diproses',
                                            'shipped'    => 'Dikirim',
                                            'delivered'  => 'Selesai',
                                            'cancelled'  => 'Dibatal',
                                            default      => ucfirst($order->status),
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $color }}">{{ $label }}</span>
                                </td>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted" style="padding:32px;">
                                    <i class="fa fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4;"></i>
                                    Belum ada pesanan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Sidebar Kanan --}}
    <div>

        {{-- UMKM Pending Verifikasi --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-clock"></i> Menunggu Verifikasi</h3>
                <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-sm btn-outline-amber">Semua</a>
            </div>
            <div class="pending-list">
                @forelse($umkmPending as $umkm)
                    <div class="pending-item">
                        <div class="pending-avatar">{{ strtoupper(substr($umkm->name, 0, 2)) }}</div>
                        <div class="pending-info">
                            <div class="pending-name">{{ $umkm->name }}</div>
                            <div class="pending-meta">
                                {{ $umkm->category->name ?? '-' }} · {{ $umkm->kecamatan ?? '-' }}
                            </div>
                        </div>
                        <a href="{{ route('admin.umkm.show', $umkm) }}" class="btn btn-sm btn-outline-amber">Review</a>
                    </div>
                @empty
                    <p class="text-muted text-center" style="padding:24px;">
                        <i class="fa fa-check-circle" style="color:var(--green);font-size:20px;display:block;margin-bottom:6px;"></i>
                        Tidak ada yang pending
                    </p>
                @endforelse
            </div>
        </div>

        {{-- Ringkasan Cepat ── --}}
        <div class="card" style="margin-top:20px;">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-info-circle"></i> Ringkasan Platform</h3>
            </div>
            <div style="padding: 8px 0;">
                <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 20px;border-bottom:1px solid #f3f4f6;font-size:13px;">
                    <span style="color:var(--gray);">UMKM Aktif</span>
                    <strong style="color:var(--green);">{{ $stats['umkm_aktif'] }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 20px;border-bottom:1px solid #f3f4f6;font-size:13px;">
                    <span style="color:var(--gray);">UMKM Pending</span>
                    <strong style="color:var(--amber);">{{ $stats['umkm_pending'] }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 20px;border-bottom:1px solid #f3f4f6;font-size:13px;">
                    <span style="color:var(--gray);">Total Produk</span>
                    <strong style="color:var(--ink);">{{ $stats['total_produk'] }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 20px;border-bottom:1px solid #f3f4f6;font-size:13px;">
                    <span style="color:var(--gray);">Total Pelanggan</span>
                    <strong style="color:var(--ink);">{{ $stats['total_customer'] }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 20px;font-size:13px;">
                    <span style="color:var(--gray);">Pesanan Hari Ini</span>
                    <strong style="color:var(--blue);">{{ $stats['pesanan_hari_ini'] }}</strong>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection