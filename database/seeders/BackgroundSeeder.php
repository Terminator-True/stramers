<?php

namespace Database\Seeders;

use App\Models\Background;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BackgroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $backgrounds = [
            ['name' => 'Forest', 'color' => 'Green', 'cost' => 100, 'rarity' => 'Common'],
            ['name' => 'Mountain', 'color' => 'Red', 'cost' => 200, 'rarity' => 'Uncommon'],
            ['name' => 'Ocean', 'color' => 'Blue', 'cost' => 300, 'rarity' => 'Rare'],
            ['name' => 'Volcano', 'color' => 'Orange', 'cost' => 500, 'rarity' => 'Epic'],
            ['name' => 'Space', 'color' => 'Purple', 'cost' => 1000, 'rarity' => 'Legendary'],
        ];

        foreach ($backgrounds as $background) {
            Background::create(array_merge($background, ['img' => strtolower($background['name']) . '.jpg']));
        }
    }
}
