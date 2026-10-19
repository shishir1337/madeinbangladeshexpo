<?php

namespace App\Support\Icons;

/**
 * The icons one page uses, each defined once as a <symbol> before </body>; every icon on the page is then a short
 * <use> reference instead of a copy of its paths. Off unless the page middleware turns it on, so icons rendered
 * anywhere else (Livewire updates, mail, Blade::render) stay inline. Bound as scoped (one per request).
 */
class IconSprite
{
    private bool $enabled = false;

    /**
     * @var array<string, true>
     */
    private array $used = [];

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Records an icon for the sprite; false when icons must be rendered inline.
     */
    public function reference(string $name): bool
    {
        if (! $this->enabled || ! IconSet::has($name)) {
            return false;
        }

        $this->used[$name] = true;

        return true;
    }

    public function render(): string
    {
        if ($this->used === []) {
            return '';
        }

        $symbols = collect(array_keys($this->used))->map(function (string $name): string {
            $paint = IconSet::isFilled($name)
                ? 'fill="currentColor"'
                : 'fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"';

            return '<symbol id="i-'.$name.'" viewBox="0 0 24 24" '.$paint.'>'.IconSet::body($name).'</symbol>';
        })->implode('');

        return '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" style="position:absolute;width:0;height:0;overflow:hidden">'.$symbols.'</svg>';
    }
}
