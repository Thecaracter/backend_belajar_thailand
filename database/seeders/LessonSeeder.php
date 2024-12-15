<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\KategoriLesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lessons = [
            // Aksara
            [
                'kategori_id' => 1,
                'judul' => 'Mengenal Aksara Thai',
                'deskripsi' => 'Pengenalan dasar aksara Thailand',
                'gambar' => null,
                'isi' => 'Konten pembelajaran tentang aksara Thai...'
            ],
            [
                'kategori_id' => 1,
                'judul' => 'Menulis Aksara Thai',
                'deskripsi' => 'Panduan menulis aksara Thailand',
                'gambar' => null,
                'isi' => 'Konten panduan menulis aksara Thai...'
            ],

            // Nada
            [
                'kategori_id' => 2,
                'judul' => 'Nada dalam Bahasa Thai',
                'deskripsi' => '5 Nada dasar bahasa Thailand',
                'gambar' => null,
                'isi' => 'Konten pembelajaran tentang nada dalam bahasa Thai...'
            ],

            // Angka
            [
                'kategori_id' => 3,
                'judul' => 'Angka dalam Bahasa Thai',
                'deskripsi' => 'Sistem angka Thailand',
                'gambar' => null,
                'isi' => 'Konten pembelajaran tentang angka Thai...'
            ],

            // Simbol
            [
                'kategori_id' => 4,
                'judul' => 'Simbol-simbol Thai',
                'deskripsi' => 'Pengenalan simbol umum Thailand',
                'gambar' => null,
                'isi' => 'Konten pembelajaran tentang simbol-simbol Thai...'
            ],

            // Bahasa
            [
                'kategori_id' => 5,
                'judul' => 'Dasar Bahasa Thai',
                'deskripsi' => 'Pengenalan dasar bahasa Thailand',
                'gambar' => null,
                'isi' => 'Konten pembelajaran dasar bahasa Thai...'
            ],

            // Budaya
            [
                'kategori_id' => 6,
                'judul' => 'Budaya Thailand',
                'deskripsi' => 'Pengenalan budaya Thailand',
                'gambar' => null,
                'isi' => 'Konten pembelajaran tentang budaya Thailand...'
            ]
        ];

        foreach ($lessons as $lesson) {
            Lesson::create($lesson);
        }
    }
}