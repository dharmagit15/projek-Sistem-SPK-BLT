    <!DOCTYPE html>

    <html class="light" lang="id">

    <head>

        <meta charset="utf-8"/>

        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>

        <title>SPK BLT - Kelola Alternatif</title>

        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700;800&display=swap" rel="stylesheet"/>

        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    

        <style>

            .material-symbols-outlined {

                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;

            }

            body {

                font-family: 'Inter', sans-serif;

                background-color: #f8f9ff;

            }

            .sidebar-scroll::-webkit-scrollbar {

                width: 4px;

            }

            .sidebar-scroll::-webkit-scrollbar-track {

                background: transparent;

            }

            .sidebar-scroll::-webkit-scrollbar-thumb {

                background: rgba(255, 255, 255, 0.1);

                border-radius: 10px;

            }

        </style>

        <script id="tailwind-config">

            tailwind.config = {

                darkMode: "class",

                theme: {

                    extend: {

                        colors: {

                            "on-primary-fixed-variant": "#264191",

                            "primary-container": "#1e3a8a",

                            "surface-container-lowest": "#ffffff",

                            "surface-bright": "#f8f9ff",

                            "surface-dim": "#cbdbf5",

                            "on-primary": "#ffffff",

                            "surface-container-highest": "#d3e4fe",

                            "primary": "#00236f",

                            "on-background": "#0b1c30",

                            "surface-variant": "#d3e4fe",

                            "surface-container": "#e5eeff",

                            "on-primary-fixed": "#00164e",

                            "on-surface": "#0b1c30",

                            "on-surface-variant": "#444651",

                            "outline": "#757682",

                            "surface-container-low": "#eff4ff",

                            "surface": "#f8f9ff",

                            "surface-container-high": "#dce9ff",

                            "background": "#f8f9ff",

                            "outline-variant": "#c5c5d3",

                        },

                        borderRadius: {

                            DEFAULT: "0.125rem",

                            lg: "0.25rem",

                            xl: "0.5rem",

                            full: "0.75rem"

                        },

                        spacing: {

                            "sidebar-width": "280px"

                        }

                    },

                },

            }

        </script>

    </head>

    <body class="bg-background text-on-background">

    <aside class="w-[280px] h-screen fixed left-0 top-0 bg-primary dark:bg-on-primary-fixed shadow-sm flex flex-col p-4 overflow-y-auto sidebar-scroll z-50">
        <div class="mb-10 px-2 pt-4">
            <h1 class="font-headline-md text-xl font-bold text-on-primary">SPK BLT</h1>
            <p class="text-xs text-on-primary/60">Decision Support System</p>
        </div>
    
            <nav class="flex flex-col gap-2 flex-1">
    <a class="flex items-center gap-3 p-3 transition-colors rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }}"
    href="{{ route('admin.dashboard') }}">
        <span class="material-symbols-outlined">dashboard</span><span>Dashboard</span>
    </a>

    <a class="flex items-center gap-3 p-3 transition-colors rounded-xl {{ request()->routeIs('users*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }}"
    href="{{ route('users.index') }}">
        <span class="material-symbols-outlined">manage_accounts</span><span>Manajemen Pengguna</span>
    </a>

    <a class="flex items-center gap-3 p-3 transition-colors rounded-xl {{ request()->routeIs('kriteria*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }}"
    href="{{ route('kriteria.index') }}">
        <span class="material-symbols-outlined">list_alt</span><span>Kriteria</span>
    </a>

    <a class="flex items-center gap-3 p-3 transition-colors rounded-xl {{ request()->routeIs('alternatif*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }}"
    href="{{ route('alternatif.index') }}">
        <span class="material-symbols-outlined">groups</span><span>Kelola Warga</span>
    </a>

    <a class="flex items-center gap-3 p-3 transition-colors rounded-xl {{ request()->routeIs('perhitungan*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }}"
    href="{{ route('perhitungan.index') }}">
        <span class="material-symbols-outlined">calculate</span><span>Perhitungan</span>
    </a>

    <a class="flex items-center gap-3 p-3 transition-colors rounded-xl {{ request()->routeIs('laporan*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }}"
    href="{{ route('laporan.index') }}">
        <span class="material-symbols-outlined">description</span><span>Laporan</span>
    </a>
</nav>

        <div class="pt-4 border-t border-on-primary/10 mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf <button type="submit" class="w-full flex items-center gap-3 p-3 text-red-300 hover:text-red-100 hover:bg-red-500/20 transition-all rounded-xl font-medium group">
                    <span class="material-symbols-outlined text-red-400 group-hover:text-red-300 transition-colors">logout</span>
                    <span>Keluar Aplikasi</span>
                </button>
            </form>
        </div>
    </aside>

    <header class="fixed top-0 right-0 w-[calc(100%-280px)] h-16 bg-surface border-b border-outline-variant flex justify-between items-center px-6 z-40">
        <div class="flex items-center gap-4 w-1/3">
            <div class="relative w-full">
                
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container-high text-on-surface-variant">
                <span class="material-symbols-outlined">notifications</span>
            </button>
            <div class="h-8 w-[1px] bg-outline-variant mx-2"></div>
            <span class="text-sm font-semibold text-on-surface">{{ Auth::user()->name ?? 'Admin Console' }}</span>
        </div>
    </header>

    <main class="ml-[280px] pt-16 min-h-screen">
        <div class="p-8 max-w-[1440px] mx-auto">
            @yield('content')
        </div>
    </main>

</body>

    </html>