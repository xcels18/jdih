@extends('layouts.layout')

@section('title', 'Dashboard Pengelola - JDIH Puncak Jaya')

@section('content')
<!-- Header Banner Section -->
<div class="relative py-12 text-white overflow-hidden bg-cover bg-center border-b border-primary/10" style="background-image: linear-gradient(135deg, rgba(0, 40, 142, 0.95) 0%, rgba(13, 27, 68, 0.98) 100%), url('{{ asset('images/puncak_jaya_backdrop.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent"></div>
    <div class="max-w-[1280px] mx-auto px-6 relative z-10 flex items-center justify-between">
        <div>
            <h2 class="text-2xl md:text-3xl font-black font-display tracking-tight mb-1">Dashboard Pengelola</h2>
            <p class="text-xs text-white/70">Kelola daftar peraturan dan relasi antar dokumen hukum JDIH.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.regulations.export') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-extrabold uppercase tracking-wider py-3.5 px-6 rounded-full transition-all shadow-md hover:scale-[1.02] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Ekspor Excel
            </a>
            <a href="{{ route('admin.regulations.create') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 text-white text-[10px] font-extrabold uppercase tracking-wider py-3.5 px-6 rounded-full transition-all shadow-md hover:scale-[1.02]">
                + Tambah Regulasi
            </a>
            <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 text-white text-[10px] font-extrabold uppercase tracking-wider py-3.5 px-6 rounded-full transition-all shadow-md hover:scale-[1.02]">
                Import CSV
            </button>
        </div>
    </div>
</div>

<div class="min-h-screen bg-[#f8fafc] pb-24">
    <div class="max-w-[1280px] mx-auto px-6 py-10">
    @if(session('success'))
        <div class="bg-status-active/10 border border-status-active/20 text-status-active p-4 rounded-xl text-xs font-semibold mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Dashboard Category Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <!-- Total -->
        <div class="bg-white border border-slate-200/70 p-4 rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.02)] flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">Total</span>
                <span class="text-lg font-black font-display text-slate-800 leading-none">{{ $stats['total'] }}</span>
            </div>
        </div>

        <!-- Perda -->
        <div class="bg-white border border-slate-200/70 p-4 rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.02)] flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">PERDA</span>
                <span class="text-lg font-black font-display text-slate-800 leading-none">{{ $stats['perda'] }}</span>
            </div>
        </div>

        <!-- Perbup -->
        <div class="bg-white border border-slate-200/70 p-4 rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.02)] flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-16.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-16.25v16.25" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">PERBUP</span>
                <span class="text-lg font-black font-display text-slate-800 leading-none">{{ $stats['perbup'] }}</span>
            </div>
        </div>

        <!-- Kepbup -->
        <div class="bg-white border border-slate-200/70 p-4 rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.02)] flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.375M9 18h3.375m-6.75 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H5.25a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3Zm3.15-11.777L9 6.75l2.25 2.25L9 11.25l2.25 2.25L9 15.75l2.25 2.25" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">KEPBUP</span>
                <span class="text-lg font-black font-display text-slate-800 leading-none">{{ $stats['kepbup'] }}</span>
            </div>
        </div>

        <!-- Others -->
        <div class="bg-white border border-slate-200/70 p-4 rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.02)] flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a1.5 1.5 0 0 0 2.122 0l4.318-4.318a1.5 1.5 0 0 0 0-2.122L11.16 3.659A2.25 2.25 0 0 0 9.568 3Z" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">LAINNYA</span>
                <span class="text-lg font-black font-display text-slate-800 leading-none">{{ $stats['others'] }}</span>
            </div>
        </div>
    </div>

    <!-- Filters Bar Card -->
    <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.02)] mb-6">
        <form action="{{ route('admin.regulations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Text Search -->
            <div class="space-y-1.5 col-span-1 md:col-span-2">
                <label for="q" class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest block mb-1.5">Cari Regulasi</label>
                <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Cari berdasarkan nomor, judul, abstrak..." class="w-full border border-slate-200 focus:border-primary/30 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-4 focus:ring-primary/5 bg-slate-50/30 focus:bg-white transition-all duration-200 shadow-sm text-slate-800">
            </div>

            <!-- Filter Type -->
            <div class="space-y-1.5">
                <label for="type" class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest block mb-1.5">Bentuk</label>
                <select id="type" name="type" class="w-full border border-slate-200 focus:border-primary/30 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-4 focus:ring-primary/5 bg-slate-50/30 focus:bg-white transition-all duration-200 shadow-sm text-slate-800">
                    <option value="">Semua Bentuk</option>
                    @foreach($availableTypes as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div class="space-y-1.5">
                <label for="status" class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest block mb-1.5">Status</label>
                <select id="status" name="status" class="w-full border border-slate-200 focus:border-primary/30 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-4 focus:ring-primary/5 bg-slate-50/30 focus:bg-white transition-all duration-200 shadow-sm text-slate-800">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Berlaku</option>
                    <option value="amended" {{ request('status') == 'amended' ? 'selected' : '' }}>Diubah</option>
                    <option value="revoked" {{ request('status') == 'revoked' ? 'selected' : '' }}>Dicabut</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 md:col-span-4 justify-end pt-3 border-t border-slate-100 mt-2">
                @if(request()->anyFilled(['q', 'type', 'status']))
                    <a href="{{ route('admin.regulations.index') }}" class="border border-slate-200 hover:bg-slate-50 text-on-surface-variant hover:text-on-surface text-[10px] font-extrabold uppercase tracking-wider px-5 py-3 rounded-full flex items-center justify-center transition">
                        Reset
                    </a>
                @endif
                <button type="submit" class="bg-primary hover:bg-primary-container text-white text-[10px] font-extrabold uppercase tracking-wider px-6 py-3 rounded-full shadow-md shadow-primary/10 transition cursor-pointer hover:scale-[1.02]">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/60 font-display">
                        <th class="p-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Bentuk & Nomor</th>
                        <th class="p-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Judul Regulasi</th>
                        <th class="p-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Tahun</th>
                        <th class="p-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="p-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($regulations as $reg)
                        <tr class="hover:bg-slate-50/60 transition-all duration-200">
                            <td class="p-4 whitespace-nowrap">
                                <span class="block font-bold text-primary">{{ $reg->type }}</span>
                                <span class="text-[10px] text-on-surface-variant font-bold">No. {{ $reg->number }}</span>
                            </td>
                            <td class="p-4 font-semibold text-slate-800 leading-relaxed max-w-md">
                                <a href="{{ route('detail', $reg->id) }}" target="_blank" class="hover:text-primary transition-all line-clamp-2">
                                    {{ $reg->title }}
                                </a>
                            </td>
                            <td class="p-4 text-on-surface-variant font-bold font-display">
                                {{ $reg->year }}
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                @if($reg->status === 'active')
                                    <span class="bg-status-active/10 text-status-active text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full font-display">Berlaku</span>
                                @elseif($reg->status === 'amended')
                                    <span class="bg-status-amended/10 text-status-amended text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full font-display">Diubah</span>
                                @elseif($reg->status === 'revoked')
                                    <span class="bg-status-revoked/10 text-status-revoked text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full font-display">Dicabut</span>
                                @endif
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-4 font-display">
                                    <a href="{{ route('admin.regulations.edit', $reg->id) }}" class="text-[10px] font-extrabold text-secondary hover:text-secondary-container transition">Ubah</a>
                                    <form action="{{ route('admin.regulations.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peraturan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[10px] font-extrabold text-status-revoked hover:text-status-revoked/80 transition cursor-pointer">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-on-surface-variant/60 font-semibold">
                                Belum ada regulasi yang dimasukkan ke dalam sistem.
                            </td>
                        </tr>
                    @endempty
                </tbody>
            </table>
        </div>
    </div>

    <div class="pt-6">
        {{ $regulations->links() }}
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity z-0" aria-hidden="true" onclick="document.getElementById('importModal').classList.add('hidden')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
            <form action="{{ route('admin.regulations.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title">
                                Import CSV Regulasi
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500 mb-4">
                                    Silakan unggah file CSV yang berisi data regulasi sesuai format Spreadsheet BPK. 
                                    (Kolom <b>No</b>, <b>Judul Singkat</b>, dst. hingga <b>Link PDF</b>).
                                </p>
                                <input type="file" name="csv_file" accept=".csv" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Mulai Import
                    </button>
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors cursor-pointer">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
