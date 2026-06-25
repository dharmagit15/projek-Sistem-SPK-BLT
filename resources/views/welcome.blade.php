<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SPK-BLT</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {   
                    colors: {
                        "primary-fixed": "#dce1ff",
                        "on-primary-fixed-variant": "#264191",
                        "on-secondary-fixed": "#002113",
                        "inverse-surface": "#213145",
                        "secondary-fixed": "#6ffbbe",
                        "on-surface": "#0b1c30",
                        "surface": "#f8f9ff",
                        "secondary-fixed-dim": "#4edea3",
                        "tertiary-fixed-dim": "#ffb95f",
                        "error": "#ba1a1a",
                        "surface-variant": "#d3e4fe",
                        "primary-fixed-dim": "#b6c4ff",
                        "outline-variant": "#c5c5d3",
                        "outline": "#757682",
                        "on-surface-variant": "#444651",
                        "surface-container-highest": "#d3e4fe",
                        "on-tertiary-container": "#ef9900",
                        "primary-container": "#1e3a8a",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "on-background": "#0b1c30",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#eff4ff",
                        "surface-bright": "#f8f9ff",
                        "inverse-on-surface": "#eaf1ff",
                        "on-secondary-container": "#00714d",
                        "on-primary-container": "#90a8ff",
                        "tertiary-fixed": "#ffddb8",
                        "surface-dim": "#cbdbf5",
                        "on-secondary-fixed-variant": "#005236",
                        "tertiary": "#3e2400",
                        "surface-tint": "#4059aa",
                        "on-tertiary": "#ffffff",
                        "on-error": "#ffffff",
                        "surface-container-high": "#dce9ff",
                        "surface-container": "#e5eeff",
                        "primary": "#00236f",
                        "secondary-container": "#6cf8bb",
                        "on-primary-fixed": "#00164e",
                        "on-tertiary-fixed-variant": "#653e00",
                        "background": "#f8f9ff",
                        "on-primary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "tertiary-container": "#5c3800",
                        "on-tertiary-fixed": "#2a1700",
                        "secondary": "#006c49",
                        "inverse-primary": "#b6c4ff"
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    spacing: {
                        "sidebar-width": "280px",
                        "margin-mobile": "16px",
                        "stack-md": "16px",
                        "margin-desktop": "32px",
                        "container-max": "1440px",
                        "stack-sm": "8px",
                        "gutter": "24px"
                    },
                    fontFamily: {
                        "body-lg": ["Inter"],
                        "mono-sm": ["monospace"],
                        "label-md": ["Inter"],
                        "body-md": ["Inter"],
                        "headline-sm": ["Inter"],
                        "headline-md": ["Inter"],
                        "display-lg": ["Inter"]
                    },
                    fontSize: {
                        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "mono-sm": ["13px", {"lineHeight": "18px", "fontWeight": "400"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "display-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .bento-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .bento-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(0, 35, 111, 0.15);
        }
        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(220, 225, 255, 0.5), transparent),
                        radial-gradient(circle at bottom left, rgba(248, 249, 255, 1), transparent);
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-lg antialiased flex flex-col min-h-screen">

    <nav class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-margin-desktop h-16 bg-surface/95 backdrop-blur-sm border-b border-outline-variant">
        <div class="flex items-center gap-8">
            <span class="font-headline-md text-headline-md font-bold text-primary">SPK-BLT</span>
            <div class="hidden md:flex gap-6">
                <a class="text-primary font-bold border-b-2 border-primary py-1 text-body-lg" href="#">Program</a>
            </div>
        </div>
        
        <div class="flex items-center gap-4 ml-auto">
            @if (Route::has('login'))
                @auth
                    <span class="text-sm font-semibold text-on-surface-variant bg-surface-container-low px-3 py-1.5 rounded-full flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-secondary-fixed-dim animate-pulse"></span>
                        Halo, {{ Auth::user()->name }}
                    </span>
                    
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-md text-label-md hover:opacity-90 transition-all flex items-center gap-1">
                            <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span> Panel Admin
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="border border-error text-error px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-error/10 transition-all flex items-center gap-1">
                            <span class="material-symbols-outlined text-[18px]">logout</span> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-primary hover:underline font-label-md text-label-md px-2">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-primary-container text-on-primary-container px-6 py-2 rounded-lg font-label-md text-label-md hover:opacity-90 transition-all">
                            Daftar Akun
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <main class="flex-grow pt-16">
        <section class="relative overflow-hidden hero-gradient py-24 md:py-32 px-margin-desktop">
            <div class="max-w-container-max mx-auto grid md:grid-cols-2 gap-12 items-center">
                <div class="z-10">
                    <span class="inline-block px-3 py-1 mb-6 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-md text-label-md">SISTEM PENDUKUNG KEPUTUSAN</span>
                    <h1 class="font-display-lg text-display-lg md:text-5xl md:leading-tight text-primary mb-6">
                        Transparansi Penyaluran Bantuan Sosial
                    </h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-lg">
                        Memastikan bantuan tepat sasaran melalui analisis data yang akurat dan transparan untuk masyarakat yang membutuhkan. Didukung oleh metode Simple Additive Weighting (SAW).
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a class="bg-primary text-on-primary px-8 py-4 rounded-xl font-headline-sm text-headline-sm flex items-center gap-2 hover:shadow-lg transition-all" href="#cek-kelayakan">
                            Cek Status Penerimaan
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-primary text-on-primary px-margin-desktop">
            <div class="max-w-container-max mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="text-center p-6">
                        <div class="font-display-lg text-display-lg mb-2">1.2M+</div>
                        <div class="font-label-md text-label-md opacity-80">Total Penerima Manfaat</div>
                    </div>
                    <div class="text-center p-6 border-l border-white/10">
                        <div class="font-display-lg text-display-lg mb-2">Rp 4.2T</div>
                        <div class="font-label-md text-label-md opacity-80">Dana Terdistribusi</div>
                    </div>
                    <div class="text-center p-6 border-l border-white/10">
                        <div class="font-display-lg text-display-lg mb-2">99.8%</div>
                        <div class="font-label-md text-label-md opacity-80">Akurasi Penyaluran</div>
                    </div>
                    <div class="text-center p-6 border-l border-white/10">
                        <div class="font-display-lg text-display-lg mb-2">514</div>
                        <div class="font-label-md text-label-md opacity-80">Kabupaten/Kota Terjangkau</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-margin-desktop bg-surface">
            <div class="max-w-container-max mx-auto">
                <div class="text-center mb-16">
                    <h2 class="font-display-lg text-display-lg text-primary mb-4">Kriteria Penilaian</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                        Sistem kami menggunakan 5 parameter kriteria utama di bawah ini untuk menjamin objektivitas, akurasi, dan keadilan dalam penentuan peringkat keluarga penerima manfaat.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    <div class="bento-card bg-white border border-outline-variant p-6 rounded-[1.5rem] flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-primary-fixed rounded-xl flex items-center justify-center mb-5">
                                <span class="material-symbols-outlined text-primary text-2xl">payments</span>
                            </div>
                            <h3 class="text-lg font-bold text-primary mb-2">Pendapatan </h3>
                            <p class="text-on-surface-variant text-xs leading-relaxed">Analisis akumulasi pemasukan bulanan seluruh anggota keluarga untuk mengukur kekuatan finansial dasar.</p>
                        </div>
                    </div>

                    <div class="bento-card bg-white border border-outline-variant p-6 rounded-[1.5rem] flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-surface-container rounded-xl flex items-center justify-center mb-5">
                                <span class="material-symbols-outlined text-primary text-2xl">bolt</span>
                            </div>
                            <h3 class="text-lg font-bold text-primary mb-2">Daya Listrik </h3>
                            <p class="text-on-surface-variant text-xs leading-relaxed">Kapasitas batasan meteran listrik PLN (Volt-Ampere) yang terpasang di rumah sebagai indikator konsumsi aset harian.</p>
                        </div>
                    </div>

                    <div class="bento-card bg-white border border-outline-variant p-6 rounded-[1.5rem] flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-secondary-container rounded-xl flex items-center justify-center mb-5">
                                <span class="material-symbols-outlined text-on-secondary-container text-2xl">family_restroom</span>
                            </div>
                            <h3 class="text-lg font-bold text-primary mb-2">Tanggungan </h3>
                            <p class="text-on-surface-variant text-xs leading-relaxed">Kuantitas banyaknya jumlah anggota keluarga tanggungan non-produktif (anak/lansia) dalam satu Kartu Keluarga.</p>
                        </div>
                    </div>

                    <div class="bento-card bg-white border border-outline-variant p-6 rounded-[1.5rem] flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-tertiary-fixed rounded-xl flex items-center justify-center mb-5">
                                <span class="material-symbols-outlined text-on-tertiary-fixed-variant text-2xl">home_work</span>
                            </div>
                            <h3 class="text-lg font-bold text-primary mb-2">Kondisi Rumah</h3>
                            <p class="text-on-surface-variant text-xs leading-relaxed">Penilaian visual fisik kelayakan kelengkapan bangunan, material lantai, dinding, atap, serta kondisi sanitasi.</p>
                        </div>
                    </div>

                    <div class="bento-card bg-white border border-outline-variant p-6 rounded-[1.5rem] flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 bg-error-container rounded-xl flex items-center justify-center mb-5">
                                <span class="material-symbols-outlined text-on-error-container text-2xl">work</span>
                            </div>
                            <h3 class="text-lg font-bold text-primary mb-2">Pekerjaan </h3>
                            <p class="text-on-surface-variant text-xs leading-relaxed">Jenis stabilitas mata pencaharian kepala keluarga, meliputi kategori tidak bekerja, buruh harian, hingga pekerja lepas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-margin-desktop bg-white border-y border-outline-variant" id="cek-kelayakan">
            <div class="max-w-3xl mx-auto text-center">
                <div class="mb-8">
                    <span class="inline-block px-3 py-1 mb-4 rounded-full bg-secondary-container text-on-secondary-container font-label-md text-label-md">FITUR MANDIRI</span>
                    <h2 class="font-display-lg text-display-lg text-primary mb-4">Cek Peluang Penerimaan Bantuan</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mx-auto">
                        Gunakan kalkulator interaktif kami untuk menghitung seberapa besar peluang Anda menerima Bantuan Langsung Tunai berdasarkan kondisi ekonomi Anda.
                    </p>
                </div>
                
                <div class="flex justify-center mt-6">
                    <a href="/simulasi" class="group relative inline-flex items-center gap-3 bg-primary text-on-primary px-10 py-5 rounded-2xl font-headline-sm text-headline-sm hover:shadow-xl hover:bg-on-primary-fixed-variant transition-all transform hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-2xl animate-bounce">calculate</span>
                        <span>Mulai Simulasi BLT</span>
                        <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="w-full py-12 px-margin-desktop bg-inverse-surface mt-auto">
        <div class="max-w-container-max mx-auto text-center md:text-left">
            <p class="text-outline-variant font-label-md text-label-md">
                © 2026 SPK Penerima Bantuan Langsung Tunai - Sistem Pendukung Keputusan Penyaluran Bansos SAW. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>