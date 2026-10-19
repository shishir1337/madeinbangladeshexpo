/**
 * Generates public/img/world-dots.svg: a dotted world map for the home page's trade-route band.
 *
 * Run once with `node resources/js/build/world-dots.mjs` and commit the output. The projection must match
 * App\Support\Maps\Equirectangular (lon −180..180 → x 0..1000, lat 78..−58 → y 0..380), which draws the
 * routes and markers on top of this image.
 *
 * Land data: Natural Earth via world-atlas (public domain).
 */
import { readFileSync, writeFileSync } from 'node:fs';
import { feature } from 'topojson-client';

const WIDTH = 1000;
const HEIGHT = 380;
const LAT_TOP = 78;
const LAT_BOTTOM = -58;
const STEP = 2; // degrees between dots
const BRAZIL_ID = '076';

const project = (lat, lon) => [((lon + 180) / 360) * WIDTH, ((LAT_TOP - lat) / (LAT_TOP - LAT_BOTTOM)) * HEIGHT];

function ringContains(ring, lon, lat) {
    let inside = false;

    for (let i = 0, j = ring.length - 1; i < ring.length; j = i++) {
        const [xi, yi] = ring[i];
        const [xj, yj] = ring[j];

        if (yi > lat !== yj > lat && lon < ((xj - xi) * (lat - yi)) / (yj - yi) + xi) {
            inside = !inside;
        }
    }

    return inside;
}

function polygonsOf(geometry) {
    return geometry.type === 'Polygon' ? [geometry.coordinates] : geometry.coordinates;
}

function contains(geometry, lon, lat) {
    return polygonsOf(geometry).some(([outer, ...holes]) => ringContains(outer, lon, lat) && !holes.some((hole) => ringContains(hole, lon, lat)));
}

const atlas = (name) => JSON.parse(readFileSync(new URL(`../../../node_modules/world-atlas/${name}`, import.meta.url)));

const land = feature(atlas('land-110m.json'), atlas('land-110m.json').objects.land);
const countries = feature(atlas('countries-110m.json'), atlas('countries-110m.json').objects.countries);
const brazil = countries.features.find((country) => country.id === BRAZIL_ID).geometry;
const landGeometries = land.features.map((part) => part.geometry);

const landDots = [];
const brazilDots = [];

for (let lat = LAT_TOP - STEP / 2; lat > LAT_BOTTOM; lat -= STEP) {
    for (let lon = -180 + STEP / 2; lon < 180; lon += STEP) {
        if (contains(brazil, lon, lat)) {
            brazilDots.push(project(lat, lon));
        } else if (landGeometries.some((geometry) => contains(geometry, lon, lat))) {
            landDots.push(project(lat, lon));
        }
    }
}

const path = (dots) => dots.map(([x, y]) => `M${x.toFixed(1)} ${y.toFixed(1)}h0`).join('');

const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${WIDTH} ${HEIGHT}" width="${WIDTH}" height="${HEIGHT}">`
    + `<path d="${path(landDots)}" stroke="#1f416a" stroke-width="2.9" stroke-linecap="round"/>`
    + `<path d="${path(brazilDots)}" stroke="#2f7d68" stroke-width="2.9" stroke-linecap="round"/>`
    + '</svg>\n';

writeFileSync(new URL('../../../public/img/world-dots.svg', import.meta.url), svg);

console.log(`world-dots.svg: ${landDots.length} land dots, ${brazilDots.length} Brazil dots, ${(svg.length / 1024).toFixed(1)} KB`);
