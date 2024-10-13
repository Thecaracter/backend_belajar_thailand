<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Artikel;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        // Fungsi untuk mengambil gambar dari Picsum Photos dan mengubahnya ke base64
        $getRandomImage = function () {
            $imageUrl = "https://picsum.photos/800/600";
            $imageContent = @file_get_contents($imageUrl);
            if ($imageContent === false) {
                // Jika gagal mengambil gambar, gunakan gambar placeholder
                return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=';
            }
            $base64Image = 'data:image/jpeg;base64,' . base64_encode($imageContent);
            return $base64Image;
        };

        for ($i = 1; $i <= 20; $i++) {
            Artikel::create([
                'user_id' => $user->id,
                'judul' => $faker->sentence(6, true),
                'ringkasan' => $faker->paragraph(2),
                'foto' => $getRandomImage(),
                'konten' => $faker->paragraphs(5, true),
                'like_count' => $faker->numberBetween(0, 100),
                'view_count' => $faker->numberBetween(50, 1000),
                'is_published' => true,
            ]);
        }
    }
}
