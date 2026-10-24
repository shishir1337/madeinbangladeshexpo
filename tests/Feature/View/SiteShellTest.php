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

    public function test_the_announcement_bar_stays_below_the_header_so_the_phone_menu_covers_it(): void
    {
        Edition::factory()->current()->create();

        $html = $this->get('/')->assertOk()->getContent();

        preg_match('/data-announcement[^>]*class="[^"]*\bz-(\d+)/', $html, $announcement);
        preg_match('/<header[^>]*class="[^"]*\bz-(\d+)/s', $html, $header);

        $this->assertNotEmpty($announcement, 'Announcement z-index not found.');
        $this->assertLessThan((int) $header[1], (int) $announcement[1]);
    }

    public function test_header_ctas_link_to_apply_and_register(): void
    {
        $this->get('/')
            ->assertSee('Apply to exhibit')
            ->assertSee('href="'.localized_route('register', locale: 'en').'"', false);
    }

    public function test_header_ctas_only_show_on_wide_screens(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<a href="[^"]*\/apply"[^>]*class="[^"]*max-xl:hidden/', $html);
        $this->assertStringNotContainsString('hidden md:inline-flex', $html);
        $this->assertStringNotContainsString('hidden sm:inline-flex', $html);
    }

    public function test_each_mega_menu_panel_follows_its_trigger_inside_the_navigation(): void
    {
        $this->registerPages(['about', 'exhibit']);

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<nav aria-label="Main navigation"[\s\S]*?aria-controls="mega-the-expo"[\s\S]*?id="mega-the-expo"[\s\S]*?aria-controls="mega-take-part"[\s\S]*?id="mega-take-part"[\s\S]*?<\/nav>/', $html);
        $this->assertStringContainsString('x-on:focusout=', $html);
    }

    public function test_the_help_button_steps_aside_over_the_footer_and_the_footer_keeps_room_for_it_without_javascript(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<footer[^>]*data-hides-help/', $html);
        $this->assertMatchesRegularExpression('/<a[^>]*x-data="helpButton"[^>]*href="https:\/\/wa\.me\//', $html);
        $this->assertMatchesRegularExpression('/<footer[\s\S]*no-js:pb-28[\s\S]*<\/footer>/', $html);
        $this->assertStringNotContainsString('sm:pb-6', $html);
    }

    public function test_footer_sets_its_links_in_four_balanced_columns_ending_with_help_and_contact(): void
    {
        $this->registerPages(['about', 'exhibit', 'venue', 'news', 'faq', 'privacy']);

        $html = $this->get('/')->assertOk()->getContent();
        $footer = substr($html, strpos($html, '<footer'));

        $this->assertSame(4, substr_count($footer, 'data-footer-column'));
        $this->assertMatchesRegularExpression('/data-footer-column[\s\S]*?id="footer-the-expo"[\s\S]*?data-footer-column[\s\S]*?id="footer-take-part"[\s\S]*?data-footer-column[\s\S]*?id="footer-plan-your-trip"[\s\S]*?id="footer-news-media"[\s\S]*?data-footer-column[\s\S]*?id="footer-help"[\s\S]*?Talk to us/', $footer);
        $this->assertStringContainsString('aria-controls="footer-the-expo"', $footer);
        $this->assertStringContainsString('sg@<wbr>brazilbangladeshchamber.com', $footer);
    }

    public function test_footer_shows_the_current_edition(): void
    {
        $this->travelTo('2026-10-19 12:00:00');
        $this->createCurrentEdition();

        $html = $this->get('/')->assertOk()->getContent();
        $footer = substr($html, strpos($html, '<footer'));

        $this->assertMatchesRegularExpression('/22–25 March 2027[\s\S]*?Pro Magno Centro de Eventos, São Paulo/u', $footer);
    }

    public function test_dismissed_announcement_is_hidden_before_first_paint(): void
    {
        $this->createCurrentEdition();

        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('data-announcement-key="mbe.announcement.2026"', $html);
        $this->assertMatchesRegularExpression('/<head>[\s\S]*announcementKey[\s\S]*<\/head>/', $html);
    }

    public function test_layout_links_the_favicon_set_and_preloads_the_display_font(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('<link rel="icon" href="'.asset('favicon.svg').'" type="image/svg+xml">', $html);
        $this->assertStringContainsString('<link rel="apple-touch-icon" href="'.asset('apple-touch-icon.png').'">', $html);
        $this->assertMatchesRegularExpression('/<link rel="preload" href="[^"]*anek-bangla-latin-wght\.woff2" as="font" type="font\/woff2" crossorigin>/', $html);

        foreach (['favicon.svg', 'favicon.ico', 'apple-touch-icon.png', 'fonts/anek-bangla-latin-wght.woff2'] as $file) {
            $this->assertFileExists(public_path($file));
        }
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
