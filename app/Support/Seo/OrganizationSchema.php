<?php

namespace App\Support\Seo;

use App\Settings\GeneralSettings;
use App\Support\Images\ImageManifest;

/**
 * The organiser as a schema.org Organization, built from the editable settings. The home page puts it in its
 * graph; the organiser page publishes it on its own.
 */
class OrganizationSchema
{
    public function __construct(
        private GeneralSettings $settings,
        private ImageManifest $images,
    ) {}

    /**
     * The stable @id other nodes use to point at the organiser.
     */
    public function id(): string
    {
        return $this->settings->website.'#organization';
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            '@type' => 'Organization',
            '@id' => $this->id(),
            'name' => $this->settings->organiser_name,
            'alternateName' => $this->settings->organiser_short_name,
            'url' => $this->settings->website,
            'logo' => $this->images->url('bbcci-mark', 480),
            'address' => ['@type' => 'PostalAddress', 'streetAddress' => $this->settings->office_address, 'addressCountry' => 'BD'],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'telephone' => $this->settings->phone,
                'email' => $this->settings->email,
                'availableLanguage' => ['en', 'pt', 'bn'],
            ],
        ];
    }
}
