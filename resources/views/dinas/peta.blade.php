@extends('layouts.dashboard')
@section('title', 'Peta UMKM')
@section('page-title', 'Peta Sebaran UMKM')

@section('dashboard-content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-map text-blue"></i> Peta Sebaran UMKM Kota Padang</h3>
        <span class="badge badge-success">{{ $umkmList->count() }} UMKM aktif</span>
    </div>
    <div style="padding:0;">
        <div id="map" style="height:520px; width:100%; border-radius:0 0 14px 14px;"></div>
    </div>
</div>

<div class="stats-grid" style="margin-top:20px;">
    @php
        $kecamatanGroup = $umkmList->groupBy('kecamatan');
    @endphp
    @foreach($kecamatanGroup->take(6) as $kec => $list)
    <div class="stat-card">
        <div class="stat-icon"><i class="fa fa-map-marker-alt"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ $list->count() }}</div>
            <div class="stat-label">{{ $kec }}</div>
        </div>
    </div>
    @endforeach
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const map = L.map('map').setView([-0.9492, 100.3543], 12);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

const umkmData = @json($umkmList);
umkmData.forEach(u => {
    if (u.latitude && u.longitude) {
        const marker = L.marker([parseFloat(u.latitude), parseFloat(u.longitude)]).addTo(map);
        marker.bindPopup(`
            <div style="min-width:180px">
                <strong style="font-size:14px">${u.name}</strong><br>
                <span style="color:#6b7280;font-size:12px">📍 ${u.kecamatan}</span><br>
                <a href="/umkm/${u.slug}" target="_blank"
                   style="color:#1553A8;font-size:12px;font-weight:600">Lihat Detail →</a>
            </div>
        `);
    }
});
</script>
@endpush