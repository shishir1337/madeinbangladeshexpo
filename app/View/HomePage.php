<?php

namespace App\View;

use App\Enums\PartnerRole;
use App\Models\Edition;
use App\Models\Milestone;
use App\Models\Partner;
use App\Models\Sector;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\Video;
use App\Settings\GeneralSettings;
use App\Support\Editions\CurrentEdition;
use App\Support\Images\ImageManifest;
use App\Support\Localization\LocaleFormatter;
use App\Support\Localization\Locales;
use App\Support\Seo\OrganizationSchema;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

/**
 * Everything the home page shows, in the request's language. Event facts come from the current edition;
 * figures, sectors, milestones, quotes, videos and partners from their content models.
 */
class HomePage
{
    private const OPENING_HOUR = '10:00';

    public function __construct(
        private CurrentEdition $currentEdition,
        private LocaleFormatter $formatter,
    ) {}

    public function edition(): ?Edition
    {
        return $this->currentEdition->get();
    }

    public function title(): string
    {
        return $this->edition()?->name ?: __('site.brand');
    }

    public function dateRange(): ?string
    {
        $edition = $this->edition();

        return $edition === null ? null : $this->formatter->dateRange($edition->starts_on, $edition->ends_on);
    }

    public function venueLine(): ?string
    {
        $venue = $this->edition()?->venue;

        return $venue === null ? null : "{$venue->name}, {$venue->city}";
    }

    /**
     * Number of days the expo runs, counting the first and last day.
     */
    public function durationInDays(): ?int
    {
        $edition = $this->edition();

        return $edition === null ? null : (int) $edition->starts_on->diffInDays($edition->ends_on) + 1;
    }

    /**
     * The opening moment in UTC: the edition's opening time, or 10:00 on the first day in its own time zone.
     */
    public function opening(): ?CarbonImmutable
    {
        $edition = $this->edition();

        if ($edition === null) {
            return null;
        }

        return $edition->opening_at
            ?? CarbonImmutable::parse($edition->starts_on->toDateString().' '.self::OPENING_HOUR, $edition->timezone)->utc();
    }

    /**
     * upcoming before the opening, live until the end of the last day (edition time zone), past after it.
     *
     * @return 'upcoming'|'live'|'past'|null
     */
    public function countdownState(): ?string
    {
        $edition = $this->edition();
        $opening = $this->opening();

        if ($edition === null || $opening === null) {
            return null;
        }

        $now = CarbonImmutable::now();
        $closing = CarbonImmutable::parse($edition->ends_on->toDateString(), $edition->timezone)->endOfDay();

        return match (true) {
            $now->lessThan($opening) => 'upcoming',
            $now->lessThanOrEqualTo($closing) => 'live',
            default => 'past',
        };
    }

    /**
     * The countdown's starting values, rendered by the server so they are right before JS runs.
     *
     * @return array{days: string, hours: string, minutes: string, seconds: string}
     */
    public function countdownParts(): array
    {
        $seconds = max(0, (int) CarbonImmutable::now()->diffInSeconds($this->opening() ?? CarbonImmutable::now(), false));

        return [
            'days' => $this->formatter->plain(intdiv($seconds, 86400)),
            'hours' => $this->twoDigits(intdiv($seconds % 86400, 3600)),
            'minutes' => $this->twoDigits(intdiv($seconds % 3600, 60)),
            'seconds' => $this->twoDigits($seconds % 60),
        ];
    }

    /**
     * A time shown in a time zone, e.g. "10:00" São Paulo or "19:00" Dhaka, in the page's digits.
     */
    public function clock(CarbonImmutable $moment, string $timezone): string
    {
        $local = $moment->setTimezone($timezone);

        return $this->twoDigits($local->hour).':'.$this->twoDigits($local->minute);
    }

    /**
     * Whole hours the second time zone is ahead of the first, right now (9 for São Paulo → Dhaka).
     */
    public function hoursAhead(string $from, string $to): int
    {
        $now = CarbonImmutable::now();

        return intdiv($now->setTimezone($to)->utcOffset() - $now->setTimezone($from)->utcOffset(), 60);
    }

    /**
     * @return Collection<int, Stat>
     */
    public function stats(string $placement = 'home'): Collection
    {
        return Stat::query()->where('placement', $placement)->ordered()->get();
    }

    /**
     * @return Collection<int, Sector>
     */
    public function sectors(): Collection
    {
        return Sector::query()->ordered()->get();
    }

    /**
     * @return Collection<int, Milestone>
     */
    public function milestones(): Collection
    {
        return Milestone::query()->orderBy('happened_on')->get();
    }

    /**
     * @return Collection<int, Testimonial>
     */
    public function testimonials(): Collection
    {
        return Testimonial::query()->ordered()->get();
    }

    /**
     * @return Collection<int, Video>
     */
    public function videos(): Collection
    {
        return Video::query()->ordered()->get();
    }

    /**
     * Partners grouped by role, in role order.
     *
     * @return SupportCollection<string, Collection<int, Partner>>
     */
    public function partnersByRole(): SupportCollection
    {
        $partners = Partner::query()->ordered()->get();

        return collect(PartnerRole::cases())
            ->mapWithKeys(fn (PartnerRole $role): array => [$role->value => $partners->where('role', $role)->values()])
            ->filter(fn (Collection $group): bool => $group->isNotEmpty());
    }

    /**
     * schema.org data for search engines: the organiser always, and the current edition as an ExhibitionEvent.
     *
     * @return array<string, mixed>
     */
    public function structuredData(GeneralSettings $settings): array
    {
        $organisation = app(OrganizationSchema::class);

        $graph = [$organisation->toArray()];
        $edition = $this->edition();

        if ($edition !== null) {
            $venue = $edition->venue;
            $opening = $this->opening()->setTimezone($edition->timezone);

            $graph[] = array_filter([
                '@type' => 'ExhibitionEvent',
                'name' => $this->title(),
                'description' => __('home.meta_description'),
                'startDate' => $opening->format('Y-m-d\TH:i:sP'),
                'endDate' => $edition->ends_on->toDateString(),
                'eventStatus' => 'https://schema.org/EventScheduled',
                'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
                'inLanguage' => app(Locales::class)->current()->hreflang,
                'image' => app(ImageManifest::class)->url('expo25-stand-garments'),
                'url' => url()->current(),
                'organizer' => ['@id' => $organisation->id(), 'name' => $settings->organiser_name, 'url' => $settings->website],
                'location' => $venue === null ? null : [
                    '@type' => 'Place',
                    'name' => $venue->name,
                    'address' => array_filter([
                        '@type' => 'PostalAddress',
                        'streetAddress' => $venue->address_line,
                        'addressLocality' => $venue->city,
                        'addressRegion' => $venue->state,
                        'postalCode' => $venue->postal_code,
                        'addressCountry' => $venue->country_code,
                    ]),
                ],
                'offers' => [
                    '@type' => 'Offer',
                    'name' => __('home.hero.facts.buyers'),
                    'price' => '0',
                    'priceCurrency' => 'BRL',
                    'availability' => 'https://schema.org/InStock',
                    'url' => url()->current(),
                ],
            ]);
        }

        return ['@context' => 'https://schema.org', '@graph' => $graph];
    }

    public function formatter(): LocaleFormatter
    {
        return $this->formatter;
    }

    private function twoDigits(int $value): string
    {
        $digits = $this->formatter->plain($value);

        return $value < 10 ? $this->formatter->plain(0).$digits : $digits;
    }
}
