<?php

use App\Support\Localization\RouteSlugs;

if (! function_exists('localized_slug')) {
    /**
     * The URL slug for a route key in the locale whose routes are being registered.
     */
    function localized_slug(string $key): string
    {
        return RouteSlugs::slug($key);
    }
}

if (! function_exists('localized_route')) {
    /**
     * The URL of a localized named route, in the current locale unless another is given.
     *
     * @param  array<string, mixed>  $parameters
     */
    function localized_route(string $name, array $parameters = [], ?string $locale = null, bool $absolute = true): string
    {
        return route(($locale ?? app()->getLocale()).'.'.$name, $parameters, $absolute);
    }
}
