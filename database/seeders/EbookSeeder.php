<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ebook;

class EbookSeeder extends Seeder
{
    public function run(): void
    {
        $ebooks = [
            ['name' => 'Soal Assesment Kelas 10', 'file_path' => 'ebooks/soal_assessment_siswa_kelas_10.pdf'],
            ['name' => 'Soal Assesment Kelas 11', 'file_path' => 'ebooks/soal_assessment_siswa_kelas_11.pdf'],
            ['name' => 'Soal Assesment Kelas 12', 'file_path' => 'ebooks/soal_assessment_siswa_kelas_12.pdf'],
        ];

        foreach ($ebooks as $ebook) {
            Ebook::create($ebook);
        }
    }
}

