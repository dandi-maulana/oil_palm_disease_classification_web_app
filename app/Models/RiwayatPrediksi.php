<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPrediksi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gambar_path',
        'nama_file',
        'hasil_prediksi',
        'kepercayaan',
        'lokasi_dataset',
        'model_ai',
        'waktu_sebelum_uji',
        'waktu_sesudah_uji',
        'durasi_pengujian',
    ];
}