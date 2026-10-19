<?php

namespace App\Models\Concerns;

use App\Support\Localization\Locales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Route binding by a translatable `slug`: URLs use the slug of the request's language, and a slug from
 * another language answers with a permanent redirect to the right one instead of a 404.
 *
 * Needs the locale set before bindings are substituted (SetLocale is prioritised in bootstrap/app.php).
 */
trait ResolvesByLocalizedSlug
{
    public function localizedSlug(string $locale): string
    {
        return $this->getTranslation('slug', $locale);
    }

    public function getRouteKey(): string
    {
        return $this->localizedSlug(app()->getLocale());
    }

    /**
     * @param  mixed  $value
     * @param  string|null  $field
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        if ($field !== null) {
            return parent::resolveRouteBinding($value, $field);
        }

        $locales = app(Locales::class);
        $current = $locales->current()->key;

        if ($match = $this->newQuery()->where("slug->{$current}", $value)->first()) {
            return $match;
        }

        foreach ($locales->all() as $locale) {
            if ($locale->key === $current) {
                continue;
            }

            if ($match = $this->newQuery()->where("slug->{$locale->key}", $value)->first()) {
                throw new HttpResponseException(redirect()->to($this->urlWithSlug($value, $match->localizedSlug($current)), 301));
            }
        }

        return null;
    }

    /**
     * The current route's URL with one slug parameter swapped, keeping the query string.
     */
    private function urlWithSlug(string $wrongSlug, string $rightSlug): string
    {
        $route = request()->route();
        $parameters = array_map(fn (mixed $parameter): mixed => $parameter === $wrongSlug ? $rightSlug : $parameter, $route->parameters());
        $query = request()->getQueryString();

        return route($route->getName(), $parameters).($query ? "?{$query}" : '');
    }
}
