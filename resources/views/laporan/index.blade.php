@extends('layouts.app')

@section('content')
<div class="max-w-container-max mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h3 class="font-display-lg text-2xl font-bold text-primary">Laporan Data Penerima Bantuan</h3>
            <p class="font-body-lg text-sm text-on-surface-variant mt-1">Daftar keseluruhan warga calon penerima bantuan langsung tunai (BLT) berdasarkan urutan pendaftaran.</p>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 px-6 py-2.5 bg-white border border-primary text-primary font-semibold rounded-lg hover:bg-primary/5 transition-colors text-sm">
                <span class="material-symbols-outlined text-[20px]">file_download</span>
                Export Excel
            </button>
            <a href="{{ route('laporan.pdf') }}" target="_blank" class="flex items-center gap-2 px-6 py-2.5 bg-primary text-on-primary font-semibold rounded-lg hover:opacity-90 transition-opacity shadow-lg shadow-primary/20 text-sm">
                <span class="material-symbols-outlined text-[20px]">print</span>
                Cetak Laporan PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-outline-variant p-6 rounded-xl space-y-2 shadow-sm">
            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Total Penerima Terdaftar</p>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-on-surface">{{ number_format($totalAlternatif) }}</span>
                <span class="text-on-surface-variant text-xs">Warga</span>
            </div>
        </div>
        <div class="bg-white border border-outline-variant p-6 rounded-xl space-y-2 shadow-sm">
            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Periode Laporan</p>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-on-surface">{{ date('Y') }}</span>
                <span class="text-on-surface-variant text-xs">Tahun Berjalan</span>
            </div>
        </div>
    </div>

    <div class="bg-white border border-outline-variant rounded-xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-outline-variant flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span class="text-lg font-bold text-on-surface">Daftar Penerima Bantuan</span>
                <span class="px-3 py-1 bg-surface-container text-primary rounded-full text-xs font-bold uppercase tracking-wider">Periode {{ date('Y') }}</span>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-surface-bright border-b border-outline-variant">
                    <tr class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">
                        <th class="px-4 py-4 w-16 text-center">No</th>
                        <th class="px-4 py-4">NIK</th>
                        <th class="px-4 py-4">Nama Lengkap</th>
                        <th class="px-4 py-4">Alamat</th>
                        <th class="px-4 py-4">No. Telp</th>
                        <th class="px-4 py-4 text-center">Tanggal Mendaftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50 text-sm text-on-surface">
                    @forelse($alternatifs as $index => $warga)
                    @php
                        // Memastikan pembacaan data mendukung Object maupun Array dari Database
                        $nik = data_get($warga, 'nik', '0000000000000000');
                        $nama = data_get($warga, 'nama', '-');
                        $alamat = data_get($warga, 'alamat', '-');
                        $no_telp = data_get($warga, 'no_telp', '-');
                        
                        // Mengambil created_at secara aman baik tipe Carbon, String, maupun Object
                        $createdAt = data_get($warga, 'created_at');
                        $tanggalMendaftar = '-';
                        
                        if ($createdAt) {
                            // Jika formatnya berupa objek Carbon bawaan Eloquent
                            if (is_object($createdAt) && method_exists($createdAt, 'format')) {
                                $tanggalMendaftar = $createdAt->format('d-m-Y');
                            } else {
                                // Jika formatnya string murni dari database (Query Builder)
                                $tanggalMendaftar = date('d-m-Y', strtotime($createdAt));
                            }
                        }
                    @endphp
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="px-4 py-4 text-center text-on-surface-variant font-medium">
                            {{ $alternatifs->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-4 font-mono text-xs text-on-surface-variant">
                            {{ substr($nik, 0, 6) }}**********
                        </td>
                        <td class="px-4 py-4 font-semibold">
                            {{ $nama }}
                        </td>
                        <td class="px-4 py-4 text-xs text-on-surface-variant max-w-xs truncate" title="{{ $alamat }}">
                            {{ $alamat }}
                        </td>
                        <td class="px-4 py-4 text-xs">
                            {{ $no_telp }}
                        </td>
                        <td class="px-4 py-4 text-center font-mono text-xs text-on-surface-variant">
                            {{ $tanggalMendaftar }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">
                            Belum ada data warga penerima bantuan sosial yang terdaftar.
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
</div>
@endsection 