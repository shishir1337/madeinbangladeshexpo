<?php

namespace Tests\Feature\Http;

use App\Models\Edition;
use App\Models\Exhibitor;
use App\Models\Sector;
use Database\Seeders\EditionSeeder;
use Database\Seeders\SectorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SectorPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EditionSeeder::class);
        $this->seed(SectorSeeder::class);
    }

    public function test_sectors_index_lists_nine_sectors_with_sources(): void
    {
        $html = $this->get('/sectors')->assertOk()->getContent();

        $this->assertSame(9, substr_count($html, 'data-sector-card="'));
        $this->assertStringContainsString('ComexStat, 2025', $html);
        $this->assertStringContainsString('href="http://localhost/sectors/garments"', $html);

        $this->get('/pt/setores')
            ->assertOk()
            ->assertSee('href="http://localhost/pt/setores/vestuario"', false);
    }

    public function test_sector_page_renders_body_rules_and_exhibitors(): void
    {
        $garments = Sector::query()->where('slug->en', 'garments')->firstOrFail();
        $garments->update([
            'hs_chapters' => ['61 Knitted apparel', '62 Woven apparel'],
            'body' => [
                'en' => "## What Brazil buys\n\nKnit T-shirts lead the list.",
                'pt_BR' => "## O que o Brasil compra\n\nCamisetas de malha lideram.",
            ],
            'rules' => ['en' => ['Labels must be in Portuguese'], 'pt_BR' => ['Etiquetas em português']],
        ]);

        Exhibitor::factory()->create([
            'name' => 'STS Apparel',
            'sector_id' => $garments->id,
            'edition_id' => Edition::query()->where('slug', '2025')->value('id'),
        ]);

        $this->get('/sectors/garments')
            ->assertOk()
            ->assertSee('<h2 id="what-brazil-buys">What Brazil buys</h2>', false)
            ->assertSee('Knit T-shirts lead the list.')
            ->assertSee('Labels must be in Portuguese')
            ->assertSee('61 Knitted apparel')
            ->assertSee('STS Apparel')
            ->assertSee('href="http://localhost/sectors/textiles"', false);

        $this->get('/pt/setores/vestuario')
            ->assertOk()
            ->assertSee('<html lang="pt-BR"', false)
            ->assertSee('Camisetas de malha lideram.')
            ->assertSee('Etiquetas em português');
    }

    public function test_wrong_language_slug_redirects_to_the_right_one(): void
    {
        $this->get('/pt/setores/garments')->assertStatus(301)->assertRedirect('/pt/setores/vestuario');
        $this->get('/sectors/vestuario')->assertStatus(301)->assertRedirect('/sectors/garments');
        $this->get('/sectors/not-a-sector')->assertNotFound();
    }

    public function test_sector_alternates_use_each_languages_slug(): void
    {
        $this->get('/pt/setores/vestuario')
            ->assertOk()
            ->assertSee('<link rel="alternate" hreflang="en" href="http://localhost/sectors/garments">', false)
            ->assertSee('<link rel="alternate" hreflang="bn" href="http://localhost/bn/sectors/garments">', false)
            ->assertSee('<link rel="alternate" hreflang="pt-BR" href="http://localhost/pt/setores/vestuario">', false);
    }
}
