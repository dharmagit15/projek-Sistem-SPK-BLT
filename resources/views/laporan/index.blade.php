@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-slate-100 flex flex-col md:flex-row md:items-end justify-between gap-6 relative overflow-hidden">
        <!-- Decorative background shape -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-semibold tracking-wide mb-3">
                <span class="material-symbols-outlined text-[16px]">insert_chart</span>
                SPK Reports
            </div>
            <h3 class="font-display text-3xl font-bold text-slate-800 tracking-tight">Laporan Peringkat Kelayakan</h3>
            <p class="text-slate-500 mt-2 max-w-xl leading-relaxed">Hasil akhir dari proses perhitungan Sistem Pendukung Keputusan (SPK) untuk menentukan penerima bantuan yang paling layak.</p>
        </div>
        
        <div class="flex flex-wrap gap-3 relative z-10">
            <button class="group flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-slate-200 text-slate-600 font-semibold rounded-xl hover:border-emerald-500 hover:text-emerald-600 transition-all duration-300 shadow-sm text-sm">
                <span class="material-symbols-outlined text-[20px] group-hover:-translate-y-0.5 transition-transform">file_download</span>
                Export Excel
            </button>
            <a href="{{ route('laporan.pdf') }}" target="_blank" class="group flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary to-blue-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 text-sm overflow-hidden relative">
                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-in-out"></div>
                <span class="material-symbols-outlined text-[20px] relative z-10">print</span>
                <span class="relative z-10">Cetak PDF</span>
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow hover:-translate-y-1 duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity group-hover:scale-110 duration-300">
                <span class="material-symbols-outlined text-7xl text-blue-600">groups</span>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 border border-blue-100">
                    <span class="material-symbols-outlined">groups</span>
                </div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Alternatif</p>
                <div class="flex items-end gap-2">
                    <h4 class="text-3xl font-bold text-slate-800">{{ number_format($totalAlternatif) }}</h4>
                    <span class="text-sm text-slate-400 mb-1 font-medium">Data</span>
                </div>
            </div>
        </div>

        <!-- Status Layak Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow hover:-translate-y-1 duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity group-hover:scale-110 duration-300">
                <span class="material-symbols-outlined text-7xl text-emerald-600">verified_user</span>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4 border border-emerald-100">
                    <span class="material-symbols-outlined">verified_user</span>
                </div>
                <p class="text-sm font-medium text-slate-500 mb-1">Status Layak</p>
                <div class="flex items-end gap-3">
                    <h4 class="text-3xl font-bold text-slate-800">{{ number_format($statusLayak) }}</h4>
                    <div class="flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded text-xs font-semibold border border-emerald-100 mb-1">
                        <span class="material-symbols-outlined text-[14px]">trending_up</span>
                        {{ $totalAlternatif > 0 ? round(($statusLayak / $totalAlternatif) * 100, 1) : 0 }}%
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Tidak Layak Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow hover:-translate-y-1 duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity group-hover:scale-110 duration-300">
                <span class="material-symbols-outlined text-7xl text-rose-600">gpp_bad</span>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center mb-4 border border-rose-100">
                    <span class="material-symbols-outlined">gpp_bad</span>
                </div>
                <p class="text-sm font-medium text-slate-500 mb-1">Tidak Layak</p>
                <div class="flex items-end gap-3">
                    <h4 class="text-3xl font-bold text-slate-800">{{ number_format($statusTidakLayak) }}</h4>
                    <div class="flex items-center gap-1 text-rose-600 bg-rose-50 px-2 py-0.5 rounded text-xs font-semibold border border-rose-100 mb-1">
                        <span class="material-symbols-outlined text-[14px]">trending_down</span>
                        {{ $totalAlternatif > 0 ? round(($statusTidakLayak / $totalAlternatif) * 100, 1) : 0 }}%
                    </div>
                </div>
            </div>
        </div>

        <!-- Rata-rata Skor Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-shadow hover:-translate-y-1 duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity group-hover:scale-110 duration-300">
                <span class="material-symbols-outlined text-7xl text-purple-600">monitoring</span>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4 border border-purple-100">
                    <span class="material-symbols-outlined">monitoring</span>
                </div>
                <p class="text-sm font-medium text-slate-500 mb-1">Rata-Rata Skor</p>
                <div class="flex items-end gap-2">
                    <h4 class="text-3xl font-bold text-slate-800">{{ number_format($rataRataSkor, 3) }}</h4>
                    <span class="text-sm text-slate-400 mb-1 font-medium">Pts</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Section -->
    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined">military_tech</span>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-slate-800">Daftar Peringkat Akhir</h4>
                    <p class="text-sm text-slate-500">Berdasarkan hasil kalkulasi metode SPK</p>
                </div>
            </div>
            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm text-sm">
                <span class="material-symbols-outlined text-slate-400 text-[18px]">calendar_month</span>
                <span class="font-medium text-slate-700">Periode {{ date('Y') }}</span>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                        <th class="px-6 py-4 w-24 text-center">Peringkat</th>
                        <th class="px-6 py-4">Data Warga</th>
                        <th class="px-6 py-4 w-72">Skor Preferensi</th>
                        <th class="px-6 py-4 text-center">Status Kelayakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($alternatifs as $index => $warga)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            @if($alternatifs->firstItem() + $index == 1)
                                <div class="w-10 h-10 mx-auto bg-gradient-to-br from-amber-300 to-amber-500 text-white rounded-xl shadow-md shadow-amber-500/20 flex items-center justify-center relative transform group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined absolute -top-2 -right-2 text-[16px] text-amber-600 animate-bounce">star</span>
                                    <span class="font-bold text-lg">1</span>
                                </div>
                            @elseif($alternatifs->firstItem() + $index == 2)
                                <div class="w-9 h-9 mx-auto bg-gradient-to-br from-slate-300 to-slate-400 text-white rounded-xl shadow-md shadow-slate-400/20 flex items-center justify-center font-bold text-base">
                                    2
                                </div>
                            @elseif($alternatifs->firstItem() + $index == 3)
                                <div class="w-9 h-9 mx-auto bg-gradient-to-br from-orange-300 to-orange-400 text-white rounded-xl shadow-md shadow-orange-400/20 flex items-center justify-center font-bold text-base">
                                    3
                                </div>
                            @else
                                <div class="w-8 h-8 mx-auto bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center font-semibold text-sm border border-slate-200">
                                    {{ $alternatifs->firstItem() + $index }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200 flex-shrink-0 uppercase">
                                    {{ substr($warga->nama, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800">{{ $warga->nama }}</div>
                                    <div class="text-xs text-slate-500 font-mono mt-0.5 tracking-tight">{{ substr($warga->nik, 0, 6) }}&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center justify-between">
                                    <span class="font-mono text-sm font-bold text-slate-700">{{ number_format($warga->skor_akhir, 4) }}</span>
                                    <span class="text-[11px] font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">{{ round($warga->skor_akhir * 100) }}%</span>
                                </div>
                                <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200/50">
                                    <div class="h-full {{ $warga->status_kelayakan == 'LAYAK' ? 'bg-gradient-to-r from-emerald-400 to-emerald-500' : 'bg-gradient-to-r from-rose-400 to-rose-500' }} rounded-full relative overflow-hidden transition-all duration-1000" style="width: {{ $warga->skor_akhir * 100 }}%">
                                        <div class="absolute top-0 right-0 bottom-0 w-8 bg-white/20 blur-[2px] transform skew-x-[-20deg] translate-x-4"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($warga->status_kelayakan == 'LAYAK')
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                    <span class="text-xs font-bold tracking-wide">LAYAK</span>
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-700 border border-rose-200 rounded-full shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]">cancel</span>
                                    <span class="text-xs font-bold tracking-wide">TIDAK LAYAK</span>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <span class="material-symbols-outlined text-6xl mb-3 text-slate-300">folder_open</span>
                                <p class="text-lg font-medium text-slate-600">Belum Ada Data</p>
                                <p class="text-sm mt-1 text-slate-500">Silakan lakukan proses perhitungan SPK terlebih dahulu pada menu penilaian.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($alternatifs->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/80">
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