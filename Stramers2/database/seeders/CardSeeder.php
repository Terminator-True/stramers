<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary'];
        
        for ($i = 0; $i < 100; $i++) {
            Card::create([
                'name' => "Card " . $i,
                'category' => ['Attack', 'Defense', 'Spell'][rand(0, 2)],
                'type' => ['Creature', 'Artifact', 'Enchantment'][rand(0, 2)],
                'cost' => rand(1, 10),
                'dmg' => rand(0, 10),
                'life' => rand(1, 10),
                'usos' => rand(1, 5),
                'text' => "This is card number " . $i,
                'img' => "card_" . $i . ".jpg",
                'obtainable' => true,
                'rarity' => $rarities[rand(0, 4)],
            ]);
        }
    }
}
