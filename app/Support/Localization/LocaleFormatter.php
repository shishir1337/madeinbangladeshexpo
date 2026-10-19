<?php

namespace App\Support\Localization;

use Carbon\CarbonInterface;
use IntlDateFormatter;
use NumberFormatter;

class LocaleFormatter
{
    public function __construct(private Locales $locales) {}

    /**
     * Format a number with the locale's digits and grouping (Bangla uses lakh grouping and Bangla numerals).
     */
    public function number(int|float $value, ?string $locale = null): string
    {
        $formatter = new NumberFormatter($this->resolve($locale)->icu, NumberFormatter::DECIMAL);

        return $formatter->format($value);
    }

    /**
     * Format a calendar date with the locale's long date pattern, e.g. "22 de março de 2027".
     */
    public function date(CarbonInterface $date, ?string $locale = null): string
    {
        $resolved = $this->resolve($locale);

        return $this->formatPattern($date, $resolved->icu, $resolved->datePattern);
    }

    /**
     * Format an inclusive date range, collapsing the shared month and year, e.g. "22–25 March 2027".
     */
    public function dateRange(CarbonInterface $start, CarbonInterface $end, ?string $locale = null): string
    {
        $resolved = $this->resolve($locale);

        if ($start->isSameDay($end)) {
            return $this->date($start, $resolved->key);
        }

        if (! $start->isSameYear($end)) {
            return strtr($resolved->rangeTemplates['different_years'], [
                ':date1' => $this->date($start, $resolved->key),
                ':date2' => $this->date($end, $resolved->key),
            ]);
        }

        $parts = [
            ':d1' => $this->formatPattern($start, $resolved->icu, 'd'),
            ':d2' => $this->formatPattern($end, $resolved->icu, 'd'),
            ':year' => $this->formatPattern($start, $resolved->icu, 'yyyy'),
        ];

        if ($start->isSameMonth($end)) {
            return strtr($resolved->rangeTemplates['same_month'], $parts + [
                ':month' => $this->formatPattern($start, $resolved->icu, 'MMMM'),
            ]);
        }

        return strtr($resolved->rangeTemplates['same_year'], $parts + [
            ':month1' => $this->formatPattern($start, $resolved->icu, 'MMMM'),
            ':month2' => $this->formatPattern($end, $resolved->icu, 'MMMM'),
        ]);
    }

    private function resolve(?string $locale): Locale
    {
        return $locale === null ? $this->locales->current() : $this->locales->get($locale);
    }

    private function formatPattern(CarbonInterface $date, string $icu, string $pattern): string
    {
        $formatter = new IntlDateFormatter(
            $icu,
            IntlDateFormatter::NONE,
            IntlDateFormatter::NONE,
            $date->getTimezone(),
            IntlDateFormatter::GREGORIAN,
            $pattern,
        );

        return $formatter->format($date);
    }
}
