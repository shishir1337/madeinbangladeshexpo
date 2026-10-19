<?php

namespace Database\Seeders;

use App\Models\Edition;
use App\Models\Exhibitor;
use App\Models\Sector;
use Illuminate\Database\Seeder;

/**
 * The 15 companies announced as exhibitors at Made in Bangladesh Expo 2025 (docs/research/02 §7), each under
 * its primary sector from the competitor's sector pages (§3). Two have no published sector. Websites and logos
 * stay empty until the companies confirm them. Safe to run repeatedly.
 */
class ExhibitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $edition2025 = Edition::query()->where('slug', '2025')->value('id');

        if ($edition2025 === null) {
            return;
        }

        $exhibitors = [
            ['name' => 'Aman Plastic Toys Industries', 'sector' => 'plastics-toys'],
            ['name' => 'Apex Lingerie', 'sector' => 'garments'],
            ['name' => 'BAB Trend Fashion', 'sector' => 'garments'],
            ['name' => 'Benchmark', 'sector' => 'garments'],
            ['name' => 'Biocell', 'sector' => 'pharmaceuticals'],
            ['name' => 'Blue Planet Group', 'sector' => 'garments'],
            ['name' => 'Chemist', 'sector' => 'pharmaceuticals'],
            ['name' => 'Maha Telecom', 'sector' => 'ict'],
            ['name' => 'Marsik', 'sector' => 'garments'],
            ['name' => 'Mashiur Habib Enterprise', 'sector' => null],
            ['name' => 'Mitali Group', 'sector' => 'garments'],
            ['name' => 'Pioneer Casual Wear', 'sector' => 'garments'],
            ['name' => 'Renaissance Group', 'sector' => 'garments'],
            ['name' => 'SED Worked', 'sector' => null],
            ['name' => 'STS Apparel', 'sector' => 'garments'],
        ];

        foreach ($exhibitors as $sort => $exhibitor) {
            Exhibitor::firstOrCreate(
                ['name' => $exhibitor['name'], 'edition_id' => $edition2025],
                [
                    'sector_id' => $exhibitor['sector'] === null
                        ? null
                        : Sector::query()->where('slug->en', $exhibitor['sector'])->value('id'),
                    'website' => null,
                    'logo' => null,
                    'sort' => $sort,
                ],
            );
        }
    }
}
