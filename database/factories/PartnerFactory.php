<?php

namespace Database\Factories;

use App\Enums\PartnerRole;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ['en' => fake()->company()],
            'role' => PartnerRole::Institutional,
        ];
    }
}
