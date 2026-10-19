<?php

namespace Tests\Feature\Http;

use App\Support\Navigation\SiteNavigation;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SiteMapPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    #[DataProvider('locales')]
    public function test_every_page_in_the_navigation_opens_in_every_language(string $locale): void
    {
        $this->assertGreaterThanOrEqual(33, count(SiteNavigation::routeNames()));

        foreach (SiteNavigation::routeNames() as $page) {
            $this->get(localized_route($page, locale: $locale))->assertOk();
        }
    }

    /**
     * @return array<string, array{string}>
     */
    public static function locales(): array
    {
        return ['english' => ['en'], 'portuguese' => ['pt_BR'], 'bangla' => ['bn']];
    }

    public function test_header_and_footer_link_to_every_page(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        foreach (SiteNavigation::routeNames() as $page) {
            $this->assertStringContainsString('href="'.localized_route($page).'"', $html, "The home page does not link to [{$page}].");
        }

        foreach (['take-part', 'plan-your-trip', 'news-media', 'the-expo'] as $group) {
            $this->assertStringContainsString('id="mega-'.$group.'"', $html);
        }

        $this->assertStringContainsString('href="'.localized_route('login').'"', $html);
    }

    public function test_a_page_in_preparation_names_itself_and_is_kept_out_of_search(): void
    {
        $this->get('/pt/expor')
            ->assertOk()
            ->assertSee('<html lang="pt-BR"', false)
            ->assertSee('<meta name="robots" content="noindex', false)
            ->assertSee('Expor')
            ->assertSee('Mostre seus produtos a compradores do Brasil e da América Latina')
            ->assertSee('Calculadora de custos', false)
            ->assertSee('href="http://localhost/pt/estandes"', false);
    }

    public function test_built_pages_are_not_replaced_by_the_preparation_page(): void
    {
        $this->get('/about')->assertOk()->assertDontSee('<meta name="robots" content="noindex', false)->assertSee('What happens at the expo');
    }
}
