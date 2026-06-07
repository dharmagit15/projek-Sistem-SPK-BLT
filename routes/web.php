<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\KriteriaController;

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
