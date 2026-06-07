@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-on-surface-variant text-xs mb-2">
            <span>Dashboard</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a href="#" class="hover:underline">Alternatif</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-bold">Tambah Warga</span>
        </nav>
        <h2 class="text-2xl font-bold text-on-surface">Tambah Calon Penerima BLT</h2>
    </div>

    <div class="bg-white border border-outline-variant rounded-xl shadow-sm p-6">
        <form action="{{ route('alternatif.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="nik" class="block text-sm font-medium text-on-surface mb-1">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('nik') border-error @enderror" placeholder="Masukkan 16 digit NIK" required maxlength="16">
                    @error('nik') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-on-surface mb-1">Nama Kepala Keluarga</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('nama') border-error @enderror" placeholder="Nama lengkap kepala keluarga" required>
                    @error('nama') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-on-surface mb-1">Alamat Rumah</label>
                    <textarea name="alamat" id="alamat" rows="3" class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('alamat') border-error @enderror" placeholder="Alamat lengkap, RT/RW, Dusun" required>{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="no_telp" class="block text-sm font-medium text-on-surface mb-1">No. Telepon / WhatsApp</label>
                    <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}" class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('no_telp') border-error @enderror" placeholder="Contoh: 08123456789" required>
                    @error('no_telp') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-on-surface mb-1">Status Awal</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary">
                        <option value="Review" {{ old('status') == 'Review' ? 'selected' : '' }}>REVIEW</option>
                        <option value="Terverifikasi" {{ old('status') == 'Terverifikasi' ? 'selected' : '' }}>TERVERIFIKASI</option>
                        <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>DITOLAK</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 border-t border-outline-variant/30 pt-4">
            <a href="{{ route('alternatif.index') }}" class="px-5 py-2 border border-outline-variant text-on-surface-variant hover:bg-surface-container-low rounded-xl font-medium text-sm transition-all">
                Batal
            </a>
            <button type="submit" class="bg-primary hover:bg-primary-container text-on-primary px-5 py-2 rounded-xl font-semibold text-sm shadow-sm transition-all active:scale-95">
                Simpan Data
            </button>
        </div>
        </form>
    </div>
</div>
@endsection