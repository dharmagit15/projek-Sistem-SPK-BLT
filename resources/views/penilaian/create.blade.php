@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Input Nilai Kriteria - {{ $warga->nama }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('penilaian.store', $warga->id) }}" method="POST">
                @csrf
                
                @foreach($kriterias as $k)
                <div class="mb-3">
                    <label class="form-label">{{ $k->nama_kriteria }} ({{ ucfirst($k->jenis) }})</label>
                    <input type="number" step="any" name="nilai[{{ $k->id }}]" 
                           class="form-control" 
                           value="{{ $nilaiWarga[$k->id] ?? '' }}" 
                           placeholder="Masukkan nilai angka untuk kriteria ini" required>
                </div>
                @endforeach

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Simpan & Integrasikan Nilai</button>
                    <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection