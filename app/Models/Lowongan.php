<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'lowongan';

    // Field yang bisa diisi massal
    protected $fillable = [
        'judul',
        'deskripsi',
        'perusahaan',
        'lokasi',
        'tanggal_post',    // tanggal posting lowongan
        'batas_lamaran',   // batas pengiriman lamaran
        'gambar',          // path gambar lowongan
    ];

    // Casting otomatis menjadi Carbon (tanggal)
    protected $casts = [
        'tanggal_post' => 'datetime',
        'batas_lamaran' => 'datetime',
    ];
}
