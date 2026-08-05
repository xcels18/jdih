@extends('layouts.layout')

@section('title', 'Statistik - JDIH Puncak Jaya')

@section('content')
<!-- Header Banner Section with Glassmorphism Accent -->
<div class="relative py-14 text-white overflow-hidden bg-cover bg-center border-b border-primary/10" style="background-image: linear-gradient(135deg, rgba(0, 40, 142, 0.96) 0%, rgba(13, 27, 68, 0.98) 100%), url('{{ asset('images/puncak_jaya_backdrop.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent"></div>
    <div class="max-w-[1400px] mx-auto px-6 relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <nav class="text-[10px] uppercase tracking-widest text-white/60 mb-2 font-display">Beranda &raquo; Analitik</nav>
            <h2 class="text-3xl font-black font-display text-gradient mb-1">Dasbor Analitik JDIH</h2>
            <p class="text-xs text-white/70 font-light">Pantau kondisi, sebaran, dan popularitas produk hukum daerah secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('stats.export') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase tracking-wider transition-all flex items-center gap-2 shadow-md shadow-emerald-700/20 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Cetak Laporan (Excel)
                </a>
            @endauth
            <button onclick="window.location.reload()" class="w-10 h-10 rounded-xl border border-white/20 bg-white/5 hover:bg-white/10 text-white flex items-center justify-center transition-all cursor-pointer" title="Refresh Data">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- Main Dashboard Body -->
<div class="min-h-screen bg-slate-50/50 pb-24">
    <div class="max-w-[1400px] mx-auto px-6 py-10 space-y-8">
        
        <!-- Global Interactive Filter Bar -->
        <section class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.02)] space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                </svg>
                <h3 class="text-xs font-bold tracking-wider uppercase text-slate-800">Filter Analitik Terintegrasi</h3>
            </div>
            
            <form id="filter-form" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Filter Tahun -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide">Tahun Terbit</label>
                    <select name="year" class="filter-select w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-slate-50/50">
                        <option value="">Semua Tahun</option>
                        @foreach($filterYears as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tipe Dokumen (Level 1) -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide">Bentuk Dokumen</label>
                    <select name="document_type" class="filter-select w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-slate-50/50">
                        <option value="">Semua Bentuk</option>
                        @foreach($filterDocTypes as $docType)
                            <option value="{{ $docType }}">{{ $docType }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Bentuk Peraturan (Leaf) -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide">Bentuk Peraturan</label>
                    <select name="type" class="filter-select w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-slate-50/50">
                        <option value="">Semua Bentuk Peraturan</option>
                        @foreach($filterTypes as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Bidang Hukum -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide">Bidang Hukum</label>
                    <select name="law_field" class="filter-select w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-slate-50/50">
                        <option value="">Semua Bidang</option>
                        @foreach($filterLawFields as $field)
                            <option value="{{ $field }}">{{ $field }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </section>

        <!-- KPI Metric Cards Grid -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1: Total Dokumen -->
            <div class="bg-white border border-slate-200/85 p-6 rounded-2xl shadow-sm flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-110 transition-transform duration-500 flex items-center justify-center text-primary/10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div class="w-12 h-12 bg-primary/5 text-primary rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Total Dokumen</h4>
                    <span id="kpi-total" class="text-3xl font-black font-display text-slate-800">{{ $data['kpis']['total'] }}</span>
                    <p class="text-[10px] text-slate-500 font-medium mt-1">dokumen hukum aktif & terarsip</p>
                </div>
            </div>

            <!-- Card 2: Peraturan Perundang-Undangan -->
            <div class="bg-white border border-slate-200/85 p-6 rounded-2xl shadow-sm flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-amber-500/5 rounded-full group-hover:scale-110 transition-transform duration-500 flex items-center justify-center text-amber-500/10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                    </svg>
                </div>
                <div class="w-12 h-12 bg-amber-500/5 text-amber-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Peraturan UU</h4>
                    <span id="kpi-peraturan" class="text-3xl font-black font-display text-slate-800">{{ $data['kpis']['peraturan'] }}</span>
                    <p class="text-[10px] text-slate-500 font-medium mt-1">undang-undang & peraturan pusat</p>
                </div>
            </div>

            <!-- Card 3: Produk Hukum Daerah -->
            <div class="bg-white border border-slate-200/85 p-6 rounded-2xl shadow-sm flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-emerald-500/5 rounded-full group-hover:scale-110 transition-transform duration-500 flex items-center justify-center text-emerald-500/10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-16.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-16.25v16.25" />
                    </svg>
                </div>
                <div class="w-12 h-12 bg-emerald-500/5 text-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-16.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-16.25v16.25" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Produk Hukum Daerah</h4>
                    <span id="kpi-daerah" class="text-3xl font-black font-display text-slate-800">{{ $data['kpis']['daerah'] }}</span>
                    <p class="text-[10px] text-slate-500 font-medium mt-1">perda bupati, perkada, & perdes</p>
                </div>
            </div>

            <!-- Card 4: Total Download -->
            <div class="bg-white border border-slate-200/85 p-6 rounded-2xl shadow-sm flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-violet-500/5 rounded-full group-hover:scale-110 transition-transform duration-500 flex items-center justify-center text-violet-500/10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </div>
                <div class="w-12 h-12 bg-violet-500/5 text-violet-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Total Unduh File</h4>
                    <span id="kpi-downloads" class="text-3xl font-black font-display text-slate-800">{{ number_format($data['kpis']['downloads']) }}</span>
                    <p class="text-[10px] text-slate-500 font-medium mt-1">berkas pdf diunduh publik</p>
                </div>
            </div>
        </section>

        <!-- Charts Row 1: Line Chart + AI Insight Panel -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Line Chart: Tren Dokumen Per Tahun -->
            <div class="lg:col-span-2 bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Tren Penerbitan Regulasi Per Tahun</h3>
                    <span class="text-[10px] font-bold text-slate-400">Puncak Jaya (2020 - 2026)</span>
                </div>
                <div class="w-full h-[320px]">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Dynamic AI Insights Panel -->
            <div class="bg-gradient-to-br from-primary to-primary-container text-white p-7 rounded-2xl shadow-sm relative overflow-hidden flex flex-col justify-between">
                <div class="absolute -right-16 -top-16 w-44 h-44 rounded-full bg-white/5 pointer-events-none"></div>
                
                <div class="space-y-5 relative z-10">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-status-active">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 21l8.982-11.795H13.68l.817-5.096L5.5 15.904h4.313Z" />
                        </svg>
                        <h4 class="text-xs font-black uppercase tracking-wider text-white/90 font-display">AI Insights & Smart Analytics</h4>
                    </div>
                    
                    <div id="ai-insight-content" class="space-y-4 text-xs font-light leading-relaxed text-white/90">
                        <!-- Filled dynamically by javascript -->
                        <div class="animate-pulse space-y-2">
                            <div class="h-3.5 bg-white/20 rounded w-full"></div>
                            <div class="h-3.5 bg-white/20 rounded w-5/6"></div>
                            <div class="h-3.5 bg-white/20 rounded w-4/5"></div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-white/10 pt-5 mt-6 flex items-center justify-between text-[10px] text-white/50 relative z-10 font-sans">
                    <span>*Dianalisis secara real-time berdasarkan data aktif</span>
                    <span class="font-bold">HEURISTIC AI</span>
                </div>
            </div>
        </section>

        <!-- Charts Row 2: Sebaran Bentuk + Status + Bidang Hukum -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- 1. Distribusi Jenis (Donut Chart) -->
            <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-3">Sebaran Bentuk Peraturan</h3>
                <div class="w-full h-[240px] flex items-center justify-center">
                    <canvas id="typeChart"></canvas>
                </div>
            </div>

            <!-- 2. Status Hukum (Pie Chart) -->
            <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-3">Status Hukum Regulasi</h3>
                <div class="w-full h-[240px] flex items-center justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- 3. Bidang Hukum (Bar Chart) -->
            <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-3">Bidang Hukum Dominan</h3>
                <div class="w-full h-[240px] flex items-center justify-center">
                    <canvas id="fieldChart"></canvas>
                </div>
            </div>
        </section>

        <!-- Top Regulations Table Section -->
        <section class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden space-y-4 p-6">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-4">Top 5 Produk Hukum Paling Sering Diakses</h3>
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80 text-slate-500 uppercase tracking-wider font-bold text-[10px]">
                            <th class="p-4">Bentuk</th>
                            <th class="p-4">Judul Regulasi</th>
                            <th class="p-4 text-center">Jumlah Kunjungan</th>
                            <th class="p-4 text-center">Jumlah Diunduh</th>
                            <th class="p-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="top-regs-body" class="divide-y divide-slate-100 text-slate-700">
                        @foreach($data['top_regulations'] as $reg)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4">
                                    <span class="bg-primary/5 text-primary font-bold px-2 py-0.5 rounded text-[10px] uppercase">
                                        {{ $reg['type'] }}
                                    </span>
                                </td>
                                <td class="p-4 font-semibold text-slate-800">
                                    <a href="{{ route('detail', $reg['id']) }}" class="hover:text-primary transition">
                                        {{ $reg['title'] }}
                                    </a>
                                </td>
                                <td class="p-4 text-center font-medium">{{ number_format($reg['views']) }}</td>
                                <td class="p-4 text-center font-medium">{{ number_format($reg['downloads']) }}</td>
                                <td class="p-4 text-center">
                                    @if($reg['status'] === 'active')
                                        <span class="bg-status-active/10 text-status-active text-[10px] font-bold px-2 py-0.5 rounded-full">Berlaku</span>
                                    @elseif($reg['status'] === 'amended')
                                        <span class="bg-status-amended/10 text-status-amended text-[10px] font-bold px-2 py-0.5 rounded-full">Diubah</span>
                                    @else
                                        <span class="bg-status-revoked/10 text-status-revoked text-[10px] font-bold px-2 py-0.5 rounded-full">Dicabut</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<!-- Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart Instance References
        let trendChartObj = null;
        let typeChartObj = null;
        let statusChartObj = null;
        let fieldChartObj = null;

        // Fetch initial datasets
        let currentData = {!! json_encode($data) !!};

        // Render all charts
        renderAllCharts(currentData);
        generateAndRenderAIInsights(currentData);

        // Listen for filter form changes
        const filterSelects = document.querySelectorAll('.filter-select');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                // Fetch dynamic filters via AJAX
                const formData = new FormData(document.getElementById('filter-form'));
                const params = new URLSearchParams();
                
                params.append('ajax', '1');
                for (const [key, value] of formData.entries()) {
                    if (value) params.append(key, value);
                }

                // Show loading states on cards/insights
                document.getElementById('ai-insight-content').innerHTML = `
                    <div class="animate-pulse space-y-2">
                        <div class="h-3.5 bg-white/20 rounded w-full"></div>
                        <div class="h-3.5 bg-white/20 rounded w-5/6"></div>
                    </div>
                `;

                fetch(`{{ route('stats') }}?${params.toString()}`)
                    .then(res => res.json())
                    .then(data => {
                        currentData = data;
                        updateKPIs(data.kpis);
                        updateCharts(data.charts);
                        updateTable(data.top_regulations);
                        generateAndRenderAIInsights(data);
                    })
                    .catch(err => console.error("Gagal memperbarui analitik:", err));
            });
        });

        // 1. Update KPI Card numbers
        function updateKPIs(kpis) {
            document.getElementById('kpi-total').textContent = kpis.total;
            document.getElementById('kpi-peraturan').textContent = kpis.peraturan;
            document.getElementById('kpi-daerah').textContent = kpis.daerah;
            document.getElementById('kpi-downloads').textContent = new Intl.NumberFormat().format(kpis.downloads);
        }

        // 2. Render all Chart.js instances
        function renderAllCharts(data) {
            // Trend Area/Line Chart
            const ctxTrend = document.getElementById('trendChart').getContext('2d');
            trendChartObj = new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: data.charts.yearly_trend.labels,
                    datasets: [{
                        label: 'Dokumen Terbit',
                        data: data.charts.yearly_trend.values,
                        borderColor: '#2563EB',
                        backgroundColor: 'rgba(37, 99, 235, 0.05)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 3,
                        pointBackgroundColor: '#2563EB',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 1.5,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1, color: '#94A3B8' }, grid: { color: '#F1F5F9' } },
                        x: { ticks: { color: '#94A3B8' }, grid: { display: false } }
                    }
                }
            });

            // Type Donut Chart
            const ctxType = document.getElementById('typeChart').getContext('2d');
            typeChartObj = new Chart(ctxType, {
                type: 'doughnut',
                data: {
                    labels: data.charts.type_distribution.labels,
                    datasets: [{
                        data: data.charts.type_distribution.values,
                        backgroundColor: ['#2563EB', '#10B981', '#06B6D4', '#F59E0B', '#6366F1', '#EC4899', '#8B5CF6'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });

            // Status Pie Chart
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            statusChartObj = new Chart(ctxStatus, {
                type: 'pie',
                data: {
                    labels: data.charts.status_distribution.labels,
                    datasets: [{
                        data: data.charts.status_distribution.values,
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } }
                }
            });

            // Law Field Bar Chart
            const ctxField = document.getElementById('fieldChart').getContext('2d');
            fieldChartObj = new Chart(ctxField, {
                type: 'bar',
                data: {
                    labels: data.charts.law_field.labels.slice(0, 5),
                    datasets: [{
                        data: data.charts.law_field.values.slice(0, 5),
                        backgroundColor: '#6366F1',
                        borderRadius: 6
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, ticks: { stepSize: 1, color: '#94A3B8' }, grid: { color: '#F1F5F9' } },
                        y: { ticks: { color: '#475569', font: { size: 10 } }, grid: { display: false } }
                    }
                }
            });
        }

        // 3. Update Chart datasets on filter change
        function updateCharts(charts) {
            // Update Trend
            trendChartObj.data.labels = charts.yearly_trend.labels;
            trendChartObj.data.datasets[0].data = charts.yearly_trend.values;
            trendChartObj.update();

            // Update Type Distribution
            typeChartObj.data.labels = charts.type_distribution.labels;
            typeChartObj.data.datasets[0].data = charts.type_distribution.values;
            typeChartObj.update();

            // Update Status Distribution
            statusChartObj.data.labels = charts.status_distribution.labels;
            statusChartObj.data.datasets[0].data = charts.status_distribution.values;
            statusChartObj.update();

            // Update Law Field Bar
            fieldChartObj.data.labels = charts.law_field.labels.slice(0, 5);
            fieldChartObj.data.datasets[0].data = charts.law_field.values.slice(0, 5);
            fieldChartObj.update();
        }

        // 4. Repopulate table rows
        function updateTable(regs) {
            const tbody = document.getElementById('top-regs-body');
            tbody.innerHTML = '';
            
            if (regs.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="p-6 text-center text-slate-400">Tidak ada regulasi yang sesuai filter.</td></tr>`;
                return;
            }

            regs.forEach(reg => {
                const statusBadge = reg.status === 'active' 
                    ? `<span class="bg-status-active/10 text-status-active text-[10px] font-bold px-2 py-0.5 rounded-full">Berlaku</span>`
                    : (reg.status === 'amended' 
                        ? `<span class="bg-status-amended/10 text-status-amended text-[10px] font-bold px-2 py-0.5 rounded-full">Diubah</span>`
                        : `<span class="bg-status-revoked/10 text-status-revoked text-[10px] font-bold px-2 py-0.5 rounded-full">Dicabut</span>`);

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-4">
                            <span class="bg-primary/5 text-primary font-bold px-2 py-0.5 rounded text-[10px] uppercase">
                                ${reg.type}
                            </span>
                        </td>
                        <td class="p-4 font-semibold text-slate-800">
                            <a href="/regulation/${reg.id}" class="hover:text-primary transition">
                                ${reg.title}
                            </a>
                        </td>
                        <td class="p-4 text-center font-medium">${new Intl.NumberFormat().format(reg.views)}</td>
                        <td class="p-4 text-center font-medium">${new Intl.NumberFormat().format(reg.downloads)}</td>
                        <td class="p-4 text-center">${statusBadge}</td>
                    </tr>
                `;
            });
        }

        // 5. Rule-based AI Insight Engine
        function generateAndRenderAIInsights(data) {
            const container = document.getElementById('ai-insight-content');
            container.innerHTML = '';

            const insights = [];

            // Dominant shapes
            const sortedTypes = [...data.charts.type_distribution.labels].map((lbl, idx) => ({
                label: lbl,
                value: data.charts.type_distribution.values[idx]
            })).sort((a, b) => b.value - a.value);

            if (sortedTypes.length > 0 && data.kpis.total > 0) {
                const top = sortedTypes[0];
                const pct = Math.round((top.value / data.kpis.total) * 100);
                insights.push(`📚 Dokumen berjenis <strong>${top.label}</strong> mendominasi sistem dengan porsi sebesar <strong>${pct}%</strong> dari seluruh produk hukum (${top.value} dokumen).`);
            }

            // Trend growth
            const trendLabels = data.charts.yearly_trend.labels;
            const trendValues = data.charts.yearly_trend.values;
            if (trendValues.length >= 2) {
                const curVal = trendValues[trendValues.length - 1];
                const prevVal = trendValues[trendValues.length - 2];
                const diff = curVal - prevVal;
                const percentChange = prevVal > 0 ? Math.round((diff / prevVal) * 100) : 0;
                if (diff > 0) {
                    insights.push(`📈 Terjadi kenaikan penerbitan regulasi sebesar <strong>+${percentChange}%</strong> dari tahun ${trendLabels[trendLabels.length-2]} ke tahun ${trendLabels[trendLabels.length-1]}.`);
                } else if (diff < 0) {
                    insights.push(`📉 Penerbitan produk hukum mengalami penurunan volume sebesar <strong>${Math.abs(percentChange)}%</strong> pada periode tahun ${trendLabels[trendLabels.length-1]}.`);
                }
            }

            // Revoked warnings
            const revokedIdx = data.charts.status_distribution.labels.indexOf('Dicabut');
            if (revokedIdx !== -1) {
                const count = data.charts.status_distribution.values[revokedIdx];
                if (count > 0) {
                    insights.push(`⚠️ Teridentifikasi <strong>${count} peraturan daerah</strong> yang berstatus <strong>Dicabut/Tidak Berlaku</strong>. Pastikan dokumen penggantinya telah disinkronisasikan.`);
                }
            }

            // Top Field
            const sortedFields = [...data.charts.law_field.labels].map((lbl, idx) => ({
                label: lbl,
                value: data.charts.law_field.values[idx]
            })).sort((a, b) => b.value - a.value);

            if (sortedFields.length > 0) {
                insights.push(`🏛 Bidang hukum <strong>${sortedFields[0].label}</strong> merupakan klaster topik yang paling dominan diatur di Kabupaten Puncak Jaya saat ini.`);
            }

            if (insights.length === 0) {
                container.innerHTML = `<p class="italic text-white/60">Tidak ada analisis anomali yang ditemukan untuk filter aktif saat ini.</p>`;
            } else {
                insights.forEach(insight => {
                    const p = document.createElement('p');
                    p.className = 'border-l-2 border-white/20 pl-3 py-1 bg-white/5 rounded-r-lg';
                    p.innerHTML = insight;
                    container.appendChild(p);
                });
            }
        }
    });
</script>
@endsection
