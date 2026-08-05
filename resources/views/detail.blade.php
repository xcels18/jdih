@extends('layouts.layout')

@section('title', $regulation->title . ' - JDIH Puncak Jaya')

@section('content')
<!-- Premium Immersive Header Banner -->
<div class="relative py-16 text-white overflow-hidden bg-cover bg-center border-b border-primary/10" style="background-image: linear-gradient(135deg, rgba(0, 40, 142, 0.95) 0%, rgba(13, 27, 68, 0.98) 100%), url('{{ asset('images/puncak_jaya_backdrop.jpg') }}');">
    <!-- Subtle overlay glow -->
    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent"></div>
    <div class="max-w-[1280px] mx-auto px-6 relative z-10 space-y-4">
        <div class="flex items-center gap-3">
            <span class="bg-white/10 backdrop-blur-md text-white text-xs font-black uppercase tracking-wider px-3 py-1.5 rounded-md border border-white/20">
                {{ $regulation->type }}
            </span>
            <span class="text-xs text-white/70 font-semibold">No. {{ $regulation->number }} Tahun {{ $regulation->year }}</span>
            <span class="text-xs text-white/50">•</span>
            <span class="text-[10px] uppercase font-bold tracking-widest text-status-active">Terverifikasi JDIHN</span>
        </div>
        <h2 class="text-2xl md:text-3xl font-black font-display tracking-tight leading-snug max-w-4xl text-gradient">
            {{ $regulation->title }}
        </h2>
    </div>
</div>

<!-- Main Body Layout with Soft Ambient Backdrop -->
<div class="min-h-screen bg-gradient-to-b from-[#f0f3ff] via-[#faf8ff] to-[#faf8ff] pb-24">
    <div class="max-w-[1280px] mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Left Column: Details & Timeline -->
        <div class="space-y-8">
            
            <!-- Metadata Info Card -->
            <div class="bg-white/95 backdrop-blur border border-border-subtle p-6 rounded-2xl soft-shadow space-y-4">
                <h3 class="text-sm font-bold tracking-widest uppercase text-on-surface-variant border-b border-border-subtle pb-4">Informasi Regulasi</h3>
                
                <div class="grid grid-cols-2 gap-4 text-xs border-b border-border-subtle pb-4">
                    <div>
                        <span class="text-on-surface-variant/70 font-semibold block mb-1">Status Hukum</span>
                        @if($regulation->status === 'active')
                            <span class="bg-status-active/10 text-status-active font-bold uppercase tracking-wider px-3 py-1 rounded-full">Berlaku</span>
                        @elseif($regulation->status === 'amended')
                            <span class="bg-status-amended/10 text-status-amended font-bold uppercase tracking-wider px-3 py-1 rounded-full">Diubah</span>
                        @elseif($regulation->status === 'revoked')
                            <span class="bg-status-revoked/10 text-status-revoked font-bold uppercase tracking-wider px-3 py-1 rounded-full">Dicabut</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-on-surface-variant/70 font-semibold block mb-1">Tahun Terbit</span>
                        <span class="font-bold text-on-surface">{{ $regulation->year }}</span>
                    </div>
                    <div>
                        <span class="text-on-surface-variant/70 font-semibold block mb-1">Tanggal Ditetapkan</span>
                        <span class="font-bold text-on-surface">{{ \Carbon\Carbon::parse($regulation->stipulation_date)->isoFormat('D MMMM Y') }}</span>
                    </div>
                    <div>
                        <span class="text-on-surface-variant/70 font-semibold block mb-1">Nomor Peraturan</span>
                        <span class="font-bold text-on-surface">{{ $regulation->number }}</span>
                    </div>
                </div>

                <!-- Additional JDIH Metadata -->
                <div class="space-y-3 text-xs pt-2">
                    <div>
                        <span class="text-on-surface-variant/70 font-semibold block mb-1">T.E.U. (Tajuk Entri Utama)</span>
                        <span class="font-bold text-primary">{{ $regulation->teu ?: 'Tidak Tersedia' }}</span>
                    </div>
                    <div>
                        <span class="text-on-surface-variant/70 font-semibold block mb-1">Bidang Hukum</span>
                        <span class="font-semibold text-on-surface bg-bg-base border border-border-subtle px-2.5 py-1 rounded inline-block">{{ $regulation->law_field ?: 'Tidak Tersedia' }}</span>
                    </div>
                    <div>
                        <span class="text-on-surface-variant/70 font-semibold block mb-1.5">Subjek & Kata Kunci</span>
                        <div class="flex flex-wrap gap-1.5">
                            @if($regulation->subject)
                                @foreach(explode(',', $regulation->subject) as $tag)
                                    <span class="bg-primary/5 text-primary text-[10px] font-bold uppercase px-2 py-0.5 rounded border border-primary/10">{{ trim($tag) }}</span>
                                @endforeach
                            @else
                                <span class="text-on-surface-variant/60 font-medium italic">Tidak Tersedia</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($regulation->file_path)
                    <div class="pt-4 border-t border-border-subtle">
                        <a href="{{ asset('storage/' . $regulation->file_path) }}" target="_blank" class="w-full bg-primary hover:bg-primary-container text-white text-xs font-bold uppercase tracking-wider py-3 rounded-lg flex items-center justify-center gap-2 shadow-lg shadow-primary/20 transition-all cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Unduh Salinan PDF
                        </a>
                    </div>
                @endif
            </div>

            <!-- Timeline History Card -->
            @if(count($timeline) > 1)
                <div class="bg-white/95 backdrop-blur border border-border-subtle p-6 rounded-2xl soft-shadow space-y-6">
                    <h3 class="text-sm font-bold tracking-widest uppercase text-on-surface-variant border-b border-border-subtle pb-4">Status & Riwayat Perkembangan</h3>
                    
                    <!-- Vertical Timeline -->
                    <div class="relative pl-6 border-l-2 border-border-subtle space-y-8">
                        @foreach($timeline as $node)
                            <div class="relative">
                                <!-- Circular node -->
                                @if($node['is_current'])
                                    <div class="absolute -left-[31px] top-1.5 w-4 h-4 rounded-full border-[3px] border-primary bg-white ring-4 ring-primary/20"></div>
                                @else
                                    <div class="absolute -left-[31px] top-1.5 w-4 h-4 rounded-full border-2 border-on-surface-variant/45 bg-white"></div>
                                @endif

                                <div class="space-y-1">
                                    <div class="flex items-center justify-between gap-3">
                                        <span class="text-[10px] font-bold text-on-surface-variant">{{ \Carbon\Carbon::parse($node['date'])->format('Y') }}</span>
                                        
                                        @if(isset($node['relation_type']))
                                            <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-secondary/15 text-secondary">
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
                                            <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-primary/10 text-primary">Regulasi Ini</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('detail', $node['id']) }}" class="text-xs font-bold leading-normal block hover:underline hover:text-primary transition-all {{ $node['is_current'] ? 'text-primary' : 'text-on-surface' }}">
                                        {{ $node['title'] }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Right Column: Description & PDF Viewer -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Abstract Card -->
            <div class="bg-white/95 backdrop-blur border border-border-subtle p-6 rounded-2xl soft-shadow space-y-4">
                <h3 class="text-sm font-bold tracking-widest uppercase text-on-surface-variant border-b border-border-subtle pb-4">Abstrak / Deskripsi</h3>
                <p class="text-sm text-on-surface leading-relaxed whitespace-pre-line font-light">
                    {{ $regulation->description ?: 'Tidak ada deskripsi abstrak untuk peraturan ini.' }}
                </p>
            </div>

            <!-- PDF Reader/Iframe Card -->
            <div class="bg-white/95 backdrop-blur border border-border-subtle p-6 rounded-2xl soft-shadow space-y-4">
                <h3 class="text-sm font-bold tracking-widest uppercase text-on-surface-variant border-b border-border-subtle pb-4">Berkas Peraturan Resmi</h3>
                
                @if($regulation->file_path)
                    <div class="w-full h-[660px] border border-border-subtle rounded-xl overflow-hidden bg-bg-base relative shadow-inner">
                        <iframe src="{{ asset('storage/' . $regulation->file_path) }}" class="w-full h-full" frameborder="0"></iframe>
                    </div>
                @else
                    <div class="text-center py-20 bg-bg-base/50 rounded-xl border border-dashed border-border-subtle text-on-surface-variant/60">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 mx-auto text-on-surface-variant/35 mb-4 animate-pulse">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <p class="text-sm font-semibold">Salinan dokumen PDF belum diunggah.</p>
                        <p class="text-xs text-on-surface-variant/60 mt-1">Gunakan dashboard admin untuk mengunggah dokumen peraturan ini.</p>
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
