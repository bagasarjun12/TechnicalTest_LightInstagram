<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 3 user
        $users = [];
        for ($i = 1; $i <= 3; $i++) {
            $users[] = [
                'username' => "user$i",
                'email' => "user$i@example.com",
                'photo' => 'default.jpg',
                'biodata' => "Hi There!",
                'password' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('users')->insert($users);

        // Buat 4 reels untuk setiap user
        $reels = [];
        $images = [];
        $attributes = [];
        foreach ($users as $index => $user) {
            $userId = $index + 1;

            // Tambahkan data gambar
            for ($j = 1; $j <= 4; $j++) {
                $imageId = count($images) + 1;
                $images[] = [
                    'id_images' => $imageId,
                    'type_file' => 'image',
                    'file' => "quote$j.jpeg",
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Tambahkan data reels
                $reels[] = [
                    'id_reels' => count($reels) + 1,
                    'id_users' => $userId,
                    'id_images' => $imageId,
                    'caption' => "Caption for reel $j by User $userId",
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Tambahkan data atribut (opsional)
                $attributes[] = [
                    'id_atributs' => count($attributes) + 1,
                    'id_reels' => count($reels),
                    'id_users' => $userId,
                    'type' => 'like', // atau 'comment', 'share', dsb
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('images')->insert($images);
        DB::table('reels')->insert($reels);
        DB::table('atributs')->insert($attributes);
    }
}
