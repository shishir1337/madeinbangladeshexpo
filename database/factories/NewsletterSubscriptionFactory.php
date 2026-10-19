<?php

namespace Database\Factories;

use App\Models\NewsletterSubscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NewsletterSubscription>
 */
class NewsletterSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'locale' => 'en',
            'consent_version' => config('expo.consent.newsletter_version'),
            'consented_at' => now(),
            'consent_ip' => fake()->ipv4(),
        ];
    }

    /**
     * Indicate that the subscriber clicked the confirmation link.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'confirmed_at' => now(),
        ]);
    }
}
