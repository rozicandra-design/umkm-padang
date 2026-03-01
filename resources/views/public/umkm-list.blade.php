@extends('public.layouts.app')

@section('title', 'Direktori UMKM - UMKM Padang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Direktori UMKM</h1>
        <p class="text-gray-500 text-sm mt-1">Temukan UMKM unggulan dari Kota Padang</p>
    </div>

    <form method="GET" action="{{ route('umkm.index') }}" class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama UMKM..."
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">

            <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <select name="kecamatan" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">Semua Kecamatan</option>
                @foreach($kecamatans as $kec)
                    <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-green-600 text-white rounded-lg px-4 py-2 text-sm hover:bg-green-700 transition">Cari</button>
                @if(request()->hasAny(['q', 'category', 'kecamatan']))
                    <a href="{{ route('umkm.index') }}" class="flex-1 text-center border border-gray-300 rounded-lg px-4 py-2 text-sm hover:bg-gray-100 transition">Reset</a>
                @endif
            </div>
        </div>
    </form>

    <div class="mb-4">
        <p class="text-sm text-gray-500">Menampilkan <span class="font-semibold text-gray-700">{{ $umkmList->total() }}</span> UMKM</p>
    </div>

    @if($umkmList->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($umkmList as $umkm)
                <a href="{{ route('umkm.show', $umkm->slug) }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden group">
                    <div class="h-36 overflow-hidden bg-gray-100">
                        @if($umkm->logo)
                            <img src="{{ asset('storage/' . $umkm->logo) }}" alt="{{ $umkm->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-green-50">
                                <span class="text-4xl font-bold text-green-300">{{ strtoupper(substr($umkm->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 truncate">{{ $umkm->name }}</h3>
                        @if($umkm->category)
                            <span class="inline-block mt-1 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">{{ $umkm->category->name }}</span>
                        @endif
                        @if($umkm->kecamatan)
                            <p class="text-xs text-gray-400 mt-2">{{ $umkm->kecamatan }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">{{ $umkm->products_count }} produk</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $umkmList->links() }}</div>
    @else
        <div class="text-center py-20">
            <p class="text-gray-500 text-lg">UMKM tidak ditemukan</p>
            <p class="text-gray-400 text-sm mt-1">Coba kata kunci atau filter yang berbeda</p>
            <a href="{{ route('umkm.index') }}" class="inline-block mt-4 text-green-600 hover:underline text-sm">Lihat semua UMKM</a>
        </div>
    @endif

</div>
@endsection