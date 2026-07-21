@extends('layouts.public')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-on-surface-variant text-xs mb-2">
            <a href="{{ route('landing') }}" class="hover:underline">Beranda</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-bold">Pendaftaran SPK BLT</span>
        </nav>
        <h2 class="text-2xl font-bold text-on-surface">Form Pendaftaran SPK BLT</h2>
        <p class="text-on-surface-variant text-sm mt-1">Silakan kirim data kependudukan Anda. Setelah dikirim, Anda hanya dapat melihat status pengajuan tanpa mengubah data.</p>
    </div>

    <div class="bg-white border border-outline-variant rounded-xl shadow-sm p-6">
        <form action="{{ route('user.pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="nik" class="block text-sm font-medium text-on-surface mb-1">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}"
                           class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('nik') border-error @enderror"
                           placeholder="Masukkan 16 digit NIK" required maxlength="16" pattern="[0-9]{16}" title="NIK harus berupa 16 digit angka">
                    @error('nik') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-on-surface mb-1">Nama Kepala Keluarga</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                           class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('nama') border-error @enderror"
                           placeholder="Nama lengkap kepala keluarga" required>
                    @error('nama') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-on-surface mb-1">Alamat Rumah</label>
                    <textarea name="alamat" id="alamat" rows="3"
                              class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('alamat') border-error @enderror"
                              placeholder="Alamat lengkap, RT/RW, Dusun" required>{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="no_telp" class="block text-sm font-medium text-on-surface mb-1">No. Telepon / WhatsApp</label>
                    <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"
                           class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('no_telp') border-error @enderror"
                           placeholder="Contoh: 08123456789" required>
                    @error('no_telp') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="foto_ktp" class="block text-sm font-medium text-on-surface mb-1">Foto KTP</label>
                    <label for="foto_ktp"
                           id="dropzone"
                           class="flex flex-col items-center justify-center gap-2 w-full border-2 border-dashed border-outline-variant rounded-xl px-4 py-6 cursor-pointer hover:border-primary hover:bg-surface-container-low transition-all @error('foto_ktp') border-error @enderror">
                        <img id="preview-img" src="" alt="Preview" class="hidden max-h-40 rounded-lg object-cover mb-1">
                        <span id="dropzone-icon" class="material-symbols-outlined text-3xl text-on-surface-variant">upload_file</span>
                        <span id="dropzone-text" class="text-sm text-on-surface-variant">
                            <span class="text-primary font-semibold">Klik untuk unggah</span> atau seret file ke sini
                        </span>
                        <span class="text-xs text-on-surface-variant/70">JPG, JPEG, atau PNG. Maks 2MB.</span>
                    </label>
                    <input type="file" name="foto_ktp" id="foto_ktp" accept="image/jpeg,image/jpg,image/png" class="hidden">
                    @error('foto_ktp') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 border-t border-outline-variant/30 pt-4">
                <a href="{{ route('landing') }}" class="px-5 py-2 border border-outline-variant text-on-surface-variant hover:bg-surface-container-low rounded-xl font-medium text-sm transition-all block">
                    Batal
                </a>
                <button type="submit" class="bg-primary hover:bg-primary-container text-on-primary px-5 py-2 rounded-xl font-semibold text-sm shadow-sm transition-all active:scale-95">
                    Kirim Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const inputFoto = document.getElementById('foto_ktp');
    const previewImg = document.getElementById('preview-img');
    const dropzoneIcon = document.getElementById('dropzone-icon');
    const dropzoneText = document.getElementById('dropzone-text');
    const dropzone = document.getElementById('dropzone');

    inputFoto.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            dropzoneIcon.classList.add('hidden');
            dropzoneText.innerHTML = `<span class="text-primary font-semibold">${file.name}</span> — klik untuk ganti`;
        };
        reader.readAsDataURL(file);
    });

    ['dragover', 'dragleave', 'drop'].forEach(evt => {
        dropzone.addEventListener(evt, e => e.preventDefault());
    });
    dropzone.addEventListener('dragover', () => dropzone.classList.add('border-primary'));
    dropzone.addEventListener('dragleave', () => dropzone.classList.remove('border-primary'));
    dropzone.addEventListener('drop', function (e) {
        dropzone.classList.remove('border-primary');
        if (e.dataTransfer.files.length) {
            inputFoto.files = e.dataTransfer.files;
            inputFoto.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection
