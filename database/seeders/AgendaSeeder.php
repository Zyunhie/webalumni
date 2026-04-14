<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;
use Carbon\Carbon;

class AgendaSeeder extends Seeder
{
    public function run(): void
    {
        $agendas = [
            [
                'judul' => 'Membangun Karakter, Menguatkan Karir',
                'deskripsi' => '✨ Hello, Institut Agama Islam Tasikmalaya! 🎓 Membangun Karakter, Menguatkan Karir, dan Menyiapkan Generasi Alumni Unggul untuk Masa Depan ✨',
                'tanggal_mulai' => '2025-09-11',
                'tanggal_selesai' => null,
                'lokasi' => 'Aula Gedung Rektorat',
                'gambar' => null,
            ],
            [
                'judul' => 'Reuni Angkatan 2020',
                'deskripsi' => 'Gabung dalam reuni akbar angkatan 2020! Bertemu teman lama, nostalgia, dan networking.',
                'tanggal_mulai' => '2025-10-20',
                'tanggal_selesai' => null,
                'lokasi' => 'Gedung Serbaguna IAIT',
                'gambar' => null,
            ],
            [
                'judul' => 'Workshop Karir Alumni',
                'deskripsi' => 'Workshop praktis untuk tingkatkan skill karir dan persiapan wawancara kerja bagi alumni.',
                'tanggal_mulai' => '2025-11-15',
                'tanggal_selesai' => null,
                'lokasi' => 'Ruang Seminar Lt.2',
                'gambar' => null,
            ]
        ];

        foreach ($agendas as $agendaData) {
            Agenda::updateOrCreate(
                ['judul' => $agendaData['judul']],
                $agendaData
            );
        }
    }
}

