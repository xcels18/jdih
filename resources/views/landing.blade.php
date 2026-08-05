@extends('layouts.layout')

@section('title', 'Beranda - JDIH Puncak Jaya')

@section('content')
<!-- Immersive Hero Section with Sunset Monument Backdrop -->
<section class="relative min-h-[80vh] flex items-center justify-center pt-16 pb-24 overflow-hidden bg-cover bg-center" style="background-image: linear-gradient(180deg, rgba(15, 23, 42, 0.35) 0%, rgba(15, 23, 42, 0.85) 100%), url('{{ asset('images/puncak_jaya_backdrop.jpg') }}');">
    <!-- Subtle overlay glow -->
    <div class="absolute inset-0 bg-gradient-to-t from-[#f8f9fa] to-transparent pointer-events-none opacity-20"></div>

    <!-- Floating Background Glowing Orbs -->
    <div class="absolute top-1/4 left-1/10 w-96 h-96 rounded-full bg-primary/15 blur-[120px] pointer-events-none z-0"></div>
    <div class="absolute bottom-1/4 right-1/10 w-96 h-96 rounded-full bg-secondary/15 blur-[120px] pointer-events-none z-0"></div>

    <div class="max-w-[1000px] w-full mx-auto px-6 text-center z-10 space-y-8">
        <div class="animate-float inline-block">
            <span class="text-xs font-bold uppercase tracking-widest bg-white/10 backdrop-blur-md py-2 px-5 rounded-full border border-white/20 inline-block shadow-lg text-white">
                ✨ PORTAL HUKUM INTEGRASI KAB. PUNCAK JAYA
            </span>
        </div>
        
        <h2 class="text-4xl md:text-6xl font-black font-display tracking-tight leading-none text-gradient max-w-4xl mx-auto">
            Temukan Peraturan dengan <span class="text-primary bg-primary-fixed/30 px-3 rounded-md">Cepat</span> dan Akurat
        </h2>
        
        <p class="text-base md:text-xl text-white/85 leading-relaxed max-w-2xl mx-auto font-light">
            Portal resmi JDIH untuk pencarian, pembacaan, dan pengunduhan berbagai produk hukum nasional dan daerah di Kabupaten Puncak Jaya, Papua.
        </p>

        <!-- Sophisticated Search Bar (Stitch Specification) -->
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('search') }}" method="GET" class="w-full">
                <div class="w-full glass-panel rounded-2xl shadow-[0_20px_40px_-15px_rgba(30,64,175,0.25)] border border-white/60 p-2.5 flex items-center relative transition-all focus-within:ring-2 focus-within:ring-primary focus-within:ring-offset-4 focus-within:bg-white/95">
                    <span class="text-primary ml-4 mr-3 text-3xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                        </svg>
                    </span>
                    <input type="text" id="landing-search" name="q" class="w-full bg-transparent border-none focus:ring-0 font-body-lg text-body-lg text-on-surface placeholder:text-outline p-4 text-sm font-semibold focus:outline-none" placeholder="Cari berdasarkan judul, nomor, tahun, instansi..."/>
                    
                    <div class="hidden md:flex items-center gap-1.5 text-on-surface-variant font-semibold text-xs bg-bg-base border border-border-subtle px-2.5 py-1.5 rounded-md mr-3 select-none">
                        <span>Tekan</span>
                        <kbd class="font-mono bg-white px-1.5 rounded border border-border-subtle shadow-sm font-black text-[11px] cursor-pointer">/</kbd>
                    </div>
                    
                    <button type="submit" class="bg-primary text-white px-8 py-4 rounded-xl font-label-md text-label-md hover:bg-primary-container transition-all shadow-md hover:shadow-lg ml-2 whitespace-nowrap text-base font-bold cursor-pointer">
                        Cari
                    </button>
                </div>
            </form>
            
            <!-- Popular Searches Tags -->
            <div class="mt-6 flex flex-wrap justify-center gap-3 items-center">
                <span class="text-[10px] font-bold text-white/50 uppercase tracking-widest bg-white/5 px-2.5 py-1 rounded">Pencarian Populer:</span>
                <a class="text-xs font-semibold text-white hover:text-primary hover:bg-white px-3.5 py-1 rounded-full border border-white/20 bg-white/5 transition-all" href="{{ route('search', ['q' => 'Keuangan Daerah']) }}">Keuangan Daerah</a>
                <a class="text-xs font-semibold text-white hover:text-primary hover:bg-white px-3.5 py-1 rounded-full border border-white/20 bg-white/5 transition-all" href="{{ route('search', ['q' => 'Ketertiban']) }}">Ketertiban Umum</a>
                <a class="text-xs font-semibold text-white hover:text-primary hover:bg-white px-3.5 py-1 rounded-full border border-white/20 bg-white/5 transition-all" href="{{ route('search', ['q' => 'RKPD']) }}">RKPD 2024</a>
            </div>
        </div>
    </div>
</section>

<!-- Bento Grid / Categories Section -->
<section class="max-w-[1280px] mx-auto px-6 py-24 relative z-10 -mt-20">
    <div class="text-center mb-16">
        <span class="text-xs font-bold uppercase tracking-wider text-secondary">EKSPLORASI PRODUK HUKUM</span>
        <h3 class="text-2xl md:text-4xl font-extrabold font-display text-primary mt-1">Jelajahi Produk Hukum</h3>
        <div class="w-16 h-1 bg-primary mx-auto mt-4 rounded-full"></div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Card 1: Peraturan Daerah -->
        <a href="{{ route('search', ['type' => 'Peraturan Daerah']) }}" class="bg-white border border-border-subtle rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(30,64,175,0.08)] hover:-translate-y-1 transition-all duration-300 group cursor-pointer flex flex-col justify-between min-h-[260px] interactive-transition card-glowing-primary">
            <div>
                <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:bg-primary group-hover:text-white text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                    </svg>
                </div>
                <h3 class="font-headline-md text-on-surface mb-3 text-xl font-bold font-display">Peraturan Daerah</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">Produk hukum tertinggi daerah yang ditetapkan oleh Bupati dengan persetujuan bersama DPRD.</p>
            </div>
            <div class="mt-6 flex items-center justify-between border-t border-border-subtle pt-4">
                <span class="text-[10px] font-bold text-primary bg-primary/5 px-3 py-1.5 rounded-full uppercase tracking-wider">{{ $stats['perda'] ?? 0 }} Dokumen</span>
                <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity -translate-x-4 group-hover:translate-x-0 duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </div>
        </a>

        <!-- Card 2: Peraturan Bupati -->
        <a href="{{ route('search', ['type' => 'Peraturan Bupati']) }}" class="bg-white border border-border-subtle rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(20,184,166,0.08)] hover:-translate-y-1 transition-all duration-300 group cursor-pointer flex flex-col justify-between min-h-[260px] interactive-transition card-glowing-primary">
            <div>
                <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:bg-primary group-hover:text-white text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-16.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-16.25v16.25" />
                    </svg>
                </div>
                <h3 class="font-headline-md text-on-surface mb-3 text-xl font-bold font-display">Peraturan Bupati</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">Ketentuan pelaksana yang dikeluarkan oleh Bupati untuk menjalankan urusan otonomi daerah.</p>
            </div>
            <div class="mt-6 flex items-center justify-between border-t border-border-subtle pt-4">
                <span class="text-[10px] font-bold text-primary bg-primary/5 px-3 py-1.5 rounded-full uppercase tracking-wider">{{ $stats['perbup'] ?? 0 }} Dokumen</span>
                <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity -translate-x-4 group-hover:translate-x-0 duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </div>
        </a>

        <!-- Card 3: Keputusan Bupati -->
        <a href="{{ route('search', ['type' => 'Keputusan Bupati']) }}" class="bg-white border border-border-subtle rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(49,107,243,0.08)] hover:-translate-y-1 transition-all duration-300 group cursor-pointer flex flex-col justify-between min-h-[260px] interactive-transition card-glowing-primary">
            <div>
                <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:bg-primary group-hover:text-white text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.375M9 18h3.375m-6.75 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H5.25a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3Zm3.15-11.777L9 6.75l2.25 2.25L9 11.25l2.25 2.25L9 15.75l2.25 2.25" />
                    </svg>
                </div>
                <h3 class="font-headline-md text-on-surface mb-3 text-xl font-bold font-display">Keputusan Bupati</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">Keputusan penetapan yang bersifat konkret, individual, dan sekali-selesai untuk instansi daerah.</p>
            </div>
            <div class="mt-6 flex items-center justify-between border-t border-border-subtle pt-4">
                <span class="text-[10px] font-bold text-primary bg-primary/5 px-3 py-1.5 rounded-full uppercase tracking-wider">{{ $stats['kepbup'] ?? 0 }} Dokumen</span>
                <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity -translate-x-4 group-hover:translate-x-0 duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </div>
        </a>

        <!-- Card 4 (Wide): Other Regulations (PERKADA, Instruksi, SE) -->
        <div class="md:col-span-2 bg-gradient-to-br from-white to-[#faf8ff] border border-border-subtle rounded-3xl p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg transition-all duration-300 flex items-center relative overflow-hidden group">
            <div class="z-10 w-2/3 relative space-y-4">
                <span class="text-[10px] font-extrabold text-status-active bg-status-active/10 px-3 py-1 rounded-full inline-block uppercase tracking-wider border border-status-active/20 font-sans">Koleksi Lengkap</span>
                <h3 class="font-headline-md text-on-surface text-2xl font-bold font-display leading-tight">PERKADA, Surat Edaran & Instruksi</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">Akses dokumen kebijakan pendukung lainnya termasuk Peraturan Kepala Daerah (PERKADA), Surat Edaran (SE) Bupati, Instruksi Bupati, dan Pengumuman Resmi.</p>
                <a class="bg-primary hover:bg-primary-container text-white px-6 py-3 rounded-xl font-label-md text-xs font-bold uppercase tracking-wider transition-all inline-flex items-center gap-2 shadow-md shadow-primary/20" href="{{ route('search') }}">
                    Lihat Koleksi 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
            <div class="absolute right-0 top-0 bottom-0 w-1/2 bg-gradient-to-l from-primary/5 to-transparent pointer-events-none"></div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="0.5" stroke="currentColor" class="absolute -right-8 -bottom-8 w-44 h-44 text-primary/5 group-hover:text-primary/10 transition-colors duration-500 transform -rotate-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
        </div>

        <!-- Card 5: Advanced Search & Analytics -->
        <a href="{{ route('stats') }}" class="bg-white border border-border-subtle rounded-3xl p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg transition-all duration-300 flex flex-col justify-center items-center text-center group interactive-transition card-glowing-primary">
            <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 group-hover:bg-primary group-hover:text-white text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                </svg>
            </div>
            <h3 class="font-headline-md text-on-surface mb-2 text-xl font-bold font-display">Statistik & Tren</h3>
            <p class="text-xs text-on-surface-variant mb-6">Visualisasikan sebaran tren regulasi secara digital.</p>
            <button class="border-2 border-primary/20 text-primary px-6 py-2.5 rounded-lg font-label-md text-xs font-bold uppercase tracking-wider hover:bg-primary/5 hover:border-primary transition-all w-full cursor-pointer">
                Buka Analitik
            </button>
        </a>
    </div>
</section>

<!-- Trust Indicators Count Statistics Section (Stitch Specification) -->
<section class="bg-white border-y border-border-subtle py-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-primary/5"></div>
    <div class="max-w-[1280px] mx-auto px-6 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 text-center divide-y md:divide-y-0 md:divide-x divide-border-subtle/50">
            <div class="px-4">
                <h4 class="text-4xl font-black font-display text-primary mb-2 drop-shadow-sm">{{ $stats['total'] }}+</h4>
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Dokumen Hukum</p>
            </div>
            <div class="px-4 pt-6 md:pt-0">
                <h4 class="text-4xl font-black font-display text-secondary mb-2 drop-shadow-sm">Aktif</h4>
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Diperbarui Setiap Hari</p>
            </div>
            <div class="px-4 pt-6 md:pt-0">
                <h4 class="text-4xl font-black font-display text-primary mb-2 drop-shadow-sm">100%</h4>
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Sumber Resmi Pemkab</p>
            </div>
            <div class="px-4 pt-6 md:pt-0">
                <h4 class="text-4xl font-black font-display text-secondary mb-2 drop-shadow-sm">2M+</h4>
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Pencarian Terpadu</p>
            </div>
        </div>
    </div>
</section>

<!-- Latest Publications & Side Cards Section -->
<section class="max-w-[1280px] mx-auto px-6 py-24 grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Left Column: Recent Updates -->
    <div class="lg:col-span-2 space-y-8">
        <div class="flex items-center justify-between">
            <h3 class="text-xl md:text-2xl font-bold font-display text-primary flex items-center gap-2.5">
                <span class="w-2 h-7 bg-primary rounded-full"></span>
                Pembaruan Regulasi Terkini
            </h3>
            <a href="{{ route('search') }}" class="text-xs font-bold uppercase tracking-wider text-secondary hover:text-secondary/80 flex items-center gap-1.5 transition">
                Semua Regulasi
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        <div class="space-y-6">
            @forelse($recentRegulations as $reg)
                <div class="bg-white border border-border-subtle p-6 rounded-2xl soft-shadow interactive-transition hover:border-primary/20 hover:shadow-xl hover:shadow-primary/5 flex flex-col gap-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <span class="bg-primary/5 text-primary text-xs font-extrabold uppercase tracking-wider px-3 py-1 rounded-md">
                            {{ $reg->type }}
                        </span>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-on-surface-variant font-semibold">No. {{ $reg->number }} Tahun {{ $reg->year }}</span>
                            @if($reg->status === 'active')
                                <span class="bg-status-active/10 text-status-active text-[10px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full">Berlaku</span>
                            @elseif($reg->status === 'amended')
                                <span class="bg-status-amended/10 text-status-amended text-[10px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full">Diubah</span>
                            @elseif($reg->status === 'revoked')
                                <span class="bg-status-revoked/10 text-status-revoked text-[10px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full">Dicabut</span>
                            @endif
                        </div>
                    </div>
                    
                    <a href="{{ route('detail', $reg->id) }}" class="text-md font-bold font-display leading-snug hover:text-primary transition-all duration-300">
                        {{ $reg->title }}
                    </a>
                    
                    <p class="text-xs text-on-surface-variant/80 line-clamp-2 leading-relaxed">
                        {{ $reg->description ?: 'Tidak ada deskripsi abstrak untuk peraturan ini.' }}
                    </p>
                    
                    <div class="flex items-center justify-between border-t border-border-subtle pt-4 text-xs text-on-surface-variant">
                        <span>Ditetapkan: {{ \Carbon\Carbon::parse($reg->stipulation_date)->isoFormat('D MMMM Y') }}</span>
                        <a href="{{ route('detail', $reg->id) }}" class="font-bold text-secondary hover:text-secondary/80 flex items-center gap-1 transition">
                            Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-2xl border border-border-subtle text-on-surface-variant/60">
                    Belum ada regulasi yang dimasukkan ke dalam sistem.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Right Column: Visual Side Cards -->
    <div class="space-y-8">
        <!-- Advanced Statistics Info Card -->
        <div class="bg-white border border-border-subtle p-8 rounded-2xl soft-shadow relative overflow-hidden group interactive-transition card-glowing-primary">
            <div class="absolute -right-16 -top-16 w-36 h-36 rounded-full bg-primary/5 group-hover:scale-110 transition-all duration-500"></div>
            
            <h4 class="text-[10px] font-black tracking-widest uppercase text-on-surface-variant mb-3 font-display">Informasi Dashboard</h4>
            <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">
                Lihat visualisasi dan analisis interaktif data produk hukum daerah di Kabupaten Puncak Jaya melalui diagram.
            </p>
            <a href="{{ route('stats') }}" class="block text-center bg-primary hover:bg-primary-container text-white text-xs font-bold uppercase tracking-wider py-3.5 rounded-xl transition-all shadow-md shadow-primary/20">
                Buka Diagram Analitik
            </a>
        </div>

        <!-- JDIH Guidelines -->
        <div class="bg-gradient-to-br from-primary to-primary-container text-white p-8 rounded-2xl soft-shadow relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-32 h-32 rounded-full bg-white/5"></div>
            
            <h4 class="text-[10px] font-black tracking-widest uppercase text-white/50 mb-4 font-display">Tugas & Fungsi JDIH</h4>
            <p class="text-xs text-white/90 mb-6 leading-relaxed font-light">
                Sebagai Inspektorat Kabupaten Puncak Jaya, portal JDIH bertanggung jawab menyebarluaskan produk hukum guna menjaga integritas asas transparansi kepemerintahan daerah.
            </p>
            <div class="flex items-center gap-2.5 text-xs font-semibold text-white/80 border-t border-white/10 pt-4">
                <div class="w-6 h-6 rounded-full bg-status-active/20 flex items-center justify-center text-status-active">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                </div>
                Portal Resmi Terintegrasi JDIHN
            </div>
        </div>
    </div>
</section>

<!-- Search shortcut keyboard focus -->
<script>
    document.addEventListener('keydown', function(e) {
        if (e.key === '/') {
            const searchInput = document.getElementById('landing-search');
            if (searchInput && document.activeElement !== searchInput) {
                e.preventDefault();
                searchInput.focus();
            }
        }
    });
</script>
@endsection
