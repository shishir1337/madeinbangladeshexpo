<?php

namespace Tests\Feature\View;

use App\Models\Edition;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SiteShellTest extends TestCase
{
    use RefreshDatabase;

    public function test_shell_renders_header_footer_and_skip_link(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('href="#main"', false)
            ->assertSee('<header', false)
            ->assertSee('<footer', false)
            ->assertSee('sg@brazilbangladeshchamber.com')
            ->assertSee('Shanta Skymark, 18 Gulshan Avenue, Dhaka-1212, Bangladesh');
    }

    public function test_announcement_shows_the_edition_dates(): void
    {
        $this->createCurrentEdition();

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/data-announcement[\s\S]*?22–25 March 2027[\s\S]*?Pro Magno Centro de Eventos, São Paulo/u', $html);
    }

    public function test_announcement_hidden_without_current_edition(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertDontSee('data-announcement', false);
    }

    public function test_shell_is_fully_translated_in_bangla(): void
    {
        $this->travelTo('2026-10-19 12:00:00');
        $this->createCurrentEdition();
        $this->registerPages(['about']);

        $html = $this->get('/bn')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/data-announcement[\s\S]*?২২–২৫ মার্চ ২০২৭/u', $html);
        $this->assertStringContainsString('এক্সপো সম্পর্কে', $html);
        $this->assertStringContainsString('আয়োজনে', $html);
        $this->assertStringContainsString('© ২০২৬', $html);
        $this->assertStringNotContainsString('Organised by', $html);
        $this->assertStringNotContainsString('Skip to content', $html);
    }

    public function test_mega_menu_lists_group_items_with_descriptions(): void
    {
        $this->registerPages(['about', 'exhibit']);

        $this->get('/')
            ->assertOk()
            ->assertSee('aria-controls="mega-the-expo"', false)
            ->assertSee('aria-expanded="false"', false)
            ->assertSee('About the expo')
            ->assertSee('What it is, who it is for and why São Paulo')
            ->assertSee('Show your products to buyers from Brazil and Latin America');
    }

    public function test_footer_lists_every_available_page(): void
    {
        $this->registerPages(['about', 'exhibit', 'privacy', 'contact']);

        $response = $this->get('/pt')->assertOk();

        foreach (['about', 'exhibit', 'privacy', 'contact'] as $page) {
            $response->assertSee('href="'.localized_route($page, locale: 'pt_BR').'"', false);
        }
    }

    public function test_whatsapp_link_uses_digits_only_number(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('https://wa.me/8801553676767', false)
            ->assertSee('href="tel:+8801553676767"', false);
    }

    public function test_header_ctas_appear_once_their_pages_exist(): void
    {
        $this->get('/')->assertDontSee('Apply to exhibit');

        $this->registerPages(['register', 'apply']);

        $this->get('/')
            ->assertSee('Apply to exhibit')
            ->assertSee('href="'.localized_route('register', locale: 'en').'"', false);
    }

    public function test_there_is_exactly_one_language_switcher(): void
    {
        $html = $this->get('/pt')->assertOk()->getContent();

        $this->assertSame(1, substr_count($html, 'aria-current="true"'));
        $this->assertSame(1, substr_count($html, 'aria-label="Idioma"'));
    }

    private function createCurrentEdition(): Edition
    {
        return Edition::factory()
            ->current()
            ->for(Venue::factory()->state(['name' => 'Pro Magno Centro de Eventos', 'city' => 'São Paulo']))
            ->create([
                'slug' => '2026',
                'name' => ['en' => 'Made in Bangladesh Expo 2026', 'bn' => 'মেইড ইন বাংলাদেশ এক্সপো ২০২৬'],
                'starts_on' => '2027-03-22',
                'ends_on' => '2027-03-25',
            ]);
    }

    /**
     * @param  list<string>  $pages
     */
    private function registerPages(array $pages): void
    {
        foreach ($pages as $page) {
            Route::localized(fn () => Route::get(localized_slug($page), fn () => $page)->name($page));
        }

        Route::getRoutes()->refreshNameLookups();
    }
}
