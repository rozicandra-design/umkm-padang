@extends('layouts.dashboard')
@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@section('dashboard-content')
<div class="stats-grid">
    <div class="stat-card stat-card-blue">
        <div class="stat-icon"><i class="fa fa-money-bill-wave"></i></div>
        <div class="stat-info">
            <div class="stat-num">Rp {{ number_format($omzetBulanIni / 1000, 0) }}K</div>
            <div class="stat-label">Omzet Bulan Ini</div>
        </div>
    </div>
    <div class="stat-card stat-card-green">
        <div class="stat-icon"><i class="fa fa-shopping-bag"></i></div>
        <div class="stat-info">
            <div class="stat-num">{{ $pesananBulanIni }}</div>
            <div class="stat-label">Pesanan Bulan Ini</div>
        </div>
    </div>
    <div class="stat-card stat-card-gold">
        <div class="stat-icon"><i class="fa fa-money-bill"></i></div>
        <div class="stat-info">
            <div class="stat-num">Rp {{ number_format($omzetTotal / 1000, 0) }}K</div>
            <div class="stat-label">Total Omzet</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-chart-line"></i> Grafik Omzet {{ now()->year }}</h3>
    </div>
    <canvas id="omzetChart" height="120" style="padding:20px"></canvas>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
const rawData = @json($omzetPerBulan ?? []);
const data = Array.from({length:12}, (_, i) => rawData[i+1] || 0);
new Chart(document.getElementById('omzetChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Omzet (Rp)',
            data: data,
            borderColor: '#1553A8',
            backgroundColor: 'rgba(21,83,168,0.08)',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endpush
