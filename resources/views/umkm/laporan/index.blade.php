@extends('layouts.dashboard')
@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@section('dashboard-content')

{{-- Filter --}}
<div class="card" style="margin-bottom:20px">
    <div style="padding:16px 24px">
        <form method="GET" action="{{ route('umkm.laporan') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
            <div class="form-group" style="margin:0">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select">
                    @foreach(range(1,12) as $b)
                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin:0">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    @foreach(range(now()->year, now()->year - 3) as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-blue">Filter</button>
        </form>
    </div>
</div>

{{-- Summary Cards --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:20px">
    <div class="card" style="padding:20px">
        <p style="font-size:13px;color:#64748b;margin:0">Total Pendapatan</p>
        <p style="font-size:22px;font-weight:700;color:#16a34a;margin:4px 0 0">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </p>
    </div>
    <div class="card" style="padding:20px">
        <p style="font-size:13px;color:#64748b;margin:0">Total Pesanan</p>
        <p style="font-size:22px;font-weight:700;color:#0f172a;margin:4px 0 0">{{ $totalPesanan }}</p>
    </div>
    <div class="card" style="padding:20px">
        <p style="font-size:13px;color:#64748b;margin:0">Pesanan Selesai</p>
        <p style="font-size:22px;font-weight:700;color:#3b82f6;margin:4px 0 0">{{ $pesananSelesai }}</p>
    </div>
    <div class="card" style="padding:20px">
        <p style="font-size:13px;color:#64748b;margin:0">Pesanan Dibatalkan</p>
        <p style="font-size:22px;font-weight:700;color:#ef4444;margin:4px 0 0">{{ $pesananBatal }}</p>
    </div>
</div>

{{-- Tabel Pesanan --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Rincian Pesanan</h3>
    </div>
    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;font-size:14px">
            <thead>
                <tr style="background:#f8fafc">
                    <th style="padding:12px 16px;text-align:left;color:#64748b;font-size:12px;text-transform:uppercase">No. Pesanan</th>
                    <th style="padding:12px 16px;text-align:left;color:#64748b;font-size:12px;text-transform:uppercase">Pembeli</th>
                    <th style="padding:12px 16px;text-align:left;color:#64748b;font-size:12px;text-transform:uppercase">Tanggal</th>
                    <th style="padding:12px 16px;text-align:left;color:#64748b;font-size:12px;text-transform:uppercase">Status</th>
                    <th style="padding:12px 16px;text-align:right;color:#64748b;font-size:12px;text-transform:uppercase">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr style="border-top:1px solid #f1f5f9">
                    <td style="padding:12px 16px">
                        <a href="{{ route('umkm.pesanan.show', $order->id) }}" style="color:#3b82f6;font-weight:600">
                            {{ $order->order_number ?? '#'.$order->id }}
                        </a>
                    </td>
                    <td style="padding:12px 16px">{{ $order->customer->name ?? '-' }}</td>
                    <td style="padding:12px 16px">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td style="padding:12px 16px">
                        @php
                            $colors = [
                                'pending'    => '#854d0e;background:#fef9c3',
                                'confirmed'  => '#1d4ed8;background:#dbeafe',
                                'processing' => '#0369a1;background:#e0f2fe',
                                'shipped'    => '#6d28d9;background:#ede9fe',
                                'delivered'  => '#15803d;background:#dcfce7',
                                'cancelled'  => '#b91c1c;background:#fee2e2',
                            ];
                            $style = $colors[$order->status] ?? '#475569;background:#f1f5f9';
                        @endphp
                        <span style="padding:3px 10px;border-radius:999px;font-size:12px;font-weight:600;color:{{ $style }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td style="padding:12px 16px;text-align:right;font-weight:600">
                        Rp {{ number_format($order->grand_total ?? $order->total_price ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:32px;text-align:center;color:#94a3b8;font-style:italic">
                        Tidak ada pesanan pada periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection