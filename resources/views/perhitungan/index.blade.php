@extends('layouts.app') 

@section('content')
<div class="p-6">
    <div class="text-sm text-gray-500 mb-2">
        Dashboard <span class="mx-2">&gt;</span> <span class="text-blue-600 font-medium">Perhitungan</span>
    </div>

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Perhitungan Nilai Alternatif</h1>
            <p class="text-sm text-gray-500 mt-1">Input dan kelola nilai kriteria untuk setiap warga calon penerima bantuan langsung tunai (BLT).</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="#" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 font-medium rounded-lg px-4 py-2.5 inline-flex items-center text-sm transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Input Nilai Warga
            </a>

            <a href="#" class="bg-[#0b2545] hover:bg-[#133966] text-white font-medium rounded-lg px-4 py-2.5 inline-flex items-center text-sm transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Mulai Perhitungan
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs font-bold uppercase bg-gray-50 text-gray-600 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center w-16">NO</th>
                        <th scope="col" class="px-6 py-4">NAMA KEPALA KELUARGA</th>
                        
                        @foreach($kriterias as $kriteria)
                            <th scope="col" class="px-6 py-4 text-center uppercase">
                                {{ $kriteria->nama_kriteria }}
                            </th>
                        @endforeach
                        
                        <th scope="col" class="px-6 py-4 text-center w-32">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($alternatifs as $index => $alternatif)
                        <tr class="bg-white hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $alternatif->nama_kepala_keluarga }}</td>
                            
                            @foreach($kriterias as $kriteria)
                                <td class="px-6 py-4 text-center">
                                    0
                                </td>
                            @endforeach
                            
                            <td class="px-6 py-4 text-center">
                                <button class="text-blue-600 hover:text-blue-800 hover:underline font-medium">Edit Nilai</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="px-6 py-16 text-center text-gray-500 text-sm">
                                Belum ada data alternatif warga yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection