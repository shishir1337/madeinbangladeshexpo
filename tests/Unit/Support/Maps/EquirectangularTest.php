<?php

namespace Tests\Unit\Support\Maps;

use App\Support\Maps\Equirectangular;
use PHPUnit\Framework\TestCase;

class EquirectangularTest extends TestCase
{
    public function test_projects_the_corners_and_the_origin_onto_the_viewbox(): void
    {
        $map = new Equirectangular;

        $this->assertEqualsWithDelta(['x' => 0.0, 'y' => 0.0], $map->point(78, -180), 0.001);
        $this->assertEqualsWithDelta(['x' => 1000.0, 'y' => 380.0], $map->point(-58, 180), 0.001);
        $this->assertEqualsWithDelta(['x' => 500.0, 'y' => 217.941], $map->point(0, 0), 0.001);
    }

    public function test_builds_a_smooth_path_through_every_point(): void
    {
        $path = (new Equirectangular)->smoothPath([[22.3, 91.8], [5, 80], [-35, 20], [-24, -46.3]]);

        $this->assertStringStartsWith('M', $path);
        $this->assertSame(3, substr_count($path, 'C'));
        $this->assertStringEndsWith('371.4,285.0', $path);
    }

    public function test_builds_an_arc_between_two_points(): void
    {
        $path = (new Equirectangular)->arc([23.8, 90.4], [25.3, 55.4], 0.25);

        $this->assertMatchesRegularExpression('/^M[\d.]+,[\d.]+ Q[\d.]+,[\d.]+ [\d.]+,[\d.]+$/', $path);
    }
}
