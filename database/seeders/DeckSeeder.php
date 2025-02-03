<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class DeckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $cards = Card::all();

        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {
                $randomCardCount = rand(20, 40);
                $deck = new Deck([
                    'user_id' => $user->id,
                    'name' => "Deck " . ($i + 1) . " of " . $user->name,
                    'selected' => $i == 0,
                    'card_count' => $randomCardCount,
                ]);
                $deck->save();

                $deck->cards()->attach(
                    $cards->random($randomCardCount)->pluck('id')->toArray(),
                    ['quantity' => 1]
                );
            }
        }
    }
}
