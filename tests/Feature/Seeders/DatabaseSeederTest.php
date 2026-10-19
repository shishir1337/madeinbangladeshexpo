<?php

namespace Tests\Feature\Seeders;

use App\Models\Edition;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeding_twice_succeeds(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(2, Edition::count());
        $this->assertSame(8, Role::count());
    }

    public function test_the_test_user_is_only_created_on_a_local_machine(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->assertFalse(User::where('email', 'test@example.com')->exists());

        $this->app['env'] = 'local';
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);
        $this->assertSame(1, User::where('email', 'test@example.com')->count());
    }

    public function test_edition_seeder_keeps_an_edition_staff_made_current(): void
    {
        $current = Edition::factory()->current()->create(['slug' => '2027']);

        $this->seed(EditionSeeder::class);

        $this->assertTrue($current->fresh()->is_current);
        $this->assertFalse(Edition::where('slug', '2026')->first()->is_current);
    }

    public function test_edition_seeder_does_not_overwrite_edits(): void
    {
        $this->seed(EditionSeeder::class);
        Edition::where('slug', '2026')->first()->update(['ends_on' => '2027-03-26']);

        $this->seed(EditionSeeder::class);

        $this->assertSame('2027-03-26', Edition::where('slug', '2026')->first()->ends_on->toDateString());
    }
}
