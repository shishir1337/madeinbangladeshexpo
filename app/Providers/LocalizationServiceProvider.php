<?php

namespace App\Providers;

use App\Support\Localization\Locales;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Locales::class, fn (): Locales => new Locales(
            supported: config('locales.supported'),
            defaultKey: config('locales.default'),
        ));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
