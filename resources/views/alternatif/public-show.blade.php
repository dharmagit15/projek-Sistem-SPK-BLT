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
        <p class="text-on-surface-variant text-sm mt-1">Data yang Anda kirim telah diterima. Saat ini Anda hanya dapat melihat status pengajuan.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl text-sm flex items-center gap-2 shadow-sm">
            <span class="material-symbols-outlined text-lg">check_circle</span>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white border border-outline-variant rounded-xl shadow-sm p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="text-xs uppercase text-on-surface-variant">NIK</div>
                <div class="font-semibold text-on-surface">{{ $alternatif->nik }}</div>
            </div>
            <div>
                <div class="text-xs uppercase text-on-surface-variant">Nama</div>
                <div class="font-semibold text-on-surface">{{ $alternatif->nama }}</div>
            </div>
            <div class="md:col-span-2">
                <div class="text-xs uppercase text-on-surface-variant">Alamat</div>
                <div class="font-semibold text-on-surface">{{ $alternatif->alamat }}</div>
            </div>
            <div>
                <div class="text-xs uppercase text-on-surface-variant">No. Telepon</div>
                <div class="font-semibold text-on-surface">{{ $alternatif->no_telp }}</div>
            </div>
            <div>
                <div class="text-xs uppercase text-on-surface-variant">Status Pengajuan</div>
                @if($alternatif->status == 'Terverifikasi')
                    <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 border border-green-200 rounded-full text-xs font-bold">TERVERIFIKASI</span>
                @elseif($alternatif->status == 'Review')
                    <span class="inline-flex px-3 py-1 bg-orange-100 text-orange-700 border border-orange-200 rounded-full text-xs font-bold">REVIEW</span>
                @else
                    <span class="inline-flex px-3 py-1 bg-red-100 text-red-700 border border-red-200 rounded-full text-xs font-bold">DITOLAK</span>
                @endif
            </div>
        </div>

        @if($alternatif->foto_ktp)
            <div>
                <div class="text-xs uppercase text-on-surface-variant mb-2">Foto KTP</div>
                <a href="{{ asset('storage/' . $alternatif->foto_ktp) }}" target="_blank">
                    <img src="{{ asset('storage/' . $alternatif->foto_ktp) }}" alt="Foto KTP {{ $alternatif->nama }}" class="max-h-64 rounded-xl border border-outline-variant object-cover">
                </a>
            </div>
        @endif

        <div class="border-t border-outline-variant/30 pt-4 flex justify-end">
            <a href="{{ route('landing') }}" class="bg-primary text-on-primary px-5 py-2 rounded-xl font-semibold text-sm shadow-sm transition-all hover:bg-primary-container">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
