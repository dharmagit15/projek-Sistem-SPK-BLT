@extends('layouts.app')

@section('content')
<div class="max-w-container-max mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h3 class="font-display-lg text-2xl font-bold text-primary">Laporan Data Penerima Bantuan</h3>
            <p class="font-body-lg text-sm text-on-surface-variant mt-1">Daftar keseluruhan warga calon penerima bantuan langsung tunai (BLT) berdasarkan kriteria pencarian.</p>
        </div>
        <div class="flex gap-3">
            {{-- Tombol Export Excel dengan Query String --}}
            <a href="{{ route('laporan.excel', request()->query()) }}" class="flex items-center gap-2 px-6 py-2.5 bg-white border border-primary text-primary font-semibold rounded-lg hover:bg-primary/5 transition-colors text-sm">
                <span class="material-symbols-outlined text-[20px]">file_download</span>
                Export Excel
            </a>
            {{-- Tombol Cetak PDF dengan Query String --}}
            <a href="{{ route('laporan.pdf', request()->query()) }}" target="_blank" class="flex items-center gap-2 px-6 py-2.5 bg-primary text-on-primary font-semibold rounded-lg hover:opacity-90 transition-opacity shadow-lg shadow-primary/20 text-sm">
                <span class="material-symbols-outlined text-[20px]">print</span>
                Cetak Laporan PDF
            </a>
        </div>
    </div>

    {{-- FORM PENCARIAN & FILTER LAPORAN (Query Dinamis) --}}
    <form action="{{ request()->url() }}" method="GET" class="bg-white border border-outline-variant rounded-xl shadow-sm p-4 flex flex-col md:flex-row gap-3 md:items-center">
        <div class="relative flex-1">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">search</span>
            <input
                type="text"
                name="search"
                value="{{ $search ?? request('search') }}"
                placeholder="Cari NIK, nama, atau alamat di laporan..."
                class="w-full pl-10 pr-4 py-2.5 border border-outline-variant rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/40"
            >
        </div>

        <select name="status" class="border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
            <option value="">Semua Status</option>
            <option value="Terverifikasi" @selected(($status ?? request('status')) === 'Terverifikasi')>Terverifikasi</option>
            <option value="Review" @selected(($status ?? request('status')) === 'Review')>Review</option>
            <option value="Ditolak" @selected(($status ?? request('status')) === 'Ditolak')>Ditolak</option>
        </select>

        <select name="per_page" class="border border-outline-variant rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/40">
            @foreach([10, 25, 50, 100] as $opt)
                <option value="{{ $opt }}" @selected((int)($perPage ?? request('per_page', 10)) === $opt)>{{ $opt }} / halaman</option>
            @endforeach
        </select>

        <button type="submit" class="bg-primary hover:bg-primary-container text-on-primary px-6 py-2.5 rounded-xl font-semibold shadow-sm transition-all active:scale-95">
            Terapkan
        </button>

        @if(request('search') || request('status'))
            <a href="{{ request()->url() }}" class="text-sm text-on-surface-variant hover:text-primary underline text-center">
                Reset
            </a>
        @endif
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-outline-variant p-6 rounded-xl space-y-2 shadow-sm">
            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Total Penerima Ditemukan</p>
            <div class="flex items-baseline gap-2">
                {{-- Menggunakan total() dari pagination agar dinamis mengikuti hasil pencarian --}}
                <span class="text-3xl font-bold text-on-surface">{{ number_format($alternatifs->total()) }}</span>
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
                        <th class="px-4 py-4 text-center">Status</th>
                        <th class="px-4 py-4 text-center">Tanggal Mendaftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50 text-sm text-on-surface">
                    @forelse($alternatifs as $index => $warga)
                    @php
                        $nik = data_get($warga, 'nik', '0000000000000000');
                        $nama = data_get($warga, 'nama', '-');
                        $alamat = data_get($warga, 'alamat', '-');
                        $no_telp = data_get($warga, 'no_telp', '-');
                        $statusWarga = data_get($warga, 'status', 'Review');
                        
                        $createdAt = data_get($warga, 'created_at');
                        $tanggalMendaftar = '-';
                        
                        if ($createdAt) {
                            if (is_object($createdAt) && method_exists($createdAt, 'format')) {
                                $tanggalMendaftar = $createdAt->format('d-m-Y');
                            } else {
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
                        <td class="px-4 py-4 text-center">
                            @if($statusWarga == 'Terverifikasi')
                                <span class="px-3 py-1 bg-green-100 text-green-700 border border-green-200 rounded-full text-xs font-bold">TERVERIFIKASI</span>
                            @elseif($statusWarga == 'Review') 
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 border border-orange-200 rounded-full text-xs font-bold">REVIEW</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 border border-red-200 rounded-full text-xs font-bold">DITOLAK</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center font-mono text-xs text-on-surface-variant">
                            {{ $tanggalMendaftar }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant">
                            Tidak ada data warga yang sesuai dengan kriteria pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 bg-surface-bright border-t border-outline-variant">
            {{-- appends() menjaga parameter pencarian tetap ada saat berpindah halaman/page --}}
            {{ $alternatifs->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection