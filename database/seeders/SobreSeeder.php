<?php

namespace Database\Seeders;

use App\Models\Sobre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SobreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sobres = [
            ['name' => 'Basic Pack', 'type' => 'Normal', 'cost' => 100, 'rarity' => 'Common', 'cards_count' => 5],
            ['name' => 'Premium Pack', 'type' => 'Special', 'cost' => 250, 'rarity' => 'Uncommon', 'cards_count' => 7],
            ['name' => 'Elite Pack', 'type' => 'Rare', 'cost' => 500, 'rarity' => 'Rare', 'cards_count' => 10],
            ['name' => 'Legendary Pack', 'type' => 'Ultra Rare', 'cost' => 1000, 'rarity' => 'Legendary', 'cards_count' => 15],
        ];

        foreach ($sobres as $sobre) {
            Sobre::create($sobre);
        }
    }
}
