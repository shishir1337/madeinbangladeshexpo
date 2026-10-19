<?php

namespace Database\Factories;

use App\Enums\NewsType;
use App\Models\NewsArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NewsArticle>
 */
class NewsArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => NewsType::News,
            'slug' => ['en' => fake()->unique()->slug(4)],
            'title' => ['en' => fake()->sentence(6)],
            'excerpt' => ['en' => fake()->sentence(16)],
            'published_at' => now(),
        ];
    }
}
