<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database. Safe to run repeatedly.
     */
    public function run(): void
    {
        if (app()->isLocal()) {
            User::firstOrCreate(
                ['email' => 'test@example.com'],
                User::factory()->raw(['name' => 'Test User', 'email' => 'test@example.com']),
            );
        }

        $this->call([
            StaffRoleSeeder::class,
            EditionSeeder::class,
            HomeContentSeeder::class,
            PersonSeeder::class,
            SectorContentSeeder::class,
            ExhibitorSeeder::class,
            ProgrammeSessionSeeder::class,
            GallerySeeder::class,
        ]);
    }
}
