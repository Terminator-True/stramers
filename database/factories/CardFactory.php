<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'category' => $this->faker->randomElement(['Attack', 'Defense', 'Magic', 'Utility']),
            'type' => $this->faker->randomElement(['Fire', 'Water', 'Earth', 'Air']),
            'cost' => $this->faker->numberBetween(1, 10),
            'dmg' => $this->faker->numberBetween(0, 100),
            'life' => $this->faker->numberBetween(0, 100),
            'usos' => $this->faker->numberBetween(1, 5),
            'text' => $this->faker->sentence(10),
            'img' => 'imgs/logo.png', // se puede reemplazar en los tests si subes imágenes reales
            'obtainable' => $this->faker->boolean(),
            'rarity' => $this->faker->randomElement(['common', 'rare', 'epic', 'legendary']),
        ];
    }
}
