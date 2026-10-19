# Made in Bangladesh Expo Portal: Design

**Date:** 2026-10-19
**Client:** Brazil Bangladesh Chamber of Commerce & Industry (BBCCI)
**Status:** Draft for approval. It rests on what we know today. Items marked **[ASSUMPTION]** are working values to be replaced by the client's questionnaire answers.

**Research this design is built on** (read these before planning any phase):

- `docs/research/00-competitor-video-walkthrough.md`: the competitor's end-to-end demo video, translated
- `docs/research/01-bbcci-chamber-site.md`: everything on BBCCI's current site, plus the 2025 prospectus
- `docs/research/02-competitor-javed-demo.md`: full teardown of the competitor demo: pages, every form field, the feature matrix, and the UX, SEO and performance audit
- `docs/research/03-domain-and-features.md`: market facts, visa, compliance, integrations, verified Laravel 13 package versions, and UI direction
- `research-assets/bbcci/`: BBCCI's photos, logos and documents, with `manifest.json`
- Client questionnaire (on hold, not sent): `docs/client/bbcci-client-questionnaire.md`

---

## 1. Intent: why this exists

BBCCI runs the Made in Bangladesh Expo in São Paulo. In 2025 the process was offline:

- PDF forms
- photos of bank-deposit slips
- WhatsApp follow-ups
- paper on the chamber's desk

The result was about 20 exhibitors in hotel function rooms, no published results, and no Portuguese content for Brazilian buyers.

BBCCI now wants one trilingual portal (English, Portuguese-Brazil, Bangla). It must cover:

1. A public website that sells the expo to two audiences: Bangladeshi exporters and Brazilian/Latin American buyers.
2. A registration system for every participant type, with QR badges.
3. A complete exhibitor journey: application, approval, invoice and contract, payment, preparation, travel and visa.
4. Portals for exhibitors, associations and other participants.
5. A BBCCI admin console that runs everything without a developer.

**The competitive situation decides the strategy.** Another firm (Javed IT Solution) has already shown BBCCI a strong, working demo (`expo.javeditsolution.com`). BBCCI evidently briefed them: their demo contains non-public facts such as the venue address, the 2025 exhibitor list, board size and launch dates. So their scope is the best proxy we have for BBCCI's requirements.

Our design therefore has three layers:

1. **Parity (must-match):** every page, flow and portal feature the competitor shows or claims. BBCCI has seen it, and anything missing reads as a step backwards.
2. **Do-better:** the same features, clearly better executed. That means first impression and visual quality, speed, content completeness, real LGPD compliance and attention to detail.
3. **Net-new:** the deal-making layer they don't have. Matchmaking and meetings, a floor plan, a catalogue with quote requests (RFQ), lead scanning, live payments for both countries, wallet badges, AI help, and outcome and ROI reporting.

**What success looks like**

- BBCCI picks our proposal.
- The demo makes a strong first impression in the first 10 seconds.
- Every role can be walked end to end in a live demo.
- After launch, BBCCI staff run the edition themselves, and the expo ends with real, reportable numbers: meetings held, deals and their value.

## 2. Goals, non-goals, anti-goals

### Goals

- **G1. Full parity** with the competitor's public site (54 pages × 3 languages), registration flows, exhibitor, association and admin features (`02` §11.1).
- **G2. A first impression better than theirs.** Distinct, premium, warm and "Bangladesh meets Brazil" without looking like a flag. Real event imagery, varied page layouts, no monotony.
- **G3. Ease of use** for low-tech users on mobile: Bangladeshi SME owners, Brazilian importers and chamber staff. Forms never lose data, and every step says what happens next.
- **G4. Fully responsive from 320 px to 2560 px.** Touch-first portals; the event-day tools work on phones.
- **G5. Single source of truth.** Edition name, dates, venue, fees, deadlines, bank details and contacts live in settings. They flow everywhere: pages, all 3 languages, emails, PDFs and structured data.
- **G6. The deal-making layer** (net-new, §5 L–N) that turns the expo from an information site into a business-outcome platform.
- **G7. Measurable quality.** LCP ≤ 2.0 s on mid-range 4G mobile, WCAG 2.2 AA, no 5xx under expo-launch load, and Bangla rendered correctly everywhere, including PDFs.
- **G8. A demo that sells itself.** Seeded, clearly labelled demo data, one-click sign-in as each role, and a guided walkthrough.

### Non-goals (for now)

- Native iOS or Android apps. An installable PWA covers the phone use cases.
- Virtual or hybrid expo hosting. At most, livestream embeds of the opening and seminars.
- A full CRM or helpdesk product. The console covers BBCCI's needs: inbox and log, enquiries, follow-ups.
- Membership management for BBCCI, and a year-round sourcing marketplace. Both are designed for later (the data model must not block them) but not built now.
- Hotel booking engine and flight booking. We show information, links and room-block details.

### Anti-goals: things that would make this a failure even if it "works"

- **"To be announced" dead ends.** Every page launches with useful content and a next action, even when facts are pending.
- **One dark template everywhere.** Also: very long pages, scroll-jacking, pinned "dead scroll".
- **Hard-coded dates, fees or bank details.**
- **Analytics or tracking before consent.** No fingerprinting of any kind, ever.
- **Bangla text broken anywhere.** This includes conjuncts in PDFs, letter-by-letter text animation that splits graphemes, and letter-spacing on Bangla.
- **Pre-ticked consent boxes.** Also: one person consenting on behalf of a whole group.
- **Participant portals that look like a generic admin template.**
- **Fabricated facts presented as real.** That covers testimonials, statistics, partners and results. Demo data is always labelled as demo.
- **Facial recognition or other biometrics.** These are sensitive data under LGPD.

## 3. Constraints

- **Stack already in place:** Laravel 13.37 on PHP 8.4. PHP 8.4 is installed side-by-side via winget. XAMPP's PHP 8.2 must not be used for this project; see the memory note on the PHP path. PostgreSQL 17 and Docker are installed locally.
- **Three languages** everywhere a participant sees text, including URLs (localised slugs), emails, PDFs, badges, validation messages and the PWA. The console is English-first (Bangla optional later).
- **Payments:**
  - SSLCommerz caps a single transaction at about BDT 500,000 (≈ one USD 4,000 stall), so **bank transfer with slip upload is a first-class path**.
  - Stripe doesn't serve Bangladeshi entities.
  - PIX needs a Brazilian CNPJ, so it is an optional driver.
- **Compliance:** Brazil's LGPD (encarregado, granular consent, international-transfer consent, 3-working-day incident notice) and Bangladesh's PDPA 2026. Accessibility under Brazil's LBI Art. 63 and ABNT NBR 17225 (WCAG 2.2 AA).
- **Visa reality:** Bangladeshis need a business visitor visa (VIVIS) from the Embassy of Brazil in Dhaka. There is no e-visa, and processing takes up to 20–30 working days. Invitation letter, passport valid at least 6 months, and supporting documents. Do not use "VITEM II" for business.
- **Data formats:**
  - CNPJ can be alphanumeric (since July 2026): store as `CHAR(14)`.
  - Normalise Bangla digits ০–৯ to ASCII on all numeric inputs.
  - Phones in E.164.
- **Timeline [ASSUMPTION]:** pitch demo as soon as possible. Production live for exhibitor applications by about December 2026 if the event is in March 2027, because visa lead times need it.
- **Pitch code is production code (my call).** Nothing is built as a throwaway demo. Every phase is built to production standard: tests, validation, the rules behind each status change, encryption where §5O requires it. The demo layer (§5Q) is a flag on top of the real system. This costs a little more per phase but removes a rebuild after the award. The competitor's demo is itself production-grade.

## 4. Event facts used as working values

All of these live in settings. The **[ASSUMPTION]** ones come from the competitor demo and must be confirmed (questionnaire §3, §5).

| Fact | Working value | Source |
|---|---|---|
| Edition name | Made in Bangladesh Expo 2026 (2nd edition) | Client's own wording, competitor demo [ASSUMPTION] |
| Dates | 22–25 March 2027 (Mon–Thu), opening 10:00 BRT | Competitor demo [ASSUMPTION] |
| Venue | Pro Magno Centro de Eventos, Av. Professora Ida Kolb 513, Casa Verde, São Paulo | Competitor demo [ASSUMPTION] |
| Scale | ~50 Bangladeshi stalls plus selected Brazilian exhibitors | Competitor demo [ASSUMPTION] |
| Sectors (9) | Garments; home & technical textiles; pharmaceuticals; leather & footwear; jute; agro-food; handicrafts & décor; plastics & toys; ICT | Competitor demo; BBCCI prospectus |
| Stall | 8 × 8 ft, USD 4,000, includes 2 representatives, venue, set-up, branding | 2025 prospectus (2026 fees TBC) |
| Business delegate | USD 1,000 per person, includes B2B matchmaking | 2025 prospectus |
| Early bird | 10% | 2025 prospectus |
| Buyers / trade visitors | Free | Competitor demo [ASSUMPTION] |
| Trade direction | **Two-way.** Bangladeshi exporters exhibit to Brazilian/LatAm buyers. Selected Brazilian companies may also exhibit. Bangladeshi business delegates include importers who meet Brazilian suppliers (the 2025 prospectus lists Brazil's export focus: cotton, sugar, soy, coffee, meat, machinery) | 2025 prospectus; competitor demo. Modelled two-way from Phase 0 (my call) |
| Organiser | BBCCI, Shanta Skymark, 18 Gulshan Avenue, Dhaka-1212; +880 1553 676767 | BBCCI site |
| Leadership | President Shahriar Ahmed; VP Md. Saiful Alam; SG Md. Joynal Abdin | BBCCI site |
| 2025 edition | 15–18 June 2025, Novotel / Expo Center Norte, São Paulo; ~15–20 exhibitors | BBCCI site; competitor |

Trade statistics shown on the site must carry a source and an as-of date (EPB, ComexStat, World Bank), as in `01` §12 and `02` §3.

## 5. What we are building: module inventory

Tags: **[M]** must-match competitor · **[B]** do-better · **[N]** net-new. Phase numbers refer to §9.

### A. Public website (all pages in EN / PT-BR / BN)

Must-match pages and components (`02` §2 lists all 54):

- **Home** [M/B]. Contents:
  - hero with real 2025 photography and video (play, pause and mute controls)
  - edition, dates and venue above the fold
  - countdown plus São Paulo/Dhaka dual clocks
  - audience split (Exhibit / Visit as buyer / Sponsor / Press)
  - sourced stats bento
  - trade-route globe (sea Chattogram→Santos, air Dhaka→GRU)
  - 9 sectors
  - 1972→2027 bilateral timeline (no scroll-jacking)
  - 2025 highlights, press, partners by role
  - CTA band and newsletter
- **About; Organiser (BBCCI); Committee** [M] (leadership, board, messages).
- **Sectors index and 9 sector pages** [M/B]. Sourced figures, HS chapters, duties and rules (ANVISA/MAPA/INMETRO), 2025 exhibitors. **Plus:** featured products from current exhibitors, "Request suppliers in this sector" (RFQ) [N].
- **Exhibit, Stand packages, How to apply, Deadlines, Payment instructions** [M/B]. Package catalogue, live cost calculator (USD/BDT/BRL), document checklist, ANVISA explainer, application status flow.
- **Visit (buyers)** [M/B]. The "why visit" pitch, 4-step how-it-works, buyer FAQ. **Plus:** the "book B2B meetings" explainer [N].
- **Sponsorship** [M/B]. Tier matrix with deliverables and placement mock-ups, plus a proposal request [B].
- **Programme** with time-zone toggle [M]. **Speakers** [M] with "apply to speak". **Partners** [M], grouped by role.
- **2025 archive and galleries** [M/B]. Journey, programme, exhibitors, gallery with lightbox, and the 2025 videos (the YouTube catalogue in `01` §13) [B].
- **Venue; City guide** (map with about 35 places, filters, distances, directions); **Hotels; Travel & visa** [M/B]:
  - Travel & visa covers the visa navigator, health, money, plugs, halal, emergency numbers and Brazilians travelling to Bangladesh.
  - Weather must match the event month.
  - The map uses production tiles and clustering [B].
- **Newsroom, Press centre, Downloads** (categories, gated files), **FAQ** (≥48 Q&As, audience tabs, live search), **Contact** (desks with live local times, topic-routed form, WhatsApp) [M].
- **Legal:** privacy, terms, refunds, cookies (versioned), plus an **accessibility statement** [N].
- **Exhibitor directory and per-exhibitor public page** [M/B]. A searchable catalogue: sector, HS/NCM, certifications, MOQ, lead time [N].
- **Site-wide:**
  - mega-menu and mobile drawer
  - language switcher with browser-language suggestion
  - announcement bar
  - consistent help (WhatsApp, contact, assistant) in one fixed place that never covers content
  - cookie banner with real consent gating
  - VLibras widget on PT pages
  - site search [N]
  - 404/500/offline pages with navigation
- **SEO** [M/B]:
  - localised slugs on every page (they left English slugs on PT subpages)
  - hreflang in HTML and sitemap
  - JSON-LD: `ExhibitionEvent` with offers and schedule, Organization, FAQPage, NewsArticle, BreadcrumbList, ImageGallery
  - OG images per page; image and news sitemaps; `llms.txt`

### B. Visitor registration

- **Registration hub** with role cards and an audience filter; "resend my badge" [M].
- **Wizards** [M]:
  - **buyer/importer:** 4 steps; CNPJ lookup auto-fills company and address, CEP lookup auto-fills the street
  - **trade visitor:** 3 steps
  - **business delegate:** paid, per-person invoice
  - **VIP, press** (credential upload) and **speaker**
  - Field lists in `02` §4.
- **Autosave and resume** (local and server draft); **separate, unticked, versioned consents** [M].
- **Group registration** by XLSX template (≤200 rows, row validation) [M]. **Better:** each group member confirms their own consent and details by magic link [B].
- **VIP and speaker by signed, single-use invitation link**, pre-filled, with protocol fields [B]. The competitor's "invitation only" forms are open to anyone.
- **Instant QR e-badge** on screen, by email and as PDF, plus **Apple/Google Wallet pass** [M + N]. Self-service name correction and resend through a "manage my registration" magic link [M].

### C. Accounts and identity

- Account creation, login, reset, new-device alert [M].
- **Better:** passkeys and email magic-link sign-in for participants; TOTP 2FA mandatory for staff; organisation accounts with team members and roles (owner, staff) [B].

### D. Exhibitor application and approval

- 5-step application [M]:
  1. Company: BIN, TIN, trade licence, ERC, etc.
  2. Products, with ANVISA questions when cosmetics, food or medicines are declared.
  3. Documents.
  4. Package, with a live USD/BDT(/BRL) quote.
  5. Terms acceptance, recording timestamp, IP, user agent and terms version.
- Application number, status timeline and an email on every change [M].
- **Stand choice on the floor plan** during step 4, when the floor plan is enabled [N]. See L2.
- **Country-aware application branch** (my call). The Bangladeshi branch is the one described above. A Brazilian exhibitor branch asks for CNPJ (auto-fill), skips the visa desk and ANVISA import questions, and quotes and invoices in BRL/USD. The Bangladeshi branch ships first; the Brazilian branch is a variant of the same wizard, not a separate flow.
- Console review: approve, request changes, or reject with a reason [M].

### E. Finance

- **Proforma invoice and participation contract PDFs** in the applicant's language, generated on approval [M]. Chromium rendering, so Bangla is shaped correctly.
- **Payment paths** [M/B]:
  - bank-slip upload → finance verification → receipt PDF
  - online via SSLCommerz (cards, bKash, Nagad) in sandbox until BBCCI's merchant account is live
  - optional PIX/BRL driver (Mercado Pago) if a Brazilian entity exists [N]
- **Instalments** (50/50 default, configurable) with automatic reminders and dunning [M/B].
- **Finance desk** [B]: ledger, payments awaiting verification, overdue list, exports, and an FX-rate snapshot stored on every invoice.

### F. Exhibitor portal (branded, custom UI, not admin-template)

- Dashboard with an auto-advancing task checklist and deadlines [M].
- **Company profile** in 3 languages with live preview [M]. **Better:** AI translation draft plus a "human-verified" flag [B/N].
- **Product catalogue** with photos, HS code with NCM mapping, MOQ, FOB band, lead time and certifications [M/B/N].
- **Fascia name** with character limit and uppercase preview [M]. **Staff badges and team members** [M].
- **Encrypted document vault** with retention-based auto-deletion [M].
- **E-manual and services ordering** (extra furniture, power, badges, catalogue advert; late surcharges) [N].
- **Enquiry/RFQ inbox** from buyers [N]. **Meetings** (see L) [N]. **Leads** (see M) [N]. **Post-event ROI report** (see N) [N].

### G. Travel and visa desk

- Passport details with an expiry warning under 6 months, and the embassy checklist (16 items) with an upload per item [M].
- **Invitation letter generation** [N]:
  - one letter per person, on the configured letterhead and signatory
  - a QR code linking to a public verification page the embassy can check
  - status tracking and auto-purge after retention
- **Letter workflow with configurable steps** (my call, because the embassy may need a notarised letter from a Brazilian inviter; see `03` §B.1):
  - Steps: draft generated → BBCCI review → Brazil-side signatory approves → notarised in Brazil (cartório) → couriered/scanned → issued to the delegate.
  - The signatory, notarisation and courier steps are each switched on or off per edition in settings.
  - A **Letter signatory** console role lets a São Paulo partner approve letters without seeing anything else.
  - Courier tracking number and scanned final letter are attached to the record.
- **Visa status tracker** per delegate and delegation [B]. Console visa desk with queue and filters [M], which the competitor has marked as unfinished.

### H. Association portal (BGMEA, BKMEA, EPB…)

- Referral link, quota, applicant list and Excel export [M].
- **Better:** pay on behalf of members (one invoice for many), quota allocation, and a bulk visa pack [B].

### I. Sponsors (lightweight)

- Tier catalogue, proposal builder → console deal → contract and invoice.
- Sponsor area for uploading logo and assets.
- Post-event sponsor report [N].

### J. BBCCI console (staff admin)

- **Settings** (single source of truth, G5) [M].
- **CMS:**
  - pages and their sections (show/hide, order, draft preview)
  - news, gallery and media (focal point)
  - sectors, FAQs, downloads, partners, speakers, programme, city-guide places, hotels
  - translations editor [M]
- **Desks:**
  - applications and approvals
  - registrations
  - finance
  - visa
  - associations
  - sponsors
  - enquiries inbox
  - check-in [M; finance, visa, check-in and campaigns are unfinished in the competitor's demo]
- **Email templates:** 50+ × 3 languages with EN fallback; sent-mail log [M].
- **Audit trail** of every change, document view and export [M]. **Consent records and data-subject requests** (DSAR) queue with SLA timers [M/B].
- **Roles:** super admin, sales/approvals, finance, visa desk, letter signatory (Brazil partner), content editor, check-in operator, read-only viewer [M].
- **"Guided mode"** [M/B]:
  - in-console step-by-step guides for common jobs ("approve an application", "verify a payment")
  - contextual help on every screen
  - an "Edit this" link on public pages that takes staff to the right editor
- **Dashboards:** registrations by type, country and sector; pipeline; revenue and receivables; visa status; check-in funnel; meetings; deals [N].

### K. Communications

- Transactional email through queued templates, with plain-text alternatives and `List-Unsubscribe` on marketing [M].
- **WhatsApp Business Cloud API** for badges, reminders and payment/visa status (opt-in recorded; utility templates) [N]. Built behind a driver interface: log driver in dev and demo.
- **Campaigns and newsletters** to segments, with double opt-in [M]. SMS (BD) is optional, behind a driver.
- **Trilingual AI assistant** on site, grounded in FAQ, travel, packages and e-manual content, with handover to the human desk [N]. Behind a feature flag.

### L. B2B matchmaking and meetings (net-new)

- **L1. Matching (two-way).** Buyers declare sectors, HS/NCM interests, volumes and certifications needed. CNPJ lookup provides the CNAE activity code. Sellers declare products. The engine suggests matches with reasons, and staff can also match by hand. Matching runs both ways:
  - Brazilian buyers ↔ Bangladeshi exhibitors (the main flow)
  - Bangladeshi importer-delegates ↔ Brazilian suppliers or exhibitors

  Every organisation can be a buyer, a seller, or both.
- **L2. Floor plan.** Interactive SVG of the hall with live availability, a hold timer, corner/premium pricing and an admin-allocate mode for association pavilions. Booking feeds the application and invoice. Before a real plan exists, it runs as a feature-flagged teaser.
- **L3. Meetings.** Meeting requests with mutual accept. A slot grid (default 20 minutes) at numbered tables. Timezone-aware (BRT/BST) views and `.ics` files. Email/WhatsApp reminders. Optional interpreter request (PT↔BN↔EN). No-show flag and a one-tap outcome log afterwards.

### M. Event day (net-new except check-in)

- **PWA** for all participants: installable, offline badge, agenda, map, favourites.
- **QR check-in** [M]: camera scanning (`barcode-detector` polyfill), named devices, offline queue that syncs later, live counts.
- **Kiosk self check-in and on-demand badge printing** (Chrome kiosk printing; PrintNode optional) [N].
- **Lead retrieval** [N]: exhibitors scan buyer badges, add a rating, note and tags, and export CSV. This needs the buyer's consent captured at registration.
- **Zone access** (B2B lounge, VIP, seminar rooms) [N]. Live occupancy dashboard (Reverb) [N].

### N. Post-event (net-new)

- Surveys/NPS and one-tap post-meeting feedback.
- **Deal and outcome tracker:** both sides log the outcome and a USD estimate. This feeds a **public results page** with BBCCI's headline numbers.
- **Certificates of participation:** 3 languages, verifiable by QR.
- **ROI report** per exhibitor and sponsor (PDF and dashboard): profile views, meetings, leads, RFQs and deals, compared with the median.

### O. Privacy and compliance (cross-cutting)

- **Consents:** a granular consent model (purpose, text-version hash, locale, IP, user agent, timestamps), withdrawal, and a separate highlighted consent for sharing buyer data with Bangladeshi exhibitors (international transfer).
- **Notices:** a named encarregado (DPO) in the footer, driven by settings, and a trilingual privacy notice.
- **Rights and retention:** a DSAR centre (self-service export and delete requests, plus a console queue). Retention schedule with automatic purges, each logged.
- **Security:**
  - envelope encryption for vault files (libsodium secretstream, per-file key)
  - signed short-lived download URLs
  - every view and download logged
- **Consent-gated analytics** (Plausible or GA4 Consent Mode v2, builder's call), with no fingerprinting. YouTube and maps behind consent facades. Fonts self-hosted.
- **Age and records:** under-18s blocked from registration. An incident register with notification templates.

### P. Platform qualities

- **Performance budgets** (production, mid-range Android on 4G):
  - LCP ≤ 2.0 s, INP ≤ 200 ms, CLS ≤ 0.05
  - public HTML edge-cacheable
  - hero content visible without JS
  - ≤ 120 KB gzipped JS on content pages (globe and map lazy-loaded)
  - AVIF/WebP responsive images
- **Accessibility:**
  - WCAG 2.2 AA throughout, with particular care for 2.4.11 (focus not obscured), 2.5.7 (dragging alternatives on floor plan and uploads), 2.5.8 (target size), 3.2.6 (consistent help), 3.3.7 (redundant entry) and 3.3.8 (no puzzle CAPTCHA)
  - reduced-motion respected
  - pause controls on all moving content
- **Security:**
  - CSP with nonces, HSTS, rate limits, honeypot and Cloudflare Turnstile
  - signed URLs, least-privilege roles
  - full audit trail, backups, health checks and monitoring
- **Responsiveness:** a test matrix at 320, 360, 390, 768, 1024, 1280, 1440, 1920 and 2560 px, plus landscape phone.

### Q. Pitch demo layer

- `DEMO_MODE` flag:
  - a persistent "Demo" ribbon
  - demo data clearly labelled (fictional companies marked as demo)
  - a seeded dataset that covers every state: draft, submitted, approved, part-paid, paid, visa stages, meetings, check-ins and results
- **Demo control panel:** one-click sign-in as Buyer, Exhibitor, Association, Finance officer, Visa desk, Super admin, Check-in operator; reset demo data.
- **Guided walkthrough:** a step list that drives the live demo in the order of the pitch story.
- Payments in sandbox; emails captured (Mailpit) and viewable in the demo panel; WhatsApp on the log driver.

## 6. Experience design

### Design direction (my call; confirmed at the Phase 1 style-tile review)

- **Mood:** warm, confident, editorial: "two textile and trade cultures meeting", not "government portal" and not "flag colours".
- **Light-first pages, with dark moments:** the hero, the globe band and the countdown. This deliberately contrasts with the competitor's dark-green-everywhere look.
- **Brand motif:** a geometric pattern system derived from **Jamdani weaving** (Bangladesh) crossed with **Brazilian modernist tilework** (Athos Bulcão, Burle Marx pavements). Used in section dividers, badge backgrounds, PDF letterheads, fascia previews and loading states. Never a literal flag.
- **Palette** (contrast-checked in `03` §G.4):

  | Role | Colour |
  |---|---|
  | Surface | Jute cream `#FBF7EE` |
  | Ink | `#1F2A44` |
  | Headings / links | Brazil navy `#002776` |
  | Primary action | Bottle green `#004F3A` (white text 9.6:1) |
  | Highlight fills | Ipê yellow `#FFDF00` (fills only, navy text) |
  | Live / alert | Crimson `#B3122A` |
  | Dark sections | Midnight `#071A33`, with mint `#3DDC97` and yellow accents |

  Raw flag colours are never used as text on white.
- **Typography:** Anek Bangla (variable width and weight) for display in all three languages, Inter for Latin body, Noto Sans Bengali for Bangla body.
  - Bangla runs at about 1.08× size with line-height 1.75.
  - No letter-spacing on Bangla.
  - Bangla numerals in BN copy and stats; Latin digits in IDs, phones and booth numbers.
  - Self-hosted, with a `unicode-range` split.
- **Imagery:** BBCCI's real 2025 photos, used sparingly and cropped well, without a heavy duotone. Product and factory photography from exhibitors as it arrives. Stock only where unavoidable, and credited.
- **Motion:** GSAP + ScrollTrigger for reveals and scrubbed counters; Lenis on marketing pages only (never portals or forms); View Transitions as progressive enhancement. **No pinned scroll sections.** Never split Bangla into characters. A "Reduce motion" toggle, with OS reduced-motion respected.
- **Page templates are distinct by type.** Home, landing (exhibit/visit), editorial (sector, news), utility (travel, city guide, FAQ), directory (exhibitors/catalogue), form/wizard, portal, console. Key facts (dates, venue, price, next step) sit above the fold on every landing page. Pages are kept to about 5 screens or less, with progressive disclosure (tabs and accordions) instead of endless scroll.

### UX principles

- **Role first.** Every visitor reaches their path in one click: Exhibit · Visit/Buy · Sponsor · Press · Association.
- **Never lose work.** Autosave on every form step. Resume from email link or account. An unsaved-changes guard.
- **Always say what's next.** Every status screen shows the current step, who has the next move, and the deadline.
- **Redundant entry eliminated.** CNPJ/CEP lookup, company data inherited by staff badges, "billing same as company", Excel import.
- **Errors in plain language** in the user's language, linked to the field, with an example of a correct value.
- **Help is always one tap away** in the same place (assistant, WhatsApp, contact). It never overlaps content or a focused field.
- **Mobile-first portals.** Large targets, bottom-sheet actions on phones, camera upload for documents.

### Attention-to-detail checklist (applies to every phase)

- Loading skeletons; designed empty states with a next action; success states that celebrate.
- Locale-aware formatting for numbers, currency, dates and times, including Bangla lakh grouping.
- Focus rings visible on every interactive element; skip link; correct `lang` attributes per route and inline.
- Favicon set, per-page OG images with the edition name, print stylesheets for badges, invoices and programme.
- Copy reviewed for consistency (one name for each thing across pages, emails and PDFs).
- Microinteractions: button press states, toasts, copy-to-clipboard, countdown tick, form progress.
- No horizontal scroll at any width. Safe-area insets on phones. Images never stretched or cropped through faces.

## 7. Architecture

### Stack (my call; versions verified 2026-10-19, see `03` §F and §R.1)

| Layer | Choice |
|---|---|
| Framework | Laravel 13.37, PHP 8.4 |
| Database | **PostgreSQL 17** (dev and prod; JSONB for translations, pgvector available for later semantic matching). Tests may use a separate PostgreSQL database. |
| Public site and participant portal | Blade + **Livewire 4** + Alpine + **Tailwind CSS 4** (custom design system, not a UI kit look) |
| BBCCI console | **Filament 5** panel, themed to the brand |
| i18n | mcamara/laravel-localization (EN at root, `/pt/…`, `/bn/…`, localised slugs) · spatie/laravel-translatable (+ lara-zeus/spatie-translatable for Filament) · laravel-lang · spatie/laravel-translation-loader (DB-editable strings) |
| Settings | spatie/laravel-settings + Filament settings plugin |
| Auth and roles | Laravel Fortify (passkeys, TOTP) · email magic links · spatie/laravel-permission + Filament Shield |
| Workflows | spatie/laravel-model-states (application, registration, payment, visa state machines) |
| Audit | spatie/laravel-activitylog |
| Media | spatie/laravel-medialibrary (+ responsive images, AVIF/WebP) |
| PDFs | **spatie/laravel-pdf v2**: Browsershot/Chrome driver in dev, **Gotenberg** container in prod; golden-file test with conjunct-heavy Bangla. **Never dompdf.** |
| Excel | spatie/simple-excel (imports), pxlrbt/filament-excel (exports) |
| QR / wallet | chillerlan/php-qrcode ^5 · spatie/laravel-mobile-pass |
| Queues and realtime | Redis + Horizon (prod), database queue (dev) · Laravel Reverb |
| SEO | artesaos/seotools · spatie/schema-org · spatie/laravel-sitemap |
| Security / ops | spatie/laravel-csp · spatie/laravel-honeypot + Turnstile · spatie/laravel-backup · spatie/laravel-health · Pulse/Nightwatch |
| Front-end libraries | GSAP 3.15 · Lenis · cobe or globe.gl (globe, lazy) · MapLibre GL + OpenFreeMap tiles · barcode-detector polyfill |
| AI (flagged) | laravel/ai with Claude models (translation drafts, assistant, match reasons) |
| Testing | Pest (version is builder's call) with Pest browser tests on critical flows; axe checks; Bangla PDF golden test |

**Avoid:** dompdf for Bangla; simplesoftwareio/simple-qrcode; the old Filament translatable plugin; unmaintained "file-vault" packages.

### Hosting (working value, my call; questionnaire 15.2 may change it)

- **Production:** managed VPS (or containers) in a **São Paulo region**, behind Cloudflare (CDN, WAF, Turnstile, edge cache for public HTML). Running: PostgreSQL 17, Redis, Horizon workers, Reverb, a Gotenberg container, and S3-compatible encrypted object storage.
- **Why São Paulo:** it keeps buyer data in Brazil under LGPD and gives fast first loads for Brazilians. Cloudflare's edge serves Dhaka.
- **Shared/cPanel hosting cannot run this design.** If BBCCI insists on it, that is a re-plan, not a tweak.
- **Staging** for the pitch has the same shape at a smaller size.
- **Accounts:**
  - Wallet passes need an Apple Developer organisation account and a Google Wallet issuer account. Without them, the demo shows a rendered pass preview with "Add to Wallet" disabled.
  - AI features need an Anthropic API key. Without it, they stay behind their feature flag.

### Shape of the application

- One Laravel monolith with three surfaces:
  1. **Public site** (cacheable).
  2. **Portal** (`/portal`): one branded Livewire app with role-based areas for exhibitor, delegate, buyer, association and sponsor.
  3. **Console** (`/console`): Filament, staff only.
- Plus a **PWA shell** (`/app`) for event-day features, and a **public verification endpoint** for invitation letters, certificates and badges.
- **Domain modules** (folders or namespaces, builder's call on exact layout): Editions & Settings, Content (CMS), Registration, Organisations & People, Applications, Finance, Exhibitor, Travel & Visa, Associations, Sponsors, Communications, Matchmaking & Meetings, Floor plan, Event day, Post-event, Privacy.
- **Everything edition-scoped:** an `Edition` model owns dates, venue, packages, deadlines and content, so 2027+ editions are configuration, not code.
- **Integrations sit behind interfaces with fake/log drivers,** so the demo works with no live accounts:
  - CNPJ: BrasilAPI → CNPJá fallback
  - CEP: BrasilAPI → ViaCEP
  - payments: bank, SSLCommerz, PIX
  - mail: SES/Postmark
  - WhatsApp
  - FX rates
  - translation
  - maps

### Core entities (indicative; builder finalises the schema)

| Area | Entities |
|---|---|
| Edition and content | Edition, Venue, Setting groups, Sector, Page/Section, NewsPost, Album/Media, Faq, Download, Partner, Sponsor, Speaker, ProgrammeSession, Place (city guide), Hotel |
| People | User, Organisation (country BD/BR/other; capabilities: buyer and/or seller; plus association and sponsor types), OrganisationMember. Sectors carry a trade direction (BD→BR export sectors, BR→BD export sectors). |
| Registration | Registration (type, status, badge code), RegistrationGroup, Invitation (signed link) |
| Consent and terms | Consent, ConsentPurpose, TermsVersion, TermsAcceptance |
| Applications and stands | Application, ApplicationDocument, Package, AddOn, PriceRule, Stand (floor plan) |
| Finance | Invoice, InvoiceLine, Instalment, Payment, Receipt, FxSnapshot |
| Exhibitor | ExhibitorProfile, Product, Fascia, StaffBadge, VaultDocument, ServiceOrder |
| Travel and visa | TravelProfile, PassportRecord, VisaChecklistItem, VisaSubmission, InvitationLetter |
| Associations | Association, ReferralLink, Quota |
| Meetings | MatchSuggestion, MeetingRequest, Meeting, MeetingTable, Slot, InterpreterRequest |
| Event day | Device, ScanEvent/CheckIn, Lead, Zone |
| Communications | EmailTemplate, MessageLog, Campaign, Segment, Enquiry |
| Post-event | Survey, SurveyResponse, Deal/Outcome, Certificate |
| Privacy and audit | AuditLog (activitylog), DataSubjectRequest, RetentionRule, Incident |

### Key state machines

- **Application:**
  - draft → submitted → under review
  - under review → changes requested → submitted (loop)
  - under review → approved → invoiced → part-paid → paid → confirmed
  - Side exits: rejected · withdrawn · cancelled (refund rules apply)
- **Registration:** draft → submitted → pending approval (for types that need it) → confirmed → checked-in. Side exit: cancelled.
- **Payment:**
  - Bank: pending → slip uploaded → verified or rejected.
  - Online: initiated → success or failed.
  - Refunded is a terminal state.
- **Visa:**
  - not started → documents in progress → letter requested
  - letter requested → letter drafted → BBCCI reviewed → [signatory approved] → [notarised] → [couriered] → letter issued. Bracketed steps are on/off per edition.
  - letter issued → submitted to embassy → approved or refused
- **Meeting:** requested → accepted or declined → scheduled → checked-in → held (outcome logged) or no-show.

## 8. Content plan

- **Real content from day one:**
  - BBCCI facts, leadership, 2025 history, programme and photos, from `research-assets/bbcci` and `01`
  - YouTube videos (`01` §13)
  - sourced trade statistics
  - sector rules, visa and travel facts, city guide places (`02` §3, `03` §A–B), re-verified and dated
- **Where facts are pending, show useful content rather than placeholders:**
  - deadline calendar generated from the opening date
  - "apply to speak" and "become a partner" CTAs
  - "prices confirmed by [date]: register interest to be notified"
  - a "last updated" date on every fact block
- **Copy:** English written first by us (the build team), from the research files. Portuguese and Bangla drafts are produced by AI translation and marked "needs review" in the translations editor until a human verifies them. Questionnaire 11.2 decides who verifies after the award. Content is a workstream inside each public-site phase, not an afterthought: each page's phase delivers its copy in all 3 languages.
- **Demo data:** fictional, labelled companies and people for portals and console. Never presented as real exhibitors or real results.

## 9. Delivery: small phases

Each phase ends in a working, demoable state with tests and a review. Each gets its own detailed implementation plan (writing-plans) just before it starts.

The **pitch cut** (★) is the set that beats the competitor in a live demo.

**Priority inside the pitch cut** (my call), used when time runs short. Higher tiers are never thinned to make room for lower ones:

1. **First impression at full polish** (Phases 1–4). The public site is what BBCCI judges first, and the competitor's is strong.
2. **The two journeys the competitor has, built for real** (Phases 5, 6, 7, 8). Visitor registration and badge; exhibitor application → console approval → invoice → payment.
3. **The visible "beyond" features** (Phase 12 matchmaking, plus a preview slice of Phase 14 floor plan). These are the strongest differentiators.
4. **Remaining portals** (Phases 9, 10, 11). Built real when time allows; otherwise as thin but working slices (each screen exists, each primary action works, with seeded data) so every role can still be walked through.

Phase 13 (pitch packaging) always happens, whatever was cut before it.

| # | Phase | Delivers | Gate |
|---|---|---|---|
| 0 | Foundation | PostgreSQL, PHP 8.4 toolchain, packages, Edition + settings, 3-locale routing with localised slugs, auth skeleton, roles, CI test setup, demo-mode flag | Tests green; `/`, `/pt`, `/bn` resolve |
| 1 | Design system and style tiles | Tokens, fonts, motif, components (nav, mega-menu, footer, buttons, cards, forms, stepper, tables, badges, modals, toasts), motion primitives, living style-guide page | **You review 2–3 style tiles in the browser and pick one** |
| 2 | Home page ★ | The full home page (§5A) at production polish, in 3 languages, with real photos, video, globe and countdown | Lighthouse and responsiveness matrix pass |
| 3 | Core public pages ★ | About, Organiser, Committee, Sectors (index + 9), 2025 archive and galleries, News, Contact, FAQ, Legal, 404/500, search | Content review |
| 4 | Participation and travel pages ★ | Exhibit, Packages + calculator, Apply explainer, Deadlines, Payment instructions, Visit, Sponsorship, Programme, Speakers, Partners, Venue, City guide map, Hotels, Travel & visa, Press, Downloads | Parity check against `02` §2 page list |
| 5 | Visitor registration and badges ★ | Hub and all wizards, CNPJ/CEP lookup, autosave, consents, group XLSX with per-member confirmation, signed invitations, QR badge (screen/email/PDF/wallet), manage-my-registration | End-to-end browser tests per type |
| 6 | Accounts and exhibitor application ★ | Org accounts, passkey and magic link, 5-step application, documents, package and stand choice, terms versioning, status timeline | Browser test: apply → submitted |
| 7 | Console v1 ★ | Filament console: settings, approvals desk, registrations, CMS for the pages built so far, roles, audit log, dashboards v1 | Staff can approve or reject and edit content |
| 8 | Finance ★ | Invoice and contract PDFs (3 languages, Bangla golden test), bank-slip flow, SSLCommerz sandbox, instalments, receipts, finance desk | Pay end to end in sandbox |
| 9 | Exhibitor portal ★ | Dashboard checklist, profile (3 languages + AI draft), products, fascia, team and staff badges, vault, e-manual and services, public exhibitor page | Portal walkthrough on phone and desktop |
| 10 | Travel and visa desk ★ | Passport and expiry warning, 16-item checklist, invitation letter with QR verification, visa tracker, console visa desk | Letter verifiable by QR |
| 11 | Association portal ★ | Referral links, quotas, applicants, exports, pay on behalf | Association walkthrough |
| 12 | Matchmaking and meetings ★ | Interests, suggestions with reasons, requests, slot grid and tables, ICS, reminders, interpreter requests, outcomes | Buyer books a meeting with an exhibitor |
| 13 | Pitch packaging ★ | Demo control panel, full demo seed, guided walkthrough, deploy to staging URL, pitch script | **Pitch-ready** |
| 14 | Floor plan and stand booking | SVG plan, availability, holds, pricing, admin allocation | n/a |
| 15 | Catalogue and RFQ | Public searchable catalogue, sector RFQs, enquiry inbox | n/a |
| 16 | Event day | PWA, QR check-in (offline), kiosk and badge printing, lead retrieval, zones, live dashboard | n/a |
| 17 | Communications | Full template set (50+ × 3), WhatsApp Cloud API, campaigns, AI assistant | n/a |
| 18 | Post-event | Surveys, deal tracker, results page, certificates, ROI reports | n/a |
| 19 | Hardening and launch | Performance, WCAG audit, security review, LGPD pack (DPO, ROPA, retention jobs), load test, production deploy, monitoring, backups | Launch checklist |

Phases 14–18 can be pulled forward into the pitch cut as lighter "preview" versions if time allows. The floor plan and lead retrieval are the most visible.

### Production releases after the award (my call; dates assume a March 2027 event)

Phase 19's checks are not saved for the end. Each release gets its own hardening gate: security review, WCAG check, load test of its flows, LGPD items it touches, backups and monitoring.

| Release | Target | Contents |
|---|---|---|
| R1 | ~December 2026 | Public site; exhibitor application; console (approvals, settings, CMS); finance (invoices, bank slip, SSLCommerz); visa desk and invitation letters; core privacy (consents, DPO notice, retention jobs, vault encryption) |
| R2 | ~January 2027 | Visitor registration and badges; association portal; exhibitor portal; catalogue and RFQ; matchmaking opens to buyers |
| R3 | ~February to early March 2027 | Floor plan; meeting scheduling at tables; PWA; wallet badges; check-in and kiosk; lead retrieval; WhatsApp reminders |
| R4 | After the event | Surveys, deal tracker, results page, certificates, ROI reports |

If the event dates change, the releases shift with them, keeping visa lead times (≥ 6 weeks before departure) for R1.

## 10. Left to the builder

- Exact package versions within the stated majors; Pest version (4.x on PHPUnit 12 or 5.x after bumping PHPUnit).
- Folder and namespace layout of domain modules, and the database schema details.
- Analytics tool (Plausible vs GA4 Consent Mode), within the consent rule.
- Globe library (cobe vs globe.gl), map tile provider (OpenFreeMap vs MapTiler), mail catcher for dev (Mailpit via Docker or the log driver).
- How the guided walkthrough is implemented.

## 11. Pitch defaults (decided 2026-10-19, following the competitor's approach)

The user asked us to settle these the way the competitor did:

| Topic | Decision |
|---|---|
| Pitch date | Unknown. Build in the §9 priority order (polish first, then the competitor's journeys for real, then differentiators, then remaining portals) and keep the build demoable at the end of every phase. |
| Staging hosting | **We host the pitch demo on our own agency subdomain** (as the competitor hosts theirs on `expo.javeditsolution.com`), on a VPS we control, behind Cloudflare, with `noindex`. Production hosting follows §7 after the award. |
| Wallet passes | **Preview mode.** A rendered Apple/Google pass with "Add to Wallet" disabled until developer accounts exist. The competitor has no wallet passes at all. |
| AI features | **Built behind a feature flag, off by default.** Demoed only if an Anthropic API key is supplied. Nothing in the pitch depends on it. |
| Languages | **Full trilingual, like the competitor.** We write English. We draft Portuguese and Bangla with care: natural phrasing, Bangla numerals, correct terminology. Everything is flagged "needs review" in the translations editor until a native speaker signs off. |

## 12. Open questions (client answers replace assumptions)

These are the client questionnaire's starred items, most importantly:

- the requirements brief
- confirmed name, dates and venue
- fees and packages
- bank and merchant accounts
- invoice entity details
- who signs invitation letters
- associations involved
- languages and translation ownership
- domain and hosting
- launch date

Until answered, the working values in §4 apply.
