@extends('layouts.dashboard')
@section('title', 'Pesanan Masuk')
@section('page-title', 'Pesanan Masuk')

@section('dashboard-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-shopping-bag"></i> Daftar Pesanan Masuk</h3>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr><th>No. Pesanan</th><th>Pelanggan</th><th>Total</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><code>{{ $order->order_number }}</code></td>
                    <td>{{ $order->customer->name }}</td>
                    <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                    <td><span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span></td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td style="display:flex;gap:6px">
                        <a href="{{ route('umkm.pesanan.show', $order) }}" class="btn btn-sm btn-outline-blue">Detail</a>
                        @if($order->status === 'pending')
                        <form action="{{ route('umkm.pesanan.konfirmasi', $order) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-success">Konfirmasi</button>
                        </form>
                        @elseif($order->status === 'confirmed')
                        <form action="{{ route('umkm.pesanan.kirim', $order) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-blue">Kirim</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted" style="padding:32px">Belum ada pesanan masuk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px">{{ $orders->links() }}</div>
</div>
@endsection
