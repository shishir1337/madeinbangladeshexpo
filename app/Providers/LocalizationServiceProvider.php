<?php

namespace App\Providers;

use App\Support\Localization\Locales;
use App\Support\Localization\RouteSlugs;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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
        View::share('currentLocale', $this->app->make(Locales::class)->default());

        Route::macro('localized', function (Closure $routes): void {
            foreach (app(Locales::class)->all() as $locale) {
                RouteSlugs::registerFor($locale->key, function () use ($locale, $routes): void {
                    Route::prefix($locale->prefix ?? '')
                        ->name("{$locale->key}.")
                        ->middleware("locale:{$locale->key}")
                        ->group($routes);
                });
            }
        });
    }
}
