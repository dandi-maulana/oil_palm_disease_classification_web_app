<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrediksiController;

// Saat pengguna membuka halaman utama (misal: http://127.0.0.1:8000),
// panggil fungsi 'index' di PrediksiController
Route::get('/', [PrediksiController::class, 'index']);

// Saat ada data (gambar) yang dikirim ke alamat '/predict',
// panggil fungsi 'predict' di PrediksiController
Route::post('/predict', [PrediksiController::class, 'predict'])->name('predict');