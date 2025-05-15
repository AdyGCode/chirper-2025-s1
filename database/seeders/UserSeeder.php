<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedUsers = [
            [
                'id' => 100,
                'name' => 'Admin Istrator',
                'email' => 'admin@example.com',
                'password' => 'Password1',
                'email_verified_at' => now(),
            ],

            [
                'id' => 200,
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'password' => 'Password1',
                'email_verified_at' => null,
            ],

            [
                'id' => 201,
                'name' => 'Client User',
                'email' => 'client@example.com',
                'password' => 'Password1',
                'email_verified_at' => null,
            ],
        ];

        foreach ($seedUsers as $user) {
            $user = User::updateOrCreate(
                ['id' => $user['id']],
                $user
            );
        }

        // Add an extra 50 random users
        // User::factory()->count(50)->create();

    }
}
