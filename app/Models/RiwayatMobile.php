<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatMobile extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambar_path',
        'nama_file',
        'hasil_prediksi',
        'kepercayaan',
        'nama_penguji', // <-- TAMBAHKAN INI
        'lokasi_pengujian', // <-- TAMBAHKAN INI
        'durasi_pengujian'
    ];
}