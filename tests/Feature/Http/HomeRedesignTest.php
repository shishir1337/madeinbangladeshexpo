<?php

namespace Tests\Feature\Http;

use App\Models\Edition;
use App\Models\Sector;
use App\View\HomePage;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeRedesignTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_the_hero_title_keeps_the_series_name_and_stamps_the_edition(): void
    {
        $this->assertSame(['series' => 'Made in Bangladesh Expo', 'edition' => '2026'], app(HomePage::class)->titleParts());

        app()->setLocale('bn');
        $this->assertSame(['series' => 'মেইড ইন বাংলাদেশ এক্সপো', 'edition' => '২০২৬'], app(HomePage::class)->titleParts());
    }

    public function test_a_title_that_is_not_series_plus_edition_stays_whole(): void
    {
        Edition::query()->update(['is_current' => false]);
        Edition::factory()->current()->create(['name' => ['en' => 'Bangladesh Week in São Paulo']]);

        $this->assertSame(['series' => 'Bangladesh Week in São Paulo', 'edition' => ''], app(HomePage::class)->titleParts());
    }

    public function test_trade_balance_compares_millions_with_billions(): void
    {
        $this->assertSame(['bangladesh' => 9.4, 'brazil' => 90.6], app(HomePage::class)->tradeBalance());
    }

    public function test_the_ticket_shows_the_route_and_a_rolling_countdown_in_the_page_digits(): void
    {
        $this->travelTo('2026-10-20 12:00:00');

        $this->get('/')->assertOk()
            ->assertSee('data-section="ticket"', false)
            ->assertSeeInOrder(['DAC', 'GRU'])
            ->assertSee('odometer-strip', false);

        $this->get('/bn')->assertOk()->assertSee('<span>৯</span>', false);
    }

    public function test_every_edition_appears_in_order_as_one_series_with_the_next_one_to_come(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        $editions = substr($html, strpos($html, 'data-section="editions"'));

        $this->assertSeeInOrderIn($editions, ['First edition', '15–18 June 2025', 'Second edition', '22–25 March 2027', 'Next edition']);
        $this->assertStringContainsString('href="'.localized_route('archive').'"', $editions);
    }

    public function test_a_past_edition_shows_what_happened_there(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        $editions = substr($html, strpos($html, 'data-section="editions"'), 6000);

        $this->assertMatchesRegularExpression('/data-edition="2025"[\s\S]*?>15<[\s\S]*?exhibitors/u', $editions);
    }

    public function test_the_programme_shows_what_happens_at_the_expo(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('data-section="programme"', false)
            ->assertSeeInOrder(['Exhibition', 'B2B meetings', 'Seminars', 'Ceremonies and press']);
    }

    public function test_each_sector_card_shows_a_photo_of_its_own_sector_in_every_language(): void
    {
        $sectors = Sector::query()->orderBy('sort')->get();
        $this->assertCount(9, $sectors->whereNotNull('image'));

        foreach (['/', '/pt', '/bn'] as $path) {
            $html = $this->get($path)->assertOk()->getContent();

            foreach ($sectors as $sector) {
                $start = strpos($html, 'data-sector-card="'.$sector->id.'"');
                $this->assertNotFalse($start, "{$path}: no card for [{$sector->getTranslation('slug', 'en')}].");

                $card = substr($html, $start, strpos($html, '</article>', $start) - $start);
                $this->assertStringContainsString("img/{$sector->image}-", $card, "{$path}: [{$sector->getTranslation('slug', 'en')}] does not show its photo.");
            }
        }
    }

    public function test_a_sector_without_a_photo_keeps_its_own_material_in_every_language(): void
    {
        Sector::query()->update(['image' => null]);

        foreach (['/', '/pt', '/bn'] as $path) {
            $html = $this->get($path)->assertOk()->getContent();

            $this->assertMatchesRegularExpression('/data-sector-card="\d+"[^>]*>\s*<div class="swatch swatch--terry/', $html, "{$path}: textiles lost its terry background.");
            $this->assertMatchesRegularExpression('/data-sector-card="\d+"[^>]*>\s*<div class="swatch swatch--circuit/', $html, "{$path}: ICT lost its circuit background.");
        }
    }

    public function test_partner_cards_fill_their_row_and_logos_cannot_be_squeezed(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        $partners = substr($html, strpos($html, 'data-section="partners"'));
        $partners = substr($partners, 0, strpos($partners, '</section>'));

        $this->assertStringContainsString('lg:grid-cols-3', $partners);
        $this->assertMatchesRegularExpression('/<span class="[^"]*shrink-0[^"]*">\s*<picture>/', $partners);
    }

    public function test_the_ticket_clock_can_say_it_is_the_weekend(): void
    {
        $this->get('/')->assertOk()->assertSee('Weekend');
        $this->get('/pt')->assertOk()->assertSee('Fim de semana');
    }

    /**
     * @param  list<string>  $values
     */
    private function assertSeeInOrderIn(string $html, array $values): void
    {
        $position = 0;

        foreach ($values as $value) {
            $found = mb_strpos($html, e($value), $position);
            $this->assertNotFalse($found, "[{$value}] was not found in order.");
            $position = $found + mb_strlen(e($value));
        }
    }
}
