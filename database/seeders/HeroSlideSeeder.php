<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class HeroSlideSeeder extends Seeder
{
    /**
     * Migrate gambar dari public/images ke storage/public/hero
     * dan seed data dari array hardcoded blade ke DB.
     * 
     * Jalankan: php artisan db:seed --class=HeroSlideSeeder
     */
    public function run(): void
    {
        $slides = [
            ['img' => 'branda.jpg'],
            ['img' => 'slide2.jpg'],
            ['img' => 'slide3.jpg'],
            ['img' => 'slide4.jpg'],
        ];

        foreach ($slides as $index => $s) {
            $srcPath = public_path("images/{$s['img']}");
            $destPath = "hero/{$s['img']}";

            // Copy file dari public/images ke storage/public/hero
            if (File::exists($srcPath)) {
                Storage::disk('public')->put($destPath, File::get($srcPath));
            } else {
                // Kalau file gak ada, skip gambar (isi path dummy)
                $destPath = "hero/placeholder.jpg";
            }

            HeroSlide::create([
                'gambar' => $destPath,
                'urutan' => $index,
                'aktif'  => true,
            ]);
        }
    }
}