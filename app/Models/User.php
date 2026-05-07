<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'alumni_id',
        'name',
        'nim',
        'email',
        'profile_photo',
        'password',
        'role',
        'prodi',
        'angkatan',
        'status',           // pending, approved, rejected
        'verification_status', // untuk kompatibilitas
        'rejection_reason',
        'approved_by',
        'approved_at',
        'is_data_matched',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'approved_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'is_data_matched' => 'boolean',
    ];

    // Relasi
    public function alumniData()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAlumni()
    {
        return $this->role === 'alumni';
    }

    public function isApproved()
    {
        return $this->status === 'approved' || $this->verification_status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending' || $this->verification_status === 'pending';
    }

    public function isRejected()
    {
        return $this->status === 'rejected' || $this->verification_status === 'rejected';
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->profile_photo)) {
            return \Illuminate\Support\Facades\Storage::url($this->profile_photo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?? 'User') . '&background=10b981&color=ffffff&bold=true';
    }
}
