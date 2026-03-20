@extends('layouts.dashboard')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('dashboard-content')

{{-- TOAST --}}
@if(session('success'))
<div id="toast" style="
    position:fixed; top:24px; right:24px; z-index:9999;
    background:#22c55e; color:#fff;
    padding:14px 20px; border-radius:12px;
    font-size:14px; font-weight:600;
    box-shadow:0 8px 24px rgba(34,197,94,0.35);
    display:flex; align-items:center; gap:10px;
    animation: slideIn .3s ease;
">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
</div>
<style>@keyframes slideIn{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:translateX(0)}}</style>
<script>setTimeout(()=>{const t=document.getElementById('toast');if(t)t.style.display='none';},3500);</script>
@endif

{{-- MODAL STRUK RESI --}}
<div id="modalStruk" style="display:none;position:fixed;inset:0;z-index:2000;align-items:center;justify-content:center;">
    <div style="position:absolute;inset:0;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);" onclick="tutupModal('modalStruk')"></div>
    <div style="position:relative;background:#f1f1f1;border-radius:16px;max-width:400px;width:95%;max-height:90vh;overflow-y:auto;box-shadow:0 32px 80px rgba(0,0,0,0.25);">
        <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 18px;background:#fff;border-radius:16px 16px 0 0;border-bottom:1px solid #e5e5e5;">
            <span style="font-size:14px;font-weight:700;color:#111;">Struk Pesanan</span>
            <div style="display:flex;gap:8px;">
                <button onclick="downloadStruk()" style="display:flex;align-items:center;gap:5px;padding:7px 14px;border:1.5px solid #ee4d2d;border-radius:6px;background:#fff;color:#ee4d2d;font-size:12px;font-weight:700;cursor:pointer;">↓ Simpan</button>
                <button onclick="cetakStruk()" style="display:flex;align-items:center;gap:5px;padding:7px 14px;border:none;border-radius:6px;background:#ee4d2d;color:#fff;font-size:12px;font-weight:700;cursor:pointer;">🖨 Cetak</button>
                <button onclick="tutupModal('modalStruk')" style="padding:7px 11px;border:1.5px solid #ddd;border-radius:6px;background:#fff;color:#666;font-size:13px;cursor:pointer;">✕</button>
            </div>
        </div>

        <div id="isiStruk" style="background:#fff;margin:12px;border-radius:4px;font-family:'Courier New',monospace;font-size:12px;color:#111;padding:20px;">

            <div style="text-align:center;margin-bottom:12px;padding-bottom:12px;border-bottom:1px dashed #aaa;">
                <div style="font-size:18px;font-weight:900;letter-spacing:1px;color:#ee4d2d;">UMKM PADANG</div>
                <div style="font-size:10px;color:#555;margin-top:2px;">Platform UMKM Digital Kota Padang</div>
            </div>

            <div style="text-align:center;margin-bottom:12px;padding-bottom:12px;border-bottom:1px dashed #aaa;">
                <div style="font-size:10px;color:#777;margin-bottom:4px;">NO. PESANAN</div>
                <div style="font-size:15px;font-weight:900;letter-spacing:2px;">{{ $order->order_number }}</div>
                <div style="font-size:10px;color:#777;margin-top:4px;">{{ $order->created_at->format('d M Y, H:i') }} WIB</div>
                <div id="qrcode" style="display:inline-block;margin-top:10px;padding:6px;background:#fff;border:1px solid #ddd;border-radius:4px;"></div>
            </div>

            <div style="margin-bottom:10px;padding-bottom:10px;border-bottom:1px dashed #aaa;">
                <div style="font-size:10px;font-weight:700;color:#777;text-transform:uppercase;margin-bottom:6px;">PENGIRIM</div>
                <div style="font-weight:700;font-size:13px;">{{ $order->umkm->name ?? '-' }}</div>
                <div style="color:#444;font-size:11px;margin-top:2px;">{{ $order->umkm->address ?? $order->umkm->kecamatan ?? '-' }}</div>
                @if($order->umkm->whatsapp ?? false)
                <div style="color:#444;font-size:11px;">WA: {{ $order->umkm->whatsapp }}</div>
                @endif
            </div>

            <div style="margin-bottom:10px;padding-bottom:10px;border-bottom:1px dashed #aaa;">
                <div style="font-size:10px;font-weight:700;color:#777;text-transform:uppercase;margin-bottom:6px;">PENERIMA</div>
                <div style="font-weight:700;font-size:13px;">{{ $order->customer->name ?? '-' }}</div>
                @if($order->customer->phone ?? false)
                <div style="color:#444;font-size:11px;">{{ $order->customer->phone }}</div>
                @endif
                <div style="color:#444;font-size:11px;margin-top:2px;line-height:1.5;">{{ $order->shipping_address ?? '-' }}</div>
            </div>

            <div style="margin-bottom:10px;padding-bottom:10px;border-bottom:1px dashed #aaa;">
                <div style="font-size:10px;font-weight:700;color:#777;text-transform:uppercase;margin-bottom:8px;">DETAIL PRODUK</div>
                @foreach($order->items as $item)
                <div style="margin-bottom:8px;">
                    <div style="font-size:12px;font-weight:600;line-height:1.4;">{{ $item->product->name ?? 'Produk dihapus' }}</div>
                    <div style="display:flex;justify-content:space-between;margin-top:2px;">
                        <span style="font-size:11px;color:#555;">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        <span style="font-size:12px;font-weight:700;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            <div style="margin-bottom:12px;padding-bottom:12px;border-bottom:2px solid #111;">
                @if(isset($order->shipping_cost) && $order->shipping_cost > 0)
                <div style="display:flex;justify-content:space-between;font-size:11px;color:#555;margin-bottom:4px;">
                    <span>Ongkos Kirim</span>
                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                @endif
                <div style="display:flex;justify-content:space-between;font-size:14px;font-weight:900;margin-top:6px;">
                    <span>TOTAL</span>
                    <span>Rp {{ number_format($order->grand_total ?? $order->total_price ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <div style="text-align:center;margin-bottom:12px;">
                <span style="font-size:11px;font-weight:700;padding:4px 14px;border-radius:3px;
                    {{ in_array($order->status, ['shipped','delivered']) ? 'background:#ee4d2d;color:#fff;' : 'background:#f5f5f5;color:#555;border:1px solid #ddd;' }}">
                    @switch($order->status)
                        @case('pending') ⏳ Menunggu Konfirmasi @break
                        @case('confirmed') ✔ Dikonfirmasi @break
                        @case('processing') 🔄 Sedang Diproses @break
                        @case('shipped') 🚚 Dalam Pengiriman @break
                        @case('delivered') ✅ Pesanan Selesai @break
                        @case('cancelled') ❌ Dibatalkan @break
                        @default {{ ucfirst($order->status) }}
                    @endswitch
                </span>
            </div>

            <div style="text-align:center;font-size:10px;color:#999;line-height:1.8;">
                <div>Dicetak: {{ now()->format('d M Y, H:i') }} WIB</div>
                <div style="margin-top:4px;font-weight:700;color:#ee4d2d;">Terima kasih telah berbelanja!</div>
                <div>umkmpadang.id</div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI --}}
<div id="modalKonfirmasi" style="display:none;position:fixed;inset:0;z-index:1000;align-items:center;justify-content:center;">
    <div style="position:absolute;inset:0;background:rgba(15,23,42,0.5);backdrop-filter:blur(3px);" onclick="tutupModal('modalKonfirmasi')"></div>
    <div style="position:relative;background:#fff;border-radius:16px;padding:32px;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.15);text-align:center;">
        <div style="width:56px;height:56px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h3 style="font-size:18px;font-weight:700;color:#0f172a;margin:0 0 8px">Konfirmasi Pesanan?</h3>
        <p style="font-size:14px;color:#64748b;margin:0 0 24px;line-height:1.6">Pesanan <strong>#{{ $order->order_number }}</strong> akan dikonfirmasi dan siap diproses.</p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="tutupModal('modalKonfirmasi')" style="padding:10px 24px;border:1.5px solid #e2e8f0;border-radius:8px;background:#fff;color:#475569;font-weight:600;font-size:14px;cursor:pointer;">Batal</button>
            <button onclick="document.getElementById('formKonfirmasi').submit()" style="padding:10px 24px;border:none;border-radius:8px;background:#22c55e;color:#fff;font-weight:600;font-size:14px;cursor:pointer;">Ya, Konfirmasi</button>
        </div>
    </div>
</div>

{{-- MODAL KIRIM --}}
<div id="modalKirim" style="display:none;position:fixed;inset:0;z-index:1000;align-items:center;justify-content:center;">
    <div style="position:absolute;inset:0;background:rgba(15,23,42,0.5);backdrop-filter:blur(3px);" onclick="tutupModal('modalKirim')"></div>
    <div style="position:relative;background:#fff;border-radius:16px;padding:32px;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.15);text-align:center;">
        <div style="width:56px;height:56px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        </div>
        <h3 style="font-size:18px;font-weight:700;color:#0f172a;margin:0 0 8px">Tandai Sebagai Dikirim?</h3>
        <p style="font-size:14px;color:#64748b;margin:0 0 24px;line-height:1.6">Pesanan <strong>#{{ $order->order_number }}</strong> akan ditandai sudah dikirim ke pelanggan.</p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="tutupModal('modalKirim')" style="padding:10px 24px;border:1.5px solid #e2e8f0;border-radius:8px;background:#fff;color:#475569;font-weight:600;font-size:14px;cursor:pointer;">Batal</button>
            <button onclick="document.getElementById('formKirim').submit()" style="padding:10px 24px;border:none;border-radius:8px;background:#3b82f6;color:#fff;font-weight:600;font-size:14px;cursor:pointer;">Ya, Kirim</button>
        </div>
    </div>
</div>

<div class="order-detail-page">

    {{-- Header --}}
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('umkm.pesanan.index') }}" class="back-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Kembali
            </a>
            <div>
                <h1 class="page-title">Pesanan <span class="order-id">#{{ $order->order_number }}</span></h1>
                <p class="page-subtitle">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>
        <div class="header-right" style="display:flex;gap:10px;align-items:center;">
            <button onclick="bukaStruk()" style="display:flex;align-items:center;gap:7px;padding:9px 18px;border:none;border-radius:10px;background:#ee4d2d;color:#fff;font-size:13px;font-weight:600;cursor:pointer;box-shadow:0 4px 12px rgba(238,77,45,0.35);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Struk Resi
            </button>
            @php
                $statusMap = [
                    'pending'    => ['label'=>'⏳ Menunggu',      'bg'=>'#fef9c3','color'=>'#854d0e'],
                    'confirmed'  => ['label'=>'✔️ Dikonfirmasi',  'bg'=>'#dcfce7','color'=>'#15803d'],
                    'processing' => ['label'=>'🔄 Diproses',      'bg'=>'#dbeafe','color'=>'#1d4ed8'],
                    'shipped'    => ['label'=>'🚚 Dikirim',       'bg'=>'#e0f2fe','color'=>'#0369a1'],
                    'delivered'  => ['label'=>'✅ Selesai',       'bg'=>'#dcfce7','color'=>'#15803d'],
                    'cancelled'  => ['label'=>'❌ Dibatalkan',    'bg'=>'#fee2e2','color'=>'#b91c1c'],
                ];
                $st = $statusMap[$order->status] ?? ['label'=>ucfirst($order->status),'bg'=>'#f1f5f9','color'=>'#475569'];
            @endphp
            <span style="padding:7px 16px;border-radius:999px;font-size:13px;font-weight:600;background:{{ $st['bg'] }};color:{{ $st['color'] }};">
                {{ $st['label'] }}
            </span>
        </div>
    </div>

    <div class="order-grid">

        {{-- Informasi Pembeli --}}
        <div class="card">
            <div class="card-header">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <h2>Informasi Pembeli</h2>
            </div>
            <div class="card-body">
                <div class="info-row"><span class="info-label">Nama</span><span class="info-value">{{ $order->customer->name ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">Email</span><span class="info-value">{{ $order->customer->email ?? '-' }}</span></div>
                <div class="info-row"><span class="info-label">No. Telepon</span><span class="info-value">{{ $order->customer->phone ?? '-' }}</span></div>
            </div>
        </div>

        {{-- Alamat Pengiriman --}}
        <div class="card">
            <div class="card-header">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <h2>Alamat Pengiriman</h2>
            </div>
            <div class="card-body">
                <p class="address-text">{{ $order->shipping_address ?? 'Alamat tidak tersedia' }}</p>
                @if($order->notes)
                <div class="info-row" style="margin-top:12px;">
                    <span class="info-label">Catatan</span>
                    <span class="info-value">{{ $order->notes }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Item Pesanan --}}
        <div class="card card-full">
            <div class="card-header">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
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
                                        <img src="{{ asset('storage/'.$item->product->image) }}" class="product-thumb">
                                        @else
                                        <div class="product-thumb-placeholder">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
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
                                <td class="text-center"><span class="qty-badge">{{ $item->quantity }}</span></td>
                                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-right font-semibold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="empty-items">Tidak ada item.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
                    <div class="price-row total">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->grand_total ?? $order->total_price ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aksi Pesanan --}}
        @if(!in_array($order->status, ['shipped','delivered','cancelled']))
        <div class="card card-full">
            <div class="card-header">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                <h2>Aksi Pesanan</h2>
            </div>
            <div class="card-body">
                <div class="action-buttons">
                    @if($order->status === 'pending')
                    <form id="formKonfirmasi" action="{{ route('umkm.pesanan.konfirmasi', $order->id) }}" method="POST" style="display:none">@csrf @method('PATCH')</form>
                    <button type="button" onclick="bukaModal('modalKonfirmasi')" class="btn-action btn-confirm">✔ Konfirmasi Pesanan</button>
                    @endif
                    @if(in_array($order->status, ['pending','confirmed','processing']))
                    <form id="formKirim" action="{{ route('umkm.pesanan.kirim', $order->id) }}" method="POST" style="display:none">@csrf @method('PATCH')</form>
                    <button type="button" onclick="bukaModal('modalKirim')" class="btn-action btn-ship">🚚 Tandai Dikirim</button>
                    @endif
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

<style>
.order-detail-page{padding:24px;font-family:'Segoe UI',system-ui,sans-serif;}
.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:16px;}
.header-left{display:flex;align-items:center;gap:16px;}
.back-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:8px;background:#f1f5f9;color:#475569;text-decoration:none;font-size:14px;font-weight:500;transition:background .2s;white-space:nowrap;}
.back-btn:hover{background:#e2e8f0;color:#1e293b;}
.page-title{font-size:22px;font-weight:700;color:#0f172a;margin:0;}
.order-id{color:#3b82f6;}
.page-subtitle{font-size:13px;color:#94a3b8;margin:2px 0 0;}
.order-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;}
.card-full{grid-column:1/-1;}
.card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.04);}
.card-header{display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #f1f5f9;background:#f8fafc;}
.card-header h2{font-size:15px;font-weight:600;color:#1e293b;margin:0;}
.card-body{padding:20px;}
.no-padding{padding:0;}
.info-row{display:flex;justify-content:space-between;align-items:flex-start;padding:8px 0;border-bottom:1px solid #f8fafc;gap:16px;}
.info-row:last-child{border-bottom:none;}
.info-label{font-size:13px;color:#94a3b8;font-weight:500;flex-shrink:0;}
.info-value{font-size:14px;color:#1e293b;font-weight:500;text-align:right;}
.address-text{font-size:14px;color:#334155;line-height:1.6;margin:0;}
.items-table-wrapper{overflow-x:auto;}
.items-table{width:100%;border-collapse:collapse;font-size:14px;}
.items-table thead tr{background:#f8fafc;}
.items-table th{padding:12px 20px;text-align:left;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;white-space:nowrap;}
.items-table td{padding:14px 20px;border-top:1px solid #f1f5f9;color:#334155;vertical-align:middle;}
.text-center{text-align:center;}.text-right{text-align:right;}.font-semibold{font-weight:600;color:#0f172a;}
.product-info{display:flex;align-items:center;gap:12px;}
.product-thumb{width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;flex-shrink:0;}
.product-thumb-placeholder{width:48px;height:48px;border-radius:8px;background:#f1f5f9;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;color:#94a3b8;flex-shrink:0;}
.product-name{font-size:14px;font-weight:600;color:#1e293b;margin:0;}
.product-sku{font-size:12px;color:#94a3b8;margin:2px 0 0;}
.qty-badge{display:inline-block;padding:2px 10px;background:#f1f5f9;border-radius:999px;font-size:13px;font-weight:600;color:#475569;}
.empty-items{text-align:center;color:#94a3b8;padding:32px!important;font-style:italic;}
.price-summary{border-top:2px solid #f1f5f9;padding:16px 20px;display:flex;flex-direction:column;align-items:flex-end;gap:8px;}
.price-row{display:flex;gap:48px;font-size:14px;color:#475569;}
.price-row span:last-child{min-width:140px;text-align:right;}
.price-row.total{font-size:16px;font-weight:700;color:#0f172a;border-top:1px solid #e2e8f0;padding-top:10px;margin-top:4px;}
.action-buttons{display:flex;gap:12px;flex-wrap:wrap;}
.btn-action{padding:11px 24px;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;transition:all .2s;}
.btn-action:active{transform:scale(.97);}
.btn-confirm{background:#22c55e;color:#fff;box-shadow:0 4px 12px rgba(34,197,94,.3);}
.btn-confirm:hover{background:#16a34a;}
.btn-ship{background:#3b82f6;color:#fff;box-shadow:0 4px 12px rgba(59,130,246,.3);}
.btn-ship:hover{background:#2563eb;}
@media(max-width:768px){.order-grid{grid-template-columns:1fr;}.card-full{grid-column:1;}.page-header{flex-direction:column;align-items:flex-start;}}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function bukaModal(id){const m=document.getElementById(id);m.style.display='flex';document.body.style.overflow='hidden';}
function tutupModal(id){const m=document.getElementById(id);m.style.display='none';document.body.style.overflow='';}
document.addEventListener('keydown',e=>{if(e.key==='Escape')['modalKonfirmasi','modalKirim','modalStruk'].forEach(tutupModal);});

let qrGenerated = false;
function bukaStruk() {
    bukaModal('modalStruk');
    if (!qrGenerated) {
        document.getElementById('qrcode').innerHTML = '';
        new QRCode(document.getElementById('qrcode'), {
            text: '{{ $order->order_number }}',
            width: 100, height: 100,
            colorDark: '#111111',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });
        qrGenerated = true;
    }
}

function cetakStruk() {
    const konten = document.getElementById('isiStruk').innerHTML;
    const win = window.open('', '_blank', 'width=400,height=700');
    win.document.write(`
        <html><head><title>Struk - {{ $order->order_number }}</title>
        <style>
            *{margin:0;padding:0;box-sizing:border-box;}
            body{font-family:'Courier New',monospace;width:80mm;margin:0 auto;background:#fff;font-size:12px;color:#111;}
            @page{size:80mm auto;margin:4mm;}
            @media print{body{width:80mm;}}
            div,table,p,span{max-width:100%!important;word-break:break-word;}
            img{max-width:100%!important;}
        </style></head>
        <body>${konten}</body></html>
    `);
    win.document.close();
    win.focus();
    setTimeout(()=>win.print(), 600);
}

function downloadStruk() {
    html2canvas(document.getElementById('isiStruk'),{
        scale:2, backgroundColor:'#ffffff', useCORS:true, width:320
    }).then(canvas=>{
        const link=document.createElement('a');
        link.download='struk-{{ $order->order_number }}.png';
        link.href=canvas.toDataURL('image/png');
        link.click();
    });
}
</script>

@endsection