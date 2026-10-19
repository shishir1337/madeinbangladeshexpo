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
    public function number(int|float $value, ?string $locale = null, ?int $decimals = null): string
    {
        $formatter = new NumberFormatter($this->resolve($locale)->icu, NumberFormatter::DECIMAL);

        if ($decimals !== null) {
            $formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $decimals);
            $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, $decimals);
        }

        return $formatter->format($value);
    }

    /**
     * An integer in the locale's digits without grouping, for years and other identifiers, e.g. "২০২৬".
     */
    public function plain(int $value, ?string $locale = null): string
    {
        $formatter = new NumberFormatter($this->resolve($locale)->icu, NumberFormatter::DECIMAL);
        $formatter->setAttribute(NumberFormatter::GROUPING_USED, 0);

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

    /**
     * Free text such as a source and period ("EPB, FY2025-26") with its ASCII digits in the locale's digits.
     */
    public function digits(string $text, ?string $locale = null): string
    {
        $map = [];

        foreach (range(0, 9) as $digit) {
            $map[(string) $digit] = $this->plain($digit, $locale);
        }

        return strtr($text, $map);
    }

    /**
     * A 24-hour clock time in a time zone, in the locale's digits, e.g. "19:05" or "১৯:০৫".
     */
    public function time(CarbonInterface $moment, string $timezone, ?string $locale = null): string
    {
        return $this->formatPattern($moment->copy()->setTimezone($timezone), $this->resolve($locale)->icu, 'HH:mm');
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
