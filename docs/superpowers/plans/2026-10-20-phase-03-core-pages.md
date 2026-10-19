# Phase 3: Core Public Pages Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** the competitor's core information pages, built better: About, Organiser, Committee, Sectors (index + 9 deep-dives), the 2025 edition archive with galleries, Newsroom, FAQ, Contact, Legal, site search, localized error pages, sitemap/robots/llms.txt. All in EN, PT-BR and BN.

**Architecture:**

- **CMS-ready models**, all with translatable JSON fields, the `HasSortOrder` trait and idempotent seeders:
  - `Person` (leadership, patron and board)
  - `Exhibitor`
  - `GalleryAlbum` and `GalleryPhoto`
  - `ProgrammeSession`
  - `NewsArticle` (with the `NewsType` enum)
  - `Faq` (with the `FaqAudience` enum)
  - `ContactMessage`
  - plus new `Sector` columns (`hs_chapters`, `body`)
- **Short page copy:** `lang/{locale}/pages/*.php` (`__('pages/about.title')`).
- **Legal documents:** Markdown files in `resources/markdown/legal/{locale}/{document}.md`, versioned in `config/legal.php`, rendered with `Str::markdown`, with an auto-generated table of contents.
- **Answer tokens:** FAQ answers and other long text may use tokens that are replaced at render time from the edition and settings, so no event fact is frozen in content:
  - `{edition}`, `{dates}`, `{venue}`, `{city}`
  - `{organiser}`, `{phone}`, `{email}`
- **Controllers** are thin and invokable where possible.
- **Page templates differ by type (spec §6):**

  | Page type | Hero | Pages |
  |---|---|---|
  | Editorial | `editorial` | About, Organiser, sector pages, articles |
  | Directory | `dark` | Sectors index, Newsroom, archive |
  | Utility | `dark` | FAQ, Contact, Legal, Search |

**Spec:** §5A (pages and SEO), §5O (privacy), §6. **Content sources:**

- `docs/research/01` §3, §4, §5.2, §8, §9, §10, §12, §13
- `docs/research/02` §2, §3, §6, §7
- `docs/research/03` §A

## Global Constraints

- Phase 0–2 constraints apply. No event date, venue, fee or contact is written into a view or a content string; content uses the tokens above.
- **Localized slugs for every page and record (spec §5A SEO).** PT slugs are translated, including sectors, news and galleries. BN uses EN slugs.
  - Route keys: `about` (pt `sobre`), `organiser` (`organizador`), `committee` (`comite`), `sectors` (`setores`), `archive` (`edicao-2025`), `gallery` (`galeria`), `news` (`noticias`), `faq` (`perguntas-frequentes`), `contact` (`contato`), `search` (`busca`).
  - Legal pages are under `legal/…`: `privacy` (`privacidade`), `terms` (`termos`), `refunds` (`reembolso`), `cookies` (`cookies`), `accessibility` (`acessibilidade`).
- **Record routes:** `sectors.show` `{sector}`, `news.show` `{article}`, `gallery.show` `{album}`. Each resolves by the slug in the current locale. Alternate-language links (`LocalizedUrls`) use each record's slug in the target locale through a `HasLocalizedSlug` interface (`localizedSlug(string $locale): string`).
- **Structured data:** NewsArticle, FAQPage, ImageGallery, BreadcrumbList and Organization (organiser page).
- **Contact form:**
  - Livewire with topic routing (exhibiting, visiting, sponsorship, press, visa & travel, other); every topic routes to the organiser email until desks are configured.
  - Honeypot plus a rate limit (5 per minute per IP).
  - Required consent to process the message (not marketing).
  - The message is stored, and a notification is mailed in the organiser's language (EN).
- **Content:**
  - PT and BN are AI-drafted and flagged for client review (spec §11).
  - Every figure carries its source and period.
  - Partners, testimonials and outcomes are only those documented in the research.

## Review Focus

| Input or condition | Expected behaviour | Pinned by |
|---|---|---|
| `/pt/setores/vestuario` vs `/pt/setores/garments` | The PT slug renders; the EN slug under `/pt` gives a 301 to the PT slug, never a 404 | Task 2, `test_wrong_language_slug_redirects_to_the_right_one` |
| An unknown sector or article slug | A localized 404 page in the right language, with navigation | Task 9, `test_unknown_record_shows_localized_404` |
| FAQ search with Bangla text or mixed case | Live filter matches; "no results" state offers contact | Task 5, browser plus the `test_faq_lists_every_audience_with_search_index` data attributes |
| Contact form spam (honeypot, burst) | Silently dropped or rate-limited; real messages always saved before mail is sent | Task 6, `test_message_is_stored_even_if_mail_fails` |
| A news article missing a PT/BN translation | Falls back to EN with `lang="en"` on the untranslated block | Task 4, `test_untranslated_article_body_is_marked_english` |

---

### Task 1: Organisation pages (About, Organiser, Committee)

- `Person` model: `name`, `role` json, `group` (`PersonGroup`: leadership, patron, board, team), `email` nullable, `photo` nullable image key, `bio` json nullable, `sort`.
- `PersonSeeder`, documented people only (research 01 §4):
  - President Shahriar Ahmed, VP Md. Saiful Alam, SG Md. Joynal Abdin (with headshots and role emails)
  - Chief Patron H.E. Paulo Fernando Dias Feres, Ambassador of Brazil
- **About page:**
  - What the expo is: format (exhibition, B2B, seminars, networking)
  - Who it is for (role cards linking to registration paths)
  - "Why São Paulo" with sourced figures
  - Edition facts from the Edition
  - A 2025 → current edition comparison
- **Organiser page:**
  - BBCCI mission, vision and 6 objectives
  - 7 services
  - Governance (Board of 18, Executive Committee, 3 committees)
  - Leadership cards
  - Membership types and benefits, with a CTA to contact (membership has no online form)
  - The Dhaka office card with live Dhaka time
  - Organization JSON-LD
- **Committee page:** leadership and patron cards with roles, emails (`mailto`) and photos. Board names are "to be published by BBCCI" (not invented).
- **Tests:**
  - `test_about_page_renders_in_three_languages`
  - `test_organiser_page_lists_mission_objectives_services_and_leaders`
  - `test_committee_lists_documented_people_only`

### Task 2: Sectors index and nine sector pages

- **New Sector columns:**
  - `hs_chapters` json (list of strings, e.g. "61 Knitted apparel")
  - `body` json (Markdown with `##` sections: "What Brazil buys", "Rules to know", "How to win buyers")
  - `rules` json nullable (short bullet list)
- **Exhibitor model:** `name`, `sector_id` nullable, `edition_id`, `website` nullable, `logo` nullable, `sort`. Seeded with the 15 Expo 2025 exhibitors from research 02 §7.
- **Index page:** a 9-card grid with figures and a note on calendar vs fiscal years.
- **Sector page:**
  - Editorial hero with the headline figure and HS chapters as chips
  - Body
  - Rules
  - 2025 exhibitors in the sector
  - Previous/next sector
  - CTA to exhibit and to visit
- Route binding by localized slug; a wrong-language slug gives a 301.
- **Tests:**
  - `test_sectors_index_lists_nine_sectors_with_sources`
  - `test_sector_page_renders_body_rules_and_exhibitors`
  - `test_wrong_language_slug_redirects_to_the_right_one`
  - `test_sector_alternates_use_each_languages_slug`

### Task 3: 2025 edition archive and galleries

- **ProgrammeSession model:** `edition_id`, `day` date, `starts_at`, `ends_at` (time), `title` json, `kind` (`SessionKind`), `sort`. Seeded with the 2025 programme (research 01 §5.2 / 02 §7).
- **GalleryAlbum and GalleryPhoto models**, seeded from the processed images: an Expo 2025 São Paulo album and a "Brazil–Bangladesh events, Dhaka" album.
- **Archive page:**
  - Journey (milestones)
  - Key facts
  - The 2025 programme by day
  - The 15 exhibitors
  - Album cards
  - Videos
- **Album page:** photo grid with a lightbox (Alpine: keyboard ←/→/Esc, focus trap, swipe, caption, counter) and ImageGallery JSON-LD.
- **Tests:**
  - `test_archive_shows_programme_exhibitors_and_albums`
  - `test_album_page_renders_photos_with_captions_and_json_ld`

### Task 4: Newsroom

- **NewsArticle model:**
  - `type` (`NewsType`: news, press_release, coverage)
  - `slug` json, `title` json, `excerpt` json, `body` json nullable (Markdown)
  - `image` nullable, `source_name` nullable, `source_url` nullable, `published_at`
- **Seeded:** the 5 BBCCI items (2025 launch, regional promotion, opening, 2nd edition announcement, dates/venue confirmed) plus the 8 coverage items as external links (research 02 §3).
- **Index:** type filter tabs (query string `?type=`), pagination (12), featured latest.
- **Article page:**
  - Editorial layout, reading time, share buttons (WhatsApp, LinkedIn, X, email, copy link, native share)
  - NewsArticle JSON-LD
  - Related articles
- Coverage items open the source in a new tab.
- **Tests:**
  - `test_news_index_filters_by_type`
  - `test_article_page_has_news_article_json_ld_and_share_links`
  - `test_coverage_links_out_with_rel_noopener`
  - `test_untranslated_article_body_is_marked_english`

### Task 5: FAQ

- **Faq model:** `audience` (`FaqAudience`: general, exhibitors, buyers, visitors, delegates, press), `question` json, `answer` json (Markdown with tokens), `sort`.
- **≥ 48 Q&As** covering the competitor's topics (research 02 §3, FAQ list), all three languages.
- **Page:**
  - Audience tabs (`x-ui.tabs`) plus "All"
  - Live search (Alpine, no server round trip) over question and answer text, with a result count, a highlighted match and an empty state linking to Contact
  - Deep links (`#faq-{id}` opens that item)
  - FAQPage JSON-LD
- **Tests:**
  - `test_faq_lists_every_audience_with_search_index`
  - `test_faq_answers_replace_edition_tokens`
  - `test_faq_emits_faqpage_json_ld`

### Task 6: Contact

- **ContactMessage model:** `name`, `email`, `phone` nullable, `company` nullable, `country` nullable, `topic`, `message`, `locale`, `consent_version`, `ip`, `handled_at` nullable.
- **Livewire ContactForm:**
  - Validation with messages in the page language
  - Honeypot and rate limit
  - The message is stored first, then `ContactMessageReceived` is mailed to the settings email
  - A friendly success state with the reply-time promise
- **Page:**
  - Dhaka desk (from settings: address, phones, WhatsApp, email, live local time and office-hours status)
  - São Paulo desk ("to be announced" card)
  - Topic shortcuts
  - The form
  - A map link
- **Tests:**
  - `test_contact_page_shows_the_dhaka_desk_from_settings`
  - `test_message_is_stored_and_mailed`
  - `test_message_is_stored_even_if_mail_fails`
  - `test_contact_form_requires_consent_and_a_message`

### Task 7: Legal pages

- **Five documents × 3 languages** in `resources/markdown/legal/`: privacy, terms, refunds, cookies, accessibility.
- **`config/legal.php`:** version `2026.1` and an effective date per document.
- **Template:** a sticky table of contents (from `##` headings), the version and date, a "Questions? Contact us" card, and print styles.
- **The privacy notice describes what this site actually does:**
  - no analytics or tracking cookies
  - session and XSRF cookies only
  - `localStorage` keys (`mbe.motion`, `mbe.announcement.*`)
  - YouTube-nocookie only on click
  - newsletter double opt-in with a consent version
  - LGPD rights and the Bangladesh Personal Data Protection Act
  - DPO: "to be appointed" (settings `dpo_name`)
- **Tests:**
  - `test_each_legal_document_renders_in_three_languages_with_version`
  - `test_privacy_notice_lists_the_cookies_the_site_sets`

### Task 8: Site search

- **`/search?q=`** over sectors, news, FAQ, people and static page titles in the current locale (the DB `LIKE` over translated JSON plus a static page index).
- Results are grouped by type, with highlighted terms and an empty state.
- A search field in the header drawer and a `/` shortcut opening a search dialog on desktop.
- **Tests:**
  - `test_search_finds_sectors_news_and_faq_in_the_current_language`
  - `test_empty_search_shows_suggestions`

### Task 9: Error pages, sitemap, robots, llms.txt

- **Localized 404, 500 and 503 pages:**
  - The locale is detected from the first path segment when no route matched.
  - The site shell is shown, plus search and popular links.
  - The 500 page has no DB dependency.
- **`/sitemap.xml`:** every localized route and record, with `xhtml:link` hreflang alternates and `lastmod`.
- **`/robots.txt`:** generated; `Disallow` all in demo mode.
- **`/llms.txt`:** a site summary with key page links.
- **Tests:**
  - `test_unknown_record_shows_localized_404`
  - `test_portuguese_404_is_in_portuguese`
  - `test_sitemap_lists_alternates_for_every_page`
  - `test_robots_disallows_everything_in_demo_mode`

### Task 10: Phase gate

- [ ] Suite green, Pint clean, build clean.
- [ ] Browser, with every navigation route now real:
  - every new page at 320, 390, 768, 1280 and 1920 px in EN, PT and BN
  - no horizontal overflow
  - the header mega-menu and drawer reach every page
  - FAQ search and the lightbox work by keyboard
  - the contact form works end to end
- [ ] Ledger the gate.
