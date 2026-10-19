<?php

namespace App\Support\Localization;

use Closure;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class RouteSlugs
{
    /**
     * The locale whose routes are being registered, while Route::localized() runs.
     */
    private static ?string $registeringLocale = null;

    /**
     * Run the route definitions with slugs resolved for the given locale.
     */
    public static function registerFor(string $localeKey, Closure $routes): void
    {
        $previous = self::$registeringLocale;
        self::$registeringLocale = $localeKey;

        try {
            $routes();
        } finally {
            self::$registeringLocale = $previous;
        }
    }

    /**
     * Resolve a URL slug from lang/{locale}/routes.php for the locale being registered.
     *
     * Falls back to the default locale's slug, then to the key itself; it never throws.
     */
    public static function slug(string $key): string
    {
        $locales = app(Locales::class);
        $localeKey = self::$registeringLocale ?? app()->getLocale();
        $translatesSlugs = $locales->has($localeKey) && $locales->get($localeKey)->translatesSlugs;
        $line = "routes.{$key}";

        if ($translatesSlugs && Lang::hasForLocale($line, $localeKey)) {
            return Lang::get($line, [], $localeKey);
        }

        $defaultKey = $locales->default()->key;

        if (Lang::hasForLocale($line, $defaultKey)) {
            if ($translatesSlugs) {
                Log::warning("Missing [{$localeKey}] route slug [{$key}]; using the [{$defaultKey}] slug.");
            }

            return Lang::get($line, [], $defaultKey);
        }

        return $key;
    }
}
