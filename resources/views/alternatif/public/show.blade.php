@extends('layouts.public')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-on-surface-variant text-xs mb-2">
            <a href="{{ route('landing') }}" class="hover:underline">Beranda</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-bold">Status Pengajuan</span>
        </nav>
        <h2 class="text-2xl font-bold text-on-surface">Status Pengajuan SPK BLT</h2>
        <p class="text-on-surface-variant text-sm mt-1">Data pendaftaran Anda telah tersimpan dan siap diproses dalam Sistem Pendukung Keputusan BLT.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-xl text-sm flex items-center gap-3 shadow-sm">
            <span class="material-symbols-outlined text-xl text-emerald-600">check_circle</span>
            <div>
                <p class="font-semibold text-emerald-900">Pendaftaran Berhasil!</p>
                <p class="text-xs text-emerald-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500 text-amber-900 rounded-xl text-sm flex items-center gap-3 shadow-sm">
            <span class="material-symbols-outlined text-xl text-amber-600">info</span>
            <div>
                <p class="font-semibold text-amber-950">Informasi Pendaftaran</p>
                <p class="text-xs text-amber-800">{{ session('info') }}</p>
            </div>
        </div>
    @endif

    {{-- User badge --}}
    <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-4 text-sm flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-blue-600">person</span>
            <div>
                <p class="font-semibold text-blue-900">Akun Pengaju: {{ auth()->user()->name }}</p>
                <p class="text-xs text-blue-700">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Tersambung</span>
    </div>

    <div class="bg-white border border-outline-variant rounded-xl shadow-sm p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="text-xs uppercase font-semibold text-gray-500 mb-1">NIK</div>
                <div class="font-semibold text-gray-900 text-base">{{ $alternatif->nik }}</div>
            </div>
            <div>
                <div class="text-xs uppercase font-semibold text-gray-500 mb-1">Nama Kepala Keluarga</div>
                <div class="font-semibold text-gray-900 text-base">{{ $alternatif->nama }}</div>
            </div>
            <div class="md:col-span-2">
                <div class="text-xs uppercase font-semibold text-gray-500 mb-1">Alamat Rumah</div>
                <div class="font-medium text-gray-800">{{ $alternatif->alamat }}</div>
            </div>
            <div>
                <div class="text-xs uppercase font-semibold text-gray-500 mb-1">No. Telepon / WA</div>
                <div class="font-medium text-gray-800">{{ $alternatif->no_telp }}</div>
            </div>
            <div>
                <div class="text-xs uppercase font-semibold text-gray-500 mb-1">Status Pengajuan</div>
                @if($alternatif->status == 'Terverifikasi')
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-full text-xs font-bold">
                        <span class="material-symbols-outlined text-sm">verified</span> TERVERIFIKASI
                    </span>
                @elseif($alternatif->status == 'Review')
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-100 text-amber-800 border border-amber-200 rounded-full text-xs font-bold">
                        <span class="material-symbols-outlined text-sm">hourglass_top</span> REVIEW / MENUNGGU
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-rose-100 text-rose-800 border border-rose-200 rounded-full text-xs font-bold">
                        <span class="material-symbols-outlined text-sm">cancel</span> DITOLAK
                    </span>
                @endif
            </div>
        </div>

        @if($alternatif->foto_ktp)
            <div class="border-t border-gray-100 pt-4">
                <div class="text-xs uppercase font-semibold text-gray-500 mb-2">Dokumen Foto KTP</div>
                <a href="{{ asset('storage/' . $alternatif->foto_ktp) }}" target="_blank" class="inline-block group">
                    <img src="{{ asset('storage/' . $alternatif->foto_ktp) }}" alt="Foto KTP {{ $alternatif->nama }}" class="max-h-64 rounded-xl border border-gray-200 object-cover group-hover:opacity-90 transition-all">
                </a>
            </div>
        @endif

        {{-- Display Submitted Criteria Values --}}
        @if($alternatif->kriterias && $alternatif->kriterias->count() > 0)
            <div class="border-t border-gray-100 pt-4">
                <div class="text-xs uppercase font-semibold text-gray-500 mb-3 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base text-blue-600">fact_check</span>
                    Rincian Nilai Parameter Kriteria
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($alternatif->kriterias as $k)
                        <div class="p-3 bg-slate-50 border border-gray-200/80 rounded-xl flex justify-between items-center">
                            <div>
                                <span class="text-xs font-semibold text-gray-700 block">{{ $k->kode }} — {{ $k->nama }}</span>
                                <span class="text-[10px] text-gray-400 font-mono">Jenis: {{ $k->jenis }}</span>
                            </div>
                            <span class="font-bold text-blue-700 text-sm bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-lg">
                                {{ $k->pivot->nilai }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
            <a href="{{ route('user.pendaftaran.index') }}" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">list_alt</span> Lihat Pendaftaran Saya
            </a>
            <a href="{{ route('landing') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-semibold text-sm shadow-sm transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">home</span> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
