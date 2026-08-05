@extends('layouts.layout')

@section('title', (isset($regulation) ? 'Ubah Regulasi' : 'Tambah Regulasi') . ' - Peraturan Puncak Jaya')

@section('content')
<!-- Header Banner Section -->
<div class="relative py-8 text-white overflow-hidden bg-cover bg-center border-b border-primary/10" style="background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.98) 100%), url('{{ asset('images/puncak_jaya_backdrop.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent"></div>
    <div class="max-w-[1280px] mx-auto px-6 relative z-10 flex items-center justify-between">
        <div>
            <h2 class="text-xl md:text-2xl font-black font-display text-gradient mb-1">
                {{ isset($regulation) ? 'Ubah Regulasi' : 'Tambah Regulasi Baru' }}
            </h2>
            <p class="text-xs text-white/70">
                {{ isset($regulation) ? 'Perbarui informasi dokumen regulasi hukum.' : 'Masukkan dokumen peraturan daerah dan hubungkan dengan regulasi yang ada.' }}
            </p>
        </div>
        <a href="{{ route('admin.regulations.index') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 text-white text-xs font-bold uppercase tracking-wider py-2 px-4 rounded-lg transition-all shadow-sm">
            Kembali
        </a>
    </div>
</div>

<!-- Main Body Grid Container with Soft Gradient Backdrop -->
<div class="min-h-screen bg-[#f8fafc] pb-24">
    <div class="max-w-[1280px] mx-auto px-6 py-8">
        
        @if($errors->any())
            <div class="bg-status-revoked/10 border border-status-revoked/20 text-status-revoked p-4 rounded-xl text-xs font-semibold mb-6 max-w-4xl">
                Ada kesalahan input. Silakan periksa kembali isian formulir Anda.
            </div>
        @endif

        <form action="{{ isset($regulation) ? route('admin.regulations.update', $regulation->id) : route('admin.regulations.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            @if(isset($regulation))
                @method('PUT')
            @endif

            <!-- Left Column: Main Content (Col Span 2) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Main Information Card -->
                <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm space-y-5">
                    <h3 class="text-xs font-bold tracking-widest uppercase text-on-surface-variant border-b border-slate-100 pb-3">Informasi Utama</h3>
                    
                    <div class="space-y-1.5">
                        <label for="title" class="text-xs font-bold text-on-surface uppercase tracking-wide">Judul Lengkap Peraturan</label>
                        <textarea id="title" name="title" rows="3" required placeholder="contoh: Peraturan Daerah Kabupaten Puncak Jaya Nomor 3 Tahun 2023 tentang Pengelolaan Keuangan Daerah" class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary leading-normal bg-white shadow-inner focus:border-primary">{{ old('title', $regulation->title ?? '') }}</textarea>
                    </div>

                    <div class="space-y-1.5">
                        <label for="description" class="text-xs font-bold text-on-surface uppercase tracking-wide">Abstrak / Deskripsi Singkat</label>
                        <textarea id="description" name="description" rows="8" placeholder="Tuliskan intisari, pertimbangan, atau rangkuman singkat mengenai peraturan daerah ini..." class="w-full border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary leading-normal bg-white shadow-inner focus:border-primary">{{ old('description', $regulation->description ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Regulation Relationships Card -->
                <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm space-y-4">
                    <h3 class="text-xs font-bold tracking-widest uppercase text-on-surface-variant border-b border-slate-100 pb-3">Hubungan Regulasi (Opsional)</h3>
                    <p class="text-xs text-on-surface-variant/80">Tautkan jika regulasi ini mengubah atau mencabut peraturan lain yang sudah ada sebelumnya.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5 relative" id="searchable-relation-container">
                            <label class="text-xs font-bold text-on-surface uppercase tracking-wide">Regulasi Terkait</label>
                            
                            <!-- Search Input -->
                            <div class="relative">
                                <input type="text" id="relation-search-input" placeholder="Ketik untuk mencari regulasi..." class="w-full border border-slate-200 rounded-lg pl-3 pr-10 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary" autocomplete="off">
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Hidden input to store selected ID -->
                            <input type="hidden" id="related_regulation_id" name="related_regulation_id" value="{{ old('related_regulation_id', $existingRelation->related_regulation_id ?? '') }}">

                            <!-- Options Dropdown List -->
                            <div id="relation-options-dropdown" class="hidden absolute left-0 right-0 mt-1 max-h-60 overflow-y-auto bg-white border border-slate-200 rounded-xl shadow-xl z-50 divide-y divide-slate-100">
                                <div class="p-2.5 text-xs text-slate-400 italic cursor-pointer hover:bg-slate-50 option-item" data-id="" data-text="">
                                    -- Tidak Ada Hubungan (Kosongkan) --
                                </div>
                                @foreach($allRegulations as $item)
                                    @php
                                        $displayText = '[' . $item->type . '] No. ' . $item->number . ' / ' . $item->year . ' - ' . Str::limit($item->title, 70);
                                    @endphp
                                    <div class="p-3 text-xs text-slate-700 cursor-pointer hover:bg-primary/5 hover:text-primary option-item transition duration-150" 
                                         data-id="{{ $item->id }}" 
                                         data-text="{{ $displayText }}">
                                        <span class="font-bold text-slate-900 block mb-0.5">{{ $item->type }} No. {{ $item->number }} / {{ $item->year }}</span>
                                        <span class="text-[11px] text-slate-500 line-clamp-1 leading-normal">{{ $item->title }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label for="relation_type" class="text-xs font-bold text-on-surface uppercase tracking-wide">Tipe Hubungan</label>
                            <select id="relation_type" name="relation_type" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                                <option value="">-- Pilih Tipe Relasi --</option>
                                <option value="amends" {{ (old('relation_type', $existingRelation->relation_type ?? '') == 'amends') ? 'selected' : '' }}>Mengubah (Amends)</option>
                                <option value="amended_by" {{ (old('relation_type', $existingRelation->relation_type ?? '') == 'amended_by') ? 'selected' : '' }}>Diubah Oleh (Amended By)</option>
                                <option value="revokes" {{ (old('relation_type', $existingRelation->relation_type ?? '') == 'revokes') ? 'selected' : '' }}>Mencabut (Revokes)</option>
                                <option value="revoked_by" {{ (old('relation_type', $existingRelation->relation_type ?? '') == 'revoked_by') ? 'selected' : '' }}>Dicabut Oleh (Revoked By)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Metadata & Form Actions (Col Span 1) -->
            <div class="space-y-6">
                
                <!-- File PDF Upload Card -->
                <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm space-y-4">
                    <h3 class="text-xs font-bold tracking-widest uppercase text-on-surface-variant border-b border-slate-100 pb-3">Dokumen PDF</h3>
                    
                    <input type="hidden" id="delete_file" name="delete_file" value="0">

                    <div class="space-y-3">
                        @if(isset($regulation) && $regulation->file_path)
                            <div id="existing-file-box" class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between transition duration-300">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-emerald-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <span class="text-xs font-bold text-slate-700">PDF Terunggah</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ asset('storage/' . $regulation->file_path) }}" target="_blank" class="text-[10px] font-bold text-primary hover:bg-primary/10 bg-primary/5 border border-primary/10 px-2.5 py-1 rounded transition">Lihat</a>
                                    <button type="button" id="btn-delete-file" class="text-[10px] font-bold text-rose-600 hover:bg-rose-50 border border-rose-200 bg-white px-2.5 py-1 rounded transition cursor-pointer">Hapus</button>
                                </div>
                            </div>
                            
                            <div id="delete-warning-box" class="hidden p-3 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-2.5 text-xs text-rose-800 animate-pulse">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-rose-600 shrink-0 mt-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.34 9m-4.72 0-.34-9m9.03-3.03L19.76 13C19.76 14.1 18.1 15 16 15H8c-2.1 0-3.76-.9-3.76-2L3.23 5.97M10 11V7m4 4V7M4 5h16" />
                                </svg>
                                <div class="space-y-0.5">
                                    <p class="font-bold">File lama ditandai untuk dihapus.</p>
                                    <p class="text-[9px] text-rose-600">Simpan perubahan untuk menerapkan penghapusan.</p>
                                </div>
                            </div>
                        @endif
                        
                        <div class="relative border-2 border-dashed border-slate-200 hover:border-primary/50 transition-all rounded-xl p-4 text-center cursor-pointer bg-white group shadow-sm">
                            <input type="file" id="file" name="file" accept="application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mx-auto text-slate-400 mb-2 group-hover:text-primary transition-all">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                            </svg>
                            <span class="text-xs font-bold text-primary group-hover:underline block mb-1">Pilih / Seret PDF Baru</span>
                            <span class="text-[10px] text-slate-500 block">PDF Maksimal 20MB</span>
                        </div>

                        <!-- Selected File Status Info Box -->
                        <div id="file-info-box" class="hidden p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-2.5 text-xs text-emerald-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <div class="space-y-1">
                                <p class="font-bold">✓ PDF Baru Terpilih:</p>
                                <p id="selected-file-name" class="font-semibold text-[10px] break-all text-slate-700"></p>
                                <p class="text-[9px] text-emerald-600 font-bold bg-emerald-100/50 px-2 py-0.5 rounded border border-emerald-200/40 w-fit">Klik Simpan untuk Melakukan Upload</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Classification Inputs Card -->
                <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm space-y-4">
                    <h3 class="text-xs font-bold tracking-widest uppercase text-on-surface-variant border-b border-slate-100 pb-3">Identitas & Klasifikasi</h3>
                    
                    <div class="space-y-3.5">
                        <!-- Hidden input to submit the Level 1 category (document_type) -->
                        <input type="hidden" id="document_type" name="document_type" value="{{ old('document_type', $regulation->document_type ?? 'Peraturan Perundang-Undangan') }}">

                        <!-- Single Select with optgroup grouping -->
                        <div class="space-y-1">
                            <label for="type" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Bentuk Peraturan</label>
                            <select id="type" name="type" required class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                                <option value="">-- Pilih Bentuk Peraturan --</option>
                                
                                <optgroup label="Peraturan Perundang-Undangan &raquo; Pusat">
                                    <option value="Undang-Undang" {{ (old('type', $regulation->type ?? '') == 'Undang-Undang') ? 'selected' : '' }}>Undang-Undang</option>
                                    <option value="Perppu" {{ (old('type', $regulation->type ?? '') == 'Perppu') ? 'selected' : '' }}>Perppu</option>
                                    <option value="PP" {{ (old('type', $regulation->type ?? '') == 'PP') ? 'selected' : '' }}>PP (Peraturan Pemerintah)</option>
                                    <option value="Perpres" {{ (old('type', $regulation->type ?? '') == 'Perpres') ? 'selected' : '' }}>Perpres (Peraturan Presiden)</option>
                                    <option value="Peraturan Menteri" {{ (old('type', $regulation->type ?? '') == 'Peraturan Menteri') ? 'selected' : '' }}>Peraturan Menteri</option>
                                </optgroup>

                                <optgroup label="Peraturan Perundang-Undangan &raquo; Lembaga Negara">
                                    <option value="Peraturan MA" {{ (old('type', $regulation->type ?? '') == 'Peraturan MA') ? 'selected' : '' }}>Peraturan MA</option>
                                    <option value="Peraturan MK" {{ (old('type', $regulation->type ?? '') == 'Peraturan MK') ? 'selected' : '' }}>Peraturan MK</option>
                                    <option value="Peraturan BI" {{ (old('type', $regulation->type ?? '') == 'Peraturan BI') ? 'selected' : '' }}>Peraturan BI</option>
                                    <option value="Peraturan OJK" {{ (old('type', $regulation->type ?? '') == 'Peraturan OJK') ? 'selected' : '' }}>Peraturan OJK</option>
                                </optgroup>

                                <optgroup label="Peraturan Perundang-Undangan &raquo; Daerah &raquo; Provinsi">
                                    <option value="Perda Provinsi" {{ (old('type', $regulation->type ?? '') == 'Perda Provinsi') ? 'selected' : '' }}>Perda Provinsi</option>
                                    <option value="Pergub" {{ (old('type', $regulation->type ?? '') == 'Pergub') ? 'selected' : '' }}>Pergub (Peraturan Gubernur)</option>
                                </optgroup>

                                <optgroup label="Peraturan Perundang-Undangan &raquo; Daerah &raquo; Kabupaten/Kota">
                                    <option value="Perda Kabupaten" {{ (old('type', $regulation->type ?? '') == 'Perda Kabupaten') ? 'selected' : '' }}>Perda Kabupaten</option>
                                    <option value="Perda Kota" {{ (old('type', $regulation->type ?? '') == 'Perda Kota') ? 'selected' : '' }}>Perda Kota</option>
                                    <option value="Perbup" {{ (old('type', $regulation->type ?? '') == 'Perbup') ? 'selected' : '' }}>Perbup (Peraturan Bupati)</option>
                                    <option value="Perwali" {{ (old('type', $regulation->type ?? '') == 'Perwali') ? 'selected' : '' }}>Perwali (Peraturan Walikota)</option>
                                </optgroup>

                                <optgroup label="Peraturan Perundang-Undangan &raquo; Daerah &raquo; Desa">
                                    <option value="Perdes" {{ (old('type', $regulation->type ?? '') == 'Perdes') ? 'selected' : '' }}>Perdes (Peraturan Desa)</option>
                                    <option value="Peraturan Kepala Desa" {{ (old('type', $regulation->type ?? '') == 'Peraturan Kepala Desa') ? 'selected' : '' }}>Peraturan Kepala Desa</option>
                                    <option value="Peraturan Bersama Kepala Desa" {{ (old('type', $regulation->type ?? '') == 'Peraturan Bersama Kepala Desa') ? 'selected' : '' }}>Peraturan Bersama Kepala Desa</option>
                                </optgroup>

                                <optgroup label="Bentuk Lainnya">
                                    <option value="Keputusan" {{ (old('type', $regulation->type ?? '') == 'Keputusan') ? 'selected' : '' }}>Keputusan</option>
                                    <option value="Instruksi" {{ (old('type', $regulation->type ?? '') == 'Instruksi') ? 'selected' : '' }}>Instruksi</option>
                                    <option value="Surat Edaran" {{ (old('type', $regulation->type ?? '') == 'Surat Edaran') ? 'selected' : '' }}>Surat Edaran</option>
                                    <option value="Peraturan Kebijakan" {{ (old('type', $regulation->type ?? '') == 'Peraturan Kebijakan') ? 'selected' : '' }}>Peraturan Kebijakan</option>
                                    <option value="Produk Hukum DPR/DPRD" {{ (old('type', $regulation->type ?? '') == 'Produk Hukum DPR/DPRD') ? 'selected' : '' }}>Produk Hukum DPR/DPRD</option>
                                    <option value="Produk Hukum Desa" {{ (old('type', $regulation->type ?? '') == 'Produk Hukum Desa') ? 'selected' : '' }}>Produk Hukum Desa</option>
                                    <option value="Dokumen Legislasi" {{ (old('type', $regulation->type ?? '') == 'Dokumen Legislasi') ? 'selected' : '' }}>Dokumen Legislasi</option>
                                    <option value="Dokumen Persidangan" {{ (old('type', $regulation->type ?? '') == 'Dokumen Persidangan') ? 'selected' : '' }}>Dokumen Persidangan</option>
                                    <option value="Putusan" {{ (old('type', $regulation->type ?? '') == 'Putusan') ? 'selected' : '' }}>Putusan</option>
                                    <option value="Perjanjian" {{ (old('type', $regulation->type ?? '') == 'Perjanjian') ? 'selected' : '' }}>Perjanjian</option>
                                    <option value="Dokumen Hukum Lainnya" {{ (old('type', $regulation->type ?? '') == 'Dokumen Hukum Lainnya') ? 'selected' : '' }}>Dokumen Hukum Lainnya</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label for="status" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Status Hukum</label>
                            <select id="status" name="status" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                                <option value="active" {{ (old('status', $regulation->status ?? '') == 'active') ? 'selected' : '' }}>Berlaku (Active)</option>
                                <option value="amended" {{ (old('status', $regulation->status ?? '') == 'amended') ? 'selected' : '' }}>Diubah (Amended)</option>
                                <option value="revoked" {{ (old('status', $regulation->status ?? '') == 'revoked') ? 'selected' : '' }}>Dicabut (Revoked)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label for="number" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Nomor</label>
                                <input type="text" id="number" name="number" value="{{ old('number', $regulation->number ?? '') }}" required placeholder="cth: 12" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                            </div>
                            <div class="space-y-1">
                                <label for="year" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Tahun</label>
                                <input type="number" id="year" name="year" value="{{ old('year', $regulation->year ?? date('Y')) }}" required placeholder="cth: 2026" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label for="publishing_place" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Tempat Terbit</label>
                            <input type="text" id="publishing_place" name="publishing_place" value="{{ old('publishing_place', $regulation->publishing_place ?? 'KAB. PUNCAK JAYA') }}" required class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                        </div>

                        <div class="space-y-1">
                            <label for="stipulation_date" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Tanggal Ditetapkan</label>
                            <input type="date" id="stipulation_date" name="stipulation_date" value="{{ old('stipulation_date', $regulation->stipulation_date ?? '') }}" required class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                        </div>

                        <div class="space-y-1">
                            <label for="promulgation_date" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Tanggal Pengundangan</label>
                            <input type="date" id="promulgation_date" name="promulgation_date" value="{{ old('promulgation_date', $regulation->promulgation_date ?? '') }}" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                        </div>

                        <div class="space-y-1">
                            <label for="teu" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">T.E.U. (Tajuk Entri Utama)</label>
                            <input type="text" id="teu" name="teu" value="{{ old('teu', $regulation->teu ?? 'Inspektorat Kabupaten Puncak Jaya') }}" required class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                        </div>

                        <div class="space-y-1">
                            <label for="law_field" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Bidang Hukum</label>
                            <input type="text" id="law_field" name="law_field" value="{{ old('law_field', $regulation->law_field ?? '') }}" required placeholder="cth: Hukum Keuangan" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                        </div>

                        <div class="space-y-1">
                            <label for="gov_affairs" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Urusan Pemerintahan</label>
                            <input type="text" id="gov_affairs" name="gov_affairs" value="{{ old('gov_affairs', $regulation->gov_affairs ?? '') }}" placeholder="cth: Bidang Pendidikan" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Subjek & Kata Kunci</label>
                            <input type="hidden" id="subject" name="subject" value="{{ old('subject', $regulation->subject ?? '') }}">
                            <div id="subject-tags-container" class="w-full border border-slate-200 rounded-lg p-2.5 flex flex-wrap gap-2 focus-within:ring-1 focus-within:ring-primary bg-white min-h-[38px] cursor-text shadow-sm focus-within:border-primary">
                                <div id="tags-wrapper" class="flex flex-wrap gap-1"></div>
                                <input type="text" id="tag-input" placeholder="Ketik + Koma..." class="flex-grow min-w-[80px] border-0 p-0 text-xs focus:outline-none focus:ring-0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Actions Card -->
                <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm space-y-3">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-container text-white text-xs font-bold uppercase tracking-wider py-3.5 rounded-xl shadow-lg shadow-primary/20 transition-all cursor-pointer">
                        {{ isset($regulation) ? 'Simpan Perubahan' : 'Publish Regulasi' }}
                    </button>
                    <a href="{{ route('admin.regulations.index') }}" class="w-full border border-slate-200 hover:bg-bg-base text-on-surface-variant hover:text-on-surface text-xs font-bold uppercase tracking-wider py-3 rounded-xl flex items-center justify-center transition">
                        Batal
                    </a>
                </div>

            </div>
        </form>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subjectInput = document.getElementById('subject');
        const container = document.getElementById('subject-tags-container');
        const wrapper = document.getElementById('tags-wrapper');
        const input = document.getElementById('tag-input');
        
        let tags = [];

        // Load initial tags
        if (subjectInput.value.trim() !== '') {
            tags = subjectInput.value.split(',').map(t => t.trim()).filter(t => t !== '');
            renderTags();
        }

        function renderTags() {
            wrapper.innerHTML = '';
            tags.forEach((tag, idx) => {
                const tagEl = document.createElement('span');
                tagEl.className = 'bg-primary/10 text-primary text-xs font-semibold px-3 py-1 rounded-full border border-primary/20 flex items-center gap-1.5 select-none leading-none';
                tagEl.innerHTML = `
                    <span class="mt-0.5">${tag}</span>
                    <button type="button" class="w-4 h-4 rounded-full flex items-center justify-center hover:bg-primary/25 hover:text-status-revoked transition-all text-[11px] cursor-pointer font-bold focus:outline-none" data-index="${idx}">&times;</button>
                `;
                wrapper.appendChild(tagEl);
            });
            subjectInput.value = tags.join(', ');
        }

        // Add tag when user presses Enter, Comma, or loses focus
        function addTag(val) {
            const cleanVal = val.replace(/,/g, '').trim();
            if (cleanVal && !tags.includes(cleanVal)) {
                tags.push(cleanVal);
                renderTags();
            }
            input.value = '';
        }

        input.addEventListener('keydown', function(e) {
            if (e.key === ',' || e.key === 'Enter') {
                e.preventDefault();
                addTag(this.value);
            } else if (e.key === 'Backspace' && this.value === '' && tags.length > 0) {
                tags.pop();
                renderTags();
            }
        });

        input.addEventListener('blur', function() {
            addTag(this.value);
        });

        wrapper.addEventListener('click', function(e) {
            if (e.target.tagName === 'BUTTON') {
                const index = parseInt(e.target.getAttribute('data-index'));
                tags.splice(index, 1);
                renderTags();
            }
        });

        // Focus text input when clicking anywhere on the container
        container.addEventListener('click', function(e) {
            if (e.target !== input) {
                input.focus();
            }
        });

        // CUSTOM SEARCHABLE RELATION DROPDOWN LOGIC
        const relationSearch = document.getElementById('relation-search-input');
        const relationHidden = document.getElementById('related_regulation_id');
        const relationDropdown = document.getElementById('relation-options-dropdown');
        const optionItems = document.querySelectorAll('.option-item');

        // Initial setup
        if (relationHidden.value) {
            const selectedItem = document.querySelector(`.option-item[data-id="${relationHidden.value}"]`);
            if (selectedItem) {
                relationSearch.value = selectedItem.getAttribute('data-text');
            }
        }

        // Toggle dropdown on focus
        relationSearch.addEventListener('focus', function() {
            relationDropdown.classList.remove('hidden');
        });

        // Search filter logic
        relationSearch.addEventListener('input', function() {
            relationDropdown.classList.remove('hidden');
            const filter = this.value.toLowerCase().trim();
            
            optionItems.forEach(item => {
                const text = item.getAttribute('data-text').toLowerCase();
                const title = item.querySelector('.font-bold')?.textContent.toLowerCase() || '';
                const desc = item.querySelector('.text-\\[11px\\]')?.textContent.toLowerCase() || '';
                
                if (text.includes(filter) || title.includes(filter) || desc.includes(filter)) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });

        // Select item logic
        optionItems.forEach(item => {
            item.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const text = this.getAttribute('data-text');

                relationHidden.value = id;
                relationSearch.value = text;
                relationDropdown.classList.add('hidden');
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const container = document.getElementById('searchable-relation-container');
            if (container && !container.contains(e.target)) {
                relationDropdown.classList.add('hidden');
            }
        });

        // FILE UPLOAD VISUAL FEEDBACK LOGIC
        const fileInput = document.getElementById('file');
        const fileInfoBox = document.getElementById('file-info-box');
        const selectedFileName = document.getElementById('selected-file-name');
        const deleteFileInput = document.getElementById('delete_file');
        const existingFileBox = document.getElementById('existing-file-box');
        const deleteWarningBox = document.getElementById('delete-warning-box');
        const btnDeleteFile = document.getElementById('btn-delete-file');

        if (btnDeleteFile) {
            btnDeleteFile.addEventListener('click', function() {
                deleteFileInput.value = '1';
                existingFileBox.classList.add('hidden');
                deleteWarningBox.classList.remove('hidden');
            });
        }

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                selectedFileName.textContent = `${file.name} (${(file.size / (1024 * 1024)).toFixed(2)} MB)`;
                fileInfoBox.classList.remove('hidden');
                
                // If replacing, turn off explicit delete flag
                deleteFileInput.value = '0';
                if (existingFileBox) existingFileBox.classList.add('hidden');
                if (deleteWarningBox) deleteWarningBox.classList.add('hidden');
            } else {
                fileInfoBox.classList.add('hidden');
            }
        });        // AUTO-POPULATE DOCUMENT_TYPE MAP
        const documentTypeMap = {
            'Undang-Undang': 'Peraturan Perundang-Undangan',
            'Perppu': 'Peraturan Perundang-Undangan',
            'PP': 'Peraturan Perundang-Undangan',
            'Perpres': 'Peraturan Perundang-Undangan',
            'Peraturan Menteri': 'Peraturan Perundang-Undangan',
            'Peraturan MA': 'Peraturan Perundang-Undangan',
            'Peraturan MK': 'Peraturan Perundang-Undangan',
            'Peraturan BI': 'Peraturan Perundang-Undangan',
            'Peraturan OJK': 'Peraturan Perundang-Undangan',
            'Perda Provinsi': 'Peraturan Perundang-Undangan',
            'Pergub': 'Peraturan Perundang-Undangan',
            'Perda Kabupaten': 'Peraturan Perundang-Undangan',
            'Perda Kota': 'Peraturan Perundang-Undangan',
            'Perbup': 'Peraturan Perundang-Undangan',
            'Perwali': 'Peraturan Perundang-Undangan',
            'Perdes': 'Peraturan Perundang-Undangan',
            'Peraturan Kepala Desa': 'Peraturan Perundang-Undangan',
            'Peraturan Bersama Kepala Desa': 'Peraturan Perundang-Undangan'
        };

        const typeSelect = document.getElementById('type');
        const docTypeInput = document.getElementById('document_type');

        typeSelect.addEventListener('change', function() {
            const val = this.value;
            docTypeInput.value = documentTypeMap[val] || val;
        });

    });
</script>
@endsection
