<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - SPK BLT Admin Console</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght=300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
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
                    },
                    "fontFamily": {
                        "headline-md": ["Inter"],
                        "display-lg": ["Inter"],
                        "headline-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "label-md": ["Inter"],
                        "mono-sm": ["monospace"]
                    },
                    "fontSize": {
                        "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "display-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "mono-sm": ["13px", {"lineHeight": "18px", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .bg-pattern {
            background-color: #f8f9ff;
            background-image: radial-gradient(#dce1ff 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="bg-pattern min-h-screen flex items-center justify-center p-4">

    <div class="max-w-[1200px] w-full grid grid-cols-1 lg:grid-cols-12 gap-0 overflow-hidden rounded-xl shadow-2xl bg-surface-container-lowest">
        
        <div class="hidden lg:flex lg:col-span-7 relative bg-primary items-center justify-center overflow-hidden p-margin-desktop">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-[-10%] left-[-10%] w-[60%] h-[60%] rounded-full bg-on-primary-fixed-variant blur-[120px]"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[60%] h-[60%] rounded-full bg-secondary blur-[120px]"></div>
            </div>
            <div class="relative z-10 text-center space-y-stack-md max-w-md">
                <div class="flex justify-center mb-8">
                    <div class="w-24 h-24 bg-on-primary rounded-full flex items-center justify-center shadow-xl p-4">
                        <img alt="Garuda Pancasila" class="w-full h-full object-contain" src="{{ asset('images/OIP.webp') }}"/>
                    </div>
                </div>
                <h1 class="font-display-lg text-display-lg text-on-primary leading-tight">
                    Sistem Pendukung Keputusan Penerimaan BLT
                </h1>
                <p class="font-body-lg text-body-lg text-primary-fixed/80">
                    Mewujudkan transparansi dan efisiensi dalam penyaluran bantuan sosial kepada masyarakat yang membutuhkan melalui analisis data yang akurat.
                </p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1/3 opacity-30 pointer-events-none">
                <div class="w-full h-full" style="background-image: linear-gradient(to top, #00164e, transparent);"></div>
            </div>
        </div>

        <div class="col-span-1 lg:col-span-5 flex flex-col items-center justify-center p-margin-desktop bg-surface-container-lowest">
            <div class="w-full max-w-sm space-y-8">
                
                <div class="lg:hidden text-center space-y-4 mb-8">
                    <img alt="Logo" class="h-16 mx-auto object-contain" src="{{ asset('images/OIP.webp') }}"/>
                    <h2 class="font-headline-md text-headline-md text-primary">SPK BLT</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Sistem Pendukung Keputusan</p>
                </div>

                <div class="space-y-2">
                    <h2 class="font-headline-md text-headline-md text-on-surface lg:block hidden">Selamat Datang</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Silakan masuk ke akun administrator Anda untuk melanjutkan.</p>
                </div>

                @if (session('status'))
                    <div class="p-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-xs font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf 
                    
                    <div class="space-y-1">
                        <label class="font-label-md text-label-md text-on-surface-variant block ml-1 uppercase tracking-wider" for="email">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[20px]">mail</span>
                            </div>
                            <input class="block w-full pl-10 pr-3 py-3 bg-surface rounded-xl font-body-md text-body-md focus:outline-none focus:ring-2 transition-all placeholder:text-outline-variant
                                @error('email') border-error focus:ring-error/20 focus:border-error @else border-outline-variant focus:ring-primary/20 focus:border-primary @enderror" 
                                id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" type="email" required autofocus />
                        </div>
                        @error('email')
                            <p class="text-xs text-error mt-1 ml-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center px-1">
                            <label class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider" for="password">Password</label>
                            @if (Route::has('password.request'))
                                <a class="font-label-md text-label-md text-primary hover:underline transition-all" href="{{ route('password.request') }}">Lupa Password?</a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                            </div>
                            <input class="block w-full pl-10 pr-12 py-3 bg-surface rounded-xl font-body-md text-body-md focus:outline-none focus:ring-2 transition-all placeholder:text-outline-variant
                                @error('password') border-error focus:ring-error/20 focus:border-error @else border-outline-variant focus:ring-primary/20 focus:border-primary @enderror" 
                                id="password" name="password" placeholder="••••••••" type="password" required autocomplete="current-password" />
                            <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-on-surface transition-colors" onclick="togglePassword()" type="button">
                                <span class="material-symbols-outlined text-[20px]" id="eye-icon">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-error mt-1 ml-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center space-x-2 px-1">
                        <input class="w-4 h-4 text-primary border-outline-variant rounded focus:ring-primary transition-all" id="remember" name="remember" type="checkbox"/>
                        <label class="font-body-md text-body-md text-on-surface-variant select-none" for="remember">Ingat saya di perangkat ini</label>
                    </div>

                    <div class="space-y-4">
                        <button class="w-full bg-primary hover:bg-on-primary-fixed-variant text-on-primary font-body-lg text-body-lg py-3.5 rounded-xl shadow-lg hover:shadow-xl active:scale-[0.98] transition-all flex items-center justify-center space-x-2 group" type="submit">
                            <span>Masuk</span>
                            <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>

                        <div class="text-center">
                            <p class="font-body-md text-body-md text-on-surface-variant">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline transition-all ml-1">
                                    Daftar sekarang
                                </a>
                            </p>
                        </div>
                    </div>
                </form>

                <div class="pt-8 border-t border-outline-variant text-center space-y-4">
                    <p class="font-label-md text-label-md text-on-surface-variant">
                        © 2024 Admin Console SPK BLT. <br/>
                        Kementerian Sosial Republik Indonesia.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a class="font-label-md text-label-md text-outline hover:text-primary transition-colors" href="#">Pusat Bantuan</a>
                        <span class="text-outline-variant">•</span>
                        <a class="font-label-md text-label-md text-outline hover:text-primary transition-colors" href="#">Keamanan</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = 'visibility';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.max-w-\\[1200px\\]');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'all 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>