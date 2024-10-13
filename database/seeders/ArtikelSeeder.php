<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Artikel;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }


        for ($i = 1; $i <= 5; $i++) {
            Artikel::create([
                'user_id' => $user->id,
                'judul' => "Artikel Test $i",
                'ringkasan' => "Ini adalah ringkasan untuk artikel test $i.",
                'foto' => null,
                'konten' => "Ini adalah konten lengkap untuk artikel test $i. " . Str::random(200),
                'like_count' => 0,
                'view_count' => 0,
                'is_published' => true,
            ]);
        }
    }
}
