<?php

namespace Tests\Feature\View;

use App\Support\Images\ImageManifest;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ImgComponentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance(ImageManifest::class, new ImageManifest([
            'hall' => ['w' => 1000, 'h' => 600, 'widths' => [480, 800, 1000]],
        ]));
    }

    public function test_img_component_renders_picture_with_dimensions(): void
    {
        $html = Blade::render('<x-ui.img key="hall" alt="The expo hall" sizes="100vw" />');

        $this->assertStringContainsString('<picture', $html);
        $this->assertStringContainsString('type="image/avif"', $html);
        $this->assertStringContainsString('type="image/webp"', $html);
        $this->assertStringContainsString('img/hall-480.avif 480w', $html);
        $this->assertStringContainsString('img/hall-1000.jpg 1000w', $html);
        $this->assertStringContainsString('width="1000"', $html);
        $this->assertStringContainsString('height="600"', $html);
        $this->assertStringContainsString('alt="The expo hall"', $html);
        $this->assertStringContainsString('loading="lazy"', $html);
    }

    public function test_eager_images_are_high_priority(): void
    {
        $html = Blade::render('<x-ui.img key="hall" alt="" eager />');

        $this->assertStringContainsString('loading="eager"', $html);
        $this->assertStringContainsString('fetchpriority="high"', $html);
    }

    public function test_unknown_image_renders_nothing(): void
    {
        Log::spy();

        $this->assertSame('', trim(Blade::render('<x-ui.img key="missing" alt="x" />')));

        Log::shouldHaveReceived('warning')->once();
    }
}
