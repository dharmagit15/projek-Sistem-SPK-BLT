@extends('layouts.app')

@section('content')
<div class="container mt-5">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Sukses!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <style>
        .table-custom-border, .table-custom-border th, .table-custom-border td {
            border: 1px solid #000000 !important;
        }
    </style>
    
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-table me-2"></i> 1. Matriks Keputusan (Nilai Asli Warga)</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-custom-border table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="70px" class="text-center">No</th>
                            <th>Nama Warga</th>
                            @foreach($kriterias as $k)
                                @php
                                    // Normalisasi teks untuk memastikan pencocokan string 100% akurat
                                    $namaClean = trim(strtolower($k->nama_kriteria));
                                @endphp
                                <th class="text-center text-nowrap">
                                    <span class="d-block text-warning small fw-bold mb-1">
                                        @if(str_contains($namaClean, 'pendapatan') || str_contains($namaClean, 'c1'))
                                            C1 Pendapatan
                                        @elseif(str_contains($namaClean, 'listrik') || str_contains($namaClean, 'c2'))
                                            C2 Listrik
                                        @elseif(str_contains($namaClean, 'tanggungan') || str_contains($namaClean, 'c3'))
                                            C3 Tanggungan
                                        @elseif(str_contains($namaClean, 'rumah') || str_contains($namaClean, 'c4'))
                                            C4 Kondisi Rumah
                                        @elseif(str_contains($namaClean, 'pekerjaan') || str_contains($namaClean, 'c5'))
                                            C5 Status Pekerjaan
                                        @else
                                            {{ $k->nama_kriteria }}
                                        @endif
                                    </span>
                                    <small class="text-light-50 fw-normal">({{ ucfirst(trim($k->jenis)) }})</small>
                                </th>
                            @endforeach
                            <th width="180px" class="text-center">Aksi Integrasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilRanking as $row)
                        <tr>
                            <td class="text-center fw-bold text-secondary">{{ $loop->iteration }}</td>
                            <td><span class="fw-semibold text-dark">{{ $row['nama'] }}</span></td>
                            @foreach($kriterias as $k)
                                <td class="text-center">
                                    {{ number_format($row['detail_nilai_asli'][$k->id] ?? 0, 0, ',', '.') }}
                                </td>
                            @endforeach
                            <td class="text-center">
                                <a href="{{ url('/penilaian/input/' . $row['id']) }}" class="btn btn-sm btn-warning fw-bold px-3 shadow-sm text-dark">
                                    📝 Isi / Ubah Nilai
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($kriterias) + 3 }}" class="text-center py-4 text-muted">Data alternatif masih kosong.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-info text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-calculator me-2"></i> 2. Matriks Normalisasi (Nilai R)</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-custom-border table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="70px" class="text-center">No</th>
                            <th>Nama Warga</th>
                            @foreach($kriterias as $k)
                                @php
                                    $namaClean = trim(strtolower($k->nama_kriteria));
                                @endphp
                                <th class="text-center text-nowrap">
                                    <span class="d-block text-warning small fw-bold mb-1">
                                        @if(str_contains($namaClean, 'pendapatan') || str_contains($namaClean, 'c1'))
                                            C1 Pendapatan
                                        @elseif(str_contains($namaClean, 'listrik') || str_contains($namaClean, 'c2'))
                                            C2 Listrik
                                        @elseif(str_contains($namaClean, 'tanggungan') || str_contains($namaClean, 'c3'))
                                            C3 Tanggungan
                                        @elseif(str_contains($namaClean, 'rumah') || str_contains($namaClean, 'c4'))
                                            C4 Kondisi Rumah
                                        @elseif(str_contains($namaClean, 'pekerjaan') || str_contains($namaClean, 'c5'))
                                            C5 Status Pekerjaan
                                        @else
                                            {{ $k->nama_kriteria }}
                                        @endif
                                    </span>
                                    <small class="text-light-50 fw-normal">({{ ucfirst(trim($k->jenis)) }})</small>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilRanking as $row)
                        <tr>
                            <td class="text-center fw-bold text-secondary">{{ $loop->iteration }}</td>
                            <td class="text-dark fw-semibold">{{ $row['nama'] }}</td>
                            @foreach($kriterias as $k)
                                <td class="text-center fw-bold text-primary">
                                    {{ number_format($row['detail_normalisasi'][$k->id] ?? 0, 3, ',', '.') }}
                                </td>
                            @endforeach
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($kriterias) + 2 }}" class="text-center py-4 text-muted">Data normalisasi masih kosong.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-success text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-trophy me-2"></i> 3. Hasil Perankingan Akhir (Nilai V)</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-custom-border table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="140px" class="text-center">Ranking</th>
                            <th>NIK</th>
                            <th>Nama Warga</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th class="text-center">Simulasi Rumus Akhir (Bobot * R)</th>
                            <th class="text-end" width="160px">Skor Akhir (V)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilRanking as $index => $row)
                        <tr class="{{ $index == 0 ? 'table-warning fw-bold' : '' }}">
                            <td class="text-center">
                                @if($index == 0)
                                    <span class="badge bg-warning text-dark px-3 py-2 shadow-sm">🥇 Rank 1</span>
                                @elseif($index == 1)
                                    <span class="badge bg-secondary px-3 py-2 shadow-sm">🥈 Rank 2</span>
                                @elseif($index == 2)
                                    <span class="badge bg-danger px-3 py-2 shadow-sm">🥉 Rank 3</span>
                                @else
                                    <span class="badge bg-light text-dark border px-3 py-2">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $row['nik'] }}</td>
                            <td><span class="fw-bold text-dark">{{ $row['nama'] }}</span></td>
                            <td class="text-muted">{{ $row['alamat'] }}</td>
                            <td>
                                <span class="badge {{ $row['status'] == 'Terverifikasi' ? 'bg-success' : ($row['status'] == 'Review' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                            <td class="bg-light text-center">
                                <code class="text-dark fw-bold" style="font-size: 0.95rem; font-family: 'Courier New', Courier, monospace;">
                                    {{ $row['teks_rumus'] ?? '-' }}
                                </code>
                            </td>
                            <td class="text-end text-success fw-bold">
                                <span style="font-size: 1.1rem;">{{ number_format($row['skor_akhir'], 4, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data perhitungan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection