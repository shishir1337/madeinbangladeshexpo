<?php

namespace Tests\Feature\Http;

use App\Models\GalleryAlbum;
use Database\Seeders\EditionSeeder;
use Database\Seeders\ExhibitorSeeder;
use Database\Seeders\GallerySeeder;
use Database\Seeders\ProgrammeSessionSeeder;
use Database\Seeders\SectorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArchivePagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EditionSeeder::class);
        $this->seed(SectorSeeder::class);
        $this->seed(ExhibitorSeeder::class);
        $this->seed(ProgrammeSessionSeeder::class);
        $this->seed(GallerySeeder::class);
    }

    public function test_archive_shows_programme_exhibitors_and_albums(): void
    {
        $this->get('/archive')
            ->assertOk()
            ->assertSee('Made in Bangladesh Expo 2025')
            ->assertSee('15–18 June 2025')
            ->assertSee('Inaugural ceremony')
            ->assertSee('B2B matchmaking')
            ->assertSee('STS Apparel')
            ->assertSee('Mashiur Habib Enterprise')
            ->assertSee('href="http://localhost/gallery/expo-2025-sao-paulo"', false)
            ->assertSee('href="http://localhost/gallery/brazil-bangladesh-events-dhaka"', false);

        $this->get('/pt/edicao-2025')
            ->assertOk()
            ->assertSee('Cerimônia de abertura')
            ->assertSee('href="http://localhost/pt/galeria/feira-2025-sao-paulo"', false);

        $this->get('/gallery')
            ->assertOk()
            ->assertSee('Expo 2025, São Paulo')
            ->assertSee('Brazil–Bangladesh events, Dhaka');
    }

    public function test_album_page_renders_photos_with_captions_and_json_ld(): void
    {
        $album = GalleryAlbum::query()->where('slug->en', 'expo-2025-sao-paulo')->firstOrFail();

        $html = $this->get('/gallery/expo-2025-sao-paulo')
            ->assertOk()
            ->assertSee('The STS Apparel stall')
            ->assertSee('"@type":"ImageGallery"', false)
            ->getContent();

        $this->assertSame($album->photos()->count(), substr_count($html, 'data-lightbox-item="'));
        $this->assertGreaterThanOrEqual(10, $album->photos()->count());

        $this->get('/pt/galeria/expo-2025-sao-paulo')->assertStatus(301)->assertRedirect('/pt/galeria/feira-2025-sao-paulo');

        $this->get('/bn/gallery/expo-2025-sao-paulo')
            ->assertOk()
            ->assertSee('<html lang="bn"', false)
            ->assertSee('<link rel="alternate" hreflang="pt-BR" href="http://localhost/pt/galeria/feira-2025-sao-paulo">', false);
    }
}
