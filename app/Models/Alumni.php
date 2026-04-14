<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $fillable = [
        'nama',
        'nim',
        'prodi',
        'angkatan',
        'lulusan',
        'pekerjaan',
        'perusahaan',
        'email',
        'no_hp',
        'alamat',
        'foto',
        'ijazah',
        'transkrip',
        'user_id',
        'status',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke admin yang approve
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Accessor untuk URL foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return Storage::url($this->foto);
        }
        // Default jika tidak ada foto
        return asset('images/K.jpeg');
    }

    // Accessor untuk URL ijazah
    public function getIjazahUrlAttribute()
    {
        if (!$this->ijazah) return null;
        
        // Jika path sudah dimulai dengan 'upload/' atau 'http', gunakan asset langsung
        if (str_starts_with($this->ijazah, 'upload/') || str_starts_with($this->ijazah, 'http')) {
            return asset($this->ijazah);
        }
        // Jika path dari Storage (storage/app/public/)
        return Storage::url($this->ijazah);
    }

    // Accessor untuk URL transkrip
    public function getTranskripUrlAttribute()
    {
        if (!$this->transkrip) return null;
        
        // Jika path sudah dimulai dengan 'upload/' atau 'http', gunakan asset langsung
        if (str_starts_with($this->transkrip, 'upload/') || str_starts_with($this->transkrip, 'http')) {
            return asset($this->transkrip);
        }
        // Jika path dari Storage (storage/app/public/)
        return Storage::url($this->transkrip);
    }

    /**
     * Relasi ke lamaran alumni
     */
    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }
}



