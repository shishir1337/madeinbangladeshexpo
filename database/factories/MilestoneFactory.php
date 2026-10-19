<?php

namespace Database\Factories;

use App\Models\Milestone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Milestone>
 */
class MilestoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'happened_on' => fake()->date(),
            'title' => ['en' => fake()->sentence(4)],
            'body' => ['en' => fake()->sentence(12)],
        ];
    }
}
