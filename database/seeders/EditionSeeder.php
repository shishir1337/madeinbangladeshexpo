<?php

namespace Database\Seeders;

use App\Enums\EditionStatus;
use App\Models\Edition;
use App\Models\Venue;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

/**
 * The 2025 archive and the current 2026 edition (spec §4 working values). Safe to run repeatedly: existing
 * venues and editions are left as staff edited them, and 2026 only becomes current when nothing else is.
 */
class EditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $novotel = Venue::firstOrCreate(
            ['name' => 'Novotel São Paulo Center Norte'],
            ['city' => 'São Paulo', 'state' => 'SP', 'country_code' => 'BR'],
        );

        $proMagno = Venue::firstOrCreate(
            ['name' => 'Pro Magno Centro de Eventos'],
            [
                'address_line' => 'Av. Professora Ida Kolb, 513',
                'district' => 'Casa Verde',
                'city' => 'São Paulo',
                'state' => 'SP',
                'country_code' => 'BR',
            ],
        );

        Edition::firstOrCreate(['slug' => '2025'], [
            'venue_id' => $novotel->id,
            'number' => 1,
            'name' => [
                'en' => 'Made in Bangladesh Expo 2025',
                'pt_BR' => 'Made in Bangladesh Expo 2025',
                'bn' => 'মেইড ইন বাংলাদেশ এক্সপো ২০২৫',
            ],
            'starts_on' => '2025-06-15',
            'ends_on' => '2025-06-18',
            'opening_at' => null,
            'status' => EditionStatus::Archived,
            'is_current' => false,
        ]);

        Edition::firstOrCreate(['slug' => '2026'], [
            'venue_id' => $proMagno->id,
            'number' => 2,
            'name' => [
                'en' => 'Made in Bangladesh Expo 2026',
                'pt_BR' => 'Made in Bangladesh Expo 2026',
                'bn' => 'মেইড ইন বাংলাদেশ এক্সপো ২০২৬',
            ],
            'starts_on' => '2027-03-22',
            'ends_on' => '2027-03-25',
            'opening_at' => CarbonImmutable::parse('2027-03-22 10:00', 'America/Sao_Paulo')->utc(),
            'status' => EditionStatus::Announced,
            'is_current' => Edition::query()->current()->doesntExist(),
        ]);
    }
}
