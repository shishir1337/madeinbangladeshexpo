# Phase 1: Design System and Site Shell Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** every later page is *assembled* from a finished design system and a site shell (header with mega-menu, mobile drawer, footer, announcement bar, help button) that already looks better than the competitor's, in EN, PT-BR and BN.

**Architecture:**

- Tailwind 4 design tokens in `resources/css/app.css` (`@theme`), self-hosted variable fonts, an SVG motif set.
- Anonymous Blade components under `resources/views/components/ui/…` for primitives, `…/site/…` for the shell.
- Alpine (bundled with Livewire 4) for menus, drawer, tabs and accordions; GSAP + ScrollTrigger for reveals; Lenis on marketing pages only.
- A navigation registry (`App\Support\Navigation\SiteNavigation`) that lists every page by route name. It shows only the links whose route exists, so the shell is complete now and pages light up as later phases add them.
- An artisan image pipeline (`expo:images`, PHP GD) turns BBCCI's raw photos into responsive AVIF/WebP/JPEG sets in `public/img/`, and a `<x-ui.img>` component renders them with `srcset`, `width` and `height`.

**Tech stack:** Laravel 13, Livewire ^4.4 (Alpine bundled), Tailwind 4, GSAP 3.15, Lenis 1.3, `@fontsource-variable` Inter, Anek Bangla and Noto Sans Bengali.

**Spec:** `docs/superpowers/specs/2026-10-19-made-in-bangladesh-expo-portal-design.md` (§5A site-wide, §5P, §6). **Master plan:** Phase 1, re-ordered by the user on 2026-10-19 (see the master plan's "Re-prioritisation" section).

## Global Constraints

- Everything in Phase 0's Global Constraints still holds: the PHP 8.4 path, Composer from PowerShell with the sandbox off, MySQL on port 3366, PHPUnit, Pint, the commit trailer, and no hard-coded event facts.
- **Palette (spec §6):**

  | Token | Hex |
  |---|---|
  | `cream` | `#FBF7EE` |
  | `ink` | `#1F2A44` |
  | `navy` | `#002776` |
  | `green` | `#004F3A` |
  | `yellow` | `#FFDF00` |
  | `crimson` | `#B3122A` |
  | `midnight` | `#071A33` |
  | `mint` | `#3DDC97` |

  - Yellow is used for fills only, with navy text. Raw flag colours are never text on white.
- **Type:**
  - Display: Anek Bangla. Body: Inter for Latin, Noto Sans Bengali for Bangla.
  - `:lang(bn)` sets about 1.08× size, line-height 1.75 and no letter-spacing.
- **Motion:**
  - No pinned or scroll-jacked sections.
  - Reduced motion is respected through the OS setting and a footer toggle.
  - Every auto-moving element has a pause control.
  - Bangla text is never split into characters.
- **Accessibility:**
  - Skip link; focus ring on every control; targets at least 24 px.
  - Menus, the drawer and dialogs are keyboard-operable with focus trap and return.
  - `aria-expanded` and `aria-current` are kept accurate.
- **Responsive:** no horizontal scroll from 320 to 2560 px; safe-area insets respected.
- **Dependencies added this phase** (the user delegated these calls on 2026-10-19):
  - Composer: `livewire/livewire:^4.4`.
  - npm: `@fontsource-variable/inter`, `@fontsource-variable/anek-bangla`, `@fontsource-variable/noto-sans-bengali`, `gsap`, `lenis`.

## Review Focus

| Input or condition | Expected behaviour | Pinned by |
|---|---|---|
| A nav entry whose page does not exist yet | It is left out of the header, drawer and footer. No `RouteNotFoundException` and no dead link | Task 3, `test_links_to_pages_that_do_not_exist_yet_are_hidden` |
| Bangla page | Nav, footer and announcement are in Bangla, with Bangla numerals in the date | Task 4, `test_shell_is_fully_translated_in_bangla` |
| A photo key missing from the image manifest | `<x-ui.img>` renders nothing and logs a warning, not a 500 | Task 2, `test_unknown_image_renders_nothing` |
| No current edition | The announcement bar is hidden, and the shell still renders | Task 4, `test_announcement_hidden_without_current_edition` |
| JS disabled | Nav links are still reachable: the mega-menu panels are `<details>`-free plain links in the drawer, and the footer lists every page | Task 4, `test_footer_lists_every_available_page` |

---

### Task 1: Toolchain, tokens, fonts and motif

**Files:**
- Install: the Composer and npm dependencies above.
- Modify: `resources/css/app.css`, `resources/js/app.js`, `vite.config.js` (if needed), `resources/views/components/layouts/site.blade.php`.
- Create:
  - `resources/css/{tokens,base,components,motion}.css`, imported by `app.css`
  - `resources/js/{motion,shell}.js`
  - `resources/views/components/ui/motif.blade.php` (variants `jamdani`, `tiles`, `band`)
  - `resources/views/components/ui/icon.blade.php` (inline Lucide paths, ISC licence)
- Test: `tests/Feature/View/DesignSystemTest.php`

**Decisions:**
- **`@theme` tokens:** the palette above plus tints:
  - `cream-2 #F4EDDD`, `sand #E6DCC6`
  - `ink-soft #4A5468` (6.9:1 on cream)
  - `navy-700 #0B3A8C`, `green-700 #0A6B4F`, `green-50 #E6F2EC`, `midnight-2 #0E2A4F`
- **Font stacks:**
  - `--font-display`: 'Anek Bangla Variable'
  - `--font-sans`: 'Inter Variable', then 'Noto Sans Bengali Variable'
  - `:lang(bn) body`: Noto Sans Bengali first
- **Fluid type scale** with `clamp()`. Radii `--radius-card: 1.25rem`. Shadows are soft and warm (ink at 6–10%).
- **Motif:** inline SVG `<pattern>`.
  - *jamdani*: a stepped lozenge buti on a diagonal grid.
  - *tiles*: an Athos Bulcão-style 2×2 module of quarter-circles and triangles.
  - *band*: a 24 px divider strip.
  - Colour comes from `currentColor` plus CSS variables, so one motif works on cream and on midnight.
- **`app.js`:**
  - imports Livewire's ESM build and starts it (Alpine plus its bundled plugins)
  - `motion.js`: `[data-reveal]` fade-up with ScrollTrigger; `[data-count-to]` counters formatted with `Intl.NumberFormat(document.documentElement.lang)`
  - Lenis only when `<body data-smooth>` is set and motion is allowed
  - the reduced-motion preference is stored in `localStorage` (`mbe.motion`) and mirrored as `html[data-motion="reduced"]`
- **Layout `<head>`:** the font preload for display Latin, `<meta name="theme-color" content="#004F3A">` and the favicon set (from the BBCCI logo files).

- [ ] **Step 1: Write the failing test.** `test_layout_loads_the_design_system`: `get('/')` sees `class="font-sans` on `<body>` and `id="skip-to-content"`. `test_motif_component_renders_an_svg_pattern`: `Blade::render('<x-ui.motif variant="jamdani" />')` contains `<pattern`.
- [ ] **Step 2: Run, expect FAIL.**
- [ ] **Step 3: Install the dependencies and implement.**
- [ ] **Step 4: Run, expect PASS.** `npm run build` succeeds.
- [ ] **Step 5: Commit** `feat: design tokens, fonts, motif and motion layer`.

### Task 2: Image pipeline and `<x-ui.img>`

**Files:**
- Create:
  - `app/Console/Commands/ProcessImages.php` (`expo:images`)
  - `config/images.php` (the source list: key → research-assets path, alt per locale in lang, focal point)
  - `app/Support/Images/ImageManifest.php`
  - `resources/views/components/ui/img.blade.php`
  - `public/img/manifest.json` (generated)
- Test: `tests/Feature/Images/ProcessImagesTest.php`, `tests/Feature/View/ImgComponentTest.php`

**Decisions:**
- The command reads `config('images.sources')`. Each entry is `[key => ['path' => …, 'focus' => [x, y] (0–1, default centre), 'ratio' => null|'16:9'|…]]`.
- It writes `public/img/{key}-{width}.{avif,webp,jpg}` for widths `[480, 800, 1200, 1600, 2400]`, never upscaling. Quality: AVIF 52, WebP 78, JPEG 80. It raises `memory_limit` to 1G during the run and skips outputs that are already up to date.
- It writes `manifest.json` as `{key: {w, h, widths: [...]}}`.
- `ImageManifest::get(string $key): ?array` reads the manifest once per request.
- `<x-ui.img key="…" alt="…" sizes="…" :eager="false" class="…">` renders `<picture>` with AVIF and WebP `<source>`s plus a JPEG `<img>` carrying `width`, `height`, `loading`, `decoding="async"` and `fetchpriority="high"` when eager. When the key is unknown it renders nothing and calls `Log::warning`.
- **Initial sources** (from `research-assets/bbcci/images`):
  - Expo 2025 photos: `expo-2025/2025-07_DSC0*.jpg` (12), `2025-07_1-34.jpg`, `2026-05_1-46.jpg`
  - Leadership portraits: `people/*.png`
  - Event photos: `events/2024-03_S-*.jpg`, `events/2024-04_IMG_8*.jpg`
  - BBCCI logo: `logo/2024-04_BBCCI-Logo.jpg`
  - Keys are short slugs (`expo25-opening`, `expo25-floor-1`, …).

- [ ] **Step 1: Write the failing tests.**
  - `test_processes_a_source_into_responsive_formats`: a fixture 1000×600 JPEG made with GD in the test's temp dir and pointed to by `config`. After `artisan expo:images`, the AVIF, WebP and JPEG files exist at 480 and 800 (not 1200: never upscale), and the manifest has `w=1000`, `h=600`.
  - `test_img_component_renders_picture_with_dimensions`: a manifest entry is faked via `ImageManifest` binding. The output contains `type="image/avif"`, `srcset=`, `width="1000"` and `height="600"`.
  - `test_unknown_image_renders_nothing`.
- [ ] **Step 2: FAIL. Step 3: Implement, then run `expo:images` for real** (the output is committed). **Step 4: PASS.**
- [ ] **Step 5: Commit** `feat: responsive image pipeline for BBCCI photography`.

### Task 3: Navigation registry

**Files:**
- Create: `app/Support/Navigation/SiteNavigation.php`, `lang/{en,pt_BR,bn}/nav.php`
- Test: `tests/Feature/Support/Navigation/SiteNavigationTest.php`

**Decisions:**
- `SiteNavigation::primary(): list<array{key: string, label: string, items: list<array{route: string, label: string, description: string}>, feature?: string}>` returns four groups:
  - **the-expo:** about, organiser, committee, sectors, programme, speakers, partners, archive-2025
  - **take-part:** exhibit, stand-packages, apply, deadlines, payment, visit, sponsorship, register
  - **plan-your-trip:** venue, city-guide, hotels, travel
  - **news-media:** news, press, downloads, gallery
  - plus a top-level `contact`.
- It drops items whose `"{locale}.{route}"` does not exist, and groups that end up empty.
- `SiteNavigation::footer()` returns the same groups plus legal (privacy, terms, refunds, cookies, accessibility).
- Labels and descriptions come from `nav.php`.

- [ ] **Step 1: Write the failing tests.**
  - `test_links_to_pages_that_do_not_exist_yet_are_hidden`: with only `home` registered, `primary()` returns no groups except those with registered routes. Register a test route `about` → the-expo has 1 item.
  - `test_labels_follow_the_current_locale`.
- [ ] **Step 2: FAIL. Step 3: Implement. Step 4: PASS. Step 5: Commit** `feat: navigation registry that only links existing pages`.

### Task 4: Site shell

**Files:**
- Create, under `resources/views/components/site/`:
  - `announcement.blade.php`, `header.blade.php`, `mega-menu.blade.php`, `drawer.blade.php`, `footer.blade.php`
  - `help-button.blade.php`, `language-menu.blade.php` (a dropdown wrapper around the Phase 0 switcher data), `logo.blade.php`
- Modify: `components/layouts/site.blade.php`; `lang/*/site.php`.
- Test: `tests/Feature/View/SiteShellTest.php`

**Decisions:**
- **Announcement bar:**
  - Shows the current edition's date range (`LocaleFormatter`) and venue, plus a "Register" link once that route exists.
  - Dismiss is remembered in `localStorage` for this edition.
  - Hidden when there is no current edition.
- **Header:**
  - Sticky; cream with a blur, and it compacts after 24 px of scroll.
  - Logo (expo mark plus wordmark "Made in Bangladesh Expo" / "São Paulo · 2026"), the primary groups as buttons opening mega-menu panels, the language menu, and a secondary "Register" and primary "Apply to exhibit" when those routes exist.
  - **Mega-menu panel:** a link list with descriptions and a feature card (dates, venue, countdown text).
  - Escape and outside click close it; arrow keys move between items.
- **Drawer (below 1024 px):**
  - Full-height sheet with accordion groups, language, CTAs and contacts.
  - Focus is trapped while open and the body is scroll-locked.
- **Footer:**
  - Midnight background with the jamdani motif band.
  - Columns from `SiteNavigation::footer()`.
  - Organiser block from `GeneralSettings`: name, address, phone as `tel:`, email, and WhatsApp as `wa.me/{whatsapp_number}`.
  - Plus the "Reduce motion" toggle, the language links and © year.
- **Help button:** a WhatsApp floating button bottom-right. `main` gets bottom padding on mobile so the button never covers content (spec §6, WCAG 2.4.11).
- **Skip link** to `#main`.

- [ ] **Step 1: Write the failing tests.**
  - `test_shell_renders_header_footer_and_skip_link`: sees `href="#main"`, `<header`, `<footer` and the organiser email from settings.
  - `test_announcement_shows_the_edition_dates`: with the current edition seeded, sees `22–25 March 2027`.
  - `test_announcement_hidden_without_current_edition`.
  - `test_shell_is_fully_translated_in_bangla`: `/bn` with an edition sees `২২–২৫ মার্চ ২০২৭` and the Bangla footer heading. It does not see the English `Organised by`.
  - `test_footer_lists_every_available_page`: every `SiteNavigation::footer()` route appears as an `href`.
  - `test_whatsapp_link_uses_digits_only_number`: sees `https://wa.me/8801553676767`.
- [ ] **Step 2: FAIL. Step 3: Implement. Step 4: PASS.**
- [ ] **Step 5: Commit** `feat: site shell with mega-menu, drawer, footer and help button`.

### Task 5: UI primitives and the style guide

**Files:**
- Create, in `resources/views/components/ui/`:
  - `button`, `link`, `section`, `heading`, `card`, `stat`, `chip`, `tabs`, `tab`, `accordion`, `accordion-item`
  - `breadcrumbs`, `page-hero`, `facts`, `steps`, `notice`
- Create: `resources/views/styleguide.blade.php`, plus a `/_styleguide` route available only when `app()->isLocal()` or demo mode is on.
- Test: `tests/Feature/View/UiComponentsTest.php`

**Decisions:**
- **Button:**
  - Variants `primary` (green), `secondary` (outline navy), `ghost`, `highlight` (yellow with navy text), `on-dark`.
  - Sizes `sm`, `md`, `lg`.
  - Renders `<a>` when `href` is given, otherwise `<button>`.
- **Section:** tones `cream`, `white`, `sand`, `midnight`, `green`, plus spacing `sm`/`md`/`lg` and an optional motif edge.
- **Page hero:** three types for the different page templates (spec §6), so pages don't all look alike:
  - `editorial`: light, big type, optional photo to the right
  - `photo`: full-bleed photo with a gradient only at the bottom, plus title
  - `dark`: midnight with motif
  - All three take breadcrumbs, an eyebrow, a title, a lead, actions and a key-facts slot.
- **Breadcrumbs:** emit BreadcrumbList JSON-LD.
- **Tabs and accordion:** Alpine, with ARIA roles. Tabs follow the APG keyboard pattern; the accordion uses `x-collapse`.

- [ ] **Step 1: Write the failing tests.**
  - `test_button_renders_link_or_button`
  - `test_breadcrumbs_emit_json_ld`
  - `test_styleguide_is_hidden_in_production`: `app()->detectEnvironment(fn () => 'production')` with demo off returns 404
  - `test_styleguide_renders_locally`
- [ ] **Step 2: FAIL. Step 3: Implement** the components and a style-guide page that shows every component in each tone. **Step 4: PASS.**
- [ ] **Step 5: Commit** `feat: UI primitives and living style guide`.

### Task 6: Phase gate

- [ ] Full suite green and Pint clean. Run `npm run build`.
- [ ] In the browser, check `/_styleguide` and `/` at 320, 390, 768, 1024, 1440 and 1920 px: the shell, mega-menu (keyboard), drawer, language menu and footer all work in EN, PT and BN, with no horizontal scroll.
- [ ] Ledger the gate.
