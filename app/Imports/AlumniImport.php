<?php

namespace App\Imports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class AlumniImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari atau buat user berdasarkan NIM
        $user = \App\Models\User::where('nim', $row['nim'])->first();

        if (!$user) {
            // Buat user baru dengan role alumni
            $user = \App\Models\User::create([
                'name' => $row['nama'],
                'email' => $row['email'] ?? $row['nim'] . '@alumni.ac.id',
                'nim' => $row['nim'],
                'password' => Hash::make($row['nim']), // Password default = NIM
                'role' => 'alumni',
            ]);
        }

        // Buat alumni
        return new Alumni([
            'nama' => $row['nama'],
            'nim' => $row['nim'],
            'prodi' => $row['prodi'],
            'angkatan' => $row['angkatan'],
            'lulusan' => $row['lulusan'],
            'pekerjaan' => $row['pekerjaan'] ?? null,
            'perusahaan' => $row['perusahaan'] ?? null,
            'email' => $row['email'] ?? null,
            'no_hp' => $row['no_hp'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'user_id' => $user->id,
            'status' => 'approved', // Langsung approved karena import dari admin
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
    }
}

