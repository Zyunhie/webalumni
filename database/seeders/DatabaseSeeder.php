<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Urutan seeder penting karena ada relasi foreign key
        $this->call([
            // 1. Seeder untuk tabel yang tidak punya foreign key dulu
            HeroSlideSeeder::class,     // Tidak ada relasi
            AgendaSeeder::class,        // Tidak ada relasi ke user/alumni
            
            // 2. Seeder untuk users (admin & alumni)
            AdminAndAlumniSeeder::class, // Buat akun user dulu
            
            // 3. Seeder untuk alumni (data import) - setelah users ada
            AlumniSeeder::class,         // Data alumni import (bisa punya user_id)
        ]);
        
        $this->command->info('');
        $this->command->info('✅ All seeders completed successfully!');
        $this->command->info('');
        $this->command->info('📋 LOGIN CREDENTIALS:');
        $this->command->info('   Admin: admin@alumni.com / password');
        $this->command->info('   Alumni: ahmad@alumni.com / password');
        $this->command->info('   Alumni: siti@alumni.com / password');
        $this->command->info('   Alumni (pending): budi@alumni.com / password');
        $this->command->info('');
    }
}