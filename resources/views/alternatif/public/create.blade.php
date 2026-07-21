@extends('layouts.public')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-on-surface-variant text-xs mb-2">
            <a href="{{ route('landing') }}" class="hover:underline">Beranda</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-bold">Form Pendaftaran SPK BLT</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-on-surface">Form Pendaftaran SPK BLT</h2>
                <p class="text-on-surface-variant text-sm mt-1">Silakan isi dan kirim data kependudukan Anda untuk proses verifikasi kelayakan bantuan.</p>
            </div>
        </div>
    </div>

    {{-- Alert info logged in user --}}
    <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-4 text-sm flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-blue-600">account_circle</span>
            <div>
                <p class="font-semibold text-blue-900">Login sebagai: {{ auth()->user()->name }}</p>
                <p class="text-xs text-blue-700">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Pengguna Terverifikasi</span>
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
                    @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-on-surface mb-1">Nama Kepala Keluarga</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', auth()->user()->name) }}"
                           class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('nama') border-error @enderror"
                           placeholder="Nama lengkap kepala keluarga" required>
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-on-surface mb-1">Alamat Rumah</label>
                    <textarea name="alamat" id="alamat" rows="3"
                              class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('alamat') border-error @enderror"
                              placeholder="Alamat lengkap, RT/RW, Dusun" required>{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="no_telp" class="block text-sm font-medium text-on-surface mb-1">No. Telepon / WhatsApp</label>
                    <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"
                           class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('no_telp') border-error @enderror"
                           placeholder="Contoh: 08123456789" required>
                    @error('no_telp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="foto_ktp" class="block text-sm font-medium text-on-surface mb-1">Foto KTP</label>
                    <label for="foto_ktp"
                           id="dropzone"
                           class="flex flex-col items-center justify-center gap-2 w-full border-2 border-dashed border-outline-variant rounded-xl px-4 py-6 cursor-pointer hover:border-primary hover:bg-slate-50 transition-all @error('foto_ktp') border-red-500 @enderror">
                        <img id="preview-img" src="" alt="Preview" class="hidden max-h-40 rounded-lg object-cover mb-1">
                        <span id="dropzone-icon" class="material-symbols-outlined text-3xl text-gray-400">upload_file</span>
                        <span id="dropzone-text" class="text-sm text-gray-600">
                            <span class="text-blue-600 font-semibold">Klik untuk unggah</span> atau seret file ke sini
                        </span>
                        <span class="text-xs text-gray-400">JPG, JPEG, atau PNG. Maks 2MB.</span>
                    </label>
                    <input type="file" name="foto_ktp" id="foto_ktp" accept="image/jpeg,image/jpg,image/png" class="hidden">
                    @error('foto_ktp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- DYNAMIC CRITERIA INPUT SECTION --}}
                @if(isset($kriterias) && $kriterias->count() > 0)
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <div class="mb-4">
                            <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                                <span class="material-symbols-outlined text-blue-600">fact_check</span>
                                Parameter Kriteria Kelayakan Bantuan
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">Silakan isi nilai indikator di bawah sesuai kondisi riil rumah tangga Anda.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($kriterias as $k)
                                <div class="p-3.5 bg-slate-50 border border-gray-200 rounded-xl space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <label for="nilai_{{ $k->id }}" class="text-xs font-bold text-gray-800">
                                            {{ $k->kode }} — {{ $k->nama }}
                                        </label>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase {{ strtolower($k->jenis) == 'benefit' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $k->jenis }}
                                        </span>
                                    </div>
                                    <div class="relative">
                                        <input type="number" step="any" name="nilai[{{ $k->id }}]" id="nilai_{{ $k->id }}"
                                               value="{{ old('nilai.' . $k->id) }}"
                                               class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-600 bg-white @error('nilai.'.$k->id) border-red-500 @enderror"
                                               placeholder="Masukkan nilai..." required>
                                    </div>
                                    @error('nilai.'.$k->id)
                                        <p class="text-red-500 text-[11px] mt-0.5">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 border-t border-gray-100 pt-4">
                <a href="{{ route('landing') }}" class="px-5 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl font-medium text-sm transition-all block">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-semibold text-sm shadow-sm transition-all active:scale-95 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">send</span>
                    Kirim Pendaftaran
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

    if (inputFoto) {
        inputFoto.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                dropzoneIcon.classList.add('hidden');
                dropzoneText.innerHTML = `<span class="text-blue-600 font-semibold">${file.name}</span> — klik untuk ganti`;
            };
            reader.readAsDataURL(file);
        });

        ['dragover', 'dragleave', 'drop'].forEach(evt => {
            dropzone.addEventListener(evt, e => e.preventDefault());
        });
        dropzone.addEventListener('dragover', () => dropzone.classList.add('border-blue-500'));
        dropzone.addEventListener('dragleave', () => dropzone.classList.remove('border-blue-500'));
        dropzone.addEventListener('drop', function (e) {
            dropzone.classList.remove('border-blue-500');
            if (e.dataTransfer.files.length) {
                inputFoto.files = e.dataTransfer.files;
                inputFoto.dispatchEvent(new Event('change'));
            }
        });
    }
</script>
@endsection
