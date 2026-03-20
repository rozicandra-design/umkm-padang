@extends('layouts.dashboard')
@section('title', 'Pesanan Saya')
@section('page-title', 'Pesanan Saya')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .po-wrap { width: 100%; padding: 0 0 40px; font-family: 'Inter', sans-serif; background: #f5f5f5; }

    /* ── Tabs ── */
    .po-tabs { display: flex; background: #fff; border-bottom: 1.5px solid #e8e8e8; overflow-x: auto; scrollbar-width: none; margin-bottom: 8px; }
    .po-tabs::-webkit-scrollbar { display: none; }
    .po-tabs a { flex-shrink: 0; padding: 11px 18px; font-size: 13px; font-weight: 600; color: #888; text-decoration: none; white-space: nowrap; border-bottom: 2.5px solid transparent; margin-bottom: -1.5px; transition: all 0.15s; font-family: 'Inter', sans-serif; }
    .po-tabs a:hover { color: #16a34a; }
    .po-tabs a.po-active { color: #16a34a; border-bottom-color: #16a34a; }

    /* ── Card ── */
    .po-card { background: #fff; margin: 0 0 8px; overflow: hidden; border-top: 1px solid #e8e8e8; border-bottom: 1px solid #e8e8e8; border-left: none; border-right: none; border-radius: 0; }

    .po-head { display: flex; align-items: center; justify-content: space-between; padding: 8px 16px; border-bottom: 1px solid #f0f0f0; }
    .po-shop { display: flex; align-items: center; gap: 6px; }
    .po-shop-name { font-size: 13px; font-weight: 700; color: #111; font-family: 'Inter', sans-serif; }
    .po-badge { font-size: 9px; font-weight: 700; color: #16a34a; border: 1px solid #16a34a; padding: 1px 5px; border-radius: 3px; }
    .po-status { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; }

    .po-meta { font-size: 11px; color: #bbb; padding: 4px 16px; font-family: monospace; border-bottom: 1px solid #f5f5f5; }

    .po-product { display: flex; align-items: center; gap: 10px; padding: 8px 16px; border-bottom: 1px solid #f5f5f5; }
    .po-thumb { width: 48px; height: 48px; min-width: 48px; border-radius: 5px; background: #f5f5f5; border: 1px solid #e8e8e8; display: flex; align-items: center; justify-content: center; font-size: 22px; }
    .po-pname { font-size: 13px; color: #222; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .po-pqty { font-size: 11px; color: #999; margin-top: 2px; }
    .po-pprice { font-size: 13px; font-weight: 700; color: #222; text-align: right; white-space: nowrap; flex-shrink: 0; }
    .po-more { font-size: 11px; color: #aaa; padding: 2px 16px 6px; }

    .po-foot { display: flex; align-items: center; justify-content: space-between; padding: 8px 16px; gap: 8px; }
    .po-total { display: flex; align-items: center; gap: 5px; }
    .po-total-label { font-size: 12px; color: #888; }
    .po-total-amt { font-size: 14px; font-weight: 700; color: #16a34a; }
    .po-btn { font-size: 12px; font-weight: 600; color: #16a34a; text-decoration: none; border: 1.5px solid #16a34a; background: #fff; padding: 5px 14px; border-radius: 4px; transition: all 0.15s; white-space: nowrap; }
    .po-btn:hover { background: #16a34a; color: #fff; }

    /* Empty */
    .po-empty { text-align: center; padding: 48px 20px; background: #fff; }
    .po-empty-icon { font-size: 40px; display: block; margin-bottom: 10px; }
    .po-empty h3 { font-size: 14px; font-weight: 700; color: #333; margin: 0 0 4px; }
    .po-empty p { font-size: 12px; color: #999; margin: 0 0 14px; }
    .po-btn-shop { display: inline-flex; align-items: center; gap: 5px; background: #16a34a; color: #fff; font-weight: 700; font-size: 12px; padding: 8px 20px; border-radius: 4px; text-decoration: none; }
    .po-btn-shop:hover { background: #15803d; }

    .po-pages { padding: 12px; display: flex; justify-content: center; }
</style>
@endpush

@section('dashboard-content')
<div class="po-wrap">

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

    <div class="po-tabs">
        @foreach($statusList as $val => $label)
            <a href="{{ request()->fullUrlWithQuery(['status' => $val]) }}"
               class="{{ $activeStatus === $val ? 'po-active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    @forelse($orders as $order)
    @php
        $sc = match($order->status) {
            'pending'    => ['color' => '#f59e0b', 'label' => 'Menunggu Konfirmasi'],
            'confirmed'  => ['color' => '#3b82f6', 'label' => 'Dikonfirmasi'],
            'processing' => ['color' => '#8b5cf6', 'label' => 'Sedang Diproses'],
            'shipped'    => ['color' => '#06b6d4', 'label' => 'Sedang Dikirim'],
            'delivered'  => ['color' => '#16a34a', 'label' => 'Pesanan Selesai'],
            'cancelled'  => ['color' => '#dc2626', 'label' => 'Dibatalkan'],
            default      => ['color' => '#6b7280', 'label' => ucfirst($order->status)],
        };
        $fi = $order->items->first();
        $extra = $order->items->count() - 1;
    @endphp

    <div class="po-card">
        <div class="po-head">
            <div class="po-shop">
                <span>🏪</span>
                <span class="po-shop-name">{{ $order->umkm->name ?? '-' }}</span>
                <span class="po-badge">UMKM</span>
            </div>
            <span class="po-status" style="color:{{ $sc['color'] }};">{{ $sc['label'] }}</span>
        </div>

        <div class="po-meta">{{ $order->order_number }} &bull; {{ $order->created_at->format('d M Y, H:i') }}</div>

        <div class="po-product">
            <div class="po-thumb">📦</div>
            <div style="flex:1;min-width:0;">
                <div class="po-pname">{{ $fi?->product?->name ?? 'Produk tidak tersedia' }}</div>
                <div class="po-pqty">x{{ $fi?->quantity ?? 1 }}</div>
            </div>
            <div class="po-pprice">Rp {{ number_format($fi?->price ?? 0, 0, ',', '.') }}</div>
        </div>

        @if($extra > 0)
        <div class="po-more">+ {{ $extra }} produk lainnya</div>
        @endif

        <div class="po-foot">
            <div class="po-total">
                <span class="po-total-label">Total:</span>
                <span class="po-total-amt">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('customer.pesanan.show', $order->id) }}" class="po-btn">Lihat Detail</a>
        </div>
    </div>
    @empty
    <div class="po-empty">
        <span class="po-empty-icon">🛍️</span>
        <h3>{{ $activeStatus ? 'Tidak ada pesanan di sini.' : 'Belum ada pesanan.' }}</h3>
        <p>{{ $activeStatus ? 'Coba cek tab lainnya.' : 'Yuk mulai belanja produk UMKM lokal!' }}</p>
        @if(!$activeStatus)
            <a href="{{ route('katalog') }}" class="po-btn-shop">Mulai Belanja</a>
        @endif
    </div>
    @endforelse

    @if($orders->hasPages())
    <div class="po-pages">{{ $orders->appends(request()->query())->links() }}</div>
    @endif

</div>
@endsection