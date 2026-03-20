@extends('layouts.dashboard')
@section('title', 'Wishlist Saya')
@section('page-title', 'Wishlist Saya')

@section('dashboard-content')

<style>
    .wishlist-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .wishlist-count {
        font-size: 13px;
        color: #6b7280;
        background: #f3f4f6;
        padding: 4px 12px;
        border-radius: 99px;
        font-weight: 500;
    }
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 18px;
    }
    .wish-card {
        background: #fff;
        border: 1.5px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        transition: box-shadow .2s, transform .2s;
    }
    .wish-card:hover {
        box-shadow: 0 6px 24px rgba(0,0,0,.09);
        transform: translateY(-3px);
    }

    /* Product image area */
    .wish-img {
        height: 155px;
        background: linear-gradient(135deg, #eef4fc, #dbeafe);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 52px;
        position: relative;
        overflow: hidden;
    }
    .wish-img img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
    }
    .wish-remove-btn {
        position: absolute;
        top: 8px; right: 8px;
        background: rgba(255,255,255,.92);
        border: none;
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #ef4444;
        font-size: 13px;
        cursor: pointer;
        box-shadow: 0 1px 4px rgba(0,0,0,.12);
        transition: background .15s, transform .15s;
    }
    .wish-remove-btn:hover {
        background: #fee2e2;
        transform: scale(1.1);
    }

    /* Body */
    .wish-body { padding: 14px; }
    .wish-store {
        font-size: 11px;
        color: #2563eb;
        font-weight: 600;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .wish-name {
        font-size: 13.5px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .wish-price {
        font-size: 15px;
        font-weight: 800;
        color: #2563eb;
        margin-bottom: 12px;
    }
    .wish-actions {
        display: flex;
        gap: 8px;
    }
    .wish-btn-order {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        background: #2563eb;
        color: #fff;
        font-size: 12.5px;
        font-weight: 600;
        padding: 8px 10px;
        border-radius: 8px;
        text-decoration: none;
        transition: background .15s;
    }
    .wish-btn-order:hover { background: #1d4ed8; }

    /* Empty state */
    .wishlist-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 64px 24px;
        background: #fff;
        border: 1.5px dashed #e5e7eb;
        border-radius: 16px;
    }
    .wishlist-empty-icon {
        font-size: 56px;
        margin-bottom: 16px;
        display: block;
    }
    .wishlist-empty h3 {
        font-size: 17px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
    }
    .wishlist-empty p {
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    .wish-btn-explore {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #2563eb;
        color: #fff;
        font-size: 13.5px;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(37,99,235,.3);
        transition: background .15s, transform .1s;
    }
    .wish-btn-explore:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }
</style>

{{-- Header --}}
<div class="wishlist-header">
    <span class="wishlist-count">
        <i class="fa fa-heart" style="color:#ef4444;margin-right:4px;"></i>
        {{ $wishlists->count() }} produk tersimpan
    </span>
    @if($wishlists->count() > 0)
        <a href="{{ route('katalog') }}" style="font-size:13px;color:#2563eb;font-weight:600;text-decoration:none;">
            <i class="fa fa-plus"></i> Tambah Produk
        </a>
    @endif
</div>

{{-- Grid --}}
<div class="wishlist-grid">
    @forelse($wishlists as $wish)
        @php $product = $wish->product; @endphp
        <div class="wish-card">

            {{-- Gambar --}}
            <div class="wish-img">
                @if($product->images && $product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                         alt="{{ $product->name }}" loading="lazy">
                @else
                    &#128717;
                @endif

                {{-- Tombol hapus --}}
                <form action="{{ route('customer.wishlist.toggle', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="wish-remove-btn" title="Hapus dari wishlist">
                        <i class="fa fa-heart-broken"></i>
                    </button>
                </form>
            </div>

            {{-- Info --}}
            <div class="wish-body">
                <div class="wish-store">{{ $product->umkm->name ?? '-' }}</div>
                <div class="wish-name">{{ $product->name }}</div>
                <div class="wish-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="wish-actions">
                    <a href="{{ route('katalog.show', $product->slug) }}" class="wish-btn-order">
                        <i class="fa fa-shopping-cart"></i> Pesan
                    </a>
                </div>
            </div>
        </div>

    @empty
        <div class="wishlist-empty">
            <span class="wishlist-empty-icon">&#128148;</span>
            <h3>Wishlist Masih Kosong</h3>
            <p>Kamu belum menyimpan produk apapun.<br>Temukan produk favoritmu dan simpan di sini!</p>
            <a href="{{ route('katalog') }}" class="wish-btn-explore">
                <i class="fa fa-search"></i> Jelajahi Produk
            </a>
        </div>
    @endforelse
</div>

@endsection