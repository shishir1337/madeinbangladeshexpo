<?php

namespace Tests\Feature\Models;

use App\Models\Edition;
use Carbon\CarbonImmutable;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditionTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_one_edition_can_be_current(): void
    {
        Edition::factory()->current()->create();

        $this->expectException(QueryException::class);

        Edition::factory()->current()->create();
    }

    public function test_opening_time_is_shown_in_sao_paulo_and_dhaka(): void
    {
        $edition = Edition::factory()->create([
            'opening_at' => CarbonImmutable::parse('2027-03-22 13:00:00', 'UTC'),
        ])->fresh();

        $this->assertSame('2027-03-22 10:00', $edition->openingAtIn('America/Sao_Paulo')->format('Y-m-d H:i'));
        $this->assertSame('2027-03-22 19:00', $edition->openingAtIn('Asia/Dhaka')->format('Y-m-d H:i'));
    }

    public function test_edition_name_falls_back_to_english_when_translation_missing(): void
    {
        $edition = Edition::factory()->create([
            'name' => ['en' => 'Made in Bangladesh Expo 2026'],
        ])->fresh();

        app()->setLocale('bn');

        $this->assertSame('Made in Bangladesh Expo 2026', $edition->name);
    }
}
