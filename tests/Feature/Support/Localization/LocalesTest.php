<?php

namespace Tests\Feature\Support\Localization;

use App\Support\Localization\Locales;
use InvalidArgumentException;
use Tests\TestCase;

class LocalesTest extends TestCase
{
    public function test_supports_english_portuguese_and_bangla_in_that_order(): void
    {
        $this->assertSame(['en', 'pt_BR', 'bn'], array_keys(app(Locales::class)->all()));
    }

    public function test_english_is_the_default_and_has_no_url_prefix(): void
    {
        $default = app(Locales::class)->default();

        $this->assertSame('en', $default->key);
        $this->assertNull($default->prefix);
    }

    public function test_finds_portuguese_by_its_url_prefix(): void
    {
        $locales = app(Locales::class);

        $this->assertSame('pt_BR', $locales->fromPrefix('pt')?->key);
        $this->assertNull($locales->fromPrefix('xx'));
    }

    public function test_rejects_an_unknown_locale_key(): void
    {
        $this->expectException(InvalidArgumentException::class);

        app(Locales::class)->get('fr');
    }
}
