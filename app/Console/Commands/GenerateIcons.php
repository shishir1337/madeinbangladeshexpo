<?php

namespace App\Console\Commands;

use GdImage;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Signature('expo:icons')]
#[Description('Draw the expo mark as favicon.ico, apple-touch-icon.png and app icons in public/')]
class GenerateIcons extends Command
{
    /**
     * Supersampling factor: shapes are drawn large and scaled down, which antialiases GD's hard edges.
     */
    private const SUPERSAMPLE = 8;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $outputs = [
            'apple-touch-icon.png' => [180, false],
            'icon-192.png' => [192, true],
            'icon-512.png' => [512, true],
        ];

        foreach ($outputs as $file => [$size, $rounded]) {
            imagepng($this->draw($size, $rounded), public_path($file), 9);
            $this->components->twoColumnDetail($file, "{$size}×{$size}");
        }

        File::put(public_path('favicon.ico'), $this->ico($this->draw(32, true)));
        $this->components->twoColumnDetail('favicon.ico', '32×32');

        return self::SUCCESS;
    }

    /**
     * The mark from resources/views/components/site/logo.blade.php (a 40-unit grid), drawn at $size pixels.
     */
    private function draw(int $size, bool $rounded): GdImage
    {
        $canvas = $size * self::SUPERSAMPLE;
        $unit = $canvas / 40;
        $image = imagecreatetruecolor($canvas, $canvas);
        imagesavealpha($image, true);
        imagefill($image, 0, 0, imagecolorallocatealpha($image, 0, 0, 0, 127));

        $green = imagecolorallocate($image, 0x00, 0x4F, 0x3A);
        $this->roundedSquare($image, $canvas, $rounded ? (int) round(11 * $unit) : 0, $green);

        imagefilledpolygon($image, [
            (int) round(20 * $unit), (int) round(5.5 * $unit),
            (int) round(34.5 * $unit), (int) round(20 * $unit),
            (int) round(20 * $unit), (int) round(34.5 * $unit),
            (int) round(5.5 * $unit), (int) round(20 * $unit),
        ], imagecolorallocate($image, 0xFF, 0xDF, 0x00));

        imagefilledellipse($image, (int) round(16.4 * $unit), (int) round(17.4 * $unit), (int) round(14.4 * $unit), (int) round(14.4 * $unit), imagecolorallocate($image, 0xB3, 0x12, 0x2A));
        imagefilledellipse($image, (int) round(22.4 * $unit), (int) round(21.9 * $unit), (int) round(14.8 * $unit), (int) round(14.8 * $unit), imagecolorallocate($image, 0x00, 0x27, 0x76));

        $output = imagecreatetruecolor($size, $size);
        imagealphablending($output, false);
        imagesavealpha($output, true);
        imagecopyresampled($output, $image, 0, 0, 0, 0, $size, $size, $canvas, $canvas);

        return $output;
    }

    private function roundedSquare(GdImage $image, int $size, int $radius, int $color): void
    {
        if ($radius === 0) {
            imagefilledrectangle($image, 0, 0, $size - 1, $size - 1, $color);

            return;
        }

        imagefilledrectangle($image, $radius, 0, $size - 1 - $radius, $size - 1, $color);
        imagefilledrectangle($image, 0, $radius, $size - 1, $size - 1 - $radius, $color);

        foreach ([[$radius, $radius], [$size - 1 - $radius, $radius], [$radius, $size - 1 - $radius], [$size - 1 - $radius, $size - 1 - $radius]] as [$x, $y]) {
            imagefilledellipse($image, $x, $y, $radius * 2, $radius * 2, $color);
        }
    }

    /**
     * A single-image ICO file wrapping a PNG, which every current browser accepts.
     */
    private function ico(GdImage $image): string
    {
        ob_start();
        imagepng($image, null, 9);
        $png = (string) ob_get_clean();
        $size = imagesx($image);

        return pack('vvv', 0, 1, 1)
            .pack('CCCCvvVV', $size, $size, 0, 0, 1, 32, strlen($png), 22)
            .$png;
    }
}
