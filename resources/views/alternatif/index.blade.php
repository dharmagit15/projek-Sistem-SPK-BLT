@extends('layouts.app')

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl text-sm flex items-center gap-2 shadow-sm">
    <span class="material-symbols-outlined text-lg">check_circle</span>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

@section('content')
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <nav class="flex items-center gap-2 text-on-surface-variant text-xs mb-2">
            <span>Dashboard</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-bold">Alternatif</span>
        </nav>
        <h2 class="text-2xl font-bold text-on-surface">Kelola Alternatif</h2>
        <p class="text-on-surface-variant text-sm mt-1">Daftar warga calon penerima bantuan langsung tunai (BLT).</p>
    </div>
    <a href="{{ route('alternatif.create') }}" class="bg-primary hover:bg-primary-container text-on-primary px-6 py-2.5 rounded-xl flex items-center gap-2 font-semibold shadow-sm transition-all active:scale-95">
        <span class="material-symbols-outlined">person_add</span>
        <span>Tambah Warga</span>
    </a>
</div>

<div class="bg-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-bright text-on-surface-variant text-xs uppercase tracking-wider border-b border-outline-variant">
                    <th class="px-6 py-4 font-semibold w-16 text-center">No</th>
                    <th class="px-6 py-4 font-semibold">NIK</th>
                    <th class="px-6 py-4 font-semibold">Nama Kepala Keluarga</th>
                    <th class="px-6 py-4 font-semibold">Alamat</th>
                    <th class="px-6 py-4 font-semibold">No. Telp</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-on-surface divide-y divide-outline-variant/30">
                @forelse($alternatifs as $index => $warga)
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="px-6 py-4 text-center text-on-surface-variant">
                        {{ $alternatifs->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4 font-mono text-xs">{{ $warga->nik }}</td>
                    <td class="px-6 py-4 font-semibold">{{ $warga->nama }}</td>
                    <td class="px-6 py-4 text-on-surface-variant">{{ $warga->alamat }}</td>
                    <td class="px-6 py-4">{{ $warga->no_telp }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($warga->status == 'Terverifikasi')
                            <span class="px-3 py-1 bg-green-100 text-green-700 border border-green-200 rounded-full text-xs font-bold">TERVERIFIKASI</span>
                        @elseif($warga->status == 'Review') 
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 border border-orange-200 rounded-full text-xs font-bold">REVIEW</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 border border-red-200 rounded-full text-xs font-bold">DITOLAK</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('alternatif.edit', $warga->id) }}" class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-fixed rounded-lg transition-all" title="Edit">
                             <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form action="{{ route('alternatif.destroy', $warga->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data warga ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-on-surface-variant hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-on-surface-variant">
                        Belum ada data warga calon penerima.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 bg-surface-bright border-t border-outline-variant">
        {{ $alternatifs->links() }}
    </div>
</div>
@endsection