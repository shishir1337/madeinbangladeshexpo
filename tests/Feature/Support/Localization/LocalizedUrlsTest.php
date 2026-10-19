<?php

namespace Tests\Feature\Support\Localization;

use App\Support\Localization\LocalizedUrls;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LocalizedUrlsTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_lists_an_alternate_link_for_every_locale_and_x_default(): void
    {
        $this->get('/pt')
            ->assertOk()
            ->assertSee('hreflang="en" href="http://localhost"', false)
            ->assertSee('hreflang="pt-BR" href="http://localhost/pt"', false)
            ->assertSee('hreflang="bn" href="http://localhost/bn"', false)
            ->assertSee('hreflang="x-default" href="http://localhost"', false);
    }

    public function test_switcher_links_to_the_same_page_in_other_languages_and_marks_the_current_one(): void
    {
        Lang::addLines(['routes.about' => 'sobre'], 'pt_BR');
        Route::localized(fn () => Route::get(localized_slug('about'), fn () => Blade::render('<x-layouts.site title="About">About</x-layouts.site>'))->name('about'));
        Route::getRoutes()->refreshNameLookups();

        $response = $this->get('/pt/sobre')
            ->assertOk()
            ->assertSee('href="http://localhost/about"', false)
            ->assertSee('href="http://localhost/bn/about"', false);

        $html = $response->getContent();
        $this->assertSame(1, substr_count($html, 'aria-current="true"'));
        $this->assertMatchesRegularExpression('/<a[^>]*href="http:\/\/localhost\/pt\/sobre"[^>]*aria-current="true"[^>]*>\s*Português/u', $html);
    }

    public function test_alternates_are_empty_on_a_route_that_is_not_localized(): void
    {
        Route::get('/plain', fn () => json_encode(app(LocalizedUrls::class)->alternates()));

        $this->get('/plain')
            ->assertOk()
            ->assertContent('[]');
    }
}
