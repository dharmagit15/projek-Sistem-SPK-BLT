@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    
    {{-- Header Breadcrumb & Judul --}}
    <div class="mb-6">
        <nav class="flex items-center gap-2 text-on-surface-variant text-xs mb-2">
            <span>Penilaian</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-bold">Input Nilai</span>
        </nav>
        <h2 class="text-2xl font-bold text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-3xl">edit_document</span>
            Integrasi Parameter Kriteria
        </h2>
        <p class="text-on-surface-variant text-sm mt-1">
            Form pengisian nilai asli warga untuk: <strong class="text-on-surface">{{ $warga->nama }}</strong>
        </p>
    </div>

    {{-- Card Form --}}
    <div class="bg-white border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
        <div class="bg-surface-container-lowest border-b border-outline-variant px-6 py-4 flex justify-between items-center">
            <h3 class="font-bold text-primary m-0">Input Nilai Kriteria</h3>
            <span class="text-xs font-mono bg-primary/10 text-primary px-3 py-1 rounded-full">ID: {{ $warga->nik ?? $warga->id }}</span>
        </div>
        
        <div class="p-6">
            <form action="{{ url('admin/penilaian/store/' . $warga->id) }}" method="POST">
                @csrf
                
                <div class="space-y-5">
                    @foreach($kriterias as $k)
                    <div class="group">
                        <label class="flex items-center gap-2 mb-2">
                            <span class="font-semibold text-on-surface text-sm">{{ $k->nama_kriteria }}</span>
                            
                            {{-- Badge Benefit / Cost --}}
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold tracking-wide uppercase 
                                {{ strtolower($k->jenis) == 'benefit' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $k->jenis }}
                            </span>

                            {{-- Menampilkan Bobot (jika ada di database Anda) --}}
                            @if(isset($k->bobot))
                                <span class="text-on-surface-variant text-xs ml-auto">Bobot: <strong>{{ $k->bobot }}</strong></span>
                            @endif
                        </label>
                        
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-on-surface-variant text-[18px] group-focus-within:text-primary transition-colors">
                                    numbers
                                </span>
                            </div>
                            <input type="number" step="any" name="nilai[{{ $k->id }}]" 
                                   class="w-full pl-10 pr-4 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-xl text-on-surface text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" 
                                   value="{{ $nilaiWarga[$k->id] ?? '' }}" 
                                   placeholder="Masukkan nilai angka..." required>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Action Buttons --}}
                <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-outline-variant">
                    <a href="{{ url('admin/penilaian') }}" class="px-5 py-2.5 rounded-xl border border-outline-variant text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-semibold text-sm transition-all">
                        Batal & Kembali
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary hover:bg-primary-container text-on-primary font-semibold text-sm flex items-center gap-2 shadow-sm transition-all active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan & Hitung SAW
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection