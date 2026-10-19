<?php

namespace App\Support\Localization;

/**
 * A record whose URL slug differs by language, so alternate-language links can point at each language's slug.
 */
interface HasLocalizedSlug
{
    /**
     * The record's URL slug in a locale (a config/locales.php key such as "pt_BR").
     */
    public function localizedSlug(string $locale): string;
}
