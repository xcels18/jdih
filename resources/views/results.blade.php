@extends('layouts.layout')

@section('title', 'Cari Regulasi - JDIH Puncak Jaya')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    }
</style>

<div class="min-h-screen bg-gradient-to-b from-[#f2f4ff] via-[#faf8ff] to-[#faf8ff] pt-8 pb-24">
    <div class="max-w-[1280px] mx-auto px-6 py-12">
        <form action="{{ route('search') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Left Side: Filter Sidebar -->
            <aside class="flex flex-col p-6 bg-white border border-border-subtle rounded-2xl soft-shadow space-y-6 self-start">
                <div>
                    <h2 class="font-headline-md text-sm md:text-base font-bold text-primary">Filter Pencarian</h2>
                    <p class="text-[10px] text-on-surface-variant font-medium mt-0.5">Saring dokumen hukum sesuai kebutuhan</p>
                </div>
                
                <hr class="border-border-subtle">

                <!-- Filter: Bentuk Peraturan (Type) -->
                <div class="flex flex-col gap-3">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Bentuk Peraturan</h3>
                    <div class="flex flex-col gap-1.5 max-h-56 overflow-y-auto custom-scrollbar pr-1">
                        <label class="relative flex items-center justify-between px-3 py-2 rounded-xl border cursor-pointer transition-all duration-200 group {{ !request('type') ? 'bg-primary/5 border-primary/20 text-primary' : 'bg-slate-50/40 border-slate-100 text-on-surface-variant hover:bg-slate-50 hover:border-slate-200' }}">
                            <input type="radio" name="type" value="" onchange="this.form.submit()" class="sr-only" {{ !request('type') ? 'checked' : '' }}/>
                            <span class="text-xs font-bold">Semua Bentuk</span>
                            <span class="text-[10px] font-extrabold {{ !request('type') ? 'bg-primary/10 text-primary px-2 py-0.5 rounded-md' : 'text-slate-400 group-hover:text-slate-600' }}">
                                {{ array_sum($typeFacets) }}
                            </span>
                        </label>
                        @foreach($availableTypes as $type)
                            @php $cnt = $typeFacets[$type] ?? 0; @endphp
                            @if($cnt > 0 || request('type') == $type)
                                <label class="relative flex items-center justify-between px-3 py-2 rounded-xl border cursor-pointer transition-all duration-200 group {{ request('type') == $type ? 'bg-primary/5 border-primary/20 text-primary' : 'bg-slate-50/40 border-slate-100 text-on-surface-variant hover:bg-slate-50 hover:border-slate-200' }}">
                                    <input type="radio" name="type" value="{{ $type }}" onchange="this.form.submit()" class="sr-only" {{ request('type') == $type ? 'checked' : '' }}/>
                                    <span class="text-xs font-bold">{{ $type }}</span>
                                    <span class="text-[10px] font-extrabold {{ request('type') == $type ? 'bg-primary/10 text-primary px-2 py-0.5 rounded-md' : 'text-slate-400 group-hover:text-slate-600' }}">
                                        {{ $cnt }}
                                    </span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>

                <hr class="border-border-subtle">

                <!-- Filter: Tahun -->
                <div class="flex flex-col gap-3">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tahun Terbit</h3>
                    <div class="flex flex-col gap-1.5 max-h-56 overflow-y-auto custom-scrollbar pr-1">
                        <label class="relative flex items-center justify-between px-3 py-2 rounded-xl border cursor-pointer transition-all duration-200 group {{ !request('year') ? 'bg-primary/5 border-primary/20 text-primary' : 'bg-slate-50/40 border-slate-100 text-on-surface-variant hover:bg-slate-50 hover:border-slate-200' }}">
                            <input type="radio" name="year" value="" onchange="this.form.submit()" class="sr-only" {{ !request('year') ? 'checked' : '' }}/>
                            <span class="text-xs font-bold">Semua Tahun</span>
                            <span class="text-[10px] font-extrabold {{ !request('year') ? 'bg-primary/10 text-primary px-2 py-0.5 rounded-md' : 'text-slate-400 group-hover:text-slate-600' }}">
                                {{ array_sum($yearFacets) }}
                            </span>
                        </label>
                        @foreach($availableYears as $year)
                            @php $cnt = $yearFacets[$year] ?? 0; @endphp
                            @if($cnt > 0 || request('year') == $year)
                                <label class="relative flex items-center justify-between px-3 py-2 rounded-xl border cursor-pointer transition-all duration-200 group {{ request('year') == $year ? 'bg-primary/5 border-primary/20 text-primary' : 'bg-slate-50/40 border-slate-100 text-on-surface-variant hover:bg-slate-50 hover:border-slate-200' }}">
                                    <input type="radio" name="year" value="{{ $year }}" onchange="this.form.submit()" class="sr-only" {{ request('year') == $year ? 'checked' : '' }}/>
                                    <span class="text-xs font-bold">Tahun {{ $year }}</span>
                                    <span class="text-[10px] font-extrabold {{ request('year') == $year ? 'bg-primary/10 text-primary px-2 py-0.5 rounded-md' : 'text-slate-400 group-hover:text-slate-600' }}">
                                        {{ $cnt }}
                                    </span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>

                <hr class="border-border-subtle">

                <!-- Filter: Status Hukum -->
                <div class="flex flex-col gap-3">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Hukum</h3>
                    <div class="flex flex-col gap-1.5">
                        <label class="relative flex items-center justify-between px-3 py-2 rounded-xl border cursor-pointer transition-all duration-200 group {{ !request('status') ? 'bg-primary/5 border-primary/20 text-primary' : 'bg-slate-50/40 border-slate-100 text-on-surface-variant hover:bg-slate-50 hover:border-slate-200' }}">
                            <input type="radio" name="status" value="" onchange="this.form.submit()" class="sr-only" {{ !request('status') ? 'checked' : '' }}/>
                            <span class="text-xs font-bold">Semua Status</span>
                            <span class="text-[10px] font-extrabold {{ !request('status') ? 'bg-primary/10 text-primary px-2 py-0.5 rounded-md' : 'text-slate-400 group-hover:text-slate-600' }}">
                                {{ array_sum($statusFacets) }}
                            </span>
                        </label>
                        <label class="relative flex items-center justify-between px-3 py-2 rounded-xl border cursor-pointer transition-all duration-200 group {{ request('status') == 'active' ? 'bg-teal-50/60 border-teal-100 text-teal-800' : 'bg-slate-50/40 border-slate-100 text-on-surface-variant hover:bg-slate-50 hover:border-slate-200' }}">
                            <input type="radio" name="status" value="active" onchange="this.form.submit()" class="sr-only" {{ request('status') == 'active' ? 'checked' : '' }}/>
                            <span class="text-xs font-bold flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-active"></span> Berlaku
                            </span>
                            <span class="text-[10px] font-extrabold {{ request('status') == 'active' ? 'bg-teal-100/50 text-teal-800 px-2 py-0.5 rounded-md' : 'text-slate-400 group-hover:text-slate-600' }}">
                                {{ $statusFacets['active'] ?? 0 }}
                            </span>
                        </label>
                        <label class="relative flex items-center justify-between px-3 py-2 rounded-xl border cursor-pointer transition-all duration-200 group {{ request('status') == 'amended' ? 'bg-amber-50/60 border-amber-100 text-amber-800' : 'bg-slate-50/40 border-slate-100 text-on-surface-variant hover:bg-slate-50 hover:border-slate-200' }}">
                            <input type="radio" name="status" value="amended" onchange="this.form.submit()" class="sr-only" {{ request('status') == 'amended' ? 'checked' : '' }}/>
                            <span class="text-xs font-bold flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-amended"></span> Diubah
                            </span>
                            <span class="text-[10px] font-extrabold {{ request('status') == 'amended' ? 'bg-amber-100/50 text-amber-800 px-2 py-0.5 rounded-md' : 'text-slate-400 group-hover:text-slate-600' }}">
                                {{ $statusFacets['amended'] ?? 0 }}
                            </span>
                        </label>
                        <label class="relative flex items-center justify-between px-3 py-2 rounded-xl border cursor-pointer transition-all duration-200 group {{ request('status') == 'revoked' ? 'bg-rose-50/60 border-rose-100 text-rose-800' : 'bg-slate-50/40 border-slate-100 text-on-surface-variant hover:bg-slate-50 hover:border-slate-200' }}">
                            <input type="radio" name="status" value="revoked" onchange="this.form.submit()" class="sr-only" {{ request('status') == 'revoked' ? 'checked' : '' }}/>
                            <span class="text-xs font-bold flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-revoked"></span> Dicabut
                            </span>
                            <span class="text-[10px] font-extrabold {{ request('status') == 'revoked' ? 'bg-rose-100/50 text-rose-800 px-2 py-0.5 rounded-md' : 'text-slate-400 group-hover:text-slate-600' }}">
                                {{ $statusFacets['revoked'] ?? 0 }}
                            </span>
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <a href="{{ route('search') }}" class="block text-center text-xs font-bold text-slate-500 hover:text-primary transition py-2.5 border border-slate-200 rounded-xl bg-slate-50 hover:bg-slate-100">
                        Reset Semua Filter
                    </a>
                </div>
            </aside>

            <!-- Right Side: Search Results List -->
            <main class="lg:col-span-3 flex flex-col gap-6 min-w-0">
                
                <!-- Search and Sort controls -->
                <div class="bg-white border border-border-subtle p-4 rounded-2xl soft-shadow flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="relative w-full md:max-w-md flex items-center">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci atau nomor peraturan..." class="w-full py-2.5 pl-10 pr-4 border border-border-subtle rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-slate-50/50 focus:bg-white transition-colors placeholder:text-slate-400">
                        <div class="absolute left-3.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                        <label class="text-xs font-bold text-on-surface-variant whitespace-nowrap">Urutkan</label>
                        <select name="sort" onchange="this.form.submit()" class="border border-border-subtle rounded-xl px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base font-semibold text-on-surface-variant">
                            @if(request('q'))
                                <option value="relevance" {{ request('sort', 'relevance') == 'relevance' ? 'selected' : '' }}>Kesesuaian (Relevansi)</option>
                            @endif
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="number" {{ request('sort') == 'number' ? 'selected' : '' }}>Nomor Regulasi</option>
                        </select>
                    </div>
                </div>

                <!-- Result Header Info -->
                <div class="mb-2">
                    <h1 class="font-headline-lg text-lg md:text-xl font-bold text-on-surface">Hasil Pencarian</h1>
                    <p class="text-xs text-on-surface-variant mt-1">
                        Menampilkan <span class="font-bold text-primary">{{ $regulations->firstItem() ?: 0 }} - {{ $regulations->lastItem() ?: 0 }}</span> dari <span class="font-bold text-primary">{{ $regulations->total() }}</span> dokumen hukum
                        @if(request('q'))
                            untuk kata kunci <span class="italic font-bold text-secondary">"{{ request('q') }}"</span>
                        @endif
                    </p>
                </div>

                <!-- Cards Grid -->
                <div class="flex flex-col gap-4">
                    @forelse($regulations as $reg)
                        <article class="glass-card rounded-2xl p-6 flex flex-col gap-4 transition-all hover:-translate-y-0.5 hover:shadow-md group">
                            
                            <!-- Badges & Title -->
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex flex-col gap-1.5 w-full">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="bg-primary/5 text-primary border border-primary/10 px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                                            {{ $reg->type }}
                                        </span>
                                        <span class="text-on-surface-variant font-bold text-xs">No. {{ $reg->number }} Tahun {{ $reg->year }}</span>
                                        
                                        @if(request('q') && isset($reg->relevance_percentage))
                                            <span class="bg-indigo-500/10 text-indigo-600 text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full border border-indigo-500/20">
                                                {{ $reg->relevance_percentage }}% Relevan
                                            </span>
                                        @endif

                                        @if($reg->status === 'active')
                                            <span class="bg-[#CCFBF1] text-[#0F766E] px-2 py-0.5 rounded-full text-[10px] font-semibold flex items-center gap-1 border border-[#99F6E4]">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#0F766E]"></span> Berlaku
                                            </span>
                                        @elseif($reg->status === 'amended')
                                            <span class="bg-amber-50 text-amber-700 px-2 py-0.5 rounded-full text-[10px] font-semibold flex items-center gap-1 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span> Diubah
                                            </span>
                                        @elseif($reg->status === 'revoked')
                                            <span class="bg-rose-50 text-rose-700 px-2 py-0.5 rounded-full text-[10px] font-semibold flex items-center gap-1 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span> Dicabut
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <h2 class="font-headline-md text-sm md:text-[15px] font-bold text-on-surface group-hover:text-primary transition-colors leading-snug">
                                        <a href="{{ route('detail', $reg->id) }}">
                                            {{ $reg->title }}
                                        </a>
                                    </h2>
                                </div>
                            </div>

                            <!-- Abstract Content Block -->
                            <div class="bg-slate-50/50 p-4 rounded-xl border border-slate-100 relative overflow-hidden">
                                <p class="text-xs text-on-surface-variant leading-relaxed">
                                    <strong class="text-on-surface">Materi Pokok:</strong> 
                                    {{ Str::limit($reg->description, 280) ?: 'Abstrak atau uraian materi pokok peraturan ini belum tersedia.' }}
                                </p>
                            </div>

                            <!-- Footer Stats and Button -->
                            <div class="flex items-center justify-between mt-2 pt-4 border-t border-border-subtle">
                                <div class="flex items-center gap-4 text-on-surface-variant text-[11px] font-medium">
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-3.5 h-3.5 text-slate-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        {{ number_format($reg->view_count ?: 0) }} Dilihat
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-3.5 h-3.5 text-slate-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        {{ number_format($reg->download_count ?: 0) }} Diunduh
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-3.5 h-3.5 text-slate-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($reg->stipulation_date)->isoFormat('D MMM Y') }}
                                    </div>
                                </div>
                                <a href="{{ route('detail', $reg->id) }}" class="text-xs font-bold text-secondary hover:text-primary flex items-center gap-1 transition-colors">
                                    Buka Dokumen 
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>

                        </article>
                    @empty
                        <div class="text-center py-16 bg-white rounded-2xl border border-border-subtle text-on-surface-variant/60">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto text-on-surface-variant/35 mb-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            Tidak ada regulasi yang cocok dengan kata kunci atau filter pencarian Anda.
                        </div>
                    @endforelse
                </div>

                <!-- Pagination Links -->
                <div class="pt-6">
                    {{ $regulations->links() }}
                </div>

            </main>
        </form>
    </div>
</div>
@endsection
