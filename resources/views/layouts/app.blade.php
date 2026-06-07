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
                        "colors": {
                            "on-primary-fixed-variant": "#264191",
                            "tertiary-fixed": "#ffddb8",
                            "primary-container": "#1e3a8a",
                            "on-secondary-fixed": "#002113",
                            "surface-container-lowest": "#ffffff",
                            "surface-bright": "#f8f9ff",
                            "secondary": "#006c49",
                            "surface-dim": "#cbdbf5",
                            "on-primary": "#ffffff",
                            "surface-container-highest": "#d3e4fe",
                            "secondary-fixed-dim": "#4edea3",
                            "on-tertiary-fixed": "#2a1700",
                            "primary": "#00236f",
                            "inverse-surface": "#213145",
                            "tertiary-container": "#5c3800",
                            "on-tertiary-fixed-variant": "#653e00",
                            "inverse-primary": "#b6c4ff",
                            "tertiary": "#3e2400",
                            "on-background": "#0b1c30",
                            "secondary-container": "#6cf8bb",
                            "surface-variant": "#d3e4fe",
                            "on-error": "#ffffff",
                            "surface-container": "#e5eeff",
                            "on-primary-fixed": "#00164e",
                            "on-surface": "#0b1c30",
                            "on-surface-variant": "#444651",
                            "primary-fixed": "#dce1ff",
                            "outline": "#757682",
                            "on-tertiary": "#ffffff",
                            "on-error-container": "#93000a",
                            "surface-container-low": "#eff4ff",
                            "on-secondary": "#ffffff",
                            "surface": "#f8f9ff",
                            "surface-tint": "#4059aa",
                            "error": "#ba1a1a",
                            "on-secondary-fixed-variant": "#005236",
                            "primary-fixed-dim": "#b6c4ff",
                            "surface-container-high": "#dce9ff",
                            "tertiary-fixed-dim": "#ffb95f",
                            "background": "#f8f9ff",
                            "on-tertiary-container": "#ef9900",
                            "on-secondary-container": "#00714d",
                            "outline-variant": "#c5c5d3",
                            "inverse-on-surface": "#eaf1ff",
                            "secondary-fixed": "#6ffbbe",
                            "on-primary-container": "#90a8ff",
                            "error-container": "#ffdad6"
                        },
                        "borderRadius": {
                            "DEFAULT": "0.125rem",
                            "lg": "0.25rem",
                            "xl": "0.5rem",
                            "full": "0.75rem"
                        },
                        "spacing": {
                            "container-max": "1440px",
                            "gutter": "24px",
                            "margin-desktop": "32px",
                            "stack-md": "16px",
                            "stack-sm": "8px",
                            "margin-mobile": "16px",
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
    <aside class="w-[280px] h-screen fixed left-0 top-0 bg-primary dark:bg-on-primary-fixed shadow-sm flex flex-col p-4 overflow-y-auto sidebar-scroll z-50">
        <div class="mb-10 px-2 pt-4">
            <h1 class="font-headline-md text-xl font-bold text-on-primary">SPK BLT</h1>
            <p class="text-xs text-on-primary/60">Decision Support System</p>
        </div>
        <nav class="flex flex-col gap-2">
            <a class="flex items-center gap-3 p-3 transition-colors rounded-xl {{ request()->is('dashboard') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }}" 
               href="/dashboard">
                <span class="material-symbols-outlined">dashboard</span><span>Dashboard</span>
            </a>
            
            <a class="flex items-center gap-3 p-3 transition-colors rounded-xl {{ request()->is('kriteria*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }}" 
               href="/kriteria">
                <span class="material-symbols-outlined">list_alt</span><span>Kriteria</span>
            </a>
            
            <a class="flex items-center gap-3 p-3 transition-colors rounded-xl {{ request()->is('alternatif*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }}" 
               href="/alternatif">
                <span class="material-symbols-outlined">groups</span><span>Alternatif</span>
            </a>
            
            <a class="flex items-center gap-3 p-3 transition-colors rounded-xl {{ request()->is('perhitungan*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }}" 
               href="/perhitungan">
                <span class="material-symbols-outlined">calculate</span><span>Perhitungan</span>
            </a>
            
            <a class="flex items-center gap-3 p-3 transition-colors rounded-xl {{ request()->is('laporan*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }}" 
               href="/laporan">
                <span class="material-symbols-outlined">description</span><span>Laporan</span>
            </a>
        </nav>
    </aside>

    <header class="fixed top-0 right-0 w-[calc(100%-280px)] h-16 bg-surface border-b border-outline-variant flex justify-between items-center px-6 z-40">
        <div class="flex items-center gap-4 w-1/3">
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                <input class="w-full pl-10 pr-4 py-2 rounded-full border border-outline-variant bg-surface-container-lowest focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none text-sm" placeholder="Cari data..." type="text"/>
            </div>
            <nav class="flex flex-col gap-2">
                    <a class="flex items-center gap-3 p-3 {{ request()->is('dashboard') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }} transition-colors rounded-xl" href="#">
                        <span class="material-symbols-outlined">dashboard</span><span>Dashboard</span>
                    </a>
                    
                    <a class="flex items-center gap-3 p-3 {{ request()->is('kriteria*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }} transition-colors rounded-xl" href="#">
                        <span class="material-symbols-outlined">list_alt</span><span>Kriteria</span>
                    </a>
                    
                    <a class="flex items-center gap-3 p-3 {{ request()->is('alternatif*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }} transition-colors rounded-xl" href="#">
                        <span class="material-symbols-outlined">groups</span><span>Alternatif</span>
                    </a>
                    
                    <a class="flex items-center gap-3 p-3 {{ request()->is('perhitungan*') ? 'bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:text-on-primary hover:bg-primary-container/20' }} transition-colors rounded-xl" href="{{ route('perhitungan.index') }}">
                        <span class="material-symbols-outlined">calculate</span><span>Perhitungan</span>
                    </a>
                    
                    <a class="flex items-center gap-3 px-4 py-3 {{ Request::is('laporan*') ? 'sidebar-active bg-on-primary-fixed-variant text-on-primary' : 'text-on-primary/70 hover:bg-primary-container/20' }} rounded-xl transition-all duration-150" href="{{ route('laporan.index') }}">
                        <span class="material-symbols-outlined">description</span>
                        <span class="font-body-md text-body-md">Laporan</span>
                    </a>
                </nav>
        </aside>

        <header class="fixed top-0 right-0 w-[calc(100%-280px)] h-16 bg-surface border-b border-outline-variant flex justify-between items-center px-6 z-40">
            <div class="flex items-center gap-4 w-1/3">
                <div class="relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                    <input class="w-full pl-10 pr-4 py-2 rounded-full border border-outline-variant bg-surface-container-lowest focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none text-sm" placeholder="Cari data warga..." type="text"/>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container-high text-on-surface-variant"><span class="material-symbols-outlined">notifications</span></button>
                <div class="h-8 w-[1px] bg-outline-variant mx-2"></div>
                <span class="text-sm font-semibold text-on-surface">Admin Console</span>
            </div>
        </header>

        <main class="ml-[280px] pt-16 min-h-screen">
            <div class="p-8 max-w-[1440px] mx-auto">
                @yield('content')
            </div>
        </main>

    </body>
    </html>