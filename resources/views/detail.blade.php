@extends('layouts.layout')

@section('title', $regulation->title . ' - Peraturan Puncak Jaya')

@section('content')
<!-- Premium Breadcrumbs & Navigation Bar -->
<div class="bg-white border-b border-slate-200 py-3.5 px-6 shadow-sm">
    <div class="max-w-[1280px] mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-2 text-xs text-slate-500 font-semibold overflow-hidden">
            <a href="{{ route('landing') }}" class="hover:text-primary transition shrink-0">Beranda</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-2.5 h-2.5 text-slate-350 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <a href="{{ route('search') }}" class="hover:text-primary transition shrink-0">Cari Peraturan</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-2.5 h-2.5 text-slate-350 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <span class="text-slate-800 font-extrabold truncate max-w-[200px] md:max-w-md">{{ $regulation->title }}</span>
        </div>
        
        <a href="{{ route('search') }}" class="inline-flex items-center gap-2 text-xs text-primary font-extrabold hover:text-primary-container transition bg-primary/5 hover:bg-primary/10 px-3.5 py-2 rounded-lg border border-primary/10 w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Pencarian
        </a>
    </div>
</div>

<!-- Main Body Wrapper -->
<div class="bg-[#f8fafc] min-h-screen pb-20 relative">
    <div class="max-w-[1280px] mx-auto px-6 py-8 space-y-8">
        
        <!-- Two-Column Grid for Details and Document Preview -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT PANEL (5 cols): Title, Abstract, and Metadata/Riwayat Tabs -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- BPK Style Header Card with Background Color -->
                <div class="bg-gradient-to-r from-[#0a1128] via-[#101f42] to-[#0a1128] border border-slate-800 text-white p-6 rounded-2xl shadow-md space-y-4 relative overflow-hidden">
                    <div class="absolute -right-16 -top-16 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                    
                    <div class="flex flex-wrap items-center gap-2.5 relative z-10">
                        <span class="bg-amber-500/10 text-amber-400 text-[9px] font-black uppercase tracking-wider px-2.5 py-1 rounded border border-amber-500/20 shadow-sm">
                            {{ $regulation->type }}
                        </span>
                        <span class="text-xs text-slate-300 font-bold bg-white/5 px-2.5 py-0.5 rounded border border-white/5">No. {{ $regulation->number }} Tahun {{ $regulation->year }}</span>
                        
                        @if($regulation->status === 'active')
                            <span class="inline-flex items-center gap-1 bg-emerald-500/15 text-emerald-400 text-[9px] font-extrabold uppercase tracking-wide px-2.5 py-0.5 rounded-full border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Berlaku
                            </span>
                        @elseif($regulation->status === 'amended')
                            <span class="inline-flex items-center gap-1 bg-amber-500/15 text-amber-400 text-[9px] font-extrabold uppercase tracking-wide px-2.5 py-0.5 rounded-full border border-amber-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                Diubah
                            </span>
                        @elseif($regulation->status === 'revoked')
                            <span class="inline-flex items-center gap-1 bg-rose-500/15 text-rose-400 text-[9px] font-extrabold uppercase tracking-wide px-2.5 py-0.5 rounded-full border border-rose-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                Dicabut
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-md md:text-lg font-extrabold text-white leading-relaxed font-display relative z-10">
                        {{ $regulation->title }}
                    </h1>
                </div>

                <!-- Abstract / Materi Pokok Peraturan Card (BPK Style) -->
                <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm space-y-4">
                    <h3 class="text-xs font-extrabold tracking-widest uppercase text-slate-800 border-b border-slate-100 pb-2.5">MATERI POKOK PERATURAN</h3>
                    <p class="text-xs text-slate-650 leading-relaxed whitespace-pre-line font-medium">
                        {{ $regulation->description ?: 'Tidak ada deskripsi abstrak untuk peraturan ini.' }}
                    </p>
                </div>

                <!-- Metadata & Riwayat Tab Component (BPK Style) -->
                <div class="space-y-4">
                    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-1 flex gap-1">
                        <button onclick="switchTab('metadata')" id="tab-btn-metadata" class="tab-btn flex-1 flex items-center justify-center gap-2 text-[10px] font-extrabold px-3 py-2 rounded-lg transition duration-300 cursor-pointer bg-primary text-white">
                            METADATA PERATURAN
                        </button>
                        <button onclick="switchTab('status')" id="tab-btn-status" class="tab-btn flex-1 flex items-center justify-center gap-2 text-[10px] font-extrabold px-3 py-2 rounded-lg transition duration-300 cursor-pointer text-slate-600 hover:bg-slate-50">
                            RIWAYAT PERKEMBANGAN
                        </button>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6">
                        <!-- TAB: METADATA -->
                        <div id="tab-content-metadata" class="tab-content space-y-4">
                            <div class="space-y-3">
                                <!-- Tipe Dokumen -->
                                <div class="flex items-start gap-3.5 pb-2.5 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Tipe Dokumen</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->document_type ?: 'PERATURAN PERUNDANG-UNDANGAN' }}</span>
                                    </div>
                                </div>

                                <!-- Bentuk Peraturan -->
                                <div class="flex items-start gap-3.5 pb-2.5 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-8.284 0-15-6.716-15-15V4.875C-3 4.254-2.496 3.75-1.875 3.75H13.5M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Bentuk Peraturan</span>
                                        <span class="text-xs font-semibold text-primary">{{ $regulation->type }}</span>
                                    </div>
                                </div>

                                <!-- Nomor Peraturan -->
                                <div class="flex items-start gap-3.5 pb-2.5 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 6h15M9 3v18m6-18v18" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Nomor Peraturan</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->number }}</span>
                                    </div>
                                </div>

                                <!-- Tempat Terbit -->
                                <div class="flex items-start gap-3.5 pb-2.5 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Tempat Terbit</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->publishing_place ?: 'KAB. PUNCAK JAYA' }}</span>
                                    </div>
                                </div>

                                <!-- Tahun Terbit -->
                                <div class="flex items-start gap-3.5 pb-2.5 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Tahun Terbit</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->year }}</span>
                                    </div>
                                </div>

                                <!-- Tanggal Penetapan -->
                                <div class="flex items-start gap-3.5 pb-2.5 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Tanggal Penetapan</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ \Carbon\Carbon::parse($regulation->stipulation_date)->isoFormat('D MMMM Y') }}</span>
                                    </div>
                                </div>

                                <!-- Tanggal Pengundangan -->
                                <div class="flex items-start gap-3.5 pb-2.5 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-.75" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.5 21 9m0 0-7.5-7.5M21 9H9" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Tanggal Pengundangan</span>
                                        <span class="text-xs font-semibold text-slate-800">
                                            {{ $regulation->promulgation_date ? \Carbon\Carbon::parse($regulation->promulgation_date)->isoFormat('D MMMM Y') : 'Belum Diundangkan' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Bidang Hukum -->
                                <div class="flex items-start gap-3.5 pb-2.5 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18m-9-9 9 9-9 9-9-9 9-9Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Bidang Hukum</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->law_field ?: 'Tidak Tersedia' }}</span>
                                    </div>
                                </div>

                                <!-- Urusan Pemerintahan -->
                                <div class="flex items-start gap-3.5 pb-2.5 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.33l-7.5-5-7.5 5V21m3.75-6.75h7.5V21H7.5v-6.75Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Urusan Pemerintahan</span>
                                        <span class="text-xs font-semibold text-slate-800 leading-relaxed">{{ $regulation->gov_affairs ?: 'Tidak Tersedia' }}</span>
                                    </div>
                                </div>

                                <!-- TEU -->
                                <div class="flex items-start gap-3.5 pb-2.5 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">T.E.U. (Tajuk Entri Utama)</span>
                                        <span class="text-xs font-semibold text-slate-800">{{ $regulation->teu ?: 'Tidak Tersedia' }}</span>
                                    </div>
                                </div>

                                <!-- Kata Kunci -->
                                <div class="flex items-start gap-3.5">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a1.5 1.5 0 0 0 2.122 0l4.318-4.318a1.5 1.5 0 0 0 0-2.122L11.16 3.659A2.25 2.25 0 0 0 9.568 3Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h.008v.008H6V7.5Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-1">Kata Kunci / Subjek</span>
                                        <div class="flex flex-wrap gap-1">
                                            @if($regulation->subject)
                                                @foreach(explode(',', $regulation->subject) as $tag)
                                                    <span class="bg-slate-100 text-slate-650 text-[9px] font-bold uppercase px-2 py-0.5 rounded border border-slate-200">{{ trim($tag) }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-slate-400 text-xs italic">Tidak Tersedia</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB: RIWAYAT -->
                        <div id="tab-content-status" class="tab-content hidden space-y-4">
                            <div class="border-b border-slate-100 pb-3">
                                <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">Perkembangan Dokumen</h3>
                            </div>

                            @if(count($timeline) > 1)
                                <div class="relative pl-6 border-l-2 border-slate-200 space-y-6">
                                    @foreach($timeline as $node)
                                        <div class="relative">
                                            @if($node['is_current'])
                                                <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-[3.5px] border-primary bg-white ring-4 ring-primary/10"></div>
                                            @else
                                                <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-2 border-slate-300 bg-white"></div>
                                            @endif

                                            <div class="space-y-1 bg-slate-50/50 hover:bg-slate-50 border border-slate-150 p-3.5 rounded-2xl transition duration-300">
                                                <div class="flex items-center justify-between gap-3">
                                                    <span class="text-[10px] font-bold text-slate-400">Tahun {{ \Carbon\Carbon::parse($node['date'])->format('Y') }}</span>
                                                    @if(isset($node['relation_type']))
                                                        <span class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-secondary/15 text-secondary">
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
                                                        <span class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-primary/10 text-primary">Regulasi Ini</span>
                                                    @endif
                                                </div>
                                                <a href="{{ route('detail', $node['id']) }}" class="text-xs font-bold block hover:underline hover:text-primary transition-all {{ $node['is_current'] ? 'text-primary' : 'text-slate-800' }}">
                                                    {{ $node['title'] }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-10 border border-dashed border-slate-200 rounded-2xl text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="w-10 h-10 mx-auto text-slate-300 mb-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <p class="text-xs font-bold text-slate-700">Tidak ada riwayat keterkaitan.</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">Produk hukum ini berdiri sendiri.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT PANEL (7 cols, sticky): FILE-FILE PERATURAN -->
            <div class="lg:col-span-7 lg:sticky lg:top-6 space-y-4">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden flex flex-col">
                    
                    <!-- Native PDF Tab Header (BPK Style) -->
                    <div class="bg-slate-50 border-b border-slate-200 px-5 py-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <h3 class="text-xs font-extrabold tracking-widest uppercase text-slate-800">FILE-FILE PERATURAN</h3>
                        </div>

                        @if($regulation->file_path)
                            <div class="flex items-center gap-2.5">
                                <span class="text-[9px] font-black uppercase text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    VALID & SAH
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Preview and Action Container -->
                    <div class="p-5 bg-slate-50/40 space-y-4">
                        @if($regulation->file_path)
                            <div class="w-full h-[460px] lg:h-[calc(100vh-270px)] border border-slate-200 rounded-2xl overflow-hidden bg-slate-100 relative shadow-inner">
                                <iframe src="{{ asset('storage/' . $regulation->file_path) }}" class="w-full h-full" frameborder="0"></iframe>
                            </div>
                            
                            <!-- Download PDF action -->
                            <a href="{{ route('regulation.download', $regulation->id) }}" target="_blank" class="w-full bg-primary hover:bg-primary-container text-white text-xs font-black uppercase tracking-wider py-4 rounded-2xl flex items-center justify-center gap-2.5 shadow-lg shadow-primary/10 transition-all duration-300 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Unduh Salinan Berkas PDF
                            </a>
                            <p class="text-[10px] text-center text-slate-500 font-medium pt-1">
                                Telah diunduh sebanyak <span class="text-primary font-bold">{{ number_format($regulation->download_count ?? 0) }} kali</span> & dilihat <span class="text-primary font-bold">{{ number_format($regulation->view_count ?? 0) }} kali</span>
                            </p>
                        @else
                            <div class="text-center py-28 bg-white border border-dashed border-slate-200 rounded-2xl text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="w-14 h-14 mx-auto text-slate-200 mb-3 animate-pulse">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                <p class="text-xs font-semibold text-slate-700">Salinan dokumen PDF belum diunggah.</p>
                                <p class="text-[10px] text-slate-400 mt-1">Unggah dokumen resmi dari dashboard admin.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- BOTTOM PANEL: STATUS PERATURAN (BPK style relation lists) -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 rounded-3xl shadow-sm space-y-5">
            <div class="border-b border-slate-150 pb-3">
                <h3 class="text-xs font-extrabold tracking-widest uppercase text-slate-800">STATUS PERATURAN</h3>
            </div>

            <div class="space-y-4">
                @php
                    $relations = array_filter($timeline, function($node) {
                        return isset($node['relation_type']);
                    });
                @endphp

                @if(count($relations) > 0)
                    <div class="space-y-3.5">
                        @php $counter = 1; @endphp
                        @foreach($relations as $rel)
                            <div class="flex items-start gap-4 text-xs">
                                <span class="font-extrabold text-slate-800 py-1">{{ $counter++ }}.</span>
                                <div class="space-y-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded bg-slate-100 text-slate-650 border border-slate-200">
                                            @if($rel['relation_type'] === 'amends')
                                                Mengubah
                                            @elseif($rel['relation_type'] === 'amended_by')
                                                Diubah Oleh
                                            @elseif($rel['relation_type'] === 'revokes')
                                                Mencabut
                                            @elseif($rel['relation_type'] === 'revoked_by')
                                                Dicabut Oleh
                                            @endif
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-bold">Tahun {{ \Carbon\Carbon::parse($rel['date'])->format('Y') }}</span>
                                    </div>
                                    <a href="{{ route('detail', $rel['id']) }}" class="font-bold text-slate-800 hover:text-primary hover:underline leading-relaxed block">
                                        {{ $rel['title'] }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 bg-slate-50/50 border border-slate-150 rounded-2xl text-slate-400">
                        <p class="text-xs font-semibold text-slate-700">Peraturan ini tidak memiliki hubungan hukum langsung.</p>
                        <p class="text-[9px] text-slate-400 mt-0.5">Dokumen ini bersifat mandiri dan belum tercatat diubah atau dicabut oleh peraturan lain.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(function(content) {
            content.classList.add('hidden');
        });
        
        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            btn.classList.remove('bg-primary', 'text-white');
            btn.classList.add('text-slate-650', 'hover:bg-slate-50');
        });
        
        document.getElementById('tab-content-' + tabId).classList.remove('hidden');
        
        var activeBtn = document.getElementById('tab-btn-' + tabId);
        activeBtn.classList.add('bg-primary', 'text-white');
        activeBtn.classList.remove('text-slate-650', 'hover:bg-slate-50');
    }
</script>
@endsection
