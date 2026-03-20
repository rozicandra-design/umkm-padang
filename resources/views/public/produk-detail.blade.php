@extends('public.layouts.app')
@section('title', $product->name)

@section('content')

<div style="max-width:1100px;margin:0 auto;padding:32px 16px;">

    {{-- Breadcrumb --}}
    <div style="font-size:13px;color:#6b7280;margin-bottom:24px;">
        <a href="{{ route('home') }}" style="color:#16a34a;text-decoration:none;">Beranda</a> /
        <a href="{{ route('katalog') }}" style="color:#16a34a;text-decoration:none;">Katalog</a> /
        <span>{{ $product->name }}</span>
    </div>

    {{-- Main --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;margin-bottom:48px;">

        {{-- Gambar --}}
        <div>
            @php $images = $product->images; @endphp
            <div style="border-radius:16px;overflow:hidden;border:1px solid #e5e7eb;margin-bottom:12px;background:#f9fafb;">
                <img id="main-img"
                     src="{{ $images->first() ? Storage::url($images->first()->image_path) : asset('images/placeholder.png') }}"
                     alt="{{ $product->name }}"
                     style="width:100%;height:400px;object-fit:cover;">
            </div>
            @if($images->count() > 1)
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                @foreach($images as $img)
                <img src="{{ Storage::url($img->image_path) }}"
                     onclick="document.getElementById('main-img').src=this.src"
                     style="width:72px;height:72px;object-fit:cover;border-radius:8px;border:2px solid #e5e7eb;cursor:pointer;">
                @endforeach
            </div>
            @endif
        </div>

        {{-- Detail --}}
        <div>
            <span style="font-size:12px;background:#dcfce7;color:#16a34a;font-weight:700;padding:3px 10px;border-radius:99px;">
                {{ $product->category->name ?? '-' }}
            </span>

            <h1 style="font-size:26px;font-weight:800;color:#111827;margin:12px 0 8px;">{{ $product->name }}</h1>

            <div style="font-size:28px;font-weight:800;color:#16a34a;margin-bottom:16px;">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            @if($product->reviews->count() > 0)
            @php $avg = $product->reviews->avg('rating'); @endphp
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                <span style="color:#f59e0b;">
                    @for($i=1;$i<=5;$i++){{ $i <= round($avg) ? '★' : '☆' }}@endfor
                </span>
                <span style="font-size:13px;color:#6b7280;">{{ number_format($avg,1) }} ({{ $product->reviews->count() }} ulasan)</span>
            </div>
            @endif

            <p style="font-size:14px;color:#374151;line-height:1.7;margin-bottom:20px;">{{ $product->description }}</p>

            <div style="background:#f9fafb;border-radius:12px;padding:16px;margin-bottom:20px;font-size:13.5px;">
                <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #e5e7eb;">
                    <span style="color:#6b7280;">Stok</span>
                    <strong>{{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #e5e7eb;">
                    <span style="color:#6b7280;">Terjual</span>
                    <strong>{{ $product->sold_count ?? 0 }}x</strong>
                </div>
                <div style="display:flex;justify-content:space-between;padding:7px 0;">
                    <span style="color:#6b7280;">Dilihat</span>
                    <strong>{{ $product->view_count }}x</strong>
                </div>
            </div>

            @if($product->stock > 0)
                @auth
                @php
                    $addresses = auth()->user()->addresses()->orderByDesc('is_default')->get();
                    $isWishlisted = \App\Models\Wishlist::where('customer_id', auth()->id())
                        ->where('product_id', $product->id)->exists();
                @endphp
                <form action="{{ route('customer.pesanan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    {{-- Pilih Alamat --}}
                    <div style="margin-bottom:14px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                            <label style="font-size:13px;font-weight:600;color:#374151;">Alamat Pengiriman:</label>
                            <a href="{{ route('customer.address.index') }}" target="_blank"
                               style="font-size:12px;color:#16a34a;font-weight:600;text-decoration:none;">+ Tambah Alamat</a>
                        </div>

                        @if($addresses->count() > 0)
                        {{-- Pilihan Alamat Tersimpan --}}
                        <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:10px;" id="addr-list">
                            @foreach($addresses as $addr)
                            <label style="display:flex;align-items:flex-start;gap:10px;background:#f9fafb;border:1.5px solid #e5e7eb;border-radius:10px;padding:10px 12px;cursor:pointer;transition:border-color 0.15s;"
                                   id="addr-label-{{ $addr->id }}"
                                   onclick="selectAddress({{ $addr->id }}, `{{ addslashes($addr->address) }}{{ $addr->city ? ', '.$addr->city : '' }}{{ $addr->province ? ', '.$addr->province : '' }}`)">
                                <input type="radio" name="selected_address_id" value="{{ $addr->id }}"
                                       {{ $addr->is_default ? 'checked' : '' }}
                                       style="margin-top:2px;accent-color:#16a34a;"
                                       onchange="selectAddress({{ $addr->id }}, `{{ addslashes($addr->address) }}{{ $addr->city ? ', '.$addr->city : '' }}{{ $addr->province ? ', '.$addr->province : '' }}`)">
                                <div>
                                    <div style="font-size:13px;font-weight:700;color:#111;">
                                        {{ $addr->label }}
                                        @if($addr->is_default)
                                            <span style="font-size:10px;background:#16a34a;color:#fff;padding:1px 6px;border-radius:99px;margin-left:4px;">Utama</span>
                                        @endif
                                    </div>
                                    <div style="font-size:12px;color:#6b7280;margin-top:2px;">{{ $addr->address }}{{ $addr->city ? ', '.$addr->city : '' }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>

                        {{-- Toggle input manual --}}
                        <button type="button" onclick="toggleManual()"
                                style="font-size:12px;color:#6b7280;background:none;border:none;cursor:pointer;padding:0;text-decoration:underline;margin-bottom:8px;">
                            ✏️ Tulis alamat lain
                        </button>

                        <textarea name="shipping_address" id="manual-addr" rows="2" placeholder="Tulis alamat manual..."
                                  style="width:100%;padding:8px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;box-sizing:border-box;display:none;resize:vertical;"></textarea>

                        @else
                        {{-- Belum ada alamat tersimpan --}}
                        <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:10px 12px;font-size:13px;color:#92400e;margin-bottom:8px;">
                            Belum ada alamat tersimpan.
                            <a href="{{ route('customer.address.index') }}" target="_blank" style="color:#16a34a;font-weight:700;">Tambah sekarang →</a>
                        </div>
                        <textarea name="shipping_address" rows="3" required
                                  placeholder="Tulis alamat pengiriman lengkap..."
                                  style="width:100%;padding:8px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:13px;box-sizing:border-box;resize:vertical;"></textarea>
                        @endif
                    </div>

                    <div style="margin-bottom:14px;">
                        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:6px;">Catatan (opsional):</label>
                        <textarea name="notes" rows="2"
                                  style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;"></textarea>
                    </div>

                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                        <label style="font-size:13px;font-weight:600;color:#374151;">Jumlah:</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                               style="width:80px;padding:8px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;text-align:center;">
                    </div>

                    <div style="display:flex;gap:10px;">
                        <button type="submit"
                                style="flex:1;padding:14px;background:#16a34a;color:#fff;font-size:15px;font-weight:700;border:none;border-radius:12px;cursor:pointer;">
                            🛍 Pesan Sekarang
                        </button>
                        <form action="{{ route('customer.wishlist.toggle', $product) }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" title="{{ $isWishlisted ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}"
                                    style="padding:14px 16px;border-radius:12px;border:1.5px solid {{ $isWishlisted ? '#ef4444' : '#d1d5db' }};background:{{ $isWishlisted ? '#fee2e2' : '#fff' }};color:{{ $isWishlisted ? '#ef4444' : '#6b7280' }};font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                                {{ $isWishlisted ? '❤️' : '🤍' }}
                            </button>
                        </form>
                    </div>
                </form>

                <script>
                function selectAddress(id, text) {
                    // Highlight selected
                    document.querySelectorAll('#addr-list label').forEach(el => {
                        el.style.borderColor = '#e5e7eb';
                        el.style.background = '#f9fafb';
                    });
                    const lbl = document.getElementById('addr-label-' + id);
                    if (lbl) { lbl.style.borderColor = '#16a34a'; lbl.style.background = '#f0fdf4'; }

                    // Set manual field
                    const manual = document.getElementById('manual-addr');
                    if (manual && manual.style.display === 'none') {
                        manual.value = '';
                        manual.removeAttribute('required');
                    }
                }

                function toggleManual() {
                    const manual = document.getElementById('manual-addr');
                    const isHidden = manual.style.display === 'none';
                    manual.style.display = isHidden ? 'block' : 'none';
                    if (isHidden) {
                        manual.setAttribute('required', 'required');
                        // Uncheck radio
                        document.querySelectorAll('input[name="selected_address_id"]').forEach(r => r.checked = false);
                    } else {
                        manual.removeAttribute('required');
                    }
                }

                // Highlight default on load
                document.addEventListener('DOMContentLoaded', function() {
                    const checked = document.querySelector('input[name="selected_address_id"]:checked');
                    if (checked) {
                        const lbl = checked.closest('label');
                        if (lbl) { lbl.style.borderColor = '#16a34a'; lbl.style.background = '#f0fdf4'; }
                    }
                });
                </script>

                @else
                <div style="display:flex;gap:10px;">
                    <a href="{{ route('login') }}"
                       style="flex:1;display:block;text-align:center;padding:14px;background:#16a34a;color:#fff;font-size:15px;font-weight:700;border-radius:12px;text-decoration:none;">
                        Login untuk Memesan
                    </a>
                    <a href="{{ route('login') }}"
                       style="padding:14px 16px;border-radius:12px;border:1.5px solid #d1d5db;background:#fff;color:#6b7280;font-size:18px;text-decoration:none;display:flex;align-items:center;">
                        🤍
                    </a>
                </div>
                @endauth
            @else
                <div style="text-align:center;padding:14px;background:#fee2e2;color:#dc2626;font-weight:700;border-radius:12px;">Stok Habis</div>
                @auth
                @php $isWishlisted = \App\Models\Wishlist::where('customer_id', auth()->id())->where('product_id', $product->id)->exists(); @endphp
                <form action="{{ route('customer.wishlist.toggle', $product) }}" method="POST" style="margin-top:10px;">
                    @csrf
                    <button type="submit" style="width:100%;padding:12px;border-radius:12px;border:1.5px solid {{ $isWishlisted ? '#ef4444' : '#d1d5db' }};background:{{ $isWishlisted ? '#fee2e2' : '#fff' }};color:{{ $isWishlisted ? '#ef4444' : '#6b7280' }};font-size:14px;font-weight:600;cursor:pointer;">
                        {{ $isWishlisted ? '❤️ Hapus dari Wishlist' : '🤍 Simpan ke Wishlist' }}
                    </button>
                </form>
                @endauth
            @endif

            {{-- Info Toko --}}
            <a href="{{ route('umkm.show', $product->umkm->slug) }}"
               style="display:flex;align-items:center;gap:12px;margin-top:20px;padding:14px;border:1px solid #e5e7eb;border-radius:12px;text-decoration:none;">
                <div style="width:44px;height:44px;border-radius:10px;background:#dcfce7;color:#16a34a;font-size:18px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    {{ strtoupper(substr($product->umkm->name, 0, 2)) }}
                </div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#111827;">{{ $product->umkm->name }}</div>
                    <div style="font-size:12px;color:#6b7280;">{{ $product->umkm->kecamatan }} · {{ $product->umkm->category->name ?? '' }}</div>
                </div>
                <span style="margin-left:auto;font-size:12px;color:#16a34a;font-weight:600;">Lihat Toko →</span>
            </a>
        </div>
    </div>

    {{-- Ulasan --}}
    @if($product->reviews->count() > 0)
    <div style="margin-bottom:48px;">
        <h2 style="font-size:18px;font-weight:800;color:#111827;margin-bottom:16px;">Ulasan ({{ $product->reviews->count() }})</h2>
        <div style="display:flex;flex-direction:column;gap:12px;">
            @foreach($product->reviews as $review)
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:16px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                    <span style="font-size:13.5px;font-weight:700;color:#111827;">{{ $review->customer->name ?? 'Anonim' }}</span>
                    <span style="color:#f59e0b;">@for($i=1;$i<=5;$i++){{ $i<=$review->rating?'★':'☆' }}@endfor</span>
                </div>
                <p style="font-size:13.5px;color:#374151;margin:0 0 6px;">{{ $review->comment }}</p>
                <span style="font-size:11.5px;color:#9ca3af;">{{ $review->created_at->format('d M Y') }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Produk Terkait --}}
    @if($related->count() > 0)
    <div>
        <h2 style="font-size:18px;font-weight:800;color:#111827;margin-bottom:16px;">Produk Terkait</h2>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
            @foreach($related as $item)
            <a href="{{ route('katalog.show', $item->slug) }}"
               style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;text-decoration:none;">
                <img src="{{ $item->images->first() ? Storage::url($item->images->first()->image_path) : asset('images/placeholder.png') }}"
                     alt="{{ $item->name }}" style="width:100%;height:160px;object-fit:cover;">
                <div style="padding:12px;">
                    <div style="font-size:13px;font-weight:700;color:#111827;margin-bottom:4px;">{{ Str::limit($item->name, 28) }}</div>
                    <div style="font-size:14px;font-weight:800;color:#16a34a;">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection