@extends('layouts.app')

@section('content')
<div class="w-full">

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="flex justify-between items-center bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-sm">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-green-500">check_circle</span>
            <p class="text-green-700 text-sm font-medium m-0"><strong>Sukses!</strong> {{ session('success') }}</p>
        </div>
        <button type="button" class="text-green-700 hover:bg-green-100 p-1 rounded-md transition-colors" data-bs-dismiss="alert" aria-label="Close">
            <span class="material-symbols-outlined text-sm">close</span>
        </button>
    </div>
    @endif
    
    {{-- 1. Matriks Keputusan --}}
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant mb-8 overflow-hidden">
        <div class="bg-primary px-6 py-4 flex items-center gap-3">
            <span class="material-symbols-outlined text-on-primary">    </span>
            <h5 class="text-on-primary font-bold text-lg m-0">1. Matriks Keputusan (Nilai Asli Warga)</h5>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="text-xs uppercase bg-surface-container-low text-on-surface border-b border-outline-variant">
                    <tr>
                        <th class="px-6 py-4 text-center font-bold border-r border-outline-variant/30 w-16">No</th>
                        <th class="px-6 py-4 font-bold border-r border-outline-variant/30">Nama Warga</th>
                        {{-- Mengambil Kode dan Keterangan Kriteria secara Dinamis --}}
                        @foreach($kriterias as $k)
                            <th class="px-4 py-4 text-center font-bold border-r border-outline-variant/30">
                                <span class="block text-primary font-extrabold text-xs uppercase tracking-wider">
                                    {{ $k->kode ?? 'C'.$loop->iteration }}
                                </span>
                                <span class="block text-on-surface font-medium text-[11px] mt-0.5 normal-case text-muted">
                                    {{ $k->nama_kriteria ?? $k->nama }}
                                </span>
                                <span class="inline-block mt-1 text-on-surface-variant text-[9px] font-bold bg-surface-container py-0.5 px-2 rounded-full">
                                    ({{ ucfirst(trim($k->jenis)) }})
                                </span>
                            </th>
                        @endforeach
                        <th class="px-6 py-4 text-center font-bold">Aksi Integrasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($hasilRanking as $row)
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="px-6 py-4 text-center font-semibold text-on-surface-variant">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-semibold text-on-surface">{{ $row['nama'] }}</td>
                        @foreach($kriterias as $k)
                            <td class="px-4 py-4 text-center text-on-surface">
                                {{ number_format($row['detail_nilai_asli'][$k->id] ?? 0, 0, ',', '.') }}
                            </td>
                        @endforeach
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('penilaian.create', $row['id']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded-lg text-xs font-bold transition-colors">
                                <span class="material-symbols-outlined text-[16px]">edit_note</span> Isi / Ubah Nilai
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($kriterias) + 3 }}" class="px-6 py-8 text-center text-on-surface-variant bg-surface">Data alternatif masih kosong.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 2. Matriks Normalisasi --}}
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant mb-8 overflow-hidden">
        <div class="bg-sky-600 px-6 py-4 flex items-center gap-3">
            <span class="material-symbols-outlined text-white">tune</span>
            <h5 class="text-white font-bold text-lg m-0">2. Matriks Normalisasi (Nilai R)</h5>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="text-xs uppercase bg-sky-50 text-sky-900 border-b border-sky-100">
                    <tr>
                        <th class="px-6 py-4 text-center font-bold border-r border-sky-100 w-16">No</th>
                        <th class="px-6 py-4 font-bold border-r border-sky-100">Nama Warga</th>
                        {{-- Mengambil Kode dan Keterangan Kriteria secara Dinamis --}}
                        @foreach($kriterias as $k)
                            <th class="px-4 py-4 text-center font-bold border-r border-sky-100">
                                <span class="block text-sky-700 font-extrabold text-xs uppercase tracking-wider">
                                    {{ $k->kode ?? 'C'.$loop->iteration }}
                                </span>
                                <span class="block text-sky-900 font-medium text-[11px] mt-0.5 normal-case">
                                    {{ $k->nama_kriteria ?? $k->nama }}
                                </span>
                                <span class="inline-block mt-1 text-sky-600/70 text-[9px] font-bold bg-sky-100 py-0.5 px-2 rounded-full">
                                    ({{ ucfirst(trim($k->jenis)) }})
                                </span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($hasilRanking as $row)
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="px-6 py-4 text-center font-semibold text-on-surface-variant">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-semibold text-on-surface">{{ $row['nama'] }}</td>
                        @foreach($kriterias as $k)
                            <td class="px-4 py-4 text-center font-semibold text-sky-600">
                                {{ number_format($row['detail_normalisasi'][$k->id] ?? 0, 3, ',', '.') }}
                            </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($kriterias) + 2 }}" class="px-6 py-8 text-center text-on-surface-variant bg-surface">Data normalisasi masih kosong.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 3. Hasil Perankingan Akhir --}}
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant mb-8 overflow-hidden">
        <div class="bg-emerald-600 px-6 py-4 flex items-center gap-3">
            <span class="material-symbols-outlined text-white"></span>
            <h5 class="text-white font-bold text-lg m-0">3. Hasil Perankingan Akhir (Nilai V)</h5>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-emerald-50 text-emerald-900 border-b border-emerald-100">
                    <tr>
                        <th class="px-6 py-4 text-center font-bold w-32">Ranking</th>
                        <th class="px-6 py-4 font-bold">NIK</th>
                        <th class="px-6 py-4 font-bold">Nama Warga</th>
                        <th class="px-6 py-4 font-bold">Alamat</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 text-center font-bold">Simulasi Rumus (Bobot * R)</th>
                        <th class="px-6 py-4 text-right font-bold w-40">Skor Akhir (V)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($hasilRanking as $index => $row)
                    <tr class="{{ $index == 0 ? 'bg-yellow-50/50' : 'hover:bg-surface-container-lowest' }} transition-colors">
                        <td class="px-6 py-4 text-center">
                            @if($index == 0)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-400 text-yellow-900 rounded-full text-xs font-bold shadow-sm"> Rank 1</span>
                            @elseif($index == 1)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-bold shadow-sm"> Rank 2</span>
                            @elseif($index == 2)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-orange-200 text-orange-800 rounded-full text-xs font-bold shadow-sm"> Rank 3</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 bg-surface-container text-on-surface-variant border border-outline-variant rounded-full text-xs font-bold">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-on-surface-variant whitespace-nowrap">{{ $row['nik'] }}</td>
                        <td class="px-6 py-4 font-bold text-on-surface whitespace-nowrap">{{ $row['nama'] }}</td>
                        <td class="px-6 py-4 text-on-surface-variant min-w-[150px]">{{ $row['alamat'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                {{ $row['status'] == 'Terverifikasi' ? 'bg-green-100 text-green-700' : ($row['status'] == 'Review' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ $row['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-[13px]">
                            <code class="px-2 py-1 bg-surface-container rounded text-on-surface font-mono tracking-tight text-xs block min-w-[200px]">
                                {{ $row['teks_rumus'] ?? '-' }}
                            </code>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-[17px] font-extrabold text-emerald-600">
                                {{ number_format($row['skor_akhir'], 4, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-on-surface-variant bg-surface">Belum ada data perhitungan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection