<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Demo Mode
    |--------------------------------------------------------------------------
    |
    | On the pitch staging site: every page is marked noindex and shows a
    | "Demonstration site" ribbon, so no one mistakes it for the real portal.
    |
    */

    'demo_mode' => (bool) env('DEMO_MODE', false),

    /*
    |--------------------------------------------------------------------------
    | Consent Versions
    |--------------------------------------------------------------------------
    |
    | Each consent text is versioned; the version a person agreed to is stored
    | with their consent, so a later change of wording never rewrites history.
    |
    */

    'consent' => [
        'newsletter_version' => '2026.1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limits
    |--------------------------------------------------------------------------
    */

    'rate_limits' => [
        'newsletter_per_minute' => 5,
    ],

];
