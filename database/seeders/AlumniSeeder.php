<?php

namespace Database\Seeders;

use App\Models\Alumni;
use Illuminate\Database\Seeder;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        Alumni::insert([
            [
                'nama'     => 'Budi Santoso',
                'nim'      => '2021001',
                'prodi'    => 'PAI',
                'angkatan' => 2021,
                'email'    => 'budi@example.com',
                'status'   => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama'     => 'Siti Rahayu',
                'nim'      => '2021002',
                'prodi'    => 'PGMI',
                'angkatan' => 2021,
                'email'    => 'siti@example.com',
                'status'   => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}