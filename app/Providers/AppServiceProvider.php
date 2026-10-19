<?php

namespace App\Providers;

use App\Support\Editions\CurrentEdition;
use App\Support\Icons\IconSprite;
use App\Support\Images\ImageManifest;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(CurrentEdition::class);
        $this->app->scoped(IconSprite::class);
        $this->app->singleton(ImageManifest::class, fn (): ImageManifest => ImageManifest::fromFile(config('images.output_path').'/manifest.json'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
