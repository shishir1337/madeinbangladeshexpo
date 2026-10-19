<?php

namespace Database\Seeders;

use App\Enums\NewsType;
use App\Models\NewsArticle;
use Illuminate\Database\Seeder;

/**
 * The organiser's five newsroom items and eight media reports (docs/research/02 §3 and §7, research/03 §A.1;
 * coverage URLs as linked from the competitor's newsroom and checked against the publishers). The next
 * edition's facts are tokens replaced at render time. PT and BN copy is AI-drafted and awaits client review
 * (spec §11). Safe to run repeatedly: existing articles are left as staff edited them.
 */
class NewsArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([...$this->organiserNews(), ...$this->mediaCoverage()] as $article) {
            NewsArticle::query()->where('slug->en', $article['slug']['en'])->firstOr(
                fn (): NewsArticle => NewsArticle::create($article),
            );
        }
    }

    /**
     * News and press releases published by BBCCI.
     *
     * @return list<array{type: NewsType, slug: array<string, string>, title: array<string, string>, excerpt: array<string, string>, body: array<string, string>, image: ?string, published_at: string}>
     */
    private function organiserNews(): array
    {
        return [
            [
                'type' => NewsType::PressRelease,
                'slug' => [
                    'en' => 'made-in-bangladesh-expo-launched-in-dhaka',
                    'pt_BR' => 'made-in-bangladesh-expo-lancada-em-daca',
                    'bn' => 'made-in-bangladesh-expo-launched-in-dhaka',
                ],
                'title' => [
                    'en' => 'BBCCI presents the first Made in Bangladesh Expo in Dhaka',
                    'pt_BR' => 'BBCCI apresenta em Daca a primeira Made in Bangladesh Expo',
                    'bn' => 'ঢাকায় প্রথম মেইড ইন বাংলাদেশ এক্সপোর ঘোষণা দিল বিবিসিসিআই',
                ],
                'excerpt' => [
                    'en' => 'With Brazil\'s ambassador Paulo Fernando Dias Feres at its side, BBCCI announced in Dhaka that Bangladeshi manufacturers will exhibit in São Paulo on 15–18 June 2025.',
                    'pt_BR' => 'Ao lado do embaixador do Brasil, Paulo Fernando Dias Feres, a BBCCI anunciou em Daca que fabricantes de Bangladesh vão expor em São Paulo de 15 a 18 de junho de 2025.',
                    'bn' => 'ব্রাজিলের রাষ্ট্রদূত পাওলো ফের্নান্দো দিয়াস ফেরেসের উপস্থিতিতে বিবিসিসিআই ঢাকায় জানাল, ২০২৫ সালের ১৫–১৮ জুন সাও পাওলোতে প্রদর্শনী করবেন বাংলাদেশের উৎপাদকেরা।',
                ],
                'body' => [
                    'en' => <<<'MD'
                        The Brazil Bangladesh Chamber of Commerce & Industry (BBCCI) presented the first Made in Bangladesh Expo to the press on 8 January 2025, in the Grand Ball Room of Hotel Ascott Palace in Dhaka's Baridhara Diplomatic Zone. The expo will take Bangladeshi manufacturers to São Paulo, Brazil, on 15–18 June 2025, the first Made in Bangladesh expo to be held in Latin America.

                        BBCCI Vice President Md. Saiful Alam opened the event with a welcome address, and Secretary General Md. Joynal Abdin set out the plans for the expo in the keynote. The Ambassador of Brazil to Bangladesh, Paulo Fernando Dias Feres, also spoke. The event had the support of the Embassy of Brazil in Dhaka, whose Deputy Head of Mission, Leonardo de Oliveira Jannuzzi, and Agriculture Attaché, Silvio Luiz Rodrigues Testaseca, attended.

                        ## A bridge between two markets

                        Ambassador Feres presented the exhibition as an important step in relations between the two countries and a chance for Bangladeshi companies to show the quality of their products and find partners. Mr Alam called it a major opportunity for the country's exporters, and Mr Abdin described it as a bridge between the cultures and the commerce of Brazil and Bangladesh. As background, BBCCI put bilateral trade at US$2.53 billion (BBCCI, 2022 figures).

                        ## What the expo sets out to do

                        BBCCI has set four aims: to put Bangladeshi products in front of buyers from Brazil and the rest of Latin America, to open new markets for Bangladeshi companies, to encourage trade in both directions, and to build lasting partnerships between companies and investors of the two countries. Besides the stalls, the programme will include B2B matchmaking, policy discussions and cultural showcases. Garments, jute, pharmaceuticals, leather and textiles are among the sectors BBCCI expects to bring.

                        Exhibitor registration is open with BBCCI, and a 10% early-bird discount applies to registrations completed by 31 January 2025 (BBCCI prospectus, 2025).
                        MD,
                    'pt_BR' => <<<'MD'
                        A Câmara de Comércio e Indústria Brasil-Bangladesh (BBCCI) apresentou à imprensa a primeira Made in Bangladesh Expo em 8 de janeiro de 2025, no Grand Ball Room do Hotel Ascott Palace, na Zona Diplomática de Baridhara, em Daca. A feira levará fabricantes de Bangladesh a São Paulo de 15 a 18 de junho de 2025, na primeira Made in Bangladesh Expo realizada na América Latina.

                        O vice-presidente da BBCCI, Md. Saiful Alam, abriu o evento com as boas-vindas, e o secretário-geral, Md. Joynal Abdin, apresentou os planos da feira na palestra principal. O embaixador do Brasil em Bangladesh, Paulo Fernando Dias Feres, também discursou. O evento teve o apoio da Embaixada do Brasil em Daca, representada também pelo chefe-adjunto da missão, Leonardo de Oliveira Jannuzzi, e pelo adido agrícola, Silvio Luiz Rodrigues Testaseca.

                        ## Uma ponte entre dois mercados

                        O embaixador Feres descreveu a exposição como um passo importante nas relações entre os dois países e uma chance para as empresas de Bangladesh mostrarem a qualidade de seus produtos e encontrarem parceiros. Alam a chamou de grande oportunidade para os exportadores do país, e Abdin a apresentou como uma ponte entre as culturas e o comércio do Brasil e de Bangladesh. Como contexto, a BBCCI citou um comércio bilateral de US$ 2,53 bilhões (BBCCI, dados de 2022).

                        ## O que a feira pretende

                        A BBCCI definiu quatro objetivos: apresentar produtos de Bangladesh a compradores do Brasil e do restante da América Latina, abrir novos mercados para as empresas bangladesas, estimular o comércio nos dois sentidos e criar parcerias duradouras entre empresas e investidores dos dois países. Além dos estandes, a programação terá rodadas de negócios (B2B), debates sobre políticas e apresentações culturais. Vestuário, juta, farmacêuticos, couro e têxteis estão entre os setores que a BBCCI espera reunir.

                        As inscrições de expositores já estão abertas na BBCCI, com desconto de 10% para inscrições concluídas até 31 de janeiro de 2025 (prospecto da BBCCI, 2025).
                        MD,
                    'bn' => <<<'MD'
                        ব্রাজিল বাংলাদেশ চেম্বার অব কমার্স অ্যান্ড ইন্ডাস্ট্রি (বিবিসিসিআই) ২০২৫ সালের ৮ জানুয়ারি ঢাকার বারিধারা কূটনৈতিক এলাকার হোটেল অ্যাসকট প্যালেসের গ্র্যান্ড বলরুমে সংবাদ সম্মেলনে প্রথম মেইড ইন বাংলাদেশ এক্সপোর ঘোষণা দেয়। ২০২৫ সালের ১৫–১৮ জুন ব্রাজিলের সাও পাওলোতে এই এক্সপোতে অংশ নেবেন বাংলাদেশের উৎপাদকেরা; লাতিন আমেরিকায় এটিই প্রথম মেইড ইন বাংলাদেশ এক্সপো।

                        স্বাগত বক্তব্য দেন বিবিসিসিআইয়ের সহসভাপতি মো. সাইফুল আলম, আর মূল উপস্থাপনায় এক্সপোর পরিকল্পনা তুলে ধরেন মহাসচিব মো. জয়নাল আবদীন। বাংলাদেশে নিযুক্ত ব্রাজিলের রাষ্ট্রদূত পাওলো ফের্নান্দো দিয়াস ফেরেসও বক্তব্য দেন। ঢাকার ব্রাজিল দূতাবাসের সহযোগিতায় আয়োজিত এই অনুষ্ঠানে দূতাবাসের উপমিশনপ্রধান লিওনার্দো দে অলিভেইরা জানুজি এবং কৃষি অ্যাটাশে সিলভিও লুইজ রদ্রিগেস তেস্তাসেকা উপস্থিত ছিলেন।

                        ## দুই বাজারের মধ্যে সেতু

                        রাষ্ট্রদূত ফেরেস এই প্রদর্শনীকে দুই দেশের সম্পর্কের একটি গুরুত্বপূর্ণ পদক্ষেপ এবং বাংলাদেশি প্রতিষ্ঠানগুলোর জন্য পণ্যের মান তুলে ধরা ও অংশীদার খোঁজার সুযোগ হিসেবে বর্ণনা করেন। সাইফুল আলম একে দেশের রপ্তানিকারকদের জন্য বড় সুযোগ বলে উল্লেখ করেন, আর জয়নাল আবদীন একে ব্রাজিল ও বাংলাদেশের সংস্কৃতি ও বাণিজ্যের মধ্যে সেতুবন্ধ হিসেবে তুলে ধরেন। প্রেক্ষাপট হিসেবে বিবিসিসিআই জানায়, দ্বিপক্ষীয় বাণিজ্যের পরিমাণ ২.৫৩ বিলিয়ন মার্কিন ডলার (বিবিসিসিআই, ২০২২ সালের তথ্য)।

                        ## এক্সপোর লক্ষ্য

                        বিবিসিসিআই চারটি লক্ষ্য ঠিক করেছে: ব্রাজিল ও লাতিন আমেরিকার অন্যান্য দেশের ক্রেতাদের সামনে বাংলাদেশি পণ্য তুলে ধরা, বাংলাদেশি প্রতিষ্ঠানের জন্য নতুন বাজার খোলা, দুই দিকেই বাণিজ্য বাড়ানো এবং দুই দেশের প্রতিষ্ঠান ও বিনিয়োগকারীদের মধ্যে দীর্ঘমেয়াদি অংশীদারত্ব গড়ে তোলা। স্টলের পাশাপাশি থাকবে বি২বি ম্যাচমেকিং, নীতিবিষয়ক আলোচনা ও সাংস্কৃতিক আয়োজন। পোশাক, পাট, ওষুধ, চামড়া ও বস্ত্র খাতের প্রতিষ্ঠানগুলোর অংশগ্রহণ আশা করছে বিবিসিসিআই।

                        প্রদর্শক নিবন্ধন এখন খোলা; ২০২৫ সালের ৩১ জানুয়ারির মধ্যে নিবন্ধন সম্পন্ন করলে ১০% আগাম ছাড় মিলবে (বিবিসিসিআই প্রসপেক্টাস, ২০২৫)।
                        MD,
                ],
                'image' => 'press-2025-12',
                'published_at' => '2025-01-08 12:00:00',
            ],
            [
                'type' => NewsType::News,
                'slug' => [
                    'en' => 'expo-roadshow-rangpur-chattogram',
                    'pt_BR' => 'divulgacao-da-feira-em-rangpur-e-chattogram',
                    'bn' => 'expo-roadshow-rangpur-chattogram',
                ],
                'title' => [
                    'en' => 'The expo roadshow reaches Rangpur and Chattogram',
                    'pt_BR' => 'A divulgação da feira chega a Rangpur e Chattogram',
                    'bn' => 'রংপুর ও চট্টগ্রামে এক্সপোর প্রচার',
                ],
                'excerpt' => [
                    'en' => 'After the Dhaka launch, BBCCI took the Made in Bangladesh Expo 2025 to business communities in Rangpur on 18 January and Chattogram on 1 February 2025.',
                    'pt_BR' => 'Depois do lançamento em Daca, a BBCCI levou a Made in Bangladesh Expo 2025 às comunidades empresariais de Rangpur, em 18 de janeiro, e de Chattogram, em 1º de fevereiro de 2025.',
                    'bn' => 'ঢাকায় ঘোষণার পর মেইড ইন বাংলাদেশ এক্সপো ২০২৫-এর প্রচারে বিবিসিসিআই ১৮ জানুয়ারি রংপুরে এবং ২০২৫ সালের ১ ফেব্রুয়ারি চট্টগ্রামে ব্যবসায়ীদের কাছে যায়।',
                ],
                'body' => [
                    'en' => <<<'MD'
                        After launching the Made in Bangladesh Expo 2025 in Dhaka on 8 January, BBCCI set out to reach exporters beyond the capital. Its plan for the expo included meetings with divisional chambers of commerce in the first months of the year, and the first two stops were Rangpur and Chattogram.

                        ## Rangpur, 18 January

                        The Rangpur Chamber of Commerce and Industry hosted a promotion meeting in the auditorium of Rangpur Chamber Bhaban. Brazil's Deputy Head of Mission in Dhaka, Leonardo de Oliveira Jannuzzi, was the chief guest, and the chamber's President, Md Akbar Ali, also addressed the meeting. Mr Jannuzzi told local businesspeople that Brazil could in time become their link to other Latin American markets, such as Argentina, Uruguay and Bolivia, and encouraged them to take part in the expo. He pointed to ready-made garments, pharmaceuticals, fish and ceramics as sectors that could interest Brazilian buyers.

                        ## Chattogram, 1 February

                        At the Chattogram Press Club, BBCCI Director Imran Chowdhury presented the expo to the port city's business community and press, with Mr Jannuzzi again in attendance. Mr Chowdhury said the expo would help market Bangladeshi products in Brazil and the rest of Latin America, and would also be an occasion to invite Brazilian entrepreneurs to invest in Bangladesh.

                        ## Registration

                        The 10% early-bird discount for exhibitors, first offered until 31 January, has been extended to 15 February 2025 (BGMEA circular, 28 January 2025).
                        MD,
                    'pt_BR' => <<<'MD'
                        Depois de lançar a Made in Bangladesh Expo 2025 em Daca, em 8 de janeiro, a BBCCI saiu da capital para encontrar exportadores de outras regiões. O plano da feira previa reuniões com as câmaras de comércio das divisões administrativas do país nos primeiros meses do ano, e as duas primeiras paradas foram Rangpur e Chattogram.

                        ## Rangpur, 18 de janeiro

                        A Câmara de Comércio e Indústria de Rangpur recebeu uma reunião de divulgação no auditório do Rangpur Chamber Bhaban. O convidado de honra foi o chefe-adjunto da missão do Brasil em Daca, Leonardo de Oliveira Jannuzzi, e o presidente da câmara, Md Akbar Ali, também discursou. Jannuzzi disse aos empresários locais que, com o tempo, o Brasil pode ser a ponte para outros mercados latino-americanos, como Argentina, Uruguai e Bolívia, e os incentivou a participar da feira. Ele citou confecções, farmacêuticos, pescado e cerâmica como setores capazes de interessar compradores brasileiros.

                        ## Chattogram, 1º de fevereiro

                        No Chattogram Press Club, o diretor da BBCCI Imran Chowdhury apresentou a feira à imprensa e aos empresários da cidade portuária, novamente com a presença de Jannuzzi. Segundo Chowdhury, a feira vai ajudar a promover produtos de Bangladesh no Brasil e no restante da América Latina e será também uma ocasião para convidar empresários brasileiros a investir em Bangladesh.

                        ## Inscrições

                        O desconto de 10% para expositores que se inscreverem cedo, oferecido inicialmente até 31 de janeiro, foi prorrogado até 15 de fevereiro de 2025 (circular da BGMEA, 28 de janeiro de 2025).
                        MD,
                    'bn' => <<<'MD'
                        ৮ জানুয়ারি ঢাকায় মেইড ইন বাংলাদেশ এক্সপো ২০২৫-এর ঘোষণার পর রাজধানীর বাইরের রপ্তানিকারকদের কাছে পৌঁছাতে উদ্যোগ নেয় বিবিসিসিআই। বছরের প্রথম মাসগুলোতে বিভাগীয় চেম্বারগুলোর সঙ্গে বৈঠক ছিল এক্সপোর পরিকল্পনার অংশ, আর প্রথম দুটি গন্তব্য ছিল রংপুর ও চট্টগ্রাম।

                        ## রংপুর, ১৮ জানুয়ারি

                        রংপুর চেম্বার ভবনের মিলনায়তনে প্রচারসভার আয়োজন করে রংপুর চেম্বার অব কমার্স অ্যান্ড ইন্ডাস্ট্রি। প্রধান অতিথি ছিলেন ঢাকায় ব্রাজিল দূতাবাসের উপমিশনপ্রধান লিওনার্দো দে অলিভেইরা জানুজি; বক্তব্য দেন চেম্বারের সভাপতি মো. আকবর আলীও। জানুজি স্থানীয় ব্যবসায়ীদের বলেন, সময়ের সঙ্গে ব্রাজিল তাঁদের জন্য আর্জেন্টিনা, উরুগুয়ে ও বলিভিয়ার মতো লাতিন আমেরিকার অন্যান্য বাজারে প্রবেশের সেতু হয়ে উঠতে পারে, এবং তিনি তাঁদের এক্সপোতে অংশ নিতে উৎসাহ দেন। ব্রাজিলের ক্রেতাদের আগ্রহ জাগাতে পারে এমন খাত হিসেবে তিনি তৈরি পোশাক, ওষুধ, মাছ ও সিরামিকের কথা উল্লেখ করেন।

                        ## চট্টগ্রাম, ১ ফেব্রুয়ারি

                        চট্টগ্রাম প্রেসক্লাবে বিবিসিসিআইয়ের পরিচালক ইমরান চৌধুরী বন্দরনগরীর ব্যবসায়ী ও সাংবাদিকদের সামনে এক্সপো তুলে ধরেন; এবারও উপস্থিত ছিলেন জানুজি। ইমরান চৌধুরী বলেন, এক্সপো ব্রাজিল ও লাতিন আমেরিকার অন্যান্য দেশে বাংলাদেশি পণ্যের বাজার তৈরিতে সহায়তা করবে, পাশাপাশি ব্রাজিলের উদ্যোক্তাদের বাংলাদেশে বিনিয়োগের আমন্ত্রণ জানানোরও সুযোগ করে দেবে।

                        ## নিবন্ধন

                        প্রদর্শকদের জন্য আগাম নিবন্ধনে ১০% ছাড়ের সময়সীমা ৩১ জানুয়ারি থেকে বাড়িয়ে ২০২৫ সালের ১৫ ফেব্রুয়ারি করা হয়েছে (বিজিএমইএ সার্কুলার, ২৮ জানুয়ারি ২০২৫)।
                        MD,
                ],
                'image' => null,
                'published_at' => '2025-02-01 12:00:00',
            ],
            [
                'type' => NewsType::News,
                'slug' => [
                    'en' => 'made-in-bangladesh-expo-opens-in-sao-paulo',
                    'pt_BR' => 'made-in-bangladesh-expo-abre-as-portas-em-sao-paulo',
                    'bn' => 'made-in-bangladesh-expo-opens-in-sao-paulo',
                ],
                'title' => [
                    'en' => 'Made in Bangladesh Expo opens its doors in São Paulo',
                    'pt_BR' => 'Made in Bangladesh Expo abre as portas em São Paulo',
                    'bn' => 'সাও পাওলোতে দরজা খুলল মেইড ইন বাংলাদেশ এক্সপো',
                ],
                'excerpt' => [
                    'en' => 'The first edition opened on 16 June 2025 at the Novotel São Paulo Center Norte, with three days of exhibition, B2B meetings and seminars ahead.',
                    'pt_BR' => 'A primeira edição foi aberta em 16 de junho de 2025 no Novotel São Paulo Center Norte, com três dias de exposição, rodadas de negócios e seminários pela frente.',
                    'bn' => '২০২৫ সালের ১৬ জুন নভোটেল সাও পাওলো সেন্টার নর্তেতে প্রথম আসরের উদ্বোধন হলো; সামনে তিন দিনের প্রদর্শনী, বি২বি বৈঠক ও সেমিনার।',
                ],
                'body' => [
                    'en' => <<<'MD'
                        The first Made in Bangladesh Expo opened on 16 June 2025 at the Novotel São Paulo Center Norte, Avenida Zaki Narchi 500, in São Paulo's Vila Guilherme district. Organised by BBCCI with the support of the Embassy of Brazil in Dhaka, it is the first Made in Bangladesh expo held in Latin America. Exhibitors set up their stalls on 15 June, and the exhibition and programme run from 16 to 18 June.

                        ## The opening

                        Bangladesh's Ambassador to Brazil, Dr Md Tauhedul Islam, opened the expo. BBCCI President Shahriar Ahmed, Vice President Md. Saiful Alam and Secretary General Md. Joynal Abdin addressed the guests, together with the leadership of BBCCI's Brazil Chapter. The Defence Attaché of the Embassy of Bangladesh in Brazil also attended.

                        ## Who is exhibiting

                        Fifteen companies were announced as exhibitors. Most of them make garments and textiles, and they are joined by pharmaceutical, technology and plastic-toy companies, among others. At their stalls they are meeting importers, wholesalers and distributors from Brazil and the rest of Latin America. Brazilian trade visitors enter free of charge after pre-registering online.

                        ## The programme

                        All times are São Paulo time.

                        - Monday 16 June: Meet the Press, 9:30–10:30; inaugural ceremony, 11:00–13:00; B2B matchmaking, 14:00–17:00.
                        - Tuesday 17 June: seminar on trade and investment opportunities between Bangladesh and Brazil, 11:00–13:00; B2B matchmaking, 14:00–17:00.
                        - Wednesday 18 June: seminar by a Brazilian expert, 11:00–13:00; B2B matchmaking, 14:00–17:00; Meet the Press and closing ceremony, 17:00–19:30.

                        **Update, 17 June 2025:** on the second day, Regina Carnovale Nunes, the First Lady of the City of São Paulo, visited the stalls and spoke at the expo.
                        MD,
                    'pt_BR' => <<<'MD'
                        A primeira Made in Bangladesh Expo foi aberta em 16 de junho de 2025 no Novotel São Paulo Center Norte, na Avenida Zaki Narchi, 500, na Vila Guilherme, em São Paulo. Organizada pela BBCCI com o apoio da Embaixada do Brasil em Daca, é a primeira Made in Bangladesh Expo realizada na América Latina. Os expositores montaram seus estandes em 15 de junho, e a exposição e a programação vão de 16 a 18 de junho.

                        ## A abertura

                        O embaixador de Bangladesh no Brasil, Dr. Md Tauhedul Islam, abriu a feira. O presidente da BBCCI, Shahriar Ahmed, o vice-presidente, Md. Saiful Alam, e o secretário-geral, Md. Joynal Abdin, falaram aos convidados, ao lado da diretoria do capítulo brasileiro da BBCCI. O adido de Defesa da Embaixada de Bangladesh no Brasil também esteve presente.

                        ## Quem expõe

                        Quinze empresas foram anunciadas como expositoras. A maioria fabrica roupas e têxteis; completam a lista empresas farmacêuticas, de tecnologia e de brinquedos plásticos, entre outras. Nos estandes, elas recebem importadores, atacadistas e distribuidores do Brasil e do restante da América Latina. Visitantes profissionais brasileiros entram gratuitamente com credenciamento prévio on-line.

                        ## A programação

                        Horários de São Paulo.

                        - Segunda-feira, 16 de junho: Meet the Press, 9h30–10h30; cerimônia de abertura, 11h–13h; rodadas de negócios, 14h–17h.
                        - Terça-feira, 17 de junho: seminário sobre oportunidades de comércio e investimento entre Bangladesh e Brasil, 11h–13h; rodadas de negócios, 14h–17h.
                        - Quarta-feira, 18 de junho: seminário com um especialista brasileiro, 11h–13h; rodadas de negócios, 14h–17h; Meet the Press e cerimônia de encerramento, 17h–19h30.

                        **Atualização, 17 de junho de 2025:** no segundo dia, a primeira-dama da cidade de São Paulo, Regina Carnovale Nunes, visitou os estandes e discursou na feira.
                        MD,
                    'bn' => <<<'MD'
                        ২০২৫ সালের ১৬ জুন সাও পাওলোর ভিলা গিয়েরমে এলাকার আভেনিদা জাকি নার্চি ৫০০-তে নভোটেল সাও পাওলো সেন্টার নর্তেতে প্রথম মেইড ইন বাংলাদেশ এক্সপোর উদ্বোধন হয়েছে। ঢাকার ব্রাজিল দূতাবাসের সহযোগিতায় বিবিসিসিআই আয়োজিত এই এক্সপো লাতিন আমেরিকায় প্রথম মেইড ইন বাংলাদেশ এক্সপো। প্রদর্শকেরা ১৫ জুন স্টল সাজিয়েছেন; প্রদর্শনী ও কর্মসূচি চলবে ১৬ থেকে ১৮ জুন।

                        ## উদ্বোধন

                        ব্রাজিলে নিযুক্ত বাংলাদেশের রাষ্ট্রদূত ড. মো. তৌহিদুল ইসলাম এক্সপোর উদ্বোধন করেন। বিবিসিসিআইয়ের সভাপতি শাহরিয়ার আহমেদ, সহসভাপতি মো. সাইফুল আলম ও মহাসচিব মো. জয়নাল আবদীন অতিথিদের উদ্দেশে বক্তব্য দেন; ছিলেন বিবিসিসিআইয়ের ব্রাজিল চ্যাপ্টারের নেতারাও। ব্রাজিলে বাংলাদেশ দূতাবাসের প্রতিরক্ষা অ্যাটাশেও উপস্থিত ছিলেন।

                        ## কারা প্রদর্শন করছে

                        প্রদর্শক হিসেবে ১৫টি প্রতিষ্ঠানের নাম ঘোষণা করা হয়েছিল। এদের বেশির ভাগই পোশাক ও বস্ত্র প্রস্তুতকারক; সঙ্গে আছে ওষুধ, প্রযুক্তি ও প্লাস্টিকের খেলনা প্রস্তুতকারকসহ অন্যান্য প্রতিষ্ঠান। স্টলে তারা ব্রাজিল ও লাতিন আমেরিকার অন্যান্য দেশের আমদানিকারক, পাইকার ও পরিবেশকদের সঙ্গে দেখা করছে। আগে অনলাইনে নিবন্ধন করলে ব্রাজিলের ট্রেড ভিজিটররা বিনা মূল্যে প্রবেশ করতে পারেন।

                        ## কর্মসূচি

                        সব সময় সাও পাওলোর স্থানীয় সময়।

                        - সোমবার, ১৬ জুন: মিট দ্য প্রেস, ৯:৩০–১০:৩০; উদ্বোধনী অনুষ্ঠান, ১১:০০–১৩:০০; বি২বি ম্যাচমেকিং, ১৪:০০–১৭:০০।
                        - মঙ্গলবার, ১৭ জুন: বাংলাদেশ ও ব্রাজিলের বাণিজ্য ও বিনিয়োগের সুযোগ নিয়ে সেমিনার, ১১:০০–১৩:০০; বি২বি ম্যাচমেকিং, ১৪:০০–১৭:০০।
                        - বুধবার, ১৮ জুন: ব্রাজিলের একজন বিশেষজ্ঞের সেমিনার, ১১:০০–১৩:০০; বি২বি ম্যাচমেকিং, ১৪:০০–১৭:০০; মিট দ্য প্রেস ও সমাপনী অনুষ্ঠান, ১৭:০০–১৯:৩০।

                        **হালনাগাদ, ১৭ জুন ২০২৫:** দ্বিতীয় দিনে সাও পাওলো শহরের ফার্স্ট লেডি রেজিনা কার্নোভালে নুনেস স্টলগুলো ঘুরে দেখেন এবং এক্সপোতে বক্তব্য দেন।
                        MD,
                ],
                'image' => 'expo25-welcome',
                'published_at' => '2025-06-16 12:00:00',
            ],
            [
                'type' => NewsType::PressRelease,
                'slug' => [
                    'en' => 'bbcci-announces-second-made-in-bangladesh-expo',
                    'pt_BR' => 'bbcci-anuncia-segunda-made-in-bangladesh-expo',
                    'bn' => 'bbcci-announces-second-made-in-bangladesh-expo',
                ],
                'title' => [
                    'en' => 'BBCCI announces a second, larger Made in Bangladesh Expo',
                    'pt_BR' => 'BBCCI anuncia a segunda Made in Bangladesh Expo, maior que a primeira',
                    'bn' => 'আরও বড় পরিসরে দ্বিতীয় মেইড ইন বাংলাদেশ এক্সপোর ঘোষণা দিল বিবিসিসিআই',
                ],
                'excerpt' => [
                    'en' => 'After the 2025 expo in São Paulo, BBCCI is preparing a second edition, tentatively a three-day programme between 20 and 30 November 2026, with more sectors and a fuller business programme.',
                    'pt_BR' => 'Depois da feira de 2025 em São Paulo, a BBCCI prepara uma segunda edição, prevista provisoriamente como um programa de três dias entre 20 e 30 de novembro de 2026, com mais setores e uma agenda de negócios mais ampla.',
                    'bn' => '২০২৫ সালে সাও পাওলোর এক্সপোর পর দ্বিতীয় আসরের প্রস্তুতি নিচ্ছে বিবিসিসিআই; প্রাথমিক পরিকল্পনায় এটি ২০২৬ সালের ২০ থেকে ৩০ নভেম্বরের মধ্যে তিন দিনের কর্মসূচি, থাকবে আরও বেশি খাত ও বিস্তৃত ব্যবসায়িক আয়োজন।',
                ],
                'body' => [
                    'en' => <<<'MD'
                        The Brazil Bangladesh Chamber of Commerce & Industry (BBCCI) has announced the second Made in Bangladesh Expo, to be held in {city}, following the first edition in São Paulo in June 2025. BBCCI expects the new edition to be larger than the first.

                        ## Tentative dates

                        The expo is tentatively scheduled as a three-day programme between 20 and 30 November 2026. BBCCI will confirm the final dates and the detailed schedule later; the venue and participation fees will also be announced.

                        ## A broader programme

                        BBCCI plans larger exhibition facilities, participation from more sectors, closer engagement with institutions and more comprehensive business matchmaking. The programme is expected to include specialised seminars, investment forums, policy discussions, buyer–seller matchmaking sessions, networking events, industrial cooperation dialogues and cultural showcases.

                        ## Sectors and participants

                        The focus sectors are ready-made garments, pharmaceuticals, jute products, leather goods, agro-processing, renewable energy, ICT services, sustainable manufacturing and industrial innovation. BBCCI also intends to invite logistics providers, shipping companies, certification agencies and financial institutions. Exporters, manufacturers, investors, entrepreneurs, business associations, trade organisations and industry leaders from Bangladesh and abroad are invited to take part.

                        **Update:** BBCCI has since confirmed the dates and venue of {edition}: {dates} at {venue}, {city}.
                        MD,
                    'pt_BR' => <<<'MD'
                        A Câmara de Comércio e Indústria Brasil-Bangladesh (BBCCI) anunciou a segunda Made in Bangladesh Expo, que será realizada em {city}, depois da primeira edição em São Paulo, em junho de 2025. A BBCCI espera que a nova edição seja maior que a primeira.

                        ## Datas provisórias

                        A feira está prevista, em caráter provisório, como um programa de três dias entre 20 e 30 de novembro de 2026. A BBCCI confirmará mais adiante as datas finais e a programação detalhada; o local e os valores de participação também serão anunciados.

                        ## Uma programação mais ampla

                        A BBCCI planeja uma área de exposição maior, a participação de mais setores, maior envolvimento das instituições e rodadas de negócios mais completas. A programação deve incluir seminários especializados, fóruns de investimento, debates sobre políticas, rodadas entre compradores e vendedores, eventos de networking, diálogos sobre cooperação industrial e apresentações culturais.

                        ## Setores e participantes

                        Os setores em foco são confecções, farmacêuticos, produtos de juta, artigos de couro, agroindústria, energia renovável, serviços de TIC, manufatura sustentável e inovação industrial. A BBCCI também pretende convidar operadores logísticos, empresas de navegação, certificadoras e instituições financeiras. Exportadores, fabricantes, investidores, empreendedores, associações empresariais, entidades de comércio e lideranças da indústria de Bangladesh e de outros países estão convidados a participar.

                        **Atualização:** a BBCCI já confirmou as datas e o local da {edition}: {dates}, {venue}, {city}.
                        MD,
                    'bn' => <<<'MD'
                        ব্রাজিল বাংলাদেশ চেম্বার অব কমার্স অ্যান্ড ইন্ডাস্ট্রি (বিবিসিসিআই) দ্বিতীয় মেইড ইন বাংলাদেশ এক্সপোর ঘোষণা দিয়েছে, যা অনুষ্ঠিত হবে {city} শহরে। প্রথম আসর হয়েছিল ২০২৫ সালের জুনে সাও পাওলোতে। বিবিসিসিআই আশা করছে, নতুন আসর প্রথমটির চেয়ে বড় হবে।

                        ## সম্ভাব্য তারিখ

                        প্রাথমিক পরিকল্পনা অনুযায়ী এক্সপোটি হবে ২০২৬ সালের ২০ থেকে ৩০ নভেম্বরের মধ্যে, তিন দিনের কর্মসূচি হিসেবে। চূড়ান্ত তারিখ ও বিস্তারিত সূচি পরে নিশ্চিত করবে বিবিসিসিআই; ভেন্যু ও অংশগ্রহণ ফিও পরে জানানো হবে।

                        ## আরও বিস্তৃত কর্মসূচি

                        বিবিসিসিআই বড় প্রদর্শনী পরিসর, আরও বেশি খাতের অংশগ্রহণ, প্রতিষ্ঠানগুলোর জোরালো সম্পৃক্ততা এবং আরও পূর্ণাঙ্গ ব্যবসায়িক ম্যাচমেকিংয়ের পরিকল্পনা করছে। কর্মসূচিতে থাকতে পারে বিশেষায়িত সেমিনার, বিনিয়োগ ফোরাম, নীতিবিষয়ক আলোচনা, ক্রেতা-বিক্রেতা ম্যাচমেকিং, নেটওয়ার্কিং আয়োজন, শিল্প সহযোগিতা সংলাপ ও সাংস্কৃতিক আয়োজন।

                        ## খাত ও অংশগ্রহণকারী

                        গুরুত্ব পাবে তৈরি পোশাক, ওষুধ, পাটপণ্য, চামড়াজাত পণ্য, কৃষি প্রক্রিয়াজাতকরণ, নবায়নযোগ্য জ্বালানি, আইসিটি সেবা, টেকসই উৎপাদন ও শিল্প উদ্ভাবন খাত। লজিস্টিকস সেবাদাতা, শিপিং কোম্পানি, সনদদানকারী সংস্থা ও আর্থিক প্রতিষ্ঠানকেও আমন্ত্রণ জানানোর পরিকল্পনা রয়েছে বিবিসিসিআইয়ের। বাংলাদেশ ও অন্যান্য দেশের রপ্তানিকারক, উৎপাদক, বিনিয়োগকারী, উদ্যোক্তা, ব্যবসায়িক সংগঠন, বাণিজ্য সংস্থা ও শিল্পনেতাদের অংশ নেওয়ার আমন্ত্রণ জানানো হয়েছে।

                        **হালনাগাদ:** বিবিসিসিআই এরই মধ্যে {edition}-এর তারিখ ও ভেন্যু চূড়ান্ত করেছে: {dates}, {venue}, {city}।
                        MD,
                ],
                'image' => 'press-2026-05',
                'published_at' => '2026-05-16 12:00:00',
            ],
            [
                'type' => NewsType::News,
                'slug' => [
                    'en' => 'dates-and-venue-confirmed',
                    'pt_BR' => 'datas-e-local-confirmados',
                    'bn' => 'dates-and-venue-confirmed',
                ],
                'title' => [
                    'en' => 'Dates and venue confirmed: {dates} at {venue}, {city}',
                    'pt_BR' => 'Datas e local confirmados: {dates}, {venue}, {city}',
                    'bn' => 'তারিখ ও ভেন্যু চূড়ান্ত: {dates}, {venue}, {city}',
                ],
                'excerpt' => [
                    'en' => 'BBCCI has confirmed {edition}: {dates} at {venue}, {city}, with around 50 Bangladeshi stalls and selected Brazilian exhibitors planned.',
                    'pt_BR' => 'A BBCCI confirmou a {edition}: {dates}, {venue}, {city}, com cerca de 50 estandes de Bangladesh e expositores brasileiros selecionados.',
                    'bn' => 'বিবিসিসিআই {edition}-এর তারিখ ও ভেন্যু নিশ্চিত করেছে: {dates}, {venue}, {city}; পরিকল্পনায় আছে বাংলাদেশের প্রায় ৫০টি স্টল ও বাছাই করা ব্রাজিলীয় প্রদর্শক।',
                ],
                'body' => [
                    'en' => <<<'MD'
                        The Brazil Bangladesh Chamber of Commerce & Industry (BBCCI) has confirmed the dates and venue of {edition}, the second edition of the Made in Bangladesh Expo: {dates} at {venue}, {city}.

                        ## Who will exhibit

                        BBCCI plans around 50 Bangladeshi stalls covering the country's main export sectors: knitwear and woven garments, footwear, home textiles, jute and jute goods, leather and leather goods, pharmaceuticals, agro and food products, frozen seafood, plastics and packaging, and handicrafts. Selected Brazilian exhibitors will also take part, presenting soybean oil, sugar, cotton, coffee, agricultural commodities, food ingredients, livestock and poultry products and industrial raw materials, so that Bangladeshi importers can source directly from Brazilian suppliers.

                        ## The business programme

                        The programme centres on structured B2B matchmaking organised by BBCCI, where exhibitors and visitors meet qualified buyers and suppliers to discuss distribution, dealerships, import–export partnerships and investment. Seminars will cover trade and investment opportunities, market entry, trade facilitation, customs and regulation, logistics, industrial cooperation and sustainability, with speakers from government, industry and trade-promotion bodies of both countries. Investment forums, policy discussions and cultural showcases complete the plan.

                        ## Still to be announced

                        BBCCI is inviting Brazilian trade-promotion bodies, chambers of commerce and sector associations to join as strategic partners, and will name them once they are confirmed. The set-up day, opening hours, stall packages and fees, registration details and speakers will follow. Sign up for the expo newsletter on this site to receive each announcement, or contact BBCCI at {email} or {phone}.
                        MD,
                    'pt_BR' => <<<'MD'
                        A Câmara de Comércio e Indústria Brasil-Bangladesh (BBCCI) confirmou as datas e o local da {edition}, a segunda edição da Made in Bangladesh Expo: {dates}, {venue}, {city}.

                        ## Quem vai expor

                        A BBCCI prevê cerca de 50 estandes de Bangladesh, cobrindo os principais setores exportadores do país: malharia e confecção em tecido plano, calçados, têxteis para casa, juta e produtos de juta, couro e artigos de couro, farmacêuticos, produtos agrícolas e alimentícios, pescados congelados, plásticos e embalagens, e artesanato. Expositores brasileiros selecionados também vão participar, com óleo de soja, açúcar, algodão, café, commodities agrícolas, ingredientes alimentícios, produtos de pecuária e avicultura e matérias-primas industriais, para que importadores de Bangladesh possam comprar diretamente de fornecedores brasileiros.

                        ## A programação de negócios

                        O centro da programação são as rodadas de negócios estruturadas, organizadas pela BBCCI, em que expositores e visitantes encontram compradores e fornecedores qualificados para discutir distribuição, representação comercial, parcerias de importação e exportação e investimentos. Os seminários vão tratar de oportunidades de comércio e investimento, entrada no mercado, facilitação do comércio, aduana e regulação, logística, cooperação industrial e sustentabilidade, com palestrantes do governo, da indústria e de órgãos de promoção comercial dos dois países. Fóruns de investimento, debates sobre políticas e apresentações culturais completam o plano.

                        ## O que ainda será anunciado

                        A BBCCI está convidando órgãos brasileiros de promoção comercial, câmaras de comércio e associações setoriais para serem parceiros estratégicos e vai divulgá-los assim que forem confirmados. O dia de montagem, o horário de funcionamento, os pacotes e valores dos estandes, os detalhes de credenciamento e os palestrantes serão anunciados em seguida. Assine a newsletter da feira neste site para receber cada novidade, ou fale com a BBCCI pelo e-mail {email} ou pelo telefone {phone}.
                        MD,
                    'bn' => <<<'MD'
                        ব্রাজিল বাংলাদেশ চেম্বার অব কমার্স অ্যান্ড ইন্ডাস্ট্রি (বিবিসিসিআই) মেইড ইন বাংলাদেশ এক্সপোর দ্বিতীয় আসর {edition}-এর তারিখ ও ভেন্যু চূড়ান্ত করেছে: {dates}, {venue}, {city}।

                        ## কারা প্রদর্শন করবে

                        বিবিসিসিআই বাংলাদেশের প্রায় ৫০টি স্টলের পরিকল্পনা করেছে, যেখানে থাকবে দেশের প্রধান রপ্তানি খাতগুলো: নিটওয়্যার ও ওভেন পোশাক, জুতা, হোম টেক্সটাইল, পাট ও পাটজাত পণ্য, চামড়া ও চামড়াজাত পণ্য, ওষুধ, কৃষি ও খাদ্যপণ্য, হিমায়িত সামুদ্রিক খাদ্য, প্লাস্টিক ও প্যাকেজিং এবং হস্তশিল্প। বাছাই করা ব্রাজিলীয় প্রদর্শকেরাও অংশ নেবেন; তাঁরা সয়াবিন তেল, চিনি, তুলা, কফি, কৃষিপণ্য, খাদ্য উপকরণ, পশুসম্পদ ও পোলট্রি পণ্য এবং শিল্পের কাঁচামাল উপস্থাপন করবেন, যাতে বাংলাদেশের আমদানিকারকেরা ব্রাজিলের সরবরাহকারীদের কাছ থেকে সরাসরি পণ্য সংগ্রহ করতে পারেন।

                        ## ব্যবসায়িক কর্মসূচি

                        কর্মসূচির কেন্দ্রে থাকবে বিবিসিসিআই আয়োজিত সুসংগঠিত বি২বি ম্যাচমেকিং, যেখানে প্রদর্শক ও দর্শনার্থীরা যোগ্য ক্রেতা ও সরবরাহকারীর সঙ্গে পরিবেশন, ডিলারশিপ, আমদানি-রপ্তানি অংশীদারত্ব ও বিনিয়োগ নিয়ে আলোচনা করবেন। সেমিনারে আলোচিত হবে বাণিজ্য ও বিনিয়োগের সুযোগ, বাজারে প্রবেশ, বাণিজ্য সহজীকরণ, শুল্ক ও নিয়ন্ত্রক কাঠামো, লজিস্টিকস, শিল্প সহযোগিতা ও টেকসই ব্যবসা; বক্তা থাকবেন দুই দেশের সরকার, শিল্প ও বাণিজ্য প্রসার সংস্থাগুলো থেকে। এর সঙ্গে থাকবে বিনিয়োগ ফোরাম, নীতিবিষয়ক আলোচনা ও সাংস্কৃতিক আয়োজন।

                        ## যা পরে জানানো হবে

                        ব্রাজিলের বাণিজ্য প্রসার সংস্থা, চেম্বার অব কমার্স ও খাতভিত্তিক সংগঠনগুলোকে কৌশলগত অংশীদার হওয়ার আমন্ত্রণ জানাচ্ছে বিবিসিসিআই; নিশ্চিত হলে তাদের নাম প্রকাশ করা হবে। স্টল সাজানোর দিন, প্রদর্শনীর সময়, স্টল প্যাকেজ ও ফি, নিবন্ধনের বিস্তারিত এবং বক্তাদের নাম পরে জানানো হবে। প্রতিটি ঘোষণা পেতে এই সাইটে এক্সপোর নিউজলেটারে সাইন আপ করুন, অথবা বিবিসিসিআইয়ের সঙ্গে যোগাযোগ করুন {email} ঠিকানায় বা {phone} নম্বরে।
                        MD,
                ],
                'image' => 'sao-paulo-skyline',
                'published_at' => '2026-10-17 12:00:00',
            ],
        ];
    }

    /**
     * Media reports, linking out to the publisher. Titles keep their original language in that language.
     *
     * @return list<array{type: NewsType, slug: array<string, string>, title: array<string, string>, excerpt: array<string, string>, body: null, image: null, source_name: string, source_url: string, published_at: string}>
     */
    private function mediaCoverage(): array
    {
        return [
            [
                'type' => NewsType::Coverage,
                'slug' => [
                    'en' => 'propmark-interview-bbcci-vice-president',
                    'pt_BR' => 'propmark-entrevista-vice-presidente-da-bbcci',
                    'bn' => 'propmark-interview-bbcci-vice-president',
                ],
                'title' => [
                    'en' => 'Asia Connection: Made in Bangladesh',
                    'pt_BR' => 'Conexão Ásia: Made in Bangladesh',
                    'bn' => 'এশিয়া সংযোগ: মেইড ইন বাংলাদেশ',
                ],
                'excerpt' => [
                    'en' => 'In an interview with Propmark, BBCCI Vice President Md. Saiful Alam presents the 15–18 June expo at the Novotel São Paulo Center Norte and Bangladesh\'s ambitions for trade with Brazil and Latin America.',
                    'pt_BR' => 'Em entrevista à Propmark, o vice-presidente da BBCCI, Md. Saiful Alam, apresenta a feira de 15 a 18 de junho no Novotel São Paulo Center Norte e os objetivos de Bangladesh no comércio com o Brasil e a América Latina.',
                    'bn' => 'প্রপমার্ককে দেওয়া সাক্ষাৎকারে বিবিসিসিআইয়ের সহসভাপতি মো. সাইফুল আলম নভোটেল সাও পাওলো সেন্টার নর্তেতে ১৫–১৮ জুনের এক্সপো এবং ব্রাজিল ও লাতিন আমেরিকার সঙ্গে বাণিজ্যে বাংলাদেশের লক্ষ্যের কথা তুলে ধরেন।',
                ],
                'body' => null,
                'image' => null,
                'source_name' => 'Propmark',
                'source_url' => 'https://propmark.com.br/conexao-asia/conexao-asia-made-in-bangladesh/',
                'published_at' => '2025-06-03 18:00:00',
            ],
            [
                'type' => NewsType::Coverage,
                'slug' => [
                    'en' => 'tbs-bangladesh-to-showcase-products-in-brazil',
                    'pt_BR' => 'tbs-bangladesh-vai-expor-produtos-no-brasil',
                    'bn' => 'tbs-bangladesh-to-showcase-products-in-brazil',
                ],
                'title' => [
                    'en' => 'Bangladesh to showcase products in Brazil 15-18 June',
                    'pt_BR' => 'Bangladesh vai expor seus produtos no Brasil de 15 a 18 de junho',
                    'bn' => '১৫-১৮ জুন ব্রাজিলে পণ্য প্রদর্শন করবে বাংলাদেশ',
                ],
                'excerpt' => [
                    'en' => 'Report from the Chattogram Press Club, where BBCCI Director Imran Chowdhury presented the expo, with Brazil\'s deputy head of mission in Dhaka in attendance.',
                    'pt_BR' => 'Reportagem da coletiva no Chattogram Press Club, em que o diretor da BBCCI Imran Chowdhury apresentou a feira, com a presença do chefe-adjunto da missão do Brasil em Daca.',
                    'bn' => 'চট্টগ্রাম প্রেসক্লাবের সংবাদ সম্মেলন থেকে প্রতিবেদন; সেখানে বিবিসিসিআইয়ের পরিচালক ইমরান চৌধুরী এক্সপো তুলে ধরেন, উপস্থিত ছিলেন ঢাকায় ব্রাজিল দূতাবাসের উপমিশনপ্রধান।',
                ],
                'body' => null,
                'image' => null,
                'source_name' => 'The Business Standard',
                'source_url' => 'https://www.tbsnews.net/bangladesh/bangladesh-showcase-products-brazil-15-18-june-1058151',
                'published_at' => '2025-02-01 18:00:00',
            ],
            [
                'type' => NewsType::Coverage,
                'slug' => [
                    'en' => 'tbs-brazil-gateway-to-latin-america',
                    'pt_BR' => 'tbs-brasil-porta-de-entrada-para-a-america-latina',
                    'bn' => 'tbs-brazil-gateway-to-latin-america',
                ],
                'title' => [
                    'en' => 'Brazil can be a gateway to Latin America for Bangladeshi businessmen: Diplomat',
                    'pt_BR' => 'Brasil pode ser porta de entrada para a América Latina para empresários de Bangladesh, diz diplomata',
                    'bn' => 'বাংলাদেশি ব্যবসায়ীদের জন্য লাতিন আমেরিকার প্রবেশদ্বার হতে পারে ব্রাজিল: কূটনীতিক',
                ],
                'excerpt' => [
                    'en' => 'At a promotion meeting in Rangpur, Brazil\'s Deputy Head of Mission Leonardo de Oliveira Jannuzzi urged local businesses to join the expo and named Argentina, Uruguay and Bolivia as markets beyond Brazil.',
                    'pt_BR' => 'Em reunião de divulgação em Rangpur, o chefe-adjunto da missão do Brasil, Leonardo de Oliveira Jannuzzi, convidou as empresas locais a participar da feira e citou Argentina, Uruguai e Bolívia como mercados além do Brasil.',
                    'bn' => 'রংপুরের প্রচারসভায় ব্রাজিলের উপমিশনপ্রধান লিওনার্দো দে অলিভেইরা জানুজি স্থানীয় ব্যবসায়ীদের এক্সপোতে অংশ নিতে আহ্বান জানান এবং ব্রাজিলের বাইরে আর্জেন্টিনা, উরুগুয়ে ও বলিভিয়ার বাজারের কথা বলেন।',
                ],
                'body' => null,
                'image' => null,
                'source_name' => 'The Business Standard (BSS)',
                'source_url' => 'https://www.tbsnews.net/foreign-policy/brazil-can-be-gateway-latin-america-bangladeshi-businessmen-diplomat-1046026',
                'published_at' => '2025-01-18 18:00:00',
            ],
            [
                'type' => NewsType::Coverage,
                'slug' => [
                    'en' => 'daily-observer-bd-businesses-to-host-expo-in-brazil',
                    'pt_BR' => 'daily-observer-empresas-de-bangladesh-farao-feira-no-brasil',
                    'bn' => 'daily-observer-bd-businesses-to-host-expo-in-brazil',
                ],
                'title' => [
                    'en' => 'BD businesses to host Made in Bangladesh expo in Brazil',
                    'pt_BR' => 'Empresas de Bangladesh vão realizar a Made in Bangladesh Expo no Brasil',
                    'bn' => 'ব্রাজিলে মেইড ইন বাংলাদেশ এক্সপো করবে দেশের ব্যবসায়ীরা',
                ],
                'excerpt' => [
                    'en' => 'Report on the Dhaka launch at Hotel Ascott Palace, with remarks by Ambassador Paulo Fernando Dias Feres and BBCCI Vice President Md. Saiful Alam, and plans for B2B matchmaking, policy discussions and cultural showcases.',
                    'pt_BR' => 'Reportagem sobre o lançamento em Daca, no Hotel Ascott Palace, com falas do embaixador Paulo Fernando Dias Feres e do vice-presidente da BBCCI, Md. Saiful Alam, e o anúncio de rodadas de negócios, debates sobre políticas e apresentações culturais.',
                    'bn' => 'হোটেল অ্যাসকট প্যালেসে ঢাকার উদ্বোধনী সংবাদ সম্মেলন নিয়ে প্রতিবেদন; বক্তব্য দেন রাষ্ট্রদূত পাওলো ফের্নান্দো দিয়াস ফেরেস ও বিবিসিসিআইয়ের সহসভাপতি মো. সাইফুল আলম, জানানো হয় বি২বি ম্যাচমেকিং, নীতিবিষয়ক আলোচনা ও সাংস্কৃতিক আয়োজনের পরিকল্পনা।',
                ],
                'body' => null,
                'image' => null,
                'source_name' => 'The Daily Observer',
                'source_url' => 'https://observerbd.com/news/506540',
                'published_at' => '2025-01-09 18:00:00',
            ],
            [
                'type' => NewsType::Coverage,
                'slug' => [
                    'en' => 'daily-star-print-made-in-bangladesh-exhibition-in-june',
                    'pt_BR' => 'daily-star-impresso-feira-made-in-bangladesh-em-junho',
                    'bn' => 'daily-star-print-made-in-bangladesh-exhibition-in-june',
                ],
                'title' => [
                    'en' => '\'Made in Bangladesh\' exhibition in Brazil in June',
                    'pt_BR' => 'Feira \'Made in Bangladesh\' no Brasil em junho',
                    'bn' => 'জুনে ব্রাজিলে \'মেইড ইন বাংলাদেশ\' প্রদর্শনী',
                ],
                'excerpt' => [
                    'en' => 'The print edition\'s business page reports BBCCI\'s plan for a Made in Bangladesh exhibition in Brazil in June 2025.',
                    'pt_BR' => 'A página de economia da edição impressa noticia o plano da BBCCI de realizar uma feira Made in Bangladesh no Brasil em junho de 2025.',
                    'bn' => 'ছাপা সংস্করণের বাণিজ্য পাতায় ২০২৫ সালের জুনে ব্রাজিলে মেইড ইন বাংলাদেশ প্রদর্শনী আয়োজনে বিবিসিসিআইয়ের পরিকল্পনার খবর।',
                ],
                'body' => null,
                'image' => null,
                'source_name' => 'The Daily Star (print)',
                'source_url' => 'https://epfs.thedailystar.net/TDS/2025/01/09/Bangladesh/BUS/5_04/fd0d4db603c8aad7_04.pdf',
                'published_at' => '2025-01-09 18:00:00',
            ],
            [
                'type' => NewsType::Coverage,
                'slug' => [
                    'en' => 'daily-star-local-businesses-to-host-exhibition-in-brazil',
                    'pt_BR' => 'daily-star-empresas-locais-farao-feira-no-brasil',
                    'bn' => 'daily-star-local-businesses-to-host-exhibition-in-brazil',
                ],
                'title' => [
                    'en' => 'Local businesses to host \'Made in Bangladesh\' exhibition in Brazil',
                    'pt_BR' => 'Empresas locais vão realizar a feira \'Made in Bangladesh\' no Brasil',
                    'bn' => 'ব্রাজিলে \'মেইড ইন বাংলাদেশ\' প্রদর্শনী করবে দেশীয় প্রতিষ্ঠান',
                ],
                'excerpt' => [
                    'en' => 'The Daily Star on the Dhaka launch: an expo to diversify export markets and build trade with Latin America, with garments, jute and pharmaceuticals among the sectors.',
                    'pt_BR' => 'O The Daily Star sobre o lançamento em Daca: uma feira para diversificar mercados de exportação e ampliar o comércio com a América Latina, com vestuário, juta e farmacêuticos entre os setores.',
                    'bn' => 'ঢাকায় এক্সপোর ঘোষণা নিয়ে দ্য ডেইলি স্টার: রপ্তানি বাজার বহুমুখী করা ও লাতিন আমেরিকার সঙ্গে বাণিজ্য বাড়াতে এক্সপো, অংশ নেবে পোশাক, পাট ও ওষুধসহ বিভিন্ন খাত।',
                ],
                'body' => null,
                'image' => null,
                'source_name' => 'The Daily Star',
                'source_url' => 'https://www.thedailystar.net/business/news/local-businesses-host-made-bangladesh-exhibition-brazil-3794611',
                'published_at' => '2025-01-08 18:00:00',
            ],
            [
                'type' => NewsType::Coverage,
                'slug' => [
                    'en' => 'dhaka-tribune-made-in-bangladesh-expo-june-15-18',
                    'pt_BR' => 'dhaka-tribune-made-in-bangladesh-expo-de-15-a-18-de-junho',
                    'bn' => 'dhaka-tribune-made-in-bangladesh-expo-june-15-18',
                ],
                'title' => [
                    'en' => '\'Made in Bangladesh\' expo on June 15-18 in Brazil',
                    'pt_BR' => 'Feira \'Made in Bangladesh\' de 15 a 18 de junho no Brasil',
                    'bn' => '১৫-১৮ জুন ব্রাজিলে \'মেইড ইন বাংলাদেশ\' এক্সপো',
                ],
                'excerpt' => [
                    'en' => 'Dhaka Tribune reports the launch of the first Made in Bangladesh Expo, which aims to promote Bangladeshi exportable goods and build business networks in Latin America.',
                    'pt_BR' => 'O Dhaka Tribune noticia o lançamento da primeira Made in Bangladesh Expo, que busca promover produtos exportáveis de Bangladesh e criar redes de negócios na América Latina.',
                    'bn' => 'প্রথম মেইড ইন বাংলাদেশ এক্সপোর ঘোষণা নিয়ে ঢাকা ট্রিবিউনের প্রতিবেদন; লক্ষ্য বাংলাদেশের রপ্তানিযোগ্য পণ্যের প্রসার ও লাতিন আমেরিকায় ব্যবসায়িক যোগাযোগ গড়ে তোলা।',
                ],
                'body' => null,
                'image' => null,
                'source_name' => 'Dhaka Tribune',
                'source_url' => 'https://www.dhakatribune.com/business/370305/%E2%80%98made-in-bangladesh%E2%80%99-expo-on-june-15-18-in-brazil',
                'published_at' => '2025-01-08 18:00:00',
            ],
            [
                'type' => NewsType::Coverage,
                'slug' => [
                    'en' => 'tbs-brazil-seeks-beef-export-approval',
                    'pt_BR' => 'tbs-brasil-busca-aprovacao-para-exportar-carne-bovina',
                    'bn' => 'tbs-brazil-seeks-beef-export-approval',
                ],
                'title' => [
                    'en' => 'Brazil seeks beef export approval, eyes more investment in Bangladesh',
                    'pt_BR' => 'Brasil busca aprovação para exportar carne bovina e mira mais investimentos em Bangladesh',
                    'bn' => 'গরুর মাংস রপ্তানির অনুমোদন চায় ব্রাজিল, বাংলাদেশে আরও বিনিয়োগে আগ্রহ',
                ],
                'excerpt' => [
                    'en' => 'At BBCCI\'s launch press conference, Ambassador Paulo Fernando Dias Feres spoke of Brazil\'s wish to export beef to Bangladesh and to invest more in the country.',
                    'pt_BR' => 'Na coletiva de lançamento da BBCCI, o embaixador Paulo Fernando Dias Feres falou do interesse do Brasil em exportar carne bovina para Bangladesh e em ampliar seus investimentos no país.',
                    'bn' => 'বিবিসিসিআইয়ের উদ্বোধনী সংবাদ সম্মেলনে রাষ্ট্রদূত পাওলো ফের্নান্দো দিয়াস ফেরেস বাংলাদেশে গরুর মাংস রপ্তানি এবং দেশটিতে আরও বিনিয়োগে ব্রাজিলের আগ্রহের কথা বলেন।',
                ],
                'body' => null,
                'image' => null,
                'source_name' => 'The Business Standard',
                'source_url' => 'https://www.tbsnews.net/economy/brazil-keen-new-investments-bangladesh-ambassador-fernando-1037721',
                'published_at' => '2025-01-08 18:00:00',
            ],
        ];
    }
}
