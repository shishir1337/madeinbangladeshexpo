<?php

namespace App\Support\Localization;

use InvalidArgumentException;

class Locales
{
    /**
     * @var array<string, Locale>
     */
    private array $locales = [];

    /**
     * @param  array<string, array<string, mixed>>  $supported
     */
    public function __construct(array $supported, private string $defaultKey)
    {
        foreach ($supported as $key => $config) {
            $this->locales[$key] = Locale::fromConfig($key, $config);
        }

        if (! $this->has($defaultKey)) {
            throw new InvalidArgumentException("The default locale [{$defaultKey}] is not a supported locale.");
        }
    }

    /**
     * Every supported locale, keyed by locale key, in config order.
     *
     * @return array<string, Locale>
     */
    public function all(): array
    {
        return $this->locales;
    }

    public function get(string $key): Locale
    {
        if (! $this->has($key)) {
            throw new InvalidArgumentException("Unsupported locale [{$key}].");
        }

        return $this->locales[$key];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->locales);
    }

    public function default(): Locale
    {
        return $this->locales[$this->defaultKey];
    }

    /**
     * The locale the application is currently running in, or the default when it is not a supported one.
     */
    public function current(): Locale
    {
        return $this->locales[app()->getLocale()] ?? $this->default();
    }

    public function fromPrefix(string $prefix): ?Locale
    {
        foreach ($this->locales as $locale) {
            if ($locale->prefix === $prefix) {
                return $locale;
            }
        }

        return null;
    }
}
