<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamarans';

    protected $fillable = [
        'lowongan_id',
        'alumni_id',
        'cover_letter',
        'cv_file',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}

