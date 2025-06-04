<?php

namespace Database\Seeders;

use App\Models\Chirp;
use App\Models\User;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ChirpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

// Get all users
        $users = User::all();

// 25 quotes total
        $quotes = [
            ["message" => "Life is what happens when you're busy making other plans. - John Lennon"],
            ["message" => "The only way to do great work is to love what you do. - Steve Jobs"],
            ["message" => "Imagination is more important than knowledge. - Albert Einstein"],
            ["message" => "If you want to go fast, go alone. If you want to go far, go together. - African Proverb"],
            ["message" => "Be yourself; everyone else is already taken. - Oscar Wilde"],
            ["message" => "What you do makes a difference, and you have to decide what kind of difference you want to make. - Jane Goodall"],
            ["message" => "Do not go where the path may lead, go instead where there is no path and leave a trail. - Ralph Waldo Emerson"],
            ["message" => "Simplicity is the ultimate sophistication. - Leonardo da Vinci"],
            ["message" => "The best way to predict the future is to invent it. - Alan Kay"],
            ["message" => "Sometimes the questions are complicated and the answers are simple. - Dr. Seuss"],
            ["message" => "You miss 100% of the shots you don't take. - Wayne Gretzky"],
            ["message" => "Everything you can imagine is real. - Pablo Picasso"],
            ["message" => "The mind is everything. What you think you become. - Buddha"],
            ["message" => "Don’t count the days, make the days count. - Muhammad Ali"],
            ["message" => "The unexamined life is not worth living. - Socrates"],
            ["message" => "In the middle of every difficulty lies opportunity. - Albert Einstein"],
            ["message" => "Stay hungry, stay foolish. - Steve Jobs"],
            ["message" => "It always seems impossible until it's done. - Nelson Mandela"],
            ["message" => "Creativity is intelligence having fun. - Albert Einstein"],
            ["message" => "Turn your wounds into wisdom. - Oprah Winfrey"],
            ["message" => "The journey of a thousand miles begins with a single step. - Lao Tzu"],
            ["message" => "Strive not to be a success, but rather to be of value. - Albert Einstein"],
            ["message" => "Act as if what you do makes a difference. It does. - William James"],
            ["message" => "Happiness is not something ready-made. It comes from your own actions. - Dalai Lama"],
            ["message" => "The harder you work for something, the greater you’ll feel when you achieve it. - Unknown"],
        ];

// Prepare chirps
        $chirps = [];

        foreach ($quotes as $index => $quote) {
            // Random user
            $user = $users->random();

            // Random date between Jan 1, 2025 and now
            $start = Carbon::create(2025, 1, 1)->startOfDay()->timestamp;
            $end = now()->timestamp;
            $randomTimestamp = random_int($start, $end);
            $randomDate = Carbon::createFromTimestamp($randomTimestamp);

            // Add chirp
            $chirps[] = [
                'message' => "[$index] " . $quote['message'],
                'user_id' => $user->id,
                'created_at' => $randomDate,
            ];
        }

// Sort by created_at
        usort($chirps, fn($a, $b) => $a['created_at']->timestamp <=> $b['created_at']->timestamp);

// Insert chirps in order
        foreach ($chirps as $data) {
            Chirp::create($data);
        }


    }
}
