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
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-border-subtle/80 shadow-[0_2px_15px_-3px_rgba(15,23,42,0.05)]">
        <div class="max-w-[1280px] mx-auto px-6 py-4.5 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <!-- Official Puncak Jaya Emblem Logo -->
                <img src="{{ asset('images/logo.png') }}" alt="Logo Puncak Jaya" class="w-10 h-10 object-contain group-hover:scale-105 transition-transform duration-300">
                <div>
                    <h1 class="text-[15px] font-black font-display leading-tight tracking-tight text-primary">PERATURAN PUNCAK JAYA</h1>
                    <p class="text-[9px] tracking-wider text-on-surface-variant font-bold uppercase">Kabupaten Puncak Jaya, Papua Tengah</p>
                </div>
            </a>

            <!-- Navigation Links (using premium Plus Jakarta Sans) -->
            <nav class="hidden md:flex items-center gap-8 font-display">
                <a href="{{ route('landing') }}" class="relative text-[11px] uppercase tracking-wider font-extrabold transition-all duration-300 {{ Route::is('landing') ? 'text-primary' : 'text-on-surface-variant hover:text-primary' }}">
                    Beranda
                    @if(Route::is('landing'))
                        <span class="absolute -bottom-1.5 left-0 right-0 h-0.5 bg-primary rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('search') }}" class="relative text-[11px] uppercase tracking-wider font-extrabold transition-all duration-300 {{ Route::is('search') ? 'text-primary' : 'text-on-surface-variant hover:text-primary' }}">
                    Cari Regulasi
                    @if(Route::is('search'))
                        <span class="absolute -bottom-1.5 left-0 right-0 h-0.5 bg-primary rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('stats') }}" class="relative text-[11px] uppercase tracking-wider font-extrabold transition-all duration-300 {{ Route::is('stats') ? 'text-primary' : 'text-on-surface-variant hover:text-primary' }}">
                    Statistik
                    @if(Route::is('stats'))
                        <span class="absolute -bottom-1.5 left-0 right-0 h-0.5 bg-primary rounded-full"></span>
                    @endif
                </a>
            </nav>

            <!-- Secondary Actions -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('admin.regulations.index') }}" class="text-[10px] font-extrabold uppercase tracking-wider text-primary hover:text-primary-container py-2 px-5 border border-primary/20 rounded-full bg-primary/5 hover:bg-primary/10 transition">Dashboard</a>
                    <a href="{{ route('admin.reports.index') }}" class="relative text-[10px] font-extrabold uppercase tracking-wider text-on-surface-variant hover:text-primary transition py-2.5 px-3 {{ Route::is('admin.reports.index') ? 'text-primary font-black' : '' }}">
                        Laporan
                        @php
                            $pendingReports = \App\Models\Report::where('status', 'pending')->count();
                        @endphp
                        @if($pendingReports > 0)
                            <span class="absolute top-0 right-1 inline-flex items-center justify-center min-w-[14px] h-[14px] text-[8px] font-bold text-white bg-red-500 rounded-full px-1 shadow-sm">
                                {{ $pendingReports }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('admin.settings') }}" class="text-[10px] font-extrabold uppercase tracking-wider text-on-surface-variant hover:text-primary transition py-2 px-2 {{ Route::is('admin.settings') ? 'text-primary font-black' : '' }}">Profil</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-[10px] font-extrabold uppercase tracking-wider text-status-revoked hover:text-status-revoked/80 transition cursor-pointer">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-[10px] font-extrabold uppercase tracking-wider text-on-surface-variant hover:text-primary transition">Login Admin</a>
                    <a href="{{ route('search') }}" class="bg-primary hover:bg-primary-container text-white text-[10px] font-extrabold uppercase tracking-wider py-2.5 px-6 rounded-full shadow-md shadow-primary/10 hover:shadow-lg transition-all duration-300 hover:scale-[1.02]">Cari Produk Hukum</a>
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

    @guest
    <!-- Floating Lapor Chatbox Widget -->
    <div class="fixed bottom-6 right-6 z-50 font-display">
        <!-- Floating Button -->
        <button id="lapor-trigger" class="flex items-center gap-2 bg-primary hover:bg-primary-container text-white px-5 py-3 rounded-full shadow-lg shadow-primary/25 transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
            </svg>
            <span class="text-xs font-bold uppercase tracking-wider">Lapor Pengelola</span>
        </button>

        <!-- Chatbox Form Container (WhatsApp Styled) -->
        <div id="lapor-chatbox" class="hidden absolute bottom-16 right-0 w-80 sm:w-96 bg-[#ece5dd] border border-slate-300 rounded-2xl shadow-2xl overflow-hidden transition-all duration-300">
            <!-- WA Header -->
            <div class="bg-[#075e54] px-4 py-3 flex items-center justify-between text-white">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="JDIH Puncak Jaya" class="w-9 h-9 rounded-full bg-white p-0.5 object-contain">
                    <div>
                        <h4 class="text-xs font-bold font-display leading-tight">Helpdesk JDIH</h4>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-[9px] text-white/80 font-medium">Online (Pelayanan Prima)</span>
                        </div>
                    </div>
                </div>
                <button id="lapor-close" class="text-white/80 hover:text-white transition text-lg font-bold focus:outline-none cursor-pointer">&times;</button>
            </div>

            <!-- WA Chat Area -->
            <div class="p-4 space-y-4 max-h-[420px] overflow-y-auto custom-scrollbar">
                <!-- Welcome Speech Bubble (Left Side) -->
                <div id="lapor-welcome-bubble" class="flex items-start gap-1">
                    <div class="bg-white text-slate-800 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%] text-[11px] leading-relaxed relative">
                        Halo! Selamat datang di JDIH Puncak Jaya. Jika Anda menemukan kesalahan penulisan, link unduh rusak, atau memiliki saran perbaikan, silakan sampaikan laporan Anda di bawah ini. Tim kami akan segera menindaklanjuti. 😊
                        <span class="text-[8px] text-slate-400 block text-right mt-1">Sekarang</span>
                    </div>
                </div>

                <!-- Form -->
                <form id="lapor-form" class="space-y-3.5">
                    @csrf
                    <div class="space-y-1">
                        <label class="text-[9px] font-extrabold text-slate-500 uppercase tracking-widest block pl-1">Nama Pengirim (Opsional)</label>
                        <input type="text" id="lapor-name" name="name" placeholder="Nama Anda" class="w-full border-0 focus:border-0 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-[#128c7e] bg-white text-slate-850 shadow-sm transition">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[9px] font-extrabold text-slate-500 uppercase tracking-widest block pl-1">No. WhatsApp / Kontak (Opsional)</label>
                        <input type="text" id="lapor-contact" name="contact" placeholder="contoh: 081234567890" class="w-full border-0 focus:border-0 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-[#128c7e] bg-white text-slate-850 shadow-sm transition">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[9px] font-extrabold text-slate-500 uppercase tracking-widest block pl-1">Isi Laporan / Pesan</label>
                        <textarea id="lapor-message" name="message" rows="3" required placeholder="Tuliskan detail laporan Anda..." class="w-full border-0 focus:border-0 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-[#128c7e] bg-white text-slate-850 shadow-sm leading-relaxed transition"></textarea>
                    </div>

                    <button type="submit" id="lapor-submit" class="w-full bg-[#128c7e] hover:bg-[#075e54] text-white text-xs font-bold uppercase tracking-wider py-3 rounded-xl shadow-md transition-all cursor-pointer flex items-center justify-center gap-2 hover:scale-[1.01]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                        Kirim Laporan
                    </button>
                </form>

                <!-- Success State (Sent Speech Bubble on Right Side) -->
                <div id="lapor-success" class="hidden space-y-4 py-2">
                    <div class="flex justify-end">
                        <div class="bg-[#d9fdd3] text-slate-800 p-3.5 rounded-2xl rounded-tr-none shadow-sm max-w-[85%] text-[11px] leading-relaxed relative border border-[#c1eec1]/30">
                            <div class="flex items-center gap-1.5 text-emerald-700 font-bold mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                <span>Laporan Terkirim!</span>
                            </div>
                            Terima kasih. Pesan Anda telah masuk ke sistem pengelola JDIH Puncak Jaya dan segera kami tindaklanjuti.
                            <span class="text-[8px] text-slate-500 block text-right mt-1.5">Terkirim &bull; <span class="text-emerald-600 font-bold">✓✓</span></span>
                        </div>
                    </div>
                    <div class="text-center pt-2">
                        <button id="lapor-reset" class="text-[10px] font-bold text-[#128c7e] hover:underline uppercase cursor-pointer">Kirim Laporan Baru</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endguest

    @guest
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('lapor-trigger');
            const chatbox = document.getElementById('lapor-chatbox');
            const closeBtn = document.getElementById('lapor-close');
            const form = document.getElementById('lapor-form');
            const successState = document.getElementById('lapor-success');
            const submitBtn = document.getElementById('lapor-submit');
            const resetBtn = document.getElementById('lapor-reset');

            if (trigger) {
                trigger.addEventListener('click', function() {
                    chatbox.classList.toggle('hidden');
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    chatbox.classList.add('hidden');
                });
            }

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Mengirim...';

                    const payload = {
                        name: document.getElementById('lapor-name').value,
                        contact: document.getElementById('lapor-contact').value,
                        message: document.getElementById('lapor-message').value,
                        _token: '{{ csrf_token() }}'
                    };

                    fetch('{{ route('reports.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            form.classList.add('hidden');
                            successState.classList.remove('hidden');
                        } else {
                            alert('Gagal mengirim laporan. Silakan coba kembali.');
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Kirim Laporan';
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan jaringan.');
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Kirim Laporan';
                    });
                });
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    form.reset();
                    successState.classList.add('hidden');
                    form.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Kirim Laporan';
                });
            }
        });
    </script>
    @endguest
</body>
</html>
