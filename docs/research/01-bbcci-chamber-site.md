# 01 · BBCCI chamber website: knowledge base

**Source:** https://brazilbangladeshchamber.com/ (WordPress 7.1.3, Elementor 4.3.5, theme "Mega Business" by Creativ Themes, Rank Math SEO, Google Site Kit, LiteSpeed, PHP 8.2)
**Crawled:** 19 Oct 2026. The newest content on the site is a post dated 18 Oct 2026.
**Purpose:** research input for the new "Made in Bangladesh Expo" portal (São Paulo). This report only records facts; it proposes no design.
**Asset library:** `research-assets/bbcci/` (see section 16 and `research-assets/bbcci/manifest.json`)

> Conventions: quotes are copied word for word from the site, including its typos. "Site" means brazilbangladeshchamber.com. Anything found **off-site** is labelled **EXTERNAL**. Post URLs are shortened to their slug where the meaning is clear (prefix `https://brazilbangladeshchamber.com/`).

---

## 0. Executive summary

* The site is a **chamber website with an SEO blog**. It is not an expo website. It has 7 pages and 89 posts. Almost all posts (≈85) are long, mostly AI-assisted trade-guide articles by Secretary General Md. Joynal Abdin. Only about 5 posts carry real event or expo information.
* **Expo editions as stated on the site:**
  * **1st edition, "Made in Bangladesh Expo 2025":** **15–18 June 2025**, São Paulo, at "**Novotel Center Norte and Expo Norte facilities**" (other wordings on the site: "Novotel / Expo Norte", "Novotel Expo Norte", "Expo Center Norte"). Organised by BBCCI; the banner says "Supported by the Brazilian Embassy in Dhaka".
  * **"2026" edition:** announced on 16 May 2026 as the second edition, "**Tentatively scheduled between November 20 and November 30, 2026 for a three-day program**", with "final dates … yet to be finalized". No venue is given.
  * **"2027":** the newest post (18 Oct 2026) says "consider participating in the **Made in Bangladesh Expo 2027** in São Paulo, **subject to the organizer's confirmed schedule**". No dates and no venue.
  * The site **never mentions** "22–25 March 2027" or "Pro Magno".
* **Prices are not on the site.** They appear only in an **EXTERNAL** BGMEA circular that contains BBCCI's own 2025 prospectus and invitation letter:
  * Exhibitor stall: **USD 4,000** (8×8 sq ft, 2 exhibitors, stall preparation and branding).
  * Importer/B2B participant: **USD 1,000** per person.
  * **10% early-bird discount** to 31 Jan 2025 (later extended to 15 Feb 2025).
  * Registration deadline: 30 Mar 2025, later extended to **30 Apr 2025** (the extension is on the site, as an image).
  * Bank: **Eastern Bank Ltd**.
* **Contacts:**
  * Office: Shanta Skymark, Levels 8th–13th, 18 Gulshan Avenue, Gulshan, Dhaka-1212.
  * Emails: president@ / vp@ / sg@brazilbangladeshchamber.com.
  * Phone/WhatsApp **+880 1553 676767**. This number appears only inside blog posts and images, not on the Contact page.
  * There is **no Brazil office address** and there are **no social media links**.
* **Leadership:** President **Shahriar Ahmed**, Vice President **Md. Saiful Alam**, Secretary General **Md. Joynal Abdin**. The Brazilian Ambassador **H.E. Paulo Fernando Dias Feres** is captioned "Chief Patron of BBCCI".
* **Assets collected:**
  * 108 media-library items, which reduce to **81 unique files (≈216 MB)** after de-duplication. That includes 15 logo files, 17 Expo-2025 photos and images (12 of them high-resolution São Paulo photos at 7008×4672), and 23 event photos.
  * 3 leadership headshots cropped from the EXTERNAL prospectus.
  * **7 YouTube videos** and **0 self-hosted videos**.
  * **1 on-site document**: a 7.1 MB briefing-session PPTX that is not linked from any page. It holds the Expo 2025 programme.

---

## 1. Crawl method and coverage

| Source | Result |
|---|---|
| `sitemap.xml` → `sitemap_index.xml` (Rank Math) | post-sitemap (89 URLs), page-sitemap (7), category-sitemap (3: events, news, blog) |
| REST `/wp-json/wp/v2/pages` | 7 pages (X-WP-Total 7) |
| REST `/wp-json/wp/v2/posts?per_page=100` | 89 posts (X-WP-Total 89) |
| REST `/wp-json/wp/v2/media` | 108 items over 2 pages (107 images and 1 PPTX) |
| REST categories / tags | Categories: Blog (87), News (50), Events (4), Photo Gallery (0), Uncategorized (0). **492 tags.** |
| REST users (public) | 3 authors: "Md. Joynal Abdin" (×2 accounts) and an admin whose display name is the email address `mdjoynal@gmail.com` |
| REST comments | 0 comments. Comment forms are open on every post. |
| Full HTML of all 101 sitemap and category URLs | Fetched to read the header/menu, footer, meta, Elementor video widgets and schema |
| Not accessible | Elementor templates (`elementor_library`, 401), menu-items (401). Neither is needed: the header and footer were read from the HTML. |
| YouTube oEmbed | Titles fetched for all 7 IDs |
| Off-site (EXTERNAL, for prices only) | BGMEA circular PDF (see §5.4 and §14) |

Every page and post was read in full (REST `content.rendered`, converted to text). Expo-relevant sentences were extracted from all 96 documents with keyword searches. Images that carry text (posters, promos, banners) were read visually.

---

## 2. Site structure

**Header menu** (theme header, identical on every page): Home · About us · Our Services · Membership · Events (`/category/events/`) · Blog (`/category/blog/`) · Photo Gallery · Contact us. The header logo is `cropped-BBCCI-Logo.jpg` (240 px, served as WebP). The site title text is "Brazil Bangladesh Chamber of Commerce & Industry (BBCCI)".

**Footer:** only "Copyright © All rights reserved. Theme Mega Business by Creativ Themes". There is no address, phone, email, social links or sitemap. The sidebar on posts has a search box.

**Pages (7):** Home, About us, Our Services, Membership, Members Profile (not in the menu, placeholder content), Contact us, Photo Gallery. See §18 for the inventory.

**Category archives:** /category/events/ (4 posts), /category/news/ (50), /category/blog/ (87). Most posts are in both Blog and News.

**Behaviour:**
* Unknown URLs (for example `/pt/`, `/this-page-does-not-exist/`) **301-redirect to the home page**. There is no real 404 page.
* `www.` and `http://` redirect to `https://brazilbangladeshchamber.com/`.
* `robots.txt` allows everything except /wp-admin/.

---

## 3. The organisation: BBCCI

| Item | Value (source) |
|---|---|
| Full name | **Brazil Bangladesh Chamber of Commerce & Industry (BBCCI)**. Bangla: "ব্রাজিল বাংলাদেশ চেম্বার অব কমার্স অ্যান্ড ইন্ডাস্ট্রি (বিবিসিসিআই)" (promo images) |
| Nature | "a bilateral chamber of commerce and industry"; "Geographic Focus: Brazil–Bangladesh business corridor" (`/bbcci/`) |
| Founding year | **Not stated anywhere.** The Home page says only "Established with the aim of strengthening commercial ties…". The earliest site content is from Mar 2024 (pages created 10 Mar 2024; first media 4 Mar 2024). One post calls BBCCI "a relatively new but active entity" (`/can-latin-america-be-bangladeshs-answer-to-us-tariff-hikes/`). |
| Registration / legal status | **Not stated** (no registration number, RJSC, licence or trade-body affiliation). One promo calls it "a non-profit, member-based organization" (2026-10 featured graphic). |
| Mission (Home, About) | "BBCCI is dedicated to facilitating trade and investment flows between Brazil and Bangladesh by providing a platform for networking, advocacy, and knowledge exchange. Our mission is to enhance bilateral economic relations, foster partnerships, and support the growth and prosperity of businesses in both countries." |
| Vision | "Our vision is to be recognized as the premier bilateral chamber of commerce, driving sustainable economic development and creating value for our members through innovative initiatives, strategic partnerships, and collaborative efforts between Brazil and Bangladesh." |
| Objectives (Home, About) | Promote Trade and Investment; Advocacy and Representation; Information and Knowledge Sharing; Capacity Building; Promote Cultural Exchange; Networking and Collaboration (each with a one-sentence description). |
| Governance (About us) | **Board of Directors (18 Members)**, the highest governing body. **Executive Committee**: President, Vice President, Treasurer, Secretary-General ("Appointed by Board"). **Committees**: 1. Trade and Investment, 2. Membership and Outreach, 3. Events and Programs. Role descriptions for President, VP, Treasurer and Secretary-General. **No director or treasurer names are published.** |
| Head office | **Shanta Skymark, Levels 8th-13th, 18 Gulshan Avenue, Gulshan, Dhaka-1212, Bangladesh** (Contact us). The letterhead in the EXTERNAL PDF says "**Level 12**" at the same building. |
| Brazil office | **None given anywhere.** |
| Emails | President: **president@brazilbangladeshchamber.com** · Vice President: **vp@brazilbangladeshchamber.com** · Secretary General: **sg@brazilbangladeshchamber.com** (Contact us). **info@brazilbangladeshchamber.com** appears only in the briefing PPTX. |
| Phone / WhatsApp | **+880 1553 676767** (written variously as +8801553676767, +880 1553-676767, +880 1553 676767). It is labelled "Phone/WhatsApp" in `/top-brazilian-markets-interested-in-bangladeshi-exports/` and `/brazil-market-entry-support-for-bangladeshi-exporters-2/`, and "Whats-App" in `/bangladesh-brazil-business-matchmaking/`. **It is not on the Contact page.** A second number, **+880 19926 77117**, appears only on the "Membership Month 2025" promo image. |
| Office hours | Not published. |
| Social media | **None linked** from the site: no Facebook, LinkedIn, X, Instagram or WhatsApp link. The videos are embedded from the **Trade & Investment Bangladesh (T&IB)** YouTube channels (`@tib-bd`, `@TradeInvestmentBangladesh`). One citation links to the T&IB Facebook page. |
| Analytics | Google Site Kit (GT-TWR8ZNJS) and Burst statistics. |
| Related entities | SG Md. Joynal Abdin is also "Founder & CEO, Trade & Investment Bangladesh (T&IB)" (tradeandinvestmentbangladesh.com), "Executive Director, Online Training Academy (OTA)", "Editor, T&IB Business Directory" and "Business Consultant". His personal site is mdjoynalabdin.com. Every post links to these sites. |

**Milestones claimed by the site** (`/brazil-bangladesh-chamber-of-commerce-industry-bbcci/`, quoting BBCCI's "introductory deck", which is not on the site):
1. Made in Bangladesh Expo 2025 in São Paulo.
2. A "Brazilian business delegation visit to Bangladesh, including engagement with the Honorable Foreign Minister of Brazil".
3. "Business networking events and press conferences".
4. "Strategic Partnership Outreach for Made in Bangladesh Expo 2026".

---

## 4. People

| Name | Role | Evidence and photos |
|---|---|---|
| **Shahriar Ahmed** | President, BBCCI (president@) | Captions on About, Membership and post 216. Expo 2025 speech: `expo-2025/2025-07_DSC07671.jpg` ("President's Speech in Made in Bangladesh Expo 2025"). 8 Mar 2024 seminar: `events/2024-04_IMG_8305.jpg`. YouTube video yEet013K4qs. Headshot: `people/shahriar-ahmed-president.png` (EXTERNAL source). **Inconsistency:** media item 151 is titled "Mr. **Md. Shahriar Alam**, President, BBCCI" while its caption says "Mr. Shahriar Ahmed". |
| **Md. Saiful Alam** | Vice President, BBCCI (vp@). He signed the Expo 2025 invitation letter. | `expo-2025/2025-07_DSC07928.jpg` (alt "Md. Saiful Alam, VP, BBCCI"), `events/2024-04_IMG_8728.jpg`. YouTube mDVMcqUm_H8 and XnuwXSDGaVs. Headshot: `people/md-saiful-alam-vice-president.png` (EXTERNAL). |
| **Md. Joynal Abdin** | Secretary General, BBCCI (sg@). Author of almost all posts. Founder & CEO of T&IB. | `expo-2025/2025-07_DSC07660.jpg` ("Secretary General's Presentation…"). YouTube Yy8khT4DCAU. Headshot: `people/md-joynal-abdin-secretary-general.png` (EXTERNAL). |
| (Treasurer) | Role described on About us | **Name not published** |
| (18 Board directors) | | **Names not published** |
| **H.E. Paulo Fernando Dias Feres** | Ambassador of Brazil to Bangladesh. Captioned "**Chief Patron of BBCCI**" (media 146, post `/bbcci-events/`). | `events/2024-04_IMG_8746.jpg`, `events/2024-04_IMG_8737.jpg`, Dhaka press conference photos `expo-2025/2025-05_RTN_8401.jpg`, `2025-12_RTN_8412.jpg`, `2026-05_1-46.jpg`. Quoted in the Expo 2025 impact post. |
| **Mauro Vieira** | Foreign Minister of Brazil. Guest of honour at the FBCCI–BBCCI meeting, InterContinental Dhaka. | `events/2024-04_IMG_8646.jpg`, `IMG_8663`, `IMG_8695` |
| Ahasanul Islam Titu, MP | State Minister for Commerce, Bangladesh (2024 meeting) | `events/2024-04_IMG_8638.jpg` |
| Mahbubul Alam | President, FBCCI (chaired the 2024 meeting) | post 216 |
| Md. Amin Helalay [sic], Shomi Kaiser | FBCCI SVP / VP (2024 meeting attendees) | post 216 |
| Tipu Munshi, MP | Commerce Minister (undated BBCCI event) | `events/2024-03_S-5-1.jpg` |
| Md. Jashim Uddin | President, FBCCI (undated BBCCI event) | `events/2024-03_S-4.jpg` |
| Dr. Taufiqul Islam, PhD | "Chief Guest of the Made in Bangladesh Expo 2025" (his role or office is not stated) | `expo-2025/2025-07_DSC07697.jpg` |
| Mrs. Regina Nunes | Pictured at the Expo 2025 podium and stalls (her role is not stated) | `expo-2025/2025-07_DSC08138/8161/8166/8174.jpg` |
| Rafael dos Santos | "Brazilian textile importer". Testimonial in the impact post. | text only |

---

## 5. Made in Bangladesh Expo

### 5.1 What the site says about editions and dates (evidence)

| Edition | Exact wording on the site | Where | Published |
|---|---|---|---|
| **2025 (1st)** | "hosted its pioneering Made in Bangladesh Exhibition‑2025 in São Paulo, Brazil **from June 15 to 18, 2025**. Organized by the Brazil‑Bangladesh Chamber of Commerce and Industry (BBCCI)" | `/made-in-bangladesh-expo-2025-impact/` | 2025-07-06 |
| | "The official event information highlighted **Novotel / Expo Norte** as the venue, with dates widely communicated as **15–18 June 2025** … one public-facing event page referenced **20 exhibitors**." | `/case-study-on-the-made-in-bangladesh-expo-2025-sao-paulo-brazil/` | 2025-12-27 |
| | "Held in **June 15-18, 2025 at Novotel Center Norte and Expo Norte facilities in São Paulo**" | `/made-in-bangladesh-expo-in-sao-paulo-brazil/` | 2026-05-16 |
| | Poster: "Made in Bangladesh EXPO 2025 · June 15-18, 2025 in Sao Paulo, Brazil · Be part of history at the 1st Ever Made in Bangladesh Expo in the Soil of Latin America … Early Birth [sic] Registration Before 31st January 2025 10% Discount · +880 1553 676767" | image `2025/07/BBCCI-1.jpg`, used in `/can-latin-america-…/` and `/investment-opportunities-…/` | 2025-07-26 |
| | Bangla notice: registration deadline for the expo (15–18 June 2025, São Paulo) "**extended from 31 March 2025 to 30 April 2025**"; register via +880 1553 676767 | image `2025/07/Made-in-Bangladesh-Expo-2025.jpg` (in the media library, not shown on any page) | 2025-07-26 |
| | Dhaka press-conference banner: "…15-18, 2025 at **Novotel Expo Norte**, Sao Paulo, Brazil · **Supported by the Brazilian Embassy in Dhaka** · [1st] Ever 'Made in Bangladesh' Expo on Latin American Soil · Grand Ball Room (Level-6), Hotel Ascott Palace Dhaka, House-14, Road-6, Block-K, Baridhara Diplomatic Zone, Dhaka-1212" | photos `2026/05/1-46.jpg` (on the Expo post), `2025/05/RTN_8401` and `RTN_8412` | 2025-05 |
| | Briefing deck: "Briefing Session on Made in Bangladesh Expo 2025 · **15-18 June 2025, Expo Center Norte, Sao Paulo, Brazil**" | `2025/07/Presentation-for-the-Briefing-Session.pptx` | 2025-07-06 |
| **"2026" (planned 2nd)** | "preparations are underway for the Made in Bangladesh Expo 2026 in São Paulo, Brazil. The **second edition** of the expo is expected to be larger… **Tentatively scheduled between November 20 and November 30, 2026 for a three-day program**… Although the final dates and detailed schedule are yet to be finalized…" | `/made-in-bangladesh-expo-in-sao-paulo-brazil/` | 2026-05-16 |
| | "the chamber is actively inviting strategic partners for the 'Made in Bangladesh Expo 2026' in São Paulo" | `/brazil-bangladesh-chamber-of-commerce-industry-bbcci/` | 2026-04-06 |
| | "the upcoming Made in Bangladesh Expo 2026 in São Paulo" (3 mentions) | `/how-to-start-importing-from-brazil-to-bangladesh/` | 2026-07-08 |
| **"2027"** | "Bangladeshi manufacturers can also consider participating in the **Made in Bangladesh Expo 2027 in São Paulo, subject to the organizer's confirmed schedule and participation arrangements**." | `/how-to-find-brazilian-buyers-bangladeshi-garments-textiles-denim/` (newest post) | **2026-10-18** |
| 22–25 Mar 2027 / Pro Magno | **No mention.** There are 0 matches for "Magno", "Pro Magno", "March 2027" or "22–25" on any page, post or image caption. | – | – |

**Reading of the evidence:**
* The chamber's own content moved from "Expo 2026, tentatively 20–30 Nov 2026, three days" (May–July 2026) to "Expo 2027, subject to confirmed schedule" (18 Oct 2026).
* No 2026 venue, registration or programme was ever published.
* The site therefore **supports "the 2nd edition slipped to 2027"**. It does **not** confirm the competitor's "22–25 March 2027, Pro Magno Centro de Eventos" and does not contradict it either.
* The client's name "Made in Bangladesh Expo **2026**" matches the site's May–July 2026 wording but not its latest post. **Confirm with the client** (see §20).

### 5.2 Expo 2025: consolidated facts

| Field | Value | Source |
|---|---|---|
| Name | "Made in Bangladesh Expo 2025". Also "Made in Bangladesh Exhibition‑2025". The on-site backdrop reads "**MADE IN BANGLADESH TRADE FAIR 2025**" with a separate "BB" monogram logo. | posts 264/545; photos DSC07487/96 |
| Dates | 15–18 June 2025 (Day 1 was set-up, so 3 public days) | multiple |
| Venue | Novotel São Paulo Center Norte / Expo Center Norte complex, São Paulo. Named variously: "Novotel Center Norte and Expo Norte facilities", "Novotel / Expo Norte", "Expo Norte Novotel", "Novotel Expo Norte", "Expo Center Norte". The photos show **hotel function rooms** (meeting-room stalls, a small stage), not a large exhibition hall. **No street address is given on the site.** | posts 353, 545; PPTX; EXTERNAL prospectus; photos |
| Organiser | BBCCI | all |
| Supporter | "Supported by the Brazilian Embassy in Dhaka" (press banner). The invitation letter reference is "BBCCI/Brazil Embassy/2025/003". | photos; EXTERNAL letter |
| Other bodies named | Planned partner meetings with **FBCCI, MCCI, EPB, BGMEA, BKMEA, BTMA** "and other stakeholders" plus a "Meeting with Divisional Chamber of Commerce" (prospectus timeline, EXTERNAL). **BGMEA** circulated the invitation to its members (EXTERNAL). The site shows "BBCCI & BGMEA Leadership" photos (May 2024). | §14 |
| Exhibitors | "one public-facing event page referenced **20 exhibitors**" (case study). One stall is identifiable in photos: **STS Apparel Pvt. Ltd** (DSC08161); another shows an accessories stall (DSC08174). No exhibitor list is published. | post 353 |
| Visitors, countries, stalls, sq m | **Not published.** | – |
| Sectors | RMG, jute goods, pharmaceuticals, leather, industrial machinery (post 264); RMG, jute, pharma, leather, home textiles (post 353); garments, pharma, clean energy (post 330); handicrafts (post 392). Prospectus "Focused Area – Bangladesh": RMG; Jute & Jute Manufactures; Leather & Leather Products; Fish, Shrimps & Prawns; Home Textile; Vegetable Products; Pharmaceutical Products; Plastic & Plastic Products; Bicycles & Parts; Handicrafts; Petroleum & Petroleum Products; Ceramics & Agro-Processed Products. "Focused Area – Brazil": Mineral Fuels; Oil Seeds; Meat & Poultry; Iron & Steel; Cereals; Machinery; Sugar & Coffee; Dairy Products. | posts; EXTERNAL |
| Format and features | Exhibition stalls; B2B and B2G meetings; seminars and workshops; cultural exchange; "Food Courts" (prospectus). The impact post mentions "tailored B2B matchmaking, policy dialogues, and cultural showcases". | EXTERNAL; post 264 |
| **Programme** (PPTX, on site) | **Day 1, 15 Jun:** stall preparation and display. **Day 2, 16 Jun:** Meet the Press 9.30–10.30 am; Inaugural Ceremony 11.00 am–1.00 [pm]; B2B Matchmaking 2.00–5.00 pm. **Day 3, 17 Jun:** Seminar on Trade & Investment Opportunities between Bangladesh & Brazil 11.00 am–1.00 pm; B2B 2.00–5.00 pm. **Day 4, 18 Jun:** Seminar by Brazilian Expert 11.00 am–1.00 pm; B2B 2.00–5.00 pm; Meet the Press & Closing Ceremony 5.00–7.30 pm. | `docs/2025-07_Presentation-for-the-Briefing-Session.txt` |
| Exhibitor briefing ("How to participate") | 10 steps: initial preparations, products to display, lead generation, pre-expo communication, samples, stall design, export pricing (FOB/CIF), attracting buyers, collecting visitor info, post-expo follow-up. | PPTX |
| Speakers / guests | President Shahriar Ahmed (speech), SG Md. Joynal Abdin (presentation), VP Md. Saiful Alam, Chief Guest Dr. Taufiqul Islam PhD, Mrs. Regina Nunes. Ambassador Paulo Feres is quoted. | captions |
| Outcomes (as claimed) | "A Bangladeshi pharmaceutical company signed a distribution MoU with a São Paulo-based health distributor"; "a joint venture in sustainable packaging was proposed between a Bangladeshi jute goods exporter and a Brazilian agri-startup"; "Several deals were initiated" (VP). Post 452 itself cautions these are claims "investors should independently verify". | posts 264, 414, 452 |
| Testimonials | Shahriar Ahmed: "This historic event marked a turning point in Bangladesh's global trade outreach…". Md. Saiful Alam: "The expo was not just about promoting exports it was about building relationships…". Md. Joynal Abdin: "This event created real momentum…". Ambassador Paulo Feres: "The expo showcased how much untapped potential exists between our two nations…". Rafael dos Santos: "I found the textile quality outstanding. We've begun discussions with two Bangladeshi RMG manufacturers…" | post 264 |
| Pre-event activity | Dhaka press conference / briefing at Hotel Ascott Palace, Baridhara (photos uploaded May 2025, banner "Supported by the Brazilian Embassy in Dhaka"). A "Briefing Session" presentation by the SG. The prospectus timeline (EXTERNAL) lists Jan: partners meeting and press conference; Feb: partner selection and registration; Mar: completing registration; Apr: printing, publication and visa processing (air tickets, hotel booking, sending products). | photos; PPTX; EXTERNAL |
| Visa / hotel / travel info | **Not on the site.** The membership promo lists "চেম্বারের সুপারিশপত্র ও ভিসা রেফারেন্স সুবিধা" (chamber recommendation letter and visa reference facility) as a member benefit. The prospectus lists visa processing, air tickets and hotel booking as an April task, and Novotel amenities under "Services Available on Payment" (residential rooms, bar, pool, EV charging, parking, gym, A/C, free WiFi, 24/7 front desk, laundry, restaurant). BGMEA notes it is "not liable for stall fees or visa-related issues" and allows "only two representatives" per booth (EXTERNAL). | promo image; EXTERNAL |

### 5.3 "2026" / next edition: what is known

* **Dates:** "tentatively … between November 20 and November 30, 2026 for a three-day program". Final dates "yet to be finalized" (16 May 2026). No later confirmation exists. The 18 Oct 2026 post refers to "Expo 2027".
* **Venue:** not stated. The text mentions only "expanded exhibition facilities".
* **Planned content:** "specialized seminars, investment forums, policy discussions, cultural showcases, buyer–seller matchmaking sessions, networking events, and industrial cooperation dialogues". Focus sectors: RMG, pharmaceuticals, jute, leather, agro-processing, renewable energy, ICT services, sustainable manufacturing, industrial innovation. Invited service providers: "logistics providers, shipping companies, certification agencies, and financial institutions". Invited participants: garments, textiles, pharma, jute, leather, agro-processing, engineering, ICT, renewable energy, ceramics, home décor.
* **No prices, packages, registration form, deadlines or floor plan** are published for 2026 or 2027.

### 5.4 Packages, prices, deadlines and payment (EXTERNAL; not on the site)

These come from the BGMEA circular dated 28 Jan 2025 (`docs/external/BGMEA-circular-Brazil-Fair-1738148853.pdf`, 24 pages: circular, registration form, BBCCI invitation letter and BBCCI prospectus).

| Item | Value |
|---|---|
| Exhibitor / stall | "**Stall Size: 8x8 sq. ft.**", "**Fee: USD 4,000** (includes 2 exhibitors in the business delegation, venue rental, stall preparation, and branding)". Prospectus wording: "A company can nominate two exhibitors for one stall registration fee with space rental, stall preparation and Branding will be $ 4000 (four thousand dollars) per company". |
| Individual / importer (B2B) | "**Fee: USD 1,000** (includes membership in the business delegation and B2B matchmaking opportunities)". Prospectus: "Bangladeshi importers/businessmen can register to visit the expo and participate in B2B Meetings and networking sessions with $ 1000 (One thousand dollars) per person." |
| Early bird | "A 10% discount is available for registrations completed by 31 January 2025". BGMEA adds: "[The date of early bird registration extended till 15 February, 2025]". |
| Registration deadline | "complete the registration process by **30th March 2025**" (prospectus). The on-site Bangla notice extends it to **30 April 2025**. |
| Required documents | BBCCI letter: "Trade License; TIN Certificate; VAT Registration; Owner's Profile". BGMEA form: Trade License, Certificate of Incorporation (Ltd co.), TIN, VAT, Export License, Import License, BGMEA Membership Certificate. |
| Registration form fields (BGMEA version) | 1. Company Name · 2. Owner's Name · 3. Mobile No. / Email · 4. Nominated person's name(s) to attend · 5. Designation · 6. **Passport No** · 7. Mobile No(s) · 8. Email · 9. Type of Registration (A. Exporter $4000 / B. Importer $1000) · 10. Deposit slip No · 11–12. Account title and number · 13. Objective (A. Export to Brazil / B. Import from Brazil) · 14. List of products · 15. Attached documents · 16. Declaration (name, signature and date) |
| **Bank details (copied exactly)** | "Account Title: 'Brazil Bangladesh Chamber of Commerce & Industry', Account Number: 1271070160028, Bank Name: Eastern Bank Ltd, SWIFT Code: EBLDBDDH, Branch Address: North Gulshan Branch, 169 Gulshan Avenue, Dhaka-1212, Bangladesh". *(These are BBCCI bank details from 2025. Do not publish them on the new portal without fresh confirmation from the client.)* |
| Payment method | Deposit into the account above, then attach the deposit slip to the form. There is no online payment. |
| Currency | USD only. No BDT or BRL prices anywhere. |

---

## 6. Sectors and products promoted

* **Members-profile sectors** (site): "Readymade Garment, Textiles, Pharmaceuticals, Leather Goods, Plastic Goods, Jute & Jute Goods, Consumer Products, Real Estate, etc."
* **Services page:** "agriculture, textiles, pharmaceuticals, and technology".
* **Bangladesh → Brazil**, repeated across the posts: RMG (knitwear, woven, denim, sweaters, workwear), home textiles, jute and jute goods (coffee/cocoa sacks, bags, geotextiles), leather and footwear, pharmaceuticals, ceramics, plastics, bicycles, frozen fish and shrimp, handicrafts, light engineering, ICT/BPO, agro-processed foods.
* **Brazil → Bangladesh**: raw cotton, raw and refined sugar, soybeans and soy meal, wheat and maize, animal feed, edible oils, beef and poultry, coffee, iron and steel, pulp and paper, machinery, petrochemicals. The invitation letter also lists coffee, soybeans, beef and poultry, sugar, corn, iron ore, footwear, automobiles and auto parts, paper and pulp, petrochemicals (EXTERNAL).

---

## 7. Partners, sponsors, supporters, media

* **No partner, sponsor or media-partner logos exist** on the site or in the media library. The `partners/` asset folder is therefore empty and was not created.
* Organisations named in content:
  * **Brazilian Embassy in Dhaka**: "Supported by…" (press banner); the Ambassador is "Chief Patron".
  * **FBCCI**: co-organiser of the 8 Mar 2024 "Meeting on Facilitating Trade between Bangladesh and Brazil" (backdrop: "Jointly organized by the Federation of Bangladesh Chambers of Commerce and Industry and Brazil Bangladesh Chamber of Commerce & Industry").
  * **BGMEA**: leadership meeting photos (May 2024, `/photo-gallery/`) and the expo circular to members (EXTERNAL).
  * **MCCI, EPB, BKMEA, BTMA**: planned "Partners Meeting" (prospectus, EXTERNAL).
  * **T&IB (Trade & Investment Bangladesh)**: the SG's company. Its YouTube channels host all embedded videos.
  * The FBCCI–ApexBrasil MoU (2023) is mentioned as context (`/how-to-find-business-partners-in-brazil/`).
* **Media coverage:** none listed on the site. The site's own citations reference Financial Express ("Brazil hosts Made in Bangladesh Expo") and The Business Standard.

---

## 8. Events and news (real events only)

| Date (as evidenced) | Event | Source |
|---|---|---|
| Undated (before Mar 2024; the office-holders shown suggest 2023 or earlier) | BBCCI event attended by Commerce Minister Tipu Munshi MP, FBCCI President Md. Jashim Uddin and the Brazilian Ambassador ("Chief Patron of BBCCI") | `/bbcci-events/` (posted 25 Mar 2024) and photos S-1…S-7 |
| **8 Mar 2024** per the backdrop ("08 March 2024 \| Intercontinental Dhaka"); the post says "Dhaka, April 8, 2024" | "Meeting on Facilitating Trade between Bangladesh and Brazil", a seminar plus B2B matchmaking, FBCCI + BBCCI, Hotel InterContinental Dhaka. Brazil FM Mauro Vieira, State Minister Ahasanul Islam Titu, FBCCI President Mahbubul Alam (chair). Sectors: pharma, healthcare, jute, RMG, food, agri; call for FTA/PTA. | `/bangladesh-and-brazil-explore-trade-opportunities/` |
| May 2024 | BBCCI & BGMEA leadership meeting (2 group photos) | `/photo-gallery/` |
| Jan–May 2025 | Expo 2025 promotion: posters, early-bird offer, deadline extension, Dhaka press conference at Hotel Ascott Palace, briefing session | images and PPTX |
| **15–18 Jun 2025** | **Made in Bangladesh Expo 2025**, São Paulo | §5 |
| 15 Jul–14 Aug 2025 | "Membership Month 2025" campaign | promo image |
| 2026 | "2026" edition announced (tentatively 20–30 Nov 2026), then referred to as "Expo 2027" on 18 Oct 2026 | §5.1 |

**Not found anywhere on the site:** a Dhaka "launch" of Expo 2026/2027, roadshows or promotion meetings in **Rangpur** or **Chattogram** (Chattogram appears only as a port in logistics guides), MoU signings by BBCCI itself, inbound delegation reports, or ambassador meetings after 2024. If the client has held these, the content has to come from them, for example from social media.

---

## 9. Membership

* **Types on the Membership page:**
  * **2.1 Corporate Membership:** businesses and corporations; networking, trade missions, advocacy.
  * **2.2 Individual Membership:** professionals, entrepreneurs, consultants.
  * **2.3 Associate Membership:** chambers, trade associations, non-profits.
* **Types in `/bbcci/` (from the "introductory deck"):**
  * **Life Membership:** "the most prestigious membership of BBCCI. It offers lifelong access to all services…priority in case of representation".
  * **Corporate Membership.**
  * **General Membership:** "the common membership class for SMEs subject to annual renewal".
  * **Associate Membership.**
  * Post 524 notes the mismatch with the Membership page.
* **Benefits (page sections 3.1–3.6):** Networking Opportunities; Information and Resources; Representation and Advocacy; Events and Activities ("Priority invitation and discounted rates…"); Visibility and Recognition; Support Services ("Assistance with documentation, certifications…").
* **Benefits in the Bangla promos:**
  * Building a Brazil–Bangladesh business network.
  * Export-import cooperation and trade information.
  * B2B meetings, seminars and trade-delegation participation.
  * **Chamber recommendation letter and visa reference facility.**
  * Business development, training and consulting.
  * Access to the Latin American market.
  * Coordinated activities with government and foreign embassies.
  * Policy, information and research services.
* **Fees:** **not published anywhere**.
* **Application process:** **none on the site.** There is no form and no downloadable application. Promos say "contact +8801553676767" or email sg@.
* **Members directory:** the "Members Profile" page is an unfinished template ("We have **XYZ** number of members…", 3 blank entries).

---

## 10. Services (Our Services page)

1. Business Matchmaking
2. Market Intelligence
3. Trade Promotion (trade fairs, exhibitions)
4. Investment Facilitation
5. Business Advisory Services
6. Networking and Advocacy
7. Training and Capacity Building

The `/bbcci/` post adds a 10-item portfolio: networking events, trade missions and business delegations, matchmaking, advocacy, market research, seminars and workshops, trade promotion and exhibition support, legal and regulatory guidance, access to resources and partnerships, advisory services. Later posts present BBCCI as a "single window" for Brazil market-entry support.

---

## 11. Forms and registration mechanisms on the site

* **Search** form (sidebar, every page).
* **WordPress comment form** on every post (Comment, Name, Email, Website). There are 0 approved comments.
* **No contact form, no membership application, no expo registration or booking, no payment, no newsletter signup.** Registration in 2025 was offline: a PDF/Word form, bank deposit, then email or phone.

---

## 12. Bangladesh–Brazil relationship facts cited on the site

The figures below are as published. Note that the posts cite different sources and do not agree with each other.

| Fact | Value | Source |
|---|---|---|
| Diplomatic relations | Established **1972** | `/brazil-bangladesh-trade-agreements-current-state-and-evolution/` |
| Relationship length | "spanning over 50 years" (FBCCI president, 2024) | post 216 |
| Trade 2022 (OECD) | Brazil→BD **USD 2.35 bn**; BD→Brazil **USD 178 m** | case study; prospectus |
| Trade 2022 | "bilateral trade valued at over US $2.5 billion in 2022" | post 264 |
| Top Brazil→BD items 2022 | Soybeans $641 m; raw cotton $490 m; raw sugar $476 m; wheat $90.5 m; semi-finished iron $64.3 m; sulfur $50.5 m; poultry $44.5 m; frozen bovine meat $42.3 m; hides $36.7 m | prospectus (EXTERNAL) |
| Top BD→Brazil items 2022 | Knit T-shirts $47.5 m; non-knit men's suits $25.3 m; knit sweaters $24.1 m; non-knit women's suits $15.2 m; knit women's suits $14.8 m; non-knit men's shirts $10.5 m… | prospectus (EXTERNAL) |
| BD exports to Brazil (EPB) | FY2021-22 $109 m; FY2022-23 $175 m; FY2023-24 $147 m; **FY2024-25 $187 m (+26%)** | `/bangladesh-exports-to-brazil/`, `/complete-guide-…/` |
| FY2023-24 (other source) | Exports US$156.19 m; imports US$2,661.76 m; deficit ≈US$2.51 bn | `/bangladesh-brazil-trade-opportunities/` |
| CY2024 | Exports US$242.40 m; imports US$2,484.04 m; total US$2,726.44 m | same |
| BBS FY2023-24 | Exports Tk 21.96 bn; imports Tk 412.43 bn | `/bangladesh-brazil-business-matchmaking/` |
| 2025 (Comtrade) | Brazil→BD **US$2.72 bn**; BD→Brazil **US$281.79 m**. Dec 2025: $368 m / $22.8 m | `/bangladesh-brazil-business-opportunities/` |
| 2025 import categories | Sugar ~US$874.47 m; cotton ~US$814.83 m; cereals ~US$389.08 m; fodder ~US$215.58 m; oilseeds ~US$211.95 m; fats and oils ~US$137.20 m | same |
| Cotton | MY2024-25: BD imported 8.28 m bales; Brazil supplied 1.9 m (≈23%), the largest supplier | same |
| GDP 2024 | BD US$450.12 bn (per capita US$2,593.4); Brazil US$2.19 tn (per capita US$10,310.5) | `/brazil-bangladesh-chamber-of-commerce-industry-bbcci/` |
| Logistics | Chattogram→Santos about 35–42 days (about 34 days on the shortest route); there is no direct shipping line | export guides |
| Brazil tariffs | Average MFN about 12% (Mercosur CET) | `/brazil-customs-duties/` |
| Institutional | FBCCI–ApexBrasil MoU (2023); Brazil offered a draft umbrella MoU / PTA talks | posts 410, 344 |

---

## 13. Video catalogue

All videos are YouTube embeds through Elementor video widgets. There are **no self-hosted MP4s**: no `.mp4`, `.mov` or `.webm` in the media library or the HTML. No Facebook video is embedded. One Facebook video URL appears only as a text citation.

| # | YouTube ID | Title (oEmbed) | Channel | Embedded on |
|---|---|---|---|---|
| 1 | `5MlpxdHUHqs` | Future of Brazil-Bangladesh Trade Relations by President, BBCCI | Trade & Investment Bangladesh (TIB), @tib-bd | Home |
| 2 | `XnuwXSDGaVs` | Brazil-Bangladesh Trade Relations: An Untapped Goldmine, Vice President, BBCCI | TIB, @tib-bd | Home |
| 3 | `AhCawT3n2Uo` | **Made in Bangladesh Expo 2025 in Sao Paulo, Brazil** | Trade & Investment Bangladesh, @TradeInvestmentBangladesh | Home |
| 4 | `yEet013K4qs` | Shahriar Ahmed, President, Brazil Bangladesh Chamber of Commerce & Industry (BBCCI) | @TradeInvestmentBangladesh | Home |
| 5 | `mDVMcqUm_H8` | Mr. Md. Saiful Alam, Vice President, BBCCI | @TradeInvestmentBangladesh | Home |
| 6 | `Yy8khT4DCAU` | Speech from the Secretary General, BBCCI | @TradeInvestmentBangladesh | Home |
| 7 | `Wjbk4eZs3do` | Top 10 Brazilian Products Could be Imported to Bangladesh for Profitable Business | TIB, @tib-bd | Our Services |
| – | Facebook (citation link only) | facebook.com/TradeandInvestmentBD/videos/…/1522188155545341 ("Brazil's Import Market What Brazilian Buyers Want from Bangladesh") | T&IB Facebook | text link in `/top-5-brazilian-industries-for-bangladeshi-sme-investment-opportunities/` |

Watch URLs take the form `https://www.youtube.com/watch?v=<ID>`. Thumbnails are at `https://i.ytimg.com/vi/<ID>/hqdefault.jpg`. Note that the videos belong to T&IB channels, not to a BBCCI channel.

---

## 14. Downloadable documents

| Document | URL | Size | On site? | Content |
|---|---|---|---|---|
| Presentation for the Briefing Session (.pptx, 20 slides) | https://brazilbangladeshchamber.com/wp-content/uploads/2025/07/Presentation-for-the-Briefing-Session.pptx | 7,075,116 B | Yes, in the media library (attached to post 264) but **not linked from any page** | Expo 2025 briefing: intro, 10-step "how to participate", **4-day programme**, contact (incl. info@). Saved as `docs/2025-07_Presentation-for-the-Briefing-Session.pptx` with the text in `.txt`. |
| BGMEA circular "Participation in Made in Bangladesh Expo 2025" (PDF, 24 pp.) **EXTERNAL** | https://bgmea.com.bd/uploads/circulars/attachments/circular_attachment_BGMEA_Brazil_Fair__1738148853.pdf | 2,973,448 B | No (bgmea.com.bd) | BGMEA cover letter (28 Jan 2025), registration form, BBCCI invitation letter (ref BBCCI/Brazil Embassy/2025/003, signed by VP Md. Saiful Alam), BBCCI prospectus (about us, economic indicators, event details, objectives, focus areas, audience, features, outcomes, timeline, **fees, deadline**, team, contact). Saved in `docs/external/` with a `pdftotext` file. Several slides are flattened images and were read visually for this report. |
| PDFs hosted on the site | – | – | **None.** The 30+ PDF links in posts are third-party citations (WTO, World Bank, BEPZA, NBR, Dhaka Chamber…) and were not downloaded. | – |

There is no exhibitor manual, floor plan, brochure PDF, membership form or price list on the site.

---

## 15. Language, brand and identity

* **Language:**
  * The site is English only (`<html lang="en-US">`, og:locale en_US).
  * There are **two Bangla-language posts** (Nov 2025, about general economic trends), and many promo images are in Bangla.
  * There is **no Portuguese** content, **no language switcher** and no hreflang.
  * One post includes a "Sample buyer outreach email in Portuguese".
* **Logo:** there are two variants. **No SVG or vector logo exists** on the site; the largest file is a 1920×1920 JPG.
  * *Current* (since Apr 2024): a square dark-green field with a red circle and a navy circle overlapping a yellow diamond (a Brazil-flag diamond merged with the Bangladesh red disc), and the yellow wordmark "Brazil Bangladesh Chamber of Commerce & Industry (BBCCI)". Files: `logo/2024-04_BBCCI-Logo.jpg` (1920²), `2024-04_android-chrome-512x512-1.png`, `2024-04_cropped-BBCCI-Logo.jpg` (240², used in the header).
  * *Older* (Mar 2024): brighter green, larger circles, no wordmark. Files: `logo/2024-03_BBCCI-Logo.jpg` (1250²), `2024-03_cropped-BBCCI-Logo.jpg` (1248², **still used as og:image**), `ms-icon-310x310-1.png` (used in the Organization schema).
* **Brand colours** (sampled from the current logo; no brand guide exists):
  * Green **#009738**
  * Navy **#012269**
  * Red **#F42A40** (anti-aliased average #DD3140)
  * Yellow **#F8DF09**
  * The promos also use lime green and white.
  * The Elementor global kit is the **untouched default** (#6EC1E4 / #54595F / #7A7A7A / #61CE70). The theme accent is #5b4af9 (purple, a theme default). Neither reflects the brand.
* **Fonts:** Roboto and Roboto Slab (Elementor defaults) and Montserrat (theme). There is no brand typeface.
* **Favicon:** `wp-content/uploads/2024/04/cropped-android-chrome-512x512-1-{32x32,192x192,180x180}.png` (current logo).
* **Expo sub-brand:** the 2025 venue backdrop used "MADE IN BANGLADESH TRADE FAIR 2025" with a separate "BB" monogram (Brazil diamond plus a red/blue disc inside rounded "B" shapes, pastel teal/blue gradient). **This logo file is not on the site.** Request it from the client.

---

## 16. Asset library summary (`research-assets/bbcci/`)

* **Source:** all 108 media-library items, downloaded at **full-size originals** (unscaled `original_image` where WordPress had made a `-scaled` copy). Byte-identical re-uploads were de-duplicated, and the duplicates are recorded under `also_uploaded_as` in the manifest.
* **Result:** 81 unique files from the site, plus 3 EXTERNAL headshot crops and 2 EXTERNAL doc files. Total ≈216 MB.
* **Manifest:** `research-assets/bbcci/manifest.json` (87 entries). Fields: file, source_url, scaled_url, alt, caption, title, width, height, bytes, mime, upload_date, media_id, used_on, category, notes, also_uploaded_as.

| Folder | Files | Contents |
|---|---|---|
| `images/logo/` | 15 | Current and older logo variants, icons (no SVG) |
| `images/people/` | 3 | President, VP and SG headshots cropped from the EXTERNAL prospectus (low resolution, ~685–915 px). **There are no standalone headshots on the site.** |
| `images/expo-2025/` | 17 | 12 event photos from São Paulo (7008×4672 or 7008×3944) plus 3 Dhaka press-conference photos (6720×4480 / 1920×1280) and 2 expo posters (English early-bird; Bangla deadline extension) |
| `images/events/` | 23 | 7 undated BBCCI event slides (S-1…S-7, 1920×1080); 13 photos from the 8 Mar 2024 FBCCI–BBCCI meeting (2700×1800); 2 BBCCI–BGMEA group photos (May 2024); 1 group photo with the Ambassador (6000×4000) |
| `images/promo/` | 6 | Membership promos (Bangla and English), "Membership Month 2025" |
| `images/blog/` | 17 | Blog featured graphics, mostly AI-generated "Become a member" posters in 1254×1254 or 1920×1080, plus a trade chart |
| `images/misc/` | 2 | Stock photos (Pexels São Paulo skyline; a stock portrait), not BBCCI-owned |
| `docs/` | 2 (+external 2) | Briefing PPTX and its text; BGMEA circular PDF and its text |
| `videos/` | 0 | No self-hosted videos exist |

**Best hero-quality photos:**
* `expo-2025/2025-07_DSC07487.jpg` and `DSC07496.jpg`: BBCCI delegation in front of the "Welcome – Made in Bangladesh Trade Fair 2025" backdrop, 7008×4672.
* `expo-2025/2025-07_DSC07729-1.jpg`: group photo of about 40 participants in the São Paulo function room, 7008×3944.
* `expo-2025/2025-07_DSC08166.jpg` and `DSC08174.jpg`: Brazilian visitors at apparel stalls.
* `expo-2025/2025-07_DSC07671.jpg`, `DSC07697.jpg` and `DSC07928.jpg`: speaker portraits (President, Chief Guest, VP) at the podium.
* `events/2024-04_IMG_8646.jpg` and `IMG_8663.jpg`: Brazil FM Mauro Vieira at the 2024 Dhaka meeting.
* `expo-2025/2025-12_RTN_8412.jpg`: Brazilian Ambassador at the Dhaka press conference, 6720×4480.

**Caveats:**
* `DSC08161` has EXIF orientation 8 (it displays rotated in viewers that ignore EXIF).
* Expo photos show **meeting-room-scale stalls**, so they are not "large exhibition hall" imagery.
* Many site alt texts are SEO keywords unrelated to the image, so trust the captions and notes in the manifest instead.

### Full asset list

| Category | File | Size (px) | MB | Used on (#pages) | Title / caption / notes |
|---|---|---|---|---|---|
| logo | `images/logo/2024-04_cropped-android-chrome-512x512-1.png` | 512x512 | 0.0 | 100 | Favicon / site icon (32/180/192 px variants served). |
| logo | `images/logo/2024-04_android-chrome-512x512-1.png` | 512x512 | 0.0 | 0 | CURRENT logo 512px PNG (site icon source). |
| logo | `images/logo/2024-04_cropped-BBCCI-Logo.jpg` | 240x240 | 0.0 | 100 | CURRENT logo, 240px crop used in site header. |
| logo | `images/logo/2024-04_BBCCI-Logo.jpg` | 1920x1920 | 0.1 | 0 | CURRENT logo (Apr 2024): dark green field (#009738), red (#DD3140/#F42A40) and navy (#012269) circles on yellow (#F8DF09) diamond, yellow wordmark "Brazil Bangladesh Chamber of Commerce & Industry (BBCCI)". Largest logo  |
| logo | `images/logo/2024-04_cropped-cropped-Logo-512.jpg` | 512x512 | 0.0 | 0 | https://brazilbangladeshchamber.com/wp-content/uploads/2024/04/cropped-cropped-Logo-512.jpg |
| logo | `images/logo/2024-04_cropped-Logo-512.jpg` | 240x240 | 0.0 | 0 | Brazil Bangladesh Chamber of Commerce & Industry (BBCCI) |
| logo | `images/logo/2024-04_Logo-512.jpg` | 512x512 | 0.0 | 0 | Brazil Bangladesh Chamber of Commerce & Industry (BBCCI) |
| logo | `images/logo/2024-03_cropped-cropped-BBCCI-Logo-1.jpg` | 512x512 | 0.0 | 0 | https://brazilbangladeshchamber.com/wp-content/uploads/2024/03/cropped-cropped-BBCCI-Logo-1.jpg |
| logo | `images/logo/2024-03_cropped-cropped-BBCCI-Logo.jpg` | 240x240 | 0.0 | 0 | BBCCI Logo |
| logo | `images/logo/2024-03_cropped-apple-icon-120x120-1.png` | 120x120 | 0.0 | 0 | https://brazilbangladeshchamber.com/wp-content/uploads/2024/03/cropped-apple-icon-120×120-1.png |
| logo | `images/logo/2024-03_apple-icon-120x120-1.png` | 120x120 | 0.0 | 0 | apple-icon-120×120-1 |
| logo | `images/logo/2024-03_cropped-ms-icon-310x310-1.png` | 512x512 | 0.0 | 0 | https://brazilbangladeshchamber.com/wp-content/uploads/2024/03/cropped-ms-icon-310×310-1.png |
| logo | `images/logo/2024-03_ms-icon-310x310-1.png` | 310x310 | 0.0 | 100 | OLDER logo variant; used as Organization logo in Rank Math schema. |
| logo | `images/logo/2024-03_cropped-BBCCI-Logo.jpg` | 1248x1248 | 0.1 | 4 | OLDER logo variant (Mar 2024), cropped; used as og:image (1248x1248). |
| logo | `images/logo/2024-03_BBCCI-Logo.jpg` | 1250x1250 | 0.1 | 0 | OLDER logo variant (Mar 2024): bright green field, red + blue circles on yellow diamond, no wordmark. |
| people | `images/people/md-joynal-abdin-secretary-general.png` | 685x686 | 0.3 | 0 | NOT on brazilbangladeshchamber.com. Cropped from BBCCI Expo-2025 prospectus attached to BGMEA circular (28 Jan 2025). Low-res source (~600px circle); ask client for original headshots. |
| people | `images/people/md-saiful-alam-vice-president.png` | 685x686 | 0.3 | 0 | NOT on brazilbangladeshchamber.com. Cropped from BBCCI Expo-2025 prospectus attached to BGMEA circular (28 Jan 2025). Low-res source (~600px circle); ask client for original headshots. |
| people | `images/people/shahriar-ahmed-president.png` | 915x914 | 0.4 | 0 | NOT on brazilbangladeshchamber.com. Cropped from BBCCI Expo-2025 prospectus attached to BGMEA circular (28 Jan 2025). Low-res source (~600px circle); ask client for original headshots. |
| expo-2025 | `images/expo-2025/2026-05_1-46.jpg` | 1920x1280 | 0.2 | 1 | Dhaka pre-expo press conference / briefing for Made in Bangladesh Expo 2025, Grand Ball Room, Hotel Ascott Palace, Baridhara, Dhaka (banner: "Supported by the Brazilian Embassy in Dhaka"). Brazilian Ambassador speaking,  |
| expo-2025 | `images/expo-2025/2025-12_RTN_8412.jpg` | 6720x4480 | 7.8 | 2 | Same Dhaka pre-expo press conference (uploaded May 2025); Brazilian Ambassador speaking, VP and SG seated. |
| expo-2025 | `images/expo-2025/2025-07_BBCCI-1.jpg` | 1857x2000 | 0.7 | 2 | English promo poster:"Made in Bangladesh EXPO 2025, June 15-18, 2025 in Sao Paulo, Brazil"; "Early Bi[r]d Registration Before 31st January 2025 10% Discount"; +880 1553 676767. |
| expo-2025 | `images/expo-2025/2025-07_Made-in-Bangladesh-Expo-2025.jpg` | 1857x2000 | 0.4 | 0 | Bangla notice: registration deadline for Expo 2025 extended from 31 March 2025 to 30 April 2025; contact +880 1553 676767; Dhaka address. |
| expo-2025 | `images/expo-2025/2025-07_DSC08174.jpg` | 7008x4672 | 10.5 | 1 | Expo 2025: Mrs. Regina Nunes (caption). |
| expo-2025 | `images/expo-2025/2025-07_DSC08166.jpg` | 7008x4672 | 9.8 | 1 | Expo 2025: Mrs. Regina Nunes (caption). |
| expo-2025 | `images/expo-2025/2025-07_DSC08161.jpg` | 7008x4672 | 8.8 | 0 | Expo 2025: Mrs. Regina Nunes (caption). |
| expo-2025 | `images/expo-2025/2025-07_DSC08138.jpg` | 7008x4672 | 8.5 | 2 | Expo 2025: Mrs. Regina Nunes (caption). |
| expo-2025 | `images/expo-2025/2025-07_DSC07928.jpg` | 7008x4672 | 10.0 | 1 | Expo 2025: VP Md. Saiful Alam (alt). |
| expo-2025 | `images/expo-2025/2025-07_DSC07730.jpg` | 7008x3944 | 7.1 | 0 | Expo 2025: seated group photo incl. Mrs. Regina Nunes and BBCCI delegates. |
| expo-2025 | `images/expo-2025/2025-07_DSC07729-1.jpg` | 7008x3944 | 8.2 | 7 | Made in Bangladesh Expo 2025 in Sao Paulo, Brazil (+1 duplicate uploads) |
| expo-2025 | `images/expo-2025/2025-07_DSC07697.jpg` | 7008x4672 | 12.2 | 1 | Expo 2025: Chief Guest Dr. Taufiqul Islam, PhD (caption). |
| expo-2025 | `images/expo-2025/2025-07_DSC07671.jpg` | 7008x4672 | 9.9 | 1 | Expo 2025: President Shahriar Ahmed speaking (caption). |
| expo-2025 | `images/expo-2025/2025-07_DSC07660.jpg` | 7008x4672 | 13.2 | 1 | Expo 2025: SG Md. Joynal Abdin presenting (caption). |
| expo-2025 | `images/expo-2025/2025-07_DSC07487.jpg` | 7008x4672 | 8.8 | 7 | Expo 2025: 4 delegates in front of "Welcome - MADE IN BANGLADESH TRADE FAIR 2025" backdrop (expo sub-brand "BB" monogram). |
| expo-2025 | `images/expo-2025/2025-07_DSC07496.jpg` | 7008x4672 | 9.1 | 1 | Expo 2025: delegates in front of "Welcome - MADE IN BANGLADESH TRADE FAIR 2025" backdrop. |
| expo-2025 | `images/expo-2025/2025-05_RTN_8401.jpg` | 6720x4480 | 8.1 | 2 | Same Dhaka pre-expo press conference (uploaded May 2025). |
| events | `images/events/2025-07_1-34.jpg` | 6000x4000 | 8.5 | 3 | Group photo: VP Md. Saiful Alam (left), Brazilian Ambassador, a BBCCI leader, SG Md. Joynal Abdin (right), hotel venue; event not identified. |
| events | `images/events/2024-05_Image-2.jpg` | 4197x1800 | 4.3 | 1 | BBCCI & BGMEA leadership meeting (May 2024). |
| events | `images/events/2024-05_Image-1.jpg` | 3853x1800 | 4.2 | 0 | BBCCI & BGMEA leadership meeting (May 2024). |
| events | `images/events/2024-04_IMG_8628.jpg` | 2700x1800 | 4.0 | 1 | Brazilian Business Leader is speaking on the occasion. |
| events | `images/events/2024-04_IMG_8305.jpg` | 2700x1800 | 3.4 | 3 | 8 Apr 2024 seminar: President Shahriar Ahmed (title). |
| events | `images/events/2024-04_IMG_8638.jpg` | 2700x1800 | 4.7 | 1 | 8 Apr 2024 seminar: State Minister for Commerce Ahasanul Islam Titu (title). |
| events | `images/events/2024-04_IMG_8646.jpg` | 2700x1800 | 4.2 | 6 | 8 Apr 2024 FBCCI-BBCCI seminar, InterContinental Dhaka: Brazil FM Mauro Vieira (title). |
| events | `images/events/2024-04_IMG_8557.jpg` | 2700x1800 | 3.7 | 3 | President & Vice President of BBCCI are seen with the guests |
| events | `images/events/2024-04_IMG_8728.jpg` | 2700x1800 | 3.0 | 3 | Mr. Md. Saiful Alam, Vice President, BBCCI is seen along with Brazilian Business Leaders. |
| events | `images/events/2024-04_IMG_8515.jpg` | 2700x1800 | 2.9 | 2 | Mr. Shahriar Ahmed, President, BBCCI and Mr. Md. Saiful Alam, Vice President, BBCCI are seen along with other guests. |
| events | `images/events/2024-04_IMG_8501.jpg` | 2700x1800 | 3.8 | 2 | Mr. Shahriar Ahmed, President, BBCCI and Mr. Md. Saiful Alam, Vice President, BBCCI are seen along with other guests. |
| events | `images/events/2024-04_IMG_8737.jpg` | 2700x1800 | 3.4 | 4 | 8 Mar 2024 FBCCI-BBCCI meeting (InterContinental Dhaka): Brazilian Ambassador Paulo Fernando Dias Feres with BBCCI President & VP (caption). |
| events | `images/events/2024-04_IMG_8563.jpg` | 2700x1800 | 3.1 | 3 | Brazilian Business Leader with the President & Vice President of Brazil Bangladesh Chamber of Commerce & Industry (BBCCI) |
| events | `images/events/2024-04_IMG_8746.jpg` | 2700x1800 | 3.2 | 5 | 8 Mar 2024 meeting: Ambassador Paulo Fernando Dias Feres, President Shahriar Ahmed, VP Md. Saiful Alam, SG Md. Joynal Abdin (caption). |
| events | `images/events/2024-04_IMG_8663.jpg` | 2700x1800 | 5.0 | 2 | Honorable Foreign Minister of Brazil, State Minister for Commerce, Government of Bangladesh and President FBCCI are seen. |
| events | `images/events/2024-04_IMG_8695.jpg` | 2700x1800 | 3.3 | 4 | Honorable Foreign Minister of Brazil Mr. Mauro Vieira and other Guests |
| events | `images/events/2024-03_S-7.jpg` | 1920x1080 | 0.4 | 0 | Event organized by BBCCI |
| events | `images/events/2024-03_S-4.jpg` | 1920x1080 | 0.7 | 1 | FBCCI President Md. Jashim Uddin (undated BBCCI event). |
| events | `images/events/2024-03_S-5-1.jpg` | 1920x1080 | 0.6 | 1 | Commerce Minister Tipu Munshi MP (undated BBCCI event). (+1 duplicate uploads) |
| events | `images/events/2024-03_S-6.jpg` | 1920x1080 | 0.5 | 0 | Renowned Businessmen are seen in an event of BBCCI |
| events | `images/events/2024-03_S-2.jpg` | 1920x1080 | 0.4 | 0 | Honorable Commerce Minister, Ambassador of Brazil to Bangladesh, President, FBCCI are seen in an event of BBCCI |
| events | `images/events/2024-03_S-3.jpg` | 1920x1080 | 0.4 | 0 | Title/alt say "Mr. Md. Shahriar Alam, President" but caption says "Mr. Shahriar Ahmed, President" (name inconsistency on site). |
| events | `images/events/2024-03_S-1.jpg` | 1920x1080 | 0.3 | 3 | Brazilian Ambassador to Bangladesh, captioned "Chief Patron of BBCCI" (undated BBCCI event, pre-Apr 2024). |
| promo | `images/promo/2026-05_Membership-Circular-of-BBCCI.jpg` | 1536x1024 | 0.4 | 12 | Economic Landscape of Brazil and Opportunities for Bangladesh (+5 duplicate uploads) |
| promo | `images/promo/2026-04_Become-a-member-of-BBCCI.jpg` | 1536x1024 | 0.5 | 3 | Export Opportunities in Brazil (+2 duplicate uploads) |
| promo | `images/promo/2026-03_BBCCI-Membership.jpg` | 940x788 | 0.2 | 3 | Investment Opportunities in Bangladesh & Brazil for Each Other (+2 duplicate uploads) |
| promo | `images/promo/2026-01_Become-a-member-of-BBCCI-2.png` | 1536x1024 | 0.7 | 14 | Importing Sugar from Brazil to Bangladesh: A Step-by-Step Guide (+2 duplicate uploads) |
| promo | `images/promo/2025-11_BBCCI-Membership-Ads.jpg` | 3375x3375 | 2.6 | 12 | Brazil Bangladesh Chamber of Commerce & Industry (BBCCI) |
| promo | `images/promo/2025-08_BBCCI-1.jpg` | 1410x1182 | 0.3 | 3 | Promo "Membership Month 2025, July 15 - August 14, 2025" - benefits list; phone shown +880 19926 77117 (different from main +880 1553 676767). Also uploaded as "BBCCI-Membership-Month-2025.jpg". (+1 duplicate uploads) |
| blog | `images/blog/2026-10_BBCCI_-Bridging-Brazil-and-Bangladesh.jpg` | 1254x1254 | 0.5 | 1 | How to Find Brazilian Buyers for Bangladeshi Garments, Textiles and Denim |
| blog | `images/blog/2026-09_BBCCI-LB-2.jpg` | 1254x1254 | 0.4 | 1 | How to Import from Brazil to Bangladesh? |
| blog | `images/blog/2026-09_BBCCI-LE-1-1-1.jpg` | 1254x1254 | 0.4 | 7 | Brazil Import Regulations for Bangladeshi Exporters (+2 duplicate uploads) |
| blog | `images/blog/2026-08_BBCCI.EE_.jpg` | 1254x1254 | 0.5 | 1 | Top 10 Bangladeshi Export Products Having Ample Demand in the Brazilian Market |
| blog | `images/blog/2026-08_BBCCI-1-1.jpg` | 1254x1254 | 0.5 | 5 | Top 10 Profitable Business Ideas Between Bangladesh and Brazil (+2 duplicate uploads) |
| blog | `images/blog/2026-08_BBCCI-1.jpg` | 1024x1024 | 0.3 | 8 | Trade Potentials between Bangladesh & Brazil (+1 duplicate uploads) |
| blog | `images/blog/2026-07_Brazil-Bangladesh-Chamber-of-Commerce-1.jpg` | 1254x1254 | 0.6 | 3 | How to Find Buyers in Brazil? (+2 duplicate uploads) |
| blog | `images/blog/2026-07_BBCCI-2.jpg` | 1254x1254 | 0.5 | 6 | How to Start Importing from Brazil to Bangladesh? (+1 duplicate uploads) |
| blog | `images/blog/2026-07_BBCCI.E-2.jpg` | 1254x1254 | 0.4 | 4 | How to Start Importing from Brazil to Bangladesh? |
| blog | `images/blog/2026-06_BBCCI.BB_.jpg` | 1254x1254 | 0.5 | 1 | BBCCI |
| blog | `images/blog/2026-05_BBCCI-B.jpg` | 1920x1080 | 0.5 | 3 | BBCCI |
| blog | `images/blog/2026-05_BBCCI-E.jpg` | 1920x1080 | 0.5 | 3 | Doing Business Between Bangladesh and Brazil: Trade, Investment & Market Opportunities |
| blog | `images/blog/2026-03_Yellow-Modern-How-To-Become-To-Designer-Youtube-Thumbnail.jpg` | 1280x720 | 0.2 | 2 | Business Opportunities in Brazil (+1 duplicate uploads) |
| blog | `images/blog/2026-02_BBCCI-Banner-1.jpg` | 800x533 | 0.1 | 8 | Bangladesh–Brazil Business Opportunities (+3 duplicate uploads) |
| blog | `images/blog/2026-01_Figure.jpg` | 560x364 | 0.0 | 1 | Chart: "Bangladesh-Brazil Bilateral Trade (USD million)" 2022-2024. |
| blog | `images/blog/2026-01_ChatGPT-Image-Jan-8-2026-09_14_38-PM.png` | 1536x1024 | 0.6 | 12 | Brazil Bangladesh Chamber of Commerce & Industry (BBCCI) |
| blog | `images/blog/2025-11_BBCCI-Banner.jpg` | 1280x720 | 0.2 | 16 | Latin American Markets for Bangladeshi Exporters |
| misc | `images/misc/2024-03_pexels-kaique-rocha-97906.jpg` | 5472x3648 | 1.7 | 0 | Stock photo (Pexels, Kaique Rocha) - Sao Paulo skyline; not BBCCI-owned. |
| misc | `images/misc/2024-03_image-1.png` | 1000x1000 | 0.4 | 0 | Stock portrait photo (man in white shirt), apparently a theme/demo leftover; not BBCCI content. (+1 duplicate uploads) |
| docs | `docs/2025-07_Presentation-for-the-Briefing-Session.pptx` | - | 7.1 | 0 | Presentation for the Briefing Session |
| docs | `docs/2025-07_Presentation-for-the-Briefing-Session.txt` | - | 0.0 | 0 | Extracted with zipfile/XML parsing (20 slides). |
| docs-external | `docs/external/BGMEA-circular-Brazil-Fair-1738148853.pdf` | - | 3.0 | 0 | EXTERNAL (bgmea.com.bd): BGMEA circular 28 Jan 2025 + registration form + BBCCI invitation letter + BBCCI Expo-2025 prospectus (24 pages). Holds stall prices, deadlines and bank details. |
| docs-external | `docs/external/BGMEA-circular-Brazil-Fair-1738148853.txt` | - | 0.0 | 0 | pdftotext extraction of the above (slides are partly flattened images; see report for content read visually). |

---

## 17. Quality assessment of the current site (what the new portal must beat)

1. **There is no expo product.** There is no expo page, dates block, venue map, exhibitor list, packages or prices, registration, payment, visa/hotel guidance or FAQ. Expo info is scattered across long blog posts, image posters (text inside images) and an unlinked PPTX.
2. **Contact information is weak.**
   * The Contact page has no phone, WhatsApp, form, map or office hours.
   * The main phone number exists only inside posts and images.
   * There is no Brazil presence.
   * There is no footer contact block and there are no social links.
3. **Content is outdated or inconsistent.**
   * "Members Profile" is a placeholder ("XYZ number of members").
   * The membership classes differ between the page and the posts.
   * The 2024 event date conflicts (backdrop 8 Mar vs post "April 8").
   * The President's name is misspelt in image metadata.
   * The 2026 tentative dates were never confirmed, and the newest post switches to 2027.
4. **The blog is SEO-heavy and of uneven quality.**
   * About 85 long AI-style articles (up to 7,000 words).
   * Duplicate posts: the sugar guide ×2; "Top 10 Brazilian Industries…" ×2; "Brazil Market Entry Support…" ×2; "How to Export…" ×3 variants.
   * Leftover citation markers ("[23] [24]") and `utm_source=chatgpt.com` links appear in 7 posts.
   * There are 492 tags, some with "#" prefixes.
5. **Accessibility and SEO hygiene.**
   * Image alt texts are stuffed with unrelated post titles. For example, a photo of Brazil's Foreign Minister has the alt "Brazil–MERCOSUR Trade Agreement…".
   * og:image is the old logo.
   * The Organization schema has no address or phone.
   * The author schema exposes an email address as the author name.
   * Unknown URLs 301 to home (a soft-404 risk).
6. **Privacy and security.**
   * `/wp-json/wp/v2/users` is public; the admin's display name is a Gmail address.
   * Comment forms are open everywhere (spam vector).
7. **Brand.** The site runs on a generic multipurpose theme with default Elementor colours and fonts, a theme-credit footer, and no vector logo. It has no visual relationship to the expo's own backdrop identity.
8. **Performance.**
   * HTML TTFB is about 1.2–2.8 s, and full HTML fetches take about 3–6 s.
   * Pages are about 115–220 KB of HTML before assets.
   * Heavy original photos (7–13 MB) are uploaded. The Airlift/"bv" optimiser defers content into `<template>` chunks, which means content depends on JavaScript.
   * A responsive viewport tag is present (mobile layout is theme-default and was not tested in a browser).
9. **Language.** English only, with no Portuguese for the Brazilian audience the expo targets. Only a little Bangla, and that is mostly inside images.
10. **No events calendar, no news about real activities after mid-2025, no media or press kit, no sponsor or partner section.**

---

## 18. Full page and post inventory (7 pages + 89 posts)

| # | Type | Published | Modified | Title | Category | Words | Summary |
|---|---|---|---|---|---|---|---|
| 1 | Page | 2024-03-10 | 2025-07-08 | [Home](https://brazilbangladeshchamber.com/) | - | 377 | Intro, mission, vision, 6 objectives, 2 captioned photos, "Made in Bangladesh Expo 2025 in Sao Paulo, Brazil" heading + 6 YouTube embeds, "Our Sweet Memories" carousel (13 slides). |
| 2 | Page | 2024-03-10 | 2025-06-04 | [About us](https://brazilbangladeshchamber.com/about-us/) | - | 798 | Same intro/mission/vision/objectives as Home, plus governance: 18-member Board, Executive Committee, 3 committees, role descriptions. No names apart from photo captions. |
| 3 | Page | 2024-03-10 | 2024-07-14 | [Our Services](https://brazilbangladeshchamber.com/our-services/) | - | 422 | Services: matchmaking, market intelligence, trade promotion, investment facilitation, advisory, networking & advocacy, training. 1 YouTube embed. |
| 4 | Page | 2024-03-10 | 2024-04-10 | [Membership](https://brazilbangladeshchamber.com/membership/) | - | 500 | Membership types (Corporate, Individual, Associate) and benefits 3.1-3.6. No fees and no application form. |
| 5 | Page | 2024-03-10 | 2024-04-01 | [Members Profile](https://brazilbangladeshchamber.com/members-profile/) | - | 78 | PLACEHOLDER: "We have XYZ number of members..." and 3 empty member templates (Company name, Address, Contact Person, Designation, Mobile, Email, Website). |
| 6 | Page | 2024-03-10 | 2025-06-04 | [Contact us](https://brazilbangladeshchamber.com/contact-us/) | - | 32 | Dhaka address and 3 role emails only. No phone, form or map. |
| 7 | Page | 2024-03-25 | 2024-05-03 | [Photo Gallery](https://brazilbangladeshchamber.com/photo-gallery/) | - | 0 | Gallery of 10 photos (2024 events), no captions shown; alt texts are SEO keywords. |
| 8 | Post | 2024-03-25 | 2024-03-25 | [BBCCI Events](https://brazilbangladeshchamber.com/bbcci-events/) | Events | 36 | EVENT photo post (undated). Captioned photos of Commerce Minister Tipu Munshi MP, FBCCI President Md. Jashim Uddin, and the Brazilian Ambassador (captioned 'Chief Patron of BBCCI') speaking at a BBCCI event. No date, venue or text. |
| 9 | Post | 2024-04-10 | 2024-04-10 | [Bangladesh and Brazil Explore Trade Opportunities](https://brazilbangladeshchamber.com/bangladesh-and-brazil-explore-trade-opportunities/) | Events, News | 466 | EVENT report: seminar and B2B matchmaking at Hotel InterContinental Dhaka, dated "April 8, 2024" in the text but "08 March 2024" on the photographed backdrop, co-hosted by FBCCI and BBCCI, with Brazil's Foreign Minister Mauro Vieira, State Minister for Commerce Ahasanul Islam Titu and FBCCI President Mahbubul Alam. Focus sectors: pharma, healthcare, jute, RMG, food and agriculture; calls for an FTA/PTA. |
| 10 | Post | 2025-07-06 | 2025-07-06 | [Made in Bangladesh Expo 2025 Impact](https://brazilbangladeshchamber.com/made-in-bangladesh-expo-2025-impact/) | Blog, Events, News | 2012 | EXPO 2025 impact article by the Secretary General. Confirms 15-18 June 2025 in Sao Paulo, organised by BBCCI. Quotes the President, VP, SG, Ambassador Paulo Feres and Brazilian textile importer Rafael dos Santos. Claimed outcomes: a pharma distribution MoU and a proposed jute-packaging JV. |
| 11 | Post | 2025-07-26 | 2025-07-26 | [Can Latin America Be Bangladesh’s Answer to US Tariff Hikes?](https://brazilbangladeshchamber.com/can-latin-america-be-bangladeshs-answer-to-us-tariff-hikes/) | Blog | 4640 | Long analysis of the 2025 US reciprocal tariffs, arguing Latin America is an alternative market for Bangladesh. Notes that BBCCI promoted the 'Made in Bangladesh Expo 2025' and talked to Brazilian private-sector and municipal authorities. |
| 12 | Post | 2025-08-09 | 2025-08-09 | [Untapped Brazilian Consumer Trends for Bangladeshi Exporters](https://brazilbangladeshchamber.com/untapped-brazilian-consumer-trends-for-bangladeshi-exporters/) | Blog | 1456 | Brazilian consumer trends (about 213 million people, e-commerce, conscious consumption, wellness) and openings for Bangladeshi exporters. |
| 13 | Post | 2025-11-18 | 2025-11-18 | [Functions of a Bilateral Chamber of Commerce](https://brazilbangladeshchamber.com/functions-of-a-bilateral-chamber-of-commerce/) | Blog | 2215 | Explains what bilateral chambers do, using BBCCI as an illustrative case (advocacy for the 'Made in Bangladesh Exhibition 2025', press conferences). |
| 14 | Post | 2025-11-19 | 2025-11-19 | [Opportunities in Brazil–Bangladesh Trade: A Decade-Long Analysis](https://brazilbangladeshchamber.com/opportunities-in-brazil-bangladesh-trade-a-decade-long-analysis/) | Blog | 5917 | Decade-long (2011-2025) analysis of Brazil-Bangladesh trade, with export, import and JV prospects and a bibliography. |
| 15 | Post | 2025-11-26 | 2025-11-26 | [প্রযুক্তি, ব্যবসা, ও বৈশ্বিক প্রবণতা ২০২৬](https://brazilbangladeshchamber.com/%e0%a6%aa%e0%a7%8d%e0%a6%b0%e0%a6%af%e0%a7%81%e0%a6%95%e0%a7%8d%e0%a6%a4%e0%a6%bf-%e0%a6%ac%e0%a7%8d%e0%a6%af%e0%a6%ac%e0%a6%b8%e0%a6%be-%e0%a6%93-%e0%a6%ac%e0%a7%88%e0%a6%b6%e0%a7%8d%e0%a6%ac/) | Blog | 1584 | Bangla-language article on technology, business and global trends for 2026 (AI, net zero, blockchain, demographics). Not Brazil-specific. |
| 16 | Post | 2025-11-28 | 2025-11-28 | [বাংলাদেশের রপ্তানি বহুমুখীকরণ ২০২৫-২০৩০: ৫টি উচ্চ-প্রবৃদ্ধি সম্পন্ন লাভজনক পণ্য ও কৌশলগত বিনিয়োগ বিশ্লেষণ](https://brazilbangladeshchamber.com/%e0%a6%ac%e0%a6%be%e0%a6%82%e0%a6%b2%e0%a6%be%e0%a6%a6%e0%a7%87%e0%a6%b6%e0%a7%87%e0%a6%b0-%e0%a6%b0%e0%a6%aa%e0%a7%8d%e0%a6%a4%e0%a6%be%e0%a6%a8%e0%a6%bf-%e0%a6%ac%e0%a6%b9%e0%a7%81%e0%a6%ae%e0%a7%81/) | Blog | 3770 | Bangla-language article on Bangladesh export diversification 2025-2030: five high-growth products and an investment analysis. |
| 17 | Post | 2025-12-05 | 2025-12-05 | [Business Opportunities in Brazil for Bangladeshi Businesses](https://brazilbangladeshchamber.com/business-opportunities-in-brazil-for-bangladeshi-businesses/) | Blog | 4781 | Business opportunities in Brazil for Bangladeshi firms (export, import, tourism, investment), and the roles of BBCCI and the two embassies. |
| 18 | Post | 2025-12-08 | 2025-12-08 | [Trade & Investment Opportunities between Bangladesh & Brazil](https://brazilbangladeshchamber.com/trade-investment-opportunities-between-bangladesh-brazil/) | Blog | 2037 | Item-wise trade and investment opportunities both ways, with barriers and recommendations. Brazil GDP about USD 2.18 tn and Bangladesh about USD 450 bn (2024). |
| 19 | Post | 2025-12-11 | 2025-12-11 | [How to Export from Bangladesh to Brazil in 2026: A Step-by-Step Guide for Bangladeshi Exporters](https://brazilbangladeshchamber.com/how-to-export-from-bangladesh-to-brazil-in-2026-a-step-by-step-guide-for-bangladeshi-exporters/) | Blog | 1720 | Step-by-step export guide for 2026: HS/NCM codes, ANVISA/MAPA/INMETRO, Incoterms, 35-42 days of sea transit. Exports were USD 187 m in FY2024-25 (+26%). |
| 20 | Post | 2025-12-12 | 2025-12-12 | [Top 10 Most Profitable Products Bangladesh Can Export to Brazil](https://brazilbangladeshchamber.com/top-10-most-profitable-products-bangladesh-can-export-to-brazil/) | Blog | 1985 | Top 10 most profitable Bangladeshi products for Brazil (RMG, home textiles, jute, leather, footwear, seafood and more). |
| 21 | Post | 2025-12-16 | 2025-12-16 | [Brazil’s Import Market: What Brazilian Buyers Want From Bangladesh](https://brazilbangladeshchamber.com/brazils-import-market-what-brazilian-buyers-want-from-bangladesh/) | Blog | 4418 | Brazil's import market (USD 252.7 bn in 2023, about USD 278 bn in 2024) and what Brazilian buyers want from Bangladesh. |
| 22 | Post | 2025-12-21 | 2025-12-21 | [Brazil–Bangladesh Trade Agreements: Current State and Evolution](https://brazilbangladeshchamber.com/brazil-bangladesh-trade-agreements-current-state-and-evolution/) | Blog | 3722 | Trade agreements: diplomatic relations since 1972, the MERCOSUR context, and a proposed umbrella MoU/PTA. |
| 23 | Post | 2025-12-23 | 2025-12-23 | [Market Entry Strategies for Bangladeshi SMEs in Brazil](https://brazilbangladeshchamber.com/market-entry-strategies-for-bangladeshi-smes-in-brazil/) | Blog | 2011 | Market-entry strategies for Bangladeshi SMEs in Brazil (company formation, CNPJ, tax regime, SISCOMEX, distribution). |
| 24 | Post | 2025-12-25 | 2025-12-25 | [Top 5 Brazilian Industries for Bangladeshi SME Investment Opportunities](https://brazilbangladeshchamber.com/top-5-brazilian-industries-for-bangladeshi-sme-investment-opportunities/) | Blog | 6755 | Top 5 Brazilian industries for Bangladeshi SME investment (textiles, pharma, agribusiness, IT, renewables). |
| 25 | Post | 2025-12-27 | 2025-12-27 | [Case Study on the Made in Bangladesh Expo 2025, São Paulo, Brazil](https://brazilbangladeshchamber.com/case-study-on-the-made-in-bangladesh-expo-2025-sao-paulo-brazil/) | Blog | 939 | EXPO 2025 case study. Venue 'Novotel / Expo Norte', dates 15-18 June 2025, 'one public-facing event page referenced 20 exhibitors'. Covers sectors (RMG, jute, pharma, leather, home textiles) and outcomes. |
| 26 | Post | 2025-12-27 | 2025-12-27 | [Brazil’s Consumer Trends in 2026: What Every Bangladeshi Exporter Should Know](https://brazilbangladeshchamber.com/brazils-consumer-trends-in-2026-what-every-bangladeshi-exporter-should-know/) | Blog | 1679 | Brazil consumer trends for 2026 (Pix, social commerce, value buying) and how exporters should adapt. |
| 27 | Post | 2025-12-29 | 2025-12-29 | [Brazil–Bangladesh Trade Overview](https://brazilbangladeshchamber.com/brazil-bangladesh-trade-overview/) | Blog | 1898 | Brazil-Bangladesh trade overview, Brazil's 2025 import regulations, customs clearance for sea shipments, and penalties. |
| 28 | Post | 2026-01-02 | 2026-01-02 | [Brazil–MERCOSUR Trade Agreement: Opportunities and Challenges for Bangladesh Exports](https://brazilbangladeshchamber.com/brazil-mercosur-trade-agreement-opportunities-and-challenges-for-bangladesh-exports/) | Blog | 956 | Brazil-MERCOSUR trade agreement: opportunities and challenges for Bangladeshi exports. |
| 29 | Post | 2026-01-04 | 2026-01-04 | [Brazil–Bangladesh business matchmaking services to find partners and distributors](https://brazilbangladeshchamber.com/brazil-bangladesh-business-matchmaking-services-to-find-partners-and-distributors/) | Blog | 1660 | Business matchmaking services to find Brazilian partners and distributors, plus a due-diligence checklist. |
| 30 | Post | 2026-01-05 | 2026-01-05 | [Brazil imports taxes & duties calculator for Bangladeshi products: how to estimate landed cost (step-by-step)](https://brazilbangladeshchamber.com/brazil-imports-taxes-duties-calculator-for-bangladeshi-products-how-to-estimate-landed-cost-step-by-step/) | Blog | 1627 | Method for estimating the landed cost of Bangladeshi goods in Brazil (Brazil import taxes and duties calculator). |
| 31 | Post | 2026-01-06 | 2026-01-06 | [Step-by-Step Guide to Exporting from Bangladesh to Brazil in 2026 (Process, Documents, Costs, Timelines)](https://brazilbangladeshchamber.com/step-by-step-guide-to-exporting-from-bangladesh-to-brazil-in-2026-process-documents-costs-timelines/) | Blog | 1582 | Step-by-step 2026 export guide (process, documents, costs, timelines). |
| 32 | Post | 2026-01-08 | 2026-01-08 | [Top 10 Brazilian Industries That Need Bangladeshi Products Today](https://brazilbangladeshchamber.com/top-10-brazilian-industries-that-need-bangladeshi-products-today/) | Blog | 1536 | Top 10 Brazilian industries that need Bangladeshi products (first version; republished on 25 Jul 2026 under the same title). |
| 33 | Post | 2026-01-10 | 2026-01-10 | [How BBCCI Helps Bangladeshi SMEs Enter the Brazilian Market?](https://brazilbangladeshchamber.com/how-bbcci-helps-bangladeshi-smes-enter-the-brazilian-market/) | Blog | 1620 | How BBCCI helps Bangladeshi SMEs enter Brazil (matchmaking, export readiness, compliance navigation). |
| 34 | Post | 2026-01-13 | 2026-01-13 | [Brazil–Bangladesh Trade Growth Forecast: What to Expect by 2030](https://brazilbangladeshchamber.com/brazil-bangladesh-trade-growth-forecast-what-to-expect-by-2030/) | Blog | 1519 | Brazil-Bangladesh trade growth forecast to 2030, with three scenarios. |
| 35 | Post | 2026-01-13 | 2026-01-13 | [Bangladesh Trade Shows](https://brazilbangladeshchamber.com/bangladesh-trade-shows/) | Blog | 1969 | Top 10 trade shows in Bangladesh and how buyers and exhibitors should use them. |
| 36 | Post | 2026-01-14 | 2026-01-14 | [Bangladesh Exports to Brazil](https://brazilbangladeshchamber.com/bangladesh-exports-to-brazil/) | Blog | 5564 | Bangladesh exports to Brazil: USD 187 m in FY2024-25, up 26% from USD 147 m; USD 109 m in FY2021-22. Top products, challenges and recommendations. |
| 37 | Post | 2026-01-15 | 2026-01-15 | [Brazil Import Documentation Checklist for Bangladeshi Exporters](https://brazilbangladeshchamber.com/brazil-import-documentation-checklist-for-bangladeshi-exporters/) | Blog | 5030 | Brazil import documentation checklist for Bangladeshi exporters. Contact block: phone +8801553676767 and the SG email. |
| 38 | Post | 2026-01-16 | 2026-01-16 | [How to Find Distributors in Brazil?](https://brazilbangladeshchamber.com/how-to-find-distributors-in-brazil/) | Blog | 5406 | How to find distributors in Brazil: selection, contracts and legal points. |
| 39 | Post | 2026-01-18 | 2026-01-18 | [How to Find Business Partners in Brazil?](https://brazilbangladeshchamber.com/how-to-find-business-partners-in-brazil/) | Blog | 3449 | How to find business partners in Brazil. Mentions the 2023 FBCCI-ApexBrasil MoU. Contact block. |
| 40 | Post | 2026-01-21 | 2026-01-21 | [Trade Opportunities between Bangladesh and Brazil](https://brazilbangladeshchamber.com/trade-opportunities-between-bangladesh-and-brazil/) | Blog | 5909 | Trade opportunities (about USD 2.7 bn bilateral trade in 2024), sector by sector, with policy recommendations. Repeats the Expo 2025 MoU claims. |
| 41 | Post | 2026-01-23 | 2026-01-23 | [Top 10 Benefits of Joining a Bilateral Chamber of Commerce](https://brazilbangladeshchamber.com/top-10-benefits-of-joining-a-bilateral-chamber-of-commerce/) | Blog | 1132 | Top 10 benefits of joining a bilateral chamber of commerce. |
| 42 | Post | 2026-01-24 | 2026-01-24 | [Complete Guide to Exporting Bangladeshi Products to Brazil](https://brazilbangladeshchamber.com/complete-guide-to-exporting-bangladeshi-products-to-brazil/) | Blog | 7245 | Complete guide to exporting Bangladeshi products to Brazil, with a membership invitation and contact block. |
| 43 | Post | 2026-01-25 | 2026-01-25 | [Top Brazilian Markets Interested in Bangladeshi Exports](https://brazilbangladeshchamber.com/top-brazilian-markets-interested-in-bangladeshi-exports/) | Blog | 1728 | Top Brazilian regional markets for Bangladeshi exports (Sao Paulo, Rio, Minas Gerais, Parana and more). Contact block lists Phone/WhatsApp +8801553676767. |
| 44 | Post | 2026-01-26 | 2026-01-26 | [Top 10 Trade Events and Networking Opportunities in Brazil & Bangladesh](https://brazilbangladeshchamber.com/top-10-trade-events-and-networking-opportunities-in-brazil-bangladesh/) | Blog | 1209 | Top 10 trade events in Brazil and Bangladesh for Mar 2026-Mar 2027 (Expo Revestir, Agrishow, APAS, Futurecom, Fenatran, Dhaka shows). Does NOT list the Made in Bangladesh Expo. |
| 45 | Post | 2026-01-27 | 2026-01-27 | [Importing Sugar from Brazil to Bangladesh: A Step-by-Step Guide](https://brazilbangladeshchamber.com/importing-sugar-from-brazil-to-bangladesh-a-step-by-step-guide/) | Blog | 1553 | Step-by-step guide to importing sugar from Brazil to Bangladesh. |
| 46 | Post | 2026-01-31 | 2026-01-31 | [Importing Sugar from Brazil to Bangladesh: A Step-by-Step Guide](https://brazilbangladeshchamber.com/importing-sugar-from-brazil-to-bangladesh-a-step-by-step-guide-2/) | Blog | 1555 | Duplicate of the sugar-import guide (same content at a second URL). |
| 47 | Post | 2026-02-02 | 2026-02-02 | [Prospects of RMG Exports from Bangladesh to Brazil](https://brazilbangladeshchamber.com/prospects-of-rmg-exports-from-bangladesh-to-brazil/) | Blog | 1842 | Prospects for Bangladeshi RMG exports to Brazil. Contact block with the Dhaka address. |
| 48 | Post | 2026-02-10 | 2026-02-10 | [Brazil–Bangladesh Trade Relations](https://brazilbangladeshchamber.com/brazil-bangladesh-trade-relations/) | Blog | 1827 | Brazil-Bangladesh trade relations: diplomatic base, trade imbalance, agriculture and cotton corridors. |
| 49 | Post | 2026-02-12 | 2026-02-12 | [Brazil Customs Duties](https://brazilbangladeshchamber.com/brazil-customs-duties/) | Blog, News | 3326 | Brazil customs duties: NCM, Mercosur CET, MFN average about 12%, non-tariff measures, clearance. |
| 50 | Post | 2026-02-15 | 2026-02-15 | [Bangladesh–Brazil Business Opportunities](https://brazilbangladeshchamber.com/bangladesh-brazil-business-opportunities/) | Blog, Events, News | 1432 | Business opportunities (filed under Events). 2025 Comtrade figures: Brazil's exports to Bangladesh USD 2.72 bn, imports USD 281.79 m. EPB figures FY2024-25 USD 187 m. Brazil supplied 1.9 m bales of cotton (23%). Contact block. |
| 51 | Post | 2026-02-16 | 2026-02-16 | [Invest in Bangladesh from Brazil](https://brazilbangladeshchamber.com/invest-in-bangladesh-from-brazil/) | Blog, News | 3410 | Investing in Bangladesh from Brazil: macro outlook, One Stop Service, EPZs/EZs, top investment ideas. |
| 52 | Post | 2026-02-18 | 2026-02-18 | [Importing Agricultural Goods from Brazil](https://brazilbangladeshchamber.com/importing-agricultural-goods-from-brazil/) | Blog, News | 1419 | Top 10 agricultural goods Bangladesh can import profitably from Brazil, with BBCCI membership pitch. |
| 53 | Post | 2026-02-23 | 2026-02-23 | [RMG Exports to Brazil](https://brazilbangladeshchamber.com/rmg-exports-to-brazil/) | Blog, News | 1214 | RMG exports to Brazil: HS codes, top Brazilian buyer companies, duties and landed-cost calculation. |
| 54 | Post | 2026-02-27 | 2026-02-27 | [Exporting Jute Products to Brazil](https://brazilbangladeshchamber.com/exporting-jute-products-to-brazil/) | Blog, News | 2182 | Exporting jute products to Brazil: top imported jute items, competitors, step-by-step guide. |
| 55 | Post | 2026-02-28 | 2026-02-28 | [Exporting Pharmaceutical Products to Brazil](https://brazilbangladeshchamber.com/exporting-pharmaceutical-products-to-brazil/) | Blog, News | 1840 | Exporting pharmaceutical products to Brazil (ANVISA, taxes, top 25 Bangladeshi pharma exporters). |
| 56 | Post | 2026-03-03 | 2026-03-03 | [Brazilian Business Opportunities in Bangladesh](https://brazilbangladeshchamber.com/brazilian-business-opportunities-in-bangladesh/) | Blog, News | 2295 | Business opportunities in Bangladesh for Brazilian companies (imports, exports, investment). |
| 57 | Post | 2026-03-04 | 2026-03-04 | [Business Matchmaking for Brazilian Businesses in Bangladesh](https://brazilbangladeshchamber.com/business-matchmaking-for-brazilian-businesses-in-bangladesh/) | Blog, News | 1617 | Business matchmaking for Brazilian businesses in Bangladesh: BBCCI's matchmaking services. |
| 58 | Post | 2026-03-06 | 2026-03-06 | [Prior Preparations to Enter into Brazilian Market](https://brazilbangladeshchamber.com/prior-preparations-to-enter-into-brazilian-market/) | Blog, News | 3585 | Prior preparations to enter the Brazilian market (ERC, certificate of origin, banking/EXP, Brazilian importer registration). |
| 59 | Post | 2026-03-08 | 2026-03-08 | [Business Opportunities in Brazil](https://brazilbangladeshchamber.com/business-opportunities-in-brazil/) | Blog, News | 3150 | Top 10 business opportunities in Brazil for Bangladeshi exporters and importers. |
| 60 | Post | 2026-03-10 | 2026-03-10 | [Complementarity of Export Items of Bangladesh and Brazil](https://brazilbangladeshchamber.com/complementarity-of-export-items-of-bangladesh-and-brazil/) | Blog, News | 3016 | Complementarity of Bangladesh's and Brazil's export baskets, and why they are not competitors. |
| 61 | Post | 2026-03-13 | 2026-03-13 | [Brazil Bangladesh Chamber of Commerce & Industry (BBCCI)](https://brazilbangladeshchamber.com/bbcci/) | Blog, News | 2175 | BBCCI corporate profile: membership classes (Life, Corporate, General, Associate), governance (18-member board, executive committee, three committees), leadership and contacts. |
| 62 | Post | 2026-03-17 | 2026-03-17 | [Brazil Market Entry Support for Bangladeshi Exporters](https://brazilbangladeshchamber.com/brazil-market-entry-support-for-bangladeshi-exporters/) | Blog, News | 3350 | Brazil market entry support for Bangladeshi exporters (version 1). |
| 63 | Post | 2026-03-20 | 2026-03-20 | [Bangladesh–Brazil Trade Opportunities](https://brazilbangladeshchamber.com/bangladesh-brazil-trade-opportunities/) | Blog, News | 4254 | Trade data. FY2023-24: exports USD 156.19 m, imports USD 2,661.76 m. CY2024: exports USD 242.40 m, imports USD 2,484.04 m. Includes a proposed BBCCI action roadmap. |
| 64 | Post | 2026-03-22 | 2026-03-22 | [Bangladesh–Brazil Business Matchmaking](https://brazilbangladeshchamber.com/bangladesh-brazil-business-matchmaking/) | Blog, News | 2272 | Bangladesh-Brazil business matchmaking: services and why to join. Full contact block including WhatsApp +8801553676767. |
| 65 | Post | 2026-03-24 | 2026-03-24 | [Bangladesh to Brazil Trade Mission](https://brazilbangladeshchamber.com/bangladesh-to-brazil-trade-mission/) | Blog, News | 2765 | Guide to Bangladesh-to-Brazil trade missions, with a section on 'Made in Bangladesh Expo 2025 and beyond'. |
| 66 | Post | 2026-03-26 | 2026-03-26 | [Past, Present and Future of Bangladesh’s Export to Brazil](https://brazilbangladeshchamber.com/past-present-and-future-of-bangladeshs-export-to-brazil/) | Blog, News | 2721 | Past, present and future of Bangladesh's exports to Brazil. |
| 67 | Post | 2026-03-28 | 2026-03-28 | [Brazil Market Entry Support for Bangladeshi Exporters](https://brazilbangladeshchamber.com/brazil-market-entry-support-for-bangladeshi-exporters-2/) | Blog, News | 3034 | Brazil market entry support (version 2), presenting BBCCI as a 'single window'. Contact block. |
| 68 | Post | 2026-03-31 | 2026-03-31 | [Investment Opportunities in Bangladesh & Brazil for Each Other](https://brazilbangladeshchamber.com/investment-opportunities-in-bangladesh-brazil-for-each-other/) | Blog, News | 2856 | Investment opportunities in Bangladesh and Brazil for each other (top 10 each way, JV avenues). |
| 69 | Post | 2026-04-02 | 2026-04-02 | [Benefits of Joining a Bilateral Chamber of Commerce & Industry](https://brazilbangladeshchamber.com/benefits-of-joining-a-bilateral-chamber-of-commerce-industry/) | Blog, News | 3046 | Benefits of joining a bilateral chamber of commerce and industry. |
| 70 | Post | 2026-04-05 | 2026-04-05 | [To Explore Latin American Markets](https://brazilbangladeshchamber.com/to-explore-latin-american-markets/) | Blog, News | 2689 | Exploring Latin American markets: top export products and the role of BBCCI. |
| 71 | Post | 2026-04-06 | 2026-04-06 | [Brazil Bangladesh Chamber of Commerce & Industry (BBCCI)](https://brazilbangladeshchamber.com/brazil-bangladesh-chamber-of-commerce-industry-bbcci/) | Blog, News | 2943 | BBCCI profile citing its 'introductory deck'. Milestones: Expo 2025, a Brazilian business delegation visit with Brazil's FM, networking events and press conferences, and outreach for strategic partners for the 'Made in Bangladesh Expo 2026'. |
| 72 | Post | 2026-04-14 | 2026-04-14 | [Export Opportunities in Brazil](https://brazilbangladeshchamber.com/export-opportunities-in-brazil/) | Blog, News | 3620 | Export opportunities in Brazil: top 10 Bangladeshi products and services. |
| 73 | Post | 2026-04-19 | 2026-04-19 | [Latin American Markets for Bangladeshi Exporters](https://brazilbangladeshchamber.com/latin-american-markets-for-bangladeshi-exporters/) | Blog, News | 1215 | Top 10 Latin American markets for Bangladeshi exporters. |
| 74 | Post | 2026-05-04 | 2026-05-04 | [Economic Landscape of Brazil and Opportunities for Bangladesh](https://brazilbangladeshchamber.com/economic-landscape-of-brazil-and-opportunities-for-bangladesh/) | Blog, News | 1609 | Economic landscape of Brazil and opportunities for Bangladesh. |
| 75 | Post | 2026-05-07 | 2026-05-07 | [Bangladesh’s Export Potentials in Brazilian Market](https://brazilbangladeshchamber.com/bangladeshs-export-potentials-in-brazilian-market/) | Blog, News | 2923 | Bangladesh's export potential in the Brazilian market. |
| 76 | Post | 2026-05-10 | 2026-05-10 | [Bangladesh–Brazil Trade Relations: Opportunities and Challenges](https://brazilbangladeshchamber.com/bangladesh-brazil-trade-relations-opportunities-and-challenges/) | Blog, News | 2032 | Bangladesh-Brazil trade relations: opportunities and challenges. |
| 77 | Post | 2026-05-16 | 2026-05-16 | [Made in Bangladesh Expo in São Paulo, Brazil](https://brazilbangladeshchamber.com/made-in-bangladesh-expo-in-sao-paulo-brazil/) | Blog, News | 2985 | KEY EXPO POST. 2025 recap: 15-18 June 2025 at 'Novotel Center Norte and Expo Norte facilities', Sao Paulo. Announces the 2026 edition as the second edition, 'tentatively scheduled between November 20 and November 30, 2026 for a three-day program', with final dates not yet set. Includes an invitation to participate. |
| 78 | Post | 2026-05-26 | 2026-05-26 | [Doing Business Between Bangladesh and Brazil: Trade, Investment & Market Opportunities](https://brazilbangladeshchamber.com/doing-business-between-bangladesh-and-brazil-trade-investment-market-opportunities/) | Blog, News | 2418 | Doing business between Bangladesh and Brazil: trade, investment and market opportunities. |
| 79 | Post | 2026-06-01 | 2026-06-01 | [Top 10 Bangladeshi Export Items Having Import Demands in Brazil](https://brazilbangladeshchamber.com/top-10-bangladeshi-export-items-having-import-demands-in-brazil/) | Blog, News | 1863 | Top 10 Bangladeshi export items with import demand in Brazil. |
| 80 | Post | 2026-06-06 | 2026-06-06 | [The Future of Bangladesh–Brazil Economic Partnership](https://brazilbangladeshchamber.com/the-future-of-bangladesh-brazil-economic-partnership/) | Blog, News | 1969 | The future of the Bangladesh-Brazil economic partnership. |
| 81 | Post | 2026-06-30 | 2026-06-30 | [Profitable Trade Opportunities Between Bangladesh and Brazil](https://brazilbangladeshchamber.com/profitable-trade-opportunities-between-bangladesh-and-brazil/) | Blog, News | 3256 | Profitable trade opportunities in both directions. |
| 82 | Post | 2026-07-04 | 2026-07-04 | [Brazil Market Entry Guide for Bangladeshi Companies](https://brazilbangladeshchamber.com/brazil-market-entry-guide-for-bangladeshi-companies/) | Blog, News | 3557 | Brazil market entry guide for Bangladeshi companies (etiquette, logistics, trade fairs, buyers). |
| 83 | Post | 2026-07-08 | 2026-07-08 | [How to Start Importing from Brazil to Bangladesh?](https://brazilbangladeshchamber.com/how-to-start-importing-from-brazil-to-bangladesh/) | Blog, News | 2928 | How to start importing from Brazil (cotton and coffee examples). Refers to 'the upcoming Made in Bangladesh Expo 2026 in Sao Paulo'. |
| 84 | Post | 2026-07-16 | 2026-07-16 | [How to Find Buyers in Brazil?](https://brazilbangladeshchamber.com/how-to-find-buyers-in-brazil/) | Blog, News | 1698 | How to find buyers in Brazil (LinkedIn, trade fairs, BBCCI, directories). |
| 85 | Post | 2026-07-25 | 2026-07-25 | [Top 10 Brazilian Industries That Need Bangladeshi Products Today](https://brazilbangladeshchamber.com/top-10-brazilian-industries-that-need-bangladeshi-products-today-2/) | Blog, News | 3711 | Top 10 Brazilian industries that need Bangladeshi products (second version, same title as the 8 Jan 2026 post). |
| 86 | Post | 2026-07-28 | 2026-07-28 | [How to Export from Bangladesh to Brazil?](https://brazilbangladeshchamber.com/how-to-export-from-bangladesh-to-brazil/) | Blog, News | 1705 | How to export from Bangladesh to Brazil (short step list). |
| 87 | Post | 2026-08-01 | 2026-08-01 | [Top 10 Export Products from Bangladesh to Brazil and Brazil to Bangladesh](https://brazilbangladeshchamber.com/top-10-export-products-from-bangladesh-to-brazil-and-brazil-to-bangladesh/) | Blog, News | 6016 | Top 10 export products from Bangladesh to Brazil and from Brazil to Bangladesh. |
| 88 | Post | 2026-08-05 | 2026-08-05 | [Trade Potentials between Bangladesh & Brazil](https://brazilbangladeshchamber.com/trade-potentials-between-bangladesh-brazil/) | Blog, News | 6750 | Trade potentials between Bangladesh and Brazil (long piece, promotes BBCCI and T&IB services). |
| 89 | Post | 2026-08-08 | 2026-08-08 | [Top 10 Profitable Business Ideas Between Bangladesh and Brazil](https://brazilbangladeshchamber.com/top-10-profitable-business-ideas-between-bangladesh-and-brazil/) | Blog, News | 2979 | Top 10 profitable business ideas between Bangladesh and Brazil. |
| 90 | Post | 2026-08-22 | 2026-08-22 | [How to Export from Bangladesh to Brazil](https://brazilbangladeshchamber.com/how-to-export-from-bangladesh-to-brazil-2/) | Blog, News | 3727 | How to export from Bangladesh to Brazil (long, 3.7k-word version). |
| 91 | Post | 2026-08-26 | 2026-08-26 | [Top 10 Bangladeshi Export Products Having Ample Demand in the Brazilian Market](https://brazilbangladeshchamber.com/top-10-bangladeshi-export-products-having-ample-demand-in-the-brazilian-market/) | Blog, News | 4932 | Top 10 Bangladeshi export products in demand in Brazil (exports nearly USD 190 m a year). |
| 92 | Post | 2026-09-06 | 2026-09-06 | [How to Import Coffee from Brazil to Bangladesh?](https://brazilbangladeshchamber.com/how-to-import-coffee-from-brazil-to-bangladesh/) | Blog, News | 3489 | How to import coffee from Brazil to Bangladesh. |
| 93 | Post | 2026-09-08 | 2026-09-08 | [Pharmaceutical Export Opportunities from Bangladesh to Brazil](https://brazilbangladeshchamber.com/pharmaceutical-export-opportunities-bangladesh-to-brazil/) | Blog, News | 2824 | Pharmaceutical export opportunities: an ANVISA GMP step-by-step guide. |
| 94 | Post | 2026-09-12 | 2026-09-12 | [Brazil Import Regulations for Bangladeshi Exporters](https://brazilbangladeshchamber.com/brazil-import-regulations-for-bangladeshi-exporters/) | Blog, News | 3338 | Brazil import regulations for Bangladeshi exporters (NCM, LI/LPCO, Anvisa/MAPA/Inmetro, labelling). |
| 95 | Post | 2026-09-19 | 2026-09-19 | [How to Import from Brazil to Bangladesh?](https://brazilbangladeshchamber.com/how-to-import-from-brazil-to-bangladesh/) | Blog, News | 3616 | How to import from Brazil to Bangladesh (complete guide). |
| 96 | Post | 2026-10-18 | 2026-10-18 | [How to Find Brazilian Buyers for Bangladeshi Garments, Textiles and Denim](https://brazilbangladeshchamber.com/how-to-find-brazilian-buyers-bangladeshi-garments-textiles-denim/) | Blog, News | 4081 | How to find Brazilian buyers for garments, textiles and denim. LATEST POST (18 Oct 2026): 'Bangladeshi manufacturers can also consider participating in the Made in Bangladesh Expo 2027 in Sao Paulo, subject to the organizer's confirmed schedule and participation arrangements.' |

---

## 19. Key facts for the new portal

1. Organiser: **Brazil Bangladesh Chamber of Commerce & Industry (BBCCI)**.
2. BBCCI head office: **Shanta Skymark, Levels 8th–13th, 18 Gulshan Avenue, Gulshan, Dhaka-1212, Bangladesh** (letterhead: Level 12).
3. Emails: **president@ / vp@ / sg@brazilbangladeshchamber.com** (info@ appears in the 2025 deck only).
4. Phone/WhatsApp: **+880 1553 676767**. A second promo number, +880 19926 77117, needs confirmation.
5. Website: https://brazilbangladeshchamber.com.
6. President **Shahriar Ahmed**, VP **Md. Saiful Alam**, SG **Md. Joynal Abdin**.
7. Brazilian Ambassador to Bangladesh **H.E. Paulo Fernando Dias Feres** is captioned "Chief Patron of BBCCI".
8. Governance: 18-member Board; Executive Committee (President, VP, Treasurer, SG); committees for Trade & Investment, Membership & Outreach, Events & Programs.
9. Mission and vision text is available (see §3).
10. Membership: Corporate, Individual and Associate on the site; Life, General, Corporate and Associate in the deck. Fees are unpublished.
11. The 1st edition was branded "**Made in Bangladesh Expo 2025**", promoted as the "1st Ever Made in Bangladesh Expo in the Soil of Latin America".
12. 2025 dates: **15–18 June 2025** (15 June set-up; 16–18 June exhibition days).
13. 2025 venue: **Novotel São Paulo Center Norte / Expo Center Norte complex**, São Paulo, in hotel function rooms.
14. 2025 support: "Supported by the Brazilian Embassy in Dhaka".
15. 2025 exhibitors: "20 exhibitors" (case study). No visitor numbers are published.
16. 2025 programme: Inaugural Ceremony on 16 Jun 11:00–13:00; B2B matchmaking daily 14:00–17:00 (16–18 Jun); Seminar on Trade & Investment Opportunities on 17 Jun 11:00–13:00; Seminar by a Brazilian expert on 18 Jun 11:00–13:00; Meet the Press on 16 Jun 09:30 and 18 Jun 17:00; Closing Ceremony on 18 Jun 17:00–19:30.
17. 2025 Chief Guest: Dr. Taufiqul Islam, PhD.
18. 2025 sectors: RMG/textiles, jute, pharma, leather, home textiles, agro and food, ICT, handicrafts, plastics, ceramics, bicycles, seafood.
19. 2025 claimed outcomes: a pharma distribution MoU with a São Paulo health distributor; a jute-packaging JV proposal; RMG sourcing talks.
20. 2025 exhibitor package (EXTERNAL): **USD 4,000 per company, 8×8 sq ft stall, 2 exhibitors, stall preparation and branding included**.
21. 2025 importer/B2B package (EXTERNAL): **USD 1,000 per person** (visit, B2B meetings, networking).
22. 2025 early bird: **10% off** to 31 Jan 2025 (extended to 15 Feb 2025).
23. 2025 deadline: 30 Mar 2025, extended to **30 Apr 2025**.
24. 2025 required documents: trade licence, TIN, VAT registration, owner's profile (BGMEA members also needed export/import licence and BGMEA certificate). Passport numbers of the nominees were collected.
25. Payment: bank deposit to BBCCI, Eastern Bank Ltd, North Gulshan Branch (details in §5.4; reconfirm before use).
26. 2025 pre-event: a Dhaka press conference and briefing at Hotel Ascott Palace, Baridhara; a briefing session for exhibitors (10-step participation guide).
27. Next edition on the site: "Made in Bangladesh Expo **2026**", the second edition, "**tentatively 20–30 November 2026, three-day program**" (16 May 2026). No venue.
28. The latest site content (18 Oct 2026) refers to "**Made in Bangladesh Expo 2027** in São Paulo, subject to the organizer's confirmed schedule".
29. The site never mentions 22–25 March 2027 or Pro Magno Centro de Eventos.
30. Planned next-edition features: seminars, investment forums, policy dialogues, cultural showcases, buyer–seller matchmaking, networking, industrial cooperation dialogues; logistics, shipping, certification and finance exhibitors.
31. Planned next-edition sectors: RMG, pharma, jute, leather, agro-processing, renewable energy, ICT, sustainable manufacturing, engineering, ceramics, home décor.
32. Partners named: FBCCI, MCCI, EPB, BGMEA, BKMEA, BTMA (2025 partner meetings); FBCCI co-hosted the 2024 Dhaka meeting with Brazil's FM Mauro Vieira.
33. Trade context (2022): Brazil→BD USD 2.35 bn and BD→Brazil USD 178 m. Bilateral trade "over US$2.5 bn" (2022) and ≈US$2.7 bn (2024).
34. BD exports to Brazil: USD 187 m in FY2024-25, +26% year on year (EPB).
35. 2025 (Comtrade): Brazil→BD US$2.72 bn; BD→Brazil US$281.79 m. Brazil is BD's largest cotton supplier (≈23%, 1.9 m bales).
36. Diplomatic relations since 1972.
37. Videos: 7 YouTube videos, including the "Made in Bangladesh Expo 2025 in Sao Paulo, Brazil" recap (`AhCawT3n2Uo`) and leadership interviews.
38. Brand colours (logo): green #009738, navy #012269, red #F42A40, yellow #F8DF09.
39. Logo: the current version has a wordmark. There is no SVG. The expo had its own "BB" monogram and "Made in Bangladesh Trade Fair" backdrop, and that file is not on the site.
40. Photo assets: 12 high-resolution São Paulo 2025 photos, 3 Dhaka press-conference photos, 20+ photos of the 2024 Dhaka events.

---

## 20. Gaps, contradictions and questions for the client

**Contradictions:**
1. **Edition naming and dates.**
   * The client says "Expo 2026".
   * The site (May–Jul 2026) says 2026, tentatively 20–30 Nov 2026, three days.
   * The site (18 Oct 2026) says "Expo 2027 … subject to the organizer's confirmed schedule".
   * A competitor demo says 22–25 Mar 2027 at Pro Magno, which is absent from the site.
   * **Confirm:** the official edition name/year, exact dates (including set-up), number of days, venue (Pro Magno Centro de Eventos?), hall and address, and whether it is the "2nd edition".
2. **2025 venue name.** The site uses "Novotel Center Norte and Expo Norte facilities", "Novotel / Expo Norte", "Expo Norte Novotel" and "Expo Center Norte". The photos suggest Novotel function rooms. **Confirm** the exact 2025 venue for "past editions" copy.
3. **8 March vs 8 April 2024:** the FBCCI–BBCCI meeting backdrop says "08 March 2024"; the post says "April 8, 2024".
4. **Membership classes** differ between the page (Corporate/Individual/Associate) and the deck and posts (Life/General/Corporate/Associate).
5. **President's name** in media metadata: "Md. Shahriar Alam" vs "Shahriar Ahmed".
6. **Address:** "Levels 8th–13th" (site) vs "Level 12" (letterhead).
7. **Phone:** +880 1553 676767 vs +880 19926 77117 (Membership Month promo).
8. **Trade statistics** conflict across posts (different sources and years). Pick one sourced set for the portal.
9. **Outcome claims** (MoU, JV, "20 exhibitors") come from the chamber's own narrative and are unverified. One post itself advises verification.

**Missing information (must come from the client):**

10. **2026/27 participation packages and prices** (USD, BDT, BRL?), stall sizes and types (shell scheme, raw space, corner), what each package includes, sponsorship tiers, early-bird rules, deadlines, cancellation and refund terms.
11. **Registration and payment flow:** current bank details (the 2025 Eastern Bank account must be reconfirmed), online payment wish (card, bKash, PIX?), invoice requirements, required documents, and whether passport details are collected.
12. **Visitor/buyer registration** (free or paid?), B2B matchmaking process, and the hosted-buyer programme.
13. **Visa support** (invitation letters from BBCCI or the Embassy?), recommended hotels (Novotel deal?), travel and logistics, freight forwarder for samples, customs/ATA carnet guidance.
14. **Programme and schedule** for the next edition; speakers; seminars; inauguration guests.
15. **Partners and sponsors:** official list and logos (Brazilian Embassy Dhaka, Bangladesh Embassy Brasília, EPB, Ministry of Commerce, FBCCI, BGMEA/BKMEA/BTMA, Brazilian bodies such as ApexBrasil or FIESP?), and media partners.
16. **2025 results:** actual numbers of exhibitors, visitors and B2B meetings, an exhibitor list, testimonials with permission, and more photos and video (including the expo sub-brand logo file).
17. **Brazil-side contact:** São Paulo office or representative, Brazilian phone or WhatsApp, Portuguese-speaking contact.
18. **Social media accounts** (BBCCI Facebook, LinkedIn, YouTube?). None are linked from the site; the videos sit on T&IB channels.
19. **Board of Directors** names (18), the Treasurer, photos and bios. Official high-resolution headshots (current ones are low-resolution crops from a PDF).
20. **Legal details:** founding year, registration and licence number, and whether BBCCI is a registered non-profit or trade body.
21. **Logo source files** (SVG/AI) for BBCCI and the expo monogram, and any brand guide.
22. **Languages:** confirm EN + PT + BN for the portal and who supplies the translations.
23. **Roadshows and launch events** (Dhaka launch, Rangpur/Chattogram promotion meetings, MoUs, delegations). **There are none on the site**; obtain dates, photos and copy from the client if these happened.
24. The 2024 "BBCCI Events" photo set (S-1…S-7) is undated. Ask the client for the date and occasion (possibly the BBCCI launch).
