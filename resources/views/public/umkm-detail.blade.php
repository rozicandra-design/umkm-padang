@extends('public.layouts.app')

@section('title', $umkm->name . ' - UMKM Padang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-green-600">Beranda</a>
        <span class="mx-2">/</span>
        <a href="{{ route('umkm.index') }}" class="hover:text-green-600">UMKM</a>
        <span class="mx-2">/</span>
        <span class="text-gray-600">{{ $umkm->name }}</span>
    </nav>

    <!-- Profil UMKM -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Logo -->
            <div class="w-32 h-32 flex-shrink-0 rounded-xl overflow-hidden bg-green-50 flex items-center justify-center">
                @if($umkm->logo)
                    <img src="{{ asset('storage/' . $umkm->logo) }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-5xl font-bold text-green-300">{{ strtoupper(substr($umkm->name, 0, 1)) }}</span>
                @endif
            </div>

            <!-- Info -->
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $umkm->name }}</h1>
                        @if($umkm->category)
                            <span class="inline-block mt-1 text-sm bg-green-100 text-green-700 px-3 py-0.5 rounded-full">{{ $umkm->category->name }}</span>
                        @endif
                    </div>
                </div>

                @if($umkm->description)
                    <p class="text-gray-600 text-sm mt-3 leading-relaxed">{{ $umkm->description }}</p>
                @endif

                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-4">
                    @if($umkm->kecamatan)
                        <div class="text-sm">
                            <p class="text-gray-400 text-xs">Kecamatan</p>
                            <p class="text-gray-700 font-medium">{{ $umkm->kecamatan }}</p>
                        </div>
                    @endif
                    @if($umkm->phone)
                        <div class="text-sm">
                            <p class="text-gray-400 text-xs">Telepon</p>
                            <p class="text-gray-700 font-medium">{{ $umkm->phone }}</p>
                        </div>
                    @endif
                    @if($umkm->address)
                        <div class="text-sm">
                            <p class="text-gray-400 text-xs">Alamat</p>
                            <p class="text-gray-700 font-medium">{{ $umkm->address }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Produk UMKM -->
    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-4">Produk dari {{ $umkm->name }}</h2>

        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($products as $product)
                    <a href="{{ route('katalog.show', $product->slug) }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden group">
                        <div class="aspect-square overflow-hidden bg-gray-100">
                            @if($product->images->count() > 0)
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
                            <p class="text-green-700 font-bold text-sm mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $products->links() }}</div>
        @else
            <div class="text-center py-12 bg-white rounded-xl">
                <p class="text-gray-400">Belum ada produk dari UMKM ini</p>
            </div>
        @endif
    </div>

</div>
@endsection