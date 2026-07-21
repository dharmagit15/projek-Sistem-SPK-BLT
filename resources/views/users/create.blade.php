@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-on-surface-variant text-xs mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a href="{{ route('users.index') }}" class="hover:text-primary">Pengguna</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-bold">Tambah Baru</span>
        </nav>
        <h2 class="text-2xl font-bold text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-3xl">person_add</span>
            Tambah Akun Pengguna
        </h2>
        <p class="text-on-surface-variant text-sm mt-1">Buat akun pengguna baru untuk akses sistem pendaftaran SPK BLT.</p>
    </div>

    <div class="bg-white border border-outline-variant rounded-2xl shadow-sm p-6">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-800 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 border border-outline-variant rounded-xl focus:outline-none focus:border-primary @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama pengguna" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-800 mb-1">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2.5 border border-outline-variant rounded-xl focus:outline-none focus:border-primary @error('email') border-red-500 @enderror"
                           placeholder="contoh@domain.com" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-800 mb-1">Role / Hak Akses</label>
                    <select name="role" id="role" class="w-full px-4 py-2.5 border border-outline-variant rounded-xl focus:outline-none focus:border-primary @error('role') border-red-500 @enderror" required>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pengguna Biasa (Warga / Pendaftar)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator (Kelola Sistem)</option>
                    </select>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-800 mb-1">Kata Sandi (Password)</label>
                        <input type="password" name="password" id="password"
                               class="w-full px-4 py-2.5 border border-outline-variant rounded-xl focus:outline-none focus:border-primary @error('password') border-red-500 @enderror"
                               placeholder="Minimal 8 karakter" required>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-800 mb-1">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full px-4 py-2.5 border border-outline-variant rounded-xl focus:outline-none focus:border-primary"
                               placeholder="Ulangi kata sandi" required>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 border-t border-gray-100 pt-5">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl font-semibold text-sm transition-all">
                    Batal
                </a>
                <button type="submit" class="bg-primary hover:bg-primary-container text-on-primary px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
