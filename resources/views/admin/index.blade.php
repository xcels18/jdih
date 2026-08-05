@extends('layouts.layout')

@section('title', 'Dashboard Pengelola - JDIH Puncak Jaya')

@section('content')
<div class="relative py-12 text-white overflow-hidden bg-cover bg-center border-b border-primary/10" style="background-image: linear-gradient(135deg, rgba(0, 40, 142, 0.95) 0%, rgba(13, 27, 68, 0.98) 100%), url('{{ asset('images/puncak_jaya_backdrop.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent"></div>
    <div class="max-w-[1280px] mx-auto px-6 relative z-10 flex items-center justify-between">
        <div>
            <h2 class="text-2xl md:text-3xl font-black font-display text-gradient mb-1">Dashboard Pengelola</h2>
            <p class="text-xs text-white/70">Kelola daftar peraturan dan relasi antar dokumen hukum JDIH.</p>
        </div>
        <a href="{{ route('admin.regulations.create') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 text-white text-xs font-bold uppercase tracking-wider py-3 px-6 rounded-lg transition-all shadow-md">
            + Tambah Regulasi
        </a>
    </div>
</div>

<div class="min-h-screen bg-gradient-to-b from-[#f2f4ff] via-[#faf8ff] to-[#faf8ff] pb-24">
    <div class="max-w-[1280px] mx-auto px-6 py-12">
    @if(session('success'))
        <div class="bg-status-active/10 border border-status-active/20 text-status-active p-4 rounded-xl text-sm font-semibold mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Dashboard Category Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <!-- Total -->
        <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-bold text-slate-450 uppercase tracking-wider block">Total Regulasi</span>
                <span class="text-lg font-black text-slate-800">{{ $stats['total'] }}</span>
            </div>
        </div>

        <!-- Perda -->
        <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-bold text-slate-450 uppercase tracking-wider block">Perda (PERDA)</span>
                <span class="text-lg font-black text-slate-800">{{ $stats['perda'] }}</span>
            </div>
        </div>

        <!-- Perbup -->
        <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-16.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-16.25v16.25" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-bold text-slate-450 uppercase tracking-wider block">Perbup (PERBUP)</span>
                <span class="text-lg font-black text-slate-800">{{ $stats['perbup'] }}</span>
            </div>
        </div>

        <!-- Kepbup -->
        <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.375M9 18h3.375m-6.75 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H5.25a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3Zm3.15-11.777L9 6.75l2.25 2.25L9 11.25l2.25 2.25L9 15.75l2.25 2.25" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-bold text-slate-455 uppercase tracking-wider block">Kepbup (KEPBUP)</span>
                <span class="text-lg font-black text-slate-800">{{ $stats['kepbup'] }}</span>
            </div>
        </div>

        <!-- Others -->
        <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-3 col-span-2 md:col-span-1">
            <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a1.5 1.5 0 0 0 2.122 0l4.318-4.318a1.5 1.5 0 0 0 0-2.122L11.16 3.659A2.25 2.25 0 0 0 9.568 3Z" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-bold text-slate-450 uppercase tracking-wider block">Lainnya</span>
                <span class="text-lg font-black text-slate-800">{{ $stats['others'] }}</span>
            </div>
        </div>
    </div>

    <!-- Filters Bar Card -->
    <div class="bg-white border border-border-subtle p-5 rounded-2xl soft-shadow mb-6">
        <form action="{{ route('admin.regulations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Text Search -->
            <div class="space-y-1.5 col-span-1 md:col-span-2">
                <label for="q" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Cari Regulasi</label>
                <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Cari berdasarkan nomor, judul, abstrak..." class="w-full border border-border-subtle rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base/30">
            </div>

            <!-- Filter Type -->
            <div class="space-y-1.5">
                <label for="type" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Bentuk</label>
                <select id="type" name="type" class="w-full border border-border-subtle rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base/30">
                    <option value="">Semua Bentuk</option>
                    @foreach($availableTypes as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div class="space-y-1.5">
                <label for="status" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Status</label>
                <select id="status" name="status" class="w-full border border-border-subtle rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base/30">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Berlaku</option>
                    <option value="amended" {{ request('status') == 'amended' ? 'selected' : '' }}>Diubah</option>
                    <option value="revoked" {{ request('status') == 'revoked' ? 'selected' : '' }}>Dicabut</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 md:col-span-4 justify-end pt-3 border-t border-border-subtle/50 mt-2">
                @if(request()->anyFilled(['q', 'type', 'status']))
                    <a href="{{ route('admin.regulations.index') }}" class="border border-border-subtle hover:bg-bg-base text-on-surface-variant hover:text-on-surface text-xs font-bold uppercase tracking-wider px-5 py-2.5 rounded-lg flex items-center justify-center transition">
                        Reset
                    </a>
                @endif
                <button type="submit" class="bg-primary hover:bg-primary-container text-white text-xs font-bold uppercase tracking-wider px-6 py-2.5 rounded-lg shadow-md transition cursor-pointer">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white border border-border-subtle rounded-2xl soft-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-bg-base border-b border-border-subtle">
                        <th class="p-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Bentuk & Nomor</th>
                        <th class="p-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Judul Regulasi</th>
                        <th class="p-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Tahun</th>
                        <th class="p-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                        <th class="p-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-subtle text-sm">
                    @forelse($regulations as $reg)
                        <tr class="hover:bg-primary/5 transition-all">
                            <td class="p-4 whitespace-nowrap">
                                <span class="block font-bold text-primary">{{ $reg->type }}</span>
                                <span class="text-xs text-on-surface-variant font-medium">No. {{ $reg->number }}</span>
                            </td>
                            <td class="p-4 font-semibold text-on-surface leading-relaxed max-w-md">
                                <a href="{{ route('detail', $reg->id) }}" target="_blank" class="hover:text-primary transition-all">
                                    {{ $reg->title }}
                                </a>
                            </td>
                            <td class="p-4 text-on-surface-variant font-medium">
                                {{ $reg->year }}
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                @if($reg->status === 'active')
                                    <span class="bg-status-active/10 text-status-active text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full">Berlaku</span>
                                @elseif($reg->status === 'amended')
                                    <span class="bg-status-amended/10 text-status-amended text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full">Diubah</span>
                                @elseif($reg->status === 'revoked')
                                    <span class="bg-status-revoked/10 text-status-revoked text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full">Dicabut</span>
                                @endif
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.regulations.edit', $reg->id) }}" class="text-xs font-bold text-secondary hover:underline">Ubah</a>
                                    <form action="{{ route('admin.regulations.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peraturan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-status-revoked hover:underline cursor-pointer">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-on-surface-variant/60">
                                Belum ada regulasi yang dimasukkan ke dalam sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pt-6">
        {{ $regulations->links() }}
    </div>
</div>
</div>
@endsection
