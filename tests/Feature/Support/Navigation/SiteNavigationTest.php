<?php

namespace Tests\Feature\Support\Navigation;

use App\Support\Navigation\SiteNavigation;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SiteNavigationTest extends TestCase
{
    public function test_items_carry_localized_urls_labels_and_icons(): void
    {
        app()->setLocale('pt_BR');

        $item = collect(app(SiteNavigation::class)->primary())->firstWhere('key', 'the-expo')['items'][0];

        $this->assertSame('Sobre a feira', $item['label']);
        $this->assertSame(url('/pt/sobre'), $item['url']);
        $this->assertSame('info', $item['icon']);
        $this->assertNotSame('', $item['description']);
    }

    public function test_labels_follow_the_current_locale(): void
    {
        $this->registerLocalizedRoute('about');

        app()->setLocale('bn');
        $this->assertSame('এক্সপো', collect(app(SiteNavigation::class)->primary())->firstWhere('key', 'the-expo')['label']);

        app()->setLocale('en');
        $this->assertSame('The expo', collect(app(SiteNavigation::class)->primary())->firstWhere('key', 'the-expo')['label']);
    }

    public function test_footer_adds_the_legal_group_and_contact_is_separate(): void
    {
        $this->registerLocalizedRoute('privacy');
        $this->registerLocalizedRoute('contact');

        $navigation = app(SiteNavigation::class);

        $this->assertSame('legal', collect($navigation->footer())->last()['key']);
        $this->assertSame('contact', $navigation->contact()['route']);
        $this->assertNotContains('legal', array_column($navigation->primary(), 'key'));
    }

    public function test_every_entry_has_a_label_in_every_language(): void
    {
        foreach (['en', 'pt_BR', 'bn'] as $locale) {
            foreach (SiteNavigation::routeNames() as $route) {
                $this->assertNotSame("nav.items.{$route}.label", __("nav.items.{$route}.label", [], $locale), "Missing [{$locale}] label for [{$route}].");
                $this->assertNotSame("nav.items.{$route}.description", __("nav.items.{$route}.description", [], $locale), "Missing [{$locale}] description for [{$route}].");
            }
        }
    }

    private function registerLocalizedRoute(string $name): void
    {
        Route::localized(fn () => Route::get(localized_slug($name), fn () => $name)->name($name));
        Route::getRoutes()->refreshNameLookups();
    }
}
