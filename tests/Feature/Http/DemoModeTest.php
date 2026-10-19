<?php

namespace Tests\Feature\Http;

use Tests\TestCase;

class DemoModeTest extends TestCase
{
    public function test_demo_mode_marks_pages_noindex_and_shows_the_ribbon(): void
    {
        config(['expo.demo_mode' => true]);

        $this->get('/pt')
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
            ->assertSee('Site de demonstração');
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
