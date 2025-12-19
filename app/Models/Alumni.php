<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $fillable = [
        'nama',
        'nim',
        'prodi',
        'angkatan',
        'pekerjaan',
        'perusahaan',
        'email',
        'no_hp',
        'alamat',
        'foto',

        // approval system
        'user_id',
        'status',
        'approved_by',
        'approved_at',
    ];
}
