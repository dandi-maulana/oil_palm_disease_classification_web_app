<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\RiwayatMobile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MobileController extends Controller
{
    /**
     * Menerima gambar dan detail dari Flutter, lalu menyimpannya ke database.
     */
    public function predictMobile(Request $request)
    {
        $request->validate([
            'gambar_sawit' => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'nama_penguji' => 'required|string|max:255',
            'lokasi_pengujian' => 'required|string|max:255',
        ]);
        
        $startTime = microtime(true);
        $file = $request->file('gambar_sawit');

        try {
            $response = Http::attach(
                'file', file_get_contents($file), $file->getClientOriginalName()
            )->post('http://127.0.0.1:5000/predict');

            $duration = microtime(true) - $startTime;

            if ($response->successful()) {
                $data = $response->json();
                $path = $file->storeAs('uploads_mobile', time() . '_' . $file->getClientOriginalName(), 'public');

                RiwayatMobile::create([
                    'gambar_path' => $path,
                    'nama_file' => $file->getClientOriginalName(),
                    'hasil_prediksi' => $data['prediksi'],
                    'kepercayaan' => $data['kepercayaan'],
                    'nama_penguji' => $request->nama_penguji,
                    'lokasi_pengujian' => $request->lokasi_pengujian,
                    'durasi_pengujian' => $duration,
                ]);
                
                // Menambahkan data tambahan untuk ditampilkan langsung di aplikasi
                $data['durasi'] = number_format($duration, 4) . ' detik';
                $data['waktu_selesai'] = now()->translatedFormat('d F Y H:i:s');
                
                return response()->json($data);
            }
            return response()->json(['error' => 'Gagal mendapatkan prediksi dari server AI.'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Tidak dapat terhubung ke server AI atau terjadi kesalahan internal.'], 500);
        }
    }

    /**
     * Mengambil detail satu data riwayat berdasarkan ID.
     */
    public function getHistoryDetail($id)
    {
        // Cari data di database berdasarkan ID, jika tidak ketemu akan error 404
        $historyDetail = RiwayatMobile::findOrFail($id);
        
        // Kembalikan hasilnya sebagai JSON
        return response()->json($historyDetail);
    }
    /**
     * Mengirim data riwayat dari database mobile ke Flutter.
     */
    public function getHistory(Request $request)
    {
        $query = RiwayatMobile::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('hasil_prediksi', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nama_file', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nama_penguji', 'like', '%' . $searchTerm . '%');
            });
        }

        $history = $query->latest()->paginate(10); 
        
        return response()->json($history);
    }

    /**
     * Mengirim data sampel penyakit statis ke Flutter.
     */
    public function getSamples()
    {
        $samples = [
            [
                'id' => 'sehat',
                'name' => 'Daun Sehat',
                'imagePath' => asset('images/daun_sehat.jpg'),
                'description' => 'Daun kelapa sawit dalam kondisi sehat, menunjukkan warna hijau cerah dan tidak ada tanda-tanda kerusakan fisik atau serangan patogen.',
                'solution' => 'Pertahankan praktik agronomi yang baik, pemupukan teratur, dan pemantauan rutin untuk mencegah serangan hama dan penyakit.',
            ],
            [
                'id' => 'kuning',
                'name' => 'Daun Kuning',
                'imagePath' => asset('images/daun_kuning.jpg'),
                'description' => 'Gejala daun menguning seringkali disebabkan oleh kekurangan nutrisi, drainase yang buruk, atau serangan penyakit tertentu.',
                'solution' => 'Lakukan analisis tanah dan daun untuk mengidentifikasi defisiensi nutrisi. Berikan pupuk yang sesuai. Pastikan sistem drainase perkebunan berfungsi dengan baik.',
            ],
            [
                'id' => 'bercak',
                'name' => 'Daun Bercak',
                'imagePath' => asset('images/daun_bercak.jpg'),
                'description' => 'Ditandai dengan munculnya bercak-bercak coklat atau hitam pada permukaan daun, seringkali akibat infeksi jamur.',
                'solution' => 'Identifikasi jenis jamur penyebab. Lakukan pemangkasan daun yang terinfeksi dan bakar. Aplikasi fungisida yang tepat dapat membantu mengendalikan penyebaran.',
            ],
            [
                'id' => 'busuk',
                'name' => 'Daun Busuk',
                'imagePath' => asset('images/daun_busuk.jpg'),
                'description' => 'Kondisi daun yang membusuk, seringkali lunak dan berbau tidak sedap, disebabkan oleh infeksi bakteri atau jamur parah.',
                'solution' => 'Buang dan musnahkan bagian tanaman yang busuk untuk mencegah penyebaran. Gunakan fungisida atau bakterisida yang direkomendasikan.',
            ]
        ];
        return response()->json($samples);
    }
}