@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-on-surface-variant text-xs mb-2">
            <span>Dashboard</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a href="{{ route('alternatif.index') }}" class="hover:underline">Alternatif</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-bold">Edit Warga</span>
        </nav>
        <h2 class="text-2xl font-bold text-on-surface">Edit Data Calon Penerima BLT</h2>
    </div>

    <div class="bg-white border border-outline-variant rounded-xl shadow-sm p-6">
        <form action="{{ route('alternatif.update', $warga->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="nik" class="block text-sm font-medium text-on-surface mb-1">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $warga->nik) }}" class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('nik') border-error @enderror" placeholder="Masukkan 16 digit NIK" required maxlength="16">
                    @error('nik') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-on-surface mb-1">Nama Kepala Keluarga</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $warga->nama) }}" class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('nama') border-error @enderror" placeholder="Nama lengkap kepala keluarga" required>
                    @error('nama') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-on-surface mb-1">Alamat Rumah</label>
                    <textarea name="alamat" id="alamat" rows="3" class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('alamat') border-error @enderror" placeholder="Alamat lengkap, RT/RW, Dusun" required>{{ old('alamat', $warga->alamat) }}</textarea>
                    @error('alamat') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="no_telp" class="block text-sm font-medium text-on-surface mb-1">No. Telepon / WhatsApp</label>
                    <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $warga->no_telp) }}" class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary @error('no_telp') border-error @enderror" placeholder="Contoh: 08123456789" required>
                    @error('no_telp') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="foto_ktp" class="block text-sm font-medium text-on-surface mb-1">Foto KTP</label>

                    @if($warga->foto_ktp)
                        <div class="flex items-center gap-4 mb-3 p-3 border border-outline-variant rounded-xl bg-surface-container-low">
                            <img src="{{ asset('storage/' . $warga->foto_ktp) }}" alt="Foto KTP saat ini" class="w-20 h-20 object-cover rounded-lg border border-outline-variant">
                            <div class="text-sm">
                                <p class="font-medium text-on-surface">Foto saat ini</p>
                                <a href="{{ asset('storage/' . $warga->foto_ktp) }}" target="_blank" class="text-primary hover:underline text-xs">Lihat ukuran penuh</a>
                            </div>
                        </div>
                    @endif

                    <label for="foto_ktp"
                           id="dropzone"
                           class="flex flex-col items-center justify-center gap-2 w-full border-2 border-dashed border-outline-variant rounded-xl px-4 py-6 cursor-pointer hover:border-primary hover:bg-surface-container-low transition-all @error('foto_ktp') border-error @enderror">
                        <img id="preview-img" src="" alt="Preview" class="hidden max-h-40 rounded-lg object-cover mb-1">
                        <span id="dropzone-icon" class="material-symbols-outlined text-3xl text-on-surface-variant">upload_file</span>
                        <span id="dropzone-text" class="text-sm text-on-surface-variant">
                            <span class="text-primary font-semibold">Klik untuk {{ $warga->foto_ktp ? 'ganti' : 'unggah' }}</span> atau seret file ke sini
                        </span>
                        <span class="text-xs text-on-surface-variant/70">JPG, JPEG, atau PNG. Maks 2MB. Kosongkan jika tidak ingin mengganti.</span>
                    </label>
                    <input type="file" name="foto_ktp" id="foto_ktp" accept="image/jpeg,image/jpg,image/png" class="hidden">

                    @error('foto_ktp') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-on-surface mb-1">Status Kelayakan</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-outline-variant rounded-lg focus:outline-none focus:border-primary">
                        <option value="Review" {{ old('status', $warga->status) == 'Review' ? 'selected' : '' }}>REVIEW</option>
                        <option value="Terverifikasi" {{ old('status', $warga->status) == 'Terverifikasi' ? 'selected' : '' }}>TERVERIFIKASI</option>
                        <option value="Ditolak" {{ old('status', $warga->status) == 'Ditolak' ? 'selected' : '' }}>DITOLAK</option>
                    </select>
                </div>

                {{-- DYNAMIC CRITERIA EDIT SECTION FOR ADMIN --}}
                @if(isset($kriterias) && $kriterias->count() > 0)
                    <div class="border-t border-outline-variant/40 pt-5 mt-5">
                        <div class="mb-4">
                            <h3 class="text-base font-bold text-on-surface flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">fact_check</span>
                                Edit Parameter Nilai Kriteria Warga
                            </h3>
                            <p class="text-xs text-on-surface-variant mt-0.5">Perbarui nilai indikator kriteria warga langsung di halaman ini.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($kriterias as $k)
                                <div class="p-3 bg-surface-container-low border border-outline-variant/60 rounded-xl space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <label for="nilai_{{ $k->id }}" class="text-xs font-bold text-on-surface">
                                            {{ $k->kode }} — {{ $k->nama }}
                                        </label>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase {{ strtolower($k->jenis) == 'benefit' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                            {{ $k->jenis }}
                                        </span>
                                    </div>
                                    <input type="number" step="any" name="nilai[{{ $k->id }}]" id="nilai_{{ $k->id }}"
                                           value="{{ old('nilai.' . $k->id, $nilaiWarga[$k->id] ?? '') }}"
                                           class="w-full px-3.5 py-2 border border-outline-variant rounded-lg text-sm focus:outline-none focus:border-primary bg-white @error('nilai.'.$k->id) border-error @enderror"
                                           placeholder="Masukkan nilai angka...">
                                    @error('nilai.'.$k->id)
                                        <p class="text-error text-[11px] mt-0.5">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 border-t border-outline-variant/30 pt-4">
                <a href="{{ route('alternatif.index') }}" class="px-5 py-2 border border-outline-variant text-on-surface-variant hover:bg-surface-container-low rounded-xl font-medium text-sm transition-all">
                    Batal
                </a>
                <button type="submit" class="bg-primary hover:bg-primary-container text-on-primary px-5 py-2 rounded-xl font-semibold text-sm shadow-sm transition-all active:scale-95">
                    Simpan Perubahan
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
            dropzoneText.innerHTML = `<span class="text-primary font-semibold">${file.name}</span> — klik untuk ganti lagi`;
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