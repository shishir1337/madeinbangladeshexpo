<?php

namespace App\Support\Navigation;

use Illuminate\Support\Facades\Route;

/**
 * Every public page the site will have, grouped as the header, drawer and footer show them. Pages not built yet
 * are served by a "being prepared" page (see pagesInPreparation()), so the shell always shows the whole site
 * and never links to a 404. An entry with no route at all is left out.
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
            'exhibitors' => 'building',
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
            'register-interest' => 'mail',
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

    /**
     * @var array<string, string>
     */
    private const HELP = [
        'faq' => 'info',
        'contact' => 'message-circle',
    ];

    private const ACCOUNT = ['login' => 'log-in'];

    /**
     * Pages that have their own controller and view; every other entry is served by the preparation page.
     *
     * @var list<string>
     */
    private const BUILT = ['about', 'organiser', 'committee', 'sectors', 'archive', 'gallery'];

    /**
     * The header's mega-menu groups, ending with help (FAQ and contact).
     *
     * @return list<array{key: string, label: string, active: bool, items: list<array{route: string, url: string, label: string, description: string, icon: string, active: bool}>}>
     */
    public function primary(): array
    {
        return $this->groups([...self::GROUPS, 'help' => self::HELP]);
    }

    /**
     * The footer's columns: the menu groups, help and legal pages.
     *
     * @return list<array{key: string, label: string, active: bool, items: list<array{route: string, url: string, label: string, description: string, icon: string, active: bool}>}>
     */
    public function footer(): array
    {
        return $this->groups([...self::GROUPS, 'help' => self::HELP, 'legal' => self::LEGAL]);
    }

    /**
     * The top-level contact link, when the contact page exists.
     *
     * @return array{route: string, url: string, label: string, description: string, icon: string, active: bool}|null
     */
    public function contact(): ?array
    {
        return $this->items(['contact' => self::HELP['contact']])[0] ?? null;
    }

    /**
     * The sign-in link for exhibitors, buyers and delegates.
     *
     * @return array{route: string, url: string, label: string, description: string, icon: string, active: bool}|null
     */
    public function account(): ?array
    {
        return $this->items(self::ACCOUNT)[0] ?? null;
    }

    /**
     * The footer column a page sits in, e.g. "take-part" for "exhibit", or null when it is in none.
     *
     * @return array{key: string, label: string, active: bool, items: list<array{route: string, url: string, label: string, description: string, icon: string, active: bool}>}|null
     */
    public function groupOf(string $route): ?array
    {
        foreach ($this->footer() as $group) {
            if (in_array($route, array_column($group['items'], 'route'), true)) {
                return $group;
            }
        }

        return null;
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
        return array_keys(array_merge(...array_values(self::GROUPS), ...[self::HELP, self::LEGAL, self::ACCOUNT]));
    }

    /**
     * Navigation pages without their own controller yet, which the preparation page serves.
     *
     * @return list<string>
     */
    public static function pagesInPreparation(): array
    {
        return array_values(array_diff(self::routeNames(), self::BUILT));
    }

    public static function isInPreparation(string $route): bool
    {
        return in_array($route, self::pagesInPreparation(), true);
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
