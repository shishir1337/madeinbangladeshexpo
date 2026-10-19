# 03 — Domain, Compliance, Integrations & Feature Research
## Made in Bangladesh Expo (São Paulo) web portal — pitch research

**Prepared:** 19 Oct 2026  **Target stack:** Laravel 13 / PHP 8.4  **Languages:** English, Português (Brasil), বাংলা

**How to read this.** Every fact has a source URL. **UNVERIFIED** means no official or primary source could be found on 19 Oct 2026; such items must be confirmed with BBCCI or the provider before they appear in client-facing material. Package and library versions were pulled live from Packagist / npm / Docker Hub on 19 Oct 2026. Several vendor figures (prices, acceptance rates) are vendor-reported.

---

## Executive summary (decision-relevant)

1. **The "22–25 March 2027, Pro Magno" dates are not published anywhere official.** BBCCI's own site (16 May 2026) said the 2nd edition was "tentatively" 20–30 Nov 2026 with no venue; its newest post (18 Oct 2026) refers to "Made in Bangladesh Expo 2027 in São Paulo, subject to the organizer's confirmed schedule". Pro Magno's public calendar runs only to Dec 2026, and the event microsite still shows the 2025 edition. The 22–25 March 2027 / Pro Magno claim seems to come only from the competitor's demo. **Get written confirmation from BBCCI.** The portal must keep dates and venue as admin-editable settings, never hard-coded.
2. **The 2025 edition was small**: about 20 exhibitors on the event site, against "100+" announced. It was held at the Novotel Center Norte, not Pro Magno. The site shows three different date ranges (15–18, 16–18, 17–18 June). The fee was **US$4,000 per 8×8 ft stall** and US$1,000 per importer/B2B delegate, paid to BBCCI's **Eastern Bank (Dhaka)** account. No audited results exist. A portal that records matchmaking, meetings and deal outcomes directly fixes BBCCI's credibility gap.
3. **Trade is lopsided.** In 2025 Brazil exported about **US$2.7B** to Bangladesh (sugar, cotton, cereals, soy) and imported about **US$282M** (about 90% apparel). Bangladeshi goods pay the Mercosur tariff of about **35%**. **LDC graduation (formally 24 Nov 2026; a 3-year deferral is pending at the UNGA)** removes **no** Brazilian preference, because none exists.
4. **Visa:** Bangladeshis **cannot use Brazil's e-visa**, which covers only the US, Canada, Australia, India (business, Oct 2025) and China (business, Jan 2026). They need a **VIVIS (visitor visa, business purpose)** from the **Embassy of Brazil in Dhaka**. "VITEM II" now means medical treatment, not business. Requirements: passport valid ≥6 months, an **invitation letter notarised in Brazil**, trade licence, IRC/ERC, TIN/BIN, and company and personal bank statements. Fee is paid by pay order (BDT 9,600–11,200, UNVERIFIED). Processing takes up to 20–30 working days. The portal's visa desk should generate the invitation letters, track notarisation and courier, check passport validity against the event dates, and give a document checklist (Section B).
5. **Payments:** SSLCommerz is the primary BDT gateway (cards and bKash/Nagad in one integration), but **it caps a transaction at BDT 500,000**, roughly a US$4,000 stall. Full stalls need **bank transfer/SWIFT with proof upload** as the main path. Bangladesh Bank FEPD Circular 26 (30 Jul 2026) allows exporters to pay fair fees from ERQ accounts without prior approval. **Stripe does not serve Bangladeshi entities.** Brazilian Pix requires a Brazilian CNPJ entity (Mercado Pago or Efí).
6. **The alphanumeric CNPJ went live on 31 Jul 2026.** CNPJ fields must be `CHAR(14)` text that accepts A–Z. Any numeric-only CNPJ mask or validator now rejects newly registered companies. Test the competitor's demo for this; it is a cheap, concrete point in our favour.
7. **Stack is Laravel-13-ready**: Filament **v5.10** (Livewire **4.4**), Tailwind **4.3**, spatie/laravel-pdf **v2.14**, Pest **5.3** (PHP 8.4 / PHPUnit 13) or Pest 4.7 (PHPUnit 12). **Avoid** `simplesoftwareio/simple-qrcode` (unmaintained since 2021; conflicts with Fortify), Filament's old translatable plugin (v3 only) and the "file-vault" packages (Laravel ≤9). **This machine's PHP CLI is 8.2.12 (XAMPP)**, below Laravel 13's minimum.
8. **Bangla PDFs:** dompdf **cannot** shape Bangla (dompdf issue #2619 is still open). Use **Chromium-based rendering**: spatie/laravel-pdf v2 with the **Gotenberg** driver (or Browsershot / Cloudflare Browser Run). mPDF with OTL is the fallback only.
9. **Differentiators beyond the competitor:** AI B2B matchmaking plus meeting scheduler and B2B table management; **interpreter booking (PT↔BN↔EN)**; offline lead-retrieval PWA; HS→NCM product catalogue plus RFQ; visa-letter generation with QR verification; deal-outcome tracker and exhibitor ROI reports; WhatsApp notifications; kiosk self-print badges; wallet passes; and a services-ordering e-manual.
10. **Compliance:**
    - **LGPD:** publish the encarregado (DPO) (Res. 18/2024). Use ANPD SCCs for processors outside Brazil and the EU (mandatory since 23 Aug 2025). EU↔Brazil mutual adequacy has applied since Jan 2026. Report incidents within 3 working days. Use specific, highlighted consent to share buyer data with Bangladeshi exhibitors (Bangladesh has no adequacy decision).
    - **Bangladesh:** the **Personal Data Protection Act 2026** (formerly the Nov 2025 Ordinance) is extraterritorial; full enforcement is expected around May 2027.
    - **Customs:** **ATA Carnets are not usable for Brazil** (the guarantor's mandate ended Dec 2021). Exhibition goods enter under **temporary admission (IN RFB 1.600/2015)** with a Brazilian CNPJ consignee; the organiser can be the beneficiary.
    - **ANVISA:** samples cannot be sold, and unregistered medicines cannot be exhibited.

---

## A. Event & market facts

### A.1 Made in Bangladesh Expo — 2025 (1st edition)

| Item | Finding | Source |
|---|---|---|
| Name / organiser | "Made in Bangladesh Expo 2025" / "Made in Bangladesh Exhibition-2025", the first edition, organised by the Brazil Bangladesh Chamber of Commerce & Industry (BBCCI) | https://www.thedailystar.net/business/news/local-businesses-host-made-bangladesh-exhibition-brazil-3794611 · https://bgmea.com.bd/uploads/circulars/attachments/circular_attachment_BGMEA_Brazil_Fair__1738148853.pdf |
| Announced dates | 15–18 June 2025 (BGMEA circular of 28 Jan 2025, BSS, Daily Star, TBS) | https://www.bssnews.net/business/236869 · https://www.tbsnews.net/bangladesh/bangladesh-showcase-products-brazil-15-18-june-1058151 |
| Date conflict | Event microsite: hero "16 a 18 de Junho", welcome text "17 a 18 de junho de 2025", agenda lists 16/06–18/06. The Guide (post-event): 16–18 June. Visite São Paulo: 17–18 June. Likely reading: 15 = set-up/arrival, 16–18 = event days (**UNVERIFIED**). | https://madeinbangladesh.com.br · https://theguide.com.br/relevant/brazil-bangladesh-chamber-of-commerce-and-industry-presented-the-made-in-bangladesh-2025-trade-show-in-sao-paulo/ · https://visitesaopaulo.com/evento/made-in-bangladesh-2025/ |
| Venue | **Novotel São Paulo Center Norte** ("Expo Norte Novotel"), Av. Zaki Narchi 500, Vila Guilherme. B2B sessions in "Pavilhão nº 2". | https://visitesaopaulo.com/evento/made-in-bangladesh-2025/ · https://madeinbangladesh.com.br |
| Opened by | Dr. Tauhedul Islam, Ambassador of Bangladesh to Brazil. Regina Carnovale Nunes (wife of São Paulo's mayor) spoke. Bangladesh's Defence Attaché attended. | The Guide (above) |
| Scale | Announced: "more than 100 companies". Microsite: "1,500 participants / 20 exhibitors / 10 speakers / 5 awards", about 14 exhibitor logos (AMAN, BPG, Mitali, APEX, Pioneer…). **Actual attendance UNVERIFIED.** | https://www.bssnews.net/business/236869 · https://madeinbangladesh.com.br · https://brazilbangladeshchamber.com/case-study-on-the-made-in-bangladesh-expo-2025-sao-paulo-brazil/ |
| Results (self-reported by BBCCI) | A pharma distribution MoU with a São Paulo distributor; a proposed jute-packaging JV with a Brazilian agri-startup; a Brazilian textile importer in talks with 2 garment makers. No deal values given. | https://brazilbangladeshchamber.com/made-in-bangladesh-expo-2025-impact/ |
| Fees | Exhibitor **US$4,000** (8×8 ft stall, 2 delegates, venue, branding). Importer/B2B delegate **US$1,000**. 10% early-bird until 31 Jan 2025, later extended to 15 Feb. Registration closed 30 Mar 2025. Payment to BBCCI's account at **Eastern Bank Ltd, North Gulshan, Dhaka (SWIFT EBLDBDDH)**. | BGMEA circular PDF (above) |
| Sectors promoted | RMG, jute, leather, pharma, home textiles, fish/shrimp, plastics, bicycles, ceramics, agro-processed food, ICT, handicrafts | BGMEA circular (BBCCI deck pp. 15–16) |
| Media | Bangladesh (pre-event only): Daily Star, Dhaka Tribune (https://www.dhakatribune.com/amp/business/370305/%E2%80%98made-in-bangladesh%E2%80%99-expo-on-june-15-18-in-brazil), BSS, New Age (https://www.newagebd.net/post/foreign-affairs/255734/brazil-offers-gateway-to-latin-america-for-bangladeshi-businesses), TBS, Observer BD, Daily Sun. Brazil: Propmark interview (https://propmark.com.br/conexao-asia/conexao-asia-made-in-bangladesh/), The Guide, Visite São Paulo. **No post-event coverage found in Bangladeshi outlets, and none in Financial Express or Prothom Alo.** | as listed |

### A.2 Next edition — status as of 19 Oct 2026

| Claim | Status | Source |
|---|---|---|
| 2nd edition in Nov 2026 | BBCCI post of 16 May 2026: "tentatively scheduled between November 20 and November 30, 2026", final dates "yet to be finalized", no venue. **No evidence it was confirmed or held.** | https://brazilbangladeshchamber.com/made-in-bangladesh-expo-in-sao-paulo-brazil/ |
| 2027 edition | BBCCI post of 18 Oct 2026: "Made in Bangladesh Expo 2027 in São Paulo, subject to the organizer's confirmed schedule" | https://brazilbangladeshchamber.com/how-to-find-brazilian-buyers-bangladeshi-garments-textiles-denim/ |
| **22–25 March 2027 at Pro Magno** | **UNVERIFIED.** Not on the BBCCI site, not on madeinbangladesh.com.br (still the 2025 edition, checked 19 Oct 2026), not on Pro Magno's calendar (lists to Dec 2026), not in trade-fair directories. It appears in the competitor's demo video. | https://www.promagno.com.br/ · https://madeinbangladesh.com.br · https://www.tradefairdates.com/Events+Center+PRO+MAGNO-ZS9752.html |
| Brand confusion | **madeinbangladeshexpo.com** belongs to an unrelated organiser running "Made in Bangladesh Expo" in London (4–6 Sep 2026), Rome (27–29 Nov 2026) and Jeddah (20–22 Dec 2026). SEO and brand risk: secure a distinct domain and use `Organization`/`Event` schema with sameAs links. | https://madeinbangladeshexpo.com |

**Related events (useful content and partnerships):** Home Show Brazil 2026 (11–13 Aug 2026, Distrito Anhembi): EPB-funded Bangladesh participation with 4 firms in 5 booths, B2B meetings and a seminar (https://www.bssnews.net/news/413886). Brazil Pavilion at the 9th Agro International Expo, Dhaka (7–9 May 2026): 14 Brazilian exhibitors (https://noticiamarajo.com.br/agronegocio/pavilhao-brasil-apresenta-produtos-do-agro-nacional-na-9a-agro-expo-em-bangladesh/). FBCCI MoUs with the Rio and São Paulo commercial associations (Jul 2022) and ApexBrasil (Feb 2023) (https://thefinancialexpress.com.bd/public/trade/fbcci-signs-mou-with-brazilian-agency-to-expand-bilateral-trade-1675510734). The Brazil International Yarn & Fabric Sourcing Show is held at **Pro Magno** (17–19 Nov 2025), a useful benchmark for an Asian sourcing fair at that venue (https://www.showsbee.com/fairs/100159-Brazil-International-Yarn-Fabric-Show-2027.html).

### A.3 BBCCI — organisation

- Website https://brazilbangladeshchamber.com; event microsite https://madeinbangladesh.com.br (PT/EN only).
- **Dhaka HQ:** Shanta Skymark, 18 Gulshan Avenue, Gulshan, Dhaka-1212 (level stated inconsistently, 8–13 or 12); +880-1553-676767; president@ / vp@ / sg@brazilbangladeshchamber.com (https://brazilbangladeshchamber.com/contact-us/).
- **People:** President **Shahriar Ahmed**; VP Md. Saiful Alam; Secretary General Md. Joynal Abdin; Director R.H.M. Imran Chowdhury; BBCCI Brazil Chapter President **David El Attar**, VP Marcio Fernando Dias Feres; Honorary Consul of Bangladesh in São Paulo **Marcelo Grendel Guimarães** (BGMEA deck; madeinbangladesh.com.br; The Guide).
- **São Paulo address: UNVERIFIED.** The microsite contact is info@acquaviva.com.br.
- **Open question:** does BBCCI have a **Brazilian CNPJ entity**? This decides Pix/boleto, LGPD controller identity and Brazilian invoicing.

### A.4 Pro Magno Centro de Eventos (proposed venue)

| Item | Finding | Source |
|---|---|---|
| Address | **Av. Professora Ida Kolb, 513, Jardim das Laranjeiras / Casa Verde, São Paulo-SP**, CEP 02518-000 (directories). Cargo entrance: Rua Samaritá, 230. | https://www.promagno.com.br/como-chegar · https://www.tradefairdates.com/Events+Center+PRO+MAGNO-ZS9752.html |
| Area | Venue: **28,000 m² rentable**, minimum booking 3,000 m². Directories / Panrotas 2014: 48,000 m² total, ~21,000 m² exhibition (sources conflict). | https://www.promagno.com.br/ · https://www.panrotas.com.br/noticia-turismo/hotelaria/2014/08/29a-abup-show-estreou-novo-espaco-em-sao-paulo_103946.html |
| Halls | Modular, soundproofed dividers; 2 floors (Panrotas) or 4 floors (job-listing snippet). **Named halls UNVERIFIED.** | as above |
| Capacity | Modular auditoriums for **50–5,000** people | https://www.promagno.com.br/ |
| Parking | ~1,000–1,070 covered spaces; R$75 day / R$85 night per 12 h (car) | https://www.promagno.com.br/como-chegar |
| Transit | Nearest rail: **Palmeiras-Barra Funda** (Metro Line 3 + CPTM), then a bus to Av. Ordem e Progresso 1140 and ~400 m walk | https://www.promagno.com.br/como-chegar |
| Airports | **GRU** ~13.4 km straight line (CPTM to Barra Funda suggested); **CGH** ~8.2 km. Road times **UNVERIFIED** (allow 45–90 min from GRU at peak). | as above |
| Partner hotels | Mercure SP Barra Funda; Rio Hotel by Bourbon Barra Funda; Wyndham Garden SP Convention Nortel; Ibis SP Barra Funda; Ibis Styles Barra Funda | https://www.promagno.com.br/hoteis-parceiros |
| Contact | +55 11 4010-5100 · promagno@promagno.com.br | https://www.promagno.com.br/ |

Portal implication: the city-guide map needs the Barra Funda transit pattern (the last mile is not walkable from the metro), a **shuttle-bus schedule** feature for Barra Funda station and partner hotels, and partner-hotel booking codes.

### A.5 Bangladesh–Brazil trade statistics

Brazil reports by calendar year (CY); Bangladesh reports by fiscal year (FY, Jul–Jun). Don't mix the two in one chart.

| Period | Brazil → Bangladesh | Bangladesh → Brazil | Source |
|---|---|---|---|
| CY2022 | $2.35B | $178M | OEC via BBCCI deck (BGMEA PDF) |
| CY2023 | $2.11B | $215M | https://oec.world/profile/bilateral-country/bra/partner/bgd (Daily Star cites $2.72B total, a conflict) |
| CY2024 | UNVERIFIED | $257.1M | https://fr.tradingeconomics.com/brazil/imports/bangladesh |
| **CY2025** | **$2.72B** | **$281.8M** | https://tradingeconomics.com/brazil/exports/bangladesh · https://tradingeconomics.com/brazil/imports/bangladesh |
| FY2022-23 | $2.59B | $175M | https://www.tbsnews.net/economy/bangladeshs-export-brazil-26-fy25-1224566 |
| FY2023-24 | $2.66B | $147M | TBS (above) |
| **FY2024-25** | ~$2.64B | **$187.3M (+26%)** | https://en.prothomalo.com/business/local/b8od1slqgz |

- **Brazil sells (CY2025):** sugar $874.5M; cotton $814.8M; cereals $389.1M; soymeal/fodder $215.6M; soybeans $212.0M; fats/oils (crude soy oil) $137.2M (Trading Economics). Brazil supplied **~25% of Bangladesh's cotton** in MY2024/25 (USDA FAS via https://uiscbd.ning.com/news/a-quarter-of-bangladesh-s-cotton-comes-from-brazil-dhaka-wants-a).
- **Bangladesh sells:** about **90% apparel** (CY2025: knit $133.4M, woven $119.1M); jute $7.6–9.6M; leather goods/footwear $3.3–4.7M; home textiles $0.8M; pharma (small).
- A "nearly US$4 billion" bilateral figure quoted at a May 2026 ministerial meeting (https://www.bssnews.net/news/387387) is not supported by any dataset found.
- **Content idea:** a live "trade dashboard" page fed from Comex Stat (Brazil's official trade API) or Trading Economics data shows BBCCI's expertise and attracts buyers.

### A.6 Diplomatic relations timeline (for the "since 1972" page)

| Date | Event | Source |
|---|---|---|
| 15 May 1972 | Diplomatic relations established. Brazil was the first Latin American country to recognise Bangladesh. | https://en.wikipedia.org/wiki/Foreign_relations_of_Bangladesh · https://bimradbd.org/publication-details/bangladesh-brazil-relations-out-to-2041 |
| 1973 / 1974 | Bangladesh embassy in Brasília opens (closed 2002, reopened 2012); Brazil embassy in Dhaka opens (closed 1998, reopened 2009). Single source. | BIMRAD (above) |
| 2011 | Bangladesh Foreign Secretary visits Brasília | https://en.wikipedia.org/wiki/Bangladesh–Brazil_relations |
| 20 Aug 2021 | Bangladesh admitted to the BRICS **New Development Bank** (first non-BRICS member, with the UAE and Uruguay) | https://www.tbsnews.net/economy/bangladesh-gets-brics-bank-membership-296677 |
| Jul 2022 | 50th anniversary: visa-exemption agreement for diplomatic/official passports; Bangladesh seeks a Mercosur PTA/FTA | https://www.tbsnews.net/bangladesh/visa-exemption-agreement-signed-brazil-mark-50-years-diplomatic-relations-461362 |
| Jul 2022 / Feb 2023 | FBCCI MoUs with Rio and São Paulo commercial associations; ApexBrasil MoU | FE (above) |
| Aug 2023 | Hasina–Lula meeting at the BRICS summit, Johannesburg | Daily Star |
| 6–8 Apr 2024 | **First-ever Brazilian foreign-minister visit** (Mauro Vieira); Basic Agreement on Technical Cooperation; both sides agree to start **Mercosur–Bangladesh PTA** talks "at the earliest opportunity" | https://www.thedailystar.net/business/news/govt-seeks-duty-free-access-brazil-3585151 · https://english.news.cn/20240408/80842a8ed8834673bbababcce81351d2/c.html |
| 15 May 2026 | Humayun Kabir (PM's adviser) meets Celso Amorim in Brasília: "multidimensional strategic partnership"; 10 instruments signed, 16 ready; Brazil backs Bangladesh's BRICS aspirations | https://www.bssnews.net/news/387387 |

**Mercosur status:** listed as "proposed/under study (2024)" by ADB ARIC (https://aric.adb.org/fta-country); no negotiating rounds found. BGMEA and Uruguay discussed an "eventual" FTA in Jan 2026 (https://bangladeshtextilejournal.com/bgmea-sees-strong-garment-export-potential-through-mercosur-trade-deal/).

### A.7 LDC graduation (24 Nov 2026) — implications

- **Status:** still formally 24 Nov 2026. The government has requested a deferral to 24 Nov 2029, and ECOSOC recommended a 3-year extension on 21 Jul 2026. A UNGA decision was "expected within this month" (Commerce Minister, 19 Oct 2026). **Final outcome UNVERIFIED.** Sources: https://www.thedailystar.net/business/news/ldc-graduation-deferment-decision-expected-within-month-commerce-minister-4302406 · https://thefinancialexpress.com.bd/home/ldc-graduation-deferment-confirmation-unlikely-during-this-unga-session
- **Brazil/Mercosur:** Bangladeshi apparel already pays about **35%** import duty (e.g. HS 6114.90.90 — https://treayo.com/en/hs/brazil/61149090), or "nearly 45%" effective. Mercosur's 2005 duty-free offer to LDCs was **never found to be implemented** (https://memoria.ebc.com.br/agenciabrasil//noticia/2005-12-14/mercosur-offers-unrestricted-market-access-ldcs). **Graduation costs Bangladesh no existing preference in Brazil.** That is a positive pitch message: Brazil is a market where Bangladesh competes on equal terms with China and Vietnam, and is unaffected by graduation.
- **Extra barrier:** Brazil keeps an **anti-dumping duty on jute sacks and bags from Bangladesh** (2010, extended 2016 and 2022) (https://globaltradealert.org/state-act/1765-brazil-extension-of-antidumping-duty-on-imports-of-sacks-and-bags-of-jute-from-bangladesh-and-termination-of-duty-india). The jute-sector page should say so honestly and steer exhibitors toward non-bag jute products (diversified jute goods, home décor).
- The Brazilian textile body **Abit** is calling for trade defence against Asian apparel imports (https://www.abit.org.br/noticias/industria-textil-e-de-confeccao-avanca-em-2025), a risk worth flagging to RMG exhibitors.

### A.8 Sectors with export potential to Brazil

| Sector | Evidence | Portal angle |
|---|---|---|
| RMG / knit & woven | ~90% of exports to Brazil; Brazil imported $6.81B of textiles and apparel in 2025, more than $4B from China (Abit) | Biggest exhibitor group; HS 61/62 → NCM mapping |
| Home textiles | Small to Brazil ($0.8M), growing globally | Buyer matchmaking with retail chains |
| Jute & diversified jute goods | $883.7M globally in FY26 (https://bdnews24.com/business/ovpf9scjoq); anti-dumping duty on sacks | Sustainability story, packaging |
| Leather & footwear | $1.23B globally in FY26 (https://unb.com.bd/category/Business/june-exports-surge-by-2591-fy26-earnings-hold-steady-at-48-billion-epb/189694) | Brazil is itself a leather and footwear power: focus on leather goods and accessories |
| Pharmaceuticals | $213M exports FY25 (https://www.thedailystar.net/business/news/pharma-exports-more-double-seven-years-3937071); ANVISA registration required | ANVISA pathway explainer (Section C) |
| Ceramics, plastics, light engineering (+21.8% FY26), bicycles, ICT, agro-processed food, frozen fish/shrimp, handicrafts | Named by BBCCI or the government as priority sectors (https://www.bssnews.net/news/387387) | One sector page each (the competitor has 9) |

### A.9 Bangladeshi trade associations (for the association portal)

| Acronym | Official name | Website | Relevance |
|---|---|---|---|
| BGMEA | Bangladesh Garment Manufacturers and Exporters Association | https://www.bgmea.com.bd | Woven RMG; circulated the 2025 expo |
| BKMEA | Bangladesh Knitwear Manufacturers and Exporters Association | https://www.bkmea.com | Knitwear, the largest line to Brazil |
| EPB | Export Promotion Bureau (রপ্তানি উন্নয়ন ব্যুরো) | https://epb.gov.bd | Funds single-country fairs; official statistics |
| LFMEAB → **FLAXA** | Leathergoods & Footwear Manufacturers & Exporters Association of Bangladesh, **renamed Footwear Leathergoods & Accessories Exporters Association (FLAXA), 5 Mar 2026** | https://lfmeab.org | Leather and footwear |
| BAPI | Bangladesh Association of Pharmaceutical Industries | https://bapi-bd.com | Pharma |
| BASIS | Bangladesh Association of Software and Information Services | https://basis.org.bd | ICT |
| BJMA | Bangladesh Jute Mills Association | https://bjma.org.bd | Jute mills |
| BJGEA | Bangladesh Jute Goods Exporters' Association | www.bjgea.org.bd (unreachable; listed at https://bangladesh.eregulations.org/Contacts/39?l=en) | Jute goods |
| BPGMEA | Bangladesh Plastic Goods Manufacturers & Exporters Association | https://bpgmea.org.bd | Plastics |
| FBCCI | Federation of Bangladesh Chambers of Commerce & Industry | https://www.fbcci.org | Apex body; MoUs with ApexBrasil and Brazilian chambers |
| DCCI | Dhaka Chamber of Commerce & Industry | https://www.dhakachamber.com | SMEs |
| MCCI | Metropolitan Chamber of Commerce and Industry, Dhaka | https://www.mccibd.org | Large corporates |
| BTMA | Bangladesh Textile Mills Association | https://www.btmadhaka.com | Buyers of Brazilian cotton (reverse-trade delegates) |
| BAPA | Bangladesh Agro-Processors' Association | https://bapabd.org | Food |
| BCMEA | Bangladesh Ceramic Manufacturers & Exporters Association | https://bcmea.org.bd | Ceramics |
| BFFEA | Bangladesh Frozen Foods Exporters Association | https://www.bffea.net | Shrimp and fish |
| BIDA | Bangladesh Investment Development Authority | https://bida.gov.bd | Investment desk |

Portal implication: the association model needs an **alias/rename history** (LFMEAB→FLAXA), logos, quotas per association, referral codes, and a **"two-way" track**. BTMA and the food importers are natural *buyers* of Brazilian goods, so the portal can host a reverse "Brazil → Bangladesh" buyer list as well.

---

## B. Visa & travel

*Note: several gov.br (Itamaraty/embassy) pages showed CAPTCHAs; their content is cited from search-index snippets. Confirm visa fees and processing times directly with the embassy before publishing them on the portal.*

### B.1 Brazil visa for Bangladeshi citizens

| Topic | Finding | Source |
|---|---|---|
| **E-visa** | **Not available to Bangladeshis.** Brazil's e-visa covers the US, Canada and Australia (reinstated 10 Apr 2025), India (business, from 20 Oct 2025) and China (business, from 19 Jan 2026). Everyone else applies for a stamped visa at a Brazilian mission. | https://en.wikipedia.org/wiki/Visa_policy_of_Brazil · https://vialtopartners.com/regional-alerts/brazil-business-travel-electronic-visa-platform-for-australian-canadian-and-united-states-nationals-effective-on-april-10-2025 |
| 2026 change | From 1 Sep 2026 most posts issue **temporary** visas (VITEM) electronically, but only for nationals already exempt from visitor visas. **This does not help Bangladeshi visitors.** | https://taxnews.ey.com/news/2026-1944-brazil-begins-issuance-of-electronic-temporary-visas-for-visa-exempt-nationals |
| Correct visa type | **VIVIS (visitor visa), business purpose**, under Migration Law 13.445/2017 and Decree 9.199/2017: meetings, **fairs**, contract signing. Up to 90 days per stay, max 180 days per 12 months; no Brazilian-source pay. Technical services or training need a VITEM V. | https://en.wikipedia.org/wiki/Visa_policy_of_Brazil · https://www.gov.br/mre/pt-br/consulado-londres/visa-section/types-of-visa/visitor-visa-vivis/visitor-visa-vivis-business |
| "VITEM II" | **Obsolete label for business.** VITEM II is now the temporary visa for *health treatment*. Some embassy pages still show the old "Business visa (VITEM II)" title. **The portal and invitation letters should say "VIVIS – business".** | https://www.gov.br/mre/pt-br/embaixada-maputo/vitem-ii-tratamento-de-saude |
| Where to apply | **Embassy of Brazil, Dhaka**: Bay's Edgewater (Ground & 1st floor), NE(N) 12, North Avenue, Gulshan-2, Dhaka-1212; +880 2 5505 2126–29 / 2133; brasemb.daca@itamaraty.gov.br; consular: consular.daca@itamaraty.gov.br; https://www.gov.br/mre/pt-br/embaixada-daca . Appointments by phone; no VFS centre for Brazil in Dhaka found. The older "Symphony Building" address in directories is outdated. | https://www.sri.ufrn.br/pais/bangladesh/index.php?lc=EN · https://visacenterbangladesh.com/business-visa-for-brazil/ |
| Fee | Paid by **bank pay order** in favour of "BRAZILIAN EMBASSY IN DHAKA" before the appointment. Amount conflicts: **BDT 9,600** or **BDT 11,200** for business/event (**UNVERIFIED**). | https://www.obokash.com/brazil-visa · https://visathing.com/bangladesh/brazil/ |
| Processing | Up to **20 working days** (embassy snippet); agencies say 7–30 working days | as above |
| Yellow fever | **Not required for entry**; vaccination *recommended* for São Paulo state (CDC) | https://wwwnc.cdc.gov/travel/destinations/traveler/none/brazil |

**Business VIVIS document checklist (Dhaka). This feeds the portal's visa-desk checklist, which can go beyond the competitor's 16 items:**

1. Passport: original, **≥6 months validity** (one agency reads it as 6 months beyond departure, issued within 10 years, 2 blank facing pages), plus copies of the data pages.
2. 2 photos, white background, taken within the last 6 months.
3. Online application form + cover letter.
4. Employer NOC / forwarding letter + office ID (3 copies).
5. **Invitation letter from the Brazilian company or person, notarised in the same jurisdiction as the Brazilian inviter** (i.e. a Brazilian cartório).
6. Company memorandum, **trade licence**, **IRC & ERC** (import/export registration certificates), **TIN & BIN** certificates.
7. 3 months of company bank statements.
8. 6 months of personal bank statements + balance certificate.
9. Income-tax certificate / returns (translated and notarised; one agency asks for 3 years).
10. Flight itinerary.
11. Hotel reservation.
12. Event registration or participation confirmation (from the portal).
13. Visa fee pay order.
14. Embassy may request more; forged documents lead to a 10-year ban.

Sources: embassy snippet (https://www.gov.br/mre/pt-br/embaixada-daca) and https://visacenterbangladesh.com/business-visa-for-brazil/

### B.2 Bangladesh representation in Brazil

| Mission | Details | Source |
|---|---|---|
| **Embassy of Bangladesh, Brasília** | SHIS QL 12, Conjunto 01, Casa 03, Lago Sul, CEP 71630-215, Brasília-DF; consular +55 61 98128-8854 / 99822-9799; Ambassador **Dr. Md Tauhedul Islam** (opened the 2025 expo) | https://brasilia.mofa.gov.bd/ · https://brasilia.mofa.gov.bd/pages/static-pages/6952668b35ce18e1c05a9f0c |
| Conflicting directory data | Other addresses (QL 24 / QI 5), landline (61) 3367-3699, bdoot.brasilia@mofa.gov.bd (**UNVERIFIED**) | https://embassies.net/bangladesh-in-brazil/brasilia |
| **Honorary Consul in São Paulo** | Event microsite names **Marcelo Grendel Guimarães**. Third-party directories name Raul Milton Souza Sulzbacher (Rua Princesa Isabel 1740, Moema), probably outdated. **Confirm with BBCCI.** | https://madeinbangladesh.com.br · https://www.consulate-info.com/consulate/27675/Bangladesh-in-Sao-Paulo |

### B.3 São Paulo essentials (city-guide content)

| Topic | Finding | Source |
|---|---|---|
| Flights DAC→GRU | Emirates via Dubai (EK585 dep. 01:00, arr. 17:35, ~24.5–25.5 h); **Qatar Airways 3× daily Doha–GRU since 19 Feb 2026**; Turkish via Istanbul (total time UNVERIFIED, ~24–28 h) | https://www.emirates.com/bd/english/destinations/dac/gru/flights-from-dhaka-to-sao-paulo · https://www.qatarairways.com/pt-br/offers/doh-gru-triple-daily.html |
| GRU → venue | **CPTM Line 13-Jade "Expresso Aeroporto"** runs hourly to **Palmeiras-Barra Funda**, the nearest hub to Pro Magno; fare **R$5.40 since 6 Jan 2026**. The station isn't at the terminals: the free **Aeromóvel** people mover opened 20 Feb 2026 with reduced hours (full-service status UNVERIFIED). Airport Bus Service to Barra Funda/Tietê ~R$60–72; taxi ~R$130–200, Uber/99 ~R$100–180 (unofficial). | https://en.wikipedia.org/wiki/Line_13_(CPTM) · https://abcdoabc.com.br/sp-aumenta-passagem-de-metro-trem-5-40-em-2026/ · https://diariodotransporte.com.br/2026/02/21/aeromovel-de-guarulhos-passa-a-transportar-publico-em-geral-mas-em-horario-reduzido/ · https://www.airportbusservice.com.br/ |
| Money | BRL; Visa/Mastercard widely accepted. **Pix generally needs a CPF and a Brazilian bank account**, so visitors should plan on cards. | https://esim.holafly.com/travel-tips/brazil-payment-method/ · https://www.ribeirocavalcante.com.br/what-you-cant-do-without-cpf-in-brazil-2026/ |
| Power | Type N (Type C usually fits), 60 Hz; **São Paulo has both 127 V and 220 V outlets**, so check before plugging in | https://www.worldstandards.eu/electricity/plug-voltage-by-country/brazil |
| SIM | Prepaid SIMs normally need a CPF, so an **international eSIM** is easier | https://saily.com/en/blog/brazil-sim-card/ |
| Weather (late March) | Average high 28.0 °C, low 18.9 °C, ~229 mm rain in March (INMET normals): warm, humid, afternoon showers | https://portal.inmet.gov.br/noticias/balanço-são-paulo-sp-teve-chuva-e-temperaturas-acima-da-média-em-março-2024 |
| Safety (UK FCDO) | Phone theft (esp. 16:00–21:00), don't resist, express kidnappings, card cloning, use app taxis only, drink spiking | https://www.gov.uk/foreign-travel-advice/brazil/safety-and-security |
| Hotels near venue | Partner hotels (A.4) plus ibis Styles Barra Funda, Intercity Anhembi, Hotel Panamby (~1.1–1.8 km) | https://www.promagno.com.br/hoteis-parceiros · https://www.expedia.com/Pro-Magno-Event-Center-Hotels.0-l553248621594916766-0.Travel-Guide-Filter-Hotels |
| Tipping | ~10% service usually on restaurant bills (optional); round up taxis | https://www.smartertravel.com/?p=260778 |
| **Halal food** | Certifiers CDIAL and FAMBRAS; halal restaurants and butchers concentrated in **Brás/Pari**; Mesquita Brasil (Cambuci, 1929) | https://anba.com.br/halal-is-available-on-the-brazilian-market/ · https://halalspy.com/halal-food-guide/americas/brazil/ |

### B.4 Implications for the portal

- **Passport rule engine:** warn if the passport expires less than **6 months after planned departure from Brazil** (e.g. before ~late Sep 2027 for a late-March 2027 show; computed from the event-end setting, not hard-coded). Also prompt for 2 blank facing pages.
- **Visa timeline:** "No e-visa; apply in person at the Embassy of Brazil, Dhaka; allow up to 20–30 working days." Recommended submission deadline is about **10 weeks before the event**, with automated reminders by WhatsApp and email.
- **Invitation-letter workflow (beyond the competitor):** generate a per-delegate letter (PT + EN) from verified application data → BBCCI Brazil-chapter signatory approves → **cartório notarisation** status → courier or scan tracking → QR verification page the embassy can check. Purge passport data N days after the event.
- **Checklist uploader:** the 14 items above, each with status (missing, uploaded, verified, rejected) and reviewer comments, stored in the encrypted vault.
- **Travel hub:** GRU → Barra Funda by train; a shuttle from Barra Funda and the partner hotels to Pro Magno (a portal feature: shuttle timetable plus seat booking); Type N adapter, eSIM, "Pix unlikely without a CPF", halal map, FCDO safety tips. All in BN for exhibitors and PT/EN for buyers.

---

## C. Compliance

### C.1 LGPD (Lei 13.709/2018): obligations for an event-registration platform

| Topic | Rule | Source |
|---|---|---|
| Legal bases (Art. 7) | Use **contract (V)** for core registration and attendance data. Use **consent (I)** for marketing, for sharing buyer contact details with exhibitors (matchmaking) and for photos. Use **legitimate interest (IX)** with a documented balancing test for security, fraud prevention and aggregate analytics. Use **legal obligation (II)** for invoices and tax records. | https://lgpd-brazil.info/chapter_02/article_07 |
| Consent (Arts. 5 XII, 8) | Free, informed, unambiguous, for **specified purposes** (generic authorisations are void). A written consent clause must be **highlighted**. The controller carries the burden of proof. Revocable at any time by a simple procedure. Purpose changes must be notified. Pre-ticked boxes are invalid. | https://lgpd-brazil.info/chapter_02/article_08 |
| Data-subject rights (Art. 18) | Confirmation, access, correction, anonymisation/blocking/deletion, portability, deletion of consent-based data, information on sharing, information on the right to refuse, revocation. **Free of charge.** | https://lgpd-brazil.info/chapter_03/article_18 |
| Deadlines (Art. 19) | Simplified confirmation or access **immediately**; full declaration **within 15 days** | https://www.legjur.com/legislacao/art/LEI_00137092018-19 |
| **Encarregado (DPO)** (Art. 41 + **Res. CD/ANPD 18/2024**) | Appointed by a formal written, dated and signed act; may be a person or a company; needs a substitute, autonomy and conflict-of-interest safeguards. **Identity and contact must be published, preferably on the website.** | https://tagdlaw.com.br/regulamento-da-anpd-sobre-encarregado-de-dados-dpo/ · https://lefosse.com/noticias/o-que-voce-precisa-saber-sobre-o-novo-regulamento-que-trata-da-atuacao-do-encarregado-de-protecao-de-dados-data-protection-officer-dpo |
| **International transfer** (Art. 33 + **Res. CD/ANPD 19/2024**) | Allowed via adequacy, **ANPD standard contractual clauses** (mandatory in contracts since **23 Aug 2025**; EU SCCs are not valid on their own), specific highlighted consent, or contract necessity. **Since Jan 2026, EU ↔ Brazil mutual adequacy** (EU Decision 2026/179; Res. CD/ANPD 32/2026) means EU/EEA hosting needs no SCCs. **Bangladesh has no adequacy decision**: sharing buyer data with BD exhibitors needs specific consent (Art. 33 VIII) or contract necessity (Art. 33 IX). | https://lgpd-brazil.info/chapter_05/article_33 · https://lefosse.com/noticias/transferencia-internacional-de-dados-prazo-para-adocao-das-clausulas-padrao-da-anpd-se-encerra-em-23-de-agosto/ · https://www.whitecase.com/insight-alert/mutual-adequacy-between-eu-and-brazil-new-era-transatlantic-data-transfers |
| Security incidents (Art. 48 + **Res. 15/2024**) | Notify **ANPD and the data subjects within 3 working days** of an incident that may cause relevant risk or harm (6 days for small agents); supplementary info within 20 working days; keep an **incident log for 5 years** (including unreported incidents) | https://cesconbarrieu.com.br/anpd-aprova-o-regulamento-de-comunicacao-de-incidente-de-seguranca/ |
| Retention (Arts. 15–16) | Delete when the purpose ends, unless there's a legal obligation (e.g. tax records) or the data is anonymised | https://lgpd-brazil.info/chapter_02/article_16 |
| Small-agent regime (Res. 2/2022) | Simplified duties and doubled deadlines for micro and small entities. **Lost for high-risk processing** (large scale + profiling or sensitive data). AI matchmaking with profiling at scale may tip BBCCI into high-risk, so plan for a full DPO and a RIPD (data-protection impact report). | https://www.mayerbrown.com/-/media/files/perspectives-events/publications/2022/02/regulation-for-the-application-of-the-general-data-protection-law-lgpd-for-small-business-data-processing-agents/legal-update--regulamento-agentes-de-pequeno-porte.pdf |
| Sanctions (Art. 52 + Res. 4/2023) | Warning; fine up to **2% of Brazilian revenue, capped at R$50M per infraction**; daily fines; publication; blocking or deletion; suspension of processing | https://lgpd-brazil.info/chapter_08/article_52 |
| **2026 change** | ANPD became an independent regulatory agency (**Lei 15.352 of 25 Feb 2026**) | https://www2.camara.leg.br/legin/fed/lei/2026/lei-15352-25-fevereiro-2026-798731-norma-pl.html |
| Sensitive data | Biometrics (face, fingerprint), health, religion (e.g. a "halal meal" preference can reveal religion) are **sensitive** (Art. 5 II, Art. 11). Avoid facial recognition; make dietary preferences optional with a neutral label. | https://lgpd-brazil.info/ |

### C.2 Bangladesh — Personal Data Protection Act 2026 (formerly the 2025 Ordinance)

| Item | Finding | Source |
|---|---|---|
| Timeline | **Ordinance No. 61 of 2025** gazetted **6 Nov 2025** → Amendment Ordinance No. 23 of 2026 (**5 Feb 2026**: localisation narrowed; prison for directors replaced by fines) → **Personal Data Protection Act, 2026 (Act No. 63 of 2026)**, passed **Apr 2026**, effective retroactively from 6 Nov 2025. Some sections (CDO, complaints, administrative penalties) await a government notification. **Full enforcement expected ~13 May 2027** (secondary sources; Bangla gazette not checked). | https://www.bssnews.net/news-flash/330104 · https://digitalpolicyalert.org/change/18757-personal-data-protection-amendment-ordinance-2026-ordinance-no-23-of-2026 · https://securiti.ai/bangladesh-personal-data-protection-act-overview/ |
| Regulator | Data Protection Authority under the national data-governance framework, attached to the **Prime Minister's Office** | Sultana & Ali (2026) https://pdfs.semanticscholar.org/f4fe/9049104e124d7f5a8a7f56d4fae089a12ee8.pdf |
| Scope | **Extraterritorial**: covers processing abroad linked to offering services to people in Bangladesh, so **the portal is in scope for Bangladeshi exhibitors and delegates** | securiti; Sultana & Ali |
| Consent | Free, specific, informed, unambiguous, withdrawable. Notice must state purpose, retention, recipients and transfers, and how to withdraw. Exceptions include contract and legal obligation. | https://bd-scl.com/insights/personal-data-protection-ordinance-2025-compliance.html |
| Rights | Access, correction (the controller informs within **30 days**), portability, deletion, withdrawal, opt-out | securiti |
| Data classes and localisation | Public / internal / confidential / **restricted**. After the Feb 2026 amendment, an in-country synchronised copy is required for *restricted* and CII data. Other data may be transferred with consent or for a contract to adequate countries. **Sources conflict on how far localisation still applies**, so get Bangladeshi counsel. | Sultana & Ali; https://mahbub-law.com/key-highlights-of-the-personal-data-protection-ordinance-2025-for-businesses/ |
| Breach | Notify the **Authority** "within prescribed time" (analysts cite 72 h, **UNVERIFIED**); no explicit duty to notify individuals | securiti |
| Records and retention | No longer than necessary; processing records kept ≥5 years; a Chief Data Officer for "significant" fiduciaries | securiti |
| Penalties | Sources conflict: turnover-based 1–2% (2–5% for significant fiduciaries), or fixed up to BDT 25–50 lakh | https://bd-scl.com/insights/personal-data-protection-ordinance-2025-compliance.html · securiti |
| Cyber Security Ordinance 2025 | Ordinance No. 25 of 2025 (21 May 2025) replaced the Cyber Security Act 2023. Mostly indirect relevance (lawful access, CII). Parliamentary ratification status UNVERIFIED. | https://digitalpolicyalert.org/event/38587-cyber-security-ordinance-2025-ordinance-no-25-of-2025-enters-into-force |

**Design consequence:** don't collect Bangladeshi **NID numbers, biometrics or bank-account data** unless strictly needed. Passport and trade-licence scans are needed for visas: encrypt them, restrict access, purge after the event. That keeps the portal clear of the "restricted" class and its localisation duty.

### C.3 Cookie consent

- **ANPD guide "Cookies e Proteção de Dados Pessoais" (Oct 2022):**
  - Strictly necessary cookies need no consent; analytics and advertising need consent.
  - **Two-level banner**: first level has *Accept*, *Reject non-essential* and *More info*; second level has categories with granular toggles.
  - Pre-selected options are "strongly discouraged".
  - ANPD criticised gov.br's accept-only banner.
  - Sources: https://www.felsberg.com.br/?p=41976 · https://www.gov.br/anpd/pt-br/assuntos/noticias/sei_pr-3368186-oficio.pdf
- **Bangladesh:** no cookie-specific rule. Online identifiers are personal data, so consent principles apply.
- **EU visitors:** *Planet49* (CJEU C-673/17) says pre-ticked boxes are invalid and users must be told cookie duration and third-party access (https://curia.europa.eu/jcms/upload/docs/application/pdf/2019-10/cp190125en.pdf).
- **One build satisfies all three regimes:**
  - Opt-in banner with Accept and Reject equally prominent; no cookie wall; no analytics before consent.
  - A versioned consent log.
  - A footer link to reopen preferences.
  - Self-hosted fonts, and YouTube/maps behind click-to-load facades.

### C.4 ANVISA: exhibiting and importing cosmetics, food and pharma

| Topic | Rule | Source |
|---|---|---|
| Import framework | **RDC 81/2008** still governs (revision under way since 2024). ANVISA lists fair purposes: "exposição", "exposição com demonstração", "exposição, demonstração e distribuição em feiras e eventos". | https://www.gov.br/anvisa/pt-br/assuntos/paf/anuencia/controle-administrativo-anvisa-no-comercio-exterior/importacao-de-produtos/informacoes-gerais · https://www.normasbrasil.com.br/norma/resolucao-81-2008_108553.html |
| Who may import | Only **ANVISA-authorised companies** may import regulated goods. In practice that means a **Brazilian importer or holder**. | RDC 81 Cap. IV |
| Unregistered samples (cosmetics, food, sanitisers, health products) | Non-automatic import licence + petition + Termo de Responsabilidade; **"É vedada a comercialização das amostras"** (no sale of samples; RDC 208/2018 amendment) | RDC 81 Cap. XXI |
| Distribution at fairs | Products must not expire within **30 days** of release; foreign-language-only labels may not be delivered to consumers | RDC 81 Cap. V, XV |
| **Medicines** | **Unregistered medicines cannot be shown at fairs.** Unregistered medical devices need prior ANVISA approval (apply ~3 months ahead) and must be re-exported. | https://www.latinigroup.com.br/index.php/em-foco/artigos/1164-exposicao-de-dispositivos-medicos-em-feiras-e-eventos |
| Luggage | The personal-use exemption covers own use only. The US$1,000 air allowance excludes goods that look commercial by quantity or nature, which must go through "Bens a Declarar". MAPA (agri-food) controls UNVERIFIED. | https://toexceed.com.br/blog/2026/09/09/bens-a-declarar-na-alfandega-do-brasil-o-que-precisa-ser-declarado-e-quais-sao-os-limites/ |
| Selling — cosmetics | **RDC 752/2022**: registration for risk groups (sunscreens, straighteners, repellents), notification for the rest; Brazilian authorised holder required | https://www.lex.com.br/resolucao-anvisa-no-752-de-19-de-setembro-de-2022/ |
| Selling — food | **RDC 843/2024 + IN 281/2024** (in force 1 Sep 2024; amended by RDC 983/2025 and 990/2025; adaptation deadline 1 Sep 2026): registration, notification or communication routes | https://www.mattosfilho.com.br/unico/anvisa-regularizacao-alimentos/ |
| Selling — pharma | Registration through a Brazilian ANVISA-authorised company (RDC 948/2024 per BBCCI) | https://brazilbangladeshchamber.com/pharmaceutical-export-opportunities-bangladesh-to-brazil/ |

### C.5 Customs: exhibition goods

- **ATA Carnet: not usable for Brazil.**
  - Brazil joined ATA in 2016 with CNI as guarantor (https://iccwbo.org/news-publications/news/brazil-operates-ata-carnet-system-ahead-of-olympics/).
  - **CNI's mandate ended 31 Dec 2021 and ATA operations closed**; no replacement was appointed (https://www.gzs.si/Portals/SN-Javna-Pooblastila/Brazil%202022%2002.pdf · https://en.wikipedia.org/wiki/ATA_Carnet).
  - Resumption since 2022: **UNVERIFIED**, so assume unavailable.
  - **Bangladesh does not appear to be an ATA member** either (UNVERIFIED negative).
- **Use temporary admission (admissão temporária, IN RFB 1.600/2015)** instead.
  - Full tax suspension for goods for commercial or industrial events and for promotional samples "sem destinação comercial".
  - Conditions: Termo de Responsabilidade; exclusive use for the declared purpose; goods identifiable; re-export afterwards; 10% fine for non-compliance; consumables excluded.
  - **The event organiser may be the beneficiary** (Art. 8 §1 I).
  - Sources: https://www.gov.br/receitafederal/pt-br/assuntos/aduana-e-comercio-exterior/manuais/admissao-temporaria/suspensao-total-do-pagamento-de-tributos/1-4-beneficiarios-1 · https://www.gov.br/receitafederal/pt-br/assuntos/aduana-e-comercio-exterior/manuais/admissao-temporaria/suspensao-total-do-pagamento-de-tributos/condicoes-e-beneficiarios
- **A Brazilian consignee with a CNPJ is required.** Siscomex rejects foreign consignees, and the importer needs Siscomex/RADAR enablement (limits UNVERIFIED).
- Bonded-fair regime ("entreposto aduaneiro") applies only if the venue is bonded. Whether Pro Magno is bonded is UNVERIFIED.
- Freight: Chittagong → Santos by sea ~35–50 days via Colombo or Singapore; air via the Gulf ~3–7 days (both **UNVERIFIED**).

### C.6 Implications for the portal

- **Consent UI:** separate unticked checkboxes per purpose:
  - (a) share my contact details with Bangladeshi exhibitors (an international transfer, highlighted);
  - (b) BBCCI marketing;
  - (c) photos and video;
  - (d) WhatsApp notifications.

  Version every consent text; log timestamp, text hash, locale, IP and user agent; one-click withdrawal in the profile.
- **Privacy centre:** download my data (JSON/PDF), correct, delete, revoke. Immediate confirmation; a 15-day SLA timer in the admin queue; BD 30-day correction notices.
- **Privacy notice** in PT-BR, EN and BN naming the **encarregado** (Res. 18/2024), legal bases, recipients and countries, retention table, and the international-transfer mechanism.
- **Hosting:** Brazil (`sa-east-1`) or EU (free flow since Jan 2026); ANPD SCCs with every processor outside BR/EU (e.g. US email or AI vendors). Data-processing addenda for SES, WhatsApp/Meta, the AI provider and payment gateways.
- **Incident runbook:** ANPD + data subjects within **3 working days**; Bangladesh Authority "prescribed time" (plan 72 h); incident register kept 5 years (a Filament resource).
- **Exhibitor compliance module:**
  - Declaring a product category of cosmetics, food, pharma or devices triggers ANVISA guidance: no sale of samples; no unregistered medicines; >30-day shelf life; PT labelling; 3-month lead time for devices.
  - A "Brazilian consignee / freight forwarder CNPJ" field.
  - A banner: "ATA Carnet currently not usable — goods enter under temporary admission via the organiser's forwarder".
  - A freight cut-off countdown (sea cargo booked ≥10 weeks before the event).

---

## D. Integrations

### D.1 Summary — recommended primary and fallback

| Integration | Primary | Fallback | Key gotcha |
|---|---|---|---|
| CNPJ lookup | **BrasilAPI** `GET https://brasilapi.com.br/api/cnpj/v1/{cnpj}` (free, no key) | **CNPJá** public `GET https://open.cnpja.com/office/{cnpj}` (5/min/IP), then ReceitaWS (3/min; errors come back as HTTP 200 with `"status":"ERROR"`) | **Alphanumeric CNPJ live since 31 Jul 2026** (IN RFB 2.229/2024): store as `CHAR(14)`, regex `^[A-Z0-9]{12}[0-9]{2}$`, mod-11 check with value = ASCII−48; validate locally before any API call; cache ≥30 days |
| CNPJ validation package | `robertol/laravel-validator-ptbr` 13.0.1 (illuminate ^6–^13; alphanumeric supported) | `laravellegends/pt-br-validator` 13.0.0 (alphanumeric support UNVERIFIED) | Masks must accept letters; no `inputmode="numeric"` |
| CEP lookup | **BrasilAPI CEP v2** `GET https://brasilapi.com.br/api/cep/v2/{cep}` (returns lat/long for the map) | **ViaCEP** `GET https://viacep.com.br/ws/{cep}/json/` (unknown CEP → `{"erro": true}`; bulk use can be blocked), then OpenCEP | AwesomeAPI now needs a key (100k/month free) |
| BD payments | **SSLCommerz** (cards, bKash, Nagad, Rocket, net banking) via `raziul/sslcommerz-laravel` v1.2.0 (L13 OK) or a thin in-house client | **aamarPay**; bKash Tokenized for small fees | **BDT 500,000 per transaction cap** (≈ one US$4k stall); must call the Validation API and check `tran_id`/amount/currency; USD is converted to BDT; `risk_level=1` means hold the order |
| Full-stall payments | **Proforma invoice → SWIFT/BEFTN to BBCCI's EBL account + proof upload + staff verification** | SSLCommerz split into 2 instalments | Bangladesh Bank FEPD Circular 26 (30 Jul 2026), Part-O: ERQ balances "may be used … for participation in export fairs … without prior approval" (https://www.bb.org.bd/mediaroom/circulars/fepd/jul302026fepd-126e.pdf) |
| BR payments | **Mercado Pago** (Pix + cards; `mercadopago/dx-php` 3.16) or **Efí** (Pix API 1.19%, boleto R$3.45; https://sejaefi.com.br/tarifas) — needs a Brazilian CNPJ | **Stripe Brazil** (cards 3.99% + R$0.39; Pix 1.19% but invite-only; boleto R$3.45 — https://stripe.com/br/pricing) | Without a Brazilian entity, cross-border Pix goes via EBANX/Stripe: customer pays 3.5% IOF, caps US$3k/day |
| International cards | Stripe (Brazilian entity only; **Bangladesh is not supported** — https://stripe.com/global) / SSLCommerz international cards | SWIFT invoice | PayPal still not available for Bangladesh-address accounts (Sep 2026) |
| FX rates | **Open Exchange Rates** (BDT+BRL; free 1k req/mo hourly) for display; **official** rates on invoices: BCB **PTAX** (USD/BRL) + **Bangladesh Bank** published rate (USD/BDT) | ExchangeRate-API (BDT supported; 1.5k free/mo) | **BDT is not in Frankfurter (ECB) or PTAX**; always snapshot the rate onto the invoice |
| Email | **Amazon SES (sa-east-1 São Paulo)**, $0.10/1k | **Postmark** via Laravel's native `failover` transport | Gmail rejects non-compliant mail since Nov 2025; Outlook.com requires SPF+DKIM+DMARC for >5k/day since 5 May 2025; separate transactional and marketing subdomains; RFC 8058 one-click unsubscribe on marketing |
| WhatsApp | **Meta Cloud API direct** via `netflie/whatsapp-cloud-api` 4.0 in a custom notification channel | BSP (360dialog / Zenvia) if a shared inbox is needed | Per-message pricing since 1 Jul 2025. Reported **1 Oct 2026 change**: service-window replies charged after 1,000 free/number/month; Bangladesh gets its own rate card (utility ≈ $0.0043, marketing ≈ $0.084; source is a BSP blog, **confirm on Meta's rate card**). **OTPs to +880 from a Brazil-registered WABA are billed at the international authentication rate (~$0.11)**, so send BD OTPs by SMS or email. https://developers.facebook.com/docs/whatsapp/pricing/ |
| SMS Bangladesh | **SSL Wireless** (masked sender ID) via `xenon/laravelbdsms` (multi-gateway) | Alpha SMS / BulkSMSBD | Sender IDs must be registered with Grameenphone/Robi/Teletalk; unregistered IDs blocked since 8 Sep 2025 (https://www.twilio.com/en-us/guidelines/bd/sms); Bangla = 70 chars per segment |
| SMS Brazil | **Twilio** ($0.0599/segment — https://www.twilio.com/pt-br/sms/pricing/br) via `laravel-notification-channels/twilio` 4.2 | Zenvia / Infobip | WhatsApp first in Brazil; SMS only as OTP fallback |
| Wallet badges | **spatie/laravel-mobile-pass** 1.11.1 (Apple **and** Google Wallet, push updates) | chiiya/passes 1.4.0 | Apple Developer Program $99/yr (org needs D-U-N-S); Google Wallet API free; Google Wallet in Bangladesh **UNVERIFIED**, so always also send a PDF/PNG QR |
| QR scanning (PWA) | **`barcode-detector` 3.2.2** polyfill (native BarcodeDetector where available, zxing-wasm elsewhere) | **qr-scanner** (nimiq) 1.4.2 | **html5-qrcode** is in maintenance mode (last npm release Apr 2023); native BarcodeDetector is disabled by default on iOS Safari (https://caniuse.com/mdn-api_barcodedetector); precache the .wasm; HMAC-sign QR payloads for offline validation |
| Maps | **MapLibre GL JS 6.15** + **OpenFreeMap** tiles (free, commercial OK) | MapTiler Flex ($30/mo) | Don't use tile.openstreetmap.org in production (https://operations.osmfoundation.org/policies/tiles/). Google Maps: $200 credit replaced by per-SKU free caps since 1 Mar 2025; **Maps Embed is free and unlimited**, good for the "directions" widget |
| 3D globe | **cobe 2.0.1** (~5 KB, arcs + markers) in the hero | **globe.gl 2.46.2** (three.js) lazy-loaded on the trade-routes page | Keep arcs in the low hundreds on mobile; static SVG fallback for reduced motion |
| Badge printing | **PrintNode** (cloud print; $9/mo for 5k prints — https://www.printnode.com/en/pricing) for staffed desks; **Chrome `--kiosk --kiosk-printing` + CSS `@page`** on a Brother QL-820NWB / Zebra ZD for self-print kiosks | **QZ Tray** (signed cert $599/yr) | Brother b-PAC is Windows-only; Zebra Browser Print supports ZPL on Zebra printers only |
| Video | YouTube **no-cookie behind a click-to-load facade** (lite-youtube-embed) | Bunny Stream (from $0.005/GB) / Cloudflare Stream ($5/1k min stored) | Facade + consent for LGPD |
| Translation | **DeepL** (EN↔PT-BR with glossaries; **Bengali supported**, no glossary for BN — https://developers.deepl.com/docs/getting-started/supported-languages.md) | LLM via `laravel/ai` (tone and glossary consistency) + Google Cloud Translation | Human "verified" flag for Bangla legal and contract text |
| PDF rendering | **Gotenberg 8.38** via spatie/laravel-pdf v2 | Cloudflare Browser Run / mPDF (OTL) | See F.3; **never dompdf for Bangla** |

### D.2 Notes per integration

- **BBCCI legal entities drive the payment design.** The 2025 circular shows a **Bangladeshi bank account** (EBL), so BBCCI can probably onboard SSLCommerz or bKash as a local merchant. Confirm its trade licence and whether the account is BDT or FCY. A **Brazilian CNPJ** is needed for Mercado Pago, Efí, PagBank or Asaas (Pix and boleto for Brazilian sponsors and buyers' paid services). If none exists, Brazilian payers pay by international card or SWIFT.
- **Instalments (50/50 like the competitor, and better):** use a payment schedule entity (deposit %, due dates, reminders, auto-suspend of stand hold on non-payment, credit notes). Each instalment stays below the SSLCommerz cap.
- **Reconciliation:** every gateway callback goes through `spatie/laravel-webhook-client` into a payments ledger (idempotent, signature-verified), and a nightly job reconciles against the gateway's transaction-query API. Staff verify bank-slip uploads with a 4-eyes approval in Filament.
- **CNPJ data → matchmaking:** the CNPJ response includes **CNAE** activity codes (primary and secondary). Use them to pre-seed Brazilian buyers' sector interests (e.g. CNAE 4642-7 wholesale of clothing → RMG exhibitors). The competitor only auto-fills the address.
- **CEP v2 coordinates** let you show buyers' distribution on an admin map and compute "buyers from outside São Paulo state" for hosted-buyer travel subsidies.

---

## E. Best-in-class trade-show platform features

### E.1 Who does what well (verified snapshot)

| Platform | Distinguishing capabilities | Source |
|---|---|---|
| **Swapcard** | AI-recommended leads with match reasons; in-app badge scanning with notes and ratings; CRM push; **Hosted Buyer & Smart Meetings** and an **Exhibitor Marketplace** (Jan 2026); exhibitor-profile translation; Apple Wallet badge (May 2025) | https://www.swapcard.com/blog/swapcard-unveils-hosted-buyer-smart-meetings-exhibitor-marketplace · https://www.swapcard.com/features/exhibitor-sponsor-tools |
| **ExpoPlatform** | AI matchmaking with 7 meeting formats incl. hosted-buyer and concierge; hosted-buyer dashboard (qualification, travel allowance, meeting quotas) | https://aidoos.com/products/expoplatform/ · https://international-confex.com/exhibitor-products/hosted-buyer-programme |
| **Map Your Show** | Floor-plan builder with compliance audit; booth sales; **"Ask Lina" AI agenda assistant** (May 2026) with route planning and offline wayfinding | https://www.mapyourshow.com/show-builder · https://www.mapyourshow.com/map-your-show-mys-connected |
| **a2z Events (Momentive)** | Interactive floor plan with online booth reservation; **Event Sales Engine** (Oct 2025): booth, sponsorship and add-ons in one checkout | https://momentivesoftware.com/products/a2z-events/ |
| **Cvent** | **LeadCapture** (scan, qualify, multi-staff, CRM export; ~US$249/device at one 2026 show); **OnArrival** self check-in and badge printing; RFID heat maps planned for Q4 2026 | https://www.cvent.com/en/onsite-solutions/lead-capture · https://vendelux.com/event-lead-capture/cvent-pricing |
| **Brella** | Mutual-consent meetings at **numbered tables** (vendor: +14% acceptance; 4-seat tables beat 2-seat) | https://help-organizers.brella.io/en/articles/191204-hosting-an-in-person-event-in-brella |
| **Grip** | Hosted-buyer module; **branded post-event insight reports for exhibitors** | https://roadmap.grip.events/grip-external-roadmap/introducing-branded-post-event-insights-reports-for-exhibitors |
| **Bizzabo Klik** | NFC SmartBadges: tap to exchange, passive tracking, gamification | https://www.bizzabo.com/pricing |
| **vFairs** | QR badging, bulk pre-print, self check-in; live speech translation via Wordly | https://wordly.ai/partners/vfairs-translation |
| **Canton Fair online** | 136th session: 3.75M products, ~450k online buyers, 986 exhibitor livestreams; intelligent matching, 1:1 chat, video-negotiation appointments | https://il.mofcom.gov.cn/chinafair/art/2025/art_1edfc4c694a64751b3c6d12a16850d73.html |
| **Hannover Messe** | EEN "Technology & Business Cooperation Days": free pre-scheduled 1:1 meetings plus online follow-up days | https://www.lzh.de/en/news/2026/business-matchmaking-companies-and-research-institutions |
| **Gulfood** | **Big Deal Hub**: pre-scheduled C-suite buyer–seller meetings. DWTC exhibitor services are ordered through the "Eventplus" portal (seen in another DWTC show's manual). | https://www.gulfood.com/big-deal-hub · https://www.gulfprintpack.com/exhibitor-manual |
| **Messe Frankfurt Nextrade** | Year-round B2B ordering marketplace | https://www.hfndigital.com/market-news/messe-frankfurt-goes-live-with-digital-product-order-platform |
| Hopin → RingCentral Events | Sold 2023; virtual-only events are shrinking, so hybrid is an add-on | https://tech.eu/2023/08/02/pandemic-era-unicorn-hopin-sells-off-tech-assets-to-cloud-communications-giant-ringcentral/ |

### E.2 Feature matrix — value for a ~100–300-exhibitor bilateral expo and Laravel effort

Effort for one senior Laravel developer: **S** ≤1 week · **M** 1–3 weeks · **L** 3–6 weeks · **XL** >6 weeks or needs hardware, legal or ops work. "Competitor" = present in the competitor's demo.

| # | Feature | Value (why) | Effort | Competitor |
|---|---|---|---|---|
| 1 | **AI B2B matchmaking + meeting scheduler** (fit score from sector, HS/NCM, CNAE, intent; mutual accept; slot booking; ICS; reminders) | **High**: meetings are why the expo exists | M–L | No |
| 2 | **B2B meeting-table management** (numbered tables, slot grid, table check-in, no-show flags) | **High** | M | No |
| 3 | **Hosted-buyer programme** (apply → qualify → benefits ↔ meeting quota) | **High**: brings out-of-state and LatAm buyers | L | No |
| 4 | **Interpreter booking PT↔BN↔EN** attached to meetings or booth half-days | **High; unique.** No reviewed platform has it natively; JETRO-style pre-ordering is done by email elsewhere (https://www.jetro.go.jp/austria/topics/SMTSFoodex2023.html) | M | No |
| 5 | **AI translation of profiles, products and chat** with a "human-verified" flag | **High**: all 300 profiles readable in PT from day one | S | Partial (manual trilingual) |
| 6 | **Interactive floor plan + online stand selection and purchase** (SVG, hold timer, pricing by size and corner) | **Med–High**; keep an admin-assign mode for association pavilions | L | No |
| 7 | **Exhibitor e-manual + deadlines + services ordering** (furniture, power, fascia, extra badges, catalogue entry; late surcharges) | **High**: turns a checklist into revenue | M | Checklist only |
| 8 | **Lead retrieval PWA** (scan, rate, note, custom questions, offline, CSV/CRM export) | **High**: top exhibitor-ROI tool and sellable | M | No |
| 9 | Visitor agenda builder (seminars, meetings, saved booths, ICS) | Med | S | No |
| 10 | **WhatsApp + Web Push notifications** | **High**: both countries live on WhatsApp | M | No (email only) |
| 11 | **PWA** (installable, offline badge, agenda and plan; camera scanning) | **High** | M | No |
| 12 | **Kiosk self check-in + on-demand badge print** | Med–High (no day-1 queues; less badge waste) | M + hardware | QR badge only |
| 13 | Access control / zone scanning (B2B lounge, VIP, seminar rooms) | Med | M | No |
| 14 | Live occupancy dashboard (Reverb) | Low–Med; cheap once #13 exists | S–M | No |
| 15 | Sponsorship inventory marketplace | Med (revenue) | M | No |
| 16 | **Post-event ROI report per exhibitor** (views, leads, meetings, RFQs, deals vs median) | **High**: drives rebooking and association subsidies | M | No |
| 17 | **Product catalogue with HS-6 → Brazilian NCM**, MOQ, FOB band, Incoterms, lead time, certifications | **High**: Brazilian importers think in NCM | M | Product list only |
| 18 | **RFQ / inquiry system** routed to matching exhibitors | **High**: keeps the platform alive all year | M | No |
| 19 | **Deal / spot-order outcome tracker** (both sides log the outcome and a USD estimate) | **High**: gives BBCCI the audited headline numbers it lacked in 2025 | S | No |
| 20 | Certificates of participation (3 languages, QR verification page) | Med (credentials; future visa files) | S | No |
| 21 | Surveys / NPS + one-tap post-meeting feedback | Med | S | No |
| 22 | Hybrid / livestream (embed) | Low–Med | S (embed) | No |
| 23 | Gamification (booth QR hunt, prize draw) | Low–Med | S–M | No |
| 24 | Networking chat (translated; consented WhatsApp hand-off) | Med | M | No |
| 25 | **Visa invitation letter generation** (per-person PDF, QR verification page, status tracker, auto-purge) | **High** | S–M | Visa desk + checklist (no letter generation shown) |
| 26 | **Trilingual AI concierge** (retrieval over e-manual, FAQ, directory, agenda) | Med–High (24/7 Bangla support) | M | No |
| 27 | Apple / Google Wallet badges | Med (premium, paperless) | M | No |
| 28 | Facial-recognition check-in | **Low; avoid.** Biometrics are sensitive data under LGPD; ANPD has been probing facial recognition at 23 football clubs since Feb 2025 (https://tecnoblog.net/noticias/anpd-ve-uso-irregular-de-reconhecimento-facial-nos-estadios/) | XL | No |
| 29 | NFC smart-badge wearables | Low (cost, privacy) | XL | No |
| 30 | Indoor turn-by-turn wayfinding | Low (single venue: zoomable plan + "you are here" is enough) | L | No |

### E.3 SaaS price benchmarks (to position a custom build)

| Platform | Public pricing signal |
|---|---|
| Bizzabo | from ~$17,999/yr ($499/user/month, 3-user minimum) — https://www.bizzabo.com/pricing |
| Swapcard | Annual licence + volume; Capterra lists $570–610/user/yr — https://www.capterra.com/p/234990/Swapcard/ |
| ExpoPlatform | Setup + modules from ~$4–6k — https://www.capterra.com/p/152898/ExpoPlatform/ |
| Brella | Quote only; unofficial €4–8k per mid-size event |
| Cvent | Median ~$19.5k/yr — https://www.vendr.com/marketplace/cvent ; LeadCapture ~$249/device |
| ExpoFP (floor plan + booth booking) | $149/mo DIY → $2,100 Pro — https://expofp.com/pricing |

**Positioning:** an equivalent SaaS stack (registration ~$18–20k + matchmaking ~€5k + floor plan ~$2k) costs about **US$25–30k per edition**, before lead-retrieval licences. None of the vendor pages reviewed advertised a Bangla UI, CNPJ/CEP lookup, Pix/boleto, or a Bangladesh visa workflow (verify per vendor before claiming this). A custom build is an owned, reusable, Bangla-first asset with data under BBCCI's LGPD control.

### E.4 2025–2026 trends worth citing

- AI matchmaking is now standard (Swapcard Jan 2026; ExpoPlatform 2026 trends report — https://www.financialcontent.com/article/thenewswire-2026-3-9-expoplatform-reports-47-increase-in-attendee-engagement-with-ai-solutions).
- AI concierges that take actions (MYS "Ask Lina", May 2026 — https://www.tsnn.com/event-tech/tech-trends-using-ai-to-improve-the-trade-show-experience).
- Self-serve exhibitor upsell storefronts (Swapcard Marketplace, a2z Sales Engine).
- Wallet badges becoming the norm (https://www.codereadr.com/blog/generating-apple-and-google-wallet-passes-what-ticketing-companies-and-event-organizers-need-to-know/).
- Paperless and print-on-demand badges as a sustainability claim.
- Biometrics under LGPD scrutiny: QR first, no face recognition.

---

## F. Laravel 13 ecosystem — verified versions (Packagist/npm, checked 2026-10-19)

**Method.** Versions and constraints below were pulled live from the Packagist metadata API (`https://repo.packagist.org/p2/{vendor}/{package}.json`) and the npm registry (`https://registry.npmjs.org/{pkg}/latest`) on 2026-10-19. "L13 OK" means the latest stable release declares `illuminate/*` or `laravel/framework` `^13.0` (or has no framework constraint at all).

### F.1 Framework baseline

| Item | Verified fact | Source |
|---|---|---|
| Laravel framework | **v13.37.0** (16 Oct 2026); 13.0.0 released **17 Mar 2026**; requires **PHP ^8.3** (supports 8.3–8.5); bug fixes until Q3 2027, security until 17 Mar 2028 | https://laravel.com/docs/13.x/releases · https://packagist.org/packages/laravel/framework |
| This repo | `composer.lock` already pins **laravel/framework v13.37.0**, Tailwind `^4`, Vite `^8`, laravel-vite-plugin `^3.1` | local `composer.lock`, `package.json` |
| L13 headline features useful to us | First-party **Laravel AI SDK** (`laravel/ai` v1.2.3, v1.0 shipped 23 Sep 2026): agents, embeddings, tools; **native vector search** (`whereVectorSimilarTo` on PostgreSQL + pgvector); first-party **JSON:API resources**; `PreventRequestForgery` origin-aware CSRF; `Queue::route()`; PHP attributes (`#[Middleware]`, `#[Authorize]`, `#[Tries]`…); `Cache::touch()` | https://laravel.com/docs/13.x/releases |
| Warning: local toolchain | The only PHP on this machine's PATH is **XAMPP PHP 8.2.12** — below Laravel 13's 8.3 floor and below the PHP 8.4 that several current Spatie packages and Pest 5 now require. Install PHP 8.4 (Laravel Herd for Windows or Laragon) before development; production must be PHP 8.4. | `php -v` on this machine |

### F.2 Package matrix

| Concern | Package | Latest stable (date) | Requires | L13? | Notes / recommendation |
|---|---|---|---|---|---|
| Admin panel | **filament/filament** | **v5.10.2** (13 Oct 2026); v5.0.0 released 16 Jan 2026 | PHP ^8.2, **livewire ^4.4.7**, illuminate ^11.28\|^12\|^13, Tailwind **v4.1+** | Yes | v5 = v4 feature set + Livewire 4 support; upgrade v4→v5 has no manual steps (https://laravel-news.com/filament-5). v4 line still maintained (v4.15.2, Livewire 3). **Use v5.** |
| Reactive UI | **livewire/livewire** | **v4.4.7** (28 Sep 2026); v4.0.0 14 Jan 2026 | illuminate ^10–^13 | Yes | Single-file components, islands, async actions, non-blocking requests (https://laravel-news.com/everything-new-in-livewire-4) |
| UI kit (optional) | livewire/flux | v2.20.1 | livewire ^3.7.4\|^4 | Yes | Paid "Pro" tier for advanced components |
| SPA alternative | inertiajs/inertia-laravel + @inertiajs/react or vue3 | **v3.5.1** / npm **3.9.1** (v3.0 released 24 Mar 2026) | laravel/framework ^11.35\|^12\|^13 | Yes | React 19.3.1 / Vue 3.5.44 current. Only worth it if a separate SPA team; Livewire 4 + Filament 5 keeps one stack. |
| CSS | tailwindcss | **4.3.3** (npm) | — | Yes | Filament 5 needs Tailwind ≥4.1 |
| JS sprinkles | alpinejs | **3.17.4** | — | Yes | Bundled with Livewire |
| Localisation strings | laravel-lang/common (+ lang 15.37.4, publisher 16.8) | 6.8.0 | publisher: illuminate ^10–^13 | Yes | Provides `pt_BR` and `bn` validation/auth strings |
| Localised URLs | mcamara/laravel-localization | **v2.4.2** (24 Aug 2026) | laravel/framework ^11\|^12\|^13 | Yes | `/en/…`, `/pt-br/…`, `/bn/…` prefixes, translated slugs, hreflang helpers. Alternative: a 30-line custom route-group middleware. |
| Translatable models | spatie/laravel-translatable | **6.15.0** (19 Oct 2026) | **PHP ^8.4**, illuminate ^12\|^13 | Yes | JSON columns per locale |
| Filament ↔ translatable | **lara-zeus/spatie-translatable** | 2.0.1 | filament ^5.0 | Yes | The official `filament/spatie-laravel-translatable-plugin` stopped at **v3.3.x** — do **not** use it with Filament 4/5 |
| DB-driven UI strings | spatie/laravel-translation-loader | 2.8.3 | illuminate/translation ^6–^13 | Yes | Lets BBCCI staff edit UI copy & email strings without deploys |
| Roles/permissions | **spatie/laravel-permission** | **8.3.0** (3 Jul 2026) | PHP ^8.3, illuminate ^12\|^13 | Yes | v6.25 also L13-compatible. Add **bezhansalleh/filament-shield 4.3.1** (filament ^4\|^5) for Filament policy UI |
| Audit trail | **spatie/laravel-activitylog** | **5.1.2** (19 Oct 2026) | **PHP ^8.4**, illuminate ^12\|^13 | Yes | v4.12.3 if stuck on PHP 8.3 |
| Audit (alt.) | owen-it/laravel-auditing | v14.0.6 | illuminate ^11–^13 | Yes | Better for strict per-attribute old/new diffs + IP/UA; pick **one** |
| Media | **spatie/laravel-medialibrary** | **11.23.9** (5 Oct 2026) | illuminate ^10.2–^13 | Yes | + filament/spatie-laravel-media-library-plugin v5.10.2 |
| Settings (event dates, fees in one place) | spatie/laravel-settings + filament/spatie-laravel-settings-plugin | 3.9.0 / v5.10.2 | illuminate ^11–^13 | Yes | Typed, cached settings edited in Filament → single source of truth for dates/venue/fees across site, emails, PDFs |
| Workflow states | spatie/laravel-model-states | 2.14.2 | **PHP ^8.4** | Yes | Application/payment/visa state machines with allowed transitions |
| DTOs | spatie/laravel-data | 4.23.0 | illuminate ^10–^13 | Yes | |
| PDFs | **spatie/laravel-pdf** | **2.14.0** (5 Oct 2026); v2.0 8 Feb 2026 | illuminate/contracts ^11–^13 | Yes | v2 is multi-driver: `browsershot`, `chrome` (chrome-php), `gotenberg`, `cloudflare` (Browser Run), `weasyprint`, `dompdf`; adds render caching, PDF encryption, queued generation (https://github.com/spatie/laravel-pdf, config/laravel-pdf.php) |
| PDF engine (Chromium) | spatie/browsershot | 5.4.1 (19 Oct 2026) | Node + Puppeteer + Chrome | n/a | |
| PDF (PHP) | barryvdh/laravel-dompdf → dompdf 3.1.6 | v3.1.2 | illuminate ^9–^13 | Yes | **Cannot shape Bangla** — see F.3 |
| PDF (PHP, OTL) | mpdf/mpdf | v8.3.1 (Mar 2026) | PHP ≤8.5 | Yes (no Laravel dep) | `carlos-meneses/laravel-mpdf` wrapper last released **Sep 2023** — use mPDF directly |
| Excel | **maatwebsite/excel** | **4.0.4** (12 Oct 2026); 4.0.0 13 Aug 2026 | PHP ^8.3, illuminate ^12\|^13, **PhpSpreadsheet ^5.9** | Yes | New major — check upgrade notes; 3.1.70 also L13-OK. For group-registration import of ≤1,000 rows, **spatie/simple-excel 3.10.0** (OpenSpout, streaming, low memory) is simpler. **pxlrbt/filament-excel 4.1.1** for admin exports |
| QR | **chillerlan/php-qrcode** | 6.0.1 (Filament 5 itself depends on **^5.0**) | PHP ^8.2 | Yes | Pin `^5.0` to share Filament's copy; SVG/PNG output, no GD needed for SVG |
| QR (alt.) | bacon/bacon-qr-code | v3.1.1 | PHP ^8.1 | Yes | Already pulled in by laravel/fortify (^3.0) |
| QR (alt.) | endroid/qr-code | 6.1.3 | **PHP ^8.4** | Yes | Logo-in-QR, labels |
| QR (AVOID) | simplesoftwareio/simple-qrcode | **4.2.0 — last release Feb 2021** | **bacon/bacon-qr-code ^2.0** | Conflict | **Conflicts** with Fortify's bacon ^3 and is unmaintained. Don't use. |
| Queues | laravel/horizon | v5.50.1 | illuminate ^9.21–^13 | Yes | Redis queues: emails, PDFs, WhatsApp, imports |
| Realtime | laravel/reverb + laravel-echo 2.6.1 | v1.12.0 | illuminate ^10.47–^13 | Yes | Live check-in counters, admin notifications, meeting-request pings |
| Search | laravel/scout | v11.9.0 | illuminate ^9–^13 | Yes | `database` driver is enough for ~300 exhibitors; Meilisearch PHP SDK v1.17.0 stable (v2.0 in beta). Consider L13 native **pgvector** semantic search for cross-language matching |
| SEO meta | artesaos/seotools | v1.4.1 | illuminate ^10–^13 | Yes | |
| Structured data | spatie/schema-org | 5.0.2 | **PHP ^8.4** | Yes | `Event`, `ExhibitionEvent`, `Organization`, `Place`, `Offer` JSON-LD |
| Sitemap | spatie/laravel-sitemap | 8.2.0 | **PHP ^8.4**, illuminate ^12\|^13 | Yes | Multi-locale `<xhtml:link hreflang>` |
| Backups | spatie/laravel-backup | 10.3.3 | illuminate **^12.40**\|^13 | Yes | DB + encrypted vault to off-site S3 |
| Health | spatie/laravel-health | 1.40.2 | Yes | Yes | Queue/cron/disk/Reverb checks |
| Monitoring | laravel/pulse | v1.8.1 | Yes | Yes | Self-hosted dashboard |
| Monitoring (SaaS) | laravel/nightwatch | v1.30.4 (18 Oct 2026) | Yes | Yes | Free plan 300k events/mo, Pro $20/mo (https://nightwatch.laravel.com/pricing) |
| Security headers | spatie/laravel-csp | 3.29.0 | Yes | Yes | |
| Spam | spatie/laravel-honeypot | 4.7.3 | Yes | Yes | Plus Cloudflare Turnstile on public forms |
| Cookie banner | spatie/laravel-cookie-consent | 3.5.0 | Yes | Yes | Too basic for LGPD granular categories — build own banner (see C) |
| Auth | laravel/fortify 1.41.0 (pulls **laravel/passkeys ^0.2**) | Yes | | Yes | Passkeys + TOTP 2FA for staff/exhibitors; spatie/laravel-one-time-passwords 1.1.2 (PHP 8.4) for email-OTP login of visitors |
| Phone validation | propaganistas/laravel-phone | 6.1.0 | Yes | Yes | E.164 for BD (+880) & BR (+55) — needed for WhatsApp/SMS |
| Webhooks in | spatie/laravel-webhook-client | 3.7.0 | Yes | Yes | SSLCommerz IPN, Stripe, Mercado Pago, WhatsApp |
| Slugs/tags | spatie/laravel-sluggable 4.0.4, spatie/laravel-tags 4.12.0 | Yes | | Yes | Sector/product tagging |
| Images | intervention/image-laravel | 4.1.1 | Yes | Yes | Badge photos, logo normalisation |
| Wallet passes | **spatie/laravel-mobile-pass** | **1.11.1** (28 Sep 2026); 1.0 Apr 2026 | PHP ^8.3, illuminate ^12\|^13, pkpass, firebase/php-jwt | Yes | Generates **Apple Wallet and Google Wallet** passes and pushes updates (README) |
| Wallet passes (alt.) | chiiya/passes | 1.4.0 | no Laravel dep | Yes | Lower-level Apple+Google |
| AI | **laravel/ai** | v1.2.3 | illuminate ^12\|^13 | Yes | Matchmaking embeddings, profile translation, concierge chatbot; prism-php/prism v0.102 is the alternative |
| Testing | **pestphp/pest** | **v5.3.3** (v5.0.0 24 Jul 2026) | **PHP ^8.4, PHPUnit ^13.4** | Yes, via pest-plugin-laravel **v5 (needs laravel/framework ^13.23)** | Browser testing: pest-plugin-browser **v5.1.2** (Playwright). The repo currently pins **phpunit ^12.5** → either stay on **Pest 4.7.8** (PHPUnit 12, PHP 8.3, plugin-laravel 4.1 supports L13) or bump PHPUnit to 13 and use Pest 5 |
| Debug | barryvdh/laravel-debugbar v4.4.4, laravel/telescope v5.26.0 | Yes | | Yes | |
| AI dev tooling | laravel/boost v2.10.3, laravel/mcp v1.0.2 | Yes | | Yes | |

**Not Laravel-13-compatible / avoid:**
- `simplesoftwareio/simple-qrcode` (2021, bacon ^2 conflict).
- `filament/spatie-laravel-translatable-plugin` (Filament 3 only) → use `lara-zeus/spatie-translatable`.
- `soarecostin/file-vault` (last release Nov 2020, illuminate ≤8) and `brainstud/file-vault` (2022, illuminate ≤9) → write a small envelope-encryption service instead (F.4).
- `carlos-meneses/laravel-mpdf` (stale since 2023; works only because it has no illuminate constraint) → call mPDF directly.
- PHP-8.4-only packages (laravel-translatable 6.15, activitylog 5, schema-org 5, sitemap 8, model-states 2.14, query-builder 7, responsecache 8, endroid/qr-code 6, Pest 5): fine on PHP 8.4, but **will not install on PHP 8.3** — another reason to standardise on 8.4.

### F.3 Bangla PDF rendering — what actually works

**The problem.** Bangla requires OpenType *shaping* (GSUB/GPOS: reph `র্`, ya-phala `্য`, ra-phala `্র`, conjuncts like `ক্ষ`, `ন্ত`, pre-base vowel signs `ি`, `ে`, `ৈ` reordered before the consonant). Without a shaping engine the text is "Unicode-correct but visually broken".

| Engine | Bangla result | Evidence |
|---|---|---|
| **dompdf** (incl. barryvdh/laravel-dompdf, spatie/laravel-pdf `dompdf` driver) | **Broken**: conjuncts and vowel order wrong. No shaping engine; maintainers' umbrella issue "Support complex text layout (bidi, shaping, ordering)" is **still open**, with Bengali shaping unchecked; maintainer (Sep 2025): "Nothing yet." | https://github.com/dompdf/dompdf/issues/2619 · https://github.com/dompdf/dompdf/issues/3179 · https://github.com/dompdf/dompdf/issues/2627 |
| **mPDF 8.x** with OTL | **Mostly correct**: mPDF implements OpenType Layout incl. Indic `rphf rkrf half vatu cjct cfar`, supports the v2 `bng2` script tag; must set `useOTL => 0xFF` on the font and enable `autoScriptToLang`/`autoLangToFont`. Edge cases differ from HarfBuzz ("different shaping engines… can produce different results"); limited CSS (no flex/grid). Users who failed with dompdf report success with mPDF. | https://mpdf.github.io/fonts-languages/opentype-layout-otl.html · https://github.com/dompdf/dompdf/issues/3179 |
| **Chromium** (Browsershot, chrome-php, **Gotenberg**, Cloudflare Browser Run) | **Correct**: Chromium shapes with **HarfBuzz**; full modern CSS (grid/flex), identical to what the user sees in the browser. | https://github.com/spatie/laravel-pdf |
| **WeasyPrint** (Pango/HarfBuzz) | **Correct** shaping; excellent CSS Paged Media (running headers, page counters) | https://github.com/spatie/laravel-pdf |
| TCPDF | **Broken**: no Indic shaping | — |

**Recommendation.**
1. `spatie/laravel-pdf` v2 with the **Gotenberg** driver in production (one Docker container `gotenberg/gotenberg:8` — 8.38.1 published 15 Oct 2026, with a slimmer `-chromium` variant (https://hub.docker.com/r/gotenberg/gotenberg/tags) — called over HTTP: no Node/Chrome on the PHP box, scales independently; the full image also converts DOCX→PDF via LibreOffice). Use the `chrome`/`browsershot` driver locally. If the host can't run Docker, switch the **same Blade templates** to the `cloudflare` driver (Browser Run: 10 browser-minutes/day free; Workers Paid includes 10 browser-hours/month, then $0.09/hour — https://developers.cloudflare.com/changelog/2025-07-28-br-pricing/).
2. Embed the Bangla font with `@font-face` (self-hosted WOFF2/TTF — Noto Sans Bengali, Hind Siliguri or Anek Bangla) rather than relying on fonts installed in the container; set `lang="bn"` on Bangla blocks.
3. Fallback only if no Chromium is possible at all: mPDF with `useOTL => 0xFF` + Noto Sans Bengali.
4. Add a **golden-file test**: render a PDF containing "রপ্তানি, বাণিজ্য, ক্ষুদ্র, স্ট্রিট, র‍্যাব, কর্মী, ব্র্যান্ড, প্রদর্শনী" and diff text/images with `pdftotext` + snapshot — so a driver change can never silently regress invoices, contracts and visa invitation letters.
5. Same rule for **email**: Bangla in HTML email is shaped by the mail client — fine; but never rasterise Bangla through GD/Imagick (no shaping) for badge images — render badges as HTML/SVG→PDF via Chromium.

### F.4 Encryption at rest for the document vault (passports, trade licences)
- No maintained Laravel-13 "file vault" package exists (above). Implement a ~150-line **envelope-encryption** service: per-file random key → libsodium `sodium_crypto_secretstream_xchacha20poly1305_*` streaming encryption (built into PHP), per-file key wrapped with the app key (or AWS KMS / a dedicated `VAULT_KEY`, rotated) and stored in the DB row; plus storage-level encryption (S3 SSE-KMS / Cloudflare R2 encryption).
- Serve decrypted files only through an authorised controller with short-lived signed URLs and `activity()` logging of every view/download; auto-purge visa documents N days after the event (scheduled job) — matches LGPD necessity/retention principles.

### F.5 Suggested architecture
- **Monolith**: Laravel 13 + Livewire 4 (public site & portals) + Filament 5 (BBCCI console, association portal as a 2nd Filament panel, exhibitor portal as a 3rd panel or Livewire).
- **DB**: PostgreSQL 17/18 (pgvector for semantic matchmaking/search; JSONB for translations) or MySQL 8.4 if hosting dictates (lose native vector search).
- **Redis** (queues, cache, sessions, Horizon), **Reverb** (websockets), **Gotenberg** (PDF), S3-compatible storage (R2/S3) with CDN.
- **Hosting**: Laravel Cloud or Forge + a VPS in São Paulo (`sa-east-1`) or a BD-latency-friendly region; Cloudflare in front (WAF, Turnstile, cache).

---

## G. UI/UX direction

### G.1 What premium event sites look like (2025–2026)

| Reference | Pattern worth borrowing | Source |
|---|---|---|
| **OFFFForum** (Awwwards SOTD, 16 Oct 2026) | Massive all-caps title block, one dominant CTA, visible language toggle, **granular consent categories** | https://www.awwwards.com/sites/offfforum |
| **Web Summit** | **Audience-split IA** (Attendees / Exhibitors / Startups / Investors / Media); dual CTA "Book tickets / Exhibit"; video hero with play/pause/mute; **logo walls grouped by role**; no giant countdown | https://websummit.com/ |
| Awwwards "Events" 2026 honourable mentions | Hack the North, Design Bomb Festival, Frontier Dialogues, Le Mans Classic: kinetic type, bento grids, dark mode | https://www.awwwards.com/websites/events/ |
| Next.js Conf / Vercel Ship (basement.studio) | One identity across web, badge, stage and print | https://basement.studio/showcase/nextjs-conf-raising-the-bar-again |
| Figma Config 2026 | Multi-edition hub (SF + India) with recordings archive: fits future São Paulo and Dhaka editions | https://config.figma.com/ |
| Salone del Mobile (2025 redesign) | Trade fairs prioritise navigation and findability over spectacle | https://www.salonemilano.it/en/articoli/sito-salone-del-mobile |
| Expo 2025 Osaka | A **generative brand motif** that runs through every touchpoint | https://en.wikipedia.org/wiki/Myaku-Myaku |

**Recurring patterns:** kinetic display type on the hero only; bento stat grids; dark-first palettes; logo marquees (with a pause control, WCAG 2.2.2); video heroes with controls; sticky day-tabbed schedules; small countdown chips; scroll storytelling (here: **Dhaka → Chattogram → Santos → São Paulo**); at most one WebGL moment. A mid-2026 trend review calls kinetic type "more polish than substance; use on hero only" (https://studiomeyer.io/en/blog/webdesign-trends-2026-reality-check).

**Proposed homepage order:** hero (trilingual tagline, dates, venue; CTAs *Visit as buyer* / *Exhibit*) → stats bento (exhibitors, sectors, meetings booked, deals) → sectors grid → featured exhibitors and products → "B2B meetings + interpreters" explainer → seminar agenda → partners by role → São Paulo guide → FAQ + WhatsApp help.

**Brand-motif idea:** a geometric system derived from **Jamdani weaving** (a UNESCO-listed Bangladeshi textile craft) crossed with **Brazilian modernist** geometry (Burle Marx pavements, Athos Bulcão tiles). Use it as patterns on web, badges, stand fascia and certificates, never as flags.

### G.2 Motion stack (versions verified on npm, 19 Oct 2026)

- **GSAP 3.15.0**: free for commercial use including all former Club plugins (SplitText, MorphSVG…) since 3.13 (30 Apr 2025, after the Webflow acquisition) — https://gsap.com/blog/3-13/ . The licence only excludes competing no-code builders (https://gsap.com/standard-license). **Never split Bangla by characters** (it breaks grapheme clusters and conjuncts). Split by words or lines only.
- **ScrollTrigger**: pinned trade-route story and scrubbed counters.
- **Lenis 1.3.27**: respects `prefers-reduced-motion` by default since 1.3.26. Use it **only on marketing pages**, never in portals or forms. Sync: `lenis.on('scroll', ScrollTrigger.update)` and `gsap.ticker.add(t => lenis.raf(t*1000))`.
- **View Transitions:** same-document in Chrome/Edge 111, Safari 18.0, Firefox 144 (~93%). Cross-document `@view-transition` in Chrome 126 and Safari 18.2, partial in Firefox 144 (~89%); it is an Interop 2026 focus area (https://caniuse.com/cross-document-view-transitions · https://hacks.mozilla.org/2026/02/launching-interop-2026/). A Blade multi-page app gets these as progressive enhancement. Wrap in `@media (prefers-reduced-motion: no-preference)`.
- Provide a site-level "Reduce motion" toggle and pause buttons for marquees and video.

### G.3 Typography for EN / PT / BN

| Font | Axes / weights | Latin included? | Verdict |
|---|---|---|---|
| **Anek Bangla** (Ek Type) | Variable wdth 75–125, wght 100–800 | Yes | Best **display** face; condensed widths suit kinetic heroes; one family across scripts |
| **Noto Sans Bengali** (Google) | Variable wdth 62.5–100, wght 100–900 | Yes | Best **body and UI** face; robust shaping |
| Noto Serif Bengali | Variable wdth/wght | Yes | Serif body and bold fallback for Tiro |
| **Tiro Bangla** (Tiro Typeworks) | 400 + italic only | Yes | Elegant editorial display; build hierarchy with size |
| Hind Siliguri (ITF) | 300–700 static | Yes | Proven but dated workhorse |
| Baloo Da 2 (Ek Type) | Variable wght 400–800 | Yes | Friendly and rounded; less premium |
| Galada / Atma / Mina | Display or compact | Yes | Accents only |

Sources: Google Fonts METADATA, e.g. https://raw.githubusercontent.com/google/fonts/main/ofl/anekbangla/METADATA.pb · https://raw.githubusercontent.com/google/fonts/main/ofl/notosansbengali/METADATA.pb

**Recommended pairings:**
1. **"Unified grotesk" (recommended):** Anek Bangla for display in all three languages (wdth 75–87.5 for heroes) + **Inter** / **Noto Sans Bengali** for body.
2. **"Editorial premium":** Instrument Serif or Fraunces + Tiro Bangla for display; Manrope + Noto Sans Bengali for body.
3. **"Warm market":** Baloo Da 2 display + Hind Siliguri / Inter body.

**Rules:**
- In `:lang(bn)`: body line-height **1.7–1.8**, headings 1.25–1.35, size about **1.06–1.125×** the Latin size.
- No letter-spacing on Bangla (it breaks the matra).
- **Self-host** the fonts (an IP-leak and LGPD hygiene point).
- Per-script `@font-face` with Bengali `unicode-range: U+0951-0952, U+0964-0965, U+0980-09FE, U+200C-200D, U+25CC`; `font-display: swap`; preload the Bengali subset only on `/bn` routes.
- **Numerals:**
  - `Intl.NumberFormat('bn-BD')` gives ১২,৩৪,৫৬৭.৮৯ (lakh grouping); dates give e.g. বুধবার, ১২ মে, ২০২৭. Use Bangla digits in copy and stats, Latin digits in booth numbers, phone, CNPJ and passport fields.
  - **Normalise ০–৯ → 0–9 server-side** on all numeric inputs.
  - PHP side: `NumberFormatter('bn_BD')` / `Number::format(..., locale: 'bn')`.

### G.4 Colour — the two flags blended, without looking like a flag

Reference: BD green #006A4E, BD red #F42A41; BR green #009C3B, yellow #FFDF00, blue #002776. Contrast ratios use the WCAG 2.x formula.

**Palette A — "Delta Night"** (dark-first marketing site)

| Role | Hex | Contrast |
|---|---|---|
| Background | Midnight **#071A33** (deepened Brazil blue) | — |
| Surface | #0B1F3A | — |
| Text | Paper **#F7F5EF** | 15.99:1 |
| Muted | #94A3B8 | 6.80:1 |
| Primary interactive | Mint **#3DDC97** (lifted BD green) | 9.86:1; navy text on mint 9.86:1 |
| Accent / focus / countdown | Ipê yellow **#FFDF00** | 13.12:1 on bg |
| Live / alert | Coral **#FF5A6E** (softened BD red) | 5.76:1 |

Avoid in this palette: BD green #006A4E on navy (2.63:1) and raw BD red #F42A41 on #0B1F3A (4.13:1). Both fail for text.

**Palette B — "Jute & Ipê"** (light; portals, forms, PDFs)

| Role | Hex | Contrast |
|---|---|---|
| Surface | Jute cream **#FBF7EE** | — |
| Text | Ink **#1F2A44** | 13.33:1 |
| Headings / links | Brazil navy **#002776** | 12.66:1 |
| Primary buttons | Bottle green **#004F3A** | 9.01:1 on cream; white on it 9.64:1 |
| Alt primary | BD green **#006A4E** | white on it 6.62:1 |
| Gold text | #7A5C00 | 5.85:1 |
| Yellow #FFDF00 | **Fills only**, with navy text (10.19:1) | — |
| CTA / live | Crimson **#B3122A** | 6.47:1; white on it 6.92:1 |
| Muted | #5B6573 | 5.53:1 |
| Input borders | #8C8574 | 3.43:1 (meets the 3:1 non-text minimum) |

Hard fails: **#FFDF00 on white 1.33:1**; white on BR green #009C3B 3.61:1 (large text only); BD red on white 4.00:1. Focus ring on light surfaces: 2px #002776 outline with an optional yellow halo.

### G.5 Accessibility targets

WCAG **2.2 AA**, and Brazil's **ABNT NBR 17225:2025** (based on WCAG 2.2 A/AA; published Mar 2025 — https://teletime.com.br/11/03/2025/abnt-lanca-norma-para-aprimorar-a-acessibilidade-de-sites/). The **LBI (Lei 13.146/2015) Art. 63** requires accessible sites for companies headquartered or represented in Brazil (https://www.mpf.mp.br/o-mpf/unidades/pr-sp/noticias/mpf-recomenda-regulamentacao-de-trecho-da-lei-brasileira-de-inclusao-sobre-acessibilidade-na-internet). eMAG 3.1 is legacy (federal bodies only). **Pitch hook:** São Paulo's municipal **Selo de Acessibilidade Digital** audits against NBR 17225, and CNPJ holders can apply (https://prefeitura.sp.gov.br/web/pessoa_com_deficiencia/w/selo_de_acessibilidade_digital/250221). Target it for launch.

WCAG 2.2 new criteria applied to the multi-step forms, portals and scheduler (https://www.w3.org/WAI/standards-guidelines/wcag/new-in-22/):

- **2.4.11 Focus Not Obscured:** the sticky header, sticky Next/Back bar, cookie banner and chatbot bubble must never cover a focused field. Use `scroll-padding`.
- **2.5.7 Dragging Movements:** the floor plan, product reorder, drag-and-drop uploads and calendar all need single-pointer alternatives (zoom buttons, list view of stands, "Choose file", up/down buttons).
- **2.5.8 Target Size 24×24 px:** stepper dots, slot chips, close icons, language switcher. Small booths use the accessible list-view exception.
- **3.2.6 Consistent Help:** Help, WhatsApp and chatbot stay in the same place on every step.
- **3.3.7 Redundant Entry:** CNPJ/CEP auto-fill, "billing same as company", staff badges inherit company data, Excel import, save and resume.
- **3.3.8 Accessible Authentication:** no puzzle CAPTCHAs (Turnstile or honeypot); allow paste and password managers; offer passkeys or magic links.
- Also: errors in the active language linked by `aria-describedby`; `aria-current="step"`; warn before session timeout (2.2.1).
- **Language markup:** `lang="en" | "pt-BR" | "bn"` per route. Switcher items in their own language with `lang` (WCAG 3.1.2). Inline `lang` on mixed content. `hreflang` en / pt-BR / bn-BD + `x-default`.

---

## Recommendations

### R.1 Recommended stack and packages (versions verified 19 Oct 2026)

| Layer | Choice | Version / constraint |
|---|---|---|
| Runtime | **PHP 8.4** (upgrade dev machines from XAMPP 8.2.12) | Laravel 13 needs ≥8.3; several packages need 8.4 |
| Framework | **laravel/framework** | ^13.37 (13.0 released 17 Mar 2026; security fixes to 17 Mar 2028) |
| Public site + portals | **Livewire 4** + Blade + Alpine | livewire/livewire ^4.4.7, alpinejs 3.17 |
| Admin / association / exhibitor back-office | **Filament 5** (3 panels: BBCCI console, Association, Exhibitor) | filament/filament ^5.10 |
| CSS / build | Tailwind CSS 4 + Vite 8 | tailwindcss ^4.3, vite ^8.3, laravel-vite-plugin ^3.2 |
| i18n | mcamara/laravel-localization ^2.4 · spatie/laravel-translatable ^6.15 · lara-zeus/spatie-translatable ^2.0 (Filament) · laravel-lang/common ^6.8 · spatie/laravel-translation-loader ^2.8 | |
| Settings (single source of truth for dates, venue, fees) | spatie/laravel-settings ^3.9 + filament/spatie-laravel-settings-plugin ^5.10 | |
| Auth | laravel/fortify ^1.41 (passkeys via laravel/passkeys ^0.2, TOTP) · spatie/laravel-one-time-passwords ^1.1 | |
| Roles | spatie/laravel-permission ^8.3 + bezhansalleh/filament-shield ^4.3 | |
| Audit | spatie/laravel-activitylog ^5.1 (or owen-it/laravel-auditing ^14 — pick one) | |
| Workflow | spatie/laravel-model-states ^2.14 | |
| Media | spatie/laravel-medialibrary ^11.23 + filament media plugin ^5.10 · intervention/image-laravel ^4.1 | |
| PDFs | **spatie/laravel-pdf ^2.14** with **Gotenberg 8.38** driver (prod), chrome/browsershot (dev) | mPDF ^8.3 fallback; no dompdf for Bangla |
| Excel | spatie/simple-excel ^3.10 (imports) · maatwebsite/excel ^4.0 or pxlrbt/filament-excel ^4.1 (exports) | |
| QR | chillerlan/php-qrcode ^5 (shared with Filament) | not simplesoftwareio/simple-qrcode |
| Wallet | spatie/laravel-mobile-pass ^1.11 | |
| Queues / realtime | Redis + laravel/horizon ^5.50 · laravel/reverb ^1.12 + laravel-echo 2.6 | |
| Search / AI | laravel/scout ^11.9 (database driver) → PostgreSQL + pgvector semantic search · **laravel/ai ^1.2** (matchmaking embeddings, translation, concierge) | |
| SEO | artesaos/seotools ^1.4 · spatie/schema-org ^5.0 · spatie/laravel-sitemap ^8.2 | |
| Security | spatie/laravel-csp ^3.29 · spatie/laravel-honeypot ^4.7 + Cloudflare Turnstile · L13 `PreventRequestForgery` | |
| Webhooks | spatie/laravel-webhook-client ^3.7 | |
| Validation | propaganistas/laravel-phone ^6.1 · robertol/laravel-validator-ptbr ^13.0 (alphanumeric CNPJ) | |
| Ops | spatie/laravel-backup ^10.3 · spatie/laravel-health ^1.40 · laravel/pulse ^1.8 · laravel/nightwatch ^1.30 (free 300k events/mo) | |
| Tests | **Pest 5.3 + pest-plugin-browser 5.1** (PHP 8.4, PHPUnit 13), or Pest 4.7 if staying on PHPUnit 12 | |
| Front-end libs | GSAP 3.15 · Lenis 1.3.27 · cobe 2.0.1 · globe.gl 2.46 (lazy) · MapLibre GL 6.15 · barcode-detector 3.2.2 | |
| Infra | PostgreSQL 17/18 · Redis · S3/R2 (+ envelope encryption) · Gotenberg container · Cloudflare (WAF, CDN, Turnstile) · SES sa-east-1 | |

### R.2 Recommended integrations (primary → fallback)

Summarised in **D.1**. Headline choices: BrasilAPI → CNPJá/ReceitaWS (CNPJ); BrasilAPI v2 → ViaCEP (CEP); **bank transfer + proof** and **SSLCommerz** → aamarPay/bKash (BD); Mercado Pago or Efí → Stripe BR (BR, *if* a Brazilian CNPJ exists); Open Exchange Rates + official PTAX/Bangladesh Bank snapshots; **SES** → Postmark; **WhatsApp Cloud API direct** → BSP; SSL Wireless → Alpha SMS (BD); Twilio (BR); spatie mobile-pass; barcode-detector → qr-scanner; MapLibre + OpenFreeMap → MapTiler; cobe → globe.gl; PrintNode + Chrome kiosk printing → QZ Tray; YouTube facade → Bunny Stream; DeepL + LLM → Google Translate; Gotenberg → Cloudflare Browser Run → mPDF.

### R.3 Top 15 premium features (beyond the competitor), ranked by value ÷ effort

| Rank | Feature | Value | Effort | Why it wins the pitch |
|---|---|---|---|---|
| 1 | **Deal / spot-order outcome tracker + live results dashboard** | High | S | BBCCI had no audited 2025 numbers; this produces the press-release figures |
| 2 | **AI translation EN↔PT↔BN with "human-verified" badge** (DeepL + `laravel/ai`) | High | S | Every profile and product readable by Brazilian buyers on day one |
| 3 | **Visa invitation letters**: per-delegate PDF, QR verification page for the embassy, status tracker, auto-purge | High | S–M | Upgrades the competitor's checklist-only visa desk |
| 4 | **AI B2B matchmaking + meeting scheduler** (CNAE codes from CNPJ × HS/NCM from exhibitors; pgvector) | High | M | Core value of a bilateral expo |
| 5 | **B2B lounge table management** (numbered tables, slot grid, check-in, no-shows) | High | M | Onsite execution of #4 |
| 6 | **Interpreter booking (PT↔BN↔EN)** tied to meetings and booths | High | M | No reviewed platform has it natively |
| 7 | **Lead-retrieval PWA** (offline scan, notes, rating, CSV/HubSpot export) | High | M | A sellable exhibitor add-on |
| 8 | **WhatsApp + Web Push notifications** (meeting reminders, badge, payment, visa status) | High | M | Fewer no-shows; the channel both countries use |
| 9 | **Product catalogue with HS→NCM mapping + RFQ inbox** | High | M | Turns the directory into a year-round sourcing tool |
| 10 | **Exhibitor ROI report** (branded PDF + dashboard, benchmarks vs median) | High | M | Drives rebooking and association subsidies |
| 11 | **Services ordering e-manual** (furniture, power, extra badges, late surcharges) | High | M | Extends the checklist into revenue |
| 12 | **Kiosk self check-in + on-demand badge print + Apple/Google Wallet passes** | Med–High | M | Premium onsite feel; paperless claim |
| 13 | **Trilingual AI concierge** (retrieval over FAQ, e-manual, directory) | Med–High | M | 24/7 Bangla support across a 9–10 h time-zone gap |
| 14 | **Unified agenda builder** + certificates of participation (QR-verified) | Med | S | Low cost, visible polish |
| 15 | **Interactive floor plan with stand selection and holds** (admin-assign mode for pavilions) | Med–High | L | Visible "beyond" feature; ExpoFP-class without a licence |

Next tier: hosted-buyer programme (High/L), sponsorship marketplace, zone access control with live occupancy, surveys/NPS, gamification. **Not recommended:** facial recognition, NFC wearables, indoor turn-by-turn wayfinding.

### R.4 Compliance checklist

| # | Item | Regime | Portal mechanism |
|---|---|---|---|
| 1 | Appoint and **publish the encarregado (DPO)** with a formal signed act and substitute | LGPD Art. 41, Res. 18/2024 | Footer and privacy-notice block driven by settings |
| 2 | Map legal basis per data field and purpose (contract / consent / legitimate interest + LIA / legal obligation) | LGPD Art. 7; BD PDPA | Data inventory (ROPA) kept as a Filament resource |
| 3 | **Granular, unticked, versioned consents** with proof log and one-click withdrawal | LGPD Art. 8; BD PDPA | `consents` table (purpose, text version hash, locale, IP, UA, timestamps) |
| 4 | **Highlighted specific consent / contract basis for international transfer** of buyer data to Bangladeshi exhibitors | LGPD Art. 33 VIII/IX, Res. 19/2024 | Separate checkbox + explanation in PT |
| 5 | ANPD **SCCs** in contracts with processors outside BR/EU (email, AI, analytics, WhatsApp) | Res. 19/2024 (since 23 Aug 2025) | Vendor register with DPA/SCC status |
| 6 | Opt-in **two-level cookie banner**; Accept and Reject equally prominent; no non-essential cookies before consent; reopen link | ANPD cookie guide 2022; Planet49 | Custom Livewire banner + consent log; self-hosted fonts; YouTube/maps facades |
| 7 | **Data-subject rights centre** (access/export, correction, deletion, revocation, sharing info); 15-day SLA; BD 30-day correction notice | LGPD Arts. 18–19; BD PDPA | Self-service + admin queue with SLA timers |
| 8 | Trilingual **privacy notice** (purposes, bases, recipients, countries, retention, rights, DPO) | LGPD Art. 9; BD PDPA | CMS page versioned in `spatie/laravel-translatable` |
| 9 | **Retention schedule + automatic purge** (passport/visa docs N days after event; badges/scans after reporting; invoices kept per tax law) | LGPD Arts. 15–16; BD PDPA | Scheduled jobs + `activitylog` of purges |
| 10 | **Encryption at rest** for the document vault (envelope encryption), TLS everywhere, MFA/passkeys for staff, least-privilege roles | LGPD Art. 46; BD PDPA | Vault service, Fortify 2FA/passkeys, spatie/permission, Filament Shield |
| 11 | **Audit trail** of access to personal data and documents (view/download/export) | LGPD Arts. 37, 46 | spatie/laravel-activitylog on models + file controller |
| 12 | **Incident response**: ANPD + subjects ≤3 working days; BD Authority in prescribed time (plan 72 h); incident register kept 5 years | Res. 15/2024; BD PDPA | Runbook + Filament incident register + notification templates |
| 13 | **RIPD / DPIA** for AI matchmaking (profiling) and any biometric idea (avoid biometrics) | LGPD Art. 38 | Document; human-in-the-loop for matches; opt-out of profiling |
| 14 | Minimise BD "restricted" data (no NID, biometrics, bank details) to avoid localisation duties; get local counsel's view | BD PDPA 2026 (+ Feb 2026 amendment) | Form design; field-level review |
| 15 | Children: block registration under 18 (trade event) | LGPD Art. 14; ECA Digital | DOB/age attestation |
| 16 | Email compliance: SPF, DKIM, DMARC, one-click unsubscribe on marketing, separate subdomains | Gmail/Yahoo 2024; Outlook May 2025 | SES config; `List-Unsubscribe` headers |
| 17 | WhatsApp: opt-in record, approved templates, utility vs marketing separation | Meta policy | Consent purpose (d); template registry |
| 18 | BD SMS: registered masked sender ID; promo sends only 09:00–21:00 | BTRC | Gateway config + send-window guard |
| 19 | **Accessibility** WCAG 2.2 AA / ABNT NBR 17225:2025 (LBI Art. 63) | LBI; NBR 17225 | Pest browser + axe checks in CI; manual audit; aim for the SP Selo |
| 20 | Payments: PCI scope minimised (hosted checkout / redirects only); store gateway refs, never PANs; invoice FX snapshot | PCI DSS 4.0; tax | SSLCommerz/Stripe/MP hosted pages; ledger |
| 21 | ANVISA and customs guidance to exhibitors (samples not for sale; unregistered medicines not exhibited; temporary admission via organiser/forwarder; ATA not usable) | RDC 81/2008; IN RFB 1.600/2015 | Exhibitor compliance module + e-manual |
| 22 | Terms acceptance with version, timestamp and IP (as the competitor does), plus re-acceptance on change | Contract law | `terms_acceptances` table |

### R.5 Risks

| Risk | Impact | Mitigation |
|---|---|---|
| **Event dates and venue unconfirmed** (22–25 Mar 2027 / Pro Magno appear only in the competitor demo; Nov 2026 was "tentative") | Wrong dates in the pitch damage credibility | Confirm in writing; keep dates, venue and fees in `spatie/laravel-settings`, editable by staff |
| **Short runway**: if the edition is in March 2027, ~5 months remain; exhibitor sales and visa lead times (Section B) need the portal live by about Dec 2026 | Feature creep | Phase 1 (by Dec 2026): site, registration, application, payments, visa desk, badges. Phase 2 (Jan–Feb 2027): matchmaking, lead retrieval, kiosk. Phase 3 (post-event): ROI, certificates, RFQ |
| **Payment rails**: SSLCommerz BDT 500k cap; Stripe unavailable in BD; Brazilian Pix needs a CNPJ | Failed or partial payments | Bank-transfer path first-class; instalments under the cap; confirm BBCCI's entities |
| **Bangla rendering in PDFs and badges** | Unprofessional contracts and invoices | Chromium/Gotenberg only; golden-file tests with conjunct-heavy strings |
| **Alphanumeric CNPJ** (since Jul 2026) | Valid new companies rejected | `CHAR(14)` + alphanumeric validator + API fallback chain |
| **LGPD and BD data-protection exposure** (passports, biometrics, international transfer) | Fines, reputational damage | See R.4; no biometrics; SCCs; encryption; retention purge |
| **WhatsApp pricing changes** (Jul 2025, Oct 2026) and template re-categorisation | Cost overrun | Budget per message; utility templates only; email fallback; OTP via SMS for +880 |
| **Brand confusion** with madeinbangladeshexpo.com (an unrelated organiser) | SEO and trust | Distinct domain, schema.org `Organization`/`Event`, Google Business profile, press kit |
| **Low 2025 baseline** (~20 exhibitors) | Over-engineering for actual volume | Architecture scales, but price and phase the features to BBCCI's realistic 100–300 target |
| **Vendor/package churn** (Filament 5, Pest 5, maatwebsite/excel 4 are new majors) | Upgrade friction | Pin majors; Pest browser tests on critical flows; Laravel Boost guidance |
| **Local PHP 8.2** on the dev machine | Composer and platform errors | Standardise on PHP 8.4 (Herd/Laragon) and CI on 8.4 |
| **Trade-policy headwinds** (35% tariff, anti-dumping on jute bags, Abit lobbying) | Exhibitor ROI disappointment | Honest sector pages; matchmaking toward NCMs with lower barriers |

### R.6 Open questions for BBCCI

1. Confirmed edition dates and venue (and whether a Nov 2026 edition is cancelled).
2. Legal entities: Bangladeshi trade licence / RJSC registration; **Brazilian CNPJ?**; who is the LGPD controller and who is the encarregado (DPO)?
3. Bank accounts (BDT or FCY at EBL); appetite for SSLCommerz/bKash onboarding; Brazilian acquirer.
4. 2027 price list (stall sizes, corner premiums, buyer/delegate fees, association discounts and quotas).
5. Visa-letter signatory and letterhead; relationship with the Embassy of Brazil in Dhaka.
6. Interpreter pool (number, languages, fees); hosted-buyer budget.
7. Existing data (2025 exhibitor and visitor lists, consent provenance) for migration.
