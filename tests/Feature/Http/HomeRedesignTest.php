<?php

namespace Tests\Feature\Http;

use App\Models\Edition;
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
