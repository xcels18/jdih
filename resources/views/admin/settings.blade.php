@extends('layouts.layout')

@section('title', 'Pengaturan Profil - Peraturan Puncak Jaya')

@section('content')
<!-- Header Banner Section -->
<div class="relative py-8 text-white overflow-hidden bg-cover bg-center border-b border-primary/10" style="background-image: linear-gradient(135deg, rgba(0, 40, 142, 0.95) 0%, rgba(13, 27, 68, 0.98) 100%), url('{{ asset('images/puncak_jaya_backdrop.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent"></div>
    <div class="max-w-[800px] mx-auto px-6 relative z-10">
        <h2 class="text-xl md:text-2xl font-black font-display text-gradient mb-1">
            Pengaturan Profil Admin
        </h2>
        <p class="text-xs text-white/70">
            Perbarui informasi nama, alamat email, dan kata sandi akses panel pengelola Anda.
        </p>
    </div>
</div>

<!-- Main Body -->
<div class="min-h-screen bg-gradient-to-b from-[#f2f4ff] via-[#faf8ff] to-[#faf8ff] pb-24">
    <div class="max-w-[800px] mx-auto px-6 py-12">

        @if(session('success'))
            <div class="bg-status-active/10 border border-status-active/20 text-status-active p-4 rounded-xl text-xs font-bold mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-status-revoked/10 border border-status-revoked/20 text-status-revoked p-4 rounded-xl text-xs font-semibold mb-6">
                Silakan periksa kembali isian formulir Anda.
            </div>
        @endif

        <div class="bg-white/95 backdrop-blur border border-border-subtle p-8 rounded-2xl soft-shadow">
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-4">
                    <!-- Nama Admin -->
                    <div class="space-y-1.5">
                        <label for="name" class="text-xs font-bold text-on-surface uppercase tracking-wide">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-border-subtle rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base/20">
                    </div>

                    <!-- Email Admin -->
                    <div class="space-y-1.5">
                        <label for="email" class="text-xs font-bold text-on-surface uppercase tracking-wide">Alamat Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-border-subtle rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base/20">
                    </div>

                    <hr class="border-border-subtle/80 my-6">
                    <h3 class="text-xs font-black tracking-widest uppercase text-on-surface-variant mb-2">Ganti Kata Sandi (Kosongkan jika tidak diubah)</h3>

                    <!-- Password Baru -->
                    <div class="space-y-1.5">
                        <label for="password" class="text-xs font-bold text-on-surface uppercase tracking-wide">Kata Sandi Baru</label>
                        <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" class="w-full border border-border-subtle rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base/20">
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="text-xs font-bold text-on-surface uppercase tracking-wide">Ulangi Kata Sandi Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi sandi baru" class="w-full border border-border-subtle rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-primary bg-bg-base/20">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-4 border-t border-border-subtle pt-6 mt-6">
                    <a href="{{ route('admin.regulations.index') }}" class="text-xs font-bold uppercase tracking-wider text-on-surface-variant hover:text-on-surface py-3 px-6 transition">Kembali</a>
                    <button type="submit" class="bg-primary hover:bg-primary-container text-white text-xs font-bold uppercase tracking-wider py-3 px-6 rounded-lg shadow-lg shadow-primary/20 transition-all cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
