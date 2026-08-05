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
            Portal resmi JDIH untuk pencarian, pembacaan, dan pengunduhan berbagai produk hukum nasional dan daerah di Kabupaten Puncak Jaya, Papua Tengah.
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
       @php
        // Distinct icon definitions for all 29 type variations
        $svgCourthouse = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" /></svg>';
        $svgBook = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-16.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-16.25v16.25" /></svg>';
        $svgBuilding = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-9h.75m-.75 3h.75m-.75 3h.75m3 3h.75m-.75 3h.75m-.75 3h.75M4 21h16" /></svg>';
        $svgHome = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1M2.25 9v12m-1.5-12h1.5m16.5-6V21M12 4.875L12 3.75m0 0L10.5 3.75m1.5 0L13.5 3.75" /></svg>';
        $svgSeal = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" /></svg>';
        $svgMegaphone = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" /></svg>';
        $svgBriefcase = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875c-.621 0-1.125-.504-1.125-1.125v-4.25m16.5 0a2.25 2.25 0 0 0-2.248-2.25H5.748a2.25 2.25 0 0 0-2.248 2.25m16.5 0V9.674c0-.621-.504-1.125-1.125-1.125H4.875c-.621 0-1.125.504-1.125 1.125V14.15m16.5 0h-16.5" /></svg>';
        $svgScale = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18M12 3l3 3m-3-3L9 6m3 15l3-3m-3 3l-3-3" /></svg>';
        $svgStar = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.173-.44.83-.44 1.002 0l2.12 5.127 5.56.331c.475.028.667.618.312.928l-4.22 3.69 1.34 5.433c.114.464-.383.826-.798.587l-4.782-2.757-4.783 2.757c-.415.239-.912-.123-.798-.587l1.34-5.433-4.22-3.69c-.355-.31-.163-.9-.312-.928l5.56-.331 2.12-5.127z" /></svg>';
        $svgPen = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-3.82.859a.15.15 0 01-.18-.18l.859-3.83a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>';
        $svgShield = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.977 11.977 0 0112 2.714z" /></svg>';
        $svgKey = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" /></svg>';
        $svgUsers = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>';
        $svgBolt = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>';
        $svgChat = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v5.779z" /></svg>';
        $svgDefault = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>';

        // Map each individual leaf type to a distinct SVG icon
        $typeIcons = [
            'Undang-Undang (UU)' => $svgCourthouse,
            'Peraturan Pemerintah Pengganti Undang-Undang (Perppu)' => $svgShield,
            'Peraturan Pemerintah (PP)' => $svgBriefcase,
            'Peraturan Presiden (Perpres)' => $svgStar,
            'Peraturan Menteri (Permen)' => $svgPen,

            'Peraturan Mahkamah Agung (Perma)' => $svgScale,
            'Peraturan Mahkamah Konstitusi (Permk)' => $svgShield,
            'Peraturan Bank Indonesia (PBI)' => $svgBriefcase,
            'Peraturan Otoritas Jasa Keuangan (POJK)' => $svgStar,

            'Peraturan Daerah (Perda) Provinsi' => $svgBuilding,
            'Peraturan Gubernur (Pergub)' => $svgPen,
            'Peraturan Daerah (Perda) Kabupaten' => $svgBuilding,
            'Peraturan Daerah (Perda) Kota' => $svgBuilding,
            'Peraturan Bupati (Perbup)' => $svgBook,
            'Peraturan Walikota (Perwali)' => $svgBriefcase,
            'Peraturan Desa (Perdes)' => $svgHome,
            'Peraturan Kepala Desa (Perkades)' => $svgKey,
            'Peraturan Bersama Kepala Desa (Permakades)' => $svgUsers,

            'Keputusan Bupati (Kepbup)' => $svgSeal,
            'Instruksi Bupati (Inbup)' => $svgBolt,
            'Surat Edaran (SE)' => $svgMegaphone,
            'Peraturan Kebijakan' => $svgSeal,
            'Dokumen Persidangan' => $svgChat,
            'default' => $svgDefault,
        ];

        // Curated balanced rotating color palettes
        $colorPalettes = [
            [ // Emerald Green
                'bg' => 'bg-emerald-500/5 text-emerald-500 hover:bg-emerald-500',
                'watermark' => 'bg-emerald-500/5 text-emerald-500/10',
            ],
            [ // Amber Gold
                'bg' => 'bg-amber-500/5 text-amber-500 hover:bg-amber-500',
                'watermark' => 'bg-amber-500/5 text-amber-500/10',
            ],
            [ // Indigo Blue
                'bg' => 'bg-indigo-500/5 text-indigo-500 hover:bg-indigo-500',
                'watermark' => 'bg-indigo-500/5 text-indigo-500/10',
            ],
            [ // Violet Purple
                'bg' => 'bg-violet-500/5 text-violet-500 hover:bg-violet-500',
                'watermark' => 'bg-violet-500/5 text-violet-500/10',
            ],
            [ // Sky Blue
                'bg' => 'bg-blue-500/5 text-blue-500 hover:bg-blue-500',
                'watermark' => 'bg-blue-500/5 text-blue-500/10',
            ],
            [ // Rose Red
                'bg' => 'bg-rose-500/5 text-rose-500 hover:bg-rose-500',
                'watermark' => 'bg-rose-500/5 text-rose-500/10',
            ],
            [ // Cyan Teal
                'bg' => 'bg-cyan-500/5 text-cyan-500 hover:bg-cyan-500',
                'watermark' => 'bg-cyan-500/5 text-cyan-500/10',
            ],
            [ // Pink Fuchsia
                'bg' => 'bg-pink-500/5 text-pink-500 hover:bg-pink-500',
                'watermark' => 'bg-pink-500/5 text-pink-500/10',
            ],
        ];
    @endphp

    <!-- Slider Wrapper Container -->
    <div class="relative group">
        <!-- Navigation Buttons -->
        <div class="absolute -top-14 right-0 flex gap-2 z-20">
            <button id="slide-prev" class="w-10 h-10 rounded-xl border border-slate-200 bg-white text-slate-650 hover:bg-slate-50 flex items-center justify-center cursor-pointer transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>
            <button id="slide-next" class="w-10 h-10 rounded-xl border border-slate-200 bg-white text-slate-650 hover:bg-slate-50 flex items-center justify-center cursor-pointer transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>

        <!-- Scrollable Track -->
        <div id="carousel-track" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-4 no-scrollbar">
            @foreach($availableTypes as $type)
                @php
                    $count = \App\Models\Regulation::where('type', $type)->count();
                    $paletteIndex = $loop->index % count($colorPalettes);
                    $cfg = $colorPalettes[$paletteIndex];
                    $icon = $typeIcons[$type] ?? $typeIcons['default'];
                    
                    // Local regional products vs national references
                    $isLocal = in_array($type, [
                        'Perda Kabupaten', 'Perbup', 'Keputusan', 'Surat Edaran',
                        'Perda Provinsi', 'Pergub', 'Perdes', 'Peraturan Kepala Desa',
                        'Peraturan Bersama Kepala Desa', 'Instruksi', 'Peraturan Kebijakan'
                    ]);
                @endphp
                
                <!-- Card Item -->
                <a href="{{ route('search', ['type' => $type]) }}" class="w-full sm:w-[calc((100%-24px)/2)] md:w-[calc((100%-48px)/3)] lg:w-[calc((100%-72px)/4)] flex-shrink-0 snap-start bg-white border border-slate-200/85 p-6 rounded-2xl shadow-sm flex items-center gap-5 relative overflow-hidden group cursor-pointer hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 {{ $cfg['watermark'] }} rounded-full group-hover:scale-110 transition-transform duration-500 flex items-center justify-center">
                        <div class="w-14 h-14">
                            {!! $icon !!}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-350 {{ $cfg['bg'] }} group-hover:bg-primary group-hover:text-white">
                        <div class="w-6 h-6">
                            {!! $icon !!}
                        </div>
                    </div>
                    <div class="relative z-10 flex-1 min-w-0">
                        <h4 class="text-[11px] font-bold text-slate-500 mb-0.5 line-clamp-1" title="{{ $type }}">{{ $type }}</h4>
                        <span class="text-3xl font-black font-display text-slate-800">{{ $count }}</span>
                        <p class="text-[10px] text-slate-500 font-medium mt-1">dokumen terbit</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Bottom Banner Card: Other Regulations (PERKADA, Instruksi, SE) -->
    <div class="mt-8 bg-gradient-to-br from-white to-[#faf8ff] border border-border-subtle rounded-3xl p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg transition-all duration-300 flex items-center relative overflow-hidden group">
        <div class="z-10 w-full md:w-2/3 relative space-y-4">
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

<!-- Style & Carousel script -->
<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('carousel-track');
        const prev = document.getElementById('slide-prev');
        const next = document.getElementById('slide-next');
        
        if (track && prev && next) {
            prev.addEventListener('click', () => {
                const firstCard = track.querySelector('a');
                const cardWidth = firstCard ? firstCard.offsetWidth : 360;
                track.scrollBy({ left: -(cardWidth + 24), behavior: 'smooth' });
            });
            next.addEventListener('click', () => {
                const firstCard = track.querySelector('a');
                const cardWidth = firstCard ? firstCard.offsetWidth : 360;
                track.scrollBy({ left: cardWidth + 24, behavior: 'smooth' });
            });
        }
    });

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
