<?php

namespace Tests\Feature\Seeders;

use App\Enums\StaffRole;
use App\Models\User;
use Database\Seeders\StaffRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StaffRoleSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_one_role_per_staff_role(): void
    {
        $this->seed(StaffRoleSeeder::class);

        $expected = array_column(StaffRole::cases(), 'value');
        sort($expected);

        $this->assertSame($expected, Role::query()->orderBy('name')->pluck('name')->all());
    }

    public function test_running_twice_does_not_duplicate_roles(): void
    {
        $this->seed(StaffRoleSeeder::class);
        $this->seed(StaffRoleSeeder::class);

        $this->assertSame(8, Role::query()->count());
    }

    public function test_a_user_can_hold_a_staff_role(): void
    {
        $this->seed(StaffRoleSeeder::class);

        $user = User::factory()->create();
        $user->assignRole(StaffRole::Finance->value);

        $this->assertTrue($user->hasRole('finance'));
    }
}
