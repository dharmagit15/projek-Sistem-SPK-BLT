@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-on-surface-variant text-xs mb-2">
                <a href="{{ route('landing') }}" class="hover:underline">Beranda</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-primary font-bold">Pendaftaran Saya</span>
            </nav>
            <h2 class="text-2xl font-bold text-on-surface">Riwayat Pendaftaran SPK BLT</h2>
            <p class="text-on-surface-variant text-sm mt-1">Daftar berkas pendaftaran bantuan sosial yang telah Anda ajukan.</p>
        </div>
        <div>
            <a href="{{ route('user.pendaftaran.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm transition-all inline-flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">add</span>
                Buat Pendaftaran Baru
            </a>
        </div>
    </div>

    {{-- User Info Header --}}
    <div class="mb-6 bg-white border border-outline-variant rounded-xl p-4 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-semibold">Pengguna Terverifikasi</span>
    </div>

    {{-- Table or Card list --}}
    <div class="bg-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
        @if(isset($alternatifs) && count($alternatifs) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-gray-200 text-xs uppercase font-semibold text-gray-600">
                        <tr>
                            <th class="px-6 py-3">NIK</th>
                            <th class="px-6 py-3">Nama KK</th>
                            <th class="px-6 py-3">Alamat</th>
                            <th class="px-6 py-3">Parameter Kriteria</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($alternatifs as $item)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-mono font-medium text-gray-900">{{ $item->nik }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $item->nama }}</td>
                                <td class="px-6 py-4 text-gray-600 max-w-xs truncate">{{ $item->alamat }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-md border border-blue-200">
                                        <span class="material-symbols-outlined text-sm">fact_check</span>
                                        {{ $item->kriterias ? $item->kriterias->count() : 0 }} Terisi
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status == 'Terverifikasi')
                                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-full text-xs font-bold">Terverifikasi</span>
                                    @elseif($item->status == 'Review')
                                        <span class="px-2.5 py-1 bg-amber-100 text-amber-800 border border-amber-200 rounded-full text-xs font-bold">Review</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-rose-100 text-rose-800 border border-rose-200 rounded-full text-xs font-bold">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('user.pendaftaran.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-xs inline-flex items-center gap-1">
                                        Detail <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 px-4">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-2">assignment</span>
                <p class="text-gray-600 font-medium">Belum ada pengajuan pendaftaran SPK BLT.</p>
                <p class="text-xs text-gray-400 mt-1 mb-4">Klik tombol di bawah untuk mulai mengisi formulir pendaftaran.</p>
                <a href="{{ route('user.pendaftaran.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-semibold text-sm shadow-sm inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Isi Form Pendaftaran
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
