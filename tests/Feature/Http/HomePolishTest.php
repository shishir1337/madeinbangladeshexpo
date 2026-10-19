<?php

namespace Tests\Feature\Http;

use App\Models\Edition;
use App\Models\Video;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * The finished home page: press coverage, clickable photos, consistent calls to action, translated details and
 * a bounded number of queries.
 */
class HomePolishTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_home_shows_recent_press_coverage_linking_to_each_publisher(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('data-section="press"', false)
            ->assertSee('The Daily Star')
            ->assertSee('href="https://propmark.com.br/conexao-asia/conexao-asia-made-in-bangladesh/" target="_blank" rel="noopener"', false)
            ->assertSee('href="'.localized_route('news').'"', false);

        $this->get('/pt')->assertOk()->assertSee('Conexão Ásia: Made in Bangladesh');
    }

    public function test_highlight_photos_open_in_the_lightbox_and_link_to_the_gallery(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        $highlights = substr($html, strpos($html, 'data-section="highlights"'));

        $this->assertStringContainsString('x-data="lightbox(', $highlights);
        $this->assertSame(6, substr_count(strstr($highlights, 'data-section="partners"', true) ?: $highlights, 'data-lightbox-item="'));
        $this->assertStringContainsString('href="'.localized_route('gallery').'"', $highlights);
    }

    public function test_every_buyer_call_to_action_goes_to_registration(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        $register = localized_route('register');

        foreach (['data-hero', 'data-section="paths"', 'data-section="cta"'] as $section) {
            $part = substr($html, strpos($html, $section), 20000);
            $this->assertStringContainsString('href="'.$register.'"', $part, "The buyer call to action in [{$section}] should go to registration.");
        }

        $this->assertStringNotContainsString('href="'.localized_route('visit').'" class="group/link', $html);
    }

    public function test_photo_credit_and_city_are_in_the_page_language(): void
    {
        $this->get('/pt')->assertOk()->assertSee('Foto: Kaique Rocha / Pexels');

        $html = $this->get('/bn')->assertOk()->getContent();
        $this->assertStringContainsString('ছবি: Kaique Rocha / Pexels', $html);
        $this->assertMatchesRegularExpression('/<title>[^<]*সাও পাওলো<\/title>/u', $html);
        $this->assertStringNotContainsString('দ্বিতীয় আসর · São Paulo', $html);
    }

    public function test_hero_eyebrow_has_no_dangling_separator_without_a_venue(): void
    {
        Edition::query()->current()->firstOrFail()->update(['venue_id' => null]);

        $this->get('/')->assertOk()->assertDontSee('Second edition · <', false)->assertSee('Second edition');
    }

    public function test_social_card_describes_the_image(): void
    {
        $this->get('/')->assertOk()->assertSee('<meta property="og:image:alt" content="'.e(__('home.hero.photo_main')).'">', false);
    }

    public function test_hero_video_is_the_featured_one(): void
    {
        $other = Video::query()->where('is_featured', false)->firstOrFail();
        Video::query()->update(['is_featured' => false]);
        $other->update(['is_featured' => true]);

        $html = $this->get('/')->getContent();
        $hero = substr($html, strpos($html, 'data-hero'), 12000);
        $this->assertStringContainsString($other->youtube_id, $hero);
    }

    public function test_countdown_after_the_expo_points_to_its_highlights(): void
    {
        $this->travelTo(Edition::query()->current()->firstOrFail()->ends_on->addWeek());

        $this->get('/')->assertOk()->assertSee('data-countdown-state="past"', false)->assertSee('href="#highlights"', false);
    }

    public function test_scrolling_rows_are_reachable_by_keyboard(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        preg_match_all('/<(?:ul|div|ol)[^>]*class="[^"]*(?:swipe-row|track-gutter)[^"]*"[^>]*>/', $html, $rows);
        $this->assertGreaterThanOrEqual(3, count($rows[0]));

        foreach ($rows[0] as $row) {
            $this->assertStringContainsString('tabindex="0"', $row);
            $this->assertStringContainsString('aria-label="', $row);
        }
    }

    public function test_trade_map_caption_is_announced_with_the_figure(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertDoesNotMatchRegularExpression('/<figure[^>]*role="img"/', $html);
        $this->assertMatchesRegularExpression('/<figure[^>]*>.*?role="img".*?<figcaption/s', $html);
    }

    public function test_home_page_runs_a_small_fixed_number_of_queries(): void
    {
        $this->get('/');

        DB::enableQueryLog();
        $this->get('/')->assertOk();
        $queries = array_map(fn (array $query): string => $query['query'].' '.json_encode($query['bindings']), DB::getQueryLog());

        $this->assertLessThanOrEqual(14, count($queries), implode("\n", $queries));
        $this->assertSame(count($queries), count(array_unique($queries)), 'A query ran twice: '.implode("\n", $queries));
    }
}
