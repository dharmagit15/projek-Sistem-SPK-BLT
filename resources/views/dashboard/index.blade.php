@extends('layouts.app')

@section('content')
<div class="p-6 sm:p-8 bg-slate-50 min-h-screen">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang, Admin</h2>
            <p class="text-sm text-slate-500 mt-1">Berikut adalah ringkasan data Sistem Pendukung Keputusan hari ini.</p>
        </div>
        <div>
            <a href="{{ route('perhitungan.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-[18px] mr-2">analytics</span>
                Mulai Hitung SPK
            </a>
        </div>
    </div>

    <!-- 4 Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden group hover:border-slate-300 transition-all">
            <div class="space-y-2 z-10">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Total Kriteria</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalKriteria ?? 0 }}</h3>
                <span class="inline-flex items-center text-[11px] font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                    <span class="material-symbols-outlined text-[12px] mr-0.5 font-bold">arrow_upward</span> Aktif
                </span>
            </div>
            <div class="p-4 bg-blue-50 text-blue-600 rounded-xl transition-colors group-hover:bg-blue-100">
                <span class="material-symbols-outlined text-[28px] block">rule</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden group hover:border-slate-300 transition-all">
            <div class="space-y-2 z-10">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Total Alternatif</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalAlternatif ?? 0 }}</h3>
                <span class="inline-flex items-center text-[11px] font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                    Masyarakat/KPM
                </span>
            </div>
            <div class="p-4 bg-amber-50 text-amber-600 rounded-xl transition-colors group-hover:bg-amber-100">
                <span class="material-symbols-outlined text-[28px] block">groups</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden group hover:border-slate-300 transition-all">
            <div class="space-y-2 z-10">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Selesai Dinilai</p>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $persentaseDinilai ?? 0 }}%</h3>
                <div class="w-24 bg-slate-100 h-1.5 rounded-full mt-2 overflow-hidden">
                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $persentaseDinilai ?? 0 }}%"></div>
                </div>
            </div>
            <div class="p-4 bg-emerald-50 text-emerald-600 rounded-xl transition-colors group-hover:bg-emerald-100">
                <span class="material-symbols-outlined text-[28px] block">task_alt</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between relative overflow-hidden group hover:border-slate-300 transition-all">
            <div class="space-y-2 z-10">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Periode Aktif</p>
                <h3 class="text-xl font-bold text-slate-800">Tahap II</h3>
                <span class="text-xs text-slate-400 block font-medium">TA 2026</span>
            </div>
            <div class="p-4 bg-purple-50 text-purple-600 rounded-xl transition-colors group-hover:bg-purple-100">
                <span class="material-symbols-outlined text-[28px] block">calendar_today</span>
            </div>
        </div>

    </div>

    <!-- Main Content Panels -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Panel: Table Kriteria -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-black text-slate-800 tracking-tight text-lg">Daftar Kriteria Terdaftar</h3>
                        <p class="text-xs text-slate-400 mt-1">Ringkasan kriteria bobot penilaian SPK BLT.</p>
                    </div>
                    <a href="{{ route('kriteria.index') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100/80 px-3 py-1.5 rounded-xl transition-colors">
                        Lihat Semua
                        <span class="material-symbols-outlined text-[16px] ml-1">arrow_forward</span>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                <th class="py-3 px-6">Nama Kriteria</th>
                                <th class="py-3 px-6">Tipe</th>
                                <th class="py-3 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700 font-medium">
                        @forelse($daftarKriteria as $kriteria)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <td class="py-3.5 px-6">
                                    <div class="flex items-center gap-3">
                                        <span class="w-2 h-2 rounded-full {{ isset($kriteria->jenis) && strtolower($kriteria->jenis) == 'benefit' ? 'bg-emerald-500' : 'bg-blue-500' }}"></span>
                                        <span>{{ $kriteria->nama ?? 'Nama Tidak Ditemukan' }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold {{ isset($kriteria->jenis) && strtolower($kriteria->jenis) == 'benefit' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                        {{ ucfirst($kriteria->jenis ?? 'Cost') }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <a href="{{ route('kriteria.edit', $kriteria->id) }}" class="text-slate-400 hover:text-blue-600 inline-block">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-sm text-slate-400 font-normal">Belum ada data kriteria.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="p-4 bg-slate-50/50 border-t border-slate-100 text-center">
                <span class="text-xs text-slate-400 font-medium">Total Terhitung: <strong class="text-slate-700 font-bold">{{ $totalKriteria ?? 0 }}</strong> Atribut Valid</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 mb-1">Aktivitas Sistem</h3>
            <p class="text-xs text-slate-500 mb-6">Log data terakhir.</p>
            
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
            
            <div class="pt-6 mt-6 border-t border-slate-50 flex items-center justify-between text-xs text-slate-400">
                <span>Status Server</span>
                <span class="inline-flex items-center gap-1 font-bold text-emerald-600">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                    Online
                </span>
            </div>
        </div>

    </div>
</div>
@endsection