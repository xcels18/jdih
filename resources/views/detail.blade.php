@extends('layouts.layout')

@section('title', $regulation->title . ' - Peraturan Puncak Jaya')

@section('content')
<!-- Custom Styles for Timeline & Scrollbars -->
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #E2E8F0;
        border-radius: 10px;
    }
    
    .timeline-line::before {
        content: '';
        position: absolute;
        left: 11px;
        top: 24px;
        bottom: -24px;
        width: 2px;
        background-color: #E2E8F0;
        z-index: 0;
    }
    .timeline-item:last-child .timeline-line::before {
        display: none;
    }
</style>

<!-- Main Wrapper (pt-16 for navbar padding) -->
<div class="flex max-w-[1280px] mx-auto w-full min-h-screen bg-bg-base">
    
    <!-- Left Sidebar: Filters & Quick Links (Hidden on mobile/tablet) -->
    <aside class="hidden lg:flex flex-col bg-white h-[calc(100vh-64px)] w-60 sticky top-16 border-r border-border-subtle flex-shrink-0 p-6">
        <div class="mb-8">
            <h2 class="font-headline-md text-md font-bold text-primary mb-1">Akses Cepat</h2>
            <p class="text-on-surface-variant text-[11px]">Navigasi dokumen hukum</p>
        </div>
        <nav class="flex-1 space-y-1.5 overflow-y-auto custom-scrollbar">
            <a href="{{ route('search') }}" class="flex items-center gap-3 p-3 text-xs font-bold text-on-surface-variant hover:bg-slate-50 hover:text-primary rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                </svg>
                Pencarian Peraturan
            </a>
            <a href="{{ route('search', ['type' => 'Peraturan Daerah (Perda) Kabupaten']) }}" class="flex items-center gap-3 p-3 text-xs font-bold text-on-surface-variant hover:bg-slate-50 hover:text-primary rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
                Perda Kabupaten
            </a>
            <a href="{{ route('search', ['type' => 'Peraturan Bupati (Perbup)']) }}" class="flex items-center gap-3 p-3 text-xs font-bold text-on-surface-variant hover:bg-slate-50 hover:text-primary rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-16.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-16.25v16.25" />
                </svg>
                Peraturan Bupati
            </a>
            <a href="{{ route('search', ['type' => 'Keputusan Bupati (Kepbup)']) }}" class="flex items-center gap-3 p-3 text-xs font-bold text-on-surface-variant hover:bg-slate-50 hover:text-primary rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12Z" />
                </svg>
                Keputusan Bupati
            </a>
        </nav>
        <div class="mt-auto pt-4 border-t border-slate-100">
            <a href="{{ route('landing') }}" class="w-full border border-border-subtle text-primary font-bold text-center block text-xs py-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 w-full flex flex-col xl:flex-row gap-6 p-6 min-w-0 overflow-hidden">
        
        <!-- Left Column: Main Doc Info, Tabs & PDF Reader -->
        <div class="flex-1 min-w-0 flex flex-col gap-6">
            
            <!-- Document Header Card (Stitch Style) -->
            <section class="bg-white rounded-2xl border border-border-subtle p-6 relative overflow-hidden shadow-sm">
                <!-- Subtle background decoration -->
                <div class="absolute top-0 right-0 w-44 h-44 bg-primary/5 rounded-bl-full -z-0"></div>
                
                <div class="relative z-10 flex flex-col gap-4">
                    <div>
                        <!-- Status Badge -->
                        @if($regulation->status === 'active')
                            <div class="inline-flex items-center gap-1.5 bg-status-active/10 text-status-active px-3 py-1 rounded-md font-bold text-[10px] tracking-wider uppercase mb-3 border border-status-active/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-active"></span>
                                Berlaku
                            </div>
                        @elseif($regulation->status === 'amended')
                            <div class="inline-flex items-center gap-1.5 bg-status-amended/10 text-status-amended px-3 py-1 rounded-md font-bold text-[10px] tracking-wider uppercase mb-3 border border-status-amended/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-amended"></span>
                                Diubah
                            </div>
                        @elseif($regulation->status === 'revoked')
                            <div class="inline-flex items-center gap-1.5 bg-status-revoked/10 text-status-revoked px-3 py-1 rounded-md font-bold text-[10px] tracking-wider uppercase mb-3 border border-status-revoked/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-revoked"></span>
                                Dicabut
                            </div>
                        @endif
                        
                        <h1 class="text-lg md:text-xl font-extrabold text-on-surface leading-snug font-display max-w-3xl">{{ $regulation->title }}</h1>
                        <p class="text-xs text-on-surface-variant font-medium mt-1.5">Bentuk Peraturan: <span class="text-primary font-bold">{{ $regulation->type }}</span> • No. {{ $regulation->number }} Tahun {{ $regulation->year }}</p>
                    </div>

                    <!-- Action Bar -->
                    <div class="flex flex-wrap items-center gap-2.5 mt-2 pt-4 border-t border-slate-100">
                        @if($regulation->file_path)
                            <a href="{{ route('regulation.download', $regulation->id) }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-container text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:opacity-95 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Unduh PDF
                            </a>
                            <a href="{{ asset('storage/' . $regulation->file_path) }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-secondary hover:bg-secondary/90 text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:opacity-95 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                Pratinjau PDF
                            </a>
                        @endif
                        <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 bg-white border border-border-subtle text-on-surface text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-slate-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.844 2.44 9.564a2.25 2.25 0 0 1 0-3.18l4.28-4.28a2.25 2.25 0 0 1 3.18 0l4.28 4.28a2.25 2.25 0 0 1 0 3.18l-4.28 4.28a2.25 2.25 0 0 1-3.18 0ZM19.5 12a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            Cetak
                        </button>
                        <button onclick="navigator.clipboard.writeText('{{ $regulation->title }}')" class="inline-flex items-center justify-center gap-2 bg-white border border-border-subtle text-on-surface text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-slate-50 transition-colors md:ml-auto">
                            Salin Judul
                        </button>
                    </div>
                </div>
            </section>

            <!-- Content & Tabs Area (Bento Layout) -->
            <section class="bg-white rounded-2xl border border-border-subtle shadow-sm flex flex-col min-h-[600px] overflow-hidden">
                <!-- Tabs Navigation -->
                <div class="border-b border-border-subtle px-4 overflow-x-auto custom-scrollbar flex-shrink-0 bg-slate-50/50">
                    <nav class="flex items-center gap-6 min-w-max">
                        <button onclick="switchDetailTab('ringkasan')" id="tab-btn-ringkasan" class="tab-btn-item py-4 text-xs font-bold text-primary border-b-2 border-primary transition-all">
                            Ringkasan Peraturan
                        </button>
                        <button onclick="switchDetailTab('isi')" id="tab-btn-isi" class="tab-btn-item py-4 text-xs font-bold text-on-surface-variant hover:text-primary border-b-2 border-transparent transition-all">
                            Isi / Berkas PDF
                        </button>
                        <button onclick="switchDetailTab('riwayat')" id="tab-btn-riwayat" class="tab-btn-item py-4 text-xs font-bold text-on-surface-variant hover:text-primary border-b-2 border-transparent transition-all">
                            Riwayat Perubahan
                        </button>
                    </nav>
                </div>

                <!-- Tab Content Layout -->
                <div class="flex-grow flex flex-col lg:flex-row overflow-hidden">
                    
                    <!-- Main Reading Canvas -->
                    <div class="flex-grow p-6 md:p-8 overflow-y-auto custom-scrollbar">
                        
                        <!-- TAB 1: RINGKASAN & METADATA -->
                        <div id="tab-detail-ringkasan" class="tab-detail-content space-y-6">
                            <div>
                                <h3 class="font-headline-md text-[16px] font-bold text-on-surface mb-3 border-b border-slate-100 pb-2">Abstrak / Ringkasan Eksekutif</h3>
                                <p class="text-xs text-on-surface-variant leading-relaxed font-medium whitespace-pre-line bg-slate-50/60 p-4 rounded-xl border border-slate-100">
                                    {{ $regulation->description ?: 'Abstrak atau deskripsi materi pokok peraturan ini belum diunggah.' }}
                                </p>
                            </div>
                            
                            <!-- Complete Metadata Grid -->
                            <div>
                                <h3 class="font-headline-md text-[16px] font-bold text-on-surface mb-3 border-b border-slate-100 pb-2">Identitas & Metadata Lengkap</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase block mb-0.5">Tipe Dokumen</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->document_type ?: 'PERATURAN PERUNDANG-UNDANGAN' }}</span>
                                    </div>
                                    <div class="border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase block mb-0.5">Bentuk Peraturan</span>
                                        <span class="text-xs font-semibold text-primary">{{ $regulation->type }}</span>
                                    </div>
                                    <div class="border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase block mb-0.5">Nomor Peraturan</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->number }}</span>
                                    </div>
                                    <div class="border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase block mb-0.5">Tahun Terbit</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->year }}</span>
                                    </div>
                                    <div class="border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase block mb-0.5">Tanggal Ditetapkan</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ \Carbon\Carbon::parse($regulation->stipulation_date)->isoFormat('D MMMM Y') }}</span>
                                    </div>
                                    <div class="border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase block mb-0.5">Tanggal Diundangkan</span>
                                        <span class="text-xs font-semibold text-slate-800">
                                            {{ $regulation->promulgation_date ? \Carbon\Carbon::parse($regulation->promulgation_date)->isoFormat('D MMMM Y') : 'Belum Diundangkan' }}
                                        </span>
                                    </div>
                                    <div class="border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase block mb-0.5">Tajuk Entri Utama (T.E.U.)</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->teu ?: 'Bupati Puncak Jaya' }}</span>
                                    </div>
                                    <div class="border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase block mb-0.5">Tempat Terbit</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->publishing_place ?: 'KABUPATEN PUNCAK JAYA' }}</span>
                                    </div>
                                    <div class="border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase block mb-0.5">Bidang Hukum</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->law_field ?: 'Tidak Tersedia' }}</span>
                                    </div>
                                    <div class="border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase block mb-0.5">Urusan Pemerintahan</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->gov_affairs ?: 'Tidak Tersedia' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: ISI PDF -->
                        <div id="tab-detail-isi" class="tab-detail-content hidden space-y-4">
                            @if($regulation->file_path)
                                <div class="w-full h-[550px] border border-slate-200 rounded-xl overflow-hidden bg-slate-100 shadow-inner">
                                    <iframe src="{{ asset('storage/' . $regulation->file_path) }}" class="w-full h-full" frameborder="0"></iframe>
                                </div>
                                <p class="text-[10px] text-center text-slate-450 font-medium">
                                    Dokumen ini dibaca sebanyak <span class="text-primary font-bold">{{ $regulation->view_count }} kali</span> dan diunduh <span class="text-primary font-bold">{{ $regulation->download_count }} kali</span>.
                                </p>
                            @else
                                <div class="text-center py-20 bg-slate-50 border border-dashed border-slate-200 rounded-xl text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="w-12 h-12 mx-auto text-slate-300 mb-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12" />
                                    </svg>
                                    <p class="text-xs font-bold text-slate-700">Salinan dokumen PDF belum diunggah.</p>
                                    <p class="text-[10px] text-slate-400 mt-1">Gunakan panel admin untuk melakukan unggah berkas resmi.</p>
                                </div>
                            @endif
                        </div>

                        <!-- TAB 4: RIWAYAT PERUBAHAN -->
                        <div id="tab-detail-riwayat" class="tab-detail-content hidden">
                            <h3 class="font-headline-md text-[16px] font-bold text-on-surface mb-4 border-b border-slate-100 pb-2">Riwayat Perkembangan</h3>
                            
                            @if(count($timeline) > 1)
                                <div class="relative pl-6 border-l-2 border-slate-200 space-y-6">
                                    @foreach($timeline as $node)
                                        <div class="relative">
                                            @if($node['is_current'])
                                                <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-[3.5px] border-primary bg-white ring-4 ring-primary/10"></div>
                                            @else
                                                <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-2 border-slate-300 bg-white"></div>
                                            @endif

                                            <div class="space-y-1 bg-slate-50/50 p-3 rounded-xl border border-slate-100">
                                                <div class="flex items-center justify-between gap-3">
                                                    <span class="text-[9px] font-bold text-slate-450">Tahun {{ \Carbon\Carbon::parse($node['date'])->format('Y') }}</span>
                                                    @if(isset($node['relation_type']))
                                                        <span class="text-[8px] font-extrabold uppercase px-2 py-0.5 rounded bg-secondary/10 text-secondary">
                                                            @if($node['relation_type'] === 'amends')
                                                                Mengubah
                                                            @elseif($node['relation_type'] === 'amended_by')
                                                                Diubah Oleh
                                                            @elseif($node['relation_type'] === 'revokes')
                                                                Mencabut
                                                            @elseif($node['relation_type'] === 'revoked_by')
                                                                Dicabut Oleh
                                                            @endif
                                                        </span>
                                                    @elseif($node['is_current'])
                                                        <span class="text-[8px] font-extrabold uppercase px-2 py-0.5 rounded bg-primary/10 text-primary">Regulasi Ini</span>
                                                    @endif
                                                </div>
                                                <a href="{{ route('detail', $node['id']) }}" class="text-xs font-bold block hover:text-primary transition {{ $node['is_current'] ? 'text-primary' : 'text-slate-800' }}">
                                                    {{ $node['title'] }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-10 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-slate-450">
                                    <p class="text-xs font-semibold text-slate-700">Tidak ada riwayat keterkaitan.</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">Produk hukum ini bersifat mandiri.</p>
                                </div>
                            @endif
                        </div>

                    </div>

                </div>
            </section>
        </div>

        <!-- Right Column: Quick Metadata & Lifecycle Timeline -->
        <aside class="w-full xl:w-72 flex flex-col gap-6 flex-shrink-0">
            <!-- Metadata Summary Card -->
            <div class="bg-white rounded-2xl border border-border-subtle p-5 shadow-sm space-y-4">
                <h3 class="font-headline-md text-sm font-bold text-on-surface">Fakta Singkat</h3>
                <dl class="flex flex-col gap-2.5 text-xs">
                    <div class="flex flex-col border-b border-slate-100 pb-2">
                        <dt class="text-slate-400 font-medium mb-0.5">Jenis Peraturan</dt>
                        <dd class="text-slate-800 font-bold">{{ $regulation->type }}</dd>
                    </div>
                    <div class="flex flex-col border-b border-slate-100 pb-2">
                        <dt class="text-slate-400 font-medium mb-0.5">Nomor / Tahun</dt>
                        <dd class="text-slate-800 font-bold">{{ $regulation->number }} / {{ $regulation->year }}</dd>
                    </div>
                    <div class="flex flex-col border-b border-slate-100 pb-2">
                        <dt class="text-slate-400 font-medium mb-0.5">Tanggal Ditetapkan</dt>
                        <dd class="text-slate-800 font-bold">{{ \Carbon\Carbon::parse($regulation->stipulation_date)->isoFormat('D MMM Y') }}</dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="text-slate-400 font-medium mb-0.5">Subjek / Kata Kunci</dt>
                        <dd class="text-slate-800 font-bold truncate">{{ $regulation->subject ?: 'Pemerintahan' }}</dd>
                    </div>
                </dl>
                <button onclick="switchDetailTab('metadata')" class="w-full text-center text-primary text-xs font-bold hover:underline">
                    Lihat Metadata Lengkap →
                </button>
            </div>

            <!-- Lifecycle Timeline Card -->
            <div class="bg-white rounded-2xl border border-border-subtle p-5 shadow-sm space-y-4">
                <h3 class="font-headline-md text-sm font-bold text-on-surface">Lifecycle Peraturan</h3>
                <div class="relative pl-3 mt-4">
                    
                    <!-- Ditetapkan Timeline Node -->
                    <div class="timeline-item relative mb-6 timeline-line">
                        <div class="absolute -left-[27px] top-1 w-6 h-6 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center z-10">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        </div>
                        <div class="pl-2">
                            <div class="text-[10px] text-slate-400 font-medium mb-0.5">{{ \Carbon\Carbon::parse($regulation->stipulation_date)->isoFormat('D MMM Y') }}</div>
                            <div class="text-xs text-slate-800 font-bold">Ditetapkan</div>
                            <div class="text-[10px] text-slate-500 mt-0.5">Dokumen hukum resmi disahkan.</div>
                        </div>
                    </div>

                    <!-- Hubungan Hukum Node (if amended/revoked) -->
                    @php
                        $directRelations = array_filter($timeline, function($node) {
                            return isset($node['relation_type']);
                        });
                    @endphp

                    @foreach($directRelations as $node)
                        <div class="timeline-item relative mb-6 timeline-line">
                            <div class="absolute -left-[27px] top-1 w-6 h-6 rounded-full border-2 border-white bg-status-amended/10 flex items-center justify-center z-10">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-amended"></span>
                            </div>
                            <div class="pl-2">
                                <div class="text-[10px] text-status-amended font-medium mb-0.5">{{ \Carbon\Carbon::parse($node['date'])->isoFormat('D MMM Y') }}</div>
                                <div class="text-xs text-slate-800 font-bold">
                                    @if($node['relation_type'] === 'amends')
                                        Mengubah
                                    @elseif($node['relation_type'] === 'amended_by')
                                        Diubah Oleh
                                    @elseif($node['relation_type'] === 'revokes')
                                        Mencabut
                                    @elseif($node['relation_type'] === 'revoked_by')
                                        Dicabut Oleh
                                    @endif
                                </div>
                                <a href="{{ route('detail', $node['id']) }}" class="text-[10px] text-primary hover:underline font-medium block mt-1 line-clamp-2">
                                    {{ $node['title'] }}
                                </a>
                            </div>
                        </div>
                    @endforeach

                    <!-- Current State Node -->
                    <div class="timeline-item relative">
                        @if($regulation->status === 'active')
                            <div class="absolute -left-[27px] top-1 w-6 h-6 rounded-full border-2 border-white bg-status-active flex items-center justify-center z-10 shadow-[0_0_0_3px_rgba(20,184,166,0.15)]">
                                <span class="w-2 h-2 rounded-full bg-white"></span>
                            </div>
                            <div class="pl-2">
                                <div class="text-[10px] text-status-active font-medium mb-0.5">Saat Ini</div>
                                <div class="text-xs text-slate-800 font-bold">Status: Aktif / Berlaku</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">Berlaku sah di Kabupaten Puncak Jaya.</div>
                            </div>
                        @elseif($regulation->status === 'amended')
                            <div class="absolute -left-[27px] top-1 w-6 h-6 rounded-full border-2 border-white bg-status-amended flex items-center justify-center z-10 shadow-[0_0_0_3px_rgba(245,158,11,0.15)]">
                                <span class="w-2 h-2 rounded-full bg-white"></span>
                            </div>
                            <div class="pl-2">
                                <div class="text-[10px] text-status-amended font-medium mb-0.5">Saat Ini</div>
                                <div class="text-xs text-slate-800 font-bold">Status: Diubah</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">Regulasi ini telah mengalami perubahan ketentuan.</div>
                            </div>
                        @elseif($regulation->status === 'revoked')
                            <div class="absolute -left-[27px] top-1 w-6 h-6 rounded-full border-2 border-white bg-status-revoked flex items-center justify-center z-10 shadow-[0_0_0_3px_rgba(225,29,72,0.15)]">
                                <span class="w-2 h-2 rounded-full bg-white"></span>
                            </div>
                            <div class="pl-2">
                                <div class="text-[10px] text-status-revoked font-medium mb-0.5">Saat Ini</div>
                                <div class="text-xs text-slate-800 font-bold">Status: Dicabut / Tidak Berlaku</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">Ketentuan hukum sudah tidak mengikat.</div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </aside>

    </main>
</div>

<script>
    // Tab switching logic (Stitch Style)
    function switchDetailTab(tabId) {
        document.querySelectorAll('.tab-detail-content').forEach(function(content) {
            content.classList.add('hidden');
        });
        
        document.querySelectorAll('.tab-btn-item').forEach(function(btn) {
            btn.classList.remove('text-primary', 'border-primary');
            btn.classList.add('text-on-surface-variant', 'border-transparent');
        });
        
        document.getElementById('tab-detail-' + tabId).classList.remove('hidden');
        
        var activeBtn = document.getElementById('tab-btn-' + tabId);
        activeBtn.classList.add('text-primary', 'border-primary');
        activeBtn.classList.remove('text-on-surface-variant', 'border-transparent');
    }
</script>
@endsection
