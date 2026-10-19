<?php

namespace Tests\Feature\Http;

use App\Models\Edition;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_english_home_shows_the_current_edition_dates_venue_and_organiser(): void
    {
        $this->createCurrentEdition();

        $this->get('/')
            ->assertOk()
            ->assertSee('Made in Bangladesh Expo 2026')
            ->assertSee('22–25 March 2027')
            ->assertSee('Pro Magno Centro de Eventos, São Paulo')
            ->assertSee('Organised by Brazil Bangladesh Chamber of Commerce & Industry')
            ->assertSee('+880 1553 676767');
    }

    public function test_portuguese_home_shows_the_portuguese_date_range(): void
    {
        $this->createCurrentEdition();

        $this->get('/pt')
            ->assertOk()
            ->assertSee('22 a 25 de março de 2027');
    }

    public function test_bangla_home_shows_the_bangla_name_and_bangla_numerals(): void
    {
        $this->createCurrentEdition();

        $this->get('/bn')
            ->assertOk()
            ->assertSee('মেইড ইন বাংলাদেশ এক্সপো ২০২৬')
            ->assertSee('২২–২৫ মার্চ ২০২৭');
    }

    public function test_home_renders_without_a_current_edition(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Dates to be announced')
            ->assertSee('Organised by');
    }

    private function createCurrentEdition(): Edition
    {
        return Edition::factory()
            ->current()
            ->for(Venue::factory()->state(['name' => 'Pro Magno Centro de Eventos', 'city' => 'São Paulo']))
            ->create([
                'slug' => '2026',
                'name' => [
                    'en' => 'Made in Bangladesh Expo 2026',
                    'pt_BR' => 'Made in Bangladesh Expo 2026',
                    'bn' => 'মেইড ইন বাংলাদেশ এক্সপো ২০২৬',
                ],
                'starts_on' => '2027-03-22',
                'ends_on' => '2027-03-25',
            ]);
    }
}
