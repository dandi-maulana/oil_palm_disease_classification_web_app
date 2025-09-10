<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Api\PrediksiApiController;

// URL lengkapnya akan menjadi: http://.../api/predict
Route::post('/predict', [PrediksiApiController::class, 'predict']);