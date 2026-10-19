<?php

namespace Database\Factories;

use App\Models\Edition;
use App\Models\Exhibitor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Exhibitor>
 */
class ExhibitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'edition_id' => Edition::factory(),
            'name' => fake()->unique()->company(),
        ];
    }
}
