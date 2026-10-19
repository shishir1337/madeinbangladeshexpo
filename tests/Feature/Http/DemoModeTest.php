<?php

namespace Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoModeTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_mode_marks_pages_noindex_and_shows_the_ribbon(): void
    {
        config(['expo.demo_mode' => true]);

        $this->get('/pt')
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
            ->assertSee('Site de demonstração');
    }

    public function test_demo_ribbon_is_a_styled_banner(): void
    {
        config(['expo.demo_mode' => true]);

        $this->get('/')
            ->assertOk()
            ->assertSee('class="demo-ribbon', false)
            ->assertSee('bg-crimson', false);
    }

    public function test_without_demo_mode_pages_are_indexable_and_show_no_ribbon(): void
    {
        config(['expo.demo_mode' => false]);

        $this->get('/pt')
            ->assertOk()
            ->assertHeaderMissing('X-Robots-Tag')
            ->assertDontSee('demo-ribbon');
    }
}
