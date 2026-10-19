<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Everything the home page shows besides the edition and settings. Safe to run repeatedly.
 */
class HomeContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            StatSeeder::class,
            SectorSeeder::class,
            MilestoneSeeder::class,
            TestimonialSeeder::class,
            VideoSeeder::class,
            PartnerSeeder::class,
        ]);
    }
}
