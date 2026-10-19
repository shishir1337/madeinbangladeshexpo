<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrganisationPagesController;
use App\Http\Controllers\RedirectLegacyLocalePrefix;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\StyleguideController;
use Illuminate\Support\Facades\Route;

Route::localized(function (): void {
    Route::get('/', HomeController::class)->name('home');

    Route::get(localized_slug('about'), [OrganisationPagesController::class, 'about'])->name('about');
    Route::get(localized_slug('organiser'), [OrganisationPagesController::class, 'organiser'])->name('organiser');
    Route::get(localized_slug('committee'), [OrganisationPagesController::class, 'committee'])->name('committee');

    Route::get(localized_slug('sectors'), [SectorController::class, 'index'])->name('sectors');
    Route::get(localized_slug('sectors').'/{sector}', [SectorController::class, 'show'])->name('sectors.show');

    Route::get(localized_slug('archive'), ArchiveController::class)->name('archive');
    Route::get(localized_slug('gallery'), [GalleryController::class, 'index'])->name('gallery');
    Route::get(localized_slug('gallery').'/{album}', [GalleryController::class, 'show'])->name('gallery.show');

    Route::get(localized_slug('newsletter').'/{subscription}/confirm', [NewsletterController::class, 'confirm'])->name('newsletter.confirm');
    Route::get(localized_slug('newsletter').'/{subscription}/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
});

Route::get('_styleguide', StyleguideController::class)->name('styleguide');

Route::get('{legacyPrefix}/{path?}', RedirectLegacyLocalePrefix::class)
    ->where('legacyPrefix', 'pt-br|pt-BR|PT|Pt|en|EN|bn-bd|bn-BD|BN')
    ->where('path', '.*')
    ->name('legacy-locale-prefix');
