@extends('layouts.dashboard')
@section('title', 'Pesanan Saya')
@section('page-title', 'Pesanan Saya')
@section('dashboard-content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .orders-wrap * {
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    .orders-wrap {
        max-width: 860px;
        margin: 0 auto;
        padding: 0 0 60px;
        background: #f5f5f5;
        min-height: 100vh;
    }

    /* ── Filter Tab Bar (Shopee style) ── */
    .filter-tabs {
        display: flex;
        background: #fff;
        border-bottom: 1px solid #e8e8e8;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .filter-tabs::-webkit-scrollbar { display: none; }

    .filter-tabs a {
        flex-shrink: 0;
        padding: 14px 20px;
        font-size: 13px;
        font-weight: 600;
        color: #888;
        text-decoration: none;
        white-space: nowrap;
        border-bottom: 2px solid transparent;
        transition: all 0.18s;
    }

    .filter-tabs a:hover { color: #16a34a; }

    .filter-tabs a.active {
        color: #16a34a;
        border-bottom: 2px solid #16a34a;
    }

    /* ── Alert ── */
    .alert-success {
        background: #f0fdf4;
        color: #15803d;
        padding: 12px 16px;
        font-weight: 600;
        font-size: 13px;
        border-left: 3px solid #16a34a;
        margin: 12px 12px 0;
        border-radius: 8px;
    }

    /* ── Order Card ── */
    .order-card {
        background: #fff;
        margin: 10px 0;
        border-top: 1px solid #efefef;
        border-bottom: 1px solid #efefef;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-bottom: 1px solid #f5f5f5;
        gap: 8px;
    }

    .shop-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .shop-name {
        font-size: 13px;
        font-weight: 700;
        color: #222;
    }

    .shop-badge {
        font-size: 10px;
        font-weight: 600;
        color: #16a34a;
        border: 1px solid #16a34a;
        padding: 1px 6px;
        border-radius: 3px;
        margin-left: 4px;
    }

    .status-text {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .order-meta-sub {
        font-size: 11px;
        color: #bbb;
        padding: 6px 16px 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .order-meta-sub span {
        font-family: monospace;
        color: #aaa;
    }

    .product-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 16px;
        border-bottom: 1px solid #f5f5f5;
    }

    .product-thumb {
        width: 64px;
        height: 64px;
        border-radius: 6px;
        background: #f5f5f5;
        border: 1px solid #e8e8e8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        flex-shrink: 0;
    }

    .product-info { flex: 1; min-width: 0; }

    .product-name {
        font-size: 13px;
        color: #222;
        font-weight: 500;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-qty { font-size: 12px; color: #999; }

    .product-price {
        font-size: 14px;
        font-weight: 700;
        color: #222;
        text-align: right;
        flex-shrink: 0;
    }

    .more-items {
        font-size: 12px;
        color: #999;
        padding: 4px 16px 10px;
    }

    .card-footer {
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .total-section {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .total-label { font-size: 12px; color: #888; }

    .total-amount {
        font-size: 15px;
        font-weight: 700;
        color: #16a34a;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        font-size: 13px;
        font-weight: 600;
        color: #16a34a;
        text-decoration: none;
        border: 1px solid #16a34a;
        background: #fff;
        padding: 7px 18px;
        border-radius: 4px;
        transition: all 0.15s;
    }

    .btn-detail:hover {
        background: #16a34a;
        color: #fff;
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 72px 20px;
        background: #fff;
        margin-top: 10px;
    }

    .empty-icon { font-size: 56px; margin-bottom: 14px; }

    .empty-state h3 {
        font-size: 15px;
        font-weight: 700;
        color: #333;
        margin: 0 0 6px;
    }

    .empty-state p {
        font-size: 13px;
        color: #999;
        margin: 0 0 20px;
    }

    .btn-shop {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #16a34a;
        color: #fff;
        font-weight: 700;
        font-size: 13px;
        padding: 10px 24px;
        border-radius: 4px;
        text-decoration: none;
        transition: background 0.15s;
    }

    .btn-shop:hover { background: #15803d; }

    .pagination-wrap {
        padding: 16px;
        display: flex;
        justify-content: center;
    }
</style>

<div class="orders-wrap">

    {{-- Filter Tabs --}}
    @php
        $statusList = [
            ''           => 'Semua',
            'pending'    => 'Menunggu',
            'confirmed'  => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'shipped'    => 'Dikirim',
            'delivered'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
        ];
        $activeStatus = request('status', '');
    @endphp

    <div class="filter-tabs">
        @foreach($statusList as $val => $label)
            <a href="{{ request()->fullUrlWithQuery(['status' => $val]) }}"
               class="{{ $activeStatus === $val ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
    @endif

    {{-- Order List --}}
    @forelse($orders as $order)
    @php
        $statusConfig = match($order->status) {
            'pending'    => ['color' => '#f59e0b', 'label' => 'Menunggu Konfirmasi'],
            'confirmed'  => ['color' => '#3b82f6', 'label' => 'Dikonfirmasi'],
            'processing' => ['color' => '#8b5cf6', 'label' => 'Sedang Diproses'],
            'shipped'    => ['color' => '#06b6d4', 'label' => 'Sedang Dikirim'],
            'delivered'  => ['color' => '#16a34a', 'label' => 'Pesanan Selesai'],
            'cancelled'  => ['color' => '#dc2626', 'label' => 'Dibatalkan'],
            default      => ['color' => '#6b7280', 'label' => ucfirst($order->status)],
        };
        $firstItem = $order->items->first();
        $extraCount = $order->items->count() - 1;
    @endphp

    <div class="order-card">

        {{-- Shop + Status --}}
        <div class="card-header">
            <div class="shop-info">
                <span>🏪</span>
                <span class="shop-name">{{ $order->umkm->name ?? '-' }}</span>
                <span class="shop-badge">UMKM</span>
            </div>
            <span class="status-text" style="color:{{ $statusConfig['color'] }};">
                {{ $statusConfig['label'] }}
            </span>
        </div>

        {{-- Order number + date --}}
        <div class="order-meta-sub">
            <span>{{ $order->order_number }}</span>
            &bull;
            {{ $order->created_at->format('d M Y, H:i') }}
        </div>

        {{-- Product --}}
        <div class="product-row">
            <div class="product-thumb">📦</div>
            <div class="product-info">
                <div class="product-name">
                    {{ $firstItem?->product?->name ?? 'Produk tidak tersedia' }}
                </div>
                <div class="product-qty">x{{ $firstItem?->quantity ?? 1 }}</div>
            </div>
            <div class="product-price">
                Rp {{ number_format($firstItem?->price ?? 0, 0, ',', '.') }}
            </div>
        </div>

        @if($extraCount > 0)
        <div class="more-items">+ {{ $extraCount }} produk lainnya</div>
        @endif

        {{-- Footer --}}
        <div class="card-footer">
            <div class="total-section">
                <span class="total-label">Total Pesanan:</span>
                <span class="total-amount">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('customer.pesanan.show', $order->id) }}" class="btn-detail">
                Lihat Detail
            </a>
        </div>

    </div>
    @empty
    <div class="empty-state">
        <div class="empty-icon">🛍️</div>
        <h3>{{ $activeStatus ? 'Tidak ada pesanan di sini.' : 'Belum ada pesanan.' }}</h3>
        <p>{{ $activeStatus ? 'Coba cek tab status lainnya.' : 'Yuk mulai belanja produk UMKM lokal!' }}</p>
        @if(!$activeStatus)
            <a href="{{ route('katalog') }}" class="btn-shop">Mulai Belanja</a>
        @endif
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($orders->hasPages())
    <div class="pagination-wrap">
        {{ $orders->appends(request()->query())->links() }}
    </div>
    @endif

</div>

@endsection