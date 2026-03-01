@extends('layouts.dashboard')
@section('title', 'Laporan')
@section('page-title', 'Laporan & Statistik')

@section('dashboard-content')

@php
    $bulanNama = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    $omzetPerBulan = collect($omzetBulanan)->keyBy('bulan');
    $maxOmzet = $omzetBulanan->max('omzet') ?: 1;
@endphp

{{-- Stats Ringkasan --}}
<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card stat-card-green">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-store"></i></div>
            <span class="stat-badge stat-badge-green">Aktif</span>
        </div>
        <div>
            <div class="stat-num">{{ $umkmPerKategori->sum('total') }}</div>
            <div class="stat-label">Total UMKM Aktif</div>
        </div>
    </div>
    <div class="stat-card stat-card-amber">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fa fa-chart-line"></i></div>
            <span class="stat-badge stat-badge-amber">{{ now()->year }}</span>
        </div>
        <div>
            <div class="stat-num-sm">Rp {{ number_format($omzetBulanan->sum('omzet'), 0, ',', '.') }}</div>
            <div class="stat-label">Total Omzet Tahun Ini</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">

    {{-- Omzet Per Bulan --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-chart-bar"></i> Omzet Per Bulan ({{ now()->year }})</h3>
        </div>
        <div style="padding:20px;">
            @if($omzetBulanan->isEmpty())
                <p class="text-muted text-center" style="padding:24px;font-size:13px;">Belum ada data omzet</p>
            @else
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @for($i = 1; $i <= 12; $i++)
                        @php
                            $data = $omzetPerBulan->get($i);
                            $omzet = $data ? $data->omzet : 0;
                            $pct = $maxOmzet > 0 ? ($omzet / $maxOmzet * 100) : 0;
                        @endphp
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span style="width:30px;font-size:12px;color:#6b7280;text-align:right;">{{ $bulanNama[$i] }}</span>
                            <div style="flex:1;background:#f3f4f6;border-radius:99px;height:10px;overflow:hidden;">
                                <div style="width:{{ $pct }}%;background:#16a34a;height:100%;border-radius:99px;transition:width .3s;"></div>
                            </div>
                            <span style="width:110px;font-size:12px;font-weight:600;color:#374151;text-align:right;">
                                Rp {{ number_format($omzet, 0, ',', '.') }}
                            </span>
                        </div>
                    @endfor
                </div>
            @endif
        </div>
    </div>

    {{-- UMKM Per Kategori --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-tags"></i> UMKM Per Kategori</h3>
        </div>
        <div style="padding:20px;">
            @if($umkmPerKategori->isEmpty())
                <p class="text-muted text-center" style="padding:24px;font-size:13px;">Belum ada data</p>
            @else
                @php $maxKategori = $umkmPerKategori->max('total') ?: 1; @endphp
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($umkmPerKategori as $item)
                        @php $pct = $item->total / $maxKategori * 100; @endphp
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span style="width:110px;font-size:12px;color:#6b7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $item->kategori }}
                            </span>
                            <div style="flex:1;background:#f3f4f6;border-radius:99px;height:10px;overflow:hidden;">
                                <div style="width:{{ $pct }}%;background:#2563eb;height:100%;border-radius:99px;"></div>
                            </div>
                            <span style="width:40px;font-size:12px;font-weight:700;color:#374151;text-align:right;">
                                {{ $item->total }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Tabel Detail Omzet --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-table"></i> Detail Omzet Bulanan</h3>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Omzet</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php $totalOmzet = $omzetBulanan->sum('omzet'); @endphp
                @forelse($omzetBulanan as $row)
                <tr>
                    <td>{{ $bulanNama[$row->bulan] }} {{ now()->year }}</td>
                    <td><strong>Rp {{ number_format($row->omzet, 0, ',', '.') }}</strong></td>
                    <td>
                        @php $pct = $totalOmzet > 0 ? round($row->omzet / $totalOmzet * 100, 1) : 0; @endphp
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:80px;background:#f3f4f6;border-radius:99px;height:6px;">
                                <div style="width:{{ $pct }}%;background:#16a34a;height:100%;border-radius:99px;"></div>
                            </div>
                            <span style="font-size:12px;color:#6b7280;">{{ $pct }}%</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted" style="padding:32px;">
                        Belum ada data omzet tahun ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection