<?php

namespace App\Support\Images;

use Illuminate\Support\Facades\File;

/**
 * The responsive-image manifest written by `expo:images`: for each image key, its full size and the widths
 * that exist on disk as public/img/{key}-{width}.{avif,webp,jpg}.
 */
class ImageManifest
{
    /**
     * @param  array<string, array{w: int, h: int, widths: list<int>}>  $entries
     */
    public function __construct(private array $entries) {}

    public static function fromFile(string $path): self
    {
        if (! File::exists($path)) {
            return new self([]);
        }

        return new self(json_decode(File::get($path), true) ?? []);
    }

    /**
     * @return array{w: int, h: int, widths: list<int>}|null
     */
    public function get(string $key): ?array
    {
        return $this->entries[$key] ?? null;
    }

    /**
     * The absolute URL of an image's largest rendition up to the preferred width, e.g. for Open Graph cards.
     */
    public function url(string $key, int $preferredWidth = 1200, string $format = 'jpg'): ?string
    {
        $entry = $this->get($key);

        if ($entry === null) {
            return null;
        }

        $fitting = array_filter($entry['widths'], fn (int $width): bool => $width <= $preferredWidth);
        $width = $fitting === [] ? min($entry['widths']) : max($fitting);

        return asset("img/{$key}-{$width}.{$format}");
    }

    /**
     * @return array<string, array{w: int, h: int, widths: list<int>}>
     */
    public function all(): array
    {
        return $this->entries;
    }
}
