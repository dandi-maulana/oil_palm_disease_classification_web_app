<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrediksiController;

// Rute untuk halaman-halaman utama
Route::get('/', [PrediksiController::class, 'home'])->name('home');
Route::get('/hasil', [PrediksiController::class, 'hasil'])->name('hasil');
Route::get('/pengujian', [PrediksiController::class, 'pengujian'])->name('pengujian');
Route::get('/tentang-kami', [PrediksiController::class, 'tentangKami'])->name('tentang-kami');
Route::get('/riwayat', [PrediksiController::class, 'riwayat'])->name('riwayat');

// Rute untuk menerima file gambar dari halaman pengujian
Route::post('/predict', [PrediksiController::class, 'predict'])->name('predict');

