@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">edit_document</span>
            Input Nilai Kriteria
        </h2>
        <p class="text-gray-600 text-sm mt-1">
            Mengisi nilai untuk warga: <span class="font-semibold text-gray-900">{{ $warga->nama }}</span>
        </p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <h3 class="font-bold text-gray-700 m-0">Form Penilaian</h3>
            <span class="text-[10px] font-bold bg-blue-100 text-blue-700 px-3 py-1 rounded-full uppercase tracking-wider">
                ID: {{ $warga->id }}
            </span>
        </div>

        <form action="{{ url('/admin/penilaian/store/' . $warga->id) }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                @foreach($kriterias as $k)
                <div class="group">
                    {{-- Judul Input Dinamis: Gabungan Kode & Keterangan --}}
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-bold text-gray-700 flex items-center gap-2">
                            <span class="text-blue-600 font-mono font-extrabold text-xs bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-md">
                                {{ $k->kode ?? 'C'.$loop->iteration }}
                            </span>
                            <span>{{ $k->nama_kriteria ?? $k->nama }}</span>
                        </label>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ strtolower($k->jenis) == 'benefit' ? 'bg-green-50 text-green-700' : 'bg-orange-50 text-orange-700' }}">
                            {{ strtoupper($k->jenis) }}
                        </span>
                    </div>
                    
                    <div class="relative">
                        <input type="number" step="any" name="nilai[{{ $k->id }}]" 
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm group-hover:bg-white"
                            value="{{ $nilaiWarga[$k->id] ?? '' }}" 
                            placeholder="Masukkan nilai asli (contoh: 85)" required>
                    </div>
                    <div class="mt-1 flex items-center gap-1 text-gray-400 text-[11px]">
                        <span class="material-symbols-outlined text-[12px]">info</span>
                        Bobot Kriteria: <span class="font-semibold text-gray-600">{{ str_replace('.', ',', rtrim(rtrim($k->bobot, '0'), '.')) }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-3">
                <a href="{{ url('/admin/perhitungan') }}" 
                   class="flex-1 text-center px-5 py-3 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-all">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-[2] px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection