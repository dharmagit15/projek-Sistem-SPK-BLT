<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SawController;
use App\Http\Controllers\PenilaianController;


Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
Route::get('/penilaian/input/{id}', [PenilaianController::class, 'create'])->name('penilaian.create');
Route::post('/penilaian/store/{id}', [PenilaianController::class, 'store'])->name('penilaian.store');
// Rute untuk Perhitungan SAW
// Rute untuk Perhitungan SAW
Route::get('/perhitungan', [SawController::class, 'hitungSaw'])->name('perhitungan.index');

// Rute untuk menampilkan form input nilai kriteria warga
Route::get('/penilaian/input/{id}', [SawController::class, 'formNilai'])->name('penilaian.create');

// Rute untuk memproses penyimpanan nilai kriteria ke database
Route::post('/penilaian/store/{id}', [SawController::class, 'simpanNilai'])->name('penilaian.store');

Route::get('/', function () {
    return view('welcome');
});

// Punya Kelola Alternatif (Jangan Ditimpa / Diubah)
// ===================================================
Route::resource('alternatif', AlternatifController::class);

//punya Input nilai / Perhitungan
// Pastikan baris ini berada di paling bawah file, tidak terbungkus di dalam Route::middleware(['auth'])
Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');
Route::get('/alternatif/create', [AlternatifController::class, 'create'])->name('alternatif.create');
Route::post('/alternatif', [AlternatifController::class, 'store'])->name('alternatif.store');
Route::get('/alternatif/{id}/edit', [AlternatifController::class, 'edit'])->name('alternatif.edit');
Route::put('/alternatif/{id}', [AlternatifController::class, 'update'])->name('alternatif.update');
Route::delete('/alternatif/{id}', [AlternatifController::class, 'destroy'])->name('alternatif.destroy');

// Kelola Kriteria
// ===================================================
Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria');
Route::get('/kriteria/create', [KriteriaController::class, 'create'])->name('kriteria.create');
Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
Route::get('/kriteria/{id}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
Route::delete('/kriteria/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');

// Letakkan di dalam grup middleware auth jika ada
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/cetak-pdf', [LaporanController::class, 'cetakPdf'])->name('laporan.pdf');

// Pastikan rute /perhitungan ini mengarah ke fungsi hitungSaw di Controller Anda
Route::get('/perhitungan', [SawController::class, 'hitungSaw']);