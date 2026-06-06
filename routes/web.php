<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternatifController;

Route::get('/', function () {
    return view('welcome');
});

// Punya Kelola Alternatif (Jangan Ditimpa / Diubah)
// ===================================================
Route::resource('alternatif', AlternatifController::class);
