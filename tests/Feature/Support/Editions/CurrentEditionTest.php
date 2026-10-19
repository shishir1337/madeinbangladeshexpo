<?php

namespace Tests\Feature\Support\Editions;

use App\Models\Edition;
use App\Support\Editions\CurrentEdition;
use Database\Seeders\EditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrentEditionTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_the_edition_marked_current(): void
    {
        Edition::factory()->archived()->create();
        $current = Edition::factory()->current()->create();

        $this->assertTrue(app(CurrentEdition::class)->get()->is($current));
    }

    public function test_returns_null_when_no_edition_is_current(): void
    {
        Edition::factory()->archived()->create();

        $this->assertNull(app(CurrentEdition::class)->get());
    }

    public function test_seeder_creates_the_2025_archive_and_the_current_2026_edition(): void
    {
        $this->seed(EditionSeeder::class);
        $this->seed(EditionSeeder::class);

        $current = app(CurrentEdition::class)->get();

        $this->assertSame(2, Edition::count());
        $this->assertSame('2026', $current->slug);
        $this->assertSame('2027-03-22', $current->starts_on->toDateString());
        $this->assertSame('2027-03-25', $current->ends_on->toDateString());
        $this->assertSame('2027-03-22 10:00', $current->openingAtIn('America/Sao_Paulo')->format('Y-m-d H:i'));
        $this->assertSame('Pro Magno Centro de Eventos', $current->venue->name);
        $this->assertSame('মেইড ইন বাংলাদেশ এক্সপো ২০২৬', $current->getTranslation('name', 'bn'));
    }
}
