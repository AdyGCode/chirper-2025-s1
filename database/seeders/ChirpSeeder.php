<?php

namespace Database\Seeders;

use App\Models\Chirp;
use App\Models\User;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class ChirpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        for ($count = 0; $count <= 3; $count++) {
            foreach ($users as $user) {
                $chirpMessage = "[$count] " . Lorem::paragraph();
                $chirp = new Chirp([
                    'message' => $chirpMessage,
                    'user_id' => $user->id,
                    'created_at' => now()->addSeconds(random_int(-60, 60)),
                ]);
                $chirp->save();
            }
        }

    }
}
