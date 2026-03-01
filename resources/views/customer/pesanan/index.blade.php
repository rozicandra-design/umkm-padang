@extends('layouts.dashboard')
@section('title', 'Pesanan Saya')
@section('page-title', 'Pesanan Saya')

@section('dashboard-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-shopping-bag"></i> Daftar Pesanan</h3>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr><th>No. Pesanan</th><th>Toko</th><th>Item</th><th>Total</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><code>{{ $order->order_number }}</code></td>
                    <td>{{ $order->umkm->name ?? '-' }}</td>
                    <td>{{ $order->items->count() }} item</td>
                    <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                    <td><span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span></td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('customer.pesanan.show', $order) }}" class="btn btn-sm btn-outline-blue">Detail</a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted" style="padding:32px">Belum ada pesanan. <a href="{{ route('katalog') }}" style="color:#1553A8">Mulai belanja →</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px">{{ $orders->links() }}</div>
</div>
@endsection
