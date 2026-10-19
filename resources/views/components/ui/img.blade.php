@props([
    'key',
    'alt',
    'sizes' => '100vw',
    'eager' => false,
])

@php
    $entry = app(\App\Support\Images\ImageManifest::class)->get($key);

    if ($entry === null) {
        \Illuminate\Support\Facades\Log::warning("Image [{$key}] is not in public/img/manifest.json; run `php artisan expo:images`.");
    }

    $srcset = fn (string $format): string => collect($entry['widths'] ?? [])
        ->map(fn (int $width): string => asset("img/{$key}-{$width}.{$format}")." {$width}w")
        ->implode(', ');
@endphp

@if ($entry !== null)
    <picture>
        <source type="image/avif" srcset="{{ $srcset('avif') }}" sizes="{{ $sizes }}">
        <source type="image/webp" srcset="{{ $srcset('webp') }}" sizes="{{ $sizes }}">
        <img
            src="{{ asset("img/{$key}-".collect($entry['widths'])->last().'.jpg') }}"
            srcset="{{ $srcset('jpg') }}"
            sizes="{{ $sizes }}"
            width="{{ $entry['w'] }}"
            height="{{ $entry['h'] }}"
            alt="{{ $alt }}"
            loading="{{ $eager ? 'eager' : 'lazy' }}"
            decoding="{{ $eager ? 'sync' : 'async' }}"
            @if ($eager) fetchpriority="high" @endif
            {{ $attributes }}
        >
    </picture>
@endif
