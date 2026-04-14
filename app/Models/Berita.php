<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita'; // nama tabel (bukan 'beritas')
    protected $fillable = ['judul', 'isi', 'gambar', 'tanggal'];
    
    protected $casts = [
        'tanggal' => 'date', // tambahkan ini
    ];
}
