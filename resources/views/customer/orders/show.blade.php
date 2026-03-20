@extends('layouts.dashboard')
@section('title', 'Detail Pesanan')
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
<style>@keyframes slideIn { from { opacity:0; transform:translateX(40px); } to { opacity:1; transform:translateX(0); } }</style>
<script>setTimeout(() => { const t = document.getElementById('toast'); if(t) t.style.display='none'; }, 3500);</script>
@endif

@if(session('error'))
<div id="toast-err" style="
    position:fixed; top:24px; right:24px; z-index:9999;
    background:#ef4444; color:#fff;
    padding:14px 20px; border-radius:12px;
    font-size:14px; font-weight:600;
    box-shadow:0 8px 24px rgba(239,68,68,0.35);
    display:flex; align-items:center; gap:10px;
">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    {{ session('error') }}
</div>
<script>setTimeout(() => { const t = document.getElementById('toast-err'); if(t) t.style.display='none'; }, 3500);</script>
@endif

{{-- MODAL BATAL --}}
<div id="modalBatal" style="display:none; position:fixed; inset:0; z-index:1000; align-items:center; justify-content:center;">
    <div style="position:absolute; inset:0; background:rgba(15,23,42,0.5); backdrop-filter:blur(3px);" onclick="tutupModal('modalBatal')"></div>
    <div style="position:relative; background:#fff; border-radius:16px; padding:32px; max-width:420px; width:90%; box-shadow:0 24px 60px rgba(0,0,0,0.15); text-align:center;">
        <div style="width:56px;height:56px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </div>
        <h3 style="font-size:18px;font-weight:700;color:#0f172a;margin:0 0 8px">Batalkan Pesanan?</h3>
        <p style="font-size:14px;color:#64748b;margin:0 0 24px;line-height:1.6">Pesanan <strong>#{{ $order->order_number }}</strong> akan dibatalkan. Tindakan ini tidak bisa diurungkan.</p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="tutupModal('modalBatal')" style="padding:10px 24px;border:1.5px solid #e2e8f0;border-radius:8px;background:#fff;color:#475569;font-weight:600;font-size:14px;cursor:pointer;">Tidak</button>
            <button onclick="document.getElementById('formBatal').submit()" style="padding:10px 24px;border:none;border-radius:8px;background:#ef4444;color:#fff;font-weight:600;font-size:14px;cursor:pointer;">Ya, Batalkan</button>
        </div>
    </div>
</div>

{{-- MODAL TERIMA --}}
<div id="modalTerima" style="display:none; position:fixed; inset:0; z-index:1000; align-items:center; justify-content:center;">
    <div style="position:absolute; inset:0; background:rgba(15,23,42,0.5); backdrop-filter:blur(3px);" onclick="tutupModal('modalTerima')"></div>
    <div style="position:relative; background:#fff; border-radius:16px; padding:32px; max-width:420px; width:90%; box-shadow:0 24px 60px rgba(0,0,0,0.15); text-align:center;">
        <div style="width:56px;height:56px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h3 style="font-size:18px;font-weight:700;color:#0f172a;margin:0 0 8px">Konfirmasi Penerimaan?</h3>
        <p style="font-size:14px;color:#64748b;margin:0 0 24px;line-height:1.6">
            Apakah Anda sudah menerima pesanan <strong>#{{ $order->order_number }}</strong>?<br>
            Pesanan akan ditandai sebagai <strong style="color:#16a34a;">Selesai</strong>.
        </p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="tutupModal('modalTerima')" style="padding:10px 24px;border:1.5px solid #e2e8f0;border-radius:8px;background:#fff;color:#475569;font-weight:600;font-size:14px;cursor:pointer;">Belum</button>
            <button onclick="document.getElementById('formTerima').submit()" style="padding:10px 24px;border:none;border-radius:8px;background:#16a34a;color:#fff;font-weight:600;font-size:14px;cursor:pointer;">
                Ya, Sudah Diterima
            </button>
        </div>
    </div>
</div>

<div style="padding:24px; font-family:'Segoe UI',system-ui,sans-serif;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:16px;">
        <div style="display:flex;align-items:center;gap:16px;">
            <a href="{{ route('customer.pesanan.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:8px;background:#f1f5f9;color:#475569;text-decoration:none;font-size:14px;font-weight:500;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Kembali
            </a>
            <div>
                <h1 style="font-size:20px;font-weight:700;color:#0f172a;margin:0;">Pesanan <span style="color:#3b82f6;">#{{ $order->order_number }}</span></h1>
                <p style="font-size:13px;color:#94a3b8;margin:2px 0 0;">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>
        @php
            $statusMap = [
                'pending'    => ['label' => '&#9203; Menunggu Konfirmasi', 'bg' => '#fef9c3', 'color' => '#854d0e'],
                'confirmed'  => ['label' => '&#10003; Dikonfirmasi',        'bg' => '#dcfce7', 'color' => '#15803d'],
                'processing' => ['label' => '&#128260; Diproses',           'bg' => '#dbeafe', 'color' => '#1d4ed8'],
                'shipped'    => ['label' => '&#128666; Dikirim',            'bg' => '#e0f2fe', 'color' => '#0369a1'],
                'delivered'  => ['label' => '&#10004; Selesai',             'bg' => '#dcfce7', 'color' => '#15803d'],
                'cancelled'  => ['label' => '&#10060; Dibatalkan',          'bg' => '#fee2e2', 'color' => '#b91c1c'],
            ];
            $st = $statusMap[$order->status] ?? ['label' => ucfirst($order->status), 'bg' => '#f1f5f9', 'color' => '#475569'];
        @endphp
        <span style="padding:7px 16px;border-radius:999px;font-size:13px;font-weight:600;background:{{ $st['bg'] }};color:{{ $st['color'] }};">
            {!! $st['label'] !!}
        </span>
    </div>

    {{-- Progress Tracker --}}
    @php
        $steps = ['pending','confirmed','processing','shipped','delivered'];
        $currentIdx = array_search($order->status, $steps);
        if ($order->status === 'cancelled') $currentIdx = -1;
    @endphp
    @if($order->status !== 'cancelled')
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px 28px;margin-bottom:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;position:relative;">
            {{-- Line --}}
            <div style="position:absolute;top:18px;left:10%;right:10%;height:2px;background:#e2e8f0;z-index:0;"></div>
            <div style="position:absolute;top:18px;left:10%;height:2px;background:#16a34a;z-index:1;width:{{ $currentIdx >= 0 ? ($currentIdx / (count($steps)-1)) * 80 : 0 }}%;transition:width .3s;"></div>

            @php
                $stepLabels = ['Dipesan','Dikonfirmasi','Diproses','Dikirim','Selesai'];
                $stepIcons  = ['&#128722;','&#10003;','&#9881;','&#128666;','&#127873;'];
            @endphp
            @foreach($steps as $i => $step)
            <div style="display:flex;flex-direction:column;align-items:center;gap:8px;position:relative;z-index:2;flex:1;">
                <div style="
                    width:36px;height:36px;border-radius:50%;
                    display:flex;align-items:center;justify-content:center;
                    font-size:14px;font-weight:700;
                    background:{{ $i <= $currentIdx ? '#16a34a' : '#f1f5f9' }};
                    color:{{ $i <= $currentIdx ? '#fff' : '#94a3b8' }};
                    border:2px solid {{ $i <= $currentIdx ? '#16a34a' : '#e2e8f0' }};
                    box-shadow:{{ $i === $currentIdx ? '0 0 0 4px rgba(22,163,74,.15)' : 'none' }};
                    transition:all .3s;
                ">{!! $stepIcons[$i] !!}</div>
                <span style="font-size:11px;font-weight:{{ $i === $currentIdx ? '700' : '500' }};color:{{ $i <= $currentIdx ? '#16a34a' : '#94a3b8' }};white-space:nowrap;">
                    {{ $stepLabels[$i] }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;">

        {{-- Info Toko --}}
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
            <div style="display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #f1f5f9;background:#f8fafc;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <h2 style="font-size:15px;font-weight:600;color:#1e293b;margin:0;">Informasi Toko</h2>
            </div>
            <div style="padding:20px;">
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f8fafc;">
                    <span style="font-size:13px;color:#94a3b8;font-weight:500;">Nama Toko</span>
                    <span style="font-size:14px;color:#1e293b;font-weight:600;">{{ $order->umkm->name ?? '-' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f8fafc;">
                    <span style="font-size:13px;color:#94a3b8;font-weight:500;">WhatsApp</span>
                    <span style="font-size:14px;color:#1e293b;font-weight:500;">{{ $order->umkm->whatsapp ?? '-' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;">
                    <span style="font-size:13px;color:#94a3b8;font-weight:500;">Kecamatan</span>
                    <span style="font-size:14px;color:#1e293b;font-weight:500;">{{ $order->umkm->kecamatan ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Alamat Pengiriman --}}
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
            <div style="display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #f1f5f9;background:#f8fafc;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <h2 style="font-size:15px;font-weight:600;color:#1e293b;margin:0;">Alamat Pengiriman</h2>
            </div>
            <div style="padding:20px;">
                <p style="font-size:14px;color:#334155;line-height:1.6;margin:0;">{{ $order->shipping_address ?? 'Alamat tidak tersedia' }}</p>
                @if($order->notes)
                <div style="margin-top:12px;padding:10px 14px;background:#f8fafc;border-radius:8px;font-size:13px;color:#475569;">
                    <strong>Catatan:</strong> {{ $order->notes }}
                </div>
                @endif
            </div>
        </div>

        {{-- Item Pesanan --}}
        <div style="grid-column:1/-1;background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
            <div style="display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #f1f5f9;background:#f8fafc;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <h2 style="font-size:15px;font-weight:600;color:#1e293b;margin:0;">Item Pesanan</h2>
            </div>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:14px;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th style="padding:12px 20px;text-align:left;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;">Produk</th>
                            <th style="padding:12px 20px;text-align:center;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;">Qty</th>
                            <th style="padding:12px 20px;text-align:right;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;">Harga Satuan</th>
                            <th style="padding:12px 20px;text-align:right;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                        <tr style="border-top:1px solid #f1f5f9;">
                            <td style="padding:14px 20px;vertical-align:middle;">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/'.$item->product->image) }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;">
                                    @else
                                    <div style="width:48px;height:48px;border-radius:8px;background:#f1f5f9;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;color:#94a3b8;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                    @endif
                                    <div>
                                        <p style="font-size:14px;font-weight:600;color:#1e293b;margin:0;">{{ $item->product->name ?? 'Produk dihapus' }}</p>
                                        @if($item->product && $item->product->unit)
                                        <p style="font-size:12px;color:#94a3b8;margin:2px 0 0;">per {{ $item->product->unit }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                                <span style="display:inline-block;padding:2px 10px;background:#f1f5f9;border-radius:999px;font-size:13px;font-weight:600;color:#475569;">{{ $item->quantity }}</span>
                            </td>
                            <td style="padding:14px 20px;text-align:right;vertical-align:middle;color:#334155;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="padding:14px 20px;text-align:right;vertical-align:middle;font-weight:600;color:#0f172a;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center;padding:32px;color:#94a3b8;font-style:italic;">Tidak ada item.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Ringkasan Harga --}}
            <div style="border-top:2px solid #f1f5f9;padding:16px 20px;display:flex;flex-direction:column;align-items:flex-end;gap:8px;">
                <div style="display:flex;gap:48px;font-size:14px;color:#475569;">
                    <span>Subtotal</span>
                    <span style="min-width:140px;text-align:right;">Rp {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
                </div>
                @if(isset($order->shipping_cost) && $order->shipping_cost > 0)
                <div style="display:flex;gap:48px;font-size:14px;color:#475569;">
                    <span>Ongkos Kirim</span>
                    <span style="min-width:140px;text-align:right;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                @endif
                <div style="display:flex;gap:48px;font-size:16px;font-weight:700;color:#0f172a;border-top:1px solid #e2e8f0;padding-top:10px;margin-top:4px;">
                    <span>Total</span>
                    <span style="min-width:140px;text-align:right;">Rp {{ number_format($order->grand_total ?? $order->total_price ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- AKSI: Konfirmasi Terima (status = shipped) --}}
        @if($order->status === 'shipped')
        <div style="grid-column:1/-1;background:#fff;border:2px solid #16a34a;border-radius:12px;overflow:hidden;">
            <div style="display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #dcfce7;background:#f0fdf4;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <h2 style="font-size:15px;font-weight:600;color:#15803d;margin:0;">Konfirmasi Penerimaan</h2>
            </div>
            <div style="padding:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                <div>
                    <p style="font-size:14px;font-weight:600;color:#15803d;margin:0 0 4px;">Pesanan Anda sedang dalam perjalanan!</p>
                    <p style="font-size:13px;color:#6b7280;margin:0;">Klik tombol di bawah jika pesanan sudah Anda terima dengan baik.</p>
                </div>
                <div style="display:flex;gap:10px;align-items:center;">
                    <form id="formTerima" action="{{ route('customer.pesanan.terima', $order->id) }}" method="POST" style="display:none;">
                        @csrf @method('PATCH')
                    </form>
                    <button type="button" onclick="bukaModal('modalTerima')"
                        style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border:none;border-radius:10px;background:#16a34a;color:#fff;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(22,163,74,.35);transition:all .2s;"
                        onmouseover="this.style.background='#15803d'"
                        onmouseout="this.style.background='#16a34a'">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Konfirmasi Pesanan Diterima
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- AKSI: Batalkan (status = pending) --}}
        @if($order->status === 'pending')
        <div style="grid-column:1/-1;background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
            <div style="display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #f1f5f9;background:#f8fafc;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <h2 style="font-size:15px;font-weight:600;color:#1e293b;margin:0;">Aksi</h2>
            </div>
            <div style="padding:20px;">
                <form id="formBatal" action="{{ route('customer.pesanan.batal', $order->id) }}" method="POST" style="display:none;">
                    @csrf @method('PATCH')
                </form>
                <button type="button" onclick="bukaModal('modalBatal')"
                    style="display:inline-flex;align-items:center;gap:8px;padding:11px 24px;border:none;border-radius:10px;background:#ef4444;color:#fff;font-size:14px;font-weight:600;cursor:pointer;box-shadow:0 4px 12px rgba(239,68,68,.3);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Batalkan Pesanan
                </button>
                <p style="font-size:12px;color:#94a3b8;margin:10px 0 0;">Pesanan hanya bisa dibatalkan selama masih menunggu konfirmasi.</p>
            </div>
        </div>
        @endif

        {{-- Status Selesai --}}
        @if($order->status === 'delivered')
        <div style="grid-column:1/-1;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:20px;display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div>
                <p style="font-size:15px;font-weight:700;color:#15803d;margin:0 0 4px;">Pesanan Selesai!</p>
                <p style="font-size:13px;color:#6b7280;margin:0;">Pesanan telah dikonfirmasi diterima. Terima kasih telah berbelanja!</p>
            </div>
        </div>
        @endif

    </div>
</div>

<script>
function bukaModal(id) {
    const m = document.getElementById(id);
    m.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function tutupModal(id) {
    const m = document.getElementById(id);
    m.style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        tutupModal('modalBatal');
        tutupModal('modalTerima');
    }
});
</script>

@endsection