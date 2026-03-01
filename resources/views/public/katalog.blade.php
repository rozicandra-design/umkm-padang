@extends('public.layouts.app')

@section('title', 'Katalog Produk - UMKM Padang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Katalog Produk</h1>
        <p class="text-gray-500 text-sm mt-1">Temukan produk unggulan dari UMKM Kota Padang</p>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('katalog') }}" class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <!-- Search -->
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari produk..."
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
            >

            <!-- Kategori -->
            <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <!-- Urutkan -->
            <select name="sort" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">Terbaru</option>
                <option value="termurah" {{ request('sort') === 'termurah' ? 'selected' : '' }}>Termurah</option>
                <option value="termahal" {{ request('sort') === 'termahal' ? 'selected' : '' }}>Termahal</option>
                <option value="terlaris" {{ request('sort') === 'terlaris' ? 'selected' : '' }}>Terlaris</option>
            </select>

            <!-- Tombol -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-green-600 text-white rounded-lg px-4 py-2 text-sm hover:bg-green-700 transition">
                    Cari
                </button>
                @if(request()->hasAny(['q', 'category', 'sort', 'kecamatan']))
                    <a href="{{ route('katalog') }}" class="flex-1 text-center border border-gray-300 rounded-lg px-4 py-2 text-sm hover:bg-gray-100 transition">
                        Reset
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Info Hasil -->
    <div class="flex items-center justify-between mb-4">
        <p class="text-sm text-gray-500">
            Menampilkan <span class="font-semibold text-gray-700">{{ $products->total() }}</span> produk
        </p>
    </div>

    <!-- Grid Produk -->
    @if($products->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($products as $product)
                <a href="{{ route('katalog.show', $product->slug) }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden group">
                    <!-- Gambar -->
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        @if($product->images->count() > 0)
                            <img
                                src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="p-3">
                        <p class="text-xs text-green-600 font-medium mb-1 truncate">{{ $product->umkm->name ?? '-' }}</p>
                        <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
                        <p class="text-green-700 font-bold text-sm mt-1">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        @if($product->category)
                            <span class="inline-block mt-2 text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>

    @else
        <div class="text-center py-20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-gray-500 text-lg">Produk tidak ditemukan</p>
            <p class="text-gray-400 text-sm mt-1">Coba kata kunci atau filter yang berbeda</p>
            <a href="{{ route('katalog') }}" class="inline-block mt-4 text-green-600 hover:underline text-sm">Lihat semua produk</a>
        </div>
    @endif

</div>
@endsection