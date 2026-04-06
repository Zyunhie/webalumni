<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{
    protected $fillable = [
        'nama',
        'jurusan',
        'tahun_lulus',
        'pekerjaan',
        'perusahaan',
        'foto',
        'isi_testimoni',
        'status',
        'alasan_penolakan',
        'user_id',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'tahun_lulus' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeMyTestimonials($query)
    {
        return $query->where('user_id', auth()->id());
    }
}
