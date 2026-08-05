@extends('layouts.layout')

@section('title', 'Statistik - JDIH Puncak Jaya')

@section('content')
<div class="relative py-12 text-white overflow-hidden bg-cover bg-center border-b border-primary/10" style="background-image: linear-gradient(135deg, rgba(0, 40, 142, 0.95) 0%, rgba(13, 27, 68, 0.98) 100%), url('{{ asset('images/puncak_jaya_backdrop.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent"></div>
    <div class="max-w-[1280px] mx-auto px-6 relative z-10">
        <h2 class="text-2xl md:text-3xl font-black font-display text-gradient mb-1">Statistik Produk Hukum</h2>
        <p class="text-xs text-white/70">Visualisasi sebaran peraturan perundang-undangan Kabupaten Puncak Jaya.</p>
    </div>
</div>

<div class="min-h-screen bg-gradient-to-b from-[#f2f4ff] via-[#faf8ff] to-[#faf8ff] pb-24">
    <div class="max-w-[1280px] mx-auto px-6 py-12 space-y-12">
    
    <!-- Top Grid: Key Metric Figures -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white border border-border-subtle p-6 rounded-2xl soft-shadow">
            <h4 class="text-xs uppercase tracking-wider font-bold text-on-surface-variant mb-2">Peraturan Daerah</h4>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black font-display text-primary">{{ $typeCounts['Peraturan Daerah'] ?? 0 }}</span>
                <span class="text-xs text-on-surface-variant font-medium">dokumen aktif & sejarah</span>
            </div>
        </div>
        <div class="bg-white border border-border-subtle p-6 rounded-2xl soft-shadow">
            <h4 class="text-xs uppercase tracking-wider font-bold text-on-surface-variant mb-2">Peraturan Bupati</h4>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black font-display text-primary">{{ $typeCounts['Peraturan Bupati'] ?? 0 }}</span>
                <span class="text-xs text-on-surface-variant font-medium">dokumen terdaftar</span>
            </div>
        </div>
        <div class="bg-white border border-border-subtle p-6 rounded-2xl soft-shadow">
            <h4 class="text-xs uppercase tracking-wider font-bold text-on-surface-variant mb-2">Keputusan Bupati</h4>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black font-display text-primary">{{ $typeCounts['Keputusan Bupati'] ?? 0 }}</span>
                <span class="text-xs text-on-surface-variant font-medium">surat keputusan resmi</span>
            </div>
        </div>
    </div>

    <!-- Middle Grid: Visual Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Chart 1: Status Distribution -->
        <div class="bg-white border border-border-subtle p-6 rounded-2xl soft-shadow">
            <h3 class="text-sm font-bold tracking-widest uppercase text-on-surface-variant border-b border-border-subtle pb-4 mb-6">Status Hukum Regulasi</h3>
            <div class="w-full max-w-[320px] mx-auto h-[320px]">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Type Distribution -->
        <div class="bg-white border border-border-subtle p-6 rounded-2xl soft-shadow">
            <h3 class="text-sm font-bold tracking-widest uppercase text-on-surface-variant border-b border-border-subtle pb-4 mb-6">Sebaran Berdasarkan Jenis</h3>
            <div class="w-full h-[320px]">
                <canvas id="typeChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Bottom Row: Trend Line -->
    <div class="bg-white border border-border-subtle p-6 rounded-2xl soft-shadow">
        <h3 class="text-sm font-bold tracking-widest uppercase text-on-surface-variant border-b border-border-subtle pb-4 mb-6">Tren Regulasi Per Tahun</h3>
        <div class="w-full h-[350px]">
            <canvas id="trendChart"></canvas>
        </div>
    </div>
</div>
</div>

<!-- Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Status Chart
    const statusData = {
        labels: ['Berlaku', 'Diubah', 'Dicabut'],
        datasets: [{
            data: [
                {{ $statusCounts['active'] ?? 0 }},
                {{ $statusCounts['amended'] ?? 0 }},
                {{ $statusCounts['revoked'] ?? 0 }}
            ],
            backgroundColor: ['#14B8A6', '#F59E0B', '#E11D48'],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    };
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: statusData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 2. Type Chart
    const typeData = {
        labels: {!! json_encode(array_keys($typeCounts)) !!},
        datasets: [{
            label: 'Jumlah Dokumen',
            data: {!! json_encode(array_values($typeCounts)) !!},
            backgroundColor: '#1e40af',
            borderRadius: 8
        }]
    };
    new Chart(document.getElementById('typeChart'), {
        type: 'bar',
        data: typeData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // 3. Trend Chart
    const trendData = {
        labels: {!! json_encode(array_keys($yearCounts)) !!},
        datasets: [{
            label: 'Produk Hukum Terbit',
            data: {!! json_encode(array_values($yearCounts)) !!},
            borderColor: '#00288e',
            backgroundColor: 'rgba(0, 40, 142, 0.05)',
            fill: true,
            tension: 0.3,
            borderWidth: 3,
            pointBackgroundColor: '#00288e'
        }]
    };
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: trendData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endsection
