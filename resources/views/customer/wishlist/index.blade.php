@extends('layouts.dashboard')
@section('title', 'Wishlist')
@section('page-title', 'Wishlist Saya')

@section('dashboard-content')
<div class="products-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:18px">
    @forelse($wishlists as $wish)
    @php $product = $wish->product; @endphp
    <div class="card" style="overflow:hidden">
        <div style="height:150px;background:#EEF4FC;display:flex;align-items:center;justify-content:center;font-size:48px">
            🛍️
        </div>
        <div style="padding:14px">
            <div style="font-size:11px;color:#1553A8;font-weight:500;margin-bottom:4px">{{ $product->umkm->name ?? '-' }}</div>
            <div style="font-size:13px;font-weight:700;margin-bottom:6px">{{ $product->name }}</div>
            <div style="font-size:15px;font-weight:800;color:#1553A8;margin-bottom:12px">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>
            <div style="display:flex;gap:8px">
                <a href="{{ route('produk.show', $product->slug) }}" class="btn btn-sm btn-blue" style="flex:1;justify-content:center">Pesan</a>
                <form action="{{ route('customer.wishlist.toggle', $product) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger" title="Hapus dari wishlist"><i class="fa fa-heart-broken"></i></button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:48px;color:#6B7A90">
        <div style="font-size:48px;margin-bottom:12px">💔</div>
        <p>Wishlist masih kosong.</p>
        <a href="{{ route('katalog') }}" class="btn btn-blue" style="margin-top:12px">Jelajahi Produk</a>
    </div>
    @endforelse
</div>
@endsection
