<?php

namespace Database\Factories;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sector>
 */
class SectorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'slug' => ['en' => str($name)->slug()->toString()],
            'name' => ['en' => ucfirst($name)],
            'summary' => ['en' => fake()->sentence(10)],
            'icon' => 'layers',
        ];
    }
}
