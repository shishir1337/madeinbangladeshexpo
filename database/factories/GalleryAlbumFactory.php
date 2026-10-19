<?php

namespace Database\Factories;

use App\Models\GalleryAlbum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GalleryAlbum>
 */
class GalleryAlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => ['en' => fake()->unique()->slug(3)],
            'title' => ['en' => fake()->sentence(3)],
            'cover' => 'expo25-welcome',
        ];
    }
}
