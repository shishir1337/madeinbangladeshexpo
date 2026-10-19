<?php

namespace App\Http\Middleware;

use App\Support\Localization\Locales;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Number;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function __construct(private Locales $locales) {}

    /**
     * Run the request in the locale its route was registered for.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $locale): Response
    {
        $localeObject = $this->locales->get($locale);

        App::setLocale($localeObject->key);
        Number::useLocale($localeObject->icu);
        Carbon::setLocale($localeObject->icu);
        View::share('currentLocale', $localeObject);

        return $next($request);
    }
}
