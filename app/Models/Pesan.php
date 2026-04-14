<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'email', 'pesan', 'status', 'dibaca_pada'];

    protected $casts = [
        'dibaca_pada' => 'datetime',
    ];

    // Scope untuk filter tanggal
    public function scopeTanggal($query, $tanggal)
    {
        if ($tanggal) {
            return $query->whereDate('created_at', $tanggal);
        }
        return $query;
    }

    // Scope untuk rentang tanggal (start - end)
    public function scopeBetweenDates($query, $start, $end)
    {
        if ($start && $end) {
            return $query->whereBetween('created_at', [$start, $end]);
        } elseif ($start) {
            return $query->whereDate('created_at', '>=', $start);
        } elseif ($end) {
            return $query->whereDate('created_at', '<=', $end);
        }
        return $query;
    }
}