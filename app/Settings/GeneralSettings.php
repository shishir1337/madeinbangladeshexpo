<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

/**
 * The organiser's identity and contact details, editable without a deploy.
 */
class GeneralSettings extends Settings
{
    public string $organiser_name;

    public string $organiser_short_name;

    public string $office_address;

    /**
     * Phone number as shown to people, e.g. "+880 1553 676767".
     */
    public string $phone;

    /**
     * Digits only, for wa.me links, e.g. "8801553676767".
     */
    public string $whatsapp_number;

    public string $email;

    /**
     * The organiser's own website (the chamber), as opposed to this expo site.
     */
    public string $website;

    /**
     * Data protection officer (LGPD "encarregado"); not yet named by BBCCI.
     */
    public ?string $dpo_name;

    public ?string $dpo_email;

    public static function group(): string
    {
        return 'general';
    }
}
