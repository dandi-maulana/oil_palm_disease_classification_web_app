<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class PrediksiController extends Controller
{
    // Fungsi ini akan menampilkan halaman utama website
    public function index()
    {
        return view('prediksi');
    }

    // Fungsi ini akan menangani unggahan gambar dan berkomunikasi dengan API Python
    public function predict(Request $request)
    {
        // Validasi file yang diunggah
        $request->validate([
            'gambar_sawit' => 'required|image|mimes:jpeg,png,jpg|max:10240', // Maksimal 2MB
        ]);

        try {
            // Mengirim gambar ke API Python yang berjalan di port 5000
            $response = Http::attach(
                'file', file_get_contents($request->file('gambar_sawit')), $request->file('gambar_sawit')->getClientOriginalName()
            )->post('http://127.0.0.1:5000/predict');

            // Mengembalikan hasil dari API Python ke pengguna
            if ($response->successful()) {
                return $response->json();
            } else {
                return response()->json(['error' => 'Gagal mendapatkan prediksi dari server AI.'], 500);
            }

        } catch (ConnectionException $e) {
            // Tangani error jika API Python tidak aktif atau tidak bisa dihubungi
            return response()->json(['error' => 'Tidak dapat terhubung ke server AI. Pastikan server Python sedang berjalan.'], 500);
        }
    }
}