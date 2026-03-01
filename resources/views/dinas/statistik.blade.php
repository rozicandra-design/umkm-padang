@extends('layouts.dashboard')
@section('title', 'Statistik')
@section('page-title', 'Statistik UMKM')

@section('dashboard-content')

<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card stat-card-green">
        <div class="stat-card-top"><div class="stat-icon"><i class="fa fa-store"></i></div></div>
        <div><div class="stat-num">{{ $totalUmkm }}</div><div class="stat-label">Total UMKM Aktif</div></div>
    </div>
    <div class="stat-card stat-card-blue">
        <div class="stat-card-top"><div class="stat-icon"><i class="fa fa-box"></i></div></div>
        <div><div class="stat-num">{{ $totalProduk }}</div><div class="stat-label">Total Produk</div></div>
    </div>
    <div class="stat-card stat-card-amber">
        <div class="stat-card-top"><div class="stat-icon"><i class="fa fa-shopping-bag"></i></div></div>
        <div><div class="stat-num">{{ $totalPesanan }}</div><div class="stat-label">Total Pesanan</div></div>
    </div>
    <div class="stat-card stat-card-purple">
        <div class="stat-card-top"><div class="stat-icon"><i class="fa fa-chart-line"></i></div></div>
        <div><div class="stat-num-sm">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div><div class="stat-label">Total Omzet</div></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-tags"></i> UMKM Per Kategori</h3>
        </div>
        <div style="padding:20px;">
            @php $maxK = $umkmPerKategori->max('total') ?: 1; @endphp
            @forelse($umkmPerKategori as $item)
                @php $pct = $item->total / $maxK * 100; @endphp
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                    <span style="width:120px;font-size:12px;color:#6b7280;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item->kategori }}</span>
                    <div style="flex:1;background:#f3f4f6;border-radius:99px;height:10px;">
                        <div style="width:{{ $pct }}%;background:#16a34a;height:100%;border-radius:99px;"></div>
                    </div>
                    <span style="width:30px;font-size:12px;font-weight:700;text-align:right;">{{ $item->total }}</span>
                </div>
            @empty
                <p class="text-muted text-center">Belum ada data</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-map-marker"></i> UMKM Per Kecamatan</h3>
        </div>
        <div style="padding:20px;">
            @php $maxKec = $umkmPerKecamatan->max('total') ?: 1; @endphp
            @forelse($umkmPerKecamatan as $item)
                @php $pct = $item->total / $maxKec * 100; @endphp
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                    <span style="width:120px;font-size:12px;color:#6b7280;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item->kecamatan ?? '-' }}</span>
                    <div style="flex:1;background:#f3f4f6;border-radius:99px;height:10px;">
                        <div style="width:{{ $pct }}%;background:#2563eb;height:100%;border-radius:99px;"></div>
                    </div>
                    <span style="width:30px;font-size:12px;font-weight:700;text-align:right;">{{ $item->total }}</span>
                </div>
            @empty
                <p class="text-muted text-center">Belum ada data</p>
            @endforelse
        </div>
    </div>

</div>

@endsection