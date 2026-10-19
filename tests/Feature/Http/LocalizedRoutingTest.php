<?php

namespace Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LocalizedRoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_english_home_renders_at_the_root(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<html lang="en"', false);
    }

    public function test_portuguese_home_renders_under_pt(): void
    {
        $this->get('/pt')
            ->assertOk()
            ->assertSee('<html lang="pt-BR"', false);
    }

    public function test_bangla_home_renders_under_bn(): void
    {
        $this->get('/bn')
            ->assertOk()
            ->assertSee('<html lang="bn"', false);
    }

    public function test_trailing_slash_on_language_root_renders_same_page(): void
    {
        $this->get('/pt/')
            ->assertOk()
            ->assertSee('<html lang="pt-BR"', false);
    }

    #[DataProvider('legacyPrefixRedirects')]
    public function test_variant_language_prefixes_redirect_permanently(string $request, string $expected): void
    {
        $this->get($request)
            ->assertStatus(301)
            ->assertRedirect(url($expected));
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function legacyPrefixRedirects(): array
    {
        return [
            'lowercase pt-br' => ['/pt-br', '/pt'],
            'uppercase PT' => ['/PT', '/pt'],
            'explicit en' => ['/en', '/'],
            'bn-bd' => ['/bn-bd', '/bn'],
            'pt-br with a path' => ['/pt-br/sobre', '/pt/sobre'],
        ];
    }

    #[DataProvider('offSiteTargets')]
    public function test_legacy_redirect_never_leaves_the_site(string $request): void
    {
        $location = $this->get($request)->assertStatus(301)->headers->get('Location');

        $this->assertSame('localhost', parse_url($location, PHP_URL_HOST));
    }

    /**
     * @return array<string, array{string}>
     */
    public static function offSiteTargets(): array
    {
        return [
            'absolute url after en' => ['/en/https://evil.example/phish'],
            'encoded slashes after en' => ['/en/https:%2F%2Fevil.example/phish'],
            'protocol-relative after EN' => ['/EN//evil.example/phish'],
        ];
    }

    public function test_blank_portuguese_slug_falls_back_and_never_replaces_the_home_page(): void
    {
        Lang::addLines(['routes.about' => ''], 'pt_BR');
        Lang::addLines(['routes.about' => 'about'], 'en');
        Route::localized(fn () => Route::get(localized_slug('about'), fn () => app()->getLocale())->name('about'));
        Route::getRoutes()->refreshNameLookups();

        $this->get('/pt')->assertOk()->assertSee('<html lang="pt-BR"', false);
        $this->get('/pt/about')->assertOk()->assertSee('pt_BR');
    }

    public function test_translated_slugs_resolve_in_each_locale(): void
    {
        $this->registerAboutRoute();

        $this->get('/pt/sobre')->assertOk()->assertSee('pt_BR');
        $this->get('/about')->assertOk()->assertSee('en');
        $this->get('/bn/about')->assertOk()->assertSee('bn');
    }

    public function test_missing_portuguese_slug_falls_back_to_english_slug(): void
    {
        Lang::addLines(['routes.press-kit' => 'press-kit'], 'en');
        Route::localized(fn () => Route::get(localized_slug('press-kit'), fn () => app()->getLocale())->name('press-kit'));
        Route::getRoutes()->refreshNameLookups();

        $this->get('/pt/press-kit')->assertOk()->assertSee('pt_BR');
    }

    public function test_locale_does_not_leak_between_requests(): void
    {
        $this->get('/bn')->assertOk();

        $this->get('/')
            ->assertOk()
            ->assertSee('<html lang="en"', false);
    }

    public function test_localized_route_builds_prefixed_urls(): void
    {
        $this->assertSame(url('/bn'), localized_route('home', locale: 'bn'));
        $this->assertSame(url('/'), localized_route('home', locale: 'en'));
    }

    private function registerAboutRoute(): void
    {
        Lang::addLines(['routes.about' => 'sobre'], 'pt_BR');
        Lang::addLines(['routes.about' => 'about'], 'en');
        Route::localized(fn () => Route::get(localized_slug('about'), fn () => app()->getLocale())->name('about'));
        Route::getRoutes()->refreshNameLookups();
    }
}
