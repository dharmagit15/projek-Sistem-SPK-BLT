<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SPK BLT - Pendaftaran</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9ff;
        }
    </style>
</head>
<body class="bg-background text-on-background">
    <nav class="fixed top-0 left-0 w-full z-40 bg-surface/95 backdrop-blur-sm border-b border-outline-variant">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="font-bold text-primary text-lg">SPK-BLT</a>
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="text-sm text-on-surface-variant hover:text-primary">Beranda</a>
                <a href="{{ route('user.simulasi') }}" class="text-sm text-on-surface-variant hover:text-primary">Simulasi</a>
            </div>
        </div>
    </nav>

    <main class="pt-20 min-h-screen">
        @yield('content')
    </main>
</body>
</html>
