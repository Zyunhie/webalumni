<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Alumni;

class AdminAndAlumniSeeder extends Seeder
{
    public function run(): void
    {
        // ==================================================
        // 1. BUAT AKUN ADMIN
        // ==================================================
        $admin = User::updateOrCreate(
            ['email' => 'admin@alumni.com'],
            [
                'name' => 'Administrator',
                'nim' => 'ADMIN001',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('✓ Admin created: admin@alumni.com / password');

        // ==================================================
        // 2. BUAT AKUN ALUMNI (sudah diverifikasi)
        // ==================================================
        // Alumni 1 - PGMI
        $alumni1 = User::updateOrCreate(
            ['email' => 'ahmad@alumni.com'],
            [
                'name' => 'Ahmad Fauzi',
                'nim' => '123456789',
                'password' => Hash::make('password'),
                'role' => 'alumni',
                'status' => 'approved',
                'prodi' => 'PGMI',
                'angkatan' => 2020,
                'email_verified_at' => now(),
            ]
        );
        
        // Alumni 2 - PAI
        $alumni2 = User::updateOrCreate(
            ['email' => 'siti@alumni.com'],
            [
                'name' => 'Siti Aminah',
                'nim' => '987654321',
                'password' => Hash::make('password'),
                'role' => 'alumni',
                'status' => 'approved',
                'prodi' => 'PAI',
                'angkatan' => 2021,
                'email_verified_at' => now(),
            ]
        );
        
        // Alumni 3 - PIAUD (pending verifikasi)
        $alumni3 = User::updateOrCreate(
            ['email' => 'budi@alumni.com'],
            [
                'name' => 'Budi Santoso',
                'nim' => '555555555',
                'password' => Hash::make('password'),
                'role' => 'alumni',
                'status' => 'pending',
                'prodi' => 'PIAUD',
                'angkatan' => 2022,
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('✓ Alumni accounts created: ahmad@alumni.com, siti@alumni.com, budi@alumni.com (pending)');

        // ==================================================
        // 3. BUAT DATA ALUMNI (untuk tabel alumni - hasil import)
        // ==================================================
        
        // Data alumni PGMI (terhubung ke user)
        Alumni::updateOrCreate(
            ['nim' => '123456789'],
            [
                'nama' => 'Ahmad Fauzi',
                'prodi' => 'PGMI',
                'angkatan' => 2020,
                'lulusan' => 2024,
                'pekerjaan' => 'Guru',
                'perusahaan' => 'SDN 1 Tasikmalaya',
                'email' => 'ahmad@alumni.com',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Pendidikan No. 1, Tasikmalaya',
                'status' => 'approved',
                'user_id' => $alumni1->id,
                'approved_at' => now(),
            ]
        );
        
        // Data alumni PAI (terhubung ke user)
        Alumni::updateOrCreate(
            ['nim' => '987654321'],
            [
                'nama' => 'Siti Aminah',
                'prodi' => 'PAI',
                'angkatan' => 2021,
                'lulusan' => 2025,
                'pekerjaan' => 'Dosen',
                'perusahaan' => 'UIN Sunan Gunung Djati',
                'email' => 'siti@alumni.com',
                'no_hp' => '081298765432',
                'alamat' => 'Jl. Agama No. 2, Bandung',
                'status' => 'approved',
                'user_id' => $alumni2->id,
                'approved_at' => now(),
            ]
        );
        
        $this->command->info('✓ Alumni data (import) created');
    }
}