# Phase 0: Foundation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** a Laravel 13 app on MySQL that serves English at `/`, Portuguese at `/pt` and Bangla at `/bn` from one route definition. The current edition's name, dates and venue are read from the database and rendered correctly in each language.

**Architecture:** a small custom localization layer:

- a locale registry from `config/locales.php`
- a `Route::localized()` macro that registers each route once per locale, with translated slugs
- a `locale:{key}` middleware
- URL helpers for hreflang alternates and the language switcher

Event facts live in `Edition`/`Venue` models (translatable name) and in spatie settings, and are formatted per locale (Bangla numerals included) by one formatter service.

**Tech stack:** Laravel 13.37, PHP 8.4, MySQL (locally XAMPP's MariaDB 10.4; MySQL 8 in production), PHPUnit 12, spatie/laravel-translatable ^6.15, spatie/laravel-settings ^3.9, spatie/laravel-permission ^8.3.

**Spec:** `docs/superpowers/specs/2026-10-19-made-in-bangladesh-expo-portal-design.md` (§3 constraints, §4 working values, §5J roles, §5Q demo mode, §7 stack). Master plan: `docs/superpowers/plans/2026-10-19-master-plan.md`.

**Deliberate departures from the spec's stack table:**

1. **A custom localization layer instead of `mcamara/laravel-localization`.** About 150 tested lines give deterministic route names (`pt_BR.home`) and plain `route:cache`, and avoid mcamara's Livewire update-route workaround. The spec's research named this as the alternative.
2. **PHPUnit instead of Pest.** The project's Boost guidelines say the project uses PHPUnit, and forbid new test dependencies without approval. Pest can still be adopted later (for browser tests in Phase 5); it runs existing PHPUnit classes unchanged.

## Global Constraints

**Runtimes and tools**

- **PHP:** always `C:\Users\amaiz\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe` (PHP 8.4). Never the `php` on PATH, which is XAMPP 8.2 and too old for Laravel 13.
  - In Bash, start each command with:

    ```bash
    PHP84="/c/Users/amaiz/AppData/Local/Microsoft/WinGet/Packages/PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe/php.exe"
    ```

    then run `"$PHP84" artisan …`.
  - Shell state doesn't persist between commands, so set the variable in the same command.
- **Composer must run from PowerShell.** The Bash tool cannot resolve github.com.

  ```powershell
  $php84 = "C:\Users\amaiz\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe"
  & $php84 C:\ProgramData\ComposerSetup\bin\composer.phar <args> --no-interaction
  ```

- **Database:** MySQL, the user's choice (2026-10-19). Locally this is XAMPP's MariaDB 10.4 on `127.0.0.1:3366`, user `root` with no password; production is MySQL 8.
  - App database `bbcci_expo`, test database `bbcci_expo_test` (both `utf8mb4_unicode_ci`).
  - Use the `mysql` driver. Write only SQL that runs on both MariaDB 10.4 and MySQL 8: no partial indexes, no `jsonb`, no `ILIKE`.
  - XAMPP's MySQL must be running. Start it from the XAMPP Control Panel, or with `C:\xampp\mysql\bin\mysqld.exe --defaults-file=C:\xampp\mysql\bin\my.ini --standalone`.

**Laravel Boost conventions** (`CLAUDE.md`)

- Create files with `php artisan make:… --no-interaction`.
- Tests are **PHPUnit** classes (`php artisan make:test --phpunit Name`, plus `--unit` only for framework-free logic). Test method names use the `test_` prefix and state the result.
- Run `vendor/bin/pint --dirty --format agent` before each commit.
- Don't add dependencies beyond the three listed in Tech Stack.
- Don't add documentation files.

**Locales**

| Key | URL prefix | `html lang` / hreflang | ICU locale | Native name | Slugs |
|---|---|---|---|---|---|
| `en` | none | `en` / `en` | `en_GB` | English | — |
| `pt_BR` | `pt` | `pt-BR` / `pt-BR` | `pt_BR` | Português | translated |
| `bn` | `bn` | `bn` / `bn` | `bn_BD` | বাংলা | English, because Bengali-script URLs turn unreadable when shared |

- `x-default` is the English URL.
- Route names are `{localeKey}.{name}`, for example `pt_BR.home`.

**Content rules**

- No event date, fee, venue or contact is hard-coded in views or PHP. They come from `Edition`, `Venue` or `GeneralSettings`.
- Bangla copy shows Bangla numerals (ICU `bn_BD` does this). No `letter-spacing` on Bangla.
- **Commits:** every commit message ends with:

  ```
  Co-Authored-By: Claude Opus 5.5 <noreply@anthropic.com>
  ```

## Review Focus

| Input or condition | Expected behaviour | Pinned by |
|---|---|---|
| A visitor types an old or variant language prefix: `/pt-br`, `/PT`, `/en`, `/bn-bd` | A 301 redirect to the right language (`/pt`, `/pt`, `/`, `/bn`), not a 404 | Task 3, `test_variant_language_prefixes_redirect_permanently` |
| Trailing slash on a language root (`/pt/`) | Renders the Portuguese page | Task 3, `test_trailing_slash_on_language_root_renders_same_page` |
| A route key with no Portuguese slug yet | The Portuguese URL uses the English slug and still works; never a literal `routes.key` path | Task 3, `test_missing_portuguese_slug_falls_back_to_english_slug` |
| A fresh install with no current edition | The home page renders organiser details and "Dates to be announced" with HTTP 200, not a 500 | Task 10, `test_home_renders_without_a_current_edition` |
| An edition name not yet translated into PT or BN | The English name shows, never an empty heading | Task 6, `test_edition_name_falls_back_to_english_when_translation_missing` |

---

### Task 1: Repository, toolchain and MySQL test database

**Files:**
- Modify: `.gitignore`, `.env`, `.env.example`, `phpunit.xml`, `tests/TestCase.php`
- Delete: `tests/Feature/ExampleTest.php`, `tests/Unit/ExampleTest.php`
- Test: `tests/Feature/DatabaseConnectionTest.php`

**Interfaces:**
- Produces: a git repository with a baseline commit, a working `mysql` connection for app and tests, and `TestCase` calling `$this->withoutVite()` in `setUp()`.

- [ ] **Step 1: Check the MySQL PHP extension.** PHP 8.4's `php.ini` already enables `pdo_mysql`.

  Run: `"$PHP84" -m | grep -i pdo_mysql`
  Expected: `pdo_mysql` listed.

- [ ] **Step 2: Initialise git and make the baseline commit.**
  - Run `git init`.
  - Append `/research-assets/` to `.gitignore`. The 217 MB of client photos stay out of git; later phases copy chosen images into `resources/`.
  - Run `git add -A` and commit `chore: baseline Laravel 13 skeleton, Boost guidelines, research and design docs`.

  Expected: `git log --oneline` shows 1 commit, and `git status` is clean.

- [ ] **Step 3: Create the databases.**

  ```powershell
  & C:\xampp\mysql\bin\mysql.exe -u root -h 127.0.0.1 -P 3366 -e "CREATE DATABASE IF NOT EXISTS bbcci_expo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; CREATE DATABASE IF NOT EXISTS bbcci_expo_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
  ```

  Expected: `SHOW DATABASES LIKE 'bbcci%'` lists both.

- [ ] **Step 4: Point the app and tests at MySQL.**
  - In `.env`, set:
    - `DB_CONNECTION=mysql`, `DB_HOST=127.0.0.1`, `DB_PORT=3366`
    - `DB_DATABASE=bbcci_expo`, `DB_USERNAME=root`, `DB_PASSWORD=` (empty)
    - `APP_NAME="Made in Bangladesh Expo"`
    - `DEMO_MODE=false`
  - `.env.example` gets the same values, except the standard `DB_PORT=3306`.
  - In `phpunit.xml`, replace the sqlite lines with `<env name="DB_CONNECTION" value="mysql"/>` and `<env name="DB_DATABASE" value="bbcci_expo_test"/>`.
  - In `tests/TestCase.php`, add `setUp()` calling `parent::setUp()` and then `$this->withoutVite()`.
  - Delete both `ExampleTest.php` files and `database/database.sqlite`.

- [ ] **Step 5: Write the failing test.** `php artisan make:test --phpunit DatabaseConnectionTest`

  ```php
  use RefreshDatabase;

  public function test_tests_run_against_the_mysql_test_database(): void
  {
      $this->assertSame('mysql', DB::connection()->getDriverName());
      $this->assertSame('bbcci_expo_test', DB::connection()->getDatabaseName());
  }
  ```

- [ ] **Step 6: Migrate and run the test.**

  Run:

  ```bash
  "$PHP84" artisan migrate --no-interaction
  "$PHP84" artisan test --compact
  ```

  Expected: migrations ran on `bbcci_expo`; 1 test passes. If it fails, check Step 4's `phpunit.xml` lines first.

- [ ] **Step 7: Commit.** `chore: run app and tests on MySQL`

---

### Task 2: Locale registry

**Files:**
- Create: `config/locales.php`, `app/Support/Localization/Locale.php`, `app/Support/Localization/Locales.php`, `app/Providers/LocalizationServiceProvider.php`
- Modify: `bootstrap/providers.php`
- Test: `tests/Feature/Support/Localization/LocalesTest.php`

**Interfaces:**
- Produces:
  - `final readonly class Locale` with properties:
    - `string $key`, `?string $prefix`
    - `string $hreflang`, `string $htmlLang`, `string $icu`, `string $nativeName`
    - `bool $translatesSlugs`, `string $datePattern`
    - `array $rangeTemplates` (array shape `array{same_month: string, same_year: string, different_years: string}`)

    and `static fromConfig(string $key, array $config): self`.
  - `Locales` (container singleton):
    - `all(): array<string, Locale>` (config order)
    - `get(string $key): Locale` (throws `InvalidArgumentException` for unknown keys)
    - `has(string $key): bool`
    - `default(): Locale`
    - `current(): Locale` (from `app()->getLocale()`)
    - `fromPrefix(string $prefix): ?Locale`

- [ ] **Step 1: Write the failing tests.**
  - `test_supports_english_portuguese_and_bangla_in_that_order`: `array_keys(app(Locales::class)->all()) === ['en', 'pt_BR', 'bn']`.
  - `test_english_is_the_default_and_has_no_url_prefix`: `default()->key === 'en'` and `default()->prefix === null`.
  - `test_finds_portuguese_by_its_url_prefix`: `fromPrefix('pt')->key === 'pt_BR'` and `fromPrefix('xx') === null`.
  - `test_rejects_an_unknown_locale_key`: `expectException(InvalidArgumentException::class)`, then `get('fr')`.

- [ ] **Step 2: Run** `"$PHP84" artisan test --compact --filter=LocalesTest`. Expected: FAIL (class not found).

- [ ] **Step 3: Implement.**
  - `config/locales.php` returns `['default' => 'en', 'supported' => [...]]` with one entry per row of the Global Constraints locale table. Keys: `prefix`, `hreflang`, `html_lang`, `icu`, `native_name`, `translates_slugs`, `date_pattern`, `range`.
  - Date patterns and range templates:

    | Locale | `date_pattern` | `same_month` | `same_year` | `different_years` |
    |---|---|---|---|---|
    | en | `d MMMM yyyy` | `:d1–:d2 :month :year` | `:d1 :month1 – :d2 :month2 :year` | `:date1 – :date2` |
    | pt_BR | `d 'de' MMMM 'de' yyyy` | `:d1 a :d2 de :month de :year` | `:d1 de :month1 a :d2 de :month2 de :year` | `:date1 a :date2` |
    | bn | `d MMMM yyyy` | `:d1–:d2 :month :year` | `:d1 :month1 – :d2 :month2 :year` | `:date1 – :date2` |

    The dash in `–` is U+2013.
  - Register `Locales` as a singleton in `LocalizationServiceProvider::register()`, and add the provider to `bootstrap/providers.php`.

- [ ] **Step 4: Run the tests.** Expected: 4 pass.

- [ ] **Step 5: Pint, then commit** `feat: locale registry for en, pt_BR and bn`.

---

### Task 3: Localized routing, slugs and the locale middleware

**Files:**
- Create:
  - `app/Support/Localization/RouteSlugs.php`
  - `app/helpers.php` (add to composer.json `autoload.files`, then `composer dump-autoload` in PowerShell)
  - `app/Http/Middleware/SetLocale.php`
  - `app/Http/Controllers/RedirectLegacyLocalePrefix.php`
  - `app/Http/Controllers/HomeController.php`
  - `resources/views/components/layouts/site.blade.php`
  - `resources/views/home.blade.php`
  - `lang/en/routes.php`, `lang/pt_BR/routes.php` (both `return [];` for now; later phases add keys)
- Modify:
  - `app/Providers/LocalizationServiceProvider.php` (`Route::localized` macro in `boot()`)
  - `bootstrap/app.php` (middleware alias `locale`)
  - `routes/web.php` (replace the welcome route)
- Delete: `resources/views/welcome.blade.php`
- Test: `tests/Feature/Http/LocalizedRoutingTest.php`

**Interfaces:**
- Consumes: `Locales`, `Locale` (Task 2).
- Produces:
  - **Route macro** `Route::localized(Closure $routes): void`. It registers `$routes` once per locale inside a group with:
    - `prefix($locale->prefix ?? '')`
    - `name("{$locale->key}.")`
    - `middleware("locale:{$locale->key}")`
  - **`RouteSlugs::registerFor(string $localeKey, Closure $routes): void`** sets the locale being registered while `$routes` runs.
  - **`RouteSlugs::slug(string $key): string`** resolves the slug in this order, first match wins:
    1. The registering locale's own `routes.{$key}` line, only if that locale translates slugs and the line exists.
    2. The `en` `routes.{$key}` line, if it exists. When a translating locale falls back here, log a `Log::warning` naming the locale and key.
    3. The key itself. It never throws.
  - **Helpers:**
    - `localized_slug(string $key): string`
    - `localized_route(string $name, array $parameters = [], ?string $locale = null, bool $absolute = true): string`, which calls `route(($locale ?? app()->getLocale()).'.'.$name, …)`.
  - **Middleware `SetLocale::handle(Request $request, Closure $next, string $locale): Response`** calls:
    - `App::setLocale($locale)`
    - `Number::useLocale($icu)`
    - `Carbon::setLocale($icu)`
    - `View::share('currentLocale', $localeObject)`
  - **`RedirectLegacyLocalePrefix::__invoke(string $legacyPrefix, ?string $path = null): RedirectResponse`** issues a 301 to the target locale's prefix plus `$path`. The map is:

    | Legacy prefix | Target |
    |---|---|
    | `pt-br`, `pt-BR`, `PT`, `Pt` | `pt_BR` |
    | `en`, `EN` | `en` |
    | `bn-bd`, `bn-BD`, `BN` | `bn` |

    Register it **after** `Route::localized(...)` in `routes/web.php`, constrained with `->where('legacyPrefix', 'pt-br|pt-BR|PT|Pt|en|EN|bn-bd|bn-BD|BN')->where('path', '.*')`.
  - **Home route:** `Route::get('/', HomeController::class)->name('home')` inside `Route::localized`.
  - **Layout component** `<x-layouts.site :title="string">`: renders `<html lang="{{ $currentLocale->htmlLang }}">`, `<title>`, and `@vite(['resources/css/app.css', 'resources/js/app.js'])`, plus `{{ $slot }}`.

- [ ] **Step 1: Write the failing tests.** `make:test --phpunit Http/LocalizedRoutingTest` (move into `tests/Feature/Http/` if the generator flattens the path). In each slug test, register the test route inside the test with:

  ```php
  Lang::addLines(['routes.about' => 'sobre'], 'pt_BR');
  Route::localized(fn () => Route::get(localized_slug('about'), fn () => app()->getLocale())->name('about'));
  ```

  Tests:
  - `test_english_home_renders_at_the_root`: `get('/')`, status 200, `assertSee('<html lang="en"', false)`.
  - `test_portuguese_home_renders_under_pt`: `get('/pt')`, `assertSee('<html lang="pt-BR"', false)`.
  - `test_bangla_home_renders_under_bn`: `get('/bn')`, `assertSee('<html lang="bn"', false)`.
  - `test_trailing_slash_on_language_root_renders_same_page`: `get('/pt/')`, status 200, `lang="pt-BR"`.
  - `test_variant_language_prefixes_redirect_permanently`, with a data provider of cases:

    | Request | Location |
    |---|---|
    | `/pt-br` | `/pt` |
    | `/PT` | `/pt` |
    | `/en` | `/` |
    | `/bn-bd` | `/bn` |
    | `/pt-br/sobre` | `/pt/sobre` |

    Each case asserts `assertStatus(301)` and `assertRedirect(url($expected))`.
  - `test_translated_slugs_resolve_in_each_locale`:
    - `get('/pt/sobre')` sees `pt_BR`
    - `get('/about')` sees `en`
    - `get('/bn/about')` sees `bn`
  - `test_missing_portuguese_slug_falls_back_to_english_slug`: `Lang::addLines(['routes.press' => 'press'], 'en')` (no pt line), then register `press`; `get('/pt/press')` sees `pt_BR`.
  - `test_locale_does_not_leak_between_requests`: `get('/bn')`, then `get('/')`, and the second response has `lang="en"`.
  - `test_localized_route_builds_prefixed_urls`:
    - `localized_route('home', locale: 'bn') === url('/bn')`
    - `localized_route('home', locale: 'en') === url('/')`

- [ ] **Step 2: Run** `--filter=LocalizedRoutingTest`. Expected: FAIL.

- [ ] **Step 3: Implement** the interfaces above.
  - `HomeController` (invokable) returns `view('home')` for now.
  - `home.blade.php` uses `<x-layouts.site :title="config('app.name')">` with an `<h1>{{ config('app.name') }}</h1>`. Task 10 replaces the content.

- [ ] **Step 4: Run the tests.** Expected: all pass. Also run `"$PHP84" artisan route:list --except-vendor`; expected: `en.home`, `pt_BR.home` and `bn.home` at `/`, `pt` and `bn`.

- [ ] **Step 5: Pint, then commit** `feat: localized routing with translated slugs and legacy prefix redirects`.

---

### Task 4: hreflang alternates and the language switcher

**Files:**
- Create:
  - `app/Support/Localization/LocalizedUrls.php`
  - `resources/views/components/seo/alternates.blade.php`
  - `resources/views/components/locale-switcher.blade.php`
- Modify: `resources/views/components/layouts/site.blade.php`, plus `lang/{en,pt_BR,bn}/site.php` (create with key `language`: `Language` / `Idioma` / `ভাষা`)
- Test: `tests/Feature/Support/Localization/LocalizedUrlsTest.php`

**Interfaces:**
- Consumes: `Locales`, `localized_route`, route names `{locale}.{name}` (Task 3).
- Produces: `LocalizedUrls` with:
  - **`alternates(): array<string, string>`**: an hreflang-keyed map of absolute URLs for the current route in every locale, plus `'x-default'` set to the `en` URL.
  - **`switcher(): list<array{locale: Locale, url: string, isCurrent: bool}>`**
  - Both take the base name by stripping `{locale}.` from the current route name and reuse `request()->route()->parameters()`. Both return `[]` when the current route is not localized.
- Components:
  - `<x-seo.alternates />` prints `<link rel="alternate" hreflang="…" href="…">` per entry.
  - `<x-locale-switcher />` prints a `<nav aria-label="{{ __('site.language') }}">`. In it, each link has `lang="{{ $locale->htmlLang }}"` and `hreflang`, and the current locale's link has `aria-current="true"`. Each link's text is the locale's `nativeName`.
  - The layout includes both components.

- [ ] **Step 1: Write the failing tests.** Use the same test-route registration as Task 3.
  - `test_home_lists_an_alternate_link_for_every_locale_and_x_default`: `get('/pt')` sees (unescaped):
    - `hreflang="en" href="http://localhost"`
    - `hreflang="pt-BR" href="http://localhost/pt"`
    - `hreflang="bn" href="http://localhost/bn"`
    - `hreflang="x-default" href="http://localhost"`
  - In every test that registers a route at runtime, call `Route::getRoutes()->refreshNameLookups()` straight after registering, so named-route URL generation sees it.
  - `test_switcher_links_to_the_same_page_in_other_languages_and_marks_the_current_one`: register `about` with pt slug `sobre`, then `get('/pt/sobre')`:
    - `assertSee('href="http://localhost/about"', false)`
    - `assertSee('href="http://localhost/bn/about"', false)`
    - exactly one `aria-current="true"` in the HTML
    - the HTML matches `/<a[^>]*href="http:\/\/localhost\/pt\/sobre"[^>]*aria-current="true"[^>]*>\s*Português/u`
  - `test_alternates_are_empty_on_a_route_that_is_not_localized`: a plain `Route::get('/plain', fn () => json_encode(app(LocalizedUrls::class)->alternates()))`; response body `[]`.

- [ ] **Step 2: Run, expect FAIL. Step 3: Implement. Step 4: Run, expect PASS.**

- [ ] **Step 5: Pint, then commit** `feat: hreflang alternates and language switcher`.

---

### Task 5: Locale-aware numbers, dates and date ranges

**Files:**
- Create: `app/Support/Localization/LocaleFormatter.php`
- Test: `tests/Feature/Support/Localization/LocaleFormatterTest.php`

**Interfaces:**
- Consumes: `Locales` (`icu`, `datePattern`, `rangeTemplates`).
- Produces: `LocaleFormatter` with:
  - `number(int|float $value, ?string $locale = null): string`
  - `date(CarbonInterface $date, ?string $locale = null): string`
  - `dateRange(CarbonInterface $start, CarbonInterface $end, ?string $locale = null): string`
  - `$locale` is a locale key; `null` means the current locale.

**The algorithm.** Use `IntlDateFormatter` with the locale's `icu` and the date's own timezone:

1. Format the day with pattern `d`, the month with `MMMM`, and the year with `yyyy`. Each part comes out in the locale's numerals.
2. Choose a template:
   - `same_month` when the start and end month and year match
   - `same_year` when only the year matches
   - otherwise `different_years`, with `:date1`/`:date2` produced by `date()`
3. A range whose start and end fall on the same day returns `date($start)`.
4. Fill the placeholders with `strtr`.

- [ ] **Step 1: Write the failing tests.** Use data providers; expected strings verified against ICU 77.1 on this machine.

  `test_formats_numbers_with_each_locales_digits_and_grouping`:

  | Locale | 1234567 | 4000 |
  |---|---|---|
  | en | `1,234,567` | `4,000` |
  | pt_BR | `1.234.567` | `4.000` |
  | bn | `১২,৩৪,৫৬৭` | `৪,০০০` |

  `test_formats_a_single_date` (2027-03-22):

  | Locale | Expected |
  |---|---|
  | en | `22 March 2027` |
  | pt_BR | `22 de março de 2027` |
  | bn | `২২ মার্চ ২০২৭` |

  `test_formats_date_ranges` (locale, start, end → expected):

  | Locale | Start | End | Expected |
  |---|---|---|---|
  | en | 2027-03-22 | 2027-03-25 | `22–25 March 2027` |
  | pt_BR | 2027-03-22 | 2027-03-25 | `22 a 25 de março de 2027` |
  | bn | 2027-03-22 | 2027-03-25 | `২২–২৫ মার্চ ২০২৭` |
  | en | 2027-03-29 | 2027-04-02 | `29 March – 2 April 2027` |
  | pt_BR | 2027-03-29 | 2027-04-02 | `29 de março a 2 de abril de 2027` |
  | bn | 2027-03-29 | 2027-04-02 | `২৯ মার্চ – ২ এপ্রিল ২০২৭` |
  | en | 2026-12-30 | 2027-01-02 | `30 December 2026 – 2 January 2027` |
  | pt_BR | 2026-12-30 | 2027-01-02 | `30 de dezembro de 2026 a 2 de janeiro de 2027` |
  | bn | 2026-12-30 | 2027-01-02 | `৩০ ডিসেম্বর ২০২৬ – ২ জানুয়ারী ২০২৭` |
  | en | 2027-03-22 | 2027-03-22 | `22 March 2027` |

  `test_uses_the_current_locale_when_none_is_given`: `app()->setLocale('bn')`, then `number(10) === '১০'`.

- [ ] **Step 2: Run, expect FAIL. Step 3: Implement. Step 4: Run, expect PASS.**

- [ ] **Step 5: Pint, then commit** `feat: locale-aware number and date formatting with Bangla numerals`.

---

### Task 6: Editions and venues

**Files:**
- Install (PowerShell): `composer require spatie/laravel-translatable:^6.15`
- Create (via `make:model -mf`, `make:enum`, `make:class`, `make:seeder`):
  - `app/Enums/EditionStatus.php`
  - `app/Models/Venue.php`, `app/Models/Edition.php`
  - migrations `create_venues_table` and `create_editions_table`
  - `database/factories/VenueFactory.php`, `database/factories/EditionFactory.php`
  - `app/Support/Editions/CurrentEdition.php`
  - `database/seeders/EditionSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php` (call `EditionSeeder`), `app/Providers/AppServiceProvider.php` (`scoped` binding of `CurrentEdition`)
- Test: `tests/Feature/Models/EditionTest.php`, `tests/Feature/Support/Editions/CurrentEditionTest.php`

**Schema**

`venues`:

| Column | Type |
|---|---|
| `id` | primary key |
| `name` | string |
| `address_line` | nullable string |
| `district` | nullable string |
| `city` | string |
| `state` | nullable string(2) |
| `postal_code` | nullable string |
| `country_code` | char(2) |
| `latitude` | nullable decimal(10,7) |
| `longitude` | nullable decimal(10,7) |
| timestamps | |

`editions`:

| Column | Type |
|---|---|
| `id` | primary key |
| `venue_id` | nullable FK → venues, null on delete |
| `slug` | string, unique |
| `number` | unsignedSmallInteger |
| `name` | json |
| `starts_on` | date |
| `ends_on` | date |
| `opening_at` | nullable timestampTz |
| `timezone` | string, default `America/Sao_Paulo` |
| `status` | string |
| `is_current` | boolean, default false |
| timestamps | |

| `current_marker` | nullable unsignedTinyInteger, `storedAs('if(is_current, 1, null)')`, unique index named `editions_single_current` |

MySQL has no partial indexes. `current_marker` is 1 for the current edition and NULL for every other one. A unique index allows any number of NULLs, so it permits at most one current edition. The column is generated: add it to the model's `$guarded` and `$hidden`, and never write it.

**Interfaces:**
- Produces:
  - `enum EditionStatus: string` with cases `Draft = 'draft'`, `Announced = 'announced'`, `RegistrationOpen = 'registration_open'`, `Closed = 'closed'`, `Archived = 'archived'`.
  - `Edition` model:
    - `use HasTranslations; public array $translatable = ['name'];`
    - casts: `starts_on` and `ends_on` as `immutable_date`, `opening_at` as `immutable_datetime`, `status` as `EditionStatus`, `is_current` as `boolean`
    - `venue(): BelongsTo`
    - `openingAtIn(string $timezone): ?CarbonImmutable`
    - `scopeCurrent(Builder $query): void`
  - `EditionFactory` with states `current()` and `archived()`.
  - `CurrentEdition::get(): ?Edition`, memoised per request (with `venue` eager-loaded).

- [ ] **Step 1: Write the failing tests.**

  `EditionTest`:
  - `test_only_one_edition_can_be_current`: create a `current()` edition, then `expectException(QueryException::class)` and create a second `current()` edition.
  - `test_opening_time_is_shown_in_sao_paulo_and_dhaka`: `opening_at` = `2027-03-22 13:00:00` UTC.
    - `openingAtIn('America/Sao_Paulo')->format('Y-m-d H:i') === '2027-03-22 10:00'`
    - `openingAtIn('Asia/Dhaka')->format('Y-m-d H:i') === '2027-03-22 19:00'`
  - `test_edition_name_falls_back_to_english_when_translation_missing`: name `['en' => 'Made in Bangladesh Expo 2026']`; `app()->setLocale('bn')`, then `$edition->name === 'Made in Bangladesh Expo 2026'`.

  `CurrentEditionTest`:
  - `test_returns_the_edition_marked_current`: one archived and one current; `get()->is($current)`.
  - `test_returns_null_when_no_edition_is_current`.
  - `test_seeder_creates_the_2025_archive_and_the_current_2026_edition`: `seed(EditionSeeder::class)` twice (idempotent), then assert:
    - 2 editions
    - current slug `2026`, `starts_on` `2027-03-22`, `ends_on` `2027-03-25`
    - venue name `Pro Magno Centro de Eventos`
    - bn name `মেইড ইন বাংলাদেশ এক্সপো ২০২৬`

- [ ] **Step 2: Run, expect FAIL.**

- [ ] **Step 3: Implement.** Seeder values from spec §4, using `updateOrCreate` on `slug` for idempotency:

  | Field | 2025 | 2026 |
  |---|---|---|
  | slug | `2025` | `2026` |
  | number | 1 | 2 |
  | name (en, pt_BR) | `Made in Bangladesh Expo 2025` | `Made in Bangladesh Expo 2026` |
  | name (bn) | `মেইড ইন বাংলাদেশ এক্সপো ২০২৫` | `মেইড ইন বাংলাদেশ এক্সপো ২০২৬` |
  | starts_on – ends_on | 2025-06-15 – 2025-06-18 | 2027-03-22 – 2027-03-25 |
  | opening_at | null | 2027-03-22 10:00 `America/Sao_Paulo` |
  | status | Archived | Announced |
  | is_current | false | true |
  | venue name | `Novotel São Paulo Center Norte` | `Pro Magno Centro de Eventos` |
  | venue address | — | `Av. Professora Ida Kolb, 513`, district `Casa Verde` |
  | venue city, state, country | `São Paulo`, `SP`, `BR` | `São Paulo`, `SP`, `BR` |

- [ ] **Step 4: Run, expect PASS.** Then run `"$PHP84" artisan migrate:fresh --seed --no-interaction` on the dev database; expected: no errors.

- [ ] **Step 5: Pint, then commit** `feat: editions and venues with the 2026 working values`.

---

### Task 7: General settings (organiser contacts)

**Files:**
- Install (PowerShell): `composer require spatie/laravel-settings:^3.9`, then publish its config and migration per the package README (`composer show spatie/laravel-settings` to confirm the version first).
- Create:
  - `app/Settings/GeneralSettings.php`
  - `database/settings/2026_10_19_000001_create_general_settings.php` (`make:settings-migration`)
- Test: `tests/Feature/Settings/GeneralSettingsTest.php`

**Interfaces:**
- Produces: `GeneralSettings extends Spatie\LaravelSettings\Settings` with group `general` and these properties:
  - `public string $organiser_name`, `$organiser_short_name`, `$office_address`
  - `$phone` (display form), `$whatsapp_number` (digits only, for `wa.me`), `$email`
  - `public ?string $dpo_name`, `$dpo_email`

- [ ] **Step 1: Write the failing test.** `test_ships_with_the_bbcci_contact_details`. After `RefreshDatabase` has migrated, resolve `app(GeneralSettings::class)` and assert:
  - `organiser_name === 'Brazil Bangladesh Chamber of Commerce & Industry'`
  - `organiser_short_name === 'BBCCI'`
  - `office_address === 'Shanta Skymark, 18 Gulshan Avenue, Dhaka-1212, Bangladesh'`
  - `phone === '+880 1553 676767'`
  - `whatsapp_number === '8801553676767'`
  - `email === 'sg@brazilbangladeshchamber.com'`
  - `dpo_name === null`

- [ ] **Step 2: Run, expect FAIL. Step 3: Implement** the settings class, and a settings migration that `add`s exactly those values. **Step 4: Run, expect PASS.**

- [ ] **Step 5: Pint, then commit** `feat: general settings with BBCCI contact details`.

---

### Task 8: Staff roles

**Files:**
- Install (PowerShell): `composer require spatie/laravel-permission:^8.3`, then publish its config and migration per the package README and migrate.
- Create: `app/Enums/StaffRole.php`, `database/seeders/StaffRoleSeeder.php`
- Modify: `app/Models/User.php` (`use HasRoles`), `database/seeders/DatabaseSeeder.php` (call `StaffRoleSeeder`)
- Test: `tests/Feature/Seeders/StaffRoleSeederTest.php`

**Interfaces:**
- Produces: `enum StaffRole: string` with these cases:

  | Case | Value |
  |---|---|
  | `SuperAdmin` | `super_admin` |
  | `Sales` | `sales` |
  | `Finance` | `finance` |
  | `VisaDesk` | `visa_desk` |
  | `LetterSignatory` | `letter_signatory` |
  | `ContentEditor` | `content_editor` |
  | `CheckInOperator` | `check_in_operator` |
  | `Viewer` | `viewer` |

  `StaffRoleSeeder` creates one `web`-guard role per case with `Role::findOrCreate`.

- [ ] **Step 1: Write the failing tests.**
  - `test_creates_one_role_per_staff_role`: after seeding, role names sorted equal the `StaffRole` values sorted.
  - `test_running_twice_does_not_duplicate_roles`: count is 8 after two runs.
  - `test_a_user_can_hold_a_staff_role`: `User::factory()->create()->assignRole(StaffRole::Finance->value)`, then `hasRole('finance')` is true.

- [ ] **Step 2: Run, expect FAIL. Step 3: Implement. Step 4: Run, expect PASS.**

- [ ] **Step 5: Pint, then commit** `feat: staff roles`.

---

### Task 9: Demo mode

**Files:**
- Create:
  - `config/expo.php` with `'demo_mode' => (bool) env('DEMO_MODE', false)`
  - `app/Http/Middleware/AddNoindexHeaderInDemoMode.php`
  - `resources/views/components/demo-ribbon.blade.php`
- Modify:
  - `bootstrap/app.php` (append the middleware to the `web` group)
  - layout (render `<x-demo-ribbon />` first in `<body>`)
  - `lang/{en,pt_BR,bn}/site.php` (`demo_ribbon`: `Demonstration site` / `Site de demonstração` / `ডেমো সাইট`)
- Test: `tests/Feature/Http/DemoModeTest.php`

**Interfaces:**
- Produces: the middleware sets `X-Robots-Tag: noindex, nofollow` on every web response when `config('expo.demo_mode')` is true. `<x-demo-ribbon />` renders `<div role="note" class="demo-ribbon">{{ __('site.demo_ribbon') }}</div>` only in demo mode.

- [ ] **Step 1: Write the failing tests.**
  - `test_demo_mode_marks_pages_noindex_and_shows_the_ribbon`: `config(['expo.demo_mode' => true])`; `get('/pt')` has `assertHeader('X-Robots-Tag', 'noindex, nofollow')` and `assertSee('Site de demonstração')`.
  - `test_without_demo_mode_pages_are_indexable_and_show_no_ribbon`: `assertHeaderMissing('X-Robots-Tag')` and `assertDontSee('demo-ribbon')`.

- [ ] **Step 2: Run, expect FAIL. Step 3: Implement. Step 4: Run, expect PASS.**

- [ ] **Step 5: Pint, then commit** `feat: demo mode flag with noindex header and ribbon`.

---

### Task 10: Data-driven home page in three languages

**Files:**
- Modify: `app/Http/Controllers/HomeController.php`, `resources/views/home.blade.php`, `lang/{en,pt_BR,bn}/site.php`
- Test: `tests/Feature/Http/HomePageTest.php`

**Interfaces:**
- Consumes: `CurrentEdition::get()` (Task 6), `LocaleFormatter::dateRange()` (Task 5), `GeneralSettings` (Task 7), the layout and components (Tasks 3, 4, 9).
- Produces: `HomeController::__invoke(CurrentEdition $currentEdition, LocaleFormatter $formatter, GeneralSettings $settings): View`. It passes:
  - `edition` (`?Edition`)
  - `dateRange` (`?string`)
  - `settings`

  The view renders:
  - `<h1>` with the edition name, or `config('app.name')` when there's no current edition
  - a `<p>` with the date range or `__('site.dates_to_be_announced')`
  - the venue's `name, city`
  - `__('site.organised_by', ['organiser' => $settings->organiser_name])`
  - the phone number

  New `site.php` strings:

  | Key | en | pt_BR | bn |
  |---|---|---|---|
  | `organised_by` | `Organised by :organiser` | `Organizado por :organiser` | `আয়োজক: :organiser` |
  | `dates_to_be_announced` | `Dates to be announced` | `Datas a anunciar` | `তারিখ শিগগিরই ঘোষণা করা হবে` |

- [ ] **Step 1: Write the failing tests.** Use `Edition::factory()->current()` with the seeder's 2026 values, built through the factory and a `Venue` named `Pro Magno Centro de Eventos`, city `São Paulo`.
  - `test_english_home_shows_the_current_edition_dates_venue_and_organiser`: sees `Made in Bangladesh Expo 2026`, `22–25 March 2027`, `Pro Magno Centro de Eventos, São Paulo`, `Organised by Brazil Bangladesh Chamber of Commerce & Industry` (raw `&`; `assertSee` escapes it), `+880 1553 676767`.
  - `test_portuguese_home_shows_the_portuguese_date_range`: `get('/pt')` sees `22 a 25 de março de 2027`.
  - `test_bangla_home_shows_the_bangla_name_and_bangla_numerals`: `get('/bn')` sees `মেইড ইন বাংলাদেশ এক্সপো ২০২৬` and `২২–২৫ মার্চ ২০২৭`.
  - `test_home_renders_without_a_current_edition`: no editions; `get('/')` is 200 and sees `Dates to be announced` and `Organised by`.

- [ ] **Step 2: Run, expect FAIL. Step 3: Implement. Step 4: Run, expect PASS.**

- [ ] **Step 5: Pint, then commit** `feat: data-driven home page in English, Portuguese and Bangla`.

---

### Task 11: Phase gate

- [ ] **Step 1: Run the full suite and style check.** Run `"$PHP84" artisan test --compact`; expected: all green, 0 failures. Then run `vendor/bin/pint --format agent`; expected: no changes left.

- [ ] **Step 2: Seed and serve.**
  - Run `"$PHP84" artisan migrate:fresh --seed --no-interaction`, then `npm run build`.
  - Restart the dev server: stop any running `artisan serve`, then run `"$PHP84" artisan serve --host=127.0.0.1 --port=8000` in the background.

- [ ] **Step 3: Check the three languages in the browser.**
  - Open `http://127.0.0.1:8000/`, `/pt` and `/bn` in Chrome. Each shows the edition name, date range and venue in its language (Bangla numerals on `/bn`).
  - The language switcher moves between them on the same page.
  - `/pt-br` redirects to `/pt`.
  - Show the user.

- [ ] **Step 4: Record the gate.** Commit any fixes, then tell the user Phase 0 is complete and that Phase 1's plan (design system and style tiles) is next.
