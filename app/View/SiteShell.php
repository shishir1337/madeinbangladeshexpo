<?php

namespace App\View;

use App\Models\Edition;
use App\Settings\GeneralSettings;
use App\Support\Editions\CurrentEdition;
use App\Support\Localization\LocaleFormatter;
use App\Support\Navigation\SiteNavigation;
use Carbon\CarbonImmutable;

/**
 * What the site shell (announcement, header, drawer, footer, help button) shows on every page, in the
 * request's language. Event facts come from the current edition and settings, never from the views.
 */
class SiteShell
{
    public function __construct(
        private CurrentEdition $currentEdition,
        private LocaleFormatter $formatter,
        public GeneralSettings $settings,
        public SiteNavigation $navigation,
    ) {}

    public function edition(): ?Edition
    {
        return $this->currentEdition->get();
    }

    public function dateRange(): ?string
    {
        $edition = $this->edition();

        return $edition === null ? null : $this->formatter->dateRange($edition->starts_on, $edition->ends_on);
    }

    /**
     * "Venue, City", or null when the edition has no venue yet.
     */
    public function venueLine(): ?string
    {
        $venue = $this->edition()?->venue;

        return $venue === null ? null : "{$venue->name}, {$venue->cityName()}";
    }

    /**
     * Whole days until the opening day in the edition's own time zone; null when there is no edition or it has started.
     */
    public function daysToGo(): ?int
    {
        $edition = $this->edition();

        if ($edition === null) {
            return null;
        }

        $today = CarbonImmutable::now($edition->timezone)->startOfDay();
        $opening = CarbonImmutable::parse($edition->starts_on->toDateString(), $edition->timezone);
        $days = (int) $today->diffInDays($opening, false);

        return $days < 0 ? null : $days;
    }

    public function daysToGoLabel(): ?string
    {
        $days = $this->daysToGo();

        return $days === null ? null : trans_choice('site.days_to_go', $days, ['count' => $this->formatter->number($days)]);
    }

    /**
     * The edition's year label in the locale's digits ("2026", "২০২৬"), when its slug is a year.
     */
    public function editionYear(): ?string
    {
        $slug = $this->edition()?->slug;

        return $slug !== null && ctype_digit($slug) ? $this->formatter->plain((int) $slug) : null;
    }

    public function telUrl(): string
    {
        return 'tel:'.preg_replace('/[^\d+]/', '', $this->settings->phone);
    }

    public function whatsappUrl(): string
    {
        return 'https://wa.me/'.$this->settings->whatsapp_number.'?text='.rawurlencode(__('site.help.whatsapp_message'));
    }

    public function year(): string
    {
        return $this->formatter->plain(now()->year);
    }
}
