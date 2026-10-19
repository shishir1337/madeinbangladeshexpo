<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | The locale served at the site root, without a URL prefix. It is also the
    | x-default hreflang alternate and the fallback for missing slugs.
    |
    */

    'default' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Supported Locales
    |--------------------------------------------------------------------------
    |
    | Keys are Laravel locale keys (lang/ directory names), in the order the
    | language switcher shows them. Bangla keeps English slugs, because
    | Bengali-script URLs turn unreadable when they are shared.
    |
    */

    'supported' => [

        'en' => [
            'prefix' => null,
            'hreflang' => 'en',
            'html_lang' => 'en',
            'icu' => 'en_GB',
            'native_name' => 'English',
            'translates_slugs' => false,
            'date_pattern' => 'd MMMM yyyy',
            'range' => [
                'same_month' => ':d1–:d2 :month :year',
                'same_year' => ':d1 :month1 – :d2 :month2 :year',
                'different_years' => ':date1 – :date2',
            ],
        ],

        'pt_BR' => [
            'prefix' => 'pt',
            'hreflang' => 'pt-BR',
            'html_lang' => 'pt-BR',
            'icu' => 'pt_BR',
            'native_name' => 'Português',
            'translates_slugs' => true,
            'date_pattern' => "d 'de' MMMM 'de' yyyy",
            'range' => [
                'same_month' => ':d1 a :d2 de :month de :year',
                'same_year' => ':d1 de :month1 a :d2 de :month2 de :year',
                'different_years' => ':date1 a :date2',
            ],
        ],

        'bn' => [
            'prefix' => 'bn',
            'hreflang' => 'bn',
            'html_lang' => 'bn',
            'icu' => 'bn_BD',
            'native_name' => 'বাংলা',
            'translates_slugs' => false,
            'date_pattern' => 'd MMMM yyyy',
            'range' => [
                'same_month' => ':d1–:d2 :month :year',
                'same_year' => ':d1 :month1 – :d2 :month2 :year',
                'different_years' => ':date1 – :date2',
            ],
        ],

    ],

];
