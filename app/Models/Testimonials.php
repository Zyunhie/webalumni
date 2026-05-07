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

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeMyTestimonials($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function getStatusLabelAttribute()
    {
        return [
            'pending' => 'Menunggu Review',
            'approved' => 'Dipublikasikan',
            'rejected' => 'Perlu Revisi',
        ][$this->status] ?? ucfirst($this->status);
    }

    public function getStatusBadgeClassAttribute()
    {
        return [
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
            'approved' => 'bg-green-50 text-green-700 border-green-200',
            'rejected' => 'bg-red-50 text-red-700 border-red-200',
        ][$this->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
    }
}
