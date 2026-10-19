<?php

$source = fn (string $path): string => base_path('research-assets/bbcci/images/'.$path);

return [

    /*
    |--------------------------------------------------------------------------
    | Responsive Image Pipeline
    |--------------------------------------------------------------------------
    |
    | `php artisan expo:images` turns each source into public/img/{key}-{width}.{avif,webp,jpg} and records
    | them in public/img/manifest.json, which <x-ui.img key="…"> reads. Sources come from BBCCI's own
    | photography in research-assets/ (git-ignored); the generated files are committed.
    |
    | Per source: `crop` [x, y, w, h] fractions, `ratio` "w:h" with an optional `focus` [x, y], and `max`
    | width. Only full-bleed heroes go up to 2400 px.
    |
    */

    'output_path' => public_path('img'),

    'widths' => [480, 800, 1200, 1600, 2400],

    'sources' => [

        // Made in Bangladesh Expo 2025, São Paulo (15–18 June 2025)
        'expo25-welcome' => ['path' => $source('expo-2025/2025-07_DSC07487.jpg'), 'max' => 2400],
        'expo25-welcome-2' => ['path' => $source('expo-2025/2025-07_DSC07496.jpg'), 'max' => 1600],
        'expo25-delegation' => ['path' => $source('expo-2025/2025-07_DSC07729-1.jpg'), 'max' => 2400],
        'expo25-guests' => ['path' => $source('expo-2025/2025-07_DSC07730.jpg'), 'max' => 1600],
        'expo25-stand-garments' => ['path' => $source('expo-2025/2025-07_DSC08166.jpg'), 'max' => 2400],
        'expo25-stand-sts' => ['path' => $source('expo-2025/2025-07_DSC08161.jpg'), 'max' => 1600],
        'expo25-stand-accessories' => ['path' => $source('expo-2025/2025-07_DSC08174.jpg'), 'max' => 2400],
        'expo25-speaker-regina-nunes' => ['path' => $source('expo-2025/2025-07_DSC08138.jpg'), 'max' => 1600],
        'expo25-speaker-shahriar-ahmed' => ['path' => $source('expo-2025/2025-07_DSC07671.jpg'), 'max' => 1600],
        'expo25-speaker-joynal-abdin' => ['path' => $source('expo-2025/2025-07_DSC07660.jpg'), 'max' => 1600],
        'expo25-speaker-saiful-alam' => ['path' => $source('expo-2025/2025-07_DSC07928.jpg'), 'max' => 1600],
        'expo25-speaker-taufiqul-islam' => ['path' => $source('expo-2025/2025-07_DSC07697.jpg'), 'max' => 1600],
        'expo25-trade-mission' => ['path' => $source('events/2025-07_1-34.jpg'), 'max' => 1600],

        // Press conferences in Dhaka
        'press-2025-05' => ['path' => $source('expo-2025/2025-05_RTN_8401.jpg'), 'max' => 1600],
        'press-2025-12' => ['path' => $source('expo-2025/2025-12_RTN_8412.jpg'), 'max' => 1600],
        'press-2026-05' => ['path' => $source('expo-2025/2026-05_1-46.jpg'), 'max' => 1600],

        // Brazil–Bangladesh events, Dhaka 2024
        'forum-2024-panel' => ['path' => $source('events/2024-03_S-2.jpg'), 'max' => 1600],
        'forum-2024-speech' => ['path' => $source('events/2024-03_S-1.jpg'), 'max' => 1600],
        'forum-2024-audience' => ['path' => $source('events/2024-03_S-6.jpg'), 'max' => 1600],
        'fbcci-2024-meeting' => ['path' => $source('events/2024-04_IMG_8305.jpg'), 'max' => 1600],
        'fbcci-2024-podium' => ['path' => $source('events/2024-04_IMG_8646.jpg'), 'max' => 1600],
        'fbcci-2024-fm-selfie' => ['path' => $source('events/2024-04_IMG_8563.jpg'), 'max' => 1600],
        'fbcci-2024-group' => ['path' => $source('events/2024-04_IMG_8695.jpg'), 'max' => 1600],
        'fbcci-2024-leaders' => ['path' => $source('events/2024-04_IMG_8737.jpg'), 'max' => 1600],
        'bbcci-bgmea-2024' => ['path' => $source('events/2024-05_Image-2.jpg'), 'max' => 2400],

        // São Paulo (stock: Kaique Rocha / Pexels)
        'sao-paulo-skyline' => ['path' => $source('misc/2024-03_pexels-kaique-rocha-97906.jpg'), 'max' => 2400],

        // BBCCI leadership portraits and logo mark
        'leader-shahriar-ahmed' => ['path' => $source('people/shahriar-ahmed-president.png'), 'max' => 480],
        'leader-saiful-alam' => ['path' => $source('people/md-saiful-alam-vice-president.png'), 'max' => 480],
        'leader-joynal-abdin' => ['path' => $source('people/md-joynal-abdin-secretary-general.png'), 'max' => 480],
        'bbcci-mark' => ['path' => $source('logo/2024-04_BBCCI-Logo.jpg'), 'crop' => [0.146, 0.106, 0.704, 0.668], 'max' => 480],
        'bbcci-logo' => ['path' => $source('logo/2024-04_BBCCI-Logo.jpg'), 'max' => 800],

    ],

];
