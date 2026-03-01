@extends('layouts.dashboard')
@section('title', 'Dashboard Dinas')
@section('page-title', 'Dashboard Dinas UMKM')

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
    --teal:    #0d9488;
    --teal-l:  #f0fdfa;
    --teal-m:  #ccfbf1;
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
    background: #fff; border: 1px solid var(--border); border-radius: 16px;
    padding: 20px; display: flex; flex-direction: column; gap: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05); transition: transform .15s, box-shadow .15s;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,.08); }
.stat-card-top { display: flex; align-items: flex-start; justify-content: space-between; }
.stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.stat-card-green  .stat-icon { background: var(--green-m);  color: var(--green); }
.stat-card-blue   .stat-icon { background: var(--blue-m);   color: var(--blue); }
.stat-card-amber  .stat-icon { background: var(--amber-m);  color: var(--amber); }
.stat-card-purple .stat-icon { background: var(--purple-m); color: var(--purple); }
.stat-card-teal   .stat-icon { background: var(--teal-m);   color: var(--teal); }
.stat-num    { font-size: 28px; font-weight: 800; color: var(--ink); line-height: 1; }
.stat-num-sm { font-size: 19px; font-weight: 800; color: var(--ink); line-height: 1; }
.stat-label  { font-size: 13px; color: var(--gray); font-weight: 500; margin-top: 4px; }
.stat-sub    { font-size: 12px; color: var(--gray); padding-top: 8px; border-top: 1px solid var(--border); }
.stat-sub strong { color: var(--ink); }
.stat-badge { font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 99px; }
.stat-badge-green { background: var(--green-m); color: var(--green); }
.stat-badge-amber { background: var(--amber-m); color: var(--amber); }

/* ── Cards ── */
.card { background: #fff; border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
.card + .card { margin-top: 20px; }
.card-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--border); }
.card-title { font-size: 14.5px; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: 8px; }
.card-title i { color: var(--green); }

/* ── Buttons ── */
.btn { display: inline-flex; align-items: center; gap: 6px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; text-decoration: none; transition: all .15s; font-family: inherit; }
.btn-sm { font-size: 12px; padding: 6px 12px; }
.btn-outline-green  { background: var(--green-l); color: var(--green); border: 1px solid var(--green-m); }
.btn-outline-green:hover  { background: var(--green-m); }
.btn-outline-blue   { background: var(--blue-l);  color: var(--blue);  border: 1px solid var(--blue-m); }
.btn-outline-blue:hover   { background: var(--blue-m); }
.btn-outline-teal   { background: var(--teal-l);  color: var(--teal);  border: 1px solid var(--teal-m); }
.btn-outline-teal:hover   { background: var(--teal-m); }

/* ── Dashboard layout ── */
.dashboard-row {
    display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;
}
.dashboard-row-3 {
    display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 24px;
}
@media (max-width: 1100px) { .dashboard-row, .dashboard-row-3 { grid-template-columns: 1fr; } }

/* ── Quick Actions ── */
.quick-actions {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 12px; margin-bottom: 24px;
}
.quick-btn {
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;
    padding: 18px 14px; border-radius: 14px; text-decoration: none;
    font-size: 13px; font-weight: 600; transition: all .18s; border: 1.5px solid transparent;
}
.quick-btn i { font-size: 20px; }
.quick-btn:hover { transform: translateY(-2px); }
.quick-btn-green  { background: var(--green-l);  color: var(--green);  border-color: var(--green-m); }
.quick-btn-green:hover  { background: var(--green-m); }
.quick-btn-blue   { background: var(--blue-l);   color: var(--blue);   border-color: var(--blue-m); }
.quick-btn-blue:hover   { background: var(--blue-m); }
.quick-btn-teal   { background: var(--teal-l);   color: var(--teal);   border-color: var(--teal-m); }
.quick-btn-teal:hover   { background: var(--teal-m); }
.quick-btn-purple { background: var(--purple-l); color: var(--purple); border-color: var(--purple-m); }
.quick-btn-purple:hover { background: var(--purple-m); }

/* ── Chart Bars ── */
.chart-wrap { padding: 20px; }
.chart-bars { display: flex; align-items: flex-end; gap: 8px; height: 140px; padding-bottom: 8px; border-bottom: 2px solid var(--border); }
.chart-bar-wrap { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; height: 100%; justify-content: flex-end; }
.chart-bar { width: 100%; background: var(--green-m); border-radius: 6px 6px 0 0; transition: background .2s; min-height: 4px; }
.chart-bar:hover { background: var(--green); }
.chart-bar-val { font-size: 9px; font-weight: 700; color: var(--gray); }
.chart-labels { display: flex; gap: 8px; margin-top: 8px; }
.chart-label  { flex: 1; text-align: center; font-size: 10px; color: var(--gray); font-weight: 600; }

/* ── Kecamatan bars ── */
.kec-list { padding: 12px 20px; display: flex; flex-direction: column; gap: 10px; }
.kec-item { display: flex; flex-direction: column; gap: 4px; }
.kec-header { display: flex; justify-content: space-between; font-size: 13px; }
.kec-name  { font-weight: 600; color: var(--ink); }
.kec-count { font-weight: 700; color: var(--green); }
.kec-bar-bg { height: 6px; background: var(--border); border-radius: 99px; overflow: hidden; }
.kec-bar-fill { height: 100%; background: var(--green); border-radius: 99px; transition: width .4s; }

/* ── Kategori ── */
.cat-list { padding: 8px 0; }
.cat-item { display: flex; align-items: center; justify-content: space-between; padding: 10px 20px; border-bottom: 1px solid #f3f4f6; font-size: 13px; }
.cat-item:last-child { border-bottom: none; }
.cat-name  { font-weight: 600; color: var(--ink); }
.cat-count { font-size: 12px; font-weight: 700; background: var(--green-m); color: var(--green); padding: 2px 10px; border-radius: 99px; }

/* ── UMKM Terbaru ── */
.umkm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1px; background: var(--border); }
.umkm-item { background: #fff; padding: 14px 18px; display: flex; align-items: center; gap: 12px; transition: background .15s; }
.umkm-item:hover { background: var(--bg); }
.umkm-avatar { width: 38px; height: 38px; border-radius: 10px; background: var(--green-m); color: var(--green); font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.umkm-name  { font-size: 13px; font-weight: 700; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.umkm-meta  { font-size: 11.5px; color: var(--gray); margin-top: 1px; }

/* ── Badges ── */
.badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 99px; }
.badge-green { background: var(--green-m); color: var(--green); }
.badge-amber { background: var(--amber-m); color: var(--amber); }
</style>
@endpush

@section('dashboard-content')

{{-- ── Quick Actions ── --}}
<div class="quick-actions">
    <a href="{{ route('dinas.statistik') }}" class="quick-btn quick-btn-green">
        <i class="fa fa-chart-pie"></i>
        <span>Statistik UMKM</span>
    </a>
    <a href="{{ route('dinas.peta') }}" class="quick-btn quick-btn-teal">
        <i class="fa fa-map-marked-alt"></i>
        <span>Peta Sebaran</span>
    </a>
    <a href="{{ route('dinas.laporan') }}" class="quick-btn quick-btn-blue">
        <i class="fa fa-file-alt"></i>
        <span>Laporan</span>
    </a>
    <a href="{{ route('katalog') }}" class="quick-btn quick-btn-purple">
        <i class="fa fa-store"></i>
        <span>Lihat Katalog</span>
    </a>
</div>

{{-- ── Stats Cards ── --}}
<div class="stats-grid">

    <div class="stat-card stat-card-green">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-store"></i></div>
            <span class="stat-badge stat-badge-green">{{ $stats['umkm_aktif'] }} aktif</span>
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_umkm'] }}</div>
            <div class="stat-label">Total UMKM Terdaftar</div>
        </div>
        <div class="stat-sub"><strong>{{ $stats['umkm_pending'] }}</strong> menunggu verifikasi</div>
    </div>

    <div class="stat-card stat-card-blue">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-box"></i></div>
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_produk'] }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
        <div class="stat-sub">Dari seluruh UMKM aktif</div>
    </div>

    <div class="stat-card stat-card-purple">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-users"></i></div>
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_customer'] }}</div>
            <div class="stat-label">Pelanggan Terdaftar</div>
        </div>
        <div class="stat-sub">Pengguna aktif platform</div>
    </div>

    <div class="stat-card stat-card-amber">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-shopping-bag"></i></div>
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_pesanan'] }}</div>
            <div class="stat-label">Total Transaksi</div>
        </div>
        <div class="stat-sub">Omzet: <strong>Rp {{ number_format($stats['omzet_total'], 0, ',', '.') }}</strong></div>
    </div>

    <div class="stat-card stat-card-teal">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-chart-line"></i></div>
            <span class="stat-badge stat-badge-green">{{ now()->translatedFormat('F') }}</span>
        </div>
        <div>
            <div class="stat-num-sm">Rp {{ number_format($stats['omzet_bulan_ini'], 0, ',', '.') }}</div>
            <div class="stat-label">Omzet Bulan Ini</div>
        </div>
        <div class="stat-sub">Transaksi selesai bulan ini</div>
    </div>

</div>

{{-- ── Chart Omzet ── --}}
<div class="card" style="margin-bottom: 24px;">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-chart-line"></i> Omzet Platform — {{ now()->year }}</h3>
    </div>
    <div class="chart-wrap">
        @php
            $bulanLabel = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
            $maxOmzet = $omzetPerBulan->max() ?: 1;
        @endphp
        <div class="chart-bars">
            @for($i = 1; $i <= 12; $i++)
                @php $val = $omzetPerBulan->get($i, 0); @endphp
                <div class="chart-bar-wrap">
                    <div class="chart-bar-val">{{ $val > 0 ? 'Rp'.number_format($val/1000000,1).'jt' : '' }}</div>
                    <div class="chart-bar" style="height: {{ max(4, ($val / $maxOmzet) * 120) }}px;"
                        title="{{ $bulanLabel[$i-1] }}: Rp {{ number_format($val,0,',','.') }}"></div>
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

{{-- ── Sebaran & Kategori ── --}}
<div class="dashboard-row">

    {{-- Sebaran per Kecamatan --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-map-marker-alt"></i> Sebaran per Kecamatan</h3>
        </div>
        <div class="kec-list">
            @php $maxKec = $umkmPerKecamatan->max('total') ?: 1; @endphp
            @forelse($umkmPerKecamatan as $kec)
                <div class="kec-item">
                    <div class="kec-header">
                        <span class="kec-name">{{ $kec->kecamatan ?? 'Tidak diketahui' }}</span>
                        <span class="kec-count">{{ $kec->total }} UMKM</span>
                    </div>
                    <div class="kec-bar-bg">
                        <div class="kec-bar-fill" style="width: {{ ($kec->total / $maxKec) * 100 }}%;"></div>
                    </div>
                </div>
            @empty
                <p style="text-align:center;color:var(--gray);padding:20px;font-size:13px;">Belum ada data</p>
            @endforelse
        </div>
    </div>

    {{-- Sebaran per Kategori --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-tags"></i> Sebaran per Kategori</h3>
        </div>
        <div class="cat-list">
            @forelse($umkmPerKategori as $kat)
                <div class="cat-item">
                    <span class="cat-name">{{ $kat->kategori }}</span>
                    <span class="cat-count">{{ $kat->total }}</span>
                </div>
            @empty
                <p style="text-align:center;color:var(--gray);padding:20px;font-size:13px;">Belum ada data</p>
            @endforelse
        </div>
    </div>

</div>

{{-- ── UMKM Terbaru ── --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-store"></i> UMKM Terbaru Bergabung</h3>
        <a href="{{ route('dinas.statistik') }}" class="btn btn-sm btn-outline-green">Lihat Semua</a>
    </div>
    <div class="umkm-grid">
        @forelse($umkmTerbaru as $umkm)
            <div class="umkm-item">
                <div class="umkm-avatar">{{ strtoupper(substr($umkm->name, 0, 2)) }}</div>
                <div style="flex:1;min-width:0;">
                    <div class="umkm-name">{{ $umkm->name }}</div>
                    <div class="umkm-meta">{{ $umkm->category->name ?? '-' }} · {{ $umkm->kecamatan ?? '-' }}</div>
                </div>
                <span class="badge badge-green">Aktif</span>
            </div>
        @empty
            <div style="grid-column:span 2;text-align:center;padding:32px;color:var(--gray);font-size:13px;">
                Belum ada UMKM aktif
            </div>
        @endforelse
    </div>
</div>

@endsection