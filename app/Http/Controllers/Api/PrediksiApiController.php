<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class PrediksiApiController extends Controller
{
    public function predict(Request $request)
    {
        $request->validate([
            'gambar_sawit' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        try {
            // Teruskan gambar ke API Python
            $response = Http::attach(
                'file', file_get_contents($request->file('gambar_sawit')), $request->file('gambar_sawit')->getClientOriginalName()
            )->post('http://127.0.0.1:5000/predict');

            if ($response->successful()) {
                // Kembalikan hasil JSON dari Python langsung ke Flutter
                return $response->json();
            }

            return response()->json(['error' => 'Gagal mendapatkan prediksi.'], 500);

        } catch (ConnectionException $e) {
            return response()->json(['error' => 'Tidak dapat terhubung ke server AI.'], 500);
        }
    }
}