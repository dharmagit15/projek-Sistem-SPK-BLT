@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-on-surface-variant text-xs mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a href="{{ route('users.index') }}" class="hover:text-primary">Pengguna</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-bold">Edit Akun</span>
        </nav>
        <h2 class="text-2xl font-bold text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-3xl">manage_accounts</span>
            Edit Akun Pengguna ({{ $user->name }})
        </h2>
        <p class="text-on-surface-variant text-sm mt-1">Perbarui informasi akun, role hak akses, atau reset kata sandi pengguna.</p>
    </div>

    <div class="bg-white border border-outline-variant rounded-2xl shadow-sm p-6">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-800 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2.5 border border-outline-variant rounded-xl focus:outline-none focus:border-primary @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama pengguna" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-800 mb-1">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-2.5 border border-outline-variant rounded-xl focus:outline-none focus:border-primary @error('email') border-red-500 @enderror"
                           placeholder="contoh@domain.com" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-800 mb-1">Role / Hak Akses</label>
                    <select name="role" id="role" class="w-full px-4 py-2.5 border border-outline-variant rounded-xl focus:outline-none focus:border-primary @error('role') border-red-500 @enderror" required>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Pengguna Biasa (Warga / Pendaftar)</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator (Kelola Sistem)</option>
                    </select>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="border-t border-gray-100 pt-4 mt-4">
                    <div class="mb-3">
                        <h4 class="text-sm font-bold text-gray-800 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-amber-600 text-base">lock_reset</span>
                            Ubah Kata Sandi (Opsional)
                        </h4>
                        <p class="text-xs text-gray-500">Kosongkan kolom di bawah jika Anda tidak ingin mengubah kata sandi pengguna.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-800 mb-1">Kata Sandi Baru</label>
                            <input type="password" name="password" id="password"
                                   class="w-full px-4 py-2.5 border border-outline-variant rounded-xl focus:outline-none focus:border-primary @error('password') border-red-500 @enderror"
                                   placeholder="Minimal 8 karakter (opsional)">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-800 mb-1">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full px-4 py-2.5 border border-outline-variant rounded-xl focus:outline-none focus:border-primary"
                                   placeholder="Ulangi kata sandi baru">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 border-t border-gray-100 pt-5">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl font-semibold text-sm transition-all">
                    Batal
                </a>
                <button type="submit" class="bg-primary hover:bg-primary-container text-on-primary px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Perbarui Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
