<?php

namespace App\View;

use App\Enums\NewsType;
use App\Enums\PartnerRole;
use App\Enums\SessionKind;
use App\Models\Edition;
use App\Models\Milestone;
use App\Models\NewsArticle;
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

    /**
     * Query results already loaded for this request, so partials that share data never query twice.
     *
     * @var array<string, mixed>
     */
    private array $loaded = [];

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

    /**
     * The title split for the hero: the series name, which stays the same every year, then what names this
     * edition (usually its year). An edition named differently keeps its whole name in `series`.
     *
     * @return array{series: string, edition: string}
     */
    public function titleParts(): array
    {
        $title = $this->title();
        $brand = __('site.brand');

        if ($title !== $brand && str_starts_with($title, $brand.' ')) {
            return ['series' => $brand, 'edition' => trim(mb_substr($title, mb_strlen($brand)))];
        }

        return ['series' => $title, 'edition' => ''];
    }

    /**
     * The ten digits in the page's numerals, for the rolling countdown.
     *
     * @return list<string>
     */
    public function digitStrip(): array
    {
        return array_map(fn (int $digit): string => $this->formatter->plain($digit), range(0, 9));
    }

    public function dateRange(): ?string
    {
        $edition = $this->edition();

        return $edition === null ? null : $this->formatter->dateRange($edition->starts_on, $edition->ends_on);
    }

    public function venueLine(): ?string
    {
        $venue = $this->edition()?->venue;

        return $venue === null ? null : "{$venue->name}, {$venue->cityName()}";
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
        $values = $this->countdownValues();

        return [
            'days' => $this->formatter->plain($values['days']),
            'hours' => $this->twoDigits($values['hours']),
            'minutes' => $this->twoDigits($values['minutes']),
            'seconds' => $this->twoDigits($values['seconds']),
        ];
    }

    /**
     * Time left until the opening as whole numbers, never negative.
     *
     * @return array{days: int, hours: int, minutes: int, seconds: int}
     */
    public function countdownValues(): array
    {
        $seconds = max(0, (int) CarbonImmutable::now()->diffInSeconds($this->opening() ?? CarbonImmutable::now(), false));

        return [
            'days' => intdiv($seconds, 86400),
            'hours' => intdiv($seconds % 86400, 3600),
            'minutes' => intdiv($seconds % 3600, 60),
            'seconds' => $seconds % 60,
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
        return $this->once("stats.{$placement}", fn (): Collection => Stat::query()->where('placement', $placement)->ordered()->get());
    }

    /**
     * Each direction's share of two-way trade, in percent, from the two route figures ("281.8 m" and "2.72 bn"
     * become comparable through their English unit suffix). Null when either figure or its unit is missing.
     *
     * @return array{bangladesh: float, brazil: float}|null
     */
    public function tradeBalance(): ?array
    {
        $routes = $this->stats('routes')->keyBy('key');
        $scale = ['bn' => 1e9, 'm' => 1e6, 'k' => 1e3];

        $amount = function (?Stat $stat) use ($scale): ?float {
            $unit = $stat === null ? null : trim((string) $stat->getTranslation('suffix', 'en', false));

            return $stat === null || ! isset($scale[$unit]) ? null : (float) $stat->value * $scale[$unit];
        };

        $bangladesh = $amount($routes->get('bangladesh-to-brazil'));
        $brazil = $amount($routes->get('brazil-to-bangladesh'));

        if ($bangladesh === null || $brazil === null || $bangladesh + $brazil <= 0) {
            return null;
        }

        $share = round($bangladesh / ($bangladesh + $brazil) * 100, 1);

        return ['bangladesh' => $share, 'brazil' => round(100 - $share, 1)];
    }

    /**
     * @return Collection<int, Sector>
     */
    public function sectors(): Collection
    {
        return $this->once('sectors', fn (): Collection => Sector::query()->ordered()->get());
    }

    /**
     * Every edition of the series in order, with what happened at each: exhibitors, B2B afternoons, seminars,
     * ceremonies and photos (all zero for an edition still to come).
     *
     * @return Collection<int, Edition>
     */
    public function editions(): Collection
    {
        return $this->once('editions', fn (): Collection => Edition::query()
            ->with(['venue', 'galleryAlbums'])
            ->withCount([
                'exhibitors',
                'galleryPhotos',
                'programmeSessions as matchmaking_count' => fn ($query) => $query->where('kind', SessionKind::Matchmaking),
                'programmeSessions as seminar_count' => fn ($query) => $query->where('kind', SessionKind::Seminar),
                'programmeSessions as ceremony_count' => fn ($query) => $query->where('kind', SessionKind::Ceremony),
            ])
            ->orderBy('number')
            ->get());
    }

    /**
     * The latest edition that has taken place, which the programme and highlights look back on.
     */
    public function lastPastEdition(): ?Edition
    {
        return $this->editions()->filter(fn (Edition $edition): bool => $edition->isPast())->last();
    }

    /**
     * @return Collection<int, Milestone>
     */
    public function milestones(): Collection
    {
        return $this->once('milestones', fn (): Collection => Milestone::query()->orderBy('happened_on')->get());
    }

    /**
     * @return Collection<int, Testimonial>
     */
    public function testimonials(): Collection
    {
        return $this->once('testimonials', fn (): Collection => Testimonial::query()->ordered()->get());
    }

    /**
     * @return Collection<int, Video>
     */
    public function videos(): Collection
    {
        return $this->once('videos', fn (): Collection => Video::query()->ordered()->get());
    }

    /**
     * The video the hero plays: the one marked as featured, else the first.
     */
    public function featuredVideo(): ?Video
    {
        return $this->videos()->firstWhere('is_featured', true) ?? $this->videos()->first();
    }

    /**
     * The latest media reports about the expo, newest first; each links out to its publisher.
     *
     * @return Collection<int, NewsArticle>
     */
    public function coverage(int $limit = 6): Collection
    {
        return $this->once('coverage', fn (): Collection => NewsArticle::query()
            ->where('type', NewsType::Coverage)
            ->latest('published_at')
            ->limit($limit)
            ->get());
    }

    /**
     * Partners grouped by role, in role order.
     *
     * @return SupportCollection<string, Collection<int, Partner>>
     */
    public function partnersByRole(): SupportCollection
    {
        $partners = $this->once('partners', fn (): Collection => Partner::query()->with('edition')->ordered()->get());

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

    /**
     * @template T
     *
     * @param  callable(): T  $load
     * @return T
     */
    private function once(string $key, callable $load): mixed
    {
        return $this->loaded[$key] ??= $load();
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
