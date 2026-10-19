<?php

namespace App\Support\Localization;

final readonly class Locale
{
    /**
     * @param  array{same_month: string, same_year: string, different_years: string}  $rangeTemplates
     */
    public function __construct(
        public string $key,
        public ?string $prefix,
        public string $hreflang,
        public string $htmlLang,
        public string $icu,
        public string $nativeName,
        public bool $translatesSlugs,
        public string $datePattern,
        public array $rangeTemplates,
        public string $shortName = '',
    ) {}

    /**
     * Build a locale from its entry in config/locales.php.
     *
     * @param  array{prefix: ?string, hreflang: string, html_lang: string, icu: string, native_name: string, short_name?: string, translates_slugs: bool, date_pattern: string, range: array{same_month: string, same_year: string, different_years: string}}  $config
     */
    public static function fromConfig(string $key, array $config): self
    {
        return new self(
            key: $key,
            prefix: $config['prefix'],
            hreflang: $config['hreflang'],
            htmlLang: $config['html_lang'],
            icu: $config['icu'],
            nativeName: $config['native_name'],
            shortName: $config['short_name'] ?? strtoupper($key),
            translatesSlugs: $config['translates_slugs'],
            datePattern: $config['date_pattern'],
            rangeTemplates: $config['range'],
        );
    }
}
