<nav x-data="{ open: false }" class="fixed top-0 left-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-gray-200/80 shadow-sm transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Brand & Main Nav -->
            <div class="flex items-center gap-8">
                <a href="{{ route('landing') }}" class="flex items-center gap-2 font-extrabold text-blue-700 text-xl tracking-tight">
                    <span class="material-symbols-outlined text-blue-600">assured_workload</span>
                    <span>SPK-BLT</span>
                </a>

                <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('landing') }}"
                       class="transition-colors py-1.5 border-b-2 {{ request()->routeIs('landing') ? 'border-blue-600 text-blue-700 font-semibold' : 'border-transparent text-gray-600 hover:text-blue-600' }}">
                        Beranda
                    </a>
                    <a href="{{ route('user.simulasi') }}"
                       class="transition-colors py-1.5 border-b-2 {{ request()->routeIs('user.simulasi') ? 'border-blue-600 text-blue-700 font-semibold' : 'border-transparent text-gray-600 hover:text-blue-600' }}">
                        Simulasi
                    </a>
                    @auth
                        <a href="{{ route('user.pendaftaran.index') }}"
                           class="transition-colors py-1.5 border-b-2 {{ request()->routeIs('user.pendaftaran.*') ? 'border-blue-600 text-blue-700 font-semibold' : 'border-transparent text-gray-600 hover:text-blue-600' }}">
                            Pendaftaran Saya
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Right Actions (Auth State) -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    <span class="text-xs font-medium text-gray-700 bg-gray-100 px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-gray-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        {{ Auth::user()->name }}
                    </span>

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="bg-blue-800 hover:bg-blue-900 text-white text-xs font-semibold px-3.5 py-2 rounded-xl transition-all flex items-center gap-1.5 shadow-sm">
                            <span class="material-symbols-outlined text-base">admin_panel_settings</span>
                            Panel Admin
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 px-3.5 py-2 rounded-xl transition-all flex items-center gap-1">
                            <span class="material-symbols-outlined text-base">logout</span>
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-gray-700 hover:text-blue-600 px-3 py-2 transition-colors">
                        Masuk / Login
                    </a>
                    <a href="{{ route('user.pendaftaran.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all shadow-sm flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base">edit_document</span>
                        Pendaftaran SPK BLT
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center md:hidden">
                <button @click="open = !open" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none">
                    <span class="material-symbols-outlined text-2xl" x-text="open ? 'close' : 'menu'">menu</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div x-show="open" x-transition class="md:hidden border-t border-gray-200 bg-white px-4 pt-2 pb-4 space-y-2">
        <a href="{{ route('landing') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">
            Beranda
        </a>
        <a href="{{ route('user.simulasi') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">
            Simulasi
        </a>
        @auth
            <a href="{{ route('user.pendaftaran.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">
                Pendaftaran Saya
            </a>
            <div class="pt-3 border-t border-gray-100 flex flex-col gap-2">
                <span class="text-xs font-semibold text-gray-500 px-3">Login sebagai: {{ Auth::user()->name }}</span>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-blue-800 bg-blue-50">
                        Panel Admin
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-semibold text-rose-600 hover:bg-rose-50">
                        Keluar
                    </button>
                </form>
            </div>
        @else
            <div class="pt-3 border-t border-gray-100 space-y-2">
                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700">
                    Masuk / Login
                </a>
                <a href="{{ route('user.pendaftaran.create') }}" class="block w-full text-center px-4 py-2 bg-blue-600 rounded-xl text-sm font-semibold text-white">
                    Pendaftaran SPK BLT
                </a>
            </div>
        @endauth
    </div>
</nav>
