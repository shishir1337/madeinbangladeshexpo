# 02: Competitor teardown of Javed IT Solution's "Made in Bangladesh Expo" demo

- **Target:** https://expo.javeditsolution.com/ (built by Javed IT Solution for BBCCI)
- **Researched:** 19 October 2026 (the sitemap `lastmod` values run from 17 to 19 October 2026, so the demo was still being edited during this research)
- **Scope:** every URL in `sitemap.xml` (162 URLs: 54 pages × EN / PT-BR / BN), plus public pages that are not in the sitemap (`/login`, `/account/create`, `/forgot-password`, `/register/{type}/group`, 404), the public JS/CSS bundles, HTTP headers, robots.txt, the one public download, and the Bangla demo-video transcript (`youtube_transcript.txt`).
- **Method:** curl/HTML extraction of all 162 pages; Playwright at 1440×900 and 390×844 (DPR 2) for screenshots, LCP/CLS, request counts and console errors; Chrome to observe client-side validation; static reading of the public Vite bundle (`/build/manifest.json` and 144 JS chunks).
- **Rules followed:** I did not log in, create an account, submit or upload anything, or type personal data. The one interaction was pressing **Continue** on an empty wizard step to see validation. The cookie banner was answered with **Reject all**. One request to `/portal` returned a 302 to `/login` with no content.
- **Raw data (scratchpad, not committed):** `…/scratchpad/jv/` holds the HTML, extracted text, assets and metrics.
- **Screenshots:** `docs/research/competitor-screens/` (47 JPGs; the files are listed in §9.6).

---

## 0. Executive summary

The demo is **much stronger than a typical agency mock-up.** Expect the BBCCI committee to be impressed by it. It is a custom Laravel and Vite build that is fully trilingual (EN/PT-BR/BN). Its content is deep and sourced: trade statistics, tariffs, ANVISA rules and a 16-item visa checklist, each with a check date. It has about 80 bespoke interactive "explainer" components. The registration wizards are production-grade, with CNPJ/CEP auto-fill, autosave and resume, granular LGPD consents and group upload from XLSX. The public JS bundle also shows a sizeable admin platform already in code: CRM pipeline, campaigns and journeys, helpdesk, inbox, QR check-in with an offline queue, a content and translation editor, and an on-page "guided mode".

The demo also has clear weaknesses:

1. **Most 2026 business content is empty ("to be announced").** Speakers (0), partners, committee messages, deadlines, 2026 fees and packages, downloads (1 file), the exhibitor directory (0 entries), the hotel block and office hours are all unfilled. In effect it is a polished shell.
2. **There are no B2B matchmaking tools.** The site has no meeting scheduler, interactive floor plan or stand booking, product catalogue or search, exhibitor lead retrieval, mobile app or PWA, wallet passes, live chat or AI, video or virtual tour, or sponsor and exhibitor analytics.
3. **Online payment is not live.** SSLCommerz is wired into the CSP, but the site says online payment is "not switched on yet". There is no PIX or BRL option.
4. **The privacy practice contradicts the privacy story.** A first-party script `/_a/a.js` runs on all 162 pages without any consent check. It does canvas fingerprinting, reads the unmasked WebGL GPU, battery level, high-entropy client hints, storage and media-device counts, and tracks every click with coordinates. This contradicts their own cookie policy ("analytics only with consent", "nothing before you reach it") and is an LGPD risk. A Cloudflare Web Analytics beacon also loads and is not listed in their cookie table.
5. **UX and performance costs come from the visual ambition.** Every page uses the same full-screen, dark-green-tinted photo hero. Pages are very long (home 12,300 px on desktop and 13,700 px on mobile; travel 14,500 px). A pinned scroll section creates about 1,400 px of dead scroll on the homepage. Homepage LCP is 4.6 s on desktop and 5.5 s on mobile (lab test, unthrottled). TTFB ranges from 0.7 to 2.4 s on a shared LiteSpeed host. The crawl hit intermittent Cloudflare 520/525 errors and one 22-second timeout. On mobile, the WhatsApp button overlaps content.
6. **Content inconsistencies.** The edition is called "2026" but runs in March 2027. The travel page still shows **November** weather. Several CTAs still say "you'll get the dates and venue when confirmed" although they are confirmed. Two 2025 exhibitors have no sector, and press-card headlines are cut off.

**Pitch stance:** match everything they show one for one. That is non-negotiable, because BBCCI has seen it. Then win on **business outcomes** (matchmaking, floor plan, lead capture, live payments, analytics), **trust** (genuine LGPD compliance, uptime and performance), and **event-day tooling** (PWA, wallet badges, scanning).

---

## 1. Technology stack (confirmed from headers, HTML and bundles)

| Layer | Finding | Evidence |
|---|---|---|
| Backend | **Laravel** (session cookie `made-in-bangladesh-expo-session`, `XSRF-TOKEN`, `csrf-token` meta, 419 handling, `/csrf-token` refresh route) | HTTP headers, `mbe-config` JSON |
| Web server / host | **LiteSpeed** (`x-turbo-charged-by: LiteSpeed`) behind **Cloudflare** (proxy, NEL, Speculation-Rules). HTML is not edge-cached (`cf-cache-status: DYNAMIC`, `Cache-Control: no-cache, private`), which points to cPanel-style shared hosting | Response headers |
| Front-end build | **Vite** (`/build/assets/*`, public `/build/manifest.json` with 153 entries) | manifest |
| CSS | **Tailwind CSS v4.3.3** plus a large custom design-system stylesheet (472 KB raw / 76 KB brotli), `color-mix()`, `clamp()`, container queries, about 70 `:focus-visible` rules, about 60 `prefers-reduced-motion` rules | CSS bundles |
| JS architecture | Vanilla ES modules lazy-loaded by `data-module="…"` (about 80 modules on public pages, about 60 of them bespoke `v-*` visual explainers). **No Alpine, Livewire, React or Vue.** AJAX forms (`data-ajax`) with toasts | `app-CtLOugul.js` (183 KB raw / 63 KB br) |
| Animation | **GSAP 3.x + ScrollTrigger**, **Lenis 1.3.26** smooth scroll | bundle strings |
| Globe | **d3-geo + topojson-client + world-atlas land-110m** (custom orthographic globe, drag to rotate, "replay routes") | manifest |
| Map | **Leaflet** with **OpenStreetMap public tiles** (`tile.openstreetmap.org`). No clustering | manifest, CSP |
| Sliders | Custom slider module (92 KB chunk, probably a vendored carousel), custom hero slider with pause/play | manifest |
| Drag-sort (admin) | **SortableJS** | manifest |
| Fonts (self-hosted woff2) | **Bricolage Grotesque** (display), **Inter** (UI/body, with metric-matched fallback), **Hind Siliguri** (Bangla), **Sabbir Sorolota** (Bangla numerals only, via `unicode-range`), a mono font | `@font-face` |
| Accessibility add-on | **VLibras** (Brazilian government Libras sign-language widget), loaded on all 54 PT pages | CSP, `data-module="vlibras"` |
| Analytics | (a) **First-party `/_a/a.js` → `collect.php`**: pageview, dwell, scroll %, clicks, canvas fingerprint, WebGL GPU, battery, client hints, storage and media devices. **No consent gate.** Comments in the code are in Bangla. (b) **Cloudflare Web Analytics** beacon. (c) **GA4** slot via GTM, empty (`"ga4":""`), with consent-gated copy | `a.js`, network log |
| Payments | **SSLCommerz** (sandbox and securepay) allowed in CSP `form-action`. bKash, Nagad and card are promised "when enabled". `pay-online.js` and `pay-slip.js` modules exist | CSP, page copy |
| Security | Strict **CSP with per-request nonce**, HSTS (1 yr), XFO SAMEORIGIN, nosniff, Referrer-Policy, Permissions-Policy (camera, mic, geo and payment off). Honeypot field plus signed timestamp `_ft` on every form. CSRF auto-refresh on 419 | headers, forms |
| SEO plumbing | Per-page title, description and canonical; hreflang (en, pt-BR, bn, x-default) in the HTML **and** the XML sitemap (648 `xhtml:link` alternates); OG and Twitter cards with alt text; JSON-LD | §10.1 |
| Indexing | **`X-Robots-Tag: noindex, nofollow…`** header on the demo, which conflicts with the meta `index, follow`. Expected for a staging demo, but it must be removed for production | headers |
| robots.txt | Explicitly allows AI crawlers (`Content-Signal: ai-train=yes`) and disallows `/portal /admin /ajax /payments /documents /m/ /forms` | robots.txt |

**Admin and portal surface visible in the public bundle** (code is shipped, but the video says much of it is "still to be done"):

- **Admin desks:**
  - Content: `content-pages` (show/hide sections, toggle motion graphics, draft preview), `content-media` (bulk upload of 30 images, focal point), `content-translations`, `templates` (e-mail templates with EN fallback per language)
  - Forms and pricing: `forms` (drag-order), `pricing` (preview)
  - Applications: `applications-list`, `applications-decide`, `approvals`
  - CRM and messaging: `pipeline` (CRM with lost-reason), `crm-orgpick`, `segments`, `campaigns`, `campaigns-journeys`, `inbox`, `helpdesk`
  - Event day: **`checkin`** (camera QR scanning via `BarcodeDetector`, named devices, offline scan queue that syncs when back online, live "today" stats)
  - Shell: role-based actions ("Your role does not include this action"), idle sign-out warning, unsaved-changes guard
- **Guided mode:** `guide.js` and `guide-hotkey.js` (`/gm/status`) provide an on-page editing overlay. You click layers of the live page to edit them, which is how they will pitch "run it without a developer".
- **Portal modules:** `portal-shell/home/progress` (animated task checklist), `apply-wizard`, `apply-docs`, `apply-quote` (live USD/BDT quote), `exh-form`, `exh-live` (live profile preview), `exh-fascia` (fascia name with character counter and uppercase preview), `exh-vault` (document vault with "sensitive" flag), `pay-slip`, `pay-online`, `v-portal-fin-*` (invoice, receipt, badge), `travel-form`, `v-portal-travel-passport/checklist/file/track/clock` (the visa desk), `reg-group` and `reg-manage` (self-service registration management; probably the `/m/` magic-link pages).

---

## 2. Site map and page inventory

All 54 pages exist in three languages (EN at the root, `/pt/…` and `/bn/…`). PT slugs are localised for top-level pages but **stay in English** for sectors, news, galleries and registration sub-types (for example `/pt/setores/garments` and `/pt/credenciamento/buyer`). Raw HTML weight is 141–306 KB per page; brotli transfer for the HTML is 20–33 KB.

| # | EN path | PT path | Purpose | Main interactive components |
|---|---|---|---|---|
| 1 | `/` | `/pt` | Home | Announcement bar, mega-menu (countdown, dual clocks, latest news), 4-slide hero, role cards, countdown with SP/Dhaka 24-h timezone ruler, intro and edition comparison, stat story (5 sourced stats), **trade-route globe**, sector bento grid (9), 2025 highlights and photo slider with lightbox, press timeline chart (8 articles), bilateral timeline 1972→2027 (horizontal, pinned), venue diagram with 4 distance buttons, partner wall, CTA band, newsletter, cookie banner, WhatsApp widget |
| 2 | `/about` | `/pt/sobre` | What the expo is | Hero slider (each slide jumps to a section), "key facts" scene picker, audience cards, format list, "Why São Paulo" stats |
| 3 | `/organiser` | `/pt/organizador` | About BBCCI | Mission and vision, 6 objectives, 7 services, leadership board diagram, membership CTA, Dhaka office card with live Dhaka time |
| 4 | `/committee` | `/pt/comite` | Organising team | 4 people; "Messages" section **empty** |
| 5 | `/sectors` | `/pt/setores` | Sector index | 9 tilt cards each with one sourced figure; a "two sources, two fiscal years" explainer |
| 6–14 | `/sectors/{garments, textiles, pharmaceuticals, leather, jute, agro-food, handicrafts, plastics, ict}` | `/pt/setores/{same}` | Sector deep-dives | Key figures (3–4, sourced), HS chapters, duties and regulation text, 2025 exhibitors from that sector (logos), previous/next pager |
| 15 | `/programme` | `/pt/programacao` | Programme | São Paulo→Dhaka time slider; 4 expo days (TBA); 2025 programme for reference |
| 16 | `/speakers` | `/pt/palestrantes` | Speakers | Pipeline graphic; **0 speakers** |
| 17 | `/partners` | `/pt/parceiros` | Partners | 2025: BBCCI and the Embassy of Brazil; 2026: **TBA** |
| 18 | `/2025` | `/pt/2025` | 2025 archive | Journey timeline, key facts, Gantt-style programme, logo wall (15), gallery slider (14 photos), 2 albums, press list |
| 19–20 | `/gallery/made-in-bangladesh-expo-2025-sao-paulo`, `/gallery/dhaka-launch-8-january-2025` | `/pt/galeria/…` | Albums (12 and 2 photos) | Lightbox, ImageGallery schema |
| 21 | `/exhibit` | `/pt/expor` | Why exhibit | Market stat story, stall-benefits diagram (6), package table and cards, **cost calculator (USD + BDT)**, "Ask about a stall" form, 6-step "whose move" process, goods-travel explainer (shown / sold / health products), deadlines (TBA), FAQ teaser |
| 22 | `/stand-packages` | `/pt/estandes` | Packages and fees | Exhibitor vs delegate toggle, package table, calculator, included / not-included cards, "Ask about a stall" form |
| 23 | `/exhibit/apply` | `/pt/expor/inscricao` | How to apply | 5-step wizard animation, **document checklist with ticks saved in localStorage** (6 docs), ANVISA explainer (medicines, devices, cosmetics, food), status timeline (6 states), "Start application" → `/portal/application` |
| 24 | `/deadlines` | `/pt/prazos` | Deadlines | Plan-backwards chart drawn to scale, clocks; all 4 deadlines **TBA** |
| 25 | `/payment-instructions` | `/pt/pagamento` | How to pay | Method filter (In BD / Abroad), bank details hidden until login, receipt-flow stepper, FAQ |
| 26 | `/sponsorship` | `/pt/patrocinio` | Sponsorship | "Bridge" diagram, 5 categories (price on request), proposal request form |
| 27 | `/visit` | `/pt/por-que-visitar` | Why visit (buyers) | Stat story, sector list, 2025 vs 2026 "Full Pass" ticket, 4-step phone mock-up (CNPJ → e-badge → plan → QR entry), buyer FAQ |
| 28 | `/register` | `/pt/credenciamento` | Registration hub | 6 role cards with audience filter, 3 group-registration links, "resend my badge" form |
| 29–34 | `/register/{buyer, trade-visitor, delegate, vip, press, speaker}` | `/pt/credenciamento/{same}` | Registration wizards | See §4 |
| 35 | `/register-interest` | `/pt/cadastro-de-interesse` | Interest capture | Tabs: All participants / Buyers in Brazil |
| 36 | `/exhibitors` | `/pt/expositores` | Exhibitor directory | **Empty**; list of 2025 exhibitors as fallback |
| 37 | `/venue` | `/pt/local` | Venue | Venue facts, visitors vs loading entrance toggle, distance/time switch, nearby filter list, 2025 venue card |
| 38 | `/city-guide` | `/pt/guia-da-cidade` | City guide | Straight-line vs road comparator, **Leaflet map with 35 places**, 8 category filters, cards (address, phone, website, directions, "Show on the map", check date) |
| 39 | `/hotels` | `/pt/hoteis` | Hotels | Distance scale, "official room block TBA" card, 8 hotels with phone and website (no rates, no booking) |
| 40 | `/travel` | `/pt/viagem` | Travel and visa | 7-step visa navigator (16-item file), yellow-fever going/returning tabs, flight hubs, GRU→venue mode tabs, **business travel-quota calculator** (USD→BRL), phone/eSIM chooser, plug and voltage toggle, weather, halal and prayer map, emergency numbers, section for Brazilians travelling to BD |
| 41 | `/news` | `/pt/noticias` | Newsroom | Type filter (News 3 / Press releases 2 / Media coverage 8), pagination, latest slider, media-kit note |
| 42–46 | `/news/{5 slugs}` | `/pt/noticias/{same}` | Articles | NewsArticle schema; share (WhatsApp, LinkedIn, X, e-mail, copy, native share) |
| 47 | `/press` | `/pt/imprensa` | Press centre | Press-badge mock-up, 4-step accreditation explainer, mailto composer, coverage list, press enquiry form |
| 48 | `/downloads` | `/pt/downloads` | Document library | 9 categories, **1 file** (2025 briefing PPTX, 5.9 MB); some files are gated by name and e-mail (`media-gate`) |
| 49 | `/faq` | `/pt/perguntas-frequentes` | FAQ | **48 Q&As** in 6 audience tabs, live search with result count, FAQPage schema |
| 50 | `/contact` | `/pt/contato` | Contact | Desk cards (Dhaka, plus São Paulo "to be announced") with live local times, map links, topic-routed form, WhatsApp section |
| 51–54 | `/legal/{privacy, terms, refunds, cookies}` | `/pt/legal/{privacidade, termos, reembolso, cookies}` | Legal | Versioned (2026.1, 17 Oct 2026), sticky table of contents |

**Public routes outside the sitemap:**

- `/login`: e-mail, password with show/hide, "keep me logged in", language switch
- `/account/create`: name, e-mail, password (≥10 characters, upper and lower case, a number), account type (exporter / buyer / other), phone, e-mail language, terms checkbox
- `/forgot-password`
- `/register/{buyer, trade-visitor, delegate}/group` (PT: `/pt/credenciamento/{type}/grupo`)
- `…/group/template.xlsx`
- `/downloads/file/{id}`
- A custom 404 page. It contains no menu but tells the visitor to "use the menu".
- No `llms.txt`, manifest, service worker, security.txt, RSS or site search.

---

## 3. Page-by-page notes (facts and copy that matter)

### Home (`/`)

- **Meta title:** "Made in Bangladesh Expo 2026 · São Paulo, Brazil | BBCCI".
- **Hero slides (4):** (1) the expo and dates, with CTAs "Register interest" and "About the expo"; (2) Show your products to Brazilian buyers, "Apply to exhibit"; (3) Meet Bangladeshi manufacturers, "Pre-register"; (4) Organised by BBCCI, "About BBCCI". The slider auto-advances every 6.5 s and has pause, previous, next and dots.
- **Countdown:** targets 2027-03-22 10:00 BRT (19:00 Dhaka), with a 24-hour dual-timezone ruler.
- **Stat story:**
  - Bangladesh has been Brazil's 2nd-largest clothing supplier every year 2018–2025.
  - 10.2% of Brazil's clothing imports came from Bangladesh in 2025.
  - Bangladesh's exports to Brazil reached a record US$215 m in FY2025-26 (+14.6%).
  - Bilateral trade was about US$3 bn in 2025 (BR→BD US$2,710 m, BD→BR US$266 m).
  - Brazil has 213 m consumers and US$2.3 tn GDP.
  - Each stat carries a source and date (ComexStat, EPB, World Bank).
  - A 4-step narrative follows: Brazil already buys → room to grow → meet in SP → orders and shipping (about 29 days by sea).
- **Trade routes:** sea Chattogram→Santos about 29 days; air Dhaka→GRU 3–7 days; 78% of exports go by sea and 22% by air (Jan–Sep 2026); main ports of entry are São Francisco do Sul and Santos.
- **Timeline:** 1972 recognition → Apr 2024 first Brazilian FM visit → 8 Jan 2025 launch → Jan–Feb 2025 Rangpur and Chattogram promotion → 16–18 Jun 2025 1st edition → 16 May 2026 2nd edition announced → 22–25 Mar 2027.
- **Footer:** contact, WhatsApp, newsletter (e-mail plus a required marketing-consent box, double opt-in), legal links, "Cookie settings", "Developed by Javed IT Solution".

### About, Organiser, Committee

- **BBCCI:** licensed by the Ministry of Commerce, Bangladesh; the Chief Patron is the Ambassador of Brazil to Bangladesh.
- **Leadership:** President **Shahriar Ahmed**, VP **Md. Saiful Alam**, Secretary General **Md. Joynal Abdin**, Director **Imran Chowdhury**; Board of 18 members.
- **Services:** matchmaking, trade promotion, market intelligence, investment facilitation, advisory, training, and recommendation and visa-reference letters.
- **Why São Paulo:** São Paulo-state importers took 35.1% of Bangladesh's exports to Brazil; 29.4% of customs entries went through Santos; Brás is 2.7 km from the 2025 venue.
- **Stale copy:** the About CTA still says "you'll receive the dates and venue when BBCCI confirms them".

### Sectors (9 pages): figures each page publishes

| Sector | Key figures shown | Rules mentioned | 2025 exhibitors listed |
|---|---|---|---|
| Garments | 2nd supplier; US$240 m (10.2%); 92% of BD→BR exports (~US$198 m); 35% duty on all 243 lines (HS 61–62) | PT labelling; LEED, WRAP, OEKO-TEX, GOTS and ISO certificates | Apex Lingerie, BAB Trend Fashion, Benchmark, Blue Planet Group, Marsik, Mitali Group, Pioneer Casual Wear, Renaissance Group, STS Apparel |
| Home & technical textiles | US$928 m BD exports; Brazil HS 63 imports US$377 m; BD share 0.3% | 35% linen and carpets, 26% fabrics, 18% yarn, 16.2% bedding | BPG, Marsik, Mitali, Renaissance |
| Pharmaceuticals | US$238.5 m; Brazil HS 30 US$14.5 bn; duty 0–12.6% | ANVISA registration plus local holder; unregistered medicines cannot be exhibited | Biocell, Chemist |
| Leather & footwear | Footwear US$1.22 bn; HS 42 US$680 m; HS 64 US$629 m | 35% most footwear; 18% + 6.5% IPI on leather bags; LWG | none |
| Jute | 18.1% share of HS 53; US$884 m (+7.75%); 0% quota of 2,095 t for raw jute | Anti-dumping US$0.16/kg on jute sacks until 16 Sep 2027 | none |
| Agro-food | Agri US$1.0 bn; fish US$443 m; Brazil HS 03 US$1.44 bn | MAPA plant approval, ANVISA labelling, 30-day expiry rule | none |
| Handicrafts & décor | HS 69 US$364 m; HS 94 US$1.40 bn; 18% tableware | ANVISA lead and cadmium limits | none |
| Plastics & toys | HS 39 US$11.0 bn; HS 95 US$1.16 bn | INMETRO certification for toys | Aman Plastic Toys |
| ICT & software | 9 h time difference; 3.5% IOF; 50% ERQ retention | 25% withholding tax; no tax treaty | Maha Telecom |

Each sector page is short (3–4 figures plus about 4 paragraphs). Images are Pexels stock. There is no product, exhibitor or buyer search.

### Exhibit, Stand packages, Apply

- **Six exhibitor benefits:** meet buyers, launch products, brand exposure (directory microsite), market research, partnerships (a Siscomex importer is needed), and lead follow-up.
- **Process ("whose move"):** you apply online → you upload documents → BBCCI reviews → BBCCI issues the proforma invoice and contract → you pay → you prepare.
- **Customs explainer:** Brazil does not accept ATA Carnets; goods enter under temporary admission through a CNPJ consignee; goods to be sold need a regular import; ANVISA rules apply.
- **2025 document checklist:** trade licence, TIN, VAT registration, export licence, owner's profile, and certificate of incorporation.
- **Application status flow:** Submitted → Under review → Approved (invoice and terms) → Payment received → Participation confirmed → Prepare.

### Payment instructions

- **Methods:**
  - In Bangladesh: bank transfer, pay order or counter deposit in taka, with the invoice number as reference and the slip uploaded in the portal.
  - In Bangladesh, later: online card, bKash or Nagad, "when enabled" (**not live**).
  - Abroad: SWIFT in USD to Dhaka, with the confirmation uploaded.
- **Anti-fraud:** bank details are shown only in the portal and on the invoice.
- **Receipts:** a 4-stage flow from Unpaid → BBCCI checks → Paid → money receipt (download plus e-mail).

### Visit (buyers)

- **Stats:** 2nd supplier; 10.2%; Bangladesh supplies 18.1% of Brazil's HS 53 imports; 285+ LEED garment factories.
- **2025 "Full Pass" (R$0 with pre-registration):** sector talks, conferences, business rounds, networking, meeting room, full access.
- **Steps:** pre-register with CNPJ (auto-fill; the new alphanumeric CNPJ is accepted) → QR e-badge by **e-mail and WhatsApp** → plan the visit from the directory and programme → QR at the entrance.

### City guide, Hotels, Venue, Travel

- **Venue:** Pro Magno Centro de Eventos, Av. Professora Ida Kolb 513, Casa Verde, 02518-000. Exhibitor loading is at Rua Samaritá 230. One pavilion on 4 floors, rooftop food court, about 1,000 covered parking spaces. Phone +55 11 4010-5100.
- **Distances:**
  - GRU: 21.9 km straight line, 28.4 km by road, about 28 min
  - CGH: 18 km by road
  - VCP: 88 km
  - Palmeiras-Barra Funda: 1.9 km straight line, 2.7 km on foot, then bus 9784-10
- **City-guide places (35):** venue 1, airports 3, transit 5, hotels 8, mosques 4, wholesale districts 6 (Bom Retiro, Brás, Pari, Mega Polo Moda, 25 de Março, Santa Ifigênia), official bodies 4 (ACSP, FIESP, Embassy of Bangladesh in Brasília, Embassy of Brazil in Dhaka), essentials 4. Each place has a check date.
- **Hotels (8, with distance and no rates):** Holiday Inn Parque Anhembi 3.1 km, Luz Plaza 4.2, Golden Tower Express Anhembi 4.4, HLN 4.7, Hotel Luni 4.7, Novotel Center Norte 4.9, Hotel LM 5.9, Hotel Mega Polo 5.9. The venue's 5 partner hotels are named in text only (Mercure, Rio Hotel by Bourbon, Wyndham Garden Convention Nortel, Ibis and Ibis Styles Barra Funda). The page states there is **no official room block**.
- **Travel:**
  - Visa: VIVIS business visa, 16-item file, fee **BDT 11,200**, up to 20 working days, appointments by phone Sun–Tue 09:30–10:00.
  - Health: yellow fever is required on the **return** to BD.
  - Flights: one stop via DXB, DOH, IST or ADD, 24–32 h in total.
  - Customs: e-DBV declaration thresholds.
  - Money: BD business travel quota of US$400/day, US$4,000/trip and US$10,000/year; R$4.99 per US$.
  - Practical: Pix is not usable without a CPF; eSIM advice; 127/220 V with N/C plugs.
  - Weather: shows **November** figures (bug: the expo is in March).
  - Emergency numbers: 190, 192, 193, 156.
  - A section for Brazilians travelling to BD: visa R$170.

### Newsroom, Press, Downloads, FAQ, Contact

- **News:** 5 items: 17 Oct 2026 dates and venue confirmed; 16 May 2026 2nd edition announced (originally a tentative 20–30 Nov 2026, 3 days); 16 Jun 2025 opening; 1 Feb 2025 Rangpur and Chattogram; 8 Jan 2025 Dhaka launch. There are also 8 external media-coverage items (Propmark, TBS ×3, Daily Star ×2, Daily Observer, Dhaka Tribune).
- **FAQ:** 48 questions in 6 tabs (General 8, Exhibitors 13, Buyers 8, Visitors 5, Delegates 10, Press 4), with live search. Topics include dates, organiser, sectors, time zone, fees, inclusions, representatives, early-bird, how to apply, documents, payment, portal, samples and ATA, selling samples, pharma and food, B2B, free entry, CNPJ, import duty, shipping time, RADAR, data sharing, public access, pass, venue access, hours, badge printing, visa type and documents, invitation letter, visa time and cost, yellow fever, forex quota, delegate fee, importing from Brazil, embassy address, press accreditation, logos, interviews, and naming.
- **Downloads:** 9 categories, one file ("Exhibitor briefing session 2025 (slides)", PPTX 5.9 MB, English; 20 slides covering a 10-step exhibitor preparation guide and the 2025 programme). There is no prospectus, floor plan, exhibitor manual or media kit yet.
- **Contact:**
  - Dhaka desk: +880 1553 676767, +880 1992 677117, info@ and sg@brazilbangladeshchamber.com, WhatsApp. Office hours "to be announced".
  - São Paulo desk: "to be announced".
  - Contact form topics (Exhibiting, Visiting/buying, Sponsorship, Press, Visa and travel, Something else) all route to the Dhaka desk.

---

## 4. Registration and enquiry flows (all fields)

### 4.1 Shared wizard behaviour (all `/register/*` pages)

- **Steps:** 3 or 4 `fieldset` steps with a sticky progress list. **Continue** validates the current step client-side, showing inline "This field is required." messages plus a summary "Please complete the highlighted fields before continuing." (observed). **Back** keeps the data.
- **Autosave:** on every input or change, the form saves to `localStorage` (`mbe.reg.{flow}.{type}`) **and** POSTs a server draft (`/register/{type}/draft`). If saving fails it retries every 8 s. On return the user sees "We restored what you typed earlier" and a "Start again" option (which DELETEs the draft).
- **Country-conditional blocks:**
  - Brazil: CNPJ, legal name, CEP, street, number, complement, neighbourhood, city, UF.
  - Bangladesh: district (64), BIN, ERC, trade-licence number.
  - Other: state and city.
  - The phone prefix chip changes with the country (+55 / +880).
- **CNPJ lookup:** `/ajax/cnpj/{14 alnum}` (Receita Federal) fills the trade and legal names and the address. It accepts the **new alphanumeric CNPJ** (July 2026). **CEP lookup** (`/ajax/cep/{8}`) fills street, district, city and UF.
- **Anti-spam:** honeypot field "homepage" plus a signed timestamp `_ft` and CSRF.
- **Bangla:** step numbers and counts render in Bangla numerals.
- **Consent step (identical on all types):**
  1. ☐* *Required:* BBCCI may use my details to process the registration and contact me about participation.
  2. ☐ Share my name, company and contact details with exhibitors (B2B).
  3. ☐ E-mail news (expo and BBCCI).
  4. ☐ WhatsApp updates about registration and payments.
  - None are pre-ticked. The text links to the privacy policy and says choices can be changed in account settings.

### 4.2 Buyer / importer (4 steps; submit button "Complete registration")

1. **About you:** Full name* (hint: as on badge) · E-mail* (badge and updates) · Country* (250 countries, defaults to Brazil) · Mobile (with +55 chip; for WhatsApp only) · Job title
2. **Your company:** Company* · BR block: **CNPJ*** (14 characters, auto-fill), legal name (razão social), CEP (auto-fill), street, number, flat/suite, neighbourhood, city, UF (27) · BD block: district, BIN, ERC, trade licence · Other: state or province, city
3. **What you source:** Sectors of interest* (9 checkboxes) · Annual import volume* (<US$100k / 100k–500k / 500k–2m / 2–10m / >10m / we don't import yet) · Import licence (RADAR/Siscomex)* (direct / via trading company or broker / not yet; self-declared) · How did you hear (invitation, association, search, social, press, colleague, attended 2025, other)
4. **Consent and submit**

### 4.3 Trade visitor (3 steps)

Same as the buyer flow, except that **company and CNPJ are optional**, sectors are optional, and there is no import-volume or licence question. Steps: About you → Your company (plus sectors and source) → Consent.

### 4.4 Business delegate (Bangladesh; 4 steps; button "Register and issue the invoice")

1. About you (**mobile required**, +880 chip)
2. Your organisation (company*, **district*** for BD)
3. **Delegate package:** radio "Business delegate (Bangladesh)", US$1,000 (৳1,23,280) per person, covering delegation membership and B2B matchmaking, "provisional until 2026 fees confirmed" · **Number of people*** (1–10; the select shows "1" twice, a bug) · a row per extra delegate (Full name*, E-mail*, Job title). "Each person gets their own registration, e-badge and invoice."
4. Consent. The invoice is issued immediately and BBCCI confirms after review.

### 4.5 VIP guest (3 steps)

About you → **Your invitation** (Organisation, Invitation reference (optional: code or the name of the inviting BBCCI member), plus the full country blocks, so a BD VIP is asked for BIN, ERC and trade licence) → Consent. The page says "by invitation only", but **anyone can open and submit the form.**

### 4.6 Press (3 steps; button "Send accreditation request")

About you → **Your outlet:** Media outlet* · Role* (journalist, photographer, video/TV, editor, producer, content creator, other) · Outlet website · **Press card or assignment letter*** (file: PDF, JPG, PNG or WebP up to 10 MB, "stored privately"; it must be re-attached after a reload) · Planned coverage → Consent. BBCCI approves, then sends the QR press badge.

### 4.7 Speaker (3 steps)

About you → Your invitation: organisation, invitation reference, **session or topic**, **short bio (2,000 characters)**, plus the country blocks → Consent. There is no photo upload or headshot request in the public form.

### 4.8 Group registration (buyer, trade visitor and delegate; 3 steps; button "Register the group")

1. **Coordinator:** the person fields, company*, **group or delegation name**, the country blocks, a checkbox "I am attending too", and (if attending) sectors, import volume, licence and source.
2. **People in the group:** repeatable rows (Full name*, E-mail*, Job title, Mobile, Company) with Add and Remove, **or "Upload a spreadsheet"**: download `template.xlsx`, then upload an `.xlsx` of up to 2 MB and **200 people**. Every row is validated with row-level error messages and nothing typed is lost.
3. **Consent:** the coordinator ticks the same four boxes **on behalf of everyone**. This is an LGPD weakness, because each member's own consent to sharing and marketing is not collected.

### 4.9 Other public forms

| Form | Endpoint | Fields |
|---|---|---|
| Ask about a stall (`/exhibit`, `/stand-packages`) | `/forms/book_stand` | Company*, Full name*, Designation, E-mail*, Mobile (+880)*, Main sector (9), Products (textarea), Number of stalls, Message*. Note: "Sending does not book a stall" |
| Sponsorship proposal | `/forms/sponsor_enquiry` | Company*, Name*, E-mail*, Phone/WhatsApp, Country, Opportunity (5 categories), Message* |
| Contact | `/forms/contact` | Name*, E-mail*, Phone/WhatsApp, Company, Country, Topic* (6), Message*, newsletter opt-in |
| Press enquiry | `/forms/press_enquiry` | Name*, Outlet*, E-mail*, Phone, Country, Message* |
| Register interest: all | `/forms/register_interest` | I am a* (exporter, buyer, delegate, sponsor, press), Name*, E-mail*, Phone/WhatsApp, Company, Country, Sectors, Message, newsletter opt-in |
| Register interest: buyers in Brazil | `/forms/visit_interest` | Name*, E-mail*, Company*, CNPJ (optional), State (UF), WhatsApp (+55), Products sourced (9), newsletter opt-in |
| Newsletter (footer) | `/forms/newsletter` | E-mail*, consent* (double opt-in promised) |
| Resend badge | `/register/resend` | E-mail*, Registration type |
| Cost calculator | `/ajax/quote` (GET) | Stall type (one option), stalls 1–10, delegates 0–20 → USD and BDT totals |
| Account creation | `/account/create` | Name*, E-mail*, Password* (≥10, mixed case and a number, live rule list), I am…* (exporter / buyer / other), Phone, E-mail language* (EN / PT-BR / BN), Terms and privacy* (one combined checkbox) |

### 4.10 Exhibitor application (behind login, so not observed; from the public explainer and the video)

The five steps are: (1) account plus e-mail confirmation; (2) company details: BIN, TIN, trade licence, sector, products, export markets, and **ANVISA questions** if medicines, devices, cosmetics, personal care or food are declared; (3) document upload (PDF and images); (4) package choice plus extra delegates with a **live USD and BDT price**; (5) submit and receive an application number, then track status.

Terms acceptance records the date, time, IP, browser and terms version. After approval, BBCCI issues a **proforma invoice and participation contract PDF in the applicant's language**. Payment is either a slip upload (verified, then a receipt) or online (SSLCommerz, bKash, Nagad or card, once the merchant account is live), with **50/50 instalments** claimed.

---

## 5. Packages, pricing, deadlines and sponsorship

### 5.1 Packages (2025 figures; 2026 TBA everywhere)

| Package | Price | BDT shown (123.28/US$) | Includes | Notes |
|---|---|---|---|---|
| **Standard stall** | **US$4,000 per stall** | ৳4,93,120 | One 8 × 8 ft (about 2.4 × 2.4 m) stall, 2 company representatives in the business delegation, venue rental, stall preparation, branding | Max 2 people per stall; calculator allows 1–10 stalls |
| **Business delegate (Bangladesh)** | **US$1,000 per person** | ৳1,23,280 | Delegation membership, B2B matchmaking | For BD importers or business people without a stall; calculator 0–20 |
| Trade visitor / buyer (Brazil) | **R$0** (2025, with pre-registration) | n/a | "Full Pass": talks, conferences, business rounds, networking, meeting room, full access | 2026 visitor terms TBA |
| Early-bird (2025) | **−10%** | n/a | Deadline 31 Jan 2025, extended to 15 Feb 2025 | 2026 early-bird TBA |
| Not included | n/a | n/a | Flights, hotel, visa fee (BDT 11,200), sample freight | n/a |

They present only one stall size. There are no corner, island, shell-scheme vs raw-space, premium location or co-exhibitor options, and no member rate ("any member rate will be confirmed").

### 5.2 Deadlines

The deadlines page shows only TBA rows (Applications, Payments, Visa support, Shipping) and a scale chart with a "154 days to opening" counter. The planning guidance is to allow about two months for visa formalities (BBCCI's 2025 plan) and up to 20 working days for embassy processing.

### 5.3 Sponsorship (all "price on request")

| Category | Pitched benefits |
|---|---|
| Strategic partner | Recognition across expo communication; speaking or hosting role; contact with exhibitors and buyers |
| Logistics & shipping partner | Access to exhibitors shipping samples; role in shipping arrangements; presence at expo and in communications |
| Banking & finance partner | Contact with BR–BD traders; trade-finance presentation; recognition |
| Certification & testing partner | Contact with exporters; seminar slot; recognition |
| Programme & hospitality partner | Name on a session or reception; welcome or speaking slot; recognition |

There are no tiered packages (Platinum, Gold and so on), no deliverables matrix, no sponsor logo placements or mock-ups, no audience numbers, and no ROI reporting.

### 5.4 Payment rules (public)

- Fees are quoted in USD. Bangladeshi participants pay in taka (the amount on the invoice). Foreign participants pay by SWIFT in USD.
- Bank details are portal-only.
- Instalments: "any instalments as set out in your invoice" (the video claims 50/50).
- The refund policy has **no figures**: cancellation charges are "published per edition", refunds go to the original payer, visa-refusal handling is "per the edition's terms", and costs paid to others are never refunded.

---

## 6. Legal pages: key clauses and LGPD handling

**Privacy notice (v2026.1, 17 Oct 2026)**

- Controller: BBCCI in Dhaka, contact info@. LGPD applies under Art. 3, and **Bangladesh's Personal Data Protection Act 2026** is cited.
- **Data collected:**
  - Exhibitors: company data and documents, passport details of representatives, visa documents if the visa desk is used, hotel requests, and **terms acceptance with date, time, IP, browser and version**.
  - Buyers: name, company, CNPJ, legal and trade names, job title, e-mail, mobile, sectors, import activity. **No CPF for free registrations.**
  - Press: credentials. Speakers: photo and bio, which are published.
  - Payments: slips and receipts; gateway card data is never seen.
  - Technical: IP, device, pages, campaign, security logs, **e-mail open tracking**.
  - On site: **badge scan times**, photos and video.
- **Legal bases:** contract (Art. 7 V); **consent with a separate unticked box per purpose** (sharing buyer data with exhibitors, newsletter, WhatsApp/SMS, analytics and marketing cookies; Art. 7 I, Art. 8); legal obligation (Art. 7 II and VI); legitimate interest (security, deduplication, event photography).
- **Recipients:** named Brazil-side partners, the Brazilian invitation-letter signer (name and passport only on request), exhibitors (only with consent), hotels, processors and authorities. "BBCCI does not sell data."
- **Transfers:** BR→BD transfers under ANPD standard contractual clauses (Art. 33). Passport, NID and tax numbers are "sensitive" under the BD 2026 Act and sent abroad only when needed.
- **Retention:** passport, NID and visa documents are **auto-deleted after the edition**. Consent records are kept as proof.
- **Security:** encryption in transit, encryption of passport and ID documents, least-privilege access, activity logs, backups, breach notification.
- **Rights:** the full LGPD Art. 18 list, with a **15-day** reply. Withdrawal via unsubscribe, cookie settings or e-mail.
- **Gaps:**
  - There is **no named Encarregado (DPO)**. The notice says only that a Portuguese-speaking contact "will be added".
  - There is no data-subject-request self-service.
  - The policy is contradicted in practice by `/_a/a.js` fingerprinting and by the Cloudflare beacon (see §10.3).

**Terms of participation**

- Participation is confirmed only after invoice, terms acceptance and payment. Until then BBCCI may give the stall to someone else.
- The invoice overrides the terms where they differ.
- Stall location is allocated by BBCCI and can change. Badges are personal. No subletting or sharing without written consent.
- Visa refusal is not BBCCI's liability.
- Exhibition-goods compliance (ATA, temporary admission, ANVISA, Portuguese labels) is the exhibitor's responsibility.
- Conduct rules apply; BBCCI can close a stall.
- Directory listing is with the company's consent, and the company warrants IP rights in uploaded material.
- Photography consent is opt-out by telling the photographer.
- Liability is limited and there is a force majeure clause.
- **Governed by Bangladesh law** with amicable settlement first, which may worry Brazilian sponsors.

**Refund and cancellation policy:** summarised in §5.4. It is procedurally clear but contains **no percentages or dates**.

**Cookie policy:**

- Categories: necessary, analytics and marketing. Reject is as easy as accept, nothing is pre-ticked, scrolling is not consent, and choices are logged (`mbe_consent_id`).
- Cookies listed: session (240 min), XSRF, `mbe_consent` (180 d), `mbe_consent_id` (180 d), **`mbe_device` (365 d, new-device sign-in alerts)**, and GA4 `_ga` cookies (consent-only, "once connected").
- localStorage holds drafts and the announcement-bar dismissal.
- YouTube-nocookie embeds and OSM tiles are described as "lazy". **However, OSM tiles load as soon as the map scrolls into view, and the fingerprinting script and Cloudflare beacon are not disclosed.**

---

## 7. Key event facts they publish (for our own content)

| Item | Value |
|---|---|
| Event name | Made in Bangladesh Expo **2026** (2nd edition; the name is kept although it runs in 2027) |
| Dates | **22–25 March 2027 (Mon–Thu)**; opening 22 Mar 10:00 BRT / 19:00 Dhaka; set-up day and hours TBA |
| Venue | **Pro Magno Centro de Eventos**, Av. Professora Ida Kolb 513, Casa Verde, São Paulo-SP 02518-000; loading at Rua Samaritá 230 |
| Scale | About **50 Bangladeshi stalls** plus selected Brazilian exhibitors (soybean oil, sugar, cotton, coffee, agri commodities, food ingredients, livestock and poultry, industrial raw materials) |
| Programme plan | Structured B2B matchmaking; seminars on trade, investment, market entry, facilitation, customs and regulation, logistics, industrial cooperation and sustainability; investment forums; policy discussions; cultural showcases |
| Sectors (site) | Garments; Home & technical textiles; Pharmaceuticals; Leather & footwear; Jute & jute goods; Agro-food & processed food; Handicrafts & home décor; Plastics & toys; ICT & software. BBCCI's invitation also names engineering, renewable energy, ceramics, frozen seafood, packaging and knitwear/woven |
| History | Launched 8 Jan 2025 at Hotel Ascott Palace, Dhaka (with Ambassador **Paulo Fernando Dias Feres**); Rangpur 18 Jan 2025; Chattogram Press Club 1 Feb 2025; **1st edition 15–18 Jun 2025, Novotel São Paulo Center Norte** (Av. Zaki Narchi 500); the First Lady of São Paulo city visited on day 2; 2nd edition announced 16 May 2026 (tentatively 20–30 Nov 2026), dates and venue confirmed 17 Oct 2026 |
| 2025 programme | 15 Jun set-up; 16 Jun Meet the Press 09:30–10:30, inauguration 11–13, B2B 14–17; 17 Jun seminar on trade and investment 11–13, B2B 14–17; 18 Jun Brazilian expert seminar 11–13, B2B 14–17, Meet the Press and closing 17:00–19:30 |
| 2025 exhibitors (15) | Aman Plastic Toys Industries, Apex Lingerie, BAB Trend Fashion, Benchmark, Biocell, Blue Planet Group, Chemist, Maha Telecom, Marsik, Mashiur Habib Enterprise, Mitali Group, Pioneer Casual Wear, Renaissance Group, SED Worked, STS Apparel |
| 2025 partners | Organiser BBCCI; supported by the Embassy of Brazil in Dhaka |
| BBCCI contact | Shanta Skymark, Level 12, 18 Gulshan Avenue, Dhaka-1212; +880 1553 676767 (WhatsApp), +880 1992 677117; info@ and sg@brazilbangladeshchamber.com |

---

## 8. Feature matrix

**Columns:** **Where** is Public, Reg (public registration), Portal or Admin. **Evidence** is S (seen on the public site), J (code in the public JS bundle), V (claimed in the video only) or P (stated in the privacy or terms text). **Q** is quality from 1 to 5 based on what is visible.

| # | Feature | Where | Evidence | Q | Notes |
|---|---|---|---|---|---|
| 1 | Trilingual EN / PT-BR / BN, hreflang, localised top-level slugs, Bangla numerals and font, browser-language suggestion bar | Public | S | 5 | Best-in-class. Source captions are left in English; sub-page slugs are English |
| 2 | VLibras sign-language widget (PT) | Public | S | 4 | Shows sensitivity to Brazil's accessibility norms |
| 3 | Mega-menu with countdown, dual clocks and latest news; mobile drawer | Public | S | 5 | Polished |
| 4 | Hero slider (real 2025 photos), pause/play, a11y labels | Public | S | 4 | Same handful of photos reused; dark tint |
| 5 | Countdown and SP/Dhaka timezone tools on several pages | Public | S | 5 | Thoughtful for two audiences |
| 6 | Sourced trade-stat storytelling (ComexStat, EPB, tariffs) | Public | S | 5 | A credibility moat; must match or exceed |
| 7 | Trade-route 3D globe (sea and air), drag, replay | Public | S/J | 4 | d3 orthographic; video "wow" moment |
| 8 | 9 sector pages with figures, rules and 2025 exhibitors | Public | S | 3 | Thin pages; stock images; no products |
| 9 | Bilateral timeline (1972→2027) | Public | S | 3 | 7 items; pinned scroll causes dead space |
| 10 | 2025 archive: journey, Gantt, logo wall, gallery, press | Public | S | 3 | Only 14 photos, no video |
| 11 | Programme with time-zone slider; 2025 reference | Public | S | 3 | 2026 empty |
| 12 | Speakers, committee messages, partners | Public | S | 1 | Empty placeholders |
| 13 | Newsroom with type filter, pagination, share buttons, NewsArticle schema | Public | S | 4 | 5 items |
| 14 | FAQ: 48 Q&As, audience tabs, live search, FAQPage schema | Public | S | 5 | Strong |
| 15 | Downloads library with categories, edition labels, gated downloads | Public | S/J | 2 | 1 file (6 MB PPTX) |
| 16 | City guide: Leaflet map, 35 places, 8 filters, distances, directions | Public | S | 4 | No clustering; OSM public tiles are not production-grade |
| 17 | Venue page: entrances, distance and time switch | Public | S | 4 | n/a |
| 18 | Hotels list | Public | S | 2 | No rates, no booking, no room block |
| 19 | Travel and visa guide (visa navigator, health, money calculator, plugs, halal, emergency) | Public | S | 5 | Rich, but November weather bug |
| 20 | Stand packages, cost calculator in USD and BDT | Public | S | 4 | One stall type only |
| 21 | Payment-instructions explainer | Public | S | 4 | Sensible anti-fraud stance |
| 22 | Sponsorship categories and proposal form | Public | S | 3 | No tiers, prices or deliverables |
| 23 | Enquiry forms (stall, sponsor, contact with topic routing, press, interest, newsletter) | Public | S | 4 | AJAX, honeypot, signed timestamp |
| 24 | Exhibitor directory and per-exhibitor microsite | Public | S/V | 1 | Empty today |
| 25 | WhatsApp widget with desk chooser and prefilled text | Public | S | 3 | Only `wa.me` deep links, no Business API |
| 26 | Cookie banner with equal reject and granular settings | Public | S | 2 | Undermined by non-consented fingerprinting |
| 27 | SEO: titles, meta, canonical, hreflang sitemap, OG, JSON-LD | Public | S | 4 | Event schema lacks offers and description; no image or news sitemap |
| 28 | Security headers, CSP nonce, anti-spam | Public | S | 5 | n/a |
| 29 | Registration hub (6 types plus audience filter) | Reg | S | 4 | n/a |
| 30 | Multi-step wizards with inline validation | Reg | S | 5 | n/a |
| 31 | Autosave and resume (local plus server draft) | Reg | S/J | 5 | n/a |
| 32 | CNPJ (alphanumeric 2026) and CEP auto-fill | Reg | S/J | 5 | Must match |
| 33 | Country-aware fields (BR / BD / other) and phone prefix | Reg | S | 4 | Same field set for VIPs and speakers (BIN etc.) is awkward |
| 34 | Granular unticked consents (4) | Reg | S | 5 | n/a |
| 35 | Paid delegate registration with per-person invoices | Reg | S | 4 | "1" duplicated in people select |
| 36 | Press accreditation with credential upload | Reg | S | 4 | n/a |
| 37 | VIP and speaker invitation flows | Reg | S | 2 | Not gated; optional reference |
| 38 | Group registration with XLSX template (≤200), row validation | Reg | S/J | 4 | Coordinator consents on behalf of members |
| 39 | Instant QR e-badge (screen, e-mail, PDF, WhatsApp) | Reg | V/S | ? | Claimed; WhatsApp delivery is stated on the site |
| 40 | Resend badge; self-service name correction (`/m/` manage links) | Reg | S/V/J | 3 | Resend form seen |
| 41 | Accounts: signup (password rules, e-mail language), login, reset, new-device alerts | Portal | S/P | 3 | No SSO, magic link, passkey or 2FA |
| 42 | 5-step exhibitor application with ANVISA logic and live USD/BDT quote | Portal | V/J | ? | Not observable |
| 43 | Terms acceptance log (time, IP, browser, version) | Portal | P/V | ? | n/a |
| 44 | Application status tracking and e-mail on each change | Portal | S/V | ? | n/a |
| 45 | Proforma invoice and participation contract PDF in the user's language | Portal | V | ? | n/a |
| 46 | Payment: slip upload, verify, receipt; online SSLCommerz, bKash, Nagad, card; 50/50 instalments | Portal | S/J/V | 2 | Online not enabled; no PIX or BRL |
| 47 | Exhibitor profile (3 languages), products, live preview | Portal | V/J | ? | n/a |
| 48 | Auto-advancing task checklist | Portal | V/J | ? | n/a |
| 49 | Fascia (stand name) with live preview and character limit | Portal | V/J | ? | n/a |
| 50 | Staff badges and team members | Portal | V | ? | n/a |
| 51 | Encrypted document vault with auto-deletion after retention | Portal | V/J/P | ? | n/a |
| 52 | Travel and visa desk: passport data, <6-month warning, 16-item embassy checklist with uploads, invitation-letter request | Portal | V/J | ? | Strong idea |
| 53 | Association portal (e.g. BGMEA): referral link, quota, applicant list, Excel export | Portal | V | ? | No public trace |
| 54 | Central settings (dates, venue, fees) propagating to site, 3 languages, e-mails and PDFs | Admin | V | ? | Site does look data-driven (dates are consistent) |
| 55 | 50+ e-mail templates × 3 languages with fallback; sent-mail log | Admin | V/J | ? | n/a |
| 56 | Audit trail; consent records | Admin | V/P | ? | n/a |
| 57 | Applications list, decide and approvals desks | Admin | J | ? | n/a |
| 58 | CMS: pages (section show/hide, draft preview), media library (focal point), translations editor, forms ordering | Admin | J | ? | n/a |
| 59 | **Guided mode** (edit live page layers in place) | Admin | J/V | ? | Their "no developer needed" story |
| 60 | CRM pipeline, segments, campaigns and journeys, inbox, helpdesk | Admin | J | ? | Video says "to be done" |
| 61 | **QR check-in desk** (camera, offline queue, device names, live stats) | Admin | J/V | ? | Already coded |
| 62 | First-party analytics with fingerprinting, no consent | Public | S/J | 1 | Compliance liability |
| 63 | B2B matchmaking scheduler / meeting booking | n/a | none | 0 | **Absent** |
| 64 | Interactive floor plan / stand selection | n/a | none | 0 | "Floor plan: added when released" |
| 65 | Product catalogue / site search / buyer RFQ | n/a | none | 0 | Only FAQ search |
| 66 | Exhibitor lead retrieval (scan buyer badges) | n/a | none | 0 | Check-in is admin-only |
| 67 | PWA / app / wallet passes / push | n/a | none | 0 | No manifest or service worker |
| 68 | Live chat / AI assistant | n/a | none | 0 | Only WhatsApp links |
| 69 | Video, virtual tour, live stream | n/a | none | 0 | CSP allows YouTube, but no content |
| 70 | Exhibitor and sponsor analytics, post-event reports, surveys, certificates | n/a | none | 0 | **Absent** |
| 71 | Hotel booking / room block, flight deals | n/a | none | 0 | Text only |
| 72 | Calendar (.ics) export, personal agenda, favourites | n/a | none | 0 | **Absent** |
| 73 | Social media links and feeds | n/a | none | 0 | None in the footer |

---

## 9. UI/UX audit

### 9.1 Visual design

- **Identity:**
  - Palette: Bangladesh green `#13803C` / `#0F6B32` / `#0B4021`, Brazil yellow `#DBD104`, accent blue `#0A28A3` and red `#CD0619`, warm paper `#F7F6F1`, ink `#14201A`.
  - Type: Bricolage Grotesque display with Inter body. Large tight headlines and generous spacing.
  - Overall feel: contemporary editorial, coherent and "designed". **This is a high bar.**
- **Imagery:**
  - About 14 real 2025 event photos are reused across almost every hero. The same group photo leads the home, stand-packages and FAQ pages.
  - The photos are amateur event shots (posed groups making victory signs), and a heavy dark-green duotone overlay makes every page look the same and rather sombre.
  - The sectors use Pexels stock (the photo credit is visible on the home page).
  - There are no product photos, no factory or brand imagery from exhibitors, and no video.
- **Template monotony:** every page uses a full-viewport photo hero, a bottom-left headline, yellow and outline CTAs, and an "On this page" card (see `contact-sheet-desktop.jpg`). Key facts such as dates and price sit below the fold.
- **Motion:** GSAP reveals, Lenis smooth scrolling, tilt cards, an odometer counter and pinned sections. It looks impressive in a demo video but makes scrolling feel heavy. The homepage has about 1,400 px of pinned "dead" scroll at the timeline (`desktop-home-full.jpg`, between "In the media" and "Key dates").
- **Explainer components:** about 60 bespoke mini-visualisations (diagrams, toggles, scale charts). They are clever, but many duplicate the paragraph next to them, which increases page length and cognitive load.

### 9.2 Information architecture and navigation

- The 4 mega-menus (The expo / Take part / Plan your trip / News & media) are clear, with primary CTAs "Register" and "Apply to exhibit". The drawer on mobile is clean (`mobile-menu-open.jpg`).
- There are role-based entry points (Exhibit, Visit, Sponsor, Press) and audience filters on Register and FAQ.
- **Weak points:**
  - Pages are extremely long: home 12,305 px desktop and 13,688 px mobile; travel 14,498 px; exhibit 9,145 px desktop and 12,465 px mobile.
  - The same content is repeated across pages (packages, deadlines and FAQ teasers each appear 3–4 times).
  - Duplicate menu items (Register interest appears twice in the "Take part" mega-menu).
  - There is no site search.
  - The 404 page tells the visitor to "use the menu", but it has none.

### 9.3 Mobile (390 × 844, DPR 2)

- No horizontal overflow was found on the tested pages.
- The announcement bar wraps to 3 lines and takes about 65 px.
- **The floating WhatsApp button overlaps the hero copy** on the home page and **overlaps the form card** on `/register/buyer` (`mobile-home-with-cookie-banner.jpg`, `mobile-register_buyer-fold.jpg`).
- The cookie banner covers about 45% of the first screen.
- Hero images fill the screen, so the first CTA is near the bottom.
- The wizard progress turns into a horizontal pill row, which works.

### 9.4 Accessibility

**Good:**

- A skip link; `aria-*` on menus, sliders, tabs and dialogs; pause control on carousels.
- About 70 `:focus-visible` styles and reduced-motion support.
- Labelled form fields with `aria-describedby` hints and errors; `aria-live` toasts.
- Every `<img>` has `alt` (decorative ones have `alt=""`).
- VLibras on PT pages; Bangla numerals with `lang="bn"`.

**Issues:**

- The "subtle" text colour `#7A867F` measures **3.5:1** on paper and 3.8:1 on white, which fails WCAG AA for the small source captions where it is likely used.
- The logo-green `#24C801` with white text would be 2.25:1 if it is used for text.
- Long scroll-jacked sections (GSAP pins and Lenis) are hard for keyboard, switch and low-vision users.
- Many interactive explainers rely on hover or click to reveal content that is also given in text (good redundancy, but more noise for screen readers).
- The timeline needs "swipe or arrow keys" instructions.

### 9.5 Bugs, inconsistencies and placeholder content

1. Edition naming: "Made in Bangladesh Expo **2026**" is used in every title and in the Event schema for an event on **22–25 March 2027**. This is confusing for SEO ("expo 2027") and for users. It was BBCCI's decision, but the site should explain it more prominently.
2. Stale copy saying the dates and venue are unconfirmed: the About CTA, the Visit CTA, the "Buyers and visitors in Brazil" interest form, and the programme hero.
3. The travel page shows **November** weather and rainfall (left over from the cancelled Nov 2026 plan); the expo is in March.
4. Placeholder or empty sections: speakers (0), partners 2026, committee messages, deadlines (all TBA), downloads (1 of 9 categories), exhibitor directory (0), hotel block, office hours, São Paulo desk, 2026 fees and packages.
5. Two of the 15 2025 exhibitors (Mashiur Habib Enterprise and SED Worked) have no sector.
6. The press cards on the home page clip headlines mid-line with no ellipsis ("…businessmen: Diplomat" is cut).
7. The delegate "Number of people" select lists "1" twice.
8. VIP and speaker forms are labelled "by invitation only" but are open to anyone.
9. Intermittent **Cloudflare 520 and 525 origin errors** (`/login`, `/register/trade-visitor/group`) and one **22 s timeout** (`/sectors/leather`) during about 230 requests.
10. The 2025 briefing deck names the 2025 venue as "Expo Center Norte", while the site says "Novotel São Paulo Center Norte".
11. PT URLs for sectors, news, galleries and registration types are English slugs; data-source captions are untranslated in PT and BN.
12. The public `/build/manifest.json` and admin JS bundles reveal the admin feature surface (information disclosure, low risk).

### 9.6 Screenshot references (`docs/research/competitor-screens/`)

- **Desktop 1440:** `desktop-home-with-cookie-banner`, `desktop-home-fold`, `desktop-home-full`, `desktop-home-globe`, `desktop-megamenu-take-part`, `desktop-exhibit-{fold, full}`, `desktop-stand-packages-{fold, full}`, `desktop-register-{fold, full}`, `desktop-register_buyer-{fold, full}`, `desktop-sectors-{fold, full}`, `desktop-sectors_garments-{fold, full}`, `desktop-city-guide-{fold, full}`, `desktop-city-guide-map-canvas`, `desktop-city-guide-map-hotels`, `desktop-faq-{fold, full}`, `desktop-travel-{fold, full}`, `desktop-exhibit_apply-{fold, full}`, `desktop-pt-{fold, full}`, `desktop-bn-{fold, full}`
- **Mobile 390:** `mobile-home-with-cookie-banner`, `mobile-home-{fold, full}`, `mobile-menu-open`, `mobile-register_buyer-{fold, full}`, `mobile-stand-packages-{fold, full}`, `mobile-city-guide-{fold, full}`, `mobile-faq-{fold, full}`, `mobile-exhibit-{fold, full}`
- **Contact sheets:** `contact-sheet-desktop.jpg` (12 page heroes side by side, which shows the template monotony), `contact-sheet-mobile.jpg`

In the `*-full` captures, some lazy images below the fold (sector tiles) and the sticky Leaflet canvas appear blank. That is an artefact of full-page capture. The viewport captures show the map working.

---

## 10. SEO, performance and security findings

### 10.1 SEO

- **Good:**
  - Exactly one H1 per page.
  - Titles are 42–66 characters (news articles 71–93).
  - Meta descriptions are 77–194 characters.
  - Canonical on every page.
  - Reciprocal hreflang in both the HTML and the sitemap.
  - OG and Twitter tags with image alt text.
  - Breadcrumbs (BreadcrumbList).
  - **JSON-LD:**
    - `Organization` with names in 3 languages, plus `ContactPoint` (areaServed BD/BR, 3 languages)
    - `WebSite`
    - `Event` (home and 2025), with Place and PostalAddress
    - `FAQPage` (48 Q&As)
    - `NewsArticle`
    - `ImageGallery`
- **Weak:**
  - The `Event` schema has no `offers`, `description`, `performer` or `eventSchedule`, and does not use `ExhibitionEvent`. Its `name` says 2026 while the start date is 2027.
  - No `Organization.sameAs` (no social profiles exist).
  - No image or news sitemap, no `llms.txt`.
  - English slugs on PT sub-pages.
  - Very long pages dilute topical focus.
  - Thin sector pages.
  - The demo is `noindex` through the response header (fine for a demo).
- **AI and LLM visibility:** robots.txt invites AI crawlers, and the content is rich in sourced facts, so it is well placed to be cited.

### 10.2 Performance (Playwright, Chromium, no throttling, cold cache from Dhaka edge `CF-RAY …-DAC`)

| Page | Device | Load | LCP | CLS | Requests | Transfer (cold) |
|---|---|---|---|---|---|---|
| `/` | Desktop | 5.3 s | **4.6 s** (hero img) | 0.014 | 56 (27 JS modules, 18 images) | ~1.1 MB |
| `/` | Mobile | 5.7 s | **5.5 s** | 0.02 | 58 | ~1.1 MB |
| `/exhibit` | Desktop | 7.6 s | 4.0 s | 0.015 | 32 | ~0.5 MB |
| `/city-guide` | Desktop | 4.1 s | 4.2 s | 0.043 | 34 (incl. OSM tiles) | ~0.75 MB |
| `/travel` | Desktop | 4.7 s | 4.7 s | 0.021 | 31 | ~0.5 MB |
| `/register/buyer` | Desktop | 2.8 s | 2.8 s (H1) | 0.015 | 15 | (cached) |
| `/bn` | Desktop | 7.3 s | 2.4 s | **0.088** | 67 (9 font files) | ~0.3 MB (partly cached) |
| `/pt` | Desktop | 2.5 s | 2.4 s | 0.031 | 68 (VLibras from cdn.jsdelivr and vlibras.gov.br) | (cached) |

- **TTFB:** 0.68–2.44 s across all 54 EN pages (the median is about 0.8 s, and the home page 2.3 s on first hit). HTML is not cached at the edge.
- **Images are well optimised:** WebP at 480, 960, 1440, 1920 and 2560 widths; the hero at 1440 px is 95 KB; `srcset`, `sizes`, `loading` and `fetchpriority` are all used.
- **The bottlenecks** are server TTFB, JS-revealed hero content (opacity and GSAP), and about 27 module requests on the home page.
- No console errors or JS exceptions were captured on the tested pages. The only failed requests were aborted OSM tiles during zoom.

### 10.3 Security and privacy

- Headers are strong (CSP nonce, HSTS, XFO, Permissions-Policy, nosniff).
- **The privacy red flag (`/_a/a.js`)** loads unconditionally on every page and sends a "full device and browser profile" to `/_a/collect.php`. The profile includes:
  - a canvas fingerprint
  - the WebGL unmasked GPU vendor and renderer
  - battery level and charging state
  - high-entropy UA client hints (model, platform version, full version list)
  - `navigator.storage.estimate()` and a media-device count
  - network type, screen and DPR, time zone and languages
  - UTM, gclid and fbclid
  - every click with element text, href and x/y position
  - dwell time and scroll depth, with a heartbeat every 15 s

  There is **no consent check**. This runs against the site's own cookie policy and LGPD Art. 7/8 (and ePrivacy-style expectations). It is a talking point for us, made factually and without naming them: "consent-gated analytics, no fingerprinting".
- Cloudflare Web Analytics (`static.cloudflareinsights.com`) also loads and is not disclosed in their cookie list.

---

## 11. How we beat them

### 11.1 Must-match (table stakes BBCCI has already seen; ship all of these)

1. Full **EN / PT-BR / BN** with Bangla numerals and Bangla webfont, **fully localised slugs** (including sectors, news and registration types), hreflang in the HTML and sitemap, a browser-language suggestion bar, and VLibras on PT.
2. Home features: hero with real 2025 photos, countdown, dual SP/Dhaka clocks, **trade-route globe** (sea Chattogram→Santos and air DAC→GRU), sourced trade stats, 9 sectors, bilateral timeline from 1972, 2025 archive, press coverage, partner wall.
3. Nine sector pages with sourced figures, HS codes, duties and regulatory notes (ANVISA, MAPA, INMETRO, anti-dumping), and 2025 exhibitors.
4. City guide on an interactive map: venue, airports, metro and bus, hotels, mosques and halal, wholesale districts, embassies and chambers, essentials, with filters, distances and directions. Plus venue, hotels and a deep **travel and visa** guide (16-item checklist, yellow fever, forex quota, plugs, emergency numbers, Brazilians to BD).
5. FAQ with ≥48 Q&As, audience tabs, live search and FAQPage schema. Newsroom with types, filters and sharing. Press centre. Downloads with edition labels and gated files.
6. Registration types (buyer, trade visitor, delegate, VIP, press, speaker) as multi-step wizards with **CNPJ (alphanumeric) and CEP auto-fill**, country-aware BD fields (BIN, ERC, trade licence, district), autosave and resume, **separate unticked consents**, a resend-badge form, **group registration with XLSX** and row validation, and an instant QR e-badge (screen, e-mail, PDF, WhatsApp) with self-service correction.
7. Exhibitor flow: account → 5-step application (with ANVISA questions) → documents → package with live USD/BDT → versioned terms acceptance → approval → **proforma invoice and contract PDF in the user's language** → slip upload or online payment (SSLCommerz, bKash, Nagad, card) with **50/50 instalments** → receipts.
8. Exhibitor portal: 3-language profile and products, auto-progressing checklist, fascia name, staff badges, team members, encrypted document vault with retention-based auto-deletion, and a travel and visa desk (passport data, warning if validity is under 6 months, embassy checklist with uploads, invitation-letter request).
9. Association portal (BGMEA, BKMEA and others): referral link, quota, applicant list, Excel export.
10. Admin: single source of truth for dates, venue and fees; **50+ trilingual e-mail templates**; sent-mail log; audit trail; consent records; application decisions; CMS for pages, media and translations; QR check-in; campaigns.
11. Security headers and CSP, honeypot and rate-limit, LGPD and BD PDPA 2026 privacy notice, cookie consent with reject parity.
12. JSON-LD (Organization, WebSite, Event, FAQPage, NewsArticle, ImageGallery, Breadcrumb), sitemap, OG cards.

### 11.2 Do-better (same features, clearly superior execution)

| Area | Their weakness | Our approach |
|---|---|---|
| Content completeness | 10+ sections "to be announced" | Launch with filled 2026 drafts: speaker and partner placeholders with "apply to speak" and "become a partner" CTAs, a deadline calendar generated from the opening date, a draft prospectus PDF, a media kit and a floor-plan teaser. Show "last updated" badges |
| Visual design | One dark-green template, the same photos everywhere, very long pages | A distinct layout per page type; light, high-contrast pages with **dates, venue and price above the fold**; a curated photo and video library (2025 plus exhibitor product shots); modular pages under about 5 screens with progressive disclosure; no scroll-jacking |
| Performance and hosting | LCP 4.6–5.5 s, TTFB up to 2.4 s, 520/525 errors on shared LiteSpeed | Managed VPS or containers with Redis and queues, edge HTML caching for public pages, CDN images, critical CSS, no JS-gated hero, **LCP target under 2.0 s on 4G**, an uptime SLA (99.9%) with a public status page |
| Privacy | Fingerprinting analytics without consent; coordinator consents for a whole group; no named DPO | **Consent-gated analytics** (GA4 Consent Mode v2 or Plausible), no fingerprinting; **each group member confirms their own consent** by magic link; a named **Encarregado** and DPO for BR plus a BD contact; a self-service DSAR centre (export and delete); public retention schedule |
| VIP and speaker flows | Public "invitation only" forms | **Signed single-use invitation links**, personalised pre-filled forms, protocol fields (salutation, delegation, security notes), VIP lounge and seating allocation |
| Packages | One stall size, no member rate, no options | Configurable catalogue: shell vs raw space, sizes (3×3, 3×6, corner, island), co-exhibitor, delegate add-ons, member and early-bird pricing rules, **multi-currency USD, BDT and BRL** |
| Sponsorship | "Price on request", no tiers | **Tier matrix** (Platinum, Gold, Silver, plus category partners) with deliverables, visual mock-ups of placements, an online proposal builder, contract and invoice, and a sponsor portal for asset uploads |
| Payments | Online gateway not live; no BRL; slip-only reality | Live **SSLCommerz (bKash, Nagad, cards)** plus **Stripe or Mercado Pago with PIX** for Brazilian sponsors and visitors, automated instalment reminders, auto-reconciliation and a finance dashboard |
| Hotels | List only | **Negotiated room-block booking** (or affiliate deep links), rates, a shuttle schedule, a roommate-sharing option for delegations |
| Map | Raw OSM public tiles, no clustering | Production tile provider (MapTiler or Mapbox), marker clustering, walking and transit routing, "save to my trip", an offline PDF city map |
| Directory | Empty; profile only | Rich searchable **exhibitor and product catalogue** (filters: sector, HS code, certifications, MOQ, lead time, export markets), product galleries, downloadable catalogues, "request quote" |
| WhatsApp | `wa.me` links only | **WhatsApp Business API**: badge delivery, reminders, payment confirmations and a menu-driven bot in PT, EN and BN, with opt-in records |
| Accessibility | Low-contrast captions, scroll-jacking | WCAG 2.2 AA audited (axe and manual), no motion pins, reduced-motion by default for long pages, a published accessibility statement, VLibras kept |
| SEO | "2026" naming conflict, thin Event schema | `ExhibitionEvent` with offers, eventSchedule, organiser `sameAs` and per-session `Event`s; landing pages for "Bangladesh suppliers in Brazil" and "feira Bangladesh São Paulo 2027"; news and image sitemaps; `llms.txt` |

### 11.3 Net-new differentiators, prioritised

**P1: win the pitch (high visibility, high business value)**

1. **AI-assisted B2B matchmaking and meeting scheduler.** Buyers and exhibitors declare sector, HS codes, volumes and certifications. The engine proposes matches with reasons. Both sides accept 20-minute slots on a calendar aware of São Paulo and Dhaka time, the system assigns meeting tables, and reminders go out by e-mail, WhatsApp and `.ics`. Afterwards there is a meeting outcome log. This turns BBCCI's promise of "structured B2B matchmaking" into software, and the competitor has nothing like it.
2. **Interactive floor plan with live stand booking.** An SVG or Konva hall plan of Pro Magno with live availability, a hold timer, upgrades (corner, premium), sponsor zones and co-exhibitor sharing. Booking flows straight into the application and the invoice. Admin gets drag-and-drop allocation. Their downloads page still says "Floor plan: added when released".
3. **Exhibitor lead retrieval and visitor app (PWA).** An installable PWA with offline support. Exhibitors scan buyer QR badges and add notes, ratings and follow-up tags, then export to CSV or a CRM (with the buyer's consent captured at registration). Visitors save favourite exhibitors and build a personal agenda, with a hall map and push announcements.
4. **Apple Wallet and Google Wallet badges**, plus a badge that works offline and auto-updates when a name is corrected.
5. **Live payments, Brazil side included:** PIX, BRL and Stripe for sponsors and Brazilian exhibitors, alongside SSLCommerz, bKash and Nagad, with automated instalment schedules and dunning.

**P2: depth that closes the deal with BBCCI management**

6. **Trilingual AI assistant** (web widget and WhatsApp) grounded in the FAQ, visa, customs and package content. It answers in PT, EN or BN, can pre-fill registration, and escalates to a human desk with full context. BBCCI gets a dashboard of questions asked, which also signals content gaps.
7. **Analytics dashboards:** for BBCCI (registrations by type, country and sector; pipeline; revenue; visa status; check-in funnel), for exhibitors (profile views, catalogue downloads, meetings, leads) and for sponsors (impressions, clicks, booth visits). This includes a **post-event ROI report PDF** for each exhibitor and sponsor.
8. **Visa and invitation-letter workflow automation:** a template letter generated from portal data, routed to the Brazilian signing partner, with status tracking. Embassy appointment reminders, a document expiry watcher and a delegation-level visa tracker for BBCCI.
9. **Post-event engagement:** surveys and NPS, certificates of participation (QR-verifiable), "meet again" follow-up campaigns, an archive of meetings, and an exhibitor testimonials module for the next edition's sales.
10. **Rich media:** a 2025 highlight video and interviews (YouTube-nocookie), a **360° virtual tour** of the venue and hall, a live stream of the opening and seminars with recordings, and a speaker video wall.

**P3: nice-to-have and future-proofing**

11. A buyer RFQ marketplace that stays open year-round ("Made in Bangladesh sourcing desk"), so the expo becomes a 12-month platform for BBCCI.
12. A delegation and association console with quota allocation, payment by the association on behalf of its members, and bulk visa packs.
13. An on-site kiosk mode: self check-in, badge printing (Zebra or Brother) and a lost-badge reprint.
14. A seminar room booking and session registration with capacity limits and waitlists, and per-session QR attendance.
15. Sustainability and compliance badges on exhibitor profiles (LEED, WRAP, OEKO-TEX, GOTS, BSCI), verified through public registers, which buyers value.
16. A dark-mode and high-contrast theme, plus a font-size control.
17. A public status page and a published security statement (`security.txt`, pentest summary), which are trust signals for chambers and embassies.

### 11.4 Talking points for the pitch (fact-based, without naming the competitor)

- "We built matchmaking, floor plan, lead capture and live payments, which is what exhibitors actually pay for, not only information pages."
- "Analytics only after consent, no device fingerprinting, a named Encarregado and per-person consent for group registrations. That is genuine LGPD compliance, not policy text alone."
- "Production hosting with edge caching and a sub-2-second LCP target; no shared-hosting 5xx errors on launch day."
- "Every page goes live with real 2026 content, not 'to be announced'."
- "Trilingual from URL to e-mail to PDF to WhatsApp, including fully localised Portuguese URLs."

---

## Appendix A: Not verifiable without login

The following could not be verified without an account: portal screens, invoice and contract PDFs, e-mail templates, the association portal, admin desks, the guided-mode UI, badge PDF and WhatsApp delivery, instalment logic and audit trail. Their existence is inferred from the video transcript and from module names and strings in the public JS bundle. Treat them as "probably partially built". The video itself says the BBCCI console with guided mode, the finance and visa desks, QR check-in and campaigns are **still to be done**, although check-in, campaigns and pipeline code is already shipped in the bundle.

## Appendix B: Raw artefacts (scratchpad)

- HTML of all 162 pages: `C:\Users\amaiz\AppData\Local\Temp\claude\C--Users-amaiz-Documents-Arrowbin-brazilbangladeshtrade\6bc2ff72-4b93-444c-bda0-30e067598045\scratchpad\jv\html\`
- Extracted text: `…\scratchpad\jv\txt\` (full) and `…\scratchpad\jv\main\` (main content only)
- Bundles: `…\scratchpad\jv\assets\` (with `mods\` holding 144 chunks); fetch log with sizes and TTFB: `…\scratchpad\jv\fetchlog.txt`
- Playwright metrics: `…\scratchpad\shots\_metrics.json`
- 2025 briefing deck: `…\scratchpad\dl_pptx\briefing2025.pptx`
