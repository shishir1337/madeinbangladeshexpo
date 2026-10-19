<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;

/**
 * The long-form content of the nine sector pages: HS chapters, a three-part body and the key rules, with every
 * figure sourced (docs/research/02 §3 and the competitor's sector pages for ComexStat, EPB and tariff figures;
 * docs/research/03 §A and §C for regulation). Only empty fields are filled, so staff edits survive re-runs.
 * PT and BN copy is AI-drafted and awaits client review (spec §11).
 */
class SectorContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->content() as $slug => $fields) {
            $sector = Sector::query()->where('slug->en', $slug)->first();

            if ($sector === null) {
                continue;
            }

            foreach ($fields as $field => $value) {
                if ($this->isEmpty($sector, $field)) {
                    $sector->setAttribute($field, $value);
                }
            }

            $sector->save();
        }
    }

    /**
     * Whether a field has no content yet in any language.
     */
    private function isEmpty(Sector $sector, string $field): bool
    {
        if ($sector->isTranslatableAttribute($field)) {
            return $sector->getTranslations($field) === [];
        }

        return blank($sector->getAttribute($field));
    }

    /**
     * Content per sector, keyed by the English slug.
     *
     * @return array<string, array{hs_chapters: list<string>, body: array{en: string, pt_BR: string, bn: string}, rules: array{en: list<string>, pt_BR: list<string>, bn: list<string>}}>
     */
    private function content(): array
    {
        return [
            'garments' => [
                'hs_chapters' => [
                    '61 · Knitted or crocheted apparel',
                    '62 · Woven apparel',
                ],
                'body' => [
                    'en' => <<<'MD'
                        ## What Brazil buys

                        Bangladesh has been Brazil's second-largest clothing supplier every year from 2018 to 2025 (ComexStat, 2018–2025). In 2025 Brazil imported US$240 million of clothing from Bangladesh, 10.2% of all its clothing imports (ComexStat, 2025). Seen from Dhaka, garments made up 92% of Bangladesh's record US$215 million of exports to Brazil, about US$198 million (EPB, FY2025-26).

                        Demand is concentrated in everyday cotton basics. The lines Brazil bought most from Bangladesh were men's cotton trousers and shorts, cotton T-shirts, pullovers in cotton and man-made fibres, men's cotton shirts and women's cotton trousers (ComexStat, 2025). The wider market is large: Brazil imported US$6.81 billion of textiles and apparel in 2025, more than US$4 billion of it from China (Abit, 2025).

                        ## Rules to know

                        Every one of the 243 clothing tariff lines in HS chapters 61 and 62 carries a 35% import duty, with no preference for Bangladesh (Camex tariff schedule, Oct 2026). PIS/COFINS-Importação and state ICMS are charged on top. Because no preference exists, Bangladesh's graduation from LDC status does not change what its garments pay in Brazil. Labels on imported clothing must be in Portuguese, and the Brazilian buyer must be an importer enabled in Siscomex. Abit, the Brazilian textile industry association, has called for trade defence against Asian apparel, so watch for new measures.

                        ## How to win Brazilian buyers

                        Compete on reliability and compliance, not on price alone. Bring the numbers of your LEED, WRAP, OEKO-TEX, GOTS or ISO certificates: buyers can check them in public registers. Agree the Portuguese label text with your buyer before production, and quote FOB and CIF prices so landed costs are easy to compare. Show the cotton basics Brazil already buys, then offer the next step up in fabric, finish or fit. Samples for the stand enter Brazil under temporary admission, as ATA Carnets are not accepted.
                        MD,
                    'pt_BR' => <<<'MD'
                        ## O que o Brasil compra

                        Bangladesh foi o segundo maior fornecedor de roupas do Brasil em todos os anos de 2018 a 2025 (ComexStat, 2018–2025). Em 2025, o Brasil importou US$ 240 milhões em vestuário de Bangladesh, 10,2% de todas as suas importações de roupas (ComexStat, 2025). Do lado bangladês, o vestuário respondeu por 92% das exportações recordes de US$ 215 milhões para o Brasil, cerca de US$ 198 milhões (EPB, ano fiscal 2025-26).

                        A demanda se concentra em básicos de algodão. As linhas mais compradas de Bangladesh foram calças e bermudas masculinas de algodão, camisetas de algodão, pulôveres de algodão e de fibras sintéticas, camisas masculinas de algodão e calças femininas de algodão (ComexStat, 2025). O mercado como um todo é grande: o Brasil importou US$ 6,81 bilhões em têxteis e confecções em 2025, mais de US$ 4 bilhões da China (Abit, 2025).

                        ## Regras importantes

                        Todas as 243 linhas tarifárias de vestuário dos capítulos 61 e 62 do SH pagam 35% de imposto de importação, sem preferência para Bangladesh (tarifa Camex, out. 2026). PIS/COFINS-Importação e ICMS estadual incidem além desse imposto. Como não há preferência, a saída de Bangladesh da categoria de país menos desenvolvido não muda o que suas roupas pagam no Brasil. A etiqueta de roupas importadas deve estar em português, e o comprador brasileiro precisa ser importador habilitado no Siscomex. A Abit, associação da indústria têxtil brasileira, defende medidas de defesa comercial contra roupas asiáticas, por isso vale acompanhar novas medidas.

                        ## Como conquistar compradores brasileiros

                        Concorra em confiabilidade e conformidade, não apenas em preço. Leve os números dos seus certificados LEED, WRAP, OEKO-TEX, GOTS ou ISO: os compradores podem conferi-los em registros públicos. Combine com o comprador o texto da etiqueta em português antes da produção e apresente preços FOB e CIF para facilitar a comparação do custo final. Mostre os básicos de algodão que o Brasil já compra e ofereça o próximo passo em tecido, acabamento ou modelagem. As amostras do estande entram no Brasil por admissão temporária, já que o Carnê ATA não é aceito.
                        MD,
                    'bn' => <<<'MD'
                        ## ব্রাজিল কী কেনে

                        ২০১৮ থেকে ২০২৫ সালের প্রতিটি বছর বাংলাদেশ ব্রাজিলের দ্বিতীয় বৃহত্তম পোশাক সরবরাহকারী ছিল (কমেক্সস্ট্যাট, ২০১৮–২০২৫)। ২০২৫ সালে ব্রাজিল বাংলাদেশ থেকে ২৪০ মিলিয়ন মার্কিন ডলারের পোশাক আমদানি করেছে, যা দেশটির মোট পোশাক আমদানির ১০.২% (কমেক্সস্ট্যাট, ২০২৫)। বাংলাদেশের দিক থেকে দেখলে, ব্রাজিলে রেকর্ড ২১৫ মিলিয়ন ডলারের রপ্তানির ৯২%, অর্থাৎ প্রায় ১৯৮ মিলিয়ন ডলার, এসেছে পোশাক থেকে (ইপিবি, অর্থবছর ২০২৫-২৬)।

                        চাহিদার বড় অংশ সুতির দৈনন্দিন পোশাকে। বাংলাদেশ থেকে ব্রাজিল সবচেয়ে বেশি কিনেছে পুরুষদের সুতির ট্রাউজার ও শর্টস, সুতির টি-শার্ট, সুতি ও কৃত্রিম তন্তুর পুলওভার, পুরুষদের সুতির শার্ট এবং নারীদের সুতির ট্রাউজার (কমেক্সস্ট্যাট, ২০২৫)। পুরো বাজারও বিশাল: ২০২৫ সালে ব্রাজিল ৬.৮১ বিলিয়ন ডলারের বস্ত্র ও পোশাক আমদানি করেছে, যার ৪ বিলিয়ন ডলারের বেশি এসেছে চীন থেকে (আবিত, ২০২৫)।

                        ## যে নিয়মগুলো জানা দরকার

                        এইচএস অধ্যায় ৬১ ও ৬২-এর ২৪৩টি পোশাক শুল্করেখার প্রতিটিতে আমদানি শুল্ক ৩৫%, বাংলাদেশের জন্য কোনো অগ্রাধিকার নেই (কামেক্স শুল্কতালিকা, অক্টোবর ২০২৬)। এর ওপর পিআইএস/কোফিন্স-আমদানি ও রাজ্যের আইসিএমএস যুক্ত হয়। যেহেতু কোনো অগ্রাধিকারই নেই, তাই এলডিসি থেকে উত্তরণের ফলে ব্রাজিলে বাংলাদেশি পোশাকের শুল্ক বদলায় না। আমদানি করা পোশাকের লেবেল পর্তুগিজ ভাষায় হতে হবে, আর ব্রাজিলের ক্রেতাকে সিসকোমেক্সে নিবন্ধিত আমদানিকারক হতে হবে। ব্রাজিলের বস্ত্রশিল্প সমিতি আবিত এশীয় পোশাকের বিরুদ্ধে বাণিজ্য-সুরক্ষা ব্যবস্থার দাবি তুলেছে, তাই নতুন পদক্ষেপের দিকে নজর রাখুন।

                        ## ব্রাজিলের ক্রেতা পাওয়ার কৌশল

                        শুধু দামে নয়, নির্ভরযোগ্যতা ও কমপ্লায়েন্সে প্রতিযোগিতা করুন। আপনার লিড, র‍্যাপ, ওকো-টেক্স, জিওটিএস বা আইএসও সনদের নম্বর সঙ্গে আনুন; ক্রেতারা সেগুলো উন্মুক্ত রেজিস্টারে যাচাই করতে পারেন। উৎপাদনের আগেই ক্রেতার সঙ্গে পর্তুগিজ লেবেলের লেখা চূড়ান্ত করুন, আর এফওবি ও সিআইএফ দুই দামই দিন, যাতে মোট খরচ তুলনা করা সহজ হয়। ব্রাজিল যে সুতির বেসিক পোশাক এরই মধ্যে কিনছে সেগুলো দেখান, তারপর কাপড়, ফিনিশিং বা ফিটে এক ধাপ উন্নত বিকল্প দিন। স্টলের নমুনা সাময়িক আমদানি (টেম্পোরারি অ্যাডমিশন) ব্যবস্থায় ব্রাজিলে ঢোকে, কারণ এটিএ কার্নে সেখানে গ্রহণ করা হয় না।
                        MD,
                ],
                'rules' => [
                    'en' => [
                        '35% import duty on all 243 clothing lines in HS 61–62, with no preference for Bangladesh (Camex, Oct 2026)',
                        'PIS/COFINS-Importação and state ICMS are added on top of the duty',
                        'Labels on imported clothing must be in Portuguese',
                        'The buyer must be an importer enabled in Siscomex',
                        'Stand samples enter under temporary admission; ATA Carnets are not accepted',
                    ],
                    'pt_BR' => [
                        'Imposto de importação de 35% em todas as 243 linhas de vestuário do SH 61–62, sem preferência para Bangladesh (Camex, out. 2026)',
                        'PIS/COFINS-Importação e ICMS estadual incidem além do imposto',
                        'A etiqueta de roupas importadas deve estar em português',
                        'O comprador precisa ser importador habilitado no Siscomex',
                        'Amostras do estande entram por admissão temporária; o Carnê ATA não é aceito',
                    ],
                    'bn' => [
                        'এইচএস ৬১–৬২-এর ২৪৩টি পোশাক শুল্করেখার সবগুলোতে ৩৫% আমদানি শুল্ক; বাংলাদেশের জন্য অগ্রাধিকার নেই (কামেক্স, অক্টোবর ২০২৬)',
                        'শুল্কের ওপর পিআইএস/কোফিন্স-আমদানি ও রাজ্যের আইসিএমএস যুক্ত হয়',
                        'আমদানি করা পোশাকের লেবেল পর্তুগিজ ভাষায় হতে হবে',
                        'ক্রেতাকে সিসকোমেক্সে নিবন্ধিত আমদানিকারক হতে হবে',
                        'স্টলের নমুনা সাময়িক আমদানি ব্যবস্থায় ঢোকে; এটিএ কার্নে গ্রহণযোগ্য নয়',
                    ],
                ],
            ],
            'textiles' => [
                'hs_chapters' => [
                    '52 · Cotton yarn and fabrics',
                    '57 · Carpets and textile floor coverings',
                    '60 · Knitted or crocheted fabrics',
                    '63 · Made-up textiles and home linen',
                ],
                'body' => [
                    'en' => <<<'MD'
                        ## What Brazil buys

                        Brazil imported US$377 million of home textiles and other made-up textile articles (HS 63) in 2025, and Bangladesh supplied just 0.3% of it (ComexStat, 2025). That gap is the opportunity. Bangladesh exported US$928 million of home textiles to the world, but only US$1.3 million of it went to Brazil (EPB, FY2025-26). Bed linen, towels, kitchen and table linen, curtains and furnishing fabrics are the natural starting points, along with yarn and knitted fabrics for Brazil's own clothing makers.

                        The two countries are already linked through cotton: Brazil supplied about a quarter of the cotton Bangladesh imported in the 2024/25 marketing year (USDA FAS, MY2024/25). If a range can be traced back to Brazilian cotton, a Brazilian buyer has a story to tell.

                        ## Rules to know

                        Duties depend on how far the product is processed (Camex tariff schedule, Oct 2026). Bed, table, toilet and kitchen linen and carpets pay 35%. Knitted fabrics and woven cotton fabrics pay 26%, cotton yarn 18%, and bedding and quilts 16.2%. An additional COFINS-Importação applies to most textile chapters, and imported products must carry Portuguese labels. Confirm the full NCM code of each product with a customs broker before you quote.

                        ## How to win Brazilian buyers

                        Lead with certification and specification. OEKO-TEX, GOTS and Textile Exchange certificates can be checked in public registers, so bring the numbers. For technical textiles, agree the specification and any testing with the buyer before you price. Show a focused range with clear weights, compositions and colourways, and quote FOB and CIF so the buyer can compare landed costs with other suppliers. With Bangladesh's share this small, treat the first order as a trial and make it easy to accept: a modest minimum quantity and a lead time you are sure to meet.
                        MD,
                    'pt_BR' => <<<'MD'
                        ## O que o Brasil compra

                        O Brasil importou US$ 377 milhões em têxteis para casa e outros artefatos têxteis confeccionados (SH 63) em 2025, e Bangladesh forneceu apenas 0,3% desse total (ComexStat, 2025). Essa distância é a oportunidade. Bangladesh exportou US$ 928 milhões em têxteis para casa ao mundo, mas só US$ 1,3 milhão foi para o Brasil (EPB, ano fiscal 2025-26). Roupa de cama, toalhas, artigos de mesa e cozinha, cortinas e tecidos de decoração são os pontos de partida naturais, ao lado de fios e malhas para as próprias confecções brasileiras.

                        Os dois países já estão ligados pelo algodão: o Brasil forneceu cerca de um quarto do algodão importado por Bangladesh na safra 2024/25 (USDA FAS, safra 2024/25). Se uma linha puder ser rastreada até o algodão brasileiro, o comprador ganha uma boa história para contar.

                        ## Regras importantes

                        O imposto de importação depende do grau de elaboração do produto (tarifa Camex, out. 2026). Roupa de cama, mesa, banho e cozinha e tapetes pagam 35%. Tecidos de malha e tecidos planos de algodão pagam 26%, fios de algodão 18%, e edredons e acolchoados 16,2%. Um adicional de COFINS-Importação se aplica à maioria dos capítulos têxteis, e os produtos importados devem ter rotulagem em português. Confirme o código NCM completo de cada produto com um despachante aduaneiro antes de cotar.

                        ## Como conquistar compradores brasileiros

                        Comece pela certificação e pela especificação. Certificados OEKO-TEX, GOTS e Textile Exchange podem ser conferidos em registros públicos, então leve os números. Para têxteis técnicos, combine a especificação e eventuais ensaios com o comprador antes de dar preço. Apresente uma linha enxuta, com gramaturas, composições e cores bem definidas, e cote FOB e CIF para que o comprador compare o custo final com o de outros fornecedores. Com uma participação tão pequena de Bangladesh, trate o primeiro pedido como um teste e facilite o sim: quantidade mínima modesta e um prazo de entrega que você tenha certeza de cumprir.
                        MD,
                    'bn' => <<<'MD'
                        ## ব্রাজিল কী কেনে

                        ২০২৫ সালে ব্রাজিল ৩৭৭ মিলিয়ন মার্কিন ডলারের হোম টেক্সটাইল ও অন্যান্য তৈরি বস্ত্রপণ্য (এইচএস ৬৩) আমদানি করেছে, যার মাত্র ০.৩% সরবরাহ করেছে বাংলাদেশ (কমেক্সস্ট্যাট, ২০২৫)। এই ব্যবধানই সুযোগ। বাংলাদেশ বিশ্বে ৯২৮ মিলিয়ন ডলারের হোম টেক্সটাইল রপ্তানি করেছে, কিন্তু ব্রাজিলে গেছে মাত্র ১.৩ মিলিয়ন ডলারের (ইপিবি, অর্থবছর ২০২৫-২৬)। বিছানার চাদর, তোয়ালে, রান্নাঘর ও টেবিলের লিনেন, পর্দা ও আসবাবের কাপড় দিয়ে শুরু করাই স্বাভাবিক; সঙ্গে ব্রাজিলের নিজস্ব পোশাক কারখানার জন্য সুতা ও নিট কাপড়।

                        তুলার মাধ্যমে দুই দেশ আগে থেকেই যুক্ত: ২০২৪/২৫ বিপণন বছরে বাংলাদেশের আমদানি করা তুলার প্রায় এক-চতুর্থাংশ সরবরাহ করেছে ব্রাজিল (ইউএসডিএ এফএএস, ২০২৪/২৫)। কোনো পণ্যসারির উৎস ব্রাজিলের তুলা পর্যন্ত দেখানো গেলে ব্রাজিলের ক্রেতা তাঁর গ্রাহকদের একটি ভালো গল্প শোনাতে পারবেন।

                        ## যে নিয়মগুলো জানা দরকার

                        পণ্য কতটা প্রক্রিয়াজাত, তার ওপর শুল্ক নির্ভর করে (কামেক্স শুল্কতালিকা, অক্টোবর ২০২৬)। বিছানা, টেবিল, বাথরুম ও রান্নাঘরের লিনেন এবং কার্পেটে শুল্ক ৩৫%। নিট কাপড় ও সুতি ওভেন কাপড়ে ২৬%, সুতি সুতায় ১৮% এবং লেপ-তোশক জাতীয় বিছানাপণ্যে ১৬.২%। বেশির ভাগ বস্ত্র অধ্যায়ে অতিরিক্ত কোফিন্স-আমদানি প্রযোজ্য, আর আমদানি করা পণ্যে পর্তুগিজ লেবেল বাধ্যতামূলক। দাম দেওয়ার আগে প্রতিটি পণ্যের পূর্ণ এনসিএম কোড কাস্টমস ব্রোকারের সঙ্গে মিলিয়ে নিন।

                        ## ব্রাজিলের ক্রেতা পাওয়ার কৌশল

                        সনদ ও স্পেসিফিকেশন দিয়ে শুরু করুন। ওকো-টেক্স, জিওটিএস ও টেক্সটাইল এক্সচেঞ্জের সনদ উন্মুক্ত রেজিস্টারে যাচাই করা যায়, তাই নম্বরগুলো সঙ্গে আনুন। টেকনিক্যাল টেক্সটাইলের ক্ষেত্রে দাম দেওয়ার আগে ক্রেতার সঙ্গে স্পেসিফিকেশন ও প্রয়োজনীয় পরীক্ষা ঠিক করে নিন। ওজন, উপাদান ও রঙের স্পষ্ট বিবরণসহ একটি সুনির্দিষ্ট পণ্যসারি দেখান, আর এফওবি ও সিআইএফ দুই দামই দিন, যাতে ক্রেতা অন্য সরবরাহকারীদের সঙ্গে মোট খরচ তুলনা করতে পারেন। বাংলাদেশের অংশ এখনো এত ছোট বলে প্রথম অর্ডারকে পরীক্ষামূলক ধরে নিন এবং রাজি হওয়া সহজ করুন: কম ন্যূনতম পরিমাণ আর এমন সময়সীমা দিন, যা আপনি নিশ্চিতভাবে রাখতে পারবেন।
                        MD,
                ],
                'rules' => [
                    'en' => [
                        '35% on bed, table, toilet and kitchen linen and on carpets (Camex, Oct 2026)',
                        '26% on knitted and woven cotton fabrics; 18% on cotton yarn (Camex, Oct 2026)',
                        '16.2% on bedding and quilts (Camex, Oct 2026)',
                        'Additional COFINS-Importação on most textile chapters',
                        'Portuguese labelling on imported products',
                    ],
                    'pt_BR' => [
                        '35% sobre roupa de cama, mesa, banho e cozinha e sobre tapetes (Camex, out. 2026)',
                        '26% sobre tecidos de malha e tecidos planos de algodão; 18% sobre fios de algodão (Camex, out. 2026)',
                        '16,2% sobre edredons e acolchoados (Camex, out. 2026)',
                        'Adicional de COFINS-Importação na maioria dos capítulos têxteis',
                        'Rotulagem em português nos produtos importados',
                    ],
                    'bn' => [
                        'বিছানা, টেবিল, বাথরুম ও রান্নাঘরের লিনেন এবং কার্পেটে ৩৫% (কামেক্স, অক্টোবর ২০২৬)',
                        'নিট ও সুতি ওভেন কাপড়ে ২৬%; সুতি সুতায় ১৮% (কামেক্স, অক্টোবর ২০২৬)',
                        'লেপ-তোশক জাতীয় বিছানাপণ্যে ১৬.২% (কামেক্স, অক্টোবর ২০২৬)',
                        'বেশির ভাগ বস্ত্র অধ্যায়ে অতিরিক্ত কোফিন্স-আমদানি',
                        'আমদানি করা পণ্যে পর্তুগিজ লেবেল বাধ্যতামূলক',
                    ],
                ],
            ],
            'pharmaceuticals' => [
                'hs_chapters' => [
                    '30 · Pharmaceutical products',
                ],
                'body' => [
                    'en' => <<<'MD'
                        ## What Brazil buys

                        Brazil imported US$14.5 billion of pharmaceutical products (HS 30) in 2025 (ComexStat, 2025). Bangladesh exported US$238.5 million of medicines to the world (EPB, FY2025-26), but its sales to Brazil are still very small. The gap reflects regulation more than demand: the Brazilian market opens product by product, as each medicine is registered, so the first task is to choose which products to register and with whom.

                        ## Rules to know

                        A medicine can be sold in Brazil only once it is registered with ANVISA, the national health regulator, through a Brazilian company authorised by ANVISA that holds the registration (RDC 948/2024). The holder can be the maker's own unit in Brazil or an authorised Brazilian distributor, and timelines vary case by case. Only ANVISA-authorised companies may import regulated goods (RDC 81/2008). Import duty on medicines in retail packs ranges from 0% to 12.6% depending on the product, and many specific medicines are at 0% under Brazil's exception list (Camex tariff schedule, Oct 2026). PIS/COFINS-Importação on pharmaceuticals uses special rates.

                        The fair has its own limits. Unregistered medicines cannot be shown at a Brazilian fair, samples of regulated products may not be sold, and unregistered medical devices need ANVISA's approval about three months ahead and must be re-exported afterwards.

                        ## How to win Brazilian buyers

                        Exhibit your capability rather than your packs. Bring registration dossiers, GMP certificates, product lists and plant videos instead of samples. The buyers to look for are distributors and companies able to act as registration holders, because they carry each product through ANVISA. Be ready to discuss which molecules you would register first and how you would share the cost and time of registration. There is a precedent: BBCCI reports that at the 2025 edition a Bangladeshi pharmaceutical company signed a distribution memorandum with a São Paulo health distributor.
                        MD,
                    'pt_BR' => <<<'MD'
                        ## O que o Brasil compra

                        O Brasil importou US$ 14,5 bilhões em produtos farmacêuticos (SH 30) em 2025 (ComexStat, 2025). Bangladesh exportou US$ 238,5 milhões em medicamentos ao mundo (EPB, ano fiscal 2025-26), mas suas vendas ao Brasil ainda são muito pequenas. A distância reflete mais a regulação do que a demanda: o mercado brasileiro se abre produto a produto, à medida que cada medicamento é registrado, por isso a primeira tarefa é escolher quais produtos registrar e com quem.

                        ## Regras importantes

                        Um medicamento só pode ser vendido no Brasil depois de registrado na ANVISA, a agência reguladora de saúde, por meio de uma empresa brasileira autorizada pela ANVISA que detenha o registro (RDC 948/2024). O detentor pode ser uma unidade própria do fabricante no Brasil ou um distribuidor brasileiro autorizado, e os prazos variam caso a caso. Só empresas autorizadas pela ANVISA podem importar produtos regulados (RDC 81/2008). O imposto de importação de medicamentos em embalagem de varejo vai de 0% a 12,6%, conforme o produto, e muitos medicamentos específicos têm alíquota zero pela lista de exceções do Brasil (tarifa Camex, out. 2026). O PIS/COFINS-Importação sobre farmacêuticos tem alíquotas especiais.

                        A feira tem limites próprios. Medicamentos sem registro não podem ser expostos em feiras no Brasil, amostras de produtos regulados não podem ser vendidas, e dispositivos médicos sem registro precisam de aprovação prévia da ANVISA, pedida com cerca de três meses de antecedência, e devem ser reexportados depois.

                        ## Como conquistar compradores brasileiros

                        Mostre capacidade, não caixas. Leve dossiês de registro, certificados de BPF, listas de produtos e vídeos da fábrica em vez de amostras. Os compradores a procurar são distribuidores e empresas capazes de atuar como detentoras do registro, porque são elas que conduzem cada produto na ANVISA. Esteja pronto para discutir quais moléculas registraria primeiro e como dividiria o custo e o prazo do registro. Já existe um precedente: segundo a BBCCI, na edição de 2025 uma farmacêutica de Bangladesh assinou um memorando de distribuição com uma distribuidora de saúde de São Paulo.
                        MD,
                    'bn' => <<<'MD'
                        ## ব্রাজিল কী কেনে

                        ২০২৫ সালে ব্রাজিল ১৪.৫ বিলিয়ন মার্কিন ডলারের ওষুধপণ্য (এইচএস ৩০) আমদানি করেছে (কমেক্সস্ট্যাট, ২০২৫)। বাংলাদেশ বিশ্বে ২৩৮.৫ মিলিয়ন ডলারের ওষুধ রপ্তানি করেছে (ইপিবি, অর্থবছর ২০২৫-২৬), কিন্তু ব্রাজিলে বিক্রি এখনো খুবই সামান্য। এই ব্যবধানের কারণ চাহিদার চেয়ে বেশি নিয়ন্ত্রক কাঠামো: প্রতিটি ওষুধ নিবন্ধিত হলে তবেই সেটির জন্য বাজার খোলে, তাই প্রথম কাজ হলো কোন পণ্য কার মাধ্যমে নিবন্ধন করবেন তা ঠিক করা।

                        ## যে নিয়মগুলো জানা দরকার

                        ব্রাজিলে কোনো ওষুধ বিক্রি করা যায় কেবল দেশটির স্বাস্থ্য নিয়ন্ত্রক সংস্থা আনভিসায় নিবন্ধনের পর, আর সেই নিবন্ধন থাকতে হয় আনভিসা-অনুমোদিত একটি ব্রাজিলীয় প্রতিষ্ঠানের নামে (আরডিসি ৯৪৮/২০২৪)। এই হোল্ডার হতে পারে ব্রাজিলে উৎপাদকের নিজস্ব ইউনিট বা অনুমোদিত কোনো ব্রাজিলীয় পরিবেশক; সময় লাগে ক্ষেত্রভেদে ভিন্ন। কেবল আনভিসা-অনুমোদিত প্রতিষ্ঠানই নিয়ন্ত্রিত পণ্য আমদানি করতে পারে (আরডিসি ৮১/২০০৮)। খুচরা প্যাকের ওষুধে আমদানি শুল্ক পণ্যভেদে ০% থেকে ১২.৬%, আর ব্রাজিলের ব্যতিক্রম তালিকায় থাকা অনেক নির্দিষ্ট ওষুধে শুল্ক শূন্য (কামেক্স শুল্কতালিকা, অক্টোবর ২০২৬)। ওষুধে পিআইএস/কোফিন্স-আমদানির বিশেষ হার প্রযোজ্য।

                        মেলার নিজস্ব সীমাও আছে। অনিবন্ধিত ওষুধ ব্রাজিলের মেলায় প্রদর্শন করা যায় না, নিয়ন্ত্রিত পণ্যের নমুনা বিক্রি নিষিদ্ধ, আর অনিবন্ধিত চিকিৎসা সরঞ্জামের জন্য প্রায় তিন মাস আগে আনভিসার অনুমোদন নিতে হয় এবং পরে তা আবার রপ্তানি করে ফেরত নিতে হয়।

                        ## ব্রাজিলের ক্রেতা পাওয়ার কৌশল

                        প্যাকেট নয়, সক্ষমতা প্রদর্শন করুন। নমুনার বদলে নিবন্ধন ডসিয়ার, জিএমপি সনদ, পণ্যতালিকা ও কারখানার ভিডিও আনুন। খুঁজতে হবে এমন পরিবেশক ও প্রতিষ্ঠান, যারা নিবন্ধন হোল্ডার হতে পারে, কারণ প্রতিটি পণ্যকে আনভিসার প্রক্রিয়া পার করায় তারাই। কোন মলিকিউল আগে নিবন্ধন করবেন এবং নিবন্ধনের খরচ ও সময় কীভাবে ভাগাভাগি করবেন, তা আলোচনার জন্য প্রস্তুত থাকুন। নজিরও আছে: বিবিসিসিআইয়ের তথ্যমতে, ২০২৫ সালের আসরে বাংলাদেশের একটি ওষুধ কোম্পানি সাও পাওলোর একটি স্বাস্থ্যপণ্য পরিবেশকের সঙ্গে পরিবেশন বিষয়ে সমঝোতা স্মারক সই করে।
                        MD,
                ],
                'rules' => [
                    'en' => [
                        'ANVISA registration before any sale, through a Brazilian registration holder (RDC 948/2024)',
                        'Only ANVISA-authorised companies may import regulated goods (RDC 81/2008)',
                        'Unregistered medicines cannot be exhibited at Brazilian fairs',
                        'Samples of regulated products may not be sold',
                        'Duty on retail-pack medicines: 0–12.6% by product (Camex, Oct 2026)',
                    ],
                    'pt_BR' => [
                        'Registro na ANVISA antes de qualquer venda, por meio de um detentor brasileiro do registro (RDC 948/2024)',
                        'Só empresas autorizadas pela ANVISA podem importar produtos regulados (RDC 81/2008)',
                        'Medicamentos sem registro não podem ser expostos em feiras no Brasil',
                        'Amostras de produtos regulados não podem ser vendidas',
                        'Imposto sobre medicamentos em embalagem de varejo: 0–12,6% conforme o produto (Camex, out. 2026)',
                    ],
                    'bn' => [
                        'বিক্রির আগে ব্রাজিলীয় নিবন্ধন হোল্ডারের মাধ্যমে আনভিসায় নিবন্ধন (আরডিসি ৯৪৮/২০২৪)',
                        'কেবল আনভিসা-অনুমোদিত প্রতিষ্ঠান নিয়ন্ত্রিত পণ্য আমদানি করতে পারে (আরডিসি ৮১/২০০৮)',
                        'অনিবন্ধিত ওষুধ ব্রাজিলের মেলায় প্রদর্শন করা যায় না',
                        'নিয়ন্ত্রিত পণ্যের নমুনা বিক্রি নিষিদ্ধ',
                        'খুচরা প্যাকের ওষুধে শুল্ক পণ্যভেদে ০–১২.৬% (কামেক্স, অক্টোবর ২০২৬)',
                    ],
                ],
            ],
            'leather-footwear' => [
                'hs_chapters' => [
                    '41 · Hides, skins and leather',
                    '42 · Leather goods, bags and cases',
                    '64 · Footwear',
                ],
                'body' => [
                    'en' => <<<'MD'
                        ## What Brazil buys

                        Brazil imported US$680 million of leather goods and bags (HS 42) and US$629 million of footwear (HS 64) in 2025, and Bangladesh supplied only 0.66% and 0.32% of them (ComexStat, 2025). Bangladesh itself exported US$1.22 billion of footwear and US$535 million of leather and leather products to the world (EPB, FY2025-26), so the capacity is there. Bags and cases, and footwear with textile uppers, lead the small trade that already exists.

                        Brazil is a major leather and footwear producer in its own right. The best opening is in leather goods, bags and accessories that complement local production, rather than in competing head-on with Brazilian shoemakers. Trade also runs the other way: Brazil sold Bangladesh US$5.5 million of tanned hides in 2025 (ComexStat, 2025).

                        ## Rules to know

                        Duties vary by product (Camex tariff schedule and TIPI, Oct 2026). Most footwear pays 35%, as do bags with an outer surface of plastic or textile. Leather handbags pay 18% plus 6.5% IPI, and finished bovine leather pays 9%. An additional COFINS-Importação applies to footwear and to leather. Imported products must carry Portuguese labels, and the Brazilian buyer must be an importer enabled in Siscomex.

                        ## How to win Brazilian buyers

                        Brazilian buyers know leather well, so quality and traceability carry weight. Tanneries and leather-goods makers certified by the Leather Working Group appear in its public supplier list; give buyers your LWG reference so they can check it. Show bags, small leather goods and accessories with clear specifications of leather type, lining and hardware, and price them with the 18% duty and IPI in mind so the buyer sees a realistic landed cost. For footwear, lead with the styles Bangladesh already sells to Brazil and bring a full size run, so a buyer can judge fit as well as finish.
                        MD,
                    'pt_BR' => <<<'MD'
                        ## O que o Brasil compra

                        O Brasil importou US$ 680 milhões em artigos de couro e bolsas (SH 42) e US$ 629 milhões em calçados (SH 64) em 2025, e Bangladesh forneceu apenas 0,66% e 0,32% desses totais (ComexStat, 2025). Bangladesh exportou ao mundo US$ 1,22 bilhão em calçados e US$ 535 milhões em couro e artigos de couro (EPB, ano fiscal 2025-26), ou seja, capacidade não falta. Bolsas e estojos, além de calçados com cabedal têxtil, lideram o pequeno comércio que já existe.

                        O Brasil é, ele próprio, um grande produtor de couro e calçados. A melhor abertura está em artigos de couro, bolsas e acessórios que complementem a produção local, e não na concorrência direta com os fabricantes brasileiros de calçados. O comércio também corre no sentido inverso: o Brasil vendeu a Bangladesh US$ 5,5 milhões em couros curtidos em 2025 (ComexStat, 2025).

                        ## Regras importantes

                        O imposto varia conforme o produto (tarifa Camex e TIPI, out. 2026). A maioria dos calçados paga 35%, assim como bolsas com superfície externa de plástico ou têxtil. Bolsas de couro pagam 18% mais 6,5% de IPI, e o couro bovino acabado paga 9%. Um adicional de COFINS-Importação se aplica a calçados e couro. Os produtos importados devem ter rotulagem em português, e o comprador brasileiro precisa ser importador habilitado no Siscomex.

                        ## Como conquistar compradores brasileiros

                        O comprador brasileiro conhece bem o couro, então qualidade e rastreabilidade pesam. Curtumes e fabricantes de artigos de couro certificados pelo Leather Working Group aparecem na lista pública de fornecedores da entidade; informe sua referência LWG para que o comprador possa conferi-la. Apresente bolsas, pequenos artigos de couro e acessórios com especificações claras de tipo de couro, forro e metais, e forme o preço já considerando os 18% de imposto e o IPI, para que o comprador veja um custo final realista. Em calçados, comece pelos modelos que Bangladesh já vende ao Brasil e leve a grade completa de numeração, para que o comprador avalie o caimento e o acabamento.
                        MD,
                    'bn' => <<<'MD'
                        ## ব্রাজিল কী কেনে

                        ২০২৫ সালে ব্রাজিল ৬৮০ মিলিয়ন মার্কিন ডলারের চামড়াজাত পণ্য ও ব্যাগ (এইচএস ৪২) এবং ৬২৯ মিলিয়ন ডলারের জুতা (এইচএস ৬৪) আমদানি করেছে, যার মধ্যে বাংলাদেশের অংশ মাত্র ০.৬৬% ও ০.৩২% (কমেক্সস্ট্যাট, ২০২৫)। অথচ বাংলাদেশ বিশ্বে ১.২২ বিলিয়ন ডলারের জুতা এবং ৫৩৫ মিলিয়ন ডলারের চামড়া ও চামড়াজাত পণ্য রপ্তানি করেছে (ইপিবি, অর্থবছর ২০২৫-২৬); অর্থাৎ সক্ষমতার অভাব নেই। বর্তমানের ছোট বাণিজ্যে এগিয়ে আছে ব্যাগ ও কেস এবং কাপড়ের উপরিভাগযুক্ত জুতা।

                        ব্রাজিল নিজেই চামড়া ও জুতার বড় উৎপাদক। তাই ব্রাজিলের জুতা নির্মাতাদের সঙ্গে সরাসরি প্রতিযোগিতার চেয়ে স্থানীয় উৎপাদনের পরিপূরক চামড়াজাত পণ্য, ব্যাগ ও অনুষঙ্গেই সবচেয়ে ভালো সুযোগ। বাণিজ্য উল্টো দিকেও চলে: ২০২৫ সালে ব্রাজিল বাংলাদেশে ৫.৫ মিলিয়ন ডলারের ট্যান করা চামড়া বিক্রি করেছে (কমেক্সস্ট্যাট, ২০২৫)।

                        ## যে নিয়মগুলো জানা দরকার

                        পণ্যভেদে শুল্ক ভিন্ন (কামেক্স শুল্কতালিকা ও টিআইপিআই, অক্টোবর ২০২৬)। বেশির ভাগ জুতায় শুল্ক ৩৫%, প্লাস্টিক বা কাপড়ের বাইরের আবরণযুক্ত ব্যাগেও তাই। চামড়ার হ্যান্ডব্যাগে ১৮% শুল্কের সঙ্গে ৬.৫% আইপিআই, আর ফিনিশড গরুর চামড়ায় ৯%। জুতা ও চামড়ায় অতিরিক্ত কোফিন্স-আমদানি প্রযোজ্য। আমদানি করা পণ্যে পর্তুগিজ লেবেল লাগবে, আর ব্রাজিলের ক্রেতাকে সিসকোমেক্সে নিবন্ধিত আমদানিকারক হতে হবে।

                        ## ব্রাজিলের ক্রেতা পাওয়ার কৌশল

                        ব্রাজিলের ক্রেতারা চামড়া ভালো চেনেন, তাই মান ও উৎস যাচাইয়ের সুযোগের গুরুত্ব বেশি। লেদার ওয়ার্কিং গ্রুপের (এলডব্লিউজি) সনদপ্রাপ্ত ট্যানারি ও চামড়াপণ্য নির্মাতাদের নাম সংস্থাটির উন্মুক্ত সরবরাহকারী তালিকায় থাকে; ক্রেতাকে আপনার এলডব্লিউজি রেফারেন্স দিন, যাতে তিনি যাচাই করতে পারেন। চামড়ার ধরন, লাইনিং ও ধাতব অনুষঙ্গের স্পষ্ট বিবরণসহ ব্যাগ, ছোট চামড়াপণ্য ও অনুষঙ্গ দেখান, আর ১৮% শুল্ক ও আইপিআই মাথায় রেখে দাম ঠিক করুন, যাতে ক্রেতা বাস্তবসম্মত মোট খরচ দেখতে পান। জুতার ক্ষেত্রে বাংলাদেশ যেসব ধরন এরই মধ্যে ব্রাজিলে বিক্রি করছে সেগুলো দিয়ে শুরু করুন, আর সব সাইজের নমুনা আনুন, যাতে ক্রেতা ফিনিশিংয়ের পাশাপাশি মাপও যাচাই করতে পারেন।
                        MD,
                ],
                'rules' => [
                    'en' => [
                        '35% on most footwear and on bags with a plastic or textile outer (Camex, Oct 2026)',
                        '18% plus 6.5% IPI on leather handbags (Camex and TIPI, Oct 2026)',
                        '9% on finished bovine leather (Camex, Oct 2026)',
                        'Additional COFINS-Importação on footwear and leather',
                        'LWG certification can be checked in a public supplier list',
                    ],
                    'pt_BR' => [
                        '35% sobre a maioria dos calçados e sobre bolsas com exterior de plástico ou têxtil (Camex, out. 2026)',
                        '18% mais 6,5% de IPI sobre bolsas de couro (Camex e TIPI, out. 2026)',
                        '9% sobre couro bovino acabado (Camex, out. 2026)',
                        'Adicional de COFINS-Importação sobre calçados e couro',
                        'A certificação LWG pode ser conferida numa lista pública de fornecedores',
                    ],
                    'bn' => [
                        'বেশির ভাগ জুতা এবং প্লাস্টিক বা কাপড়ের বাইরের আবরণযুক্ত ব্যাগে ৩৫% (কামেক্স, অক্টোবর ২০২৬)',
                        'চামড়ার হ্যান্ডব্যাগে ১৮% সঙ্গে ৬.৫% আইপিআই (কামেক্স ও টিআইপিআই, অক্টোবর ২০২৬)',
                        'ফিনিশড গরুর চামড়ায় ৯% (কামেক্স, অক্টোবর ২০২৬)',
                        'জুতা ও চামড়ায় অতিরিক্ত কোফিন্স-আমদানি',
                        'এলডব্লিউজি সনদ উন্মুক্ত সরবরাহকারী তালিকায় যাচাই করা যায়',
                    ],
                ],
            ],
            'jute' => [
                'hs_chapters' => [
                    '53 · Jute and other vegetable fibres, yarn and fabric',
                    '63 · Made-up textiles, incl. jute sacks and bags',
                ],
                'body' => [
                    'en' => <<<'MD'
                        ## What Brazil buys

                        Jute is where Bangladesh already holds a real share of the Brazilian market. It supplied 18.1% of Brazil's imports of jute and other vegetable fibres (HS 53) in 2025, its highest share in any product group, worth US$8.1 million (ComexStat, 2025). The industry at home is growing too: Bangladesh exported US$884 million of jute and jute goods, up 7.75% (EPB, FY2025-26). Raw jute, jute yarn, jute fabric and diversified jute goods are the products to lead with.

                        ## Rules to know

                        Jute sacks and bags (NCM 6305.10.00) from Bangladesh carry a definitive anti-dumping duty of US$0.16 per kg, in force until 16 September 2027 (Brazilian anti-dumping measure of 2010, extended in 2016 and 2022). It comes on top of 35% import duty and 9.75% IPI (Camex tariff schedule and TIPI, Oct 2026). It is the only Brazilian trade-defence measure that names Bangladesh, and it does not cover raw jute, yarn, fabric or diversified jute goods.

                        Raw jute normally pays 7.2%, but NCM 5303.10.10 enters at 0% within a quota of 2,095 tonnes for 10 June–6 December 2026, renewed from 7 December 2026 to 9 June 2027 (Gecex Resolutions 900 and 939). Jute yarn pays 18% and jute fabric 26% (Camex tariff schedule, Oct 2026). Plant-origin goods may need phytosanitary clearance from MAPA, Brazil's Ministry of Agriculture, depending on the product and how it is processed.

                        ## How to win Brazilian buyers

                        Steer away from sacks, where the anti-dumping duty makes prices hard to defend, and towards the goods that enter on normal terms: raw jute within the quota, yarn, fabric and diversified products such as home décor. Make sustainability part of the pitch and back it with documented sourcing. There is already interest in packaging: BBCCI reports that at the 2025 edition a Bangladeshi jute-goods exporter and a Brazilian agri-startup proposed a joint venture in sustainable packaging. Confirm each NCM code with a customs broker before you quote, because a change in classification can move a product under the anti-dumping duty.
                        MD,
                    'pt_BR' => <<<'MD'
                        ## O que o Brasil compra

                        A juta é o produto em que Bangladesh já tem uma fatia real do mercado brasileiro. O país forneceu 18,1% das importações brasileiras de juta e outras fibras vegetais (SH 53) em 2025, sua maior participação em qualquer grupo de produtos, no valor de US$ 8,1 milhões (ComexStat, 2025). O setor também cresce em Bangladesh: as exportações de juta e produtos de juta somaram US$ 884 milhões, alta de 7,75% (EPB, ano fiscal 2025-26). Juta em bruto, fios, tecidos de juta e produtos diversificados de juta são os itens para abrir a conversa.

                        ## Regras importantes

                        Sacos e sacolas de juta (NCM 6305.10.00) de Bangladesh pagam direito antidumping definitivo de US$ 0,16 por kg, em vigor até 16 de setembro de 2027 (medida antidumping brasileira de 2010, prorrogada em 2016 e 2022). Ele se soma ao imposto de importação de 35% e ao IPI de 9,75% (tarifa Camex e TIPI, out. 2026). É a única medida de defesa comercial brasileira que cita Bangladesh, e não alcança juta em bruto, fios, tecidos nem produtos diversificados de juta.

                        A juta em bruto paga normalmente 7,2%, mas a NCM 5303.10.10 entra com alíquota zero dentro de uma cota de 2.095 toneladas para o período de 10 de junho a 6 de dezembro de 2026, renovada de 7 de dezembro de 2026 a 9 de junho de 2027 (Resoluções Gecex 900 e 939). Fios de juta pagam 18% e tecidos de juta 26% (tarifa Camex, out. 2026). Produtos de origem vegetal podem precisar de liberação fitossanitária do MAPA, o Ministério da Agricultura, conforme o produto e o processamento.

                        ## Como conquistar compradores brasileiros

                        Evite os sacos, em que o antidumping torna o preço difícil de defender, e concentre-se nos produtos que entram em condições normais: juta em bruto dentro da cota, fios, tecidos e produtos diversificados, como artigos de decoração. Faça da sustentabilidade parte da proposta e sustente-a com origem documentada. Já há interesse em embalagens: segundo a BBCCI, na edição de 2025 um exportador bangladês de produtos de juta e uma agrostartup brasileira propuseram uma joint venture em embalagens sustentáveis. Confirme cada código NCM com um despachante aduaneiro antes de cotar, porque uma mudança de classificação pode levar o produto para a linha sujeita ao antidumping.
                        MD,
                    'bn' => <<<'MD'
                        ## ব্রাজিল কী কেনে

                        পাট এমন একটি খাত, যেখানে ব্রাজিলের বাজারে বাংলাদেশের সত্যিকারের অংশ রয়েছে। ২০২৫ সালে ব্রাজিলের পাট ও অন্যান্য উদ্ভিজ্জ আঁশ (এইচএস ৫৩) আমদানির ১৮.১% সরবরাহ করেছে বাংলাদেশ, যার মূল্য ৮.১ মিলিয়ন মার্কিন ডলার; কোনো পণ্যগোষ্ঠীতে এটিই বাংলাদেশের সর্বোচ্চ অংশ (কমেক্সস্ট্যাট, ২০২৫)। দেশেও খাতটি বাড়ছে: পাট ও পাটজাত পণ্যের রপ্তানি ৭.৭৫% বেড়ে ৮৮৪ মিলিয়ন ডলারে পৌঁছেছে (ইপিবি, অর্থবছর ২০২৫-২৬)। কাঁচা পাট, পাটের সুতা, পাটের কাপড় ও বহুমুখী পাটপণ্য দিয়েই আলোচনা শুরু করুন।

                        ## যে নিয়মগুলো জানা দরকার

                        বাংলাদেশ থেকে যাওয়া পাটের বস্তা ও ব্যাগে (এনসিএম 6305.10.00) কেজিপ্রতি ০.১৬ মার্কিন ডলারের চূড়ান্ত অ্যান্টি-ডাম্পিং শুল্ক রয়েছে, যা বহাল থাকবে ২০২৭ সালের ১৬ সেপ্টেম্বর পর্যন্ত (২০১০ সালে আরোপিত ব্রাজিলের অ্যান্টি-ডাম্পিং ব্যবস্থা, ২০১৬ ও ২০২২ সালে মেয়াদ বাড়ানো হয়)। এর সঙ্গে যুক্ত হয় ৩৫% আমদানি শুল্ক ও ৯.৭৫% আইপিআই (কামেক্স শুল্কতালিকা ও টিআইপিআই, অক্টোবর ২০২৬)। বাংলাদেশের নাম উল্লেখ করা ব্রাজিলের একমাত্র বাণিজ্য-সুরক্ষা ব্যবস্থা এটিই, এবং কাঁচা পাট, সুতা, কাপড় বা বহুমুখী পাটপণ্য এর আওতায় পড়ে না।

                        কাঁচা পাটে সাধারণত শুল্ক ৭.২%, তবে এনসিএম 5303.10.10 একটি ২,০৯৫ টনের কোটার মধ্যে শূন্য শুল্কে ঢোকে; কোটাটি ২০২৬ সালের ১০ জুন থেকে ৬ ডিসেম্বরের জন্য, এবং ৭ ডিসেম্বর ২০২৬ থেকে ৯ জুন ২০২৭ পর্যন্ত তা নবায়ন করা হয়েছে (জেসেক্স রেজল্যুশন ৯০০ ও ৯৩৯)। পাটের সুতায় ১৮% ও পাটের কাপড়ে ২৬% শুল্ক (কামেক্স শুল্কতালিকা, অক্টোবর ২০২৬)। পণ্য ও প্রক্রিয়াজাতকরণের ধরনভেদে উদ্ভিজ্জ উৎসের পণ্যে ব্রাজিলের কৃষি মন্ত্রণালয় মাপার উদ্ভিদ-সংগনিরোধ ছাড়পত্র লাগতে পারে।

                        ## ব্রাজিলের ক্রেতা পাওয়ার কৌশল

                        বস্তা এড়িয়ে চলুন, কারণ অ্যান্টি-ডাম্পিং শুল্কের কারণে সেখানে দাম ধরে রাখা কঠিন; মনোযোগ দিন স্বাভাবিক শর্তে ঢোকা পণ্যে: কোটার মধ্যে কাঁচা পাট, সুতা, কাপড় এবং গৃহসজ্জার মতো বহুমুখী পাটপণ্য। টেকসইতাকে প্রস্তাবের অংশ করুন এবং নথিভুক্ত উৎসের প্রমাণ দিয়ে তা জোরালো করুন। প্যাকেজিংয়ে আগ্রহ এরই মধ্যে দেখা গেছে: বিবিসিসিআইয়ের তথ্যমতে, ২০২৫ সালের আসরে বাংলাদেশের একটি পাটপণ্য রপ্তানিকারক ও ব্রাজিলের একটি কৃষি-স্টার্টআপ টেকসই প্যাকেজিংয়ে যৌথ উদ্যোগের প্রস্তাব দেয়। দাম দেওয়ার আগে প্রতিটি এনসিএম কোড কাস্টমস ব্রোকারের সঙ্গে মিলিয়ে নিন, কারণ শ্রেণিবিন্যাসে সামান্য পরিবর্তনেও পণ্যটি অ্যান্টি-ডাম্পিংয়ের আওতায় চলে যেতে পারে।
                        MD,
                ],
                'rules' => [
                    'en' => [
                        'Anti-dumping duty of US$0.16/kg on jute sacks and bags (NCM 6305.10.00), in force until 16 Sep 2027',
                        'Sacks also pay 35% duty and 9.75% IPI (Camex and TIPI, Oct 2026)',
                        'Raw jute (NCM 5303.10.10): 0% within a 2,095 t quota, otherwise 7.2% (Gecex, 2026–27)',
                        'Jute yarn 18%, jute fabric 26% (Camex, Oct 2026)',
                        'Plant-origin goods may need MAPA phytosanitary clearance',
                    ],
                    'pt_BR' => [
                        'Antidumping de US$ 0,16/kg sobre sacos e sacolas de juta (NCM 6305.10.00), em vigor até 16 de setembro de 2027',
                        'Os sacos pagam ainda 35% de imposto e 9,75% de IPI (Camex e TIPI, out. 2026)',
                        'Juta em bruto (NCM 5303.10.10): 0% dentro de cota de 2.095 t; fora dela, 7,2% (Gecex, 2026–27)',
                        'Fios de juta 18%, tecidos de juta 26% (Camex, out. 2026)',
                        'Produtos de origem vegetal podem exigir liberação fitossanitária do MAPA',
                    ],
                    'bn' => [
                        'পাটের বস্তা ও ব্যাগে (এনসিএম 6305.10.00) কেজিপ্রতি ০.১৬ ডলার অ্যান্টি-ডাম্পিং শুল্ক, বহাল ১৬ সেপ্টেম্বর ২০২৭ পর্যন্ত',
                        'বস্তায় এর সঙ্গে ৩৫% শুল্ক ও ৯.৭৫% আইপিআই (কামেক্স ও টিআইপিআই, অক্টোবর ২০২৬)',
                        'কাঁচা পাট (এনসিএম 5303.10.10): ২,০৯৫ টনের কোটায় ০%, কোটার বাইরে ৭.২% (জেসেক্স, ২০২৬–২৭)',
                        'পাটের সুতায় ১৮%, পাটের কাপড়ে ২৬% (কামেক্স, অক্টোবর ২০২৬)',
                        'উদ্ভিজ্জ উৎসের পণ্যে মাপার উদ্ভিদ-সংগনিরোধ ছাড়পত্র লাগতে পারে',
                    ],
                ],
            ],
            'agro-food' => [
                'hs_chapters' => [
                    '03 · Fish and crustaceans',
                    '09 · Coffee, tea and spices',
                ],
                'body' => [
                    'en' => <<<'MD'
                        ## What Brazil buys

                        Brazil imported US$1.44 billion of fish and crustaceans (HS 03) in 2025 (ComexStat, 2025). Bangladesh exported US$1.0 billion of agricultural products and US$443 million of frozen and live fish (EPB, FY2025-26), yet almost none of it reached Brazil. This is a market to open rather than one to grow. Frozen shrimp and fish, tea, spices and processed foods are the natural candidates, and the buyers to target are importers and distributors already set up for Brazil's food regulations.

                        ## Rules to know

                        Regulation decides access more than tariffs do. Import duty is 9% on frozen whole shrimp and 9% on black tea in small packs (Camex tariff schedule, Oct 2026). Fish and shrimp exporters typically need their processing plant approved by MAPA, Brazil's Ministry of Agriculture; plant products need phytosanitary certification; and packaged food needs Portuguese labelling under ANVISA rules. Food regularisation follows RDC 843/2024 and IN 281/2024, with routes for registration, notification or communication depending on the product.

                        Food brought to the fair is regulated too. Food for exhibition, tasting or distribution needs ANVISA's prior approval, samples may not be sold, and finished products for distribution may not expire within 30 days of their sanitary release (RDC 81/2008).

                        ## How to win Brazilian buyers

                        Start the approval work before the expo, not after it: a serious buyer will first ask whether your plant is approved by MAPA and whether your labels meet ANVISA rules. Bring certificates, plant audit reports and packaging mock-ups with Portuguese labels. For tastings, buying stock in Brazil is often simpler than shipping it. Focus on importers and distributors who already handle imported seafood, tea or spices, because they know the paperwork and can act as importer of record. Agree shelf life, cold-chain handling and pack sizes early in the conversation.
                        MD,
                    'pt_BR' => <<<'MD'
                        ## O que o Brasil compra

                        O Brasil importou US$ 1,44 bilhão em peixes e crustáceos (SH 03) em 2025 (ComexStat, 2025). Bangladesh exportou US$ 1,0 bilhão em produtos agrícolas e US$ 443 milhões em pescado congelado e vivo (EPB, ano fiscal 2025-26), mas quase nada chegou ao Brasil. É um mercado a abrir, e não a ampliar. Camarão e peixe congelados, chá, especiarias e alimentos processados são os candidatos naturais, e os compradores a buscar são importadores e distribuidores já preparados para a regulação brasileira de alimentos.

                        ## Regras importantes

                        Aqui a regulação pesa mais do que a tarifa. O imposto de importação é de 9% para camarão inteiro congelado e de 9% para chá preto em embalagens pequenas (tarifa Camex, out. 2026). Exportadores de peixe e camarão normalmente precisam ter a planta de processamento habilitada pelo MAPA, o Ministério da Agricultura; produtos vegetais exigem certificação fitossanitária; e alimentos embalados precisam de rotulagem em português conforme as regras da ANVISA. A regularização de alimentos segue a RDC 843/2024 e a IN 281/2024, com vias de registro, notificação ou comunicação conforme o produto.

                        Os alimentos levados à feira também são regulados. Alimentos para exposição, degustação ou distribuição precisam de aprovação prévia da ANVISA, amostras não podem ser vendidas, e produtos acabados para distribuição não podem vencer em até 30 dias após a liberação sanitária (RDC 81/2008).

                        ## Como conquistar compradores brasileiros

                        Comece a habilitação antes da feira, não depois: um comprador sério vai perguntar primeiro se sua planta é habilitada pelo MAPA e se seus rótulos atendem às regras da ANVISA. Leve certificados, relatórios de auditoria da planta e modelos de embalagem com rótulo em português. Para degustações, comprar o estoque no Brasil costuma ser mais simples do que enviá-lo. Concentre-se em importadores e distribuidores que já trabalham com pescado, chá ou especiarias importados, porque conhecem a documentação e podem atuar como importador. Combine logo no início prazo de validade, cadeia de frio e tamanhos de embalagem.
                        MD,
                    'bn' => <<<'MD'
                        ## ব্রাজিল কী কেনে

                        ২০২৫ সালে ব্রাজিল ১.৪৪ বিলিয়ন মার্কিন ডলারের মাছ ও খোলসযুক্ত জলজ প্রাণী (এইচএস ০৩) আমদানি করেছে (কমেক্সস্ট্যাট, ২০২৫)। বাংলাদেশ ১.০ বিলিয়ন ডলারের কৃষিপণ্য এবং ৪৪৩ মিলিয়ন ডলারের হিমায়িত ও জীবন্ত মাছ রপ্তানি করেছে (ইপিবি, অর্থবছর ২০২৫-২৬), কিন্তু তার প্রায় কিছুই ব্রাজিলে যায়নি। এটি বাড়ানোর নয়, নতুন করে খোলার বাজার। হিমায়িত চিংড়ি ও মাছ, চা, মসলা ও প্রক্রিয়াজাত খাবার স্বাভাবিক প্রার্থী, আর লক্ষ্য হওয়া উচিত ব্রাজিলের খাদ্যবিধি মেনে কাজ করতে প্রস্তুত আমদানিকারক ও পরিবেশক।

                        ## যে নিয়মগুলো জানা দরকার

                        এখানে শুল্কের চেয়ে নিয়ন্ত্রক কাঠামোই বেশি গুরুত্বপূর্ণ। আস্ত হিমায়িত চিংড়িতে আমদানি শুল্ক ৯% এবং ছোট প্যাকের কালো চায়েও ৯% (কামেক্স শুল্কতালিকা, অক্টোবর ২০২৬)। মাছ ও চিংড়ি রপ্তানিকারকদের সাধারণত প্রক্রিয়াকরণ কারখানার জন্য ব্রাজিলের কৃষি মন্ত্রণালয় মাপার অনুমোদন লাগে; উদ্ভিজ্জ পণ্যে লাগে উদ্ভিদ-স্বাস্থ্য সনদ; আর প্যাকেটজাত খাবারে আনভিসার নিয়ম অনুযায়ী পর্তুগিজ লেবেল বাধ্যতামূলক। খাদ্যপণ্যের নিয়মিতকরণ চলে আরডিসি ৮৪৩/২০২৪ ও আইএন ২৮১/২০২৪ অনুযায়ী; পণ্যভেদে নিবন্ধন, নোটিফিকেশন বা কমিউনিকেশনের পথ রয়েছে।

                        মেলায় আনা খাবারও নিয়মের আওতায়। প্রদর্শন, টেস্টিং বা বিতরণের খাবারের জন্য আনভিসার আগাম অনুমোদন লাগে, নমুনা বিক্রি করা যায় না, আর বিতরণের জন্য আনা তৈরি পণ্যের মেয়াদ স্যানিটারি ছাড়পত্রের ৩০ দিনের মধ্যে শেষ হলে চলবে না (আরডিসি ৮১/২০০৮)।

                        ## ব্রাজিলের ক্রেতা পাওয়ার কৌশল

                        অনুমোদনের কাজ এক্সপোর পরে নয়, আগেই শুরু করুন: একজন আগ্রহী ক্রেতা প্রথমেই জানতে চাইবেন আপনার কারখানা মাপার অনুমোদিত কি না এবং লেবেল আনভিসার নিয়ম মানে কি না। সনদ, কারখানার অডিট প্রতিবেদন ও পর্তুগিজ লেবেলসহ প্যাকেজিংয়ের নমুনা নকশা সঙ্গে আনুন। টেস্টিংয়ের জন্য পণ্য পাঠানোর চেয়ে ব্রাজিলেই কিনে নেওয়া প্রায়ই সহজ। যেসব আমদানিকারক ও পরিবেশক এরই মধ্যে আমদানি করা সামুদ্রিক খাবার, চা বা মসলা নিয়ে কাজ করেন, তাঁদের দিকে মনোযোগ দিন; তাঁরা কাগজপত্র বোঝেন এবং আমদানিকারক হিসেবে দায়িত্ব নিতে পারেন। মেয়াদ, কোল্ড চেইন ও প্যাকেটের আকার আলোচনার শুরুতেই ঠিক করে নিন।
                        MD,
                ],
                'rules' => [
                    'en' => [
                        'MAPA approval of the processing plant for fish and shrimp',
                        'Phytosanitary certification for plant products',
                        'Portuguese labelling under ANVISA rules (RDC 843/2024, IN 281/2024)',
                        'Food at the fair needs prior ANVISA approval and may not be sold (RDC 81/2008)',
                        '9% duty on frozen whole shrimp and on black tea in small packs (Camex, Oct 2026)',
                    ],
                    'pt_BR' => [
                        'Habilitação da planta de processamento pelo MAPA para peixe e camarão',
                        'Certificação fitossanitária para produtos vegetais',
                        'Rotulagem em português conforme a ANVISA (RDC 843/2024, IN 281/2024)',
                        'Alimentos na feira exigem aprovação prévia da ANVISA e não podem ser vendidos (RDC 81/2008)',
                        '9% sobre camarão inteiro congelado e chá preto em embalagens pequenas (Camex, out. 2026)',
                    ],
                    'bn' => [
                        'মাছ ও চিংড়ির প্রক্রিয়াকরণ কারখানার জন্য মাপার অনুমোদন',
                        'উদ্ভিজ্জ পণ্যে উদ্ভিদ-স্বাস্থ্য সনদ',
                        'আনভিসার নিয়মে পর্তুগিজ লেবেল (আরডিসি ৮৪৩/২০২৪, আইএন ২৮১/২০২৪)',
                        'মেলার খাবারে আনভিসার আগাম অনুমোদন লাগে, বিক্রি করা যায় না (আরডিসি ৮১/২০০৮)',
                        'আস্ত হিমায়িত চিংড়ি ও ছোট প্যাকের কালো চায়ে ৯% শুল্ক (কামেক্স, অক্টোবর ২০২৬)',
                    ],
                ],
            ],
            'handicrafts' => [
                'hs_chapters' => [
                    '46 · Basketwork and wickerwork',
                    '57 · Carpets and textile floor coverings',
                    '69 · Ceramic products',
                    '94 · Furniture, bedding and lighting',
                ],
                'body' => [
                    'en' => <<<'MD'
                        ## What Brazil buys

                        Trade in handicrafts is still small, but the market behind it is large. In 2025 Brazil bought US$0.76 million of basketwork, US$0.12 million of ceramics and US$0.08 million of carpets from Bangladesh, while its total imports reached US$364 million of ceramics, US$113 million of carpets and US$1.40 billion of furniture and bedding (ComexStat, 2025). Handicrafts, handloom, ceramics and home décor are all on BBCCI's sector list for the expo, so a buyer looking for décor and gifts can meet a range of Bangladeshi makers in one place.

                        ## Rules to know

                        Ceramic tableware pays 18% applied duty, plus IPI of 9.75% on porcelain dinner sets and 6.5% on other tableware (Camex tariff schedule and TIPI, Oct 2026). Low-absorption ceramic tiles pay 12.6%, carpets 35%, and bedding and quilts 16.2%. Brazil's anti-dumping duties on tableware apply to other origins, not to Bangladesh. Ceramics that come into contact with food may need to meet ANVISA limits on lead and cadmium, so check with your buyer and customs broker. Imported products must carry Portuguese labels.

                        ## How to win Brazilian buyers

                        Make provenance part of the offer. Explain who makes each piece, with which materials and techniques, and how it is finished; a clear story gives a retailer something to tell its customers. Bring a catalogue that gives the NCM code, dimensions, weight and packed volume of every item, because bulky goods are costly to ship and a buyer will want to work out the landed cost quickly. Offer small trial quantities and mixed shipments to lower the risk of a first order. Test food-contact ceramics before the fair, so you can answer the lead and cadmium question on the spot.
                        MD,
                    'pt_BR' => <<<'MD'
                        ## O que o Brasil compra

                        O comércio de artesanato ainda é pequeno, mas o mercado por trás dele é grande. Em 2025, o Brasil comprou de Bangladesh US$ 0,76 milhão em cestaria, US$ 0,12 milhão em cerâmica e US$ 0,08 milhão em tapetes, enquanto suas importações totais chegaram a US$ 364 milhões em cerâmica, US$ 113 milhões em tapetes e US$ 1,40 bilhão em móveis e artigos de cama (ComexStat, 2025). Artesanato, tecelagem manual, cerâmica e decoração estão na lista de setores da BBCCI para a feira, de modo que quem compra decoração e presentes encontra vários fabricantes de Bangladesh num só lugar.

                        ## Regras importantes

                        A louça de cerâmica paga 18% de imposto de importação aplicado, mais IPI de 9,75% em aparelhos de jantar de porcelana e de 6,5% nas demais peças (tarifa Camex e TIPI, out. 2026). Revestimentos cerâmicos de baixa absorção pagam 12,6%, tapetes 35%, e edredons e acolchoados 16,2%. Os direitos antidumping do Brasil sobre louças se aplicam a outras origens, não a Bangladesh. Cerâmicas em contato com alimentos podem ter de atender aos limites da ANVISA para chumbo e cádmio; confirme com o comprador e o despachante. Produtos importados devem ter rotulagem em português.

                        ## Como conquistar compradores brasileiros

                        Faça da origem parte da oferta. Explique quem faz cada peça, com quais materiais e técnicas e como ela é acabada: uma história clara dá ao lojista o que contar ao cliente. Leve um catálogo com código NCM, dimensões, peso e volume embalado de cada item, porque produtos volumosos custam caro para transportar e o comprador vai querer calcular o custo final rapidamente. Ofereça pequenas quantidades de teste e embarques mistos para reduzir o risco do primeiro pedido. Teste as cerâmicas para contato com alimentos antes da feira, para responder na hora à pergunta sobre chumbo e cádmio.
                        MD,
                    'bn' => <<<'MD'
                        ## ব্রাজিল কী কেনে

                        হস্তশিল্পের বাণিজ্য এখনো ছোট, তবে এর পেছনের বাজারটি বড়। ২০২৫ সালে ব্রাজিল বাংলাদেশ থেকে ০.৭৬ মিলিয়ন মার্কিন ডলারের ঝুড়ি ও বেতপণ্য, ০.১২ মিলিয়ন ডলারের সিরামিক এবং ০.০৮ মিলিয়ন ডলারের কার্পেট কিনেছে, অথচ দেশটির মোট আমদানি ছিল ৩৬৪ মিলিয়ন ডলারের সিরামিক, ১১৩ মিলিয়ন ডলারের কার্পেট এবং ১.৪০ বিলিয়ন ডলারের আসবাব ও বিছানাপণ্য (কমেক্সস্ট্যাট, ২০২৫)। হস্তশিল্প, তাঁত, সিরামিক ও গৃহসজ্জা সবই এক্সপোর জন্য বিবিসিসিআইয়ের খাততালিকায় আছে, তাই গৃহসজ্জা ও উপহারপণ্যের ক্রেতারা এক জায়গায় বাংলাদেশের নানা নির্মাতার দেখা পাবেন।

                        ## যে নিয়মগুলো জানা দরকার

                        সিরামিকের টেবিলওয়্যারে প্রযোজ্য আমদানি শুল্ক ১৮%, সঙ্গে পোরসেলিনের ডিনার সেটে ৯.৭৫% এবং অন্যান্য টেবিলওয়্যারে ৬.৫% আইপিআই (কামেক্স শুল্কতালিকা ও টিআইপিআই, অক্টোবর ২০২৬)। কম পানি শোষণকারী সিরামিক টাইলসে ১২.৬%, কার্পেটে ৩৫% এবং লেপ-তোশক জাতীয় বিছানাপণ্যে ১৬.২%। টেবিলওয়্যারে ব্রাজিলের অ্যান্টি-ডাম্পিং শুল্ক অন্যান্য উৎসের জন্য, বাংলাদেশের জন্য নয়। খাবারের সংস্পর্শে আসা সিরামিককে সীসা ও ক্যাডমিয়ামের ক্ষেত্রে আনভিসার সীমা মানতে হতে পারে, তাই ক্রেতা ও কাস্টমস ব্রোকারের সঙ্গে মিলিয়ে নিন। আমদানি করা পণ্যে পর্তুগিজ লেবেল লাগবে।

                        ## ব্রাজিলের ক্রেতা পাওয়ার কৌশল

                        পণ্যের উৎসকে প্রস্তাবের অংশ করুন। প্রতিটি পণ্য কে বানান, কোন উপকরণ ও কৌশলে, আর কীভাবে ফিনিশিং দেওয়া হয়, তা ব্যাখ্যা করুন; স্পষ্ট একটি গল্প খুচরা বিক্রেতাকে তাঁর গ্রাহকদের বলার মতো কিছু দেয়। প্রতিটি পণ্যের এনসিএম কোড, মাপ, ওজন ও প্যাকেটসহ আয়তন উল্লেখ করা ক্যাটালগ আনুন, কারণ বড় আকারের পণ্য পাঠাতে খরচ বেশি এবং ক্রেতা দ্রুত মোট খরচ হিসাব করতে চাইবেন। প্রথম অর্ডারের ঝুঁকি কমাতে অল্প পরিমাণের পরীক্ষামূলক অর্ডার ও মিশ্র চালানের সুযোগ দিন। খাবারের সংস্পর্শে আসা সিরামিক মেলার আগেই পরীক্ষা করিয়ে নিন, যাতে সীসা ও ক্যাডমিয়ামের প্রশ্নের উত্তর সঙ্গে সঙ্গে দিতে পারেন।
                        MD,
                ],
                'rules' => [
                    'en' => [
                        '18% duty on ceramic tableware, plus 6.5–9.75% IPI (Camex and TIPI, Oct 2026)',
                        '12.6% on low-absorption ceramic tiles; 35% on carpets (Camex, Oct 2026)',
                        'Brazil\'s anti-dumping duties on tableware do not apply to Bangladesh',
                        'Food-contact ceramics may need to meet ANVISA lead and cadmium limits',
                    ],
                    'pt_BR' => [
                        '18% sobre louça de cerâmica, mais IPI de 6,5% a 9,75% (Camex e TIPI, out. 2026)',
                        '12,6% sobre revestimentos cerâmicos de baixa absorção; 35% sobre tapetes (Camex, out. 2026)',
                        'O antidumping brasileiro sobre louças não se aplica a Bangladesh',
                        'Cerâmica para contato com alimentos pode ter de atender aos limites da ANVISA para chumbo e cádmio',
                    ],
                    'bn' => [
                        'সিরামিক টেবিলওয়্যারে ১৮% শুল্ক, সঙ্গে ৬.৫–৯.৭৫% আইপিআই (কামেক্স ও টিআইপিআই, অক্টোবর ২০২৬)',
                        'কম পানি শোষণকারী সিরামিক টাইলসে ১২.৬%; কার্পেটে ৩৫% (কামেক্স, অক্টোবর ২০২৬)',
                        'টেবিলওয়্যারে ব্রাজিলের অ্যান্টি-ডাম্পিং শুল্ক বাংলাদেশের ক্ষেত্রে প্রযোজ্য নয়',
                        'খাবারের সংস্পর্শে আসা সিরামিককে আনভিসার সীসা ও ক্যাডমিয়াম সীমা মানতে হতে পারে',
                    ],
                ],
            ],
            'plastics-toys' => [
                'hs_chapters' => [
                    '39 · Plastics and plastic articles',
                    '95 · Toys, games and sports goods',
                ],
                'body' => [
                    'en' => <<<'MD'
                        ## What Brazil buys

                        Brazil imported US$11.0 billion of plastics and plastic articles (HS 39) and US$1.16 billion of toys (HS 95) in 2025, and Bangladesh supplied US$1.23 million and US$0.93 million of them (ComexStat, 2025). Both are large markets where Bangladesh has barely started. Household and industrial plastics are among BBCCI's focus areas, plastics and packaging are on its sector list for the next edition, and Aman Plastic Toys Industries exhibited in São Paulo in 2025, so Brazilian buyers have already met Bangladeshi toy makers.

                        ## Rules to know

                        Plastic tableware and household articles pay 16.2% applied duty, and toys pay 20%, with one line at 18% (Camex tariff schedule, Oct 2026). Some plastics lines are on Brazil's temporary tariff-increase list, so check the exact NCM code before quoting. Toys, like bicycles, helmets and electrical goods, are subject to INMETRO conformity assessment, with testing generally done in Brazil. Imported products must carry Portuguese labels, and the Brazilian buyer must be an importer enabled in Siscomex.

                        ## How to win Brazilian buyers

                        Price certification into the offer. For toys, INMETRO testing adds cost and time before the first shipment can be sold, so tell the buyer how you will handle it and who will pay. Bring the test reports and material specifications you already have; they help a Brazilian partner plan the certification. For household plastics, show durable ranges that pack and ship efficiently, and give the NCM code for every item so the buyer can confirm the duty and any temporary increase. A short, well-chosen range with clear prices, minimum quantities and lead times will do more at the stand than a large catalogue.
                        MD,
                    'pt_BR' => <<<'MD'
                        ## O que o Brasil compra

                        O Brasil importou US$ 11,0 bilhões em plásticos e suas obras (SH 39) e US$ 1,16 bilhão em brinquedos (SH 95) em 2025, e Bangladesh forneceu US$ 1,23 milhão e US$ 0,93 milhão desses totais (ComexStat, 2025). São dois mercados grandes em que Bangladesh mal começou. Plásticos domésticos e industriais estão entre as áreas de foco da BBCCI, plásticos e embalagens fazem parte da lista de setores da próxima edição, e a Aman Plastic Toys Industries expôs em São Paulo em 2025, de modo que compradores brasileiros já conheceram fabricantes de brinquedos de Bangladesh.

                        ## Regras importantes

                        Utensílios de mesa e artigos domésticos de plástico pagam 16,2% de imposto de importação aplicado, e brinquedos pagam 20%, com uma linha a 18% (tarifa Camex, out. 2026). Algumas linhas de plásticos estão na lista brasileira de elevações temporárias de tarifa, então confira o código NCM exato antes de cotar. Brinquedos, assim como bicicletas, capacetes e produtos elétricos, estão sujeitos à avaliação da conformidade do INMETRO, com ensaios geralmente feitos no Brasil. Os produtos importados devem ter rotulagem em português, e o comprador brasileiro precisa ser importador habilitado no Siscomex.

                        ## Como conquistar compradores brasileiros

                        Inclua a certificação na oferta. No caso dos brinquedos, os ensaios do INMETRO acrescentam custo e prazo antes que o primeiro embarque possa ser vendido, então diga ao comprador como vai lidar com isso e quem vai pagar. Leve os laudos de ensaio e as especificações de materiais que já tem; eles ajudam o parceiro brasileiro a planejar a certificação. Em plásticos domésticos, mostre linhas duráveis, que se embalam e se transportam com eficiência, e informe o código NCM de cada item para que o comprador confirme o imposto e eventuais elevações temporárias. Uma linha curta e bem escolhida, com preços, quantidades mínimas e prazos claros, rende mais no estande do que um catálogo extenso.
                        MD,
                    'bn' => <<<'MD'
                        ## ব্রাজিল কী কেনে

                        ২০২৫ সালে ব্রাজিল ১১.০ বিলিয়ন মার্কিন ডলারের প্লাস্টিক ও প্লাস্টিকপণ্য (এইচএস ৩৯) এবং ১.১৬ বিলিয়ন ডলারের খেলনা (এইচএস ৯৫) আমদানি করেছে, যার মধ্যে বাংলাদেশ সরবরাহ করেছে যথাক্রমে ১.২৩ মিলিয়ন ও ০.৯৩ মিলিয়ন ডলারের পণ্য (কমেক্সস্ট্যাট, ২০২৫)। দুটিই বড় বাজার, যেখানে বাংলাদেশের যাত্রা সবে শুরু। গৃহস্থালি ও শিল্প প্লাস্টিক বিবিসিসিআইয়ের অগ্রাধিকার খাতগুলোর একটি, পরবর্তী আসরের খাততালিকায় আছে প্লাস্টিক ও প্যাকেজিং, আর ২০২৫ সালে সাও পাওলোতে প্রদর্শনী করেছে আমান প্লাস্টিক টয়েজ ইন্ডাস্ট্রিজ; অর্থাৎ ব্রাজিলের ক্রেতারা বাংলাদেশের খেলনা নির্মাতাদের সঙ্গে এরই মধ্যে পরিচিত হয়েছেন।

                        ## যে নিয়মগুলো জানা দরকার

                        প্লাস্টিকের টেবিলওয়্যার ও গৃহস্থালি সামগ্রীতে প্রযোজ্য আমদানি শুল্ক ১৬.২%, আর খেলনায় ২০% (একটি শুল্করেখায় ১৮%) (কামেক্স শুল্কতালিকা, অক্টোবর ২০২৬)। কিছু প্লাস্টিক শুল্করেখা ব্রাজিলের সাময়িক শুল্কবৃদ্ধির তালিকায় আছে, তাই দাম দেওয়ার আগে সঠিক এনসিএম কোড যাচাই করুন। সাইকেল, হেলমেট ও বৈদ্যুতিক পণ্যের মতো খেলনাও ইনমেট্রোর কনফরমিটি অ্যাসেসমেন্টের আওতায়, আর পরীক্ষা সাধারণত ব্রাজিলেই হয়। আমদানি করা পণ্যে পর্তুগিজ লেবেল লাগবে, আর ব্রাজিলের ক্রেতাকে সিসকোমেক্সে নিবন্ধিত আমদানিকারক হতে হবে।

                        ## ব্রাজিলের ক্রেতা পাওয়ার কৌশল

                        সনদের খরচ প্রস্তাবের মধ্যেই ধরুন। খেলনার ক্ষেত্রে প্রথম চালান বিক্রির আগে ইনমেট্রোর পরীক্ষায় খরচ ও সময় দুটোই লাগে, তাই আপনি বিষয়টি কীভাবে সামলাবেন এবং খরচ কে বহন করবে, তা ক্রেতাকে জানান। আপনার কাছে থাকা পরীক্ষার প্রতিবেদন ও উপকরণের বিবরণ সঙ্গে আনুন; এতে ব্রাজিলের অংশীদারের পক্ষে সনদ প্রক্রিয়ার পরিকল্পনা করা সহজ হয়। গৃহস্থালি প্লাস্টিকের ক্ষেত্রে টেকসই এবং সহজে প্যাক ও পরিবহনযোগ্য পণ্যসারি দেখান, আর প্রতিটি পণ্যের এনসিএম কোড দিন, যাতে ক্রেতা শুল্ক ও সম্ভাব্য সাময়িক শুল্কবৃদ্ধি যাচাই করতে পারেন। বড় ক্যাটালগের চেয়ে স্পষ্ট দাম, ন্যূনতম পরিমাণ ও সময়সীমাসহ ছোট, বাছাই করা পণ্যসারি স্টলে বেশি কাজে দেয়।
                        MD,
                ],
                'rules' => [
                    'en' => [
                        'Toys need INMETRO conformity assessment, generally tested in Brazil',
                        'Toys pay 20% duty, one line 18% (Camex, Oct 2026)',
                        'Plastic tableware and household articles pay 16.2% (Camex, Oct 2026)',
                        'Some plastics lines are on the temporary tariff-increase list',
                        'Imported products need Portuguese labelling',
                    ],
                    'pt_BR' => [
                        'Brinquedos exigem avaliação da conformidade do INMETRO, com ensaios geralmente no Brasil',
                        'Brinquedos pagam 20% de imposto, uma linha 18% (Camex, out. 2026)',
                        'Utensílios e artigos domésticos de plástico pagam 16,2% (Camex, out. 2026)',
                        'Algumas linhas de plásticos estão na lista de elevações temporárias de tarifa',
                        'Produtos importados exigem rotulagem em português',
                    ],
                    'bn' => [
                        'খেলনায় ইনমেট্রোর কনফরমিটি অ্যাসেসমেন্ট লাগে, পরীক্ষা সাধারণত ব্রাজিলে',
                        'খেলনায় শুল্ক ২০%, একটি শুল্করেখায় ১৮% (কামেক্স, অক্টোবর ২০২৬)',
                        'প্লাস্টিকের টেবিলওয়্যার ও গৃহস্থালি সামগ্রীতে ১৬.২% (কামেক্স, অক্টোবর ২০২৬)',
                        'কিছু প্লাস্টিক শুল্করেখা সাময়িক শুল্কবৃদ্ধির তালিকায়',
                        'আমদানি করা পণ্যে পর্তুগিজ লেবেল বাধ্যতামূলক',
                    ],
                ],
            ],
            'ict' => [
                'hs_chapters' => [],
                'body' => [
                    'en' => <<<'MD'
                        ## What Brazil buys

                        BBCCI's sector list includes ICT and software, and its invitation for the next edition names software development, freelancing, business process outsourcing and digital services. The time zones work in Bangladesh's favour. Dhaka is nine hours ahead of São Paulo all year (UTC+6 and UTC−3), because Brazil stopped using daylight saving time in 2019 (Decree 9.772/2019). 08:00–10:00 in São Paulo is 17:00–19:00 in Dhaka, so a team in Dhaka can work on a request during the Brazilian night and hand it back by the start of the Brazilian working day. Monday to Thursday are working days in both countries.

                        ## Rules to know

                        Price with Brazilian taxes in mind. A Brazilian client pays 3.5% IOF on the foreign-exchange transaction for a foreign service invoice (Decree 6.306/2007, as amended by Decree 12.499/2025) and withholds 25% income tax on services paid to non-residents (Brazilian tax rules, Oct 2026); other contributions may apply. There is no Brazil–Bangladesh tax treaty to reduce that withholding. Personal data falls under Brazil's LGPD: a provider outside Brazil and the EU that processes data for a Brazilian client needs ANPD standard contractual clauses, mandatory since 23 August 2025. On the Bangladesh side, software and ICT exporters may keep 50% of repatriated proceeds in an ERQ account (Bangladesh Bank FEPD Circular 26, 30 July 2026).

                        ## How to win Brazilian buyers

                        Agree early who bears the withholding tax: a price quoted without it must be grossed up, and the buyer will compare offers on what they actually pay. Show that you are ready for the LGPD with a data-processing agreement that includes the ANPD clauses, and explain how you protect client data. Offer a fixed overlap window in São Paulo's morning and a named account lead who works in Portuguese or English. Propose a small, well-defined pilot that proves delivery before a larger contract. Maha Telecom represented the sector at the 2025 edition.
                        MD,
                    'pt_BR' => <<<'MD'
                        ## O que o Brasil compra

                        A lista de setores da BBCCI inclui TIC e software, e o convite para a próxima edição menciona desenvolvimento de software, trabalho freelance, terceirização de processos de negócios (BPO) e serviços digitais. O fuso horário joga a favor de Bangladesh. Daca está nove horas à frente de São Paulo o ano todo (UTC+6 e UTC−3), porque o Brasil deixou de adotar o horário de verão em 2019 (Decreto 9.772/2019). Das 8h às 10h em São Paulo são 17h às 19h em Daca, então uma equipe em Daca pode trabalhar numa demanda durante a noite brasileira e devolvê-la no início do expediente no Brasil. De segunda a quinta-feira são dias úteis nos dois países.

                        ## Regras importantes

                        Forme o preço pensando nos tributos brasileiros. O cliente brasileiro paga 3,5% de IOF na operação de câmbio de uma fatura de serviço estrangeira (Decreto 6.306/2007, alterado pelo Decreto 12.499/2025) e retém 25% de imposto de renda sobre serviços pagos a não residentes (regras tributárias brasileiras, out. 2026); outras contribuições podem incidir. Não há tratado tributário entre Brasil e Bangladesh para reduzir essa retenção. Dados pessoais seguem a LGPD: um prestador fora do Brasil e da União Europeia que trate dados de um cliente brasileiro precisa das cláusulas-padrão contratuais da ANPD, obrigatórias desde 23 de agosto de 2025. Do lado de Bangladesh, exportadores de software e TIC podem manter 50% das receitas repatriadas em uma conta ERQ (Circular FEPD 26 do Bangladesh Bank, 30 de julho de 2026).

                        ## Como conquistar compradores brasileiros

                        Combine logo quem arca com a retenção: um preço cotado sem ela precisa ser ajustado para cima, e o comprador vai comparar propostas pelo que de fato paga. Mostre que está pronto para a LGPD com um contrato de tratamento de dados que inclua as cláusulas da ANPD e explique como protege os dados do cliente. Ofereça uma janela fixa de sobreposição na manhã de São Paulo e um gerente de conta que trabalhe em português ou inglês. Proponha um piloto pequeno e bem definido, que comprove a entrega antes de um contrato maior. A Maha Telecom representou o setor na edição de 2025.
                        MD,
                    'bn' => <<<'MD'
                        ## ব্রাজিল কী কেনে

                        বিবিসিসিআইয়ের খাততালিকায় আইসিটি ও সফটওয়্যার আছে, আর পরবর্তী আসরের আমন্ত্রণে উল্লেখ করা হয়েছে সফটওয়্যার উন্নয়ন, ফ্রিল্যান্সিং, বিজনেস প্রসেস আউটসোর্সিং ও ডিজিটাল সেবার কথা। সময়ের ব্যবধান বাংলাদেশের পক্ষে। সারা বছর ঢাকা সাও পাওলোর চেয়ে ৯ ঘণ্টা এগিয়ে থাকে (ইউটিসি+৬ ও ইউটিসি−৩), কারণ ২০১৯ সালে ব্রাজিল ডেলাইট সেভিং টাইম বন্ধ করেছে (ডিক্রি ৯.৭৭২/২০১৯)। সাও পাওলোর সকাল ৮টা থেকে ১০টা মানে ঢাকায় বিকেল ৫টা থেকে সন্ধ্যা ৭টা; ফলে ব্রাজিলের রাতে ঢাকার দল কাজ এগিয়ে নিয়ে ব্রাজিলের কর্মদিবস শুরুর আগেই তা ফেরত দিতে পারে। সোম থেকে বৃহস্পতিবার দুই দেশেই কর্মদিবস।

                        ## যে নিয়মগুলো জানা দরকার

                        দাম ঠিক করার সময় ব্রাজিলের কর মাথায় রাখুন। বিদেশি সেবার বিলের বৈদেশিক মুদ্রা লেনদেনে ব্রাজিলের ক্লায়েন্ট ৩.৫% আইওএফ দেন (ডিক্রি ৬.৩০৬/২০০৭, ডিক্রি ১২.৪৯৯/২০২৫ দ্বারা সংশোধিত) এবং অনিবাসীকে দেওয়া সেবামূল্য থেকে ২৫% আয়কর কেটে রাখেন (ব্রাজিলের কর বিধি, অক্টোবর ২০২৬); অন্যান্য কর-অবদানও প্রযোজ্য হতে পারে। এই কর্তন কমানোর মতো কোনো ব্রাজিল-বাংলাদেশ দ্বৈত কর চুক্তি নেই। ব্যক্তিগত তথ্য ব্রাজিলের এলজিপিডি আইনের আওতায়: ব্রাজিল ও ইউরোপীয় ইউনিয়নের বাইরের কোনো সেবাদাতা ব্রাজিলীয় ক্লায়েন্টের তথ্য প্রক্রিয়া করলে এএনপিডির স্ট্যান্ডার্ড কনট্রাকচুয়াল ক্লজ লাগবে, যা ২০২৫ সালের ২৩ আগস্ট থেকে বাধ্যতামূলক। বাংলাদেশের দিকে, সফটওয়্যার ও আইসিটি রপ্তানিকারকেরা প্রত্যাবাসিত আয়ের ৫০% ইআরকিউ হিসাবে রাখতে পারেন (বাংলাদেশ ব্যাংকের এফইপিডি সার্কুলার ২৬, ৩০ জুলাই ২০২৬)।

                        ## ব্রাজিলের ক্রেতা পাওয়ার কৌশল

                        কর্তিত কর কে বহন করবে, তা শুরুতেই ঠিক করুন: কর বাদ দিয়ে দেওয়া দাম পরে বাড়াতে হয়, আর ক্রেতা প্রস্তাবগুলো তুলনা করবেন আসলে কত দিতে হচ্ছে তার ভিত্তিতে। এএনপিডির ক্লজসহ ডেটা প্রসেসিং চুক্তি দিয়ে দেখান যে আপনি এলজিপিডি মানতে প্রস্তুত, আর ক্লায়েন্টের তথ্য কীভাবে সুরক্ষিত রাখেন তা ব্যাখ্যা করুন। সাও পাওলোর সকালে নির্দিষ্ট একটি যৌথ কর্মসময় এবং পর্তুগিজ বা ইংরেজিতে কাজ করা একজন নির্দিষ্ট অ্যাকাউন্ট ম্যানেজারের প্রস্তাব দিন। বড় চুক্তির আগে কাজের মান প্রমাণে ছোট ও সুনির্দিষ্ট একটি পাইলট প্রকল্পের প্রস্তাব দিন। ২০২৫ সালের আসরে এই খাতের প্রতিনিধিত্ব করেছে মাহা টেলিকম।
                        MD,
                ],
                'rules' => [
                    'en' => [
                        '3.5% IOF on the client\'s foreign-exchange payment (Decree 12.499/2025)',
                        '25% income tax withheld on services paid to non-residents (Brazilian tax rules, Oct 2026)',
                        'No Brazil–Bangladesh double-taxation treaty',
                        'LGPD applies; providers abroad need ANPD standard contractual clauses',
                        '50% of ICT export proceeds may be kept in an ERQ account (Bangladesh Bank, Jul 2026)',
                    ],
                    'pt_BR' => [
                        'IOF de 3,5% sobre o câmbio pago pelo cliente (Decreto 12.499/2025)',
                        'Retenção de 25% de imposto de renda sobre serviços pagos a não residentes (regras tributárias brasileiras, out. 2026)',
                        'Não há tratado contra a bitributação entre Brasil e Bangladesh',
                        'A LGPD se aplica; prestadores no exterior precisam das cláusulas-padrão da ANPD',
                        '50% das receitas de exportação de TIC podem ficar em conta ERQ (Bangladesh Bank, jul. 2026)',
                    ],
                    'bn' => [
                        'ক্লায়েন্টের বৈদেশিক মুদ্রা পরিশোধে ৩.৫% আইওএফ (ডিক্রি ১২.৪৯৯/২০২৫)',
                        'অনিবাসীকে দেওয়া সেবামূল্যে ২৫% আয়কর কর্তন (ব্রাজিলের কর বিধি, অক্টোবর ২০২৬)',
                        'ব্রাজিল-বাংলাদেশ দ্বৈত কর চুক্তি নেই',
                        'এলজিপিডি প্রযোজ্য; বিদেশি সেবাদাতার জন্য এএনপিডির স্ট্যান্ডার্ড কনট্রাকচুয়াল ক্লজ লাগে',
                        'আইসিটি রপ্তানি আয়ের ৫০% ইআরকিউ হিসাবে রাখা যায় (বাংলাদেশ ব্যাংক, জুলাই ২০২৬)',
                    ],
                ],
            ],
        ];
    }
}
