<?php

namespace Tests\Feature\Support\Localization;

use App\Support\Localization\LocaleFormatter;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LocaleFormatterTest extends TestCase
{
    #[DataProvider('numbers')]
    public function test_formats_numbers_with_each_locales_digits_and_grouping(string $locale, int $value, string $expected): void
    {
        $this->assertSame($expected, app(LocaleFormatter::class)->number($value, $locale));
    }

    /**
     * @return array<string, array{string, int, string}>
     */
    public static function numbers(): array
    {
        return [
            'en millions' => ['en', 1234567, '1,234,567'],
            'en thousands' => ['en', 4000, '4,000'],
            'pt_BR millions' => ['pt_BR', 1234567, '1.234.567'],
            'pt_BR thousands' => ['pt_BR', 4000, '4.000'],
            'bn lakh grouping' => ['bn', 1234567, '১২,৩৪,৫৬৭'],
            'bn thousands' => ['bn', 4000, '৪,০০০'],
        ];
    }

    #[DataProvider('singleDates')]
    public function test_formats_a_single_date(string $locale, string $expected): void
    {
        $this->assertSame($expected, app(LocaleFormatter::class)->date(CarbonImmutable::parse('2027-03-22'), $locale));
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function singleDates(): array
    {
        return [
            'en' => ['en', '22 March 2027'],
            'pt_BR' => ['pt_BR', '22 de março de 2027'],
            'bn' => ['bn', '২২ মার্চ ২০২৭'],
        ];
    }

    #[DataProvider('dateRanges')]
    public function test_formats_date_ranges(string $locale, string $start, string $end, string $expected): void
    {
        $formatted = app(LocaleFormatter::class)->dateRange(CarbonImmutable::parse($start), CarbonImmutable::parse($end), $locale);

        $this->assertSame($expected, $formatted);
    }

    /**
     * @return array<string, array{string, string, string, string}>
     */
    public static function dateRanges(): array
    {
        return [
            'en same month' => ['en', '2027-03-22', '2027-03-25', '22–25 March 2027'],
            'pt_BR same month' => ['pt_BR', '2027-03-22', '2027-03-25', '22 a 25 de março de 2027'],
            'bn same month' => ['bn', '2027-03-22', '2027-03-25', '২২–২৫ মার্চ ২০২৭'],
            'en same year' => ['en', '2027-03-29', '2027-04-02', '29 March – 2 April 2027'],
            'pt_BR same year' => ['pt_BR', '2027-03-29', '2027-04-02', '29 de março a 2 de abril de 2027'],
            'bn same year' => ['bn', '2027-03-29', '2027-04-02', '২৯ মার্চ – ২ এপ্রিল ২০২৭'],
            'en different years' => ['en', '2026-12-30', '2027-01-02', '30 December 2026 – 2 January 2027'],
            'pt_BR different years' => ['pt_BR', '2026-12-30', '2027-01-02', '30 de dezembro de 2026 a 2 de janeiro de 2027'],
            'bn different years' => ['bn', '2026-12-30', '2027-01-02', '৩০ ডিসেম্বর ২০২৬ – ২ জানুয়ারী ২০২৭'],
            'en single day' => ['en', '2027-03-22', '2027-03-22', '22 March 2027'],
        ];
    }

    public function test_uses_the_current_locale_when_none_is_given(): void
    {
        app()->setLocale('bn');

        $this->assertSame('১০', app(LocaleFormatter::class)->number(10));
    }
}
