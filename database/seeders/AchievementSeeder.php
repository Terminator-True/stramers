<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            ['name' => 'First Win', 'description' => 'Win your first game', 'icon' => 'trophy.png', 'points' => 10],
            ['name' => 'Collector', 'description' => 'Collect 100 unique cards', 'icon' => 'cards.png', 'points' => 50],
            ['name' => 'Master Strategist', 'description' => 'Win 100 games', 'icon' => 'strategy.png', 'points' => 100],
            ['name' => 'Legendary', 'description' => 'Obtain a legendary card', 'icon' => 'legendary.png', 'points' => 200],
            ['name' => 'Social Butterfly', 'description' => 'Add 50 friends', 'icon' => 'friends.png', 'points' => 75],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
