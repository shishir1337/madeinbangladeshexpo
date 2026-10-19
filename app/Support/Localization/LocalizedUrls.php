<?php

namespace App\Support\Localization;

use Illuminate\Support\Facades\Route;

class LocalizedUrls
{
    public function __construct(private Locales $locales) {}

    /**
     * Absolute URLs of the current page in every locale, keyed by hreflang, plus x-default.
     *
     * @return array<string, string>
     */
    public function alternates(): array
    {
        $alternates = [];

        foreach ($this->urlsByLocale() as $localeKey => $url) {
            $alternates[$this->locales->get($localeKey)->hreflang] = $url;
        }

        $defaultUrl = $this->urlsByLocale()[$this->locales->default()->key] ?? null;

        if ($defaultUrl !== null) {
            $alternates['x-default'] = $defaultUrl;
        }

        return $alternates;
    }

    /**
     * The language switcher's links to the current page, in config order.
     *
     * @return list<array{locale: Locale, url: string, isCurrent: bool}>
     */
    public function switcher(): array
    {
        $currentKey = $this->locales->current()->key;
        $links = [];

        foreach ($this->urlsByLocale() as $localeKey => $url) {
            $links[] = [
                'locale' => $this->locales->get($localeKey),
                'url' => $url,
                'isCurrent' => $localeKey === $currentKey,
            ];
        }

        return $links;
    }

    /**
     * The current page's URL in each locale it is registered for, or none when it is not localized.
     *
     * @return array<string, string>
     */
    private function urlsByLocale(): array
    {
        $route = request()->route();
        $baseName = $this->baseName($route?->getName());

        if ($baseName === null) {
            return [];
        }

        $urls = [];

        foreach ($this->locales->all() as $locale) {
            if (Route::has("{$locale->key}.{$baseName}")) {
                $urls[$locale->key] = localized_route($baseName, $route->parameters(), $locale->key);
            }
        }

        return $urls;
    }

    /**
     * Strip the "{locale}." prefix from a localized route name.
     */
    private function baseName(?string $routeName): ?string
    {
        if ($routeName === null) {
            return null;
        }

        foreach ($this->locales->all() as $locale) {
            if (str_starts_with($routeName, "{$locale->key}.")) {
                return substr($routeName, strlen($locale->key) + 1);
            }
        }

        return null;
    }
}
