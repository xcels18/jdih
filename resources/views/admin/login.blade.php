@extends('layouts.layout')

@section('title', 'Login Administrator - Peraturan Puncak Jaya')

@section('content')
<!-- Fully Immersive Professional Login Backdrop -->
<div class="min-h-[85vh] flex items-center justify-center py-20 bg-cover bg-center relative" style="background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.5) 0%, rgba(13, 27, 68, 0.95) 100%), url('{{ asset('images/puncak_jaya_backdrop.jpg') }}');">
    <!-- Overlay Glow -->
    <div class="absolute inset-0 bg-gradient-to-t from-primary/10 to-transparent pointer-events-none"></div>

    <div class="max-w-[480px] w-full mx-auto px-6 relative z-10">
        <!-- Glassmorphic Login Card -->
        <div class="bg-white/95 backdrop-blur-xl border border-white/20 p-10 rounded-3xl shadow-[0_25px_60px_-15px_rgba(0,0,0,0.4)] space-y-8">
            
            <!-- Top Branding & Logo Header -->
            <div class="text-center space-y-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Puncak Jaya" class="w-16 h-16 mx-auto object-contain animate-float drop-shadow-md">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-primary bg-primary/5 py-1.5 px-4 rounded-full border border-primary/10 inline-block">PORTAL ADMINISTRATOR</span>
                    <h2 class="text-2xl font-black font-display text-primary mt-3 tracking-tight">Login Pengelola</h2>
                    <p class="text-xs text-slate-500 mt-1">Masukkan email dan sandi resmi Inspektorat Puncak Jaya</p>
                </div>
            </div>

            <!-- Error Alerts -->
            @if($errors->any())
                <div class="bg-status-revoked/10 border border-status-revoked/20 text-status-revoked p-4 rounded-xl text-xs font-bold transition-all">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Form Fields -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-bold text-slate-700 uppercase tracking-wide">Alamat Email</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="admin@inspektorat.puncakjayakab.go.id" class="w-full border border-slate-200 rounded-xl pl-12 pr-4 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                    </div>
                </div>
                
                <div class="space-y-1.5">
                    <label for="password" class="text-xs font-bold text-slate-700 uppercase tracking-wide">Kata Sandi</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-2.25 10.5h13.5c1.035 0 1.875-.84 1.875-1.875v-6.75c0-1.035-.84-1.875-1.875-1.875H6.75c-1.035 0-1.875.84-1.875 1.875v6.75c0 1.035.84 1.875 1.875 1.875Z" />
                            </svg>
                        </span>
                        <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full border border-slate-200 rounded-xl pl-12 pr-4 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-primary bg-white shadow-sm focus:border-primary">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-gradient-to-r from-primary to-primary-container text-white font-bold text-xs uppercase tracking-widest py-4 rounded-xl transition-all hover:brightness-110 shadow-lg shadow-primary/20 cursor-pointer">
                        Masuk Sekarang
                    </button>
                </div>
            </form>
            
            <div class="border-t border-slate-100 pt-6 text-center">
                <a href="{{ route('landing') }}" class="text-xs font-bold text-slate-500 hover:text-primary transition flex items-center justify-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
