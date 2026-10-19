<?php

namespace Tests\Feature\View;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class IconSpriteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_a_page_defines_each_icon_once_and_every_icon_points_at_its_definition(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        preg_match_all('/<symbol id="i-([a-z0-9-]+)"/', $html, $symbols);
        preg_match_all('/<use href="#i-([a-z0-9-]+)"/', $html, $uses);

        $this->assertNotEmpty($uses[1]);
        $this->assertSame(array_unique($symbols[1]), $symbols[1], 'An icon is defined more than once.');
        $this->assertSame([], array_values(array_diff(array_unique($uses[1]), $symbols[1])), 'An icon is used without a definition.');
    }

    public function test_icons_render_inline_when_no_page_sprite_is_printed(): void
    {
        $html = Blade::render('<x-ui.icon name="arrow-right" />');

        $this->assertStringContainsString('<path', $html);
        $this->assertStringNotContainsString('<use', $html);
    }

    public function test_livewire_updates_render_icons_inline(): void
    {
        $html = $this->withHeader('X-Livewire', 'true')->get('/')->getContent();

        $this->assertStringNotContainsString('<use href="#i-', $html);
    }
}
