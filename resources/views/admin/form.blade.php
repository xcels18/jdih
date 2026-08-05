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
                        <div class="space-y-1.5">
                            <label for="related_regulation_id" class="text-xs font-bold text-on-surface uppercase tracking-wide">Regulasi Terkait</label>
                            <select id="related_regulation_id" name="related_regulation_id" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                                <option value="">-- Tidak Ada Hubungan --</option>
                                @foreach($allRegulations as $item)
                                    <option value="{{ $item->id }}" {{ (old('related_regulation_id', $existingRelation->related_regulation_id ?? '') == $item->id) ? 'selected' : '' }}>
                                        [{{ $item->type }}] {{ Str::limit($item->title, 60) }}
                                    </option>
                                @endforeach
                            </select>
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
                    
                    <div class="space-y-3">
                        @if(isset($regulation) && $regulation->file_path)
                            <div class="p-3 bg-status-active/5 border border-status-active/20 rounded-lg flex items-center justify-between">
                                <span class="text-xs font-bold text-status-active">✓ PDF Terunggah</span>
                                <a href="{{ asset('storage/' . $regulation->file_path) }}" target="_blank" class="text-[10px] font-bold text-primary hover:underline bg-primary/10 border border-primary/20 px-2.5 py-1 rounded transition">Lihat</a>
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
                    </div>
                </div>

                <!-- Classification Inputs Card -->
                <div class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm space-y-4">
                    <h3 class="text-xs font-bold tracking-widest uppercase text-on-surface-variant border-b border-slate-100 pb-3">Identitas & Klasifikasi</h3>
                    
                    <div class="space-y-3.5">
                        <div class="space-y-1">
                            <label for="type" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Jenis Peraturan</label>
                            <select id="type" name="type" required class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                                <option value="Peraturan Daerah" {{ (old('type', $regulation->type ?? '') == 'Peraturan Daerah') ? 'selected' : '' }}>Peraturan Daerah (PERDA)</option>
                                <option value="Peraturan Bupati" {{ (old('type', $regulation->type ?? '') == 'Peraturan Bupati') ? 'selected' : '' }}>Peraturan Bupati (PERBUP)</option>
                                <option value="Peraturan Kepala Daerah" {{ (old('type', $regulation->type ?? '') == 'Peraturan Kepala Daerah') ? 'selected' : '' }}>Peraturan Kepala Daerah (PERKADA)</option>
                                <option value="Keputusan Bupati" {{ (old('type', $regulation->type ?? '') == 'Keputusan Bupati') ? 'selected' : '' }}>Keputusan Bupati (KEPBUP)</option>
                                <option value="Instruksi Bupati" {{ (old('type', $regulation->type ?? '') == 'Instruksi Bupati') ? 'selected' : '' }}>Instruksi Bupati</option>
                                <option value="Surat Edaran" {{ (old('type', $regulation->type ?? '') == 'Surat Edaran') ? 'selected' : '' }}>Surat Edaran</option>
                                <option value="Pengumuman" {{ (old('type', $regulation->type ?? '') == 'Pengumuman') ? 'selected' : '' }}>Pengumuman</option>
                                <option value="Keputusan Dewan" {{ (old('type', $regulation->type ?? '') == 'Keputusan Dewan') ? 'selected' : '' }}>Keputusan Dewan</option>
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
                            <label for="stipulation_date" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Tanggal Ditetapkan</label>
                            <input type="date" id="stipulation_date" name="stipulation_date" value="{{ old('stipulation_date', $regulation->stipulation_date ?? '') }}" required class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                        </div>

                        <div class="space-y-1">
                            <label for="teu" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">T.E.U. (Tajuk Entri Utama)</label>
                            <input type="text" id="teu" name="teu" value="{{ old('teu', $regulation->teu ?? 'Bupati Puncak Jaya') }}" required class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                        </div>

                        <div class="space-y-1">
                            <label for="law_field" class="text-[10px] font-bold text-on-surface uppercase tracking-wide">Bidang Hukum</label>
                            <input type="text" id="law_field" name="law_field" value="{{ old('law_field', $regulation->law_field ?? '') }}" required placeholder="cth: Hukum Keuangan" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
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
    });
</script>
@endsection
