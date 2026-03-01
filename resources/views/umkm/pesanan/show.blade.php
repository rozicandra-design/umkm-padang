@extends('layouts.dashboard')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="order-detail-page">

    {{-- Header --}}
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('umkm.pesanan.index') }}" class="back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
                Kembali
            </a>
            <div>
                <h1 class="page-title">Pesanan <span class="order-id">#{{ $order->id }}</span></h1>
                <p class="page-subtitle">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>
        <div class="header-right">
            <span class="status-badge status-{{ $order->status }}">
                @switch($order->status)
                    @case('pending') ⏳ Menunggu @break
                    @case('processing') 🔄 Diproses @break
                    @case('shipped') 🚚 Dikirim @break
                    @case('delivered') ✅ Selesai @break
                    @case('cancelled') ❌ Dibatalkan @break
                    @default {{ ucfirst($order->status) }}
                @endswitch
            </span>
        </div>
    </div>

    <div class="order-grid">

        {{-- Informasi Pembeli --}}
        <div class="card">
            <div class="card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <h2>Informasi Pembeli</h2>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="info-label">Nama</span>
                    <span class="info-value">{{ $order->customer->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $order->customer->email ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Telepon</span>
                    <span class="info-value">{{ $order->customer->phone ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Informasi Pengiriman --}}
        <div class="card">
            <div class="card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
                <h2>Alamat Pengiriman</h2>
            </div>
            <div class="card-body">
                <p class="address-text">{{ $order->shipping_address ?? 'Alamat tidak tersedia' }}</p>
                @if($order->shipping_notes)
                    <div class="info-row" style="margin-top: 12px;">
                        <span class="info-label">Catatan</span>
                        <span class="info-value">{{ $order->shipping_notes }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Item Pesanan --}}
        <div class="card card-full">
            <div class="card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <path d="M16 10a4 4 0 0 1-8 0" />
                </svg>
                <h2>Item Pesanan</h2>
            </div>
            <div class="card-body no-padding">
                <div class="items-table-wrapper">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Harga Satuan</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="product-info">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}" class="product-thumb">
                                            @else
                                                <div class="product-thumb-placeholder">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="1.5">
                                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                                        <polyline points="21 15 16 10 5 21" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="product-name">{{ $item->product->name ?? 'Produk dihapus' }}</p>
                                                @if($item->product && $item->product->sku)
                                                    <p class="product-sku">SKU: {{ $item->product->sku }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="qty-badge">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-right font-semibold">
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-items">Tidak ada item dalam pesanan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Ringkasan Harga --}}
                <div class="price-summary">
                    <div class="price-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
                    </div>
                    @if(isset($order->shipping_cost) && $order->shipping_cost > 0)
                        <div class="price-row">
                            <span>Ongkos Kirim</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if(isset($order->discount) && $order->discount > 0)
                        <div class="price-row discount">
                            <span>Diskon</span>
                            <span>- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="price-row total">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total_price ?? $order->total ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aksi Pesanan --}}
        @if(!in_array($order->status, ['shipped', 'delivered', 'cancelled']))
            <div class="card card-full">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 11 12 14 22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                    <h2>Aksi Pesanan</h2>
                </div>
                <div class="card-body">
                    <div class="action-buttons">
                        @if($order->status === 'pending')
                            <form action="{{ route('umkm.pesanan.konfirmasi', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-action btn-confirm"
                                    onclick="return confirm('Konfirmasi pesanan ini?')">
                                    ✔️ Konfirmasi Pesanan
                                </button>
                            </form>
                        @endif

                        @if(in_array($order->status, ['pending', 'confirmed', 'processing']))
                            <form action="{{ route('umkm.pesanan.kirim', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-action btn-ship"
                                    onclick="return confirm('Tandai pesanan ini sebagai dikirim?')">
                                    🚚 Tandai Dikirim
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

<style>
    .order-detail-page {
        padding: 24px;
        max-width: 1100px;
        margin: 0 auto;
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    /* Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #475569;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: background 0.2s;
        white-space: nowrap;
    }

    .back-btn:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .page-title {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .order-id {
        color: #3b82f6;
    }

    .page-subtitle {
        font-size: 13px;
        color: #94a3b8;
        margin: 2px 0 0;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
    }

    .status-pending { background: #fef9c3; color: #854d0e; }
    .status-processing { background: #dbeafe; color: #1d4ed8; }
    .status-shipped { background: #e0f2fe; color: #0369a1; }
    .status-delivered { background: #dcfce7; color: #15803d; }
    .status-cancelled { background: #fee2e2; color: #b91c1c; }

    /* Grid */
    .order-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .card-full {
        grid-column: 1 / -1;
    }

    /* Card */
    .card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        background: #f8fafc;
    }

    .card-header h2 {
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .card-header svg {
        color: #64748b;
        flex-shrink: 0;
    }

    .card-body {
        padding: 20px;
    }

    .no-padding {
        padding: 0;
    }

    /* Info Rows */
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 8px 0;
        border-bottom: 1px solid #f8fafc;
        gap: 16px;
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        font-size: 13px;
        color: #94a3b8;
        font-weight: 500;
        flex-shrink: 0;
    }

    .info-value {
        font-size: 14px;
        color: #1e293b;
        font-weight: 500;
        text-align: right;
    }

    .address-text {
        font-size: 14px;
        color: #334155;
        line-height: 1.6;
        margin: 0;
    }

    /* Items Table */
    .items-table-wrapper {
        overflow-x: auto;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .items-table thead tr {
        background: #f8fafc;
    }

    .items-table th {
        padding: 12px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }

    .items-table td {
        padding: 14px 20px;
        border-top: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .items-table tr:hover td {
        background: #fafafa;
    }

    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .font-semibold { font-weight: 600; color: #0f172a; }

    /* Product Info */
    .product-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-thumb {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
    }

    .product-thumb-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .product-name {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .product-sku {
        font-size: 12px;
        color: #94a3b8;
        margin: 2px 0 0;
    }

    .qty-badge {
        display: inline-block;
        padding: 2px 10px;
        background: #f1f5f9;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }

    .empty-items {
        text-align: center;
        color: #94a3b8;
        padding: 32px !important;
        font-style: italic;
    }

    /* Price Summary */
    .price-summary {
        border-top: 2px solid #f1f5f9;
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
    }

    .price-row {
        display: flex;
        gap: 48px;
        font-size: 14px;
        color: #475569;
    }

    .price-row span:last-child {
        min-width: 140px;
        text-align: right;
    }

    .price-row.discount {
        color: #16a34a;
    }

    .price-row.total {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        border-top: 1px solid #e2e8f0;
        padding-top: 10px;
        margin-top: 4px;
    }

    /* Status Form */
    .status-form {
        display: flex;
        align-items: flex-end;
        gap: 16px;
        flex-wrap: wrap;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
        min-width: 200px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }

    .form-select {
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        color: #1e293b;
        background: #fff;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
        cursor: pointer;
    }

    .form-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn-update {
        padding: 10px 22px;
        background: #3b82f6;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        white-space: nowrap;
    }

    .btn-update:hover {
        background: #2563eb;
    }

    .btn-update:active {
        transform: scale(0.98);
    }


    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 10px 22px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
    }

    .btn-action:active { transform: scale(0.98); }

    .btn-confirm {
        background: #22c55e;
        color: #fff;
    }
    .btn-confirm:hover { background: #16a34a; }

    .btn-ship {
        background: #3b82f6;
        color: #fff;
    }
    .btn-ship:hover { background: #2563eb; }

    /* Responsive */
    @media (max-width: 768px) {
        .order-detail-page { padding: 16px; }
        .order-grid { grid-template-columns: 1fr; }
        .card-full { grid-column: 1; }
        .page-header { flex-direction: column; align-items: flex-start; }
        .price-row { gap: 24px; }
        .price-row span:last-child { min-width: 100px; }
    }
</style>
@endsection