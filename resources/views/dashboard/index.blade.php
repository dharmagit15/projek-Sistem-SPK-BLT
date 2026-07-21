@extends('layouts.app')

@section('content')
<div class="p-6 sm:p-8 bg-slate-50 min-h-screen">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}</h2>
            <p class="text-sm text-slate-500 mt-1">Berikut adalah ringkasan data Sistem Pendukung Keputusan hari ini.</p>
        </div>
        <div>
            <a href="{{ route('perhitungan.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-[18px] mr-2">analytics</span>
                Mulai Hitung SPK
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Card 1: Total Kriteria -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between relative overflow-hidden group hover:border-blue-300 hover:shadow-md transition-all duration-200">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-blue-50/50 rounded-full blur-xl group-hover:bg-blue-100/50 transition-all"></div>
            <div class="space-y-2 z-10">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Total Kriteria</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $totalKriteria ?? 0 }}</h3>
                    <span class="text-xs font-semibold text-slate-400">Atribut</span>
                </div>
                <div>
                    <span class="inline-flex items-center text-[11px] font-semibold text-blue-700 bg-blue-50 border border-blue-200/60 px-2.5 py-0.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span> {{ $totalKriteria ?? 0 }} Kriteria Aktif
                    </span>
                </div>
            </div>
            <div class="p-3.5 bg-gradient-to-br from-blue-50 to-blue-100/80 text-blue-600 rounded-2xl border border-blue-100 shadow-sm group-hover:scale-105 transition-transform">
                <span class="material-symbols-outlined text-[28px] block">tune</span>
            </div>
        </div>

        <!-- Card 2: Total Alternatif -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between relative overflow-hidden group hover:border-amber-300 hover:shadow-md transition-all duration-200">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-amber-50/50 rounded-full blur-xl group-hover:bg-amber-100/50 transition-all"></div>
            <div class="space-y-2 z-10">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Total Alternatif</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $totalAlternatif ?? 0 }}</h3>
                    <span class="text-xs font-semibold text-slate-400">Warga</span>
                </div>
                <div>
                    <span class="inline-flex items-center text-[11px] font-semibold text-amber-700 bg-amber-50 border border-amber-200/60 px-2.5 py-0.5 rounded-full">
                        <span class="material-symbols-outlined text-[13px] mr-1">badge</span> Terdaftar KPM
                    </span>
                </div>
            </div>
            <div class="p-3.5 bg-gradient-to-br from-amber-50 to-amber-100/80 text-amber-600 rounded-2xl border border-amber-100 shadow-sm group-hover:scale-105 transition-transform">
                <span class="material-symbols-outlined text-[28px] block">groups</span>
            </div>
        </div>

        <!-- Card 3: Selesai Dinilai -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between relative overflow-hidden group hover:border-emerald-300 hover:shadow-md transition-all duration-200">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-emerald-50/50 rounded-full blur-xl group-hover:bg-emerald-100/50 transition-all"></div>
            <div class="space-y-2 z-10">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Selesai Dinilai</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $persentaseDinilai ?? 0 }}%</h3>
                    <span class="text-xs font-semibold text-emerald-600">({{ $alternatifDinilai ?? 0 }}/{{ $totalAlternatif ?? 0 }})</span>
                </div>
                <div class="w-28 bg-slate-100 h-2 rounded-full overflow-hidden border border-slate-200/50">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full transition-all duration-500" style="width: {{ $persentaseDinilai ?? 0 }}%"></div>
                </div>
            </div>
            <div class="p-3.5 bg-gradient-to-br from-emerald-50 to-emerald-100/80 text-emerald-600 rounded-2xl border border-emerald-100 shadow-sm group-hover:scale-105 transition-transform">
                <span class="material-symbols-outlined text-[28px] block">task_alt</span>
            </div>
        </div>

        <!-- Card 4: Periode Aktif -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between relative overflow-hidden group hover:border-purple-300 hover:shadow-md transition-all duration-200">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-purple-50/50 rounded-full blur-xl group-hover:bg-purple-100/50 transition-all"></div>
            <div class="space-y-2 z-10">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Periode Aktif</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight">Tahap II</h3>
                </div>
                <div>
                    <span class="inline-flex items-center text-[11px] font-semibold text-purple-700 bg-purple-50 border border-purple-200/60 px-2.5 py-0.5 rounded-full">
                        <span class="material-symbols-outlined text-[13px] mr-1">event_available</span> TA {{ date('Y') }}
                    </span>
                </div>
            </div>
            <div class="p-3.5 bg-gradient-to-br from-purple-50 to-purple-100/80 text-purple-600 rounded-2xl border border-purple-100 shadow-sm group-hover:scale-105 transition-transform">
                <span class="material-symbols-outlined text-[28px] block">calendar_today</span>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-800">Daftar Kriteria Terdaftar</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Ringkasan kriteria bobot penilaian SPK BLT.</p>
                    </div>
                    <a href="{{ route('kriteria.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline">Lihat Semua</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                <th class="py-3 px-6">Kode</th>
                                <th class="py-3 px-6">Nama Kriteria</th>
                                <th class="py-3 px-6">Tipe</th>
                                <th class="py-3 px-6">Bobot</th>
                                <th class="py-3 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700 font-medium">
                        @forelse($daftarKriteria as $kriteria)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <td class="py-3.5 px-6">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold text-xs">
                                        {{ $kriteria->kode ?? ('C' . $loop->iteration) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6">
                                    <div class="flex items-center gap-3">
                                        <span class="w-2 h-2 rounded-full {{ isset($kriteria->jenis) && strtolower(trim($kriteria->jenis)) == 'benefit' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                        <span>{{ $kriteria->nama ?? 'Nama Tidak Ditemukan' }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold {{ isset($kriteria->jenis) && strtolower(trim($kriteria->jenis)) == 'benefit' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                        {{ ucfirst(trim($kriteria->jenis ?? 'Cost')) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 font-semibold text-slate-600">
                                    {{ isset($kriteria->bobot) ? (is_numeric($kriteria->bobot) ? ($kriteria->bobot <= 1 ? ($kriteria->bobot * 100) . '%' : $kriteria->bobot) : $kriteria->bobot) : '-' }}
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <a href="{{ route('kriteria.edit', $kriteria->id) }}" class="text-slate-400 hover:text-blue-600 inline-block p-1 rounded-md hover:bg-blue-50 transition-colors" title="Edit Kriteria">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-sm text-slate-400 font-normal">Belum ada data kriteria.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="p-4 bg-slate-50/50 border-t border-slate-100 text-center">
                <span class="text-xs text-slate-400 font-medium">Total Terhitung: {{ $totalKriteria ?? 0 }} Atribut Valid</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 mb-1">Aktivitas Sistem</h3>
            <p class="text-xs text-slate-500 mb-6">Log data & aktivitas terbaru.</p>
            
            <div class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-100">
                <div class="relative">
                    <span class="absolute -left-[22px] top-1 w-3 h-3 rounded-full border-2 border-white bg-blue-600 ring-4 ring-blue-50"></span>
                    <p class="text-xs font-bold text-slate-700">Sistem Berhasil Diperbarui</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Oleh Admin • Baru Saja</p>
                </div>

                @if(isset($recentAlternatifs) && count($recentAlternatifs) > 0)
                    @foreach($recentAlternatifs as $recent)
                        <div class="relative">
                            <span class="absolute -left-[22px] top-1 w-3 h-3 rounded-full border-2 border-white bg-emerald-500 ring-4 ring-emerald-50"></span>
                            <p class="text-xs font-bold text-slate-700">Registrasi Warga: {{ $recent->nama }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">NIK: {{ $recent->nik }} • {{ $recent->created_at ? $recent->created_at->diffForHumans() : 'Baru saja' }}</p>
                        </div>
                    @endforeach
                @endif

                @if(($totalKriteria ?? 0) > 0 && ($totalAlternatif ?? 0) > 0)
                    <div class="relative">
                        <span class="absolute -left-[22px] top-1 w-3 h-3 rounded-full border-2 border-white bg-purple-600 ring-4 ring-purple-50"></span>
                        <p class="text-xs font-bold text-slate-700">Modul Perhitungan SPK (SAW)</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Siap digunakan dengan {{ $totalKriteria }} kriteria & {{ $totalAlternatif }} warga</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection