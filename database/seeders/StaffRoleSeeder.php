<?php

namespace Database\Seeders;

use App\Enums\StaffRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/**
 * One web-guard role per StaffRole case. Safe to run repeatedly.
 */
class StaffRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (StaffRole::cases() as $staffRole) {
            Role::findOrCreate($staffRole->value, 'web');
        }
    }
}
