@extends('layouts.layout')

@section('title', 'Kelola Laporan Masuk - JDIH Puncak Jaya')

@section('content')
<!-- Header Banner Section -->
<div class="relative py-12 text-white overflow-hidden bg-cover bg-center border-b border-primary/10" style="background-image: linear-gradient(135deg, rgba(0, 40, 142, 0.95) 0%, rgba(13, 27, 68, 0.98) 100%), url('{{ asset('images/puncak_jaya_backdrop.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent"></div>
    <div class="max-w-[1280px] mx-auto px-6 relative z-10 flex items-center justify-between">
        <div>
            <h2 class="text-2xl md:text-3xl font-black font-display tracking-tight mb-1">Kelola Laporan Masuk</h2>
            <p class="text-xs text-white/70">Tinjau laporan kesalahan penulisan, link rusak, atau saran perbaikan dari masyarakat.</p>
        </div>
        <a href="{{ route('admin.regulations.index') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 text-white text-[10px] font-extrabold uppercase tracking-wider py-3.5 px-6 rounded-full transition-all shadow-md">
            Kembali ke Dashboard
        </a>
    </div>
</div>

<div class="min-h-screen bg-[#f8fafc] pb-24">
    <div class="max-w-[1280px] mx-auto px-6 py-10">
    @if(session('success'))
        <div class="bg-status-active/10 border border-status-active/20 text-status-active p-4 rounded-xl text-xs font-semibold mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Dashboard Report Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <!-- Total -->
        <div class="bg-white border border-slate-200/70 p-4 rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.02)] flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">Total Laporan</span>
                <span class="text-lg font-black font-display text-slate-800 leading-none">{{ $stats['total'] }}</span>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white border border-slate-200/70 p-4 rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.02)] flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">Laporan Baru (Pending)</span>
                <span class="text-lg font-black font-display text-slate-800 leading-none">{{ $stats['pending'] }}</span>
            </div>
        </div>

        <!-- Resolved -->
        <div class="bg-white border border-slate-200/70 p-4 rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.02)] flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">Selesai Ditindaklanjuti</span>
                <span class="text-lg font-black font-display text-slate-800 leading-none">{{ $stats['resolved'] }}</span>
            </div>
        </div>
    </div>

    <!-- Filters Bar Card -->
    <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.02)] mb-6">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Text Search -->
            <div class="space-y-1.5 col-span-1 md:col-span-2">
                <label for="q" class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest block mb-1.5">Cari Isi / Pengirim</label>
                <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Cari berdasarkan nama, kontak, isi pesan..." class="w-full border border-slate-200 focus:border-primary/30 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-4 focus:ring-primary/5 bg-slate-50/30 focus:bg-white transition-all duration-200 shadow-sm text-slate-800">
            </div>

            <!-- Filter Status -->
            <div class="space-y-1.5">
                <label for="status" class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest block mb-1.5">Status Laporan</label>
                <select id="status" name="status" class="w-full border border-slate-200 focus:border-primary/30 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-4 focus:ring-primary/5 bg-slate-50/30 focus:bg-white transition-all duration-200 shadow-sm text-slate-800">
                    <option value="">Semua Laporan</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 justify-end pt-3 border-t border-slate-105 md:border-t-0 md:pt-0">
                @if(request()->anyFilled(['q', 'status']))
                    <a href="{{ route('admin.reports.index') }}" class="border border-slate-200 hover:bg-slate-50 text-on-surface-variant hover:text-on-surface text-[10px] font-extrabold uppercase tracking-wider px-5 py-3 rounded-full flex items-center justify-center transition">
                        Reset
                    </a>
                @endif
                <button type="submit" class="bg-primary hover:bg-primary-container text-white text-[10px] font-extrabold uppercase tracking-wider px-6 py-3 rounded-full shadow-md shadow-primary/10 transition cursor-pointer hover:scale-[1.02] w-full md:w-auto">
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
                        <th class="p-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Pengirim</th>
                        <th class="p-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Kontak</th>
                        <th class="p-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Isi Laporan</th>
                        <th class="p-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Tanggal Masuk</th>
                        <th class="p-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="p-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($reports as $rep)
                        <tr class="hover:bg-slate-50/60 transition-all duration-200">
                            <td class="p-4 font-bold text-slate-800 whitespace-nowrap">
                                {{ $rep->name ?: 'Masyarakat Umum' }}
                            </td>
                            <td class="p-4 text-slate-650 whitespace-nowrap">
                                {{ $rep->contact ?: '-' }}
                            </td>
                            <td class="p-4 text-slate-600 leading-relaxed max-w-xs truncate">
                                {{ $rep->message }}
                            </td>
                            <td class="p-4 text-on-surface-variant font-bold font-display whitespace-nowrap">
                                {{ $rep->created_at->isoFormat('D MMM Y, HH:mm') }}
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                @if($rep->status === 'pending')
                                    <span class="bg-amber-100 text-amber-800 text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full font-display font-medium">Baru</span>
                                @elseif($rep->status === 'resolved')
                                    <span class="bg-emerald-100 text-emerald-800 text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full font-display font-black">Selesai</span>
                                @endif
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-4 font-display">
                                    <button type="button" 
                                            class="text-[10px] font-extrabold text-primary hover:text-primary-container transition cursor-pointer btn-detail-report"
                                            data-id="{{ $rep->id }}"
                                            data-name="{{ $rep->name ?: 'Masyarakat Umum' }}"
                                            data-contact="{{ $rep->contact ?: '-' }}"
                                            data-date="{{ $rep->created_at->isoFormat('D MMM Y, HH:mm') }}"
                                            data-status="{{ $rep->status }}">
                                        Detail Laporan
                                        <span class="hidden raw-message">{{ $rep->message }}</span>
                                    </button>
                                    <form action="{{ route('admin.reports.destroy', $rep->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[10px] font-extrabold text-status-revoked hover:text-status-revoked/80 transition cursor-pointer">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-on-surface-variant/60 font-semibold">
                                Belum ada laporan masuk dari pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pt-6">
        {{ $reports->links() }}
    </div>
</div>
</div>

<!-- Report Detail Modal -->
<div id="report-detail-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div id="modal-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <!-- Center helper -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Box -->
        <div class="inline-block align-middle bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200/80 font-sans">
            <!-- Modal Header -->
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xs font-black uppercase text-slate-800 tracking-wider font-display" id="modal-title">Detail Laporan Masuk</h3>
                <button id="modal-close" class="text-slate-400 hover:text-slate-600 transition text-lg font-bold focus:outline-none cursor-pointer">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4 text-xs">
                <!-- Meta Grid -->
                <div class="grid grid-cols-2 gap-4 border-b border-slate-100/80 pb-4">
                    <div>
                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">Pengirim</span>
                        <span id="modal-name" class="font-bold text-slate-800 text-sm"></span>
                    </div>
                    <div>
                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">Kontak / Email</span>
                        <span id="modal-contact" class="font-bold text-slate-700 text-sm"></span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 border-b border-slate-100/80 pb-4">
                    <div>
                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">Tanggal Kirim</span>
                        <span id="modal-date" class="font-bold text-slate-700 font-display"></span>
                    </div>
                    <div>
                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-0.5">Status Laporan</span>
                        <span id="modal-status" class="inline-block mt-1 font-bold uppercase tracking-wider text-[9px] font-display"></span>
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5">Isi Laporan / Pesan</span>
                    <div id="modal-message" class="bg-slate-50 border border-slate-200/60 rounded-xl p-4 text-slate-800 text-xs leading-relaxed whitespace-pre-line max-h-60 overflow-y-auto custom-scrollbar"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                <!-- Resolve Toggle Action Form inside Modal -->
                <form id="modal-update-form" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" id="modal-update-status">
                    <button type="submit" id="modal-update-btn" class="bg-primary hover:bg-primary-container text-white text-[10px] font-extrabold uppercase tracking-wider py-2.5 px-6 rounded-full shadow-md shadow-primary/10 transition cursor-pointer hover:scale-[1.02]"></button>
                </form>

                <div class="flex items-center gap-3">
                    <button id="modal-cancel" class="border border-slate-200 hover:bg-slate-100 text-slate-600 text-[10px] font-extrabold uppercase tracking-wider py-2 px-5 rounded-full transition cursor-pointer">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('report-detail-modal');
        const backdrop = document.getElementById('modal-backdrop');
        const closeBtn = document.getElementById('modal-close');
        const cancelBtn = document.getElementById('modal-cancel');
        
        const modalName = document.getElementById('modal-name');
        const modalContact = document.getElementById('modal-contact');
        const modalDate = document.getElementById('modal-date');
        const modalStatus = document.getElementById('modal-status');
        const modalMessage = document.getElementById('modal-message');
        
        const updateForm = document.getElementById('modal-update-form');
        const updateStatus = document.getElementById('modal-update-status');
        const updateBtn = document.getElementById('modal-update-btn');

        function openModal(data) {
            modalName.textContent = data.name;
            modalContact.textContent = data.contact;
            modalDate.textContent = data.date;
            modalMessage.textContent = data.message;
            
            // Set Status badge in modal
            if (data.status === 'pending') {
                modalStatus.className = 'bg-amber-100 text-amber-800 text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full font-display font-medium inline-block';
                modalStatus.textContent = 'Baru';
                
                // Form setup: Set to resolve
                updateStatus.value = 'resolved';
                updateBtn.textContent = 'Tandai Selesai';
                updateBtn.className = 'bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-extrabold uppercase tracking-wider py-2 px-5 rounded-full shadow-md shadow-emerald-600/10 transition cursor-pointer';
            } else {
                modalStatus.className = 'bg-emerald-100 text-emerald-800 text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full font-display font-black inline-block';
                modalStatus.textContent = 'Selesai';
                
                // Form setup: Set to pending
                updateStatus.value = 'pending';
                updateBtn.textContent = 'Tandai Baru';
                updateBtn.className = 'bg-amber-600 hover:bg-amber-700 text-white text-[10px] font-extrabold uppercase tracking-wider py-2 px-5 rounded-full shadow-md shadow-amber-600/10 transition cursor-pointer';
            }

            // Set Form action url
            updateForm.action = `/admin/reports/${data.id}`;

            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        // Attach listeners to all detail buttons
        document.querySelectorAll('.btn-detail-report').forEach(btn => {
            btn.addEventListener('click', function() {
                const messageEl = this.querySelector('.raw-message');
                const data = {
                    id: this.getAttribute('data-id'),
                    name: this.getAttribute('data-name'),
                    contact: this.getAttribute('data-contact'),
                    message: messageEl ? messageEl.textContent.trim() : '',
                    date: this.getAttribute('data-date'),
                    status: this.getAttribute('data-status')
                };
                openModal(data);
            });
        });

        // Close listeners
        [closeBtn, cancelBtn, backdrop].forEach(el => {
            if (el) el.addEventListener('click', closeModal);
        });
    });
</script>
@endsection
