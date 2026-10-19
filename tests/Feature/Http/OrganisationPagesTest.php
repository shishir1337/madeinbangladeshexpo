<?php

namespace Tests\Feature\Http;

use App\Models\Person;
use Database\Seeders\EditionSeeder;
use Database\Seeders\PersonSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class OrganisationPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EditionSeeder::class);
        $this->seed(PersonSeeder::class);
    }

    #[DataProvider('aboutPages')]
    public function test_about_page_renders_in_three_languages(string $url, string $lang, string $heading): void
    {
        $this->get($url)
            ->assertOk()
            ->assertSee('<html lang="'.$lang.'"', false)
            ->assertSee($heading);
    }

    /**
     * @return array<string, array{string, string, string}>
     */
    public static function aboutPages(): array
    {
        return [
            'english' => ['/about', 'en', 'What happens at the expo'],
            'portuguese' => ['/pt/sobre', 'pt-BR', 'O que acontece na feira'],
            'bangla' => ['/bn/about', 'bn', 'এক্সপোতে যা হয়'],
        ];
    }

    public function test_organiser_page_lists_mission_objectives_services_and_leaders(): void
    {
        $html = $this->get('/organiser')->assertOk()->getContent();

        foreach (['Our mission', 'Promote trade and investment', 'Cultural exchange', 'Business matchmaking', 'Training and capacity building', 'Board of Directors', 'Shahriar Ahmed', 'Md. Saiful Alam', 'Md. Joynal Abdin'] as $text) {
            $this->assertStringContainsString($text, $html);
        }

        $this->assertStringContainsString('"@type":"Organization"', $html);
        $this->assertStringContainsString('href="tel:+8801553676767"', $html);
    }

    public function test_committee_lists_documented_people_only(): void
    {
        $this->assertSame(4, Person::count());

        $this->get('/pt/comite')
            ->assertOk()
            ->assertSee('Paulo Fernando Dias Feres')
            ->assertSee('Embaixador do Brasil em Bangladesh')
            ->assertSee('href="mailto:president@brazilbangladeshchamber.com"', false)
            ->assertSee('Conselho de Administração');
    }
}
