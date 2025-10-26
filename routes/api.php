<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Api\PrediksiApiController;

// URL lengkapnya akan menjadi: http://.../api/predict
Route::post('/predict', [PrediksiApiController::class, 'predict']);

use App\Http\Controllers\Api\MobileController;

// Endpoint baru untuk aplikasi mobile
Route::post('/mobile/predict', [MobileController::class, 'predictMobile']);
Route::get('/mobile/history', [MobileController::class, 'getHistory']);
Route::get('/samples', [MobileController::class, 'getSamples']);
// routes/api.php
// ... (rute-rute lain tetap sama) ...
Route::get('/mobile/history', [MobileController::class, 'getHistory']);
// TAMBAHKAN RUTE BARU INI
Route::get('/mobile/history/{id}', [MobileController::class, 'getHistoryDetail']);
