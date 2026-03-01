@extends('public.layouts.app')

@section('title', 'Tentang Kami - UMKM Padang')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Hero -->
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-800">Tentang UMKM Padang</h1>
        <p class="text-gray-500 mt-3 text-lg">Platform digital untuk mendukung dan mempromosikan UMKM lokal Kota Padang</p>
    </div>

    <!-- Konten -->
    <div class="bg-white rounded-xl shadow-sm p-8 space-y-8">

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3">Apa itu UMKM Padang?</h2>
            <p class="text-gray-600 leading-relaxed">
                UMKM Padang adalah platform digital yang dikembangkan untuk membantu para pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) di Kota Padang dalam memasarkan produk mereka secara online. Platform ini menghubungkan konsumen dengan pelaku UMKM lokal secara langsung.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3">Visi</h2>
            <p class="text-gray-600 leading-relaxed">
                Menjadi platform digital terdepan yang mendorong pertumbuhan UMKM Kota Padang dan meningkatkan kesejahteraan masyarakat melalui digitalisasi ekonomi lokal.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3">Misi</h2>
            <ul class="text-gray-600 space-y-2">
                <li class="flex items-start gap-2">
                    <span class="text-green-500 mt-1">✓</span>
                    Memfasilitasi UMKM lokal untuk memasarkan produk secara digital
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-500 mt-1">✓</span>
                    Mempermudah konsumen menemukan produk unggulan dari Kota Padang
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-500 mt-1">✓</span>
                    Mendukung program pemerintah dalam pengembangan UMKM daerah
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-500 mt-1">✓</span>
                    Menyediakan data dan statistik UMKM untuk keperluan perencanaan dinas terkait
                </li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3">Kontak</h2>
            <div class="text-gray-600 space-y-1">
                <p>Dinas Koperasi dan UMKM Kota Padang</p>
                <p>Kota Padang, Sumatera Barat</p>
            </div>
        </div>

    </div>

    <!-- CTA -->
    <div class="mt-8 text-center">
        <a href="{{ route('katalog') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-medium">
            Jelajahi Produk UMKM
        </a>
        <a href="{{ route('umkm.index') }}" class="inline-block ml-3 border border-green-600 text-green-600 px-6 py-3 rounded-lg hover:bg-green-50 transition font-medium">
            Lihat Direktori UMKM
        </a>
    </div>

</div>
@endsection