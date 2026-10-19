<?php

namespace App\Http\Controllers;

use App\Support\Localization\Locales;
use Illuminate\Http\RedirectResponse;

class RedirectLegacyLocalePrefix extends Controller
{
    /**
     * Variant language prefixes and the locale key each one means.
     *
     * @var array<string, string>
     */
    private const LEGACY_PREFIXES = [
        'pt-br' => 'pt_BR',
        'pt-BR' => 'pt_BR',
        'PT' => 'pt_BR',
        'Pt' => 'pt_BR',
        'en' => 'en',
        'EN' => 'en',
        'bn-bd' => 'bn',
        'bn-BD' => 'bn',
        'BN' => 'bn',
    ];

    public function __construct(private Locales $locales) {}

    /**
     * Permanently redirect a variant language prefix to the canonical one, keeping the rest of the path.
     */
    public function __invoke(string $legacyPrefix, ?string $path = null): RedirectResponse
    {
        $target = $this->locales->get(self::LEGACY_PREFIXES[$legacyPrefix]);
        // The leading slash keeps the target on this site: url() returns absolute URLs untouched.
        $url = url('/'.trim(($target->prefix ?? '').'/'.($path ?? ''), '/'));
        $queryString = request()->getQueryString();

        return redirect()->to($queryString === null ? $url : "{$url}?{$queryString}", 301);
    }
}
