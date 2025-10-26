<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use App\Models\RiwayatPrediksi; // <-- 1. Import model
use Carbon\Carbon; // <-- 2. Import Carbon untuk manajemen waktu
use Illuminate\Support\Facades\Storage;

class PrediksiController extends Controller
{
    // ... (fungsi home, hasil, pengujian, tentangKami tetap sama)
    public function home()
    {
        return view('home');
    }
    public function hasil()
    {
        return view('hasil');
    }
    public function pengujian()
    {
        return view('pengujian');
    }
    public function tentangKami()
    {
        return view('tentang-kami');
    }

    public function riwayat(Request $request)
    {
        // Mulai query ke model RiwayatPrediksi
        $query = RiwayatPrediksi::query();

        // Periksa apakah ada input pencarian dari pengguna
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            // Tambahkan kondisi WHERE untuk memfilter berdasarkan hasil prediksi ATAU nama file
            $query->where('hasil_prediksi', 'like', '%' . $searchTerm . '%')
                ->orWhere('nama_file', 'like', '%' . $searchTerm . '%');
        }

        // Ambil data yang sudah difilter, urutkan dari yang terbaru, dan paginasi 5 per halaman
        $riwayat = $query->latest()->paginate(5);

        // Mengirim data ke view 'riwayat'
        return view('riwayat', ['riwayat' => $riwayat]);
    }

    // Fungsi predict diperbarui total
    public function predict(Request $request)
    {
        // Perbarui aturan validasi
        $request->validate([
            'gambar_sawit' => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'waktu_sebelum_uji' => 'required|date',
            'nama_penguji' => 'required|string|max:255', // Validasi input baru
            'lokasi_pengujian' => 'required|string|max:255', // Validasi input baru
        ]);

        $startTime = microtime(true);
        $file = $request->file('gambar_sawit');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $fileName, 'public');

        try {
            $response = Http::attach(
                'file',
                file_get_contents($file),
                $file->getClientOriginalName()
            )->post('http://127.0.0.1:5000/predict');

            $endTime = microtime(true);
            $duration = $endTime - $startTime;

            if ($response->successful()) {
                $data = $response->json();

                // Simpan ke database dengan data inputan baru
                RiwayatPrediksi::create([
                    'gambar_path' => $path,
                    'nama_file' => $file->getClientOriginalName(),
                    'hasil_prediksi' => $data['prediksi'],
                    'kepercayaan' => $data['kepercayaan'],
                    // Data statis yang lama masih bisa disimpan
                    'lokasi_dataset' => 'Desa Sei-Simujur, Kecamatan Laut Tador, Kabupaten Batu Bara, Sumatera Utara.',
                    'model_ai' => 'Arsitektur Squeezenet dengan Grup Convolution',
                    // Data dinamis dari input pengguna
                    'nama_penguji' => $request->nama_penguji,
                    'lokasi_pengujian' => $request->lokasi_pengujian,
                    'waktu_sebelum_uji' => \Carbon\Carbon::parse($request->waktu_sebelum_uji),
                    'waktu_sesudah_uji' => now(),
                    'durasi_pengujian' => $duration,
                ]);

                $data['durasi'] = number_format($duration, 4) . ' detik';
                $data['waktu_sesudah_uji'] = now()->translatedFormat('d F Y H:i:s');

                return response()->json($data);
            } else {
                Storage::disk('public')->delete($path);
                return response()->json(['error' => 'Gagal mendapatkan prediksi dari server AI.'], 500);
            }
        } catch (\Exception $e) {
            Storage::disk('public')->delete($path);
            return response()->json(['error' => 'Tidak dapat terhubung ke server AI. Pastikan server Python sedang berjalan.'], 500);
        }
    }
}
