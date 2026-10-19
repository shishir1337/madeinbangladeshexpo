<?php

namespace Tests\Feature\View;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class DesignSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_layout_loads_the_design_system(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<body class="font-sans', false)
            ->assertSee('id="skip-to-content"', false)
            ->assertSee('<meta name="theme-color" content="#004F3A">', false);
    }

    public function test_smooth_scrolling_is_opt_in(): void
    {
        $this->assertStringNotContainsString('data-smooth', Blade::render('<x-layouts.site title="Plain">Plain page</x-layouts.site>'));
        $this->assertStringContainsString('data-smooth', Blade::render('<x-layouts.site title="Marketing" smooth>Marketing page</x-layouts.site>'));
    }

    public function test_os_reduced_motion_is_applied_before_first_paint(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<head>[\\s\\S]*prefers-reduced-motion: reduce[\\s\\S]*<\\/head>/', $html);
    }

    public function test_reduce_motion_switch_keeps_one_accessible_name(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('role="switch"', $html);
        $this->assertStringNotContainsString('x-text="reduced ?', $html);
    }

    public function test_motif_component_renders_an_svg_pattern(): void
    {
        foreach (['jamdani', 'tiles', 'band'] as $variant) {
            $html = Blade::render('<x-ui.motif :variant="$variant" />', ['variant' => $variant]);

            $this->assertStringContainsString('<pattern', $html, "Motif [{$variant}] has no SVG pattern.");
            $this->assertStringContainsString('aria-hidden="true"', $html);
        }
    }

    public function test_each_motif_instance_uses_a_unique_pattern_id(): void
    {
        $html = Blade::render('<x-ui.motif variant="jamdani" /><x-ui.motif variant="jamdani" />');

        preg_match_all('/<pattern id="([^"]+)"/', $html, $matches);

        $this->assertCount(2, array_unique($matches[1]));
    }

    public function test_icon_component_renders_a_known_icon_and_nothing_for_an_unknown_one(): void
    {
        $this->assertStringContainsString('<svg', Blade::render('<x-ui.icon name="arrow-right" />'));
        $this->assertSame('', trim(Blade::render('<x-ui.icon name="no-such-icon" />')));
    }
}
