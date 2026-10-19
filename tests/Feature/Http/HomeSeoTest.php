<?php

namespace Tests\Feature\Http;

use App\Models\Edition;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_has_meta_description_canonical_and_social_tags(): void
    {
        $this->createCurrentEdition();

        $this->get('/pt')
            ->assertOk()
            ->assertSee('<meta name="description" content="Made in Bangladesh Expo: fabricantes de Bangladesh', false)
            ->assertSee('<link rel="canonical" href="http://localhost/pt">', false)
            ->assertSee('<meta property="og:title" content="Made in Bangladesh Expo 2026', false)
            ->assertSee('<meta property="og:locale" content="pt_BR">', false)
            ->assertSee('<meta property="og:locale:alternate" content="bn_BD">', false)
            ->assertSee('<meta property="og:image" content="http://localhost/img/expo25-stand-garments-1200.jpg">', false)
            ->assertSee('<meta name="twitter:card" content="summary_large_image">', false);
    }

    public function test_home_emits_exhibition_event_structured_data(): void
    {
        $this->createCurrentEdition();

        $event = collect($this->jsonLdGraphs($this->get('/')->assertOk()->getContent()))->firstWhere('@type', 'ExhibitionEvent');

        $this->assertNotNull($event, 'No ExhibitionEvent JSON-LD on the home page.');
        $this->assertSame('Made in Bangladesh Expo 2026', $event['name']);
        $this->assertSame('2027-03-22T10:00:00-03:00', $event['startDate']);
        $this->assertSame('2027-03-25', $event['endDate']);
        $this->assertSame('https://schema.org/OfflineEventAttendanceMode', $event['eventAttendanceMode']);
        $this->assertSame('Pro Magno Centro de Eventos', $event['location']['name']);
        $this->assertSame('BR', $event['location']['address']['addressCountry']);
        $this->assertSame('Brazil Bangladesh Chamber of Commerce & Industry', $event['organizer']['name']);
        $this->assertSame('0', $event['offers']['price']);
    }

    public function test_home_without_an_edition_still_describes_the_organiser(): void
    {
        $organisation = collect($this->jsonLdGraphs($this->get('/')->assertOk()->getContent()))->firstWhere('@type', 'Organization');

        $this->assertSame('BBCCI', $organisation['alternateName']);
        $this->assertSame('sg@brazilbangladeshchamber.com', $organisation['contactPoint']['email']);
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function jsonLdGraphs(string $html): array
    {
        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches);

        return collect($matches[1])
            ->map(fn (string $json): array => json_decode($json, true))
            ->flatMap(fn (array $data): array => $data['@graph'] ?? [$data])
            ->values()
            ->all();
    }

    private function createCurrentEdition(): Edition
    {
        return Edition::factory()
            ->current()
            ->for(Venue::factory()->state(['name' => 'Pro Magno Centro de Eventos', 'city' => 'São Paulo', 'state' => 'SP', 'country_code' => 'BR']))
            ->create([
                'slug' => '2026',
                'name' => ['en' => 'Made in Bangladesh Expo 2026', 'pt_BR' => 'Made in Bangladesh Expo 2026'],
                'starts_on' => '2027-03-22',
                'ends_on' => '2027-03-25',
            ]);
    }
}
