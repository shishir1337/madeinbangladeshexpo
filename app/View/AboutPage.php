<?php

namespace App\View;

use App\Models\Edition;
use App\Models\Stat;
use App\Support\Editions\CurrentEdition;
use App\Support\Localization\LocaleFormatter;
use Illuminate\Database\Eloquent\Collection;

/**
 * The About page: what the expo is, the current edition's facts from the database, and how it compares with
 * the edition before it.
 */
class AboutPage
{
    /**
     * Sourced figures shown under "Why São Paulo".
     */
    private const SAO_PAULO_STATS = ['brazil-consumers', 'sao-paulo-population'];

    private ?Edition $previous = null;

    private bool $previousLoaded = false;

    public function __construct(
        private CurrentEdition $currentEdition,
        private LocaleFormatter $formatter,
    ) {}

    public function edition(): ?Edition
    {
        return $this->currentEdition->get();
    }

    /**
     * The edition held before the current one, if any.
     */
    public function previous(): ?Edition
    {
        if (! $this->previousLoaded) {
            $edition = $this->edition();

            $this->previous = $edition === null ? null : Edition::query()
                ->with('venue')
                ->where('number', '<', $edition->number)
                ->orderByDesc('number')
                ->first();

            $this->previousLoaded = true;
        }

        return $this->previous;
    }

    /**
     * Key facts for the hero, all read from the current edition.
     *
     * @return list<array{icon: string, label: string, value: string}>
     */
    public function facts(): array
    {
        $edition = $this->edition();

        if ($edition === null) {
            return [];
        }

        return array_values(array_filter([
            ['icon' => 'award', 'label' => __('pages/about.facts.edition'), 'value' => $this->ordinal($edition)],
            ['icon' => 'calendar', 'label' => __('pages/about.facts.dates'), 'value' => $this->dateRange($edition)],
            $edition->venue === null ? null : ['icon' => 'map-pin', 'label' => __('pages/about.facts.venue'), 'value' => "{$edition->venue->name}, {$edition->venue->cityName()}"],
            ['icon' => 'clock', 'label' => __('pages/about.facts.duration'), 'value' => $this->duration($edition)],
        ]));
    }

    /**
     * Rows comparing the previous edition with the current one (the table's column headers name each edition).
     *
     * @return list<array{label: string, previous: string, current: string}>
     */
    public function comparison(): array
    {
        $edition = $this->edition();
        $previous = $this->previous();

        if ($edition === null || $previous === null) {
            return [];
        }

        $venue = fn (Edition $edition): string => $edition->venue === null ? '—' : "{$edition->venue->name}, {$edition->venue->cityName()}";

        return [
            ['label' => __('pages/about.facts.dates'), 'previous' => $this->dateRange($previous), 'current' => $this->dateRange($edition)],
            ['label' => __('pages/about.facts.venue'), 'previous' => $venue($previous), 'current' => $venue($edition)],
            ['label' => __('pages/about.facts.duration'), 'previous' => $this->duration($previous), 'current' => $this->duration($edition)],
        ];
    }

    /**
     * @return Collection<int, Stat>
     */
    public function stats(): Collection
    {
        return Stat::query()->whereIn('key', self::SAO_PAULO_STATS)->ordered()->get();
    }

    public function dateRange(Edition $edition): string
    {
        return $this->formatter->dateRange($edition->starts_on, $edition->ends_on);
    }

    /**
     * "First edition", "Second edition"…, as the home hero words it.
     */
    public function ordinal(Edition $edition): string
    {
        $ordinals = __('home.hero.edition');

        return $ordinals[$edition->number] ?? str_replace(':number', $this->formatter->plain($edition->number), $ordinals['n']);
    }

    /**
     * Number of days, counting the first and the last, e.g. "4 days".
     */
    public function duration(Edition $edition): string
    {
        $days = (int) $edition->starts_on->diffInDays($edition->ends_on) + 1;

        return trans_choice('pages/about.facts.days', $days, ['count' => $this->formatter->plain($days)]);
    }
}
