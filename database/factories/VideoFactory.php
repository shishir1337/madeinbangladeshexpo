<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'youtube_id' => fake()->unique()->regexify('[A-Za-z0-9_-]{11}'),
            'title' => ['en' => fake()->sentence(5)],
        ];
    }
}
