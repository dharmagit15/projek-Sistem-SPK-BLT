@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Integrasi Parameter Kriteria - Warga: {{ $warga->nama }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ url('/penilaian/store/' . $warga->id) }}" method="POST">
                @csrf
                
                @foreach($kriterias as $k)
                <div class="mb-4">
                    <label class="form-label font-weight-bold">{{ $k->nama_kriteria }} ({{ ucfirst($k->jenis) }})</label>
                    <small class="text-muted d-block mb-1">Bobot kriteria: {{ $k->bobot }}</small>
                    <input type="number" step="any" name="nilai[{{ $k->id }}]" 
                           class="form-control" 
                           value="{{ $nilaiWarga[$k->id] ?? '' }}" 
                           placeholder="Masukkan nilai angka" required>
                </div>
                @endforeach

                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4">Simpan & Hitung SAW</button>
                    <a href="{{ url('/perhitungan') }}" class="btn btn-secondary px-4">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection