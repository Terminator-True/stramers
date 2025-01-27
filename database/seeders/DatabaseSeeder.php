<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // BasicsSeeder::class,
            // AdminSeeder::class
            UserSeeder::class,
            CardSeeder::class,
            DeckSeeder::class,
            BackgroundSeeder::class,
            AchievementSeeder::class,
            SobreSeeder::class,
        ]);

    }
}
