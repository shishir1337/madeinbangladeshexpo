<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_tests_run_against_an_in_memory_sqlite_database(): void
    {
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
    }
}
