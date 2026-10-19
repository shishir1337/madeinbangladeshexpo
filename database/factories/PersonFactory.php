<?php

namespace Database\Factories;

use App\Enums\PersonGroup;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => ['en' => fake()->jobTitle()],
            'group' => PersonGroup::Team,
        ];
    }
}
