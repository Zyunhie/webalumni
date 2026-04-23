<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongans';

    protected $fillable = [
        'judul',
        'perusahaan',
        'lokasi',
        'deskripsi',
        'kualifikasi',
        'cara_melamar',
        'external_link',
        'gambar',               // ← tambahkan
        'target_prodi',
        'status',
        'is_internal',
        'posted_by',
        'rejection_reason',
    ];

    protected $casts = [
        'target_prodi' => 'array',
        'is_internal' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeForProdi($query, $prodi)
    {
        return $query->whereJsonContains('target_prodi', $prodi);
    }
    
}