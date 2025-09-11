<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class PrediksiController extends Controller
{
    // Menampilkan halaman Home
    public function home()
    {
        return view('home');
    }

    // Menampilkan halaman Hasil Model
    public function hasil()
    {
        return view('hasil');
    }

    // Menampilkan halaman Pengujian (sebelumnya prediksi.blade.php)
    public function pengujian()
    {
        return view('pengujian');
    }

    // Menampilkan halaman Tentang Kami
    public function tentangKami()
    {
        return view('tentang-kami');
    }

    // Menangani proses prediksi (tetap sama)
    public function predict(Request $request)
    {
        $request->validate([
            'gambar_sawit' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        try {
            $response = Http::attach(
                'file', file_get_contents($request->file('gambar_sawit')), $request->file('gambar_sawit')->getClientOriginalName()
            )->post('http://127.0.0.1:5000/predict');

            if ($response->successful()) {
                return $response->json();
            } else {
                return response()->json(['error' => 'Gagal mendapatkan prediksi dari server AI.'], 500);
            }

        } catch (ConnectionException $e) {
            return response()->json(['error' => 'Tidak dapat terhubung ke server AI. Pastikan server Python sedang berjalan.'], 500);
        }
    }
}