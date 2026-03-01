@extends('public.layouts.app')

@section('title', 'Peta UMKM - UMKM Padang')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 600px; width: 100%; border-radius: 12px; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Peta UMKM</h1>
        <p class="text-gray-500 text-sm mt-1">Sebaran lokasi UMKM aktif di Kota Padang</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 mb-4">
        <p class="text-sm text-gray-500">
            Menampilkan <span class="font-semibold text-green-600">{{ $umkmList->count() }}</span> UMKM di peta
        </p>
    </div>

    <div id="map" class="shadow-md"></div>

</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([-0.9471, 100.4172], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const umkmData = @json($umkmList);

    umkmData.forEach(function(umkm) {
        if (umkm.latitude && umkm.longitude) {
            const marker = L.marker([umkm.latitude, umkm.longitude]).addTo(map);
            marker.bindPopup(`
                <div style="min-width:150px">
                    <strong style="font-size:14px">${umkm.name}</strong><br>
                    <small style="color:#666">${umkm.kecamatan ?? ''}</small><br>
                    <small>${umkm.address ?? ''}</small><br>
                    <a href="/umkm/${umkm.slug}" style="color:#16a34a;font-size:12px;margin-top:4px;display:inline-block">
                        Lihat Profil →
                    </a>
                </div>
            `);
        }
    });
</script>
@endpush