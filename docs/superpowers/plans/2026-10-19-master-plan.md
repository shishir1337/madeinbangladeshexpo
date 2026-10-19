# Made in Bangladesh Expo Portal: Master Plan

**Spec:** `docs/superpowers/specs/2026-10-19-made-in-bangladesh-expo-portal-design.md`. Read it first; this plan sequences it and does not restate it.
**Research:** `docs/research/00`–`03`; client media in `research-assets/bbcci/`.

This is the roadmap. Each phase gets its own task-by-task plan (`docs/superpowers/plans/YYYY-MM-DD-phase-NN-<name>.md`), written just before the phase starts, using what the previous phases actually produced. Phase 0's plan is written: `2026-10-19-phase-00-foundation.md`.

## How every phase is run

**Definition of done** (applies to every phase; a phase isn't done until all of these hold):

1. Its tests pass (`php artisan test --compact`), and Pint is clean.
2. Every page or screen it adds works in **EN, PT-BR and BN**, with no missing strings, correct `lang` attributes, and Bangla numerals in BN copy.
3. Every page or screen passes the **responsiveness matrix**: 320, 360, 390, 768, 1024, 1280, 1440, 1920 and 2560 px, plus landscape phone. No horizontal scroll, nothing overlapping, and targets of at least 24 px.
4. Every public page meets the **performance budget** (spec §5P) in a production build, and **WCAG 2.2 AA** checks pass (axe plus a keyboard walk-through).
5. **Demo seed data** covers the states it introduces, labelled as demo.
6. The **attention-to-detail checklist** (spec §6) is walked: loading, empty and error states, focus, formatting, copy consistency.
7. The user has seen it running in the browser, and anything they flagged is fixed or logged.

**Phase workflow:**

1. Write the phase plan.
2. The user reviews it.
3. Execute task by task, each task ending in a commit.
4. Review the phase.
5. Demo it to the user.
6. Begin the next phase.

**Order of priority when time is short** (spec §9):

1. polish (Phases 1–4)
2. the competitor's journeys built for real (5–8)
3. differentiators (12, plus a floor-plan preview)
4. the remaining portals as thin, working slices (9–11)

Phase 13 (pitch packaging) always happens.

## Phase map

```
0 Foundation
└─ 1 Design system ──┬─ 2 Home ─ 3 Core pages ─ 4 Participation pages
                     │
                     ├─ 5 Visitor registration ──────────────┐
                     ├─ 6 Accounts + exhibitor application ──┤
                     │       └─ 7 Console v1 ─ 8 Finance ─ 9 Exhibitor portal ─ 10 Visa desk ─ 11 Associations
                     │                                        └─ 12 Matchmaking + meetings
                     └──────────────────────────────────────────── 13 Pitch packaging (★ pitch-ready)
14 Floor plan · 15 Catalogue + RFQ · 16 Event day · 17 Communications · 18 Post-event · 19 Hardening + launch
```

---

## Phase 0: Foundation

- **Goal:** a correctly configured Laravel 13 app on PostgreSQL that serves three locales from one set of routes and reads event facts from data, not code.
- **Scope:**
  - PostgreSQL dev and test databases
  - custom localization layer: EN at `/`, PT-BR at `/pt`, BN at `/bn`, translated slugs, hreflang alternates, language switcher data, legacy-prefix redirects
  - locale-aware number and date formatting, including Bangla numerals and date ranges
  - `Edition` and `Venue` models with the working values from spec §4
  - general settings (organiser contacts)
  - staff roles
  - demo-mode flag
  - a data-driven placeholder home page in all three languages
- **Plan:** `2026-10-19-phase-00-foundation.md`.
- **Gate:** suite green; `/`, `/pt` and `/bn` render the current edition's name, dates and venue in their own language.

## Phase 1: Design system and style tiles

- **Goal:** a design system good enough that every later page is assembled, not invented.
- **Scope:**
  - **Tokens:** spec §6 palette, spacing, radii, shadows, z-layers, motion durations.
  - **Fonts and motif:**
    - self-hosted fonts (Anek Bangla, Inter, Noto Sans Bengali) with a `unicode-range` split
    - `:lang(bn)` typography rules
    - the Jamdani × modernist-tile SVG motif set
  - **Blade components:**
    - header, mega-menu, mobile drawer, footer, announcement bar
    - language switcher, browser-language suggestion bar
    - buttons, links, cards, stat tiles, badges, tabs, accordions, modals and sheets, toasts
    - form controls (inputs, select, checkbox and radio cards, file drop, phone with country), stepper, tables, breadcrumbs, pagination, empty, loading and skeleton states
    - countdown, dual clock
    - consent banner shell
    - demo ribbon
  - **Motion layer:** GSAP and ScrollTrigger reveal utilities; Lenis on marketing pages only; reduced-motion toggle.
  - **Living style-guide page** at `/_styleguide` (dev and demo only).
  - **2–3 style tiles** of the home hero and a content page, for the user to choose from.
- **Gate:** **the user picks a style tile in the browser.** Components pass the responsiveness matrix and axe.
- **Dependencies to add:** GSAP, Lenis (npm). Others as the plan justifies.

## Phase 2: Home page ★

- **Goal:** the first impression, at production polish.
- **Scope:** every home section in spec §5A, built from Phase 1 components:
  - hero with real 2025 photography and video (controls)
  - edition, dates and venue above the fold
  - countdown with São Paulo/Dhaka clocks
  - audience split
  - sourced stats bento
  - lazy trade-route globe (sea Chattogram→Santos, air DAC→GRU) with a static fallback
  - 9 sectors teaser
  - 1972→2027 timeline (no scroll-jacking)
  - 2025 highlights with the YouTube facade
  - press, partners by role, CTA band, newsletter sign-up (double opt-in)
  - image pipeline (AVIF/WebP, responsive sizes) for `research-assets` photos
  - per-page OG image
  - `ExhibitionEvent` and Organization JSON-LD
- **Gate:** LCP ≤ 2.0 s (mobile 4G, production build); responsiveness matrix; content correct in all three languages.

## Phase 3: Core public pages ★

- **Scope:**
  - About, Organiser (BBCCI), Committee
  - Sectors index plus 9 sector pages: sourced figures, HS chapters, rules, 2025 exhibitors
  - 2025 archive and galleries (lightbox)
  - Newsroom (types, filters, sharing, NewsArticle schema) and article pages
  - FAQ: at least 48 Q&As, audience tabs, live search, FAQPage schema
  - Contact: desks with live local times, topic-routed form, honeypot and Turnstile
  - Legal (privacy, terms, refunds, cookies, accessibility statement; versioned)
  - site search
  - localized 404/500/offline pages
  - sitemap with hreflang, robots, `llms.txt`
- **Content source:** `docs/research/01` and `02` §3, re-verified and dated.
- **Gate:** parity with the competitor's equivalent pages (`02` §2, rows 1–20 and 41–54).

## Phase 4: Participation and travel pages ★

- **Scope:**
  - Exhibit
  - Stand packages with a calculator (USD/BDT/BRL, rates from settings)
  - How to apply: document checklist, ANVISA explainer, status flow
  - Deadlines (generated from the opening date)
  - Payment instructions
  - Visit (buyers)
  - Sponsorship: tier matrix plus proposal request
  - Programme with a time-zone toggle
  - Speakers ("apply to speak"), Partners by role
  - Venue
  - City guide: MapLibre with clustering, about 35 places, filters, distances
  - Hotels
  - Travel and visa: visa navigator, health, money, plugs, halal, emergency numbers, Brazilians travelling to BD. Weather must match the event month.
  - Press centre, Downloads (categories, gated files)
  - a CMS-ready content model for all of the above, so Phase 7 can expose it
- **Gate:** every page in `02` §2 has a better or equal counterpart.

## Phase 5: Visitor registration and badges ★

- **Scope:**
  - **Registration hub** with role cards and a "resend my badge" form.
  - **Wizards:** buyer (4 steps; CNPJ via BrasilAPI → CNPJá, CEP via BrasilAPI → ViaCEP, alphanumeric CNPJ `CHAR(14)`), trade visitor, business delegate (paid, per-person invoice stub that Phase 8 fills), press (credential upload).
  - **Signed single-use invitation links** for VIPs and speakers.
  - **Autosave and resume** (local plus server draft).
  - **Consents:** granular, unticked, versioned, with a proof log.
  - **Group XLSX import** (≤200 rows, row validation), with each member confirming their own consent by magic link.
  - **Badges:** QR badge (chillerlan/php-qrcode) on screen, by email and as PDF (Chromium); wallet pass in preview mode; manage-my-registration magic link (correct name, resend).
  - Normalise Bangla digits ০–৯ to ASCII on all numeric input.
- **Gate:** every registration type completes end to end in a browser test; the badge PDF renders Bangla correctly (golden test).

## Phase 6: Accounts and exhibitor application ★

- **Scope:**
  - organisation accounts: country BD/BR, buyer and/or seller capability, members
  - sign-in by passkey and email magic link; password as a fallback
  - the 5-step application (spec §5D) with country-aware branches (BD first, BR variant)
  - ANVISA questions, documents, package choice with live quote
  - terms version acceptance (timestamp, IP, user agent)
  - application number
  - application state machine and status timeline, with an email on every change
- **Gate:** a browser test takes an application from account creation to submitted.

## Phase 7: Console v1 ★

- **Scope:**
  - Filament 5 panel at `/console`, themed to the brand; staff sign-in with TOTP
  - roles from Phase 0, with Shield policies
  - settings editor (edition, venue, fees, contacts)
  - applications desk (review, request changes, approve, reject with reason)
  - registrations desk
  - CMS for every content model from Phases 2–4, with the translations editor and its "needs review" flag
  - media library
  - audit log viewer
  - dashboard v1 (registrations, applications, pipeline)
  - guided-mode help panels for the top 5 jobs
- **Gate:** a staff user approves an application and edits a page in all three languages without help.

## Phase 8: Finance ★

- **Scope:**
  - proforma invoice and participation contract PDFs (3 languages; spatie/laravel-pdf, Browsershot in dev and Gotenberg in prod; Bangla golden test)
  - invoice numbering, FX snapshot
  - bank-slip upload → finance verification → receipt PDF
  - SSLCommerz sandbox (cards, bKash, Nagad), with IPN through spatie/laravel-webhook-client
  - PIX driver interface (Mercado Pago sandbox) behind a flag
  - instalments (50/50 default), reminders and dunning
  - finance desk: awaiting verification, overdue, ledger, exports
- **Gate:** sandbox payment end to end for both paths; part-payment state correct.

## Phase 9: Exhibitor portal ★

- **Scope:**
  - dashboard with an auto-advancing checklist and deadlines
  - trilingual profile with live preview, an AI translation draft (flagged), and the human-verified flag
  - products: photos, HS→NCM, MOQ, FOB band, lead time, certifications
  - fascia name with preview
  - team and staff badges
  - encrypted vault (libsodium secretstream envelope encryption, signed URLs, access log, retention purge)
  - e-manual and services ordering
  - public exhibitor page
- **Gate:** portal walkthrough on phone and desktop; vault files are unreadable on disk.

## Phase 10: Travel and visa desk ★

- **Scope:**
  - passport record with a warning when validity is under 6 months
  - the 16-item embassy checklist with uploads
  - invitation letter PDF with a QR code to a public verification page
  - configurable letter steps (BBCCI review, Brazil-side signatory, notarisation, courier), with the letter-signatory role
  - visa tracker per person and delegation
  - console visa desk with a queue
- **Gate:** a generated letter verifies by QR; signatory sees only letters.

## Phase 11: Association portal ★

- **Scope:** referral links and attribution, quotas, applicant list, Excel export, pay-on-behalf (one invoice for many), bulk visa pack.
- **Gate:** association walkthrough end to end.

## Phase 12: Matchmaking and meetings ★

- **Scope:**
  - interest profiles (sector, HS/NCM, CNAE from CNPJ, volumes, certifications)
  - two-way rule-based match scores with reasons (AI reasons behind a flag)
  - staff manual matching
  - meeting requests with mutual accept
  - slot grid (20 min default) and numbered tables
  - BRT/Dhaka time views, `.ics`
  - email reminders (WhatsApp once Phase 17 ships)
  - interpreter requests
  - outcome log and no-show flag
- **Gate:** buyer and exhibitor book, accept and see a meeting at a table, in both time zones.

## Phase 13: Pitch packaging ★

- **Scope:**
  - full demo seed across every state (spec §5Q)
  - demo control panel: one-click sign-in per role, reset data, captured emails (Mailpit)
  - guided walkthrough that follows the pitch story
  - floor-plan preview (Phase 14 slice) if not already built
  - staging deploy on our subdomain (VPS, Cloudflare, `noindex`, HTTPS)
  - pitch script
  - final responsiveness and performance pass on everything shown
- **Gate:** **pitch-ready.** A full rehearsal on the staging URL from a phone and a laptop.

## Phase 14: Floor plan and stand booking

- **Scope:**
  - SVG hall plan editor in the console
  - public and portal plan: availability, hold timer, corner/premium pricing, sponsor zones, co-exhibitor sharing
  - admin allocation mode for pavilions
  - list view as the accessible alternative (WCAG 2.5.7)
  - booking feeds the application and invoice

## Phase 15: Catalogue and RFQ

- **Scope:** public searchable exhibitor and product catalogue (sector, HS/NCM, certifications, MOQ, lead time, export markets); sector RFQs routed to matching sellers; enquiry inbox in the portal; console oversight.

## Phase 16: Event day

- **Scope:**
  - PWA (manifest, service worker, offline badge, agenda, map, favourites)
  - QR check-in with named devices and an offline queue
  - kiosk self check-in with Chrome kiosk printing (PrintNode optional)
  - lead retrieval (scan, rate, note, tags, CSV), consent-gated
  - zone access
  - live occupancy dashboard (Reverb)

## Phase 17: Communications

- **Scope:**
  - the full set of 50+ email templates in 3 languages, editable in the console, with a sent log
  - WhatsApp Business Cloud API driver (opt-in, utility templates)
  - campaigns and segments, double opt-in newsletter
  - optional SMS driver for Bangladesh
  - trilingual AI assistant (flagged) with human handover

## Phase 18: Post-event

- **Scope:** surveys and NPS, one-tap meeting feedback, deal and outcome tracker, public results page, QR-verifiable certificates, ROI reports per exhibitor and sponsor (PDF and dashboard).

## Phase 19: Hardening and launch

- **Scope:**
  - security review and CSP
  - full WCAG 2.2 AA audit (aiming for São Paulo's Selo de Acessibilidade Digital)
  - LGPD pack: DPO notice, records of processing, retention jobs, DSAR queue, incident register
  - load test of the launch flows
  - production infrastructure (spec §7 hosting), backups, health checks, monitoring
  - launch checklist

  Each release (R1–R4, spec §9) passes its own slice of this gate before it goes live.

## Releases after the award (spec §9)

| Release | Phases it ships |
|---|---|
| R1 (~Dec 2026) | 0–4, 6, 7, 8, 10 + core privacy from 19 |
| R2 (~Jan 2027) | 5, 9, 11, 15, 12 (buyer-side matching) |
| R3 (~Feb–Mar 2027) | 14, 12 (tables), 16, 17 (WhatsApp), wallet passes |
| R4 (post-event) | 18 |
