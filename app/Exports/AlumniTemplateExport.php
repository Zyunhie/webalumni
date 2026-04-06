<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlumniTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'nama',
            'nim',
            'prodi',
            'angkatan',
            'lulusan',
            'pekerjaan',
            'perusahaan',
            'email',
            'no_hp',
            'alamat',
        ];
    }

    public function array(): array
    {
        // Template kosong (hanya header)
        return [
            [
                'Contoh Nama Alumni',
                '123456789',
                'PGMI',
                '2020',
                '2024',
                'Guru',
                'SDN 1 Tasikmalaya',
                'email@example.com',
                '081234567890',
                'Jl. Contoh No. 1, Tasikmalaya',
            ]
        ];
    }
}

