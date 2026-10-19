<?php

namespace App\Http\Middleware;

use App\Support\Icons\IconSprite;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Turns the icon sprite on for full HTML pages and prints it before </body>. Livewire updates return fragments
 * that are merged into a page whose sprite may lack their icons, so they keep inline icons.
 */
class InlineIconSprite
{
    public function __construct(private IconSprite $sprite) {}

    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        if ($request->isMethod('GET') && ! $request->hasHeader('X-Livewire')) {
            $this->sprite->enable();
        }

        $response = $next($request);

        if ($this->sprite->isEnabled() && $response instanceof Response && str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            $content = (string) $response->getContent();
            $position = strripos($content, '</body>');

            if ($position !== false) {
                $response->setContent(substr_replace($content, $this->sprite->render(), $position, 0));
            }
        }

        return $response;
    }
}
