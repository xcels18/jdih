@extends('layouts.layout')

@section('title', 'Cari Regulasi - JDIH Puncak Jaya')

@section('content')
<div class="relative py-12 text-white overflow-hidden bg-cover bg-center border-b border-primary/10" style="background-image: linear-gradient(135deg, rgba(0, 40, 142, 0.95) 0%, rgba(13, 27, 68, 0.98) 100%), url('{{ asset('images/puncak_jaya_backdrop.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent"></div>
    <div class="max-w-[1280px] mx-auto px-6 relative z-10">
        <h2 class="text-2xl md:text-3xl font-black font-display text-gradient mb-1">Cari Produk Hukum Daerah</h2>
        <p class="text-xs text-white/70">Sistem pencarian terintegrasi dokumen hukum Kabupaten Puncak Jaya.</p>
    </div>
</div>

<div class="min-h-screen bg-gradient-to-b from-[#f2f4ff] via-[#faf8ff] to-[#faf8ff] pb-24">
    <div class="max-w-[1280px] mx-auto px-6 py-12">
    <form action="{{ route('search') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Left: Filters Column -->
        <div class="space-y-6">
            <div class="bg-white border border-border-subtle p-6 rounded-2xl soft-shadow space-y-6">
                <h3 class="text-sm font-bold tracking-widest uppercase text-on-surface-variant border-b border-border-subtle pb-4">Filter Pencarian</h3>
                
                <!-- Filter Type -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-on-surface uppercase tracking-wide">Jenis Peraturan</label>
                    <select name="type" class="w-full border border-border-subtle rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base">
                        <option value="">Semua Jenis</option>
                        @foreach($availableTypes as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Year -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-on-surface uppercase tracking-wide">Tahun</label>
                    <select name="year" class="w-full border border-border-subtle rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base">
                        <option value="">Semua Tahun</option>
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-on-surface uppercase tracking-wide">Status Hukum</label>
                    <select name="status" class="w-full border border-border-subtle rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Berlaku</option>
                        <option value="amended" {{ request('status') == 'amended' ? 'selected' : '' }}>Diubah</option>
                        <option value="revoked" {{ request('status') == 'revoked' ? 'selected' : '' }}>Dicabut</option>
                    </select>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-container text-white font-bold text-xs uppercase tracking-wider py-3 rounded-lg transition-all cursor-pointer">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('search') }}" class="block text-center text-xs font-bold text-on-surface-variant hover:text-primary mt-4 transition">
                        Reset Pencarian
                    </a>
                </div>
            </div>
        </div>

        <!-- Right: Results Column -->
        <div class="lg:col-span-3 space-y-6">
            
            <!-- Search Input and Sorting Bar -->
            <div class="bg-white border border-border-subtle p-4 rounded-2xl soft-shadow flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="relative w-full md:max-w-md flex items-center">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci..." class="w-full py-2.5 pl-10 pr-4 border border-border-subtle rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                    <div class="absolute left-3.5 text-on-surface-variant/50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.608 10.608Z" />
                        </svg>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                    <label class="text-xs font-semibold text-on-surface-variant whitespace-nowrap">Urutkan</label>
                    <select name="sort" onchange="this.form.submit()" class="border border-border-subtle rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base font-semibold text-on-surface-variant">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="number" {{ request('sort') == 'number' ? 'selected' : '' }}>Nomor Regulasi</option>
                    </select>
                </div>
            </div>

            <!-- Regulations Lists -->
            <div class="space-y-6">
                @forelse($regulations as $reg)
                    <div class="bg-white border border-border-subtle p-6 rounded-2xl soft-shadow hover:border-primary/20 transition-all flex flex-col gap-4">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <span class="bg-primary/5 text-primary text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-md">
                                {{ $reg->type }}
                            </span>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-on-surface-variant font-medium">No. {{ $reg->number }} Tahun {{ $reg->year }}</span>
                                @if($reg->status === 'active')
                                    <span class="bg-status-active/10 text-status-active text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full">Berlaku</span>
                                @elseif($reg->status === 'amended')
                                    <span class="bg-status-amended/10 text-status-amended text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full">Diubah</span>
                                @elseif($reg->status === 'revoked')
                                    <span class="bg-status-revoked/10 text-status-revoked text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full">Dicabut</span>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('detail', $reg->id) }}" class="text-md font-bold font-display leading-snug hover:text-primary transition-all">
                            {{ $reg->title }}
                        </a>

                        <p class="text-xs text-on-surface-variant/80 line-clamp-2">
                            {{ $reg->description ?: 'Tidak ada deskripsi abstrak untuk peraturan ini.' }}
                        </p>

                        <div class="flex items-center justify-between border-t border-border-subtle pt-4 text-xs text-on-surface-variant">
                            <span>Ditetapkan: {{ \Carbon\Carbon::parse($reg->stipulation_date)->isoFormat('D MMMM Y') }}</span>
                            <a href="{{ route('detail', $reg->id) }}" class="font-semibold text-secondary hover:text-secondary/80 flex items-center gap-1">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
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

        </div>
    </form>
</div>
</div>
@endsection
