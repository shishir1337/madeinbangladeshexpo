<?php

namespace Database\Factories;

use App\Enums\EditionStatus;
use App\Models\Edition;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Edition>
 */
class EditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = fake()->unique()->numberBetween(2030, 9999);

        return [
            'venue_id' => Venue::factory(),
            'slug' => (string) $year,
            'number' => fake()->numberBetween(1, 50),
            'name' => ['en' => "Made in Bangladesh Expo {$year}"],
            'starts_on' => "{$year}-03-22",
            'ends_on' => "{$year}-03-25",
            'opening_at' => null,
            'timezone' => 'America/Sao_Paulo',
            'status' => EditionStatus::Announced,
            'is_current' => false,
        ];
    }

    /**
     * Indicate that the edition is the one the site is promoting.
     */
    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EditionStatus::Announced,
            'is_current' => true,
        ]);
    }

    /**
     * Indicate that the edition is a past, archived one.
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EditionStatus::Archived,
            'is_current' => false,
        ]);
    }
}
