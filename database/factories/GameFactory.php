<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'theme' => $this->faker->words(3, true),
            'keyword' => strtoupper($this->faker->word()),
            'correct_letters' => '',
            'user_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
