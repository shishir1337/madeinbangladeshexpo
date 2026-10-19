<?php

namespace Database\Factories;

use App\Models\Stat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Stat>
 */
class StatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => fake()->unique()->slug(2),
            'value' => fake()->numberBetween(1, 999),
            'decimals' => 0,
            'label' => ['en' => fake()->sentence(4)],
            'source' => 'Demo source',
            'as_of' => '2025',
            'placement' => 'home',
        ];
    }
}
