<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RedirectLegacyLocalePrefix;
use Illuminate\Support\Facades\Route;

Route::localized(function (): void {
    Route::get('/', HomeController::class)->name('home');
});

Route::get('{legacyPrefix}/{path?}', RedirectLegacyLocalePrefix::class)
    ->where('legacyPrefix', 'pt-br|pt-BR|PT|Pt|en|EN|bn-bd|bn-BD|BN')
    ->where('path', '.*')
    ->name('legacy-locale-prefix');
