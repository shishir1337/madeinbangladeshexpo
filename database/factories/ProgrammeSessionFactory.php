<?php

namespace Database\Factories;

use App\Enums\SessionKind;
use App\Models\Edition;
use App\Models\ProgrammeSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProgrammeSession>
 */
class ProgrammeSessionFactory extends Factory
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
            'day' => fake()->date(),
            'title' => ['en' => fake()->sentence(3)],
            'kind' => SessionKind::Seminar,
        ];
    }
}
