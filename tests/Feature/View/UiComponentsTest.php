<?php

namespace Tests\Feature\View;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class UiComponentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_button_renders_link_or_button(): void
    {
        $this->assertStringContainsString('<a href="/exhibit"', Blade::render('<x-ui.button href="/exhibit">Exhibit</x-ui.button>'));
        $this->assertStringContainsString('<button type="submit"', Blade::render('<x-ui.button type="submit">Send</x-ui.button>'));
    }

    public function test_breadcrumbs_emit_json_ld_and_mark_the_current_page(): void
    {
        $html = Blade::render('<x-ui.breadcrumbs :items="$items" />', ['items' => [
            ['label' => 'Home', 'url' => 'http://localhost'],
            ['label' => 'Sectors', 'url' => 'http://localhost/sectors'],
            ['label' => 'Jute', 'url' => null],
        ]]);

        $this->assertStringContainsString('<script type="application/ld+json">', $html);
        $this->assertStringContainsString('"@type":"BreadcrumbList"', $html);
        $this->assertStringContainsString('"item":"http://localhost/sectors"', $html);
        $this->assertMatchesRegularExpression('/aria-current="page"[^>]*>\s*Jute/', $html);
    }

    public function test_tabs_follow_the_aria_tab_pattern(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui.tabs id="faq" label="Audiences" :tabs="['exhibitors' => 'Exhibitors', 'buyers' => 'Buyers']">
                <x-ui.tab name="exhibitors">Exhibitor answers</x-ui.tab>
                <x-ui.tab name="buyers">Buyer answers</x-ui.tab>
            </x-ui.tabs>
        BLADE);

        $this->assertStringContainsString('role="tablist"', $html);
        $this->assertSame(2, substr_count($html, 'role="tab"'));
        $this->assertSame(2, substr_count($html, 'role="tabpanel"'));
        $this->assertStringContainsString('aria-controls="faq-panel-buyers"', $html);
        $this->assertStringContainsString('id="faq-panel-buyers"', $html);
        $this->assertStringContainsString('aria-labelledby="faq-tab-buyers"', $html);
        $this->assertStringContainsString('Buyer answers', $html);
    }

    public function test_accordion_items_work_without_javascript(): void
    {
        $html = Blade::render('<x-ui.accordion><x-ui.accordion-item title="Is entry free?">Yes, for registered buyers.</x-ui.accordion-item></x-ui.accordion>');

        $this->assertStringContainsString('<details', $html);
        $this->assertMatchesRegularExpression('/<summary[^>]*>[\s\S]*Is entry free\?/', $html);
    }

    public function test_stat_renders_the_final_value_in_the_page_language(): void
    {
        app()->setLocale('bn');

        $html = Blade::render('<x-ui.stat :value="1234567" label="Visitors" />');

        $this->assertStringContainsString('১২,৩৪,৫৬৭', $html);
        $this->assertStringContainsString('data-count-to="1234567"', $html);
    }

    public function test_cards_declare_their_tone_so_dark_section_styles_stop_at_them(): void
    {
        $this->assertStringContainsString('data-tone="white"', Blade::render('<x-ui.card>Light card</x-ui.card>'));
        $this->assertStringContainsString('data-tone="midnight"', Blade::render('<x-ui.card tone="midnight">Dark card</x-ui.card>'));
    }

    public function test_section_exposes_its_tone(): void
    {
        $this->assertStringContainsString('data-tone="midnight"', Blade::render('<x-ui.section tone="midnight">Hi</x-ui.section>'));
    }

    public function test_styleguide_is_hidden_in_production(): void
    {
        $this->app['env'] = 'production';
        config(['expo.demo_mode' => false]);

        $this->get('/_styleguide')->assertNotFound();
    }

    public function test_styleguide_renders_locally(): void
    {
        $this->app['env'] = 'local';

        $this->get('/_styleguide')
            ->assertOk()
            ->assertSee('Style guide')
            ->assertSee('role="tablist"', false);
    }
}
