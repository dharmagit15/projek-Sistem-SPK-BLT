@extends('layouts.app')

@section('content')
<div class="max-w-container-max mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h3 class="font-display-lg text-2xl font-bold text-primary">Laporan Peringkat Kelayakan</h3>
            <p class="font-body-lg text-sm text-on-surface-variant mt-1">Hasil akhir perhitungan sistem pendukung keputusan penerima bantuan.</p>
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

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white border border-outline-variant p-6 rounded-xl space-y-2 shadow-sm">
            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Total Alternatif</p>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-on-surface">{{ number_format($totalAlternatif) }}</span>
            </div>
        </div>
        <div class="bg-white border border-outline-variant p-6 rounded-xl space-y-2 shadow-sm">
            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status Layak</p>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-on-surface">{{ number_format($statusLayak) }}</span>
                <span class="text-on-surface-variant text-xs">
                    {{ $totalAlternatif > 0 ? round(($statusLayak / $totalAlternatif) * 100, 1) : 0 }}%
                </span>
            </div>
        </div>
        <div class="bg-white border border-outline-variant p-6 rounded-xl space-y-2 shadow-sm">
            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status Tidak Layak</p>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-on-surface">{{ number_format($statusTidakLayak) }}</span>
                <span class="text-on-surface-variant text-xs">
                    {{ $totalAlternatif > 0 ? round(($statusTidakLayak / $totalAlternatif) * 100, 1) : 0 }}%
                </span>
            </div>
        </div>
        <div class="bg-white border border-outline-variant p-6 rounded-xl space-y-2 shadow-sm">
            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Skor Rata-Rata</p>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-on-surface">{{ number_format($rataRataSkor, 3) }}</span>
                <span class="text-on-surface-variant text-xs">Index</span>
            </div>
        </div>
    </div>

    <div class="bg-white border border-outline-variant rounded-xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-outline-variant flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span class="text-lg font-bold text-on-surface">Daftar Peringkat Akhir</span>
                <span class="px-3 py-1 bg-surface-container text-primary rounded-full text-xs font-bold uppercase tracking-wider">Periode {{ date('Y') }}</span>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-surface-bright border-b border-outline-variant">
                    <tr class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">
                        <th class="px-6 py-4 w-24 text-center">Ranking</th>
                        <th class="px-6 py-4">NIK</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4 w-64">Skor Akhir (Preference)</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($alternatifs as $index => $warga)
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="px-6 py-4 text-center">
                            @if($alternatifs->firstItem() + $index == 1)
                                <div class="w-8 h-8 mx-auto flex items-center justify-center bg-tertiary-fixed text-on-tertiary-fixed font-bold rounded-lg shadow-sm border border-orange-200">1</div>
                            @else
                                <div class="w-8 h-8 mx-auto flex items-center justify-center bg-surface-container text-on-surface-variant font-medium rounded-lg">
                                    {{ $alternatifs->firstItem() + $index }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-on-surface-variant">{{ substr($warga->nik, 0, 6) }}**********</td>
                        <td class="px-6 py-4 font-semibold">{{ $warga->nama }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 h-2 bg-surface-container rounded-full overflow-hidden">
                                    <div class="h-full {{ $warga->status_kelayakan == 'LAYAK' ? 'bg-primary' : 'bg-error' }}" style="width: {{ $warga->skor_akhir * 100 }}%"></div>
                                </div>
                                <span class="font-mono text-xs font-bold">{{ number_format($warga->skor_akhir, 3) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($warga->status_kelayakan == 'LAYAK')
                                <span class="px-3 py-1 bg-secondary-container/40 text-on-secondary-container rounded-full text-xs font-bold tracking-wide">LAYAK</span>
                            @else
                                <span class="px-3 py-1 bg-error-container/40 text-on-error-container rounded-full text-xs font-bold tracking-wide">TIDAK LAYAK</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center font-mono text-xs text-on-surface-variant">
                            {{ $tanggalMendaftar }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant">
                            Belum ada hasil kalkulasi perangkingan bantuan sosial.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 bg-surface-bright border-t border-outline-variant">
            {{ $alternatifs->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.5s ease-out forwards;
    }
</style>
@endsection