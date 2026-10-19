<?php

namespace App\Support\Maps;

/**
 * The projection of the home page's dotted world map: longitude −180..180 → x 0..1000 and latitude
 * 78..−58 → y 0..380. It must match resources/js/build/world-dots.mjs, which drew the map image.
 */
class Equirectangular
{
    public const WIDTH = 1000;

    public const HEIGHT = 380;

    private const LAT_TOP = 78;

    private const LAT_BOTTOM = -58;

    /**
     * @return array{x: float, y: float}
     */
    public function point(float $lat, float $lon): array
    {
        return [
            'x' => ($lon + 180) / 360 * self::WIDTH,
            'y' => (self::LAT_TOP - $lat) / (self::LAT_TOP - self::LAT_BOTTOM) * self::HEIGHT,
        ];
    }

    /**
     * An SVG path through [lat, lon] waypoints, smoothed as a Catmull-Rom spline.
     *
     * @param  list<array{0: float, 1: float}>  $waypoints
     */
    public function smoothPath(array $waypoints): string
    {
        $points = array_map(fn (array $waypoint): array => $this->point($waypoint[0], $waypoint[1]), $waypoints);
        $last = count($points) - 1;
        $path = 'M'.$this->format($points[0]);

        for ($i = 0; $i < $last; $i++) {
            $previous = $points[max($i - 1, 0)];
            $from = $points[$i];
            $to = $points[$i + 1];
            $next = $points[min($i + 2, $last)];

            $controlOne = ['x' => $from['x'] + ($to['x'] - $previous['x']) / 6, 'y' => $from['y'] + ($to['y'] - $previous['y']) / 6];
            $controlTwo = ['x' => $to['x'] - ($next['x'] - $from['x']) / 6, 'y' => $to['y'] - ($next['y'] - $from['y']) / 6];

            $path .= ' C'.$this->format($controlOne).' '.$this->format($controlTwo).' '.$this->format($to);
        }

        return $path;
    }

    /**
     * A quadratic arc between two [lat, lon] points, bowed to the left of travel by `bend` × its length.
     *
     * @param  array{0: float, 1: float}  $from
     * @param  array{0: float, 1: float}  $to
     */
    public function arc(array $from, array $to, float $bend = 0.2): string
    {
        $start = $this->point($from[0], $from[1]);
        $end = $this->point($to[0], $to[1]);
        $dx = $end['x'] - $start['x'];
        $dy = $end['y'] - $start['y'];

        $control = [
            'x' => ($start['x'] + $end['x']) / 2 + $dy * $bend,
            'y' => ($start['y'] + $end['y']) / 2 - $dx * $bend * ($dx < 0 ? -1 : 1),
        ];

        return 'M'.$this->format($start).' Q'.$this->format($control).' '.$this->format($end);
    }

    /**
     * @param  array{x: float, y: float}  $point
     */
    private function format(array $point): string
    {
        return number_format($point['x'], 1, '.', '').','.number_format($point['y'], 1, '.', '');
    }
}
