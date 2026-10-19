<?php

namespace Tests\Feature\Models;

use App\Models\Milestone;
use App\Models\Partner;
use App\Models\Sector;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\Video;
use Database\Seeders\EditionSeeder;
use Database\Seeders\HomeContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_content_seeder_is_idempotent(): void
    {
        $this->seed(EditionSeeder::class);
        $this->seed(HomeContentSeeder::class);
        $this->seed(HomeContentSeeder::class);

        $this->assertSame(9, Sector::count());
        $this->assertGreaterThanOrEqual(6, Stat::count());
        $this->assertGreaterThanOrEqual(8, Milestone::count());
        $this->assertGreaterThanOrEqual(4, Testimonial::count());
        $this->assertGreaterThanOrEqual(4, Video::count());
        $this->assertGreaterThanOrEqual(2, Partner::count());
    }

    public function test_sector_slugs_are_translated_for_portuguese_only(): void
    {
        $this->seed(HomeContentSeeder::class);

        $garments = Sector::query()->where('icon', 'shirt')->firstOrFail();

        $this->assertSame('vestuario', $garments->localizedSlug('pt_BR'));
        $this->assertSame('garments', $garments->localizedSlug('bn'));
        $this->assertSame('garments', $garments->localizedSlug('en'));
    }

    public function test_stats_carry_a_source_and_date(): void
    {
        $this->seed(HomeContentSeeder::class);

        Stat::all()->each(function (Stat $stat): void {
            $this->assertNotSame('', trim($stat->source), "Stat [{$stat->key}] has no source.");
            $this->assertNotSame('', trim($stat->as_of), "Stat [{$stat->key}] has no date.");
        });
    }

    public function test_every_seeded_record_is_written_in_all_three_languages(): void
    {
        $this->seed(EditionSeeder::class);
        $this->seed(HomeContentSeeder::class);

        $translatable = [
            Stat::class => ['label'],
            Milestone::class => ['title', 'body'],
            Sector::class => ['name', 'summary', 'figure_label'],
            Testimonial::class => ['quote', 'role'],
            Video::class => ['title'],
        ];

        foreach ($translatable as $model => $fields) {
            $model::all()->each(function ($record) use ($fields): void {
                foreach ($fields as $field) {
                    foreach (['en', 'pt_BR', 'bn'] as $locale) {
                        $this->assertNotSame('', $record->getTranslation($field, $locale, false), class_basename($record)." #{$record->id} has no [{$locale}] {$field}.");
                    }
                }
            });
        }
    }

    public function test_records_fall_back_to_english(): void
    {
        $stat = Stat::factory()->create(['label' => ['en' => 'Days by sea']]);

        app()->setLocale('bn');

        $this->assertSame('Days by sea', $stat->fresh()->label);
    }

    public function test_ordered_scope_sorts_by_position(): void
    {
        Sector::factory()->create(['sort' => 2, 'icon' => 'second']);
        Sector::factory()->create(['sort' => 1, 'icon' => 'first']);

        $this->assertSame(['first', 'second'], Sector::query()->ordered()->pluck('icon')->all());
    }
}
