<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Peraturan Puncak Jaya') - Portal Informasi Hukum Resmi</title>
    
    <!-- Favicon link -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css'])
</head>
<body class="bg-bg-base text-on-surface font-sans min-h-screen flex flex-col antialiased">

    <!-- Header Navigation -->
    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-border-subtle soft-shadow">
        <div class="max-w-[1280px] mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <!-- Official Puncak Jaya Emblem Logo -->
                <img src="{{ asset('images/logo.png') }}" alt="Logo Puncak Jaya" class="w-10 h-10 object-contain group-hover:scale-105 transition-transform duration-300">
                <div>
                    <h1 class="text-lg font-bold font-display leading-tight tracking-tight text-primary">PERATURAN PUNCAK JAYA</h1>
                    <p class="text-[10px] tracking-wider text-on-surface-variant font-semibold uppercase">Kabupaten Puncak Jaya, Papua Tengah</p>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('landing') }}" class="text-sm font-semibold tracking-wide hover:text-primary transition {{ Route::is('landing') ? 'text-primary' : 'text-on-surface-variant' }}">Beranda</a>
                <a href="{{ route('search') }}" class="text-sm font-semibold tracking-wide hover:text-primary transition {{ Route::is('search') ? 'text-primary' : 'text-on-surface-variant' }}">Cari Regulasi</a>
                <a href="{{ route('stats') }}" class="text-sm font-semibold tracking-wide hover:text-primary transition {{ Route::is('stats') ? 'text-primary' : 'text-on-surface-variant' }}">Statistik</a>
            </nav>

            <!-- Secondary Actions -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('admin.regulations.index') }}" class="text-xs font-bold uppercase tracking-wider text-primary hover:text-primary-container py-2 px-4 border border-primary/20 rounded-md bg-primary/5 hover:bg-primary/10 transition">Login</a>
                    <a href="{{ route('admin.settings') }}" class="text-xs font-bold uppercase tracking-wider text-on-surface-variant hover:text-primary transition py-2 px-2">Profil</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-bold uppercase tracking-wider text-status-revoked hover:text-status-revoked/80 transition cursor-pointer">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-wider text-on-surface-variant hover:text-primary transition">Login Admin</a>
                    <a href="{{ route('search') }}" class="bg-primary hover:bg-primary-container text-white text-xs font-bold uppercase tracking-widest py-2.5 px-5 rounded-md shadow-lg shadow-primary/25 transition-all duration-300">Cari Produk Hukum</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-on-surface text-white border-t border-white/5 pt-16 pb-8">
        <div class="max-w-[1280px] mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 pb-12 border-b border-white/10">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Puncak Jaya" class="w-10 h-10 object-contain">
                    <div>
                        <h3 class="text-md font-bold font-display">Peraturan Puncak Jaya</h3>
                        <p class="text-xs text-white/50">Jaringan Dokumentasi dan Informasi Hukum</p>
                    </div>
                </div>
                <p class="text-sm text-white/70 leading-relaxed max-w-sm">
                    Pusat dokumentasi dan penyebarluasan informasi hukum resmi Kabupaten Puncak Jaya, Provinsi Papua Tengah. Menyediakan dokumen peraturan perundang-undangan tingkat daerah terintegrasi secara cepat dan akurat.
                </p>
            </div>
            <div>
                <h4 class="text-sm font-bold tracking-widest uppercase mb-6 text-white/50 font-display">Kontak Pengelola</h4>
                <p class="text-sm text-white/70 leading-relaxed mb-3">
                    <strong>Inspektorat Kabupaten Puncak Jaya</strong><br>
                    Kantor Bupati Puncak Jaya, Mulia, Papua Tengah
                </p>
                <p class="text-sm text-white/70">
                    Email: inspektorat@puncakjayakab.go.id<br>
                    Website: inspektorat.puncakjayakab.go.id
                </p>
            </div>
            <div>
                <h4 class="text-sm font-bold tracking-widest uppercase mb-6 text-white/50 font-display">JDIH Nasional</h4>
                <p class="text-sm text-white/70 mb-4">
                    Anggota Jaringan Dokumentasi dan Informasi Hukum Nasional (JDIHN) terintegrasi dengan pusat.
                </p>
                <div class="h-12 bg-white/5 rounded-lg flex items-center px-4 border border-white/10 max-w-[200px]">
                    <span class="text-xs tracking-wider uppercase font-semibold text-white/40">INTEGRATED JDIHN</span>
                </div>
            </div>
        </div>
        <div class="max-w-[1280px] mx-auto px-6 pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-white/40">
            <p>&copy; 2026 Peraturan Puncak Jaya. Hak Cipta Dilindungi.</p>
            <p class="mt-2 md:mt-0">Dibuat sesuai spesifikasi Lex Sovrana</p>
        </div>
    </footer>

</body>
</html>
