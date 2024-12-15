<?php

namespace Database\Seeders;

use App\Models\KategoriClass;
use App\Models\KategoriLesson;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            ['nama' => 'aksara'],
            ['nama' => 'nada'],
            ['nama' => 'angka'],
            ['nama' => 'simbol'],
            ['nama' => 'bahasa'],
            ['nama' => 'budaya']
        ];

        foreach ($kategori as $k) {
            KategoriLesson::create($k);
        }
    }
}
