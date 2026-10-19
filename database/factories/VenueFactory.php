<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Venue>
 */
class VenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company().' Centro de Eventos',
            'address_line' => fake()->streetAddress(),
            'district' => fake()->word(),
            'city' => 'São Paulo',
            'state' => 'SP',
            'postal_code' => fake()->numerify('#####-###'),
            'country_code' => 'BR',
        ];
    }
}
