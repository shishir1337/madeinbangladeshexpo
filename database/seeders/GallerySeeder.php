<?php

namespace Database\Seeders;

use App\Models\Edition;
use App\Models\GalleryAlbum;
use Illuminate\Database\Seeder;

/**
 * Two albums from BBCCI's own photos (docs/research/01 §4, §16): the 2025 expo in São Paulo and the chamber's
 * events in Dhaka. Captions name only people the research identifies. PT and BN are AI-drafted and await client
 * review. Safe to run repeatedly: albums match on their English slug, photos on their image key.
 */
class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $edition2025 = Edition::query()->where('slug', '2025')->value('id');

        foreach ($this->albums() as $sort => $album) {
            $record = GalleryAlbum::query()->where('slug->en', $album['slug']['en'])->first()
                ?? GalleryAlbum::create([
                    'edition_id' => $album['edition'] ? $edition2025 : null,
                    'slug' => $album['slug'],
                    'title' => $album['title'],
                    'description' => $album['description'],
                    'cover' => $album['cover'],
                    'period' => $album['period'],
                    'sort' => $sort,
                ]);

            foreach ($album['photos'] as $photoSort => [$image, $caption]) {
                $record->photos()->firstOrCreate(['image' => $image], ['caption' => $caption, 'sort' => $photoSort]);
            }
        }
    }

    /**
     * @return list<array{slug: array<string, string>, title: array<string, string>, description: array<string, string>, cover: string, period: string, edition: bool, photos: list<array{string, array<string, string>}>}>
     */
    private function albums(): array
    {
        return [
            [
                'slug' => ['en' => 'expo-2025-sao-paulo', 'pt_BR' => 'feira-2025-sao-paulo', 'bn' => 'expo-2025-sao-paulo'],
                'title' => ['en' => 'Expo 2025, São Paulo', 'pt_BR' => 'Feira 2025, São Paulo', 'bn' => 'এক্সপো ২০২৫, সাও পাওলো'],
                'description' => [
                    'en' => 'The first Made in Bangladesh Expo: stalls, speeches and the people who came, 15–18 June 2025.',
                    'pt_BR' => 'A primeira Made in Bangladesh Expo: estandes, discursos e as pessoas que vieram, de 15 a 18 de junho de 2025.',
                    'bn' => 'প্রথম মেইড ইন বাংলাদেশ এক্সপো: স্টল, বক্তৃতা আর অংশ নেওয়া মানুষেরা, ১৫–১৮ জুন ২০২৫।',
                ],
                'cover' => 'expo25-welcome',
                'period' => '2025-06',
                'edition' => true,
                'photos' => [
                    ['expo25-welcome', ['en' => 'BBCCI leaders and guests at the welcome gate', 'pt_BR' => 'Líderes da BBCCI e convidados no portal de entrada', 'bn' => 'প্রবেশদ্বারে বিবিসিসিআইয়ের নেতৃবৃন্দ ও অতিথিরা']],
                    ['expo25-welcome-2', ['en' => 'Guests arriving at the expo', 'pt_BR' => 'Convidados chegando à feira', 'bn' => 'এক্সপোতে অতিথিদের আগমন']],
                    ['expo25-speaker-shahriar-ahmed', ['en' => 'Shahriar Ahmed, President of BBCCI, speaking at the opening', 'pt_BR' => 'Shahriar Ahmed, presidente da BBCCI, discursa na abertura', 'bn' => 'উদ্বোধনে বক্তব্য দিচ্ছেন বিবিসিসিআইয়ের সভাপতি শাহরিয়ার আহমেদ']],
                    ['expo25-speaker-joynal-abdin', ['en' => 'Md. Joynal Abdin, Secretary General of BBCCI, presenting the expo', 'pt_BR' => 'Md. Joynal Abdin, secretário-geral da BBCCI, apresenta a feira', 'bn' => 'এক্সপো উপস্থাপন করছেন বিবিসিসিআইয়ের মহাসচিব মো. জয়নাল আবদীন']],
                    ['expo25-speaker-taufiqul-islam', ['en' => 'The chief guest addresses the opening ceremony', 'pt_BR' => 'O convidado de honra fala na cerimônia de abertura', 'bn' => 'উদ্বোধনী অনুষ্ঠানে প্রধান অতিথির বক্তব্য']],
                    ['expo25-speaker-regina-nunes', ['en' => 'Regina Carnovale Nunes speaking at the expo', 'pt_BR' => 'Regina Carnovale Nunes discursa na feira', 'bn' => 'এক্সপোতে বক্তব্য দিচ্ছেন রেজিনা কার্নোভালে নুনেস']],
                    ['expo25-speaker-saiful-alam', ['en' => 'Md. Saiful Alam, Vice President of BBCCI, at the podium', 'pt_BR' => 'Md. Saiful Alam, vice-presidente da BBCCI, no púlpito', 'bn' => 'মঞ্চে বিবিসিসিআইয়ের সহসভাপতি মো. সাইফুল আলম']],
                    ['expo25-guests', ['en' => 'Guests of honour at the 2025 expo', 'pt_BR' => 'Convidados de honra na feira de 2025', 'bn' => '২০২৫ সালের এক্সপোতে সম্মানিত অতিথিরা']],
                    ['expo25-delegation', ['en' => 'The Bangladeshi business delegation in São Paulo', 'pt_BR' => 'A delegação empresarial de Bangladesh em São Paulo', 'bn' => 'সাও পাওলোতে বাংলাদেশি ব্যবসায়ী প্রতিনিধিদল']],
                    ['expo25-stand-sts', ['en' => 'The STS Apparel stall', 'pt_BR' => 'O estande da STS Apparel', 'bn' => 'এসটিএস অ্যাপারেলের স্টল']],
                    ['expo25-stand-garments', ['en' => 'Visitors at a garments stall', 'pt_BR' => 'Visitantes em um estande de vestuário', 'bn' => 'পোশাকের স্টলে দর্শনার্থীরা']],
                    ['expo25-stand-accessories', ['en' => 'Exhibitors and visitors at an accessories stall', 'pt_BR' => 'Expositores e visitantes em um estande de acessórios', 'bn' => 'অ্যাকসেসরিজের স্টলে প্রদর্শক ও দর্শনার্থীরা']],
                    ['expo25-trade-mission', ['en' => 'The BBCCI delegation during the 2025 trade mission', 'pt_BR' => 'A delegação da BBCCI durante a missão comercial de 2025', 'bn' => '২০২৫ সালের বাণিজ্য মিশনে বিবিসিসিআই প্রতিনিধিদল']],
                ],
            ],
            [
                'slug' => ['en' => 'brazil-bangladesh-events-dhaka', 'pt_BR' => 'eventos-brasil-bangladesh-daca', 'bn' => 'brazil-bangladesh-events-dhaka'],
                'title' => ['en' => 'Brazil–Bangladesh events, Dhaka', 'pt_BR' => 'Eventos Brasil–Bangladesh, Daca', 'bn' => 'ব্রাজিল–বাংলাদেশ আয়োজন, ঢাকা'],
                'description' => [
                    'en' => 'Press conferences, business forums and meetings in Dhaka that built the road to São Paulo, 2024–2025.',
                    'pt_BR' => 'Coletivas de imprensa, fóruns empresariais e reuniões em Daca que abriram o caminho para São Paulo, 2024–2025.',
                    'bn' => 'ঢাকায় সংবাদ সম্মেলন, ব্যবসায়িক ফোরাম ও বৈঠক, যা সাও পাওলোর পথ তৈরি করেছে, ২০২৪–২০২৫।',
                ],
                'cover' => 'fbcci-2024-podium',
                'period' => '2024-03',
                'edition' => false,
                'photos' => [
                    ['press-2025-05', ['en' => 'The Dhaka press conference announcing the 2025 expo, supported by the Embassy of Brazil', 'pt_BR' => 'A coletiva em Daca que anunciou a feira de 2025, com apoio da Embaixada do Brasil', 'bn' => 'ব্রাজিল দূতাবাসের সহায়তায় ২০২৫ সালের এক্সপো ঘোষণার ঢাকার সংবাদ সম্মেলন']],
                    ['press-2025-12', ['en' => 'Speakers at the Dhaka press conference', 'pt_BR' => 'Palestrantes na coletiva de imprensa em Daca', 'bn' => 'ঢাকার সংবাদ সম্মেলনের বক্তারা']],
                    ['press-2026-05', ['en' => 'The press conference banner: the first Made in Bangladesh Expo on Latin American soil', 'pt_BR' => 'O painel da coletiva: a primeira Made in Bangladesh Expo em solo latino-americano', 'bn' => 'সংবাদ সম্মেলনের ব্যানার: লাতিন আমেরিকার মাটিতে প্রথম মেইড ইন বাংলাদেশ এক্সপো']],
                    ['fbcci-2024-podium', ['en' => 'Mauro Vieira, Foreign Minister of Brazil, at the FBCCI–BBCCI meeting, Dhaka, 2024', 'pt_BR' => 'Mauro Vieira, ministro das Relações Exteriores do Brasil, na reunião FBCCI–BBCCI, Daca, 2024', 'bn' => '২০২৪ সালে ঢাকায় এফবিসিসিআই–বিবিসিসিআই বৈঠকে ব্রাজিলের পররাষ্ট্রমন্ত্রী মাউরো ভিয়েইরা']],
                    ['fbcci-2024-group', ['en' => 'Brazilian and Bangladeshi business leaders with Brazil\'s Foreign Minister', 'pt_BR' => 'Líderes empresariais brasileiros e bangladeshis com o chanceler do Brasil', 'bn' => 'ব্রাজিলের পররাষ্ট্রমন্ত্রীর সঙ্গে দুই দেশের ব্যবসায়ী নেতারা']],
                    ['fbcci-2024-leaders', ['en' => 'H.E. Paulo Fernando Dias Feres, Ambassador of Brazil and Chief Patron of BBCCI, with chamber leaders', 'pt_BR' => 'S. Exa. Paulo Fernando Dias Feres, embaixador do Brasil e patrono-chefe da BBCCI, com líderes da câmara', 'bn' => 'চেম্বারের নেতাদের সঙ্গে ব্রাজিলের রাষ্ট্রদূত ও বিবিসিসিআইয়ের প্রধান পৃষ্ঠপোষক পাওলো ফের্নান্দো দিয়াস ফেরেস']],
                    ['fbcci-2024-fm-selfie', ['en' => 'A moment from the FBCCI–BBCCI meeting', 'pt_BR' => 'Um momento da reunião FBCCI–BBCCI', 'bn' => 'এফবিসিসিআই–বিবিসিসিআই বৈঠকের একটি মুহূর্ত']],
                    ['fbcci-2024-meeting', ['en' => 'BBCCI seminar in Dhaka, 2024', 'pt_BR' => 'Seminário da BBCCI em Daca, 2024', 'bn' => '২০২৪ সালে ঢাকায় বিবিসিসিআইয়ের সেমিনার']],
                    ['bbcci-bgmea-2024', ['en' => 'BBCCI and BGMEA leaders meet in Dhaka, May 2024', 'pt_BR' => 'Líderes da BBCCI e da BGMEA reunidos em Daca, maio de 2024', 'bn' => '২০২৪ সালের মে মাসে ঢাকায় বিবিসিসিআই ও বিজিএমইএর নেতাদের বৈঠক']],
                    ['forum-2024-panel', ['en' => 'Panel at a BBCCI business forum, Dhaka, 2024', 'pt_BR' => 'Painel em um fórum empresarial da BBCCI, Daca, 2024', 'bn' => '২০২৪ সালে ঢাকায় বিবিসিসিআইয়ের ব্যবসায়িক ফোরামের প্যানেল']],
                    ['forum-2024-speech', ['en' => 'A speech at the BBCCI business forum', 'pt_BR' => 'Discurso no fórum empresarial da BBCCI', 'bn' => 'বিবিসিসিআইয়ের ব্যবসায়িক ফোরামে বক্তব্য']],
                    ['forum-2024-audience', ['en' => 'Business leaders in the audience at the forum', 'pt_BR' => 'Líderes empresariais na plateia do fórum', 'bn' => 'ফোরামে উপস্থিত ব্যবসায়ী নেতারা']],
                ],
            ],
        ];
    }
}
