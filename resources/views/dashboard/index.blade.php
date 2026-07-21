@extends('layouts.app')

@section('content')
<div class="p-6 sm:p-8 bg-[#f8fafc] min-h-screen">
    
    <!-- Welcoming Header Banner -->
    <div class="relative bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 shadow-xl overflow-hidden mb-8 border border-slate-800">
        <!-- Decorative Background Gradients -->
        <div class="absolute right-0 top-0 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute left-1/3 bottom-0 w-60 h-60 bg-blue-500/10 rounded-full blur-3xl -mb-20"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="space-y-1">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                    Sistem Pendukung Keputusan BLT
                </span>
                <h2 class="text-3xl font-extrabold text-white tracking-tight mt-2">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}</h2>
                <p class="text-sm text-slate-300">Kelola kriteria, penilaian alternatif, dan kalkulasi metode SAW dalam satu panel cerdas.</p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('perhitungan.index') }}" class="inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-indigo-500/20 transition-all hover:shadow-indigo-500/30 active:scale-[0.98] group">
                    <span class="material-symbols-outlined text-[20px] mr-2 group-hover:rotate-12 transition-transform">analytics</span>
                    Mulai Hitung SPK
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Card 1: Total Kriteria -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex items-center justify-between relative overflow-hidden group hover:-translate-y-1 hover:shadow-lg hover:border-blue-200 transition-all duration-200 ease-in-out">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-blue-50/40 rounded-full blur-xl group-hover:bg-blue-100/40 transition-all duration-300"></div>
            <div class="space-y-3 z-10">
                <p class="text-xs text-slate-400 uppercase font-extrabold tracking-wider">Total Kriteria</p>
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-4xl font-black text-slate-800 tracking-tight">{{ $totalKriteria ?? 0 }}</h3>
                    <span class="text-xs font-bold text-slate-400">Kriteria</span>
                </div>
                <div>
                    <span class="inline-flex items-center text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-xl border border-blue-100/50">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span>
                        Aktif Digunakan
                    </span>
                </div>
            </div>
            <div class="p-4 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-2xl shadow-md shadow-blue-500/10 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-[26px] block">tune</span>
            </div>
        </div>

        <!-- Card 2: Total Alternatif -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex items-center justify-between relative overflow-hidden group hover:-translate-y-1 hover:shadow-lg hover:border-amber-200 transition-all duration-200 ease-in-out">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-amber-50/40 rounded-full blur-xl group-hover:bg-amber-100/40 transition-all duration-300"></div>
            <div class="space-y-3 z-10">
                <p class="text-xs text-slate-400 uppercase font-extrabold tracking-wider">Total Alternatif</p>
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-4xl font-black text-slate-800 tracking-tight">{{ $totalAlternatif ?? 0 }}</h3>
                    <span class="text-xs font-bold text-slate-400">Warga</span>
                </div>
                <div>
                    <span class="inline-flex items-center text-[10px] font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-xl border border-amber-100/50">
                        <span class="material-symbols-outlined text-[12px] mr-1">badge</span>
                        KPM Terdaftar
                    </span>
                </div>
            </div>
            <div class="p-4 bg-gradient-to-br from-amber-500 to-orange-600 text-white rounded-2xl shadow-md shadow-amber-500/10 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-[26px] block">groups</span>
            </div>
        </div>

        <!-- Card 3: Total Pengguna -->
        <a href="{{ route('users.index') }}" class="bg-white p-6 rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex items-center justify-between relative overflow-hidden group hover:-translate-y-1 hover:shadow-lg hover:border-purple-200 transition-all duration-200 ease-in-out block">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-purple-50/50 rounded-full blur-xl group-hover:bg-purple-100/50 transition-all duration-300"></div>
            <div class="space-y-3 z-10">
                <p class="text-xs text-slate-400 uppercase font-extrabold tracking-wider">Total Pengguna</p>
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-4xl font-black text-slate-800 tracking-tight">{{ $totalUser ?? 0 }}</h3>
                    <span class="text-xs font-semibold text-slate-400">User</span>
                </div>
                <div>
                    <span class="inline-flex items-center text-[10px] font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-xl border border-purple-100/50">
                        <span class="material-symbols-outlined text-[12px] mr-1">manage_accounts</span>
                        Hak Akses Admin
                    </span>
                </div>
            </div>
            <div class="p-4 bg-gradient-to-br from-purple-500 to-fuchsia-600 text-white rounded-2xl shadow-md shadow-purple-500/10 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-[26px] block">manage_accounts</span>
            </div>
        </a>

        <!-- Card 4: Periode Aktif -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex items-center justify-between relative overflow-hidden group hover:-translate-y-1 hover:shadow-lg hover:border-emerald-200 transition-all duration-200 ease-in-out">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-emerald-50/40 rounded-full blur-xl group-hover:bg-emerald-100/40 transition-all duration-300"></div>
            <div class="space-y-3 z-10">
                <p class="text-xs text-slate-400 uppercase font-extrabold tracking-wider">Periode Aktif</p>
                <div class="flex items-baseline gap-1.5">
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight">Tahap II</h3>
                </div>
                <div>
                    <span class="inline-flex items-center text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-xl border border-emerald-100/50">
                        <span class="material-symbols-outlined text-[12px] mr-1">event_available</span>
                        TA {{ date('Y') }}
                    </span>
                </div>
            </div>
            <div class="p-4 bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-2xl shadow-md shadow-emerald-500/10 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-[26px] block">calendar_today</span>
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
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 text-[10px] font-extrabold uppercase tracking-wider">
                                <th class="py-4 px-6">Kode</th>
                                <th class="py-4 px-6">Nama Kriteria</th>
                                <th class="py-4 px-6">Tipe</th>
                                <th class="py-4 px-6">Bobot</th>
                                <th class="py-4 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700 font-medium">
                        @forelse($daftarKriteria as $kriteria)
                            <tr class="hover:bg-slate-50/30 transition-colors group/row">
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-bold font-mono text-xs border border-slate-200/50">
                                        {{ $kriteria->kode ?? ('C' . $loop->iteration) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <span class="w-2.5 h-2.5 rounded-full {{ isset($kriteria->jenis) && strtolower(trim($kriteria->jenis)) == 'benefit' ? 'bg-emerald-500 shadow-md shadow-emerald-500/20' : 'bg-amber-500 shadow-md shadow-amber-500/20' }}"></span>
                                        <span class="font-semibold text-slate-800">
                                            @if(is_numeric(str_replace(['.', ','], '', $kriteria->nama ?? '')))
                                                @php
                                                    $realNames = [
                                                        'C1' => 'Penghasilan Orang Tua',
                                                        'C2' => 'Jumlah Tanggungan',
                                                        'C3' => 'Kondisi Rumah',
                                                        'C4' => 'Daya Listrik',
                                                        'C5' => 'Status Kepemilikan Rumah',
                                                    ];
                                                    $kriteriaCode = $kriteria->kode ?? ('C' . $loop->iteration);
                                                @endphp
                                                {{ $realNames[$kriteriaCode] ?? ('Kriteria ' . $kriteriaCode) }}
                                            @else
                                                {{ $kriteria->nama ?? 'Nama Tidak Ditemukan' }}
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ isset($kriteria->jenis) && strtolower(trim($kriteria->jenis)) == 'benefit' ? 'bg-emerald-50 text-emerald-700 border-emerald-200/60' : 'bg-amber-50 text-amber-700 border-amber-200/60' }}">
                                        {{ ucfirst(trim($kriteria->jenis ?? 'Cost')) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-semibold text-slate-500">
                                    {{ isset($kriteria->bobot) ? (is_numeric($kriteria->bobot) ? ($kriteria->bobot <= 1 ? ($kriteria->bobot * 100) . '%' : $kriteria->bobot) : $kriteria->bobot) : '-' }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('kriteria.edit', $kriteria->id) }}" class="p-2 rounded-lg bg-gray-100 hover:bg-blue-50 text-gray-600 hover:text-blue-600 transition-all inline-flex items-center justify-center" title="Edit Kriteria">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-sm text-slate-400 font-normal">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <span class="material-symbols-outlined text-[40px] text-slate-300">inbox</span>
                                        <p>Belum ada data kriteria terdaftar.</p>
                                    </div>
                                </td>
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

        <!-- Right Panel: Aktivitas Sistem -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] p-6 flex flex-col justify-between">
            <div>
                <h3 class="font-black text-slate-800 tracking-tight text-lg mb-1">Aktivitas Sistem</h3>
                <p class="text-xs text-slate-400 mb-6">Log data & aktivitas terbaru hari ini.</p>
                
                <div class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-100">
                    
                    <!-- Standard Update -->
                    <div class="relative group/timeline">
                        <span class="absolute -left-[23px] top-1 w-3 h-3 rounded-full border-2 border-white bg-blue-600 ring-4 ring-blue-50/80 group-hover/timeline:scale-110 transition-transform"></span>
                        <p class="text-xs font-bold text-slate-800">Sistem Berhasil Diperbarui</p>
                        <p class="text-[10px] text-slate-400 mt-1 font-medium">Oleh Admin • Baru Saja</p>
                    </div>

                    @if(isset($recentAlternatifs) && count($recentAlternatifs) > 0)
                        @foreach($recentAlternatifs as $recent)
                            <div class="relative group/timeline">
                                <span class="absolute -left-[23px] top-1 w-3 h-3 rounded-full border-2 border-white bg-emerald-500 ring-4 ring-emerald-50/80 group-hover/timeline:scale-110 transition-transform"></span>
                                <p class="text-xs font-bold text-slate-800">Registrasi Warga: {{ $recent->nama }}</p>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">NIK: {{ $recent->nik }} • {{ $recent->created_at ? $recent->created_at->diffForHumans() : 'Baru saja' }}</p>
                            </div>
                        @endforeach
                    @endif

                    @if(($totalKriteria ?? 0) > 0 && ($totalAlternatif ?? 0) > 0)
                        <div class="relative group/timeline">
                            <span class="absolute -left-[23px] top-1 w-3 h-3 rounded-full border-2 border-white bg-purple-600 ring-4 ring-purple-50/80 group-hover/timeline:scale-110 transition-transform"></span>
                            <p class="text-xs font-bold text-slate-800">Modul Perhitungan SPK (SAW)</p>
                            <p class="text-[10px] text-slate-400 mt-1 font-medium">Siap digunakan dengan {{ $totalKriteria }} kriteria & {{ $totalAlternatif }} warga</p>
                        </div>
                    @endif
                </div>
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