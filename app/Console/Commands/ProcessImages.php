<?php

namespace App\Console\Commands;

use GdImage;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Signature('expo:images {--force : Re-encode images whose outputs already exist}')]
#[Description('Turn the configured source photos into responsive AVIF, WebP and JPEG sets in public/img')]
class ProcessImages extends Command
{
    private const AVIF_QUALITY = 52;

    private const WEBP_QUALITY = 78;

    private const JPEG_QUALITY = 80;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        ini_set('memory_limit', '2G');

        $outputPath = config('images.output_path');
        $manifestPath = $outputPath.'/manifest.json';
        File::ensureDirectoryExists($outputPath);

        $manifest = File::exists($manifestPath) ? (json_decode(File::get($manifestPath), true) ?? []) : [];
        $failed = false;

        foreach (config('images.sources') as $key => $source) {
            if (! File::exists($source['path'])) {
                $this->components->error("[{$key}] source not found: {$source['path']}");
                $failed = true;

                continue;
            }

            if (! $this->option('force') && isset($manifest[$key]) && $this->outputsAreFresh($key, $source, $manifest[$key], $outputPath)) {
                $this->components->twoColumnDetail($key, 'up to date');

                continue;
            }

            $manifest[$key] = $this->process($key, $source, $outputPath);
            $this->components->twoColumnDetail($key, "{$manifest[$key]['w']}×{$manifest[$key]['h']}");
        }

        ksort($manifest);
        File::put($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    /**
     * @param  array{path: string, crop?: array{0: float, 1: float, 2: float, 3: float}, ratio?: string, focus?: array{0: float, 1: float}, max?: int}  $source
     * @return array{w: int, h: int, widths: list<int>}
     */
    private function process(string $key, array $source, string $outputPath): array
    {
        $image = $this->load($source['path']);

        if (isset($source['crop'])) {
            $image = $this->cropToBox($image, $source['crop']);
        }

        $image = $this->cropToRatio($image, $source['ratio'] ?? null, $source['focus'] ?? [0.5, 0.5]);
        $width = imagesx($image);
        $height = imagesy($image);
        $widths = $this->widthsFor(min($width, $source['max'] ?? $width));

        // Downscale once to the largest output, then derive the smaller sizes from it: much faster than
        // resampling a 7008 px original five times, with no visible difference.
        $working = $widths[array_key_last($widths)] < $width ? $this->resize($image, $widths[array_key_last($widths)]) : $image;

        foreach (array_reverse($widths) as $targetWidth) {
            $resized = $targetWidth === imagesx($working) ? $working : $this->resize($working, $targetWidth);
            $base = "{$outputPath}/{$key}-{$targetWidth}";

            imageavif($resized, "{$base}.avif", self::AVIF_QUALITY, 6);
            imagewebp($resized, "{$base}.webp", self::WEBP_QUALITY);
            imagejpeg($this->flattened($resized), "{$base}.jpg", self::JPEG_QUALITY);
        }

        return ['w' => $width, 'h' => $height, 'widths' => $widths];
    }

    /**
     * The configured widths up to the limit (the image's width, or its configured max), plus the limit itself
     * when it falls between two configured widths. Never upscales.
     *
     * @return list<int>
     */
    private function widthsFor(int $limit): array
    {
        $widths = array_values(array_filter(config('images.widths'), fn (int $width): bool => $width <= $limit));

        if ($limit < max(config('images.widths')) && ! in_array($limit, $widths, true)) {
            $widths[] = $limit;
        }

        return $widths;
    }

    /**
     * @param  array{0: float, 1: float, 2: float, 3: float}  $box  x, y, width and height as fractions of the image
     */
    private function cropToBox(GdImage $image, array $box): GdImage
    {
        $width = imagesx($image);
        $height = imagesy($image);

        return imagecrop($image, [
            'x' => (int) round($box[0] * $width),
            'y' => (int) round($box[1] * $height),
            'width' => (int) round($box[2] * $width),
            'height' => (int) round($box[3] * $height),
        ]);
    }

    private function load(string $path): GdImage
    {
        $image = imagecreatefromstring(File::get($path));
        imagealphablending($image, false);
        imagesavealpha($image, true);

        $orientation = function_exists('exif_read_data') && in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'jpeg'], true)
            ? (@exif_read_data($path)['Orientation'] ?? 1)
            : 1;

        return match ($orientation) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => $image,
        };
    }

    /**
     * Crop to a "w:h" ratio, keeping the focal point (fractions of width and height) as central as possible.
     *
     * @param  array{0: float, 1: float}  $focus
     */
    private function cropToRatio(GdImage $image, ?string $ratio, array $focus): GdImage
    {
        if ($ratio === null) {
            return $image;
        }

        [$ratioWidth, $ratioHeight] = array_map('floatval', explode(':', $ratio));
        $width = imagesx($image);
        $height = imagesy($image);
        $target = $ratioWidth / $ratioHeight;

        if ($width / $height > $target) {
            $cropWidth = (int) round($height * $target);
            $cropHeight = $height;
        } else {
            $cropWidth = $width;
            $cropHeight = (int) round($width / $target);
        }

        $x = (int) max(0, min($width - $cropWidth, round($focus[0] * $width - $cropWidth / 2)));
        $y = (int) max(0, min($height - $cropHeight, round($focus[1] * $height - $cropHeight / 2)));

        return imagecrop($image, ['x' => $x, 'y' => $y, 'width' => $cropWidth, 'height' => $cropHeight]);
    }

    private function resize(GdImage $image, int $width): GdImage
    {
        $height = (int) round(imagesy($image) * $width / imagesx($image));
        $resized = imagecreatetruecolor($width, $height);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));

        return $resized;
    }

    /**
     * JPEG has no alpha: transparent areas (logos, cut-out portraits) are laid on the site's cream surface.
     */
    private function flattened(GdImage $image): GdImage
    {
        $flat = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagefill($flat, 0, 0, imagecolorallocate($flat, 0xFB, 0xF7, 0xEE));
        imagealphablending($flat, true);
        imagecopy($flat, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imageinterlace($flat, true);

        return $flat;
    }

    /**
     * @param  array{path: string}  $source
     * @param  array{w: int, h: int, widths: list<int>}  $entry
     */
    private function outputsAreFresh(string $key, array $source, array $entry, string $outputPath): bool
    {
        $sourceTime = File::lastModified($source['path']);

        foreach ($entry['widths'] as $width) {
            $file = "{$outputPath}/{$key}-{$width}.jpg";

            if (! File::exists($file) || File::lastModified($file) < $sourceTime) {
                return false;
            }
        }

        return true;
    }
}
