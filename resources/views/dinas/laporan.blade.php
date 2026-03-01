@extends('layouts.dashboard')
@section('title', 'Laporan UMKM')
@section('page-title', 'Laporan UMKM')

@section('dashboard-content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-file-alt"></i> Laporan Data UMKM Kota Padang</h3>
        <a href="{{ route('dinas.laporan.export') }}" class="btn btn-blue btn-sm">
            <i class="fa fa-download"></i> Export Excel
        </a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Jumlah UMKM</th>
                    <th>Produk</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php $total = $umkmPerKategori->sum('total'); @endphp
                @forelse($umkmPerKategori as $item)
                <tr>
                    <td><strong>{{ $item->kategori }}</strong></td>
                    <td>{{ $item->total }}</td>
                    <td>-</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px">
                            <div style="flex:1;height:6px;background:#e5e7eb;border-radius:3px">
                                <div style="width:{{ $total > 0 ? round($item->total/$total*100) : 0 }}%;height:100%;background:#1553A8;border-radius:3px"></div>
                            </div>
                            <span style="font-size:12px;font-weight:600">{{ $total > 0 ? round($item->total/$total*100) : 0 }}%</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
