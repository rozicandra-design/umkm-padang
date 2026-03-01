@extends('layouts.dashboard')

@section('content')
<div style="max-width:900px;margin:0 auto;padding:32px 16px;">

    <h1 style="font-size:22px;font-weight:800;color:#111827;margin-bottom:24px;">Pesanan Saya</h1>

    @if(session('success'))
        <div style="background:#dcfce7;color:#16a34a;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-weight:600;">
            {{ session('success') }}
        </div>
    @endif

    @forelse($orders as $order)
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
            <div>
                <span style="font-size:14px;font-weight:700;color:#111827;">{{ $order->order_number }}</span>
                <span style="font-size:12px;color:#6b7280;margin-left:10px;">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            @php
                $statusColor = match($order->status) {
                    'pending'    => '#f59e0b',
                    'confirmed'  => '#3b82f6',
                    'processing' => '#8b5cf6',
                    'shipped'    => '#06b6d4',
                    'delivered'  => '#16a34a',
                    'cancelled'  => '#dc2626',
                    default      => '#6b7280',
                };
            @endphp
            <span style="font-size:12px;font-weight:700;color:{{ $statusColor }};background:{{ $statusColor }}20;padding:4px 12px;border-radius:99px;">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div style="font-size:13px;color:#6b7280;margin-bottom:8px;">
            🏪 {{ $order->umkm->name ?? '-' }}
        </div>

        <div style="font-size:13px;color:#6b7280;margin-bottom:12px;">
            📦 {{ $order->items->count() }} produk
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div style="font-size:15px;font-weight:800;color:#16a34a;">
                Rp {{ number_format($order->grand_total, 0, ',', '.') }}
            </div>
            <a href="{{ route('customer.pesanan.show', $order->id) }}"
               style="font-size:13px;font-weight:600;color:#16a34a;text-decoration:none;border:1px solid #16a34a;padding:6px 14px;border-radius:8px;">
                Lihat Detail →
            </a>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:60px 0;color:#6b7280;">
        <div style="font-size:48px;margin-bottom:16px;">🛍</div>
        <p style="font-size:15px;font-weight:600;">Belum ada pesanan.</p>
        <a href="{{ route('katalog') }}" style="color:#16a34a;font-weight:700;text-decoration:none;">Mulai Belanja →</a>
    </div>
    @endforelse

    <div style="margin-top:16px;">
        {{ $orders->links() }}
    </div>
</div>
@endsection