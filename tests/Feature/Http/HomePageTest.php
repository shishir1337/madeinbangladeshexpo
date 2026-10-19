<?php

namespace Tests\Feature\Http;

use App\Models\Edition;
use App\Models\Stat;
use App\Models\Venue;
use Database\Seeders\EditionSeeder;
use Database\Seeders\HomeContentSeeder;
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

    public function test_home_never_shows_an_empty_heading_when_the_name_has_no_english_version(): void
    {
        Edition::factory()->current()->create(['name' => ['pt_BR' => 'Feira Made in Bangladesh']]);

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertDoesNotMatchRegularExpression('/<h1[^>]*>\s*<\/h1>/', $html);
        $this->assertStringNotContainsString('<title></title>', $html);
        $this->assertMatchesRegularExpression('/<h1[^>]*>\s*'.preg_quote(config('app.name'), '/').'\s*<\/h1>/', $html);
    }

    public function test_hero_answers_what_when_where(): void
    {
        $this->createCurrentEdition();

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<h1[^>]*>\s*Made in Bangladesh Expo 2026\s*<\/h1>/', $html);
        $this->assertMatchesRegularExpression('/data-hero[\s\S]*22–25 March 2027[\s\S]*Pro Magno Centro de Eventos/u', $html);
    }

    public function test_countdown_targets_the_opening_in_sao_paulo_time(): void
    {
        $this->travelTo('2026-10-20 12:00:00');
        $this->createCurrentEdition();

        $this->get('/')
            ->assertOk()
            ->assertSee('data-countdown-target="2027-03-22T13:00:00Z"', false)
            ->assertSee('data-countdown-state="upcoming"', false);
    }

    public function test_countdown_never_shows_negative_time(): void
    {
        $this->createCurrentEdition();

        $this->travelTo('2027-03-23 15:00:00');
        $this->get('/')
            ->assertOk()
            ->assertSee('data-countdown-state="live"', false)
            ->assertDontSee('data-countdown-target', false)
            ->assertSee('Happening now');

        $this->travelTo('2027-04-01 12:00:00');
        $this->get('/')
            ->assertOk()
            ->assertSee('data-countdown-state="past"', false)
            ->assertDontSee('data-countdown-target', false);
    }

    public function test_home_renders_every_section_without_a_current_edition(): void
    {
        $this->seed(HomeContentSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('<h1', false)
            ->assertDontSee('data-countdown-state', false)
            ->assertSee('data-section="paths"', false)
            ->assertSee('data-section="sectors"', false);
    }

    public function test_paths_cover_exhibitors_buyers_delegates_and_sponsors(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSeeInOrder(['Exhibit', 'Visit as a buyer', 'Join the delegation', 'Sponsor or report'])
            ->assertSee('Meet Brazilian suppliers of cotton, sugar, grain and machinery');
    }

    public function test_every_stat_on_home_shows_its_source(): void
    {
        $this->seed(HomeContentSeeder::class);

        $response = $this->get('/')->assertOk();

        Stat::query()->where('placement', 'home')->get()->each(function (Stat $stat) use ($response): void {
            $response->assertSee("{$stat->source}, {$stat->as_of}");
        });
    }

    public function test_bangla_home_uses_bangla_numerals_everywhere(): void
    {
        $this->createCurrentEdition();
        $this->seed(HomeContentSeeder::class);

        $html = $this->get('/bn')->assertOk()->getContent();

        preg_match_all('/data-count-to="[^"]*"[^>]*>([^<]*)</u', $html, $matches);

        $this->assertNotEmpty($matches[1]);
        foreach ($matches[1] as $rendered) {
            $this->assertDoesNotMatchRegularExpression('/[0-9]/', $rendered, "ASCII digits in a Bangla stat: {$rendered}");
            $this->assertMatchesRegularExpression('/[০-৯]/u', $rendered);
        }
    }

    public function test_trade_routes_show_both_directions(): void
    {
        $this->seed(HomeContentSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('data-route="sea"', false)
            ->assertSee('data-route="air"', false)
            ->assertSee('src="'.asset('img/world-dots.svg').'"', false)
            ->assertSeeInOrder(['Bangladesh sells', '281.8', 'Brazil sells', '2.72']);
    }

    public function test_all_nine_sectors_appear_with_figures(): void
    {
        $this->seed(HomeContentSeeder::class);

        $response = $this->get('/')->assertOk();

        foreach (['Garments', 'Home &amp; technical textiles', 'Pharmaceuticals', 'Leather &amp; footwear', 'Jute &amp; jute goods', 'Agro-food &amp; seafood', 'Handicrafts &amp; décor', 'Plastics &amp; toys', 'ICT &amp; software'] as $name) {
            $response->assertSee($name, false);
        }

        $response->assertSee('ComexStat, 2025');
    }

    public function test_where_section_shows_venue_address_and_directions_link(): void
    {
        $this->createCurrentEdition()->venue->update(['address_line' => 'Av. Professora Ida Kolb, 513', 'district' => 'Casa Verde', 'state' => 'SP']);

        $this->get('/')
            ->assertOk()
            ->assertSee('data-section="where"', false)
            ->assertSee('Av. Professora Ida Kolb, 513, Casa Verde, São Paulo-SP')
            ->assertSee('https://www.google.com/maps/search/?api=1&amp;query=', false);
    }

    public function test_timeline_runs_from_1972_to_the_current_edition(): void
    {
        $this->createCurrentEdition();
        $this->seed(HomeContentSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSeeInOrder(['Diplomatic relations', 'A first ministerial visit', 'data-current-edition', 'Made in Bangladesh Expo 2026'], false);
    }

    public function test_videos_load_nothing_from_youtube_until_played(): void
    {
        $this->createCurrentEdition();
        $this->seed(HomeContentSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('data-youtube-id="AhCawT3n2Uo"', false)
            ->assertDontSee('<iframe', false)
            ->assertDontSee('youtube.com/embed', false)
            ->assertDontSee('i.ytimg.com', false);
    }

    public function test_testimonials_are_attributed(): void
    {
        $this->seed(HomeContentSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSeeInOrder(["This historic event marked a turning point in Bangladesh's global trade outreach.", 'Shahriar Ahmed', 'President, BBCCI']);
    }

    public function test_partners_grouped_by_role(): void
    {
        $this->seed(EditionSeeder::class);
        $this->seed(HomeContentSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSeeInOrder(['data-partner-role="organiser"', 'Brazil Bangladesh Chamber of Commerce &amp; Industry', 'data-partner-role="supporter"', 'Embassy of Brazil in Dhaka'], false);
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
