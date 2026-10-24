<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;

/**
 * The expo's nine sectors with one sourced headline figure each (docs/research/02 §3, ComexStat 2025).
 * PT and BN copy is AI-drafted and awaits client review (spec §11). Safe to run repeatedly.
 */
class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $million = ['en' => 'm', 'pt_BR' => ' mi', 'bn' => ' মিলিয়ন'];
        $billion = ['en' => 'bn', 'pt_BR' => ' bi', 'bn' => ' বিলিয়ন'];

        $sectors = [
            [
                'slug' => ['en' => 'garments', 'pt_BR' => 'vestuario', 'bn' => 'garments'],
                'icon' => 'shirt',
                'image' => 'expo25-stand-garments',
                'name' => ['en' => 'Garments', 'pt_BR' => 'Vestuário', 'bn' => 'তৈরি পোশাক'],
                'summary' => [
                    'en' => 'Knitwear, wovens, denim and sweaters from the world\'s second-largest apparel exporter.',
                    'pt_BR' => 'Malhas, tecidos planos, jeans e suéteres do segundo maior exportador de roupas do mundo.',
                    'bn' => 'বিশ্বের দ্বিতীয় বৃহত্তম পোশাক রপ্তানিকারকের নিট, ওভেন, ডেনিম ও সোয়েটার।',
                ],
                'figure_value' => 240,
                'figure_prefix' => 'US$',
                'figure_suffix' => $million,
                'figure_label' => [
                    'en' => "Brazil's clothing imports from Bangladesh",
                    'pt_BR' => 'Importações brasileiras de roupas de Bangladesh',
                    'bn' => 'বাংলাদেশ থেকে ব্রাজিলের পোশাক আমদানি',
                ],
                'figure_source' => 'ComexStat, 2025',
            ],
            [
                'slug' => ['en' => 'textiles', 'pt_BR' => 'texteis', 'bn' => 'textiles'],
                'icon' => 'layers',
                'image' => 'sector-textiles',
                'name' => ['en' => 'Home & technical textiles', 'pt_BR' => 'Têxteis para casa e técnicos', 'bn' => 'হোম ও টেকনিক্যাল টেক্সটাইল'],
                'summary' => [
                    'en' => 'Bed linen, towels, curtains, yarn and technical fabrics for a large home-goods market.',
                    'pt_BR' => 'Roupa de cama, toalhas, cortinas, fios e tecidos técnicos para um grande mercado de casa.',
                    'bn' => 'বিছানার চাদর, তোয়ালে, পর্দা, সুতা ও টেকনিক্যাল কাপড়, গৃহস্থালি পণ্যের বড় বাজারের জন্য।',
                ],
                'figure_value' => 377,
                'figure_prefix' => 'US$',
                'figure_suffix' => $million,
                'figure_label' => [
                    'en' => "Brazil's imports of made-up textiles (HS 63)",
                    'pt_BR' => 'Importações brasileiras de artefatos têxteis (SH 63)',
                    'bn' => 'ব্রাজিলের তৈরি টেক্সটাইল পণ্য আমদানি (এইচএস ৬৩)',
                ],
                'figure_source' => 'ComexStat, 2025',
            ],
            [
                'slug' => ['en' => 'pharmaceuticals', 'pt_BR' => 'farmaceuticos', 'bn' => 'pharmaceuticals'],
                'icon' => 'pill',
                'image' => 'sector-pharmaceuticals',
                'name' => ['en' => 'Pharmaceuticals', 'pt_BR' => 'Farmacêuticos', 'bn' => 'ওষুধ'],
                'summary' => [
                    'en' => 'Generics and APIs from WHO-GMP plants. ANVISA registration and a local holder are required.',
                    'pt_BR' => 'Genéricos e IFAs de fábricas com BPF da OMS. Exigem registro na ANVISA e um detentor local.',
                    'bn' => 'ডব্লিউএইচও-জিএমপি কারখানার জেনেরিক ওষুধ ও এপিআই। আনভিসা নিবন্ধন ও স্থানীয় হোল্ডার প্রয়োজন।',
                ],
                'figure_value' => 14.5,
                'figure_decimals' => 1,
                'figure_prefix' => 'US$',
                'figure_suffix' => $billion,
                'figure_label' => [
                    'en' => "Brazil's pharmaceutical imports (HS 30)",
                    'pt_BR' => 'Importações farmacêuticas do Brasil (SH 30)',
                    'bn' => 'ব্রাজিলের ওষুধ আমদানি (এইচএস ৩০)',
                ],
                'figure_source' => 'ComexStat, 2025',
            ],
            [
                'slug' => ['en' => 'leather-footwear', 'pt_BR' => 'couro-e-calcados', 'bn' => 'leather-footwear'],
                'icon' => 'footprints',
                'image' => 'sector-leather-footwear',
                'name' => ['en' => 'Leather & footwear', 'pt_BR' => 'Couro e calçados', 'bn' => 'চামড়া ও জুতা'],
                'summary' => [
                    'en' => 'Leather goods, bags and footwear, including from LWG-certified tanneries.',
                    'pt_BR' => 'Artigos de couro, bolsas e calçados, inclusive de curtumes com certificação LWG.',
                    'bn' => 'চামড়াজাত পণ্য, ব্যাগ ও জুতা, এলডব্লিউজি-সনদপ্রাপ্ত ট্যানারির পণ্যসহ।',
                ],
                'figure_value' => 680,
                'figure_prefix' => 'US$',
                'figure_suffix' => $million,
                'figure_label' => [
                    'en' => "Brazil's imports of leather goods and bags (HS 42)",
                    'pt_BR' => 'Importações brasileiras de artigos de couro e bolsas (SH 42)',
                    'bn' => 'ব্রাজিলের চামড়াজাত পণ্য ও ব্যাগ আমদানি (এইচএস ৪২)',
                ],
                'figure_source' => 'ComexStat, 2025',
            ],
            [
                'slug' => ['en' => 'jute', 'pt_BR' => 'juta', 'bn' => 'jute'],
                'icon' => 'leaf',
                'image' => 'sector-jute',
                'name' => ['en' => 'Jute & jute goods', 'pt_BR' => 'Juta e produtos de juta', 'bn' => 'পাট ও পাটজাত পণ্য'],
                'summary' => [
                    'en' => 'Coffee and cocoa sacks, yarn, geotextiles and eco-friendly bags from the golden fibre.',
                    'pt_BR' => 'Sacarias para café e cacau, fios, geotêxteis e sacolas ecológicas da fibra dourada.',
                    'bn' => 'সোনালি আঁশ থেকে কফি ও কোকোর বস্তা, সুতা, জিওটেক্সটাইল ও পরিবেশবান্ধব ব্যাগ।',
                ],
                'figure_value' => 18.1,
                'figure_decimals' => 1,
                'figure_suffix' => ['en' => '%', 'pt_BR' => '%', 'bn' => '%'],
                'figure_label' => [
                    'en' => "Bangladesh's share of Brazil's jute and vegetable-fibre imports (HS 53)",
                    'pt_BR' => 'Participação de Bangladesh nas importações brasileiras de juta e fibras vegetais (SH 53)',
                    'bn' => 'ব্রাজিলের পাট ও উদ্ভিজ্জ আঁশ আমদানিতে বাংলাদেশের অংশ (এইচএস ৫৩)',
                ],
                'figure_source' => 'ComexStat, 2025',
            ],
            [
                'slug' => ['en' => 'agro-food', 'pt_BR' => 'agroalimentos', 'bn' => 'agro-food'],
                'icon' => 'wheat',
                'image' => 'sector-agro-food',
                'name' => ['en' => 'Agro-food & seafood', 'pt_BR' => 'Agroalimentos e pescados', 'bn' => 'কৃষি-খাদ্য ও সামুদ্রিক খাবার'],
                'summary' => [
                    'en' => 'Frozen shrimp and fish, spices, snacks and processed foods, under MAPA and ANVISA rules.',
                    'pt_BR' => 'Camarão e peixe congelados, especiarias, snacks e alimentos processados, sob regras do MAPA e da ANVISA.',
                    'bn' => 'হিমায়িত চিংড়ি ও মাছ, মসলা, স্ন্যাকস ও প্রক্রিয়াজাত খাবার, মাপা ও আনভিসার নিয়ম মেনে।',
                ],
                'figure_value' => 1.44,
                'figure_decimals' => 2,
                'figure_prefix' => 'US$',
                'figure_suffix' => $billion,
                'figure_label' => [
                    'en' => "Brazil's fish and seafood imports (HS 03)",
                    'pt_BR' => 'Importações brasileiras de peixes e frutos do mar (SH 03)',
                    'bn' => 'ব্রাজিলের মাছ ও সামুদ্রিক খাবার আমদানি (এইচএস ০৩)',
                ],
                'figure_source' => 'ComexStat, 2025',
            ],
            [
                'slug' => ['en' => 'handicrafts', 'pt_BR' => 'artesanato', 'bn' => 'handicrafts'],
                'icon' => 'palette',
                'image' => 'sector-handicrafts',
                'name' => ['en' => 'Handicrafts & décor', 'pt_BR' => 'Artesanato e decoração', 'bn' => 'হস্তশিল্প ও গৃহসজ্জা'],
                'summary' => [
                    'en' => 'Ceramics, home décor, baskets and handmade gifts with a story behind every piece.',
                    'pt_BR' => 'Cerâmica, decoração, cestaria e presentes artesanais com uma história em cada peça.',
                    'bn' => 'সিরামিক, গৃহসজ্জা, ঝুড়ি ও হাতে তৈরি উপহার, প্রতিটির পেছনে একটি গল্প।',
                ],
                'figure_value' => 1.40,
                'figure_decimals' => 2,
                'figure_prefix' => 'US$',
                'figure_suffix' => $billion,
                'figure_label' => [
                    'en' => "Brazil's furniture and lighting imports (HS 94)",
                    'pt_BR' => 'Importações brasileiras de móveis e iluminação (SH 94)',
                    'bn' => 'ব্রাজিলের আসবাব ও আলোকসজ্জা পণ্য আমদানি (এইচএস ৯৪)',
                ],
                'figure_source' => 'ComexStat, 2025',
            ],
            [
                'slug' => ['en' => 'plastics-toys', 'pt_BR' => 'plasticos-e-brinquedos', 'bn' => 'plastics-toys'],
                'icon' => 'puzzle',
                'image' => 'sector-plastics-toys',
                'name' => ['en' => 'Plastics & toys', 'pt_BR' => 'Plásticos e brinquedos', 'bn' => 'প্লাস্টিক ও খেলনা'],
                'summary' => [
                    'en' => 'Household plastics, packaging and toys. Toys need INMETRO certification.',
                    'pt_BR' => 'Utilidades plásticas, embalagens e brinquedos. Brinquedos exigem certificação do INMETRO.',
                    'bn' => 'গৃহস্থালি প্লাস্টিক, প্যাকেজিং ও খেলনা। খেলনার জন্য ইনমেট্রো সনদ লাগে।',
                ],
                'figure_value' => 1.16,
                'figure_decimals' => 2,
                'figure_prefix' => 'US$',
                'figure_suffix' => $billion,
                'figure_label' => [
                    'en' => "Brazil's toy and sports-goods imports (HS 95)",
                    'pt_BR' => 'Importações brasileiras de brinquedos e artigos esportivos (SH 95)',
                    'bn' => 'ব্রাজিলের খেলনা ও ক্রীড়াসামগ্রী আমদানি (এইচএস ৯৫)',
                ],
                'figure_source' => 'ComexStat, 2025',
            ],
            [
                'slug' => ['en' => 'ict', 'pt_BR' => 'tic', 'bn' => 'ict'],
                'icon' => 'cpu',
                'image' => 'sector-ict',
                'name' => ['en' => 'ICT & software', 'pt_BR' => 'TIC e software', 'bn' => 'আইসিটি ও সফটওয়্যার'],
                'summary' => [
                    'en' => 'Software, BPO and IT services that keep working while Brazil sleeps.',
                    'pt_BR' => 'Software, BPO e serviços de TI que seguem trabalhando enquanto o Brasil dorme.',
                    'bn' => 'সফটওয়্যার, বিপিও ও আইটি সেবা, ব্রাজিল যখন ঘুমায় তখনও কাজ চলে।',
                ],
                'figure_value' => 9,
                'figure_suffix' => ['en' => ' h', 'pt_BR' => ' h', 'bn' => ' ঘণ্টা'],
                'figure_label' => [
                    'en' => 'Time difference: an extra working day for Brazilian clients',
                    'pt_BR' => 'Diferença de fuso: um dia útil a mais para clientes brasileiros',
                    'bn' => 'সময়ের পার্থক্য: ব্রাজিলের ক্লায়েন্টদের জন্য বাড়তি একটি কর্মদিবস',
                ],
                'figure_source' => 'São Paulo–Dhaka',
            ],
        ];

        foreach ($sectors as $sort => $sector) {
            $existing = Sector::query()->where('slug->en', $sector['slug']['en'])->firstOr(
                fn (): Sector => Sector::create($sector + ['sort' => $sort]),
            );

            // Sectors seeded before they had photos get one; a photo staff chose is left alone.
            if ($existing->image === null && isset($sector['image'])) {
                $existing->update(['image' => $sector['image']]);
            }
        }
    }
}
