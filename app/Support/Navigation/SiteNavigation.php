<?php

namespace App\Support\Navigation;

use Illuminate\Support\Facades\Route;

/**
 * Every public page the site will have, grouped as the header, drawer and footer show them. Entries whose
 * localized route does not exist yet are left out, so the shell never links to a page that is not built.
 */
class SiteNavigation
{
    /**
     * Route name => icon, per menu group, in menu order.
     *
     * @var array<string, array<string, string>>
     */
    private const GROUPS = [
        'the-expo' => [
            'about' => 'info',
            'organiser' => 'landmark',
            'committee' => 'users',
            'sectors' => 'layers',
            'programme' => 'calendar',
            'speakers' => 'mic',
            'partners' => 'award',
            'archive' => 'image',
        ],
        'take-part' => [
            'exhibit' => 'store',
            'stand-packages' => 'package',
            'apply' => 'list-checks',
            'deadlines' => 'clock',
            'payment' => 'banknote',
            'visit' => 'shopping-bag',
            'sponsorship' => 'sparkles',
            'register' => 'ticket',
        ],
        'plan-your-trip' => [
            'venue' => 'map-pin',
            'city-guide' => 'compass',
            'hotels' => 'bed',
            'travel' => 'plane',
        ],
        'news-media' => [
            'news' => 'newspaper',
            'press' => 'megaphone',
            'downloads' => 'download',
            'gallery' => 'camera',
        ],
    ];

    /**
     * @var array<string, string>
     */
    private const LEGAL = [
        'privacy' => 'lock',
        'terms' => 'file-text',
        'refunds' => 'banknote',
        'cookies' => 'shield-check',
        'accessibility' => 'accessibility',
    ];

    private const CONTACT = ['contact' => 'message-circle'];

    /**
     * The header's mega-menu groups.
     *
     * @return list<array{key: string, label: string, active: bool, items: list<array{route: string, url: string, label: string, description: string, icon: string, active: bool}>}>
     */
    public function primary(): array
    {
        return $this->groups(self::GROUPS);
    }

    /**
     * The footer's columns: the menu groups plus legal pages.
     *
     * @return list<array{key: string, label: string, active: bool, items: list<array{route: string, url: string, label: string, description: string, icon: string, active: bool}>}>
     */
    public function footer(): array
    {
        return $this->groups([...self::GROUPS, 'legal' => self::LEGAL]);
    }

    /**
     * The top-level contact link, when the contact page exists.
     *
     * @return array{route: string, url: string, label: string, description: string, icon: string, active: bool}|null
     */
    public function contact(): ?array
    {
        return $this->items(self::CONTACT)[0] ?? null;
    }

    /**
     * Whether the page behind a route name exists in the current locale.
     */
    public function has(string $route): bool
    {
        return Route::has(app()->getLocale().'.'.$route);
    }

    /**
     * Every route name the navigation knows about.
     *
     * @return list<string>
     */
    public static function routeNames(): array
    {
        return array_keys(array_merge(...array_values(self::GROUPS), ...[self::LEGAL, self::CONTACT]));
    }

    /**
     * @param  array<string, array<string, string>>  $groups
     * @return list<array{key: string, label: string, active: bool, items: list<array{route: string, url: string, label: string, description: string, icon: string, active: bool}>}>
     */
    private function groups(array $groups): array
    {
        $result = [];

        foreach ($groups as $key => $routes) {
            $items = $this->items($routes);

            if ($items === []) {
                continue;
            }

            $result[] = [
                'key' => $key,
                'label' => __("nav.groups.{$key}"),
                'active' => in_array(true, array_column($items, 'active'), true),
                'items' => $items,
            ];
        }

        return $result;
    }

    /**
     * @param  array<string, string>  $routes
     * @return list<array{route: string, url: string, label: string, description: string, icon: string, active: bool}>
     */
    private function items(array $routes): array
    {
        $currentRoute = request()->route()?->getName();
        $items = [];

        foreach ($routes as $route => $icon) {
            if (! $this->has($route)) {
                continue;
            }

            $routeName = app()->getLocale().'.'.$route;

            $items[] = [
                'route' => $route,
                'url' => localized_route($route),
                'label' => __("nav.items.{$route}.label"),
                'description' => __("nav.items.{$route}.description"),
                'icon' => $icon,
                'active' => $currentRoute !== null && ($currentRoute === $routeName || str_starts_with($currentRoute, "{$routeName}.")),
            ];
        }

        return $items;
    }
}
