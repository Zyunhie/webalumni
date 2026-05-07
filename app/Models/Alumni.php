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
        'status',
        'user_id',
        'pending_data',
        'rejection_reason',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'angkatan' => 'integer',
        'lulusan' => 'integer',
        'approved_at' => 'datetime',
        'pending_data' => 'array',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke admin yang approve
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Accessor untuk URL foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::url($this->foto);
        }
        return asset('images/default-avatar.png');
    }

    // Accessor untuk URL ijazah
    public function getIjazahUrlAttribute()
    {
        if ($this->ijazah && Storage::disk('public')->exists($this->ijazah)) {
            return Storage::url($this->ijazah);
        }
        return null;
    }

    // Accessor untuk URL transkrip
    public function getTranskripUrlAttribute()
    {
        if ($this->transkrip && Storage::disk('public')->exists($this->transkrip)) {
            return Storage::url($this->transkrip);
        }
        return null;
    }

    // Helper status
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}