<?php

namespace Tests\Feature\Images;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ProcessImagesTest extends TestCase
{
    private string $workDirectory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->workDirectory = storage_path('framework/testing/images-'.uniqid());
        File::ensureDirectoryExists($this->workDirectory.'/src');

        $image = imagecreatetruecolor(1000, 600);
        imagefill($image, 0, 0, imagecolorallocate($image, 0, 79, 58));
        imagejpeg($image, $this->workDirectory.'/src/fixture.jpg', 90);

        config([
            'images.output_path' => $this->workDirectory.'/out',
            'images.widths' => [480, 800, 1200, 1600, 2400],
        ]);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->workDirectory);

        parent::tearDown();
    }

    public function test_processes_a_source_into_responsive_formats_without_upscaling(): void
    {
        config(['images.sources' => ['fixture' => ['path' => $this->workDirectory.'/src/fixture.jpg']]]);

        $this->artisan('expo:images')->assertSuccessful();

        foreach ([480, 800, 1000] as $width) {
            foreach (['avif', 'webp', 'jpg'] as $format) {
                $this->assertFileExists($this->workDirectory."/out/fixture-{$width}.{$format}");
            }
        }

        $this->assertFileDoesNotExist($this->workDirectory.'/out/fixture-1200.jpg');

        $manifest = json_decode(File::get($this->workDirectory.'/out/manifest.json'), true);
        $this->assertSame(['w' => 1000, 'h' => 600, 'widths' => [480, 800, 1000]], $manifest['fixture']);
    }

    public function test_crops_to_the_requested_ratio(): void
    {
        config(['images.sources' => ['square' => ['path' => $this->workDirectory.'/src/fixture.jpg', 'ratio' => '1:1']]]);

        $this->artisan('expo:images')->assertSuccessful();

        $manifest = json_decode(File::get($this->workDirectory.'/out/manifest.json'), true);
        $this->assertSame(600, $manifest['square']['w']);
        $this->assertSame(600, $manifest['square']['h']);
        $this->assertSame([600, 600], array_slice(getimagesize($this->workDirectory.'/out/square-600.jpg'), 0, 2));
    }

    public function test_crops_to_a_box_given_in_fractions(): void
    {
        config(['images.sources' => ['mark' => ['path' => $this->workDirectory.'/src/fixture.jpg', 'crop' => [0.1, 0.25, 0.5, 0.5]]]]);

        $this->artisan('expo:images')->assertSuccessful();

        $manifest = json_decode(File::get($this->workDirectory.'/out/manifest.json'), true);
        $this->assertSame(['w' => 500, 'h' => 300, 'widths' => [480, 500]], $manifest['mark']);
    }

    public function test_max_width_limits_the_largest_output(): void
    {
        config([
            'images.widths' => [480, 800],
            'images.sources' => ['small' => ['path' => $this->workDirectory.'/src/fixture.jpg', 'max' => 480]],
        ]);

        $this->artisan('expo:images')->assertSuccessful();

        $manifest = json_decode(File::get($this->workDirectory.'/out/manifest.json'), true);
        $this->assertSame([480], $manifest['small']['widths']);
        $this->assertFileDoesNotExist($this->workDirectory.'/out/small-800.jpg');
        $this->assertFileDoesNotExist($this->workDirectory.'/out/small-1000.jpg');
    }

    public function test_a_missing_source_fails_the_command_with_its_key(): void
    {
        config(['images.sources' => ['ghost' => ['path' => $this->workDirectory.'/src/nope.jpg']]]);

        $this->artisan('expo:images')
            ->expectsOutputToContain('ghost')
            ->assertFailed();
    }
}
