<?php

namespace Database\Seeders;

use App\Models\Edition;
use App\Models\Milestone;
use Illuminate\Database\Seeder;

/**
 * Brazil–Bangladesh milestones from 1972 to the first expo (docs/research/01 §8, §12 and 03 §A.6).
 * The current edition is appended to the timeline from the Edition itself, so it is not seeded here.
 */
class MilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $edition2025 = Edition::query()->where('slug', '2025')->value('id');

        $milestones = [
            [
                'happened_on' => '1972-05-15',
                'title' => ['en' => 'Diplomatic relations', 'pt_BR' => 'Relações diplomáticas', 'bn' => 'কূটনৈতিক সম্পর্ক'],
                'body' => [
                    'en' => 'Brazil becomes the first Latin American country to recognise Bangladesh.',
                    'pt_BR' => 'O Brasil é o primeiro país da América Latina a reconhecer Bangladesh.',
                    'bn' => 'লাতিন আমেরিকার প্রথম দেশ হিসেবে ব্রাজিল বাংলাদেশকে স্বীকৃতি দেয়।',
                ],
            ],
            [
                'happened_on' => '2021-08-20',
                'date_label' => ['en' => 'August 2021', 'pt_BR' => 'Agosto de 2021', 'bn' => 'আগস্ট ২০২১'],
                'title' => ['en' => 'Bangladesh joins the BRICS bank', 'pt_BR' => 'Bangladesh entra no banco do BRICS', 'bn' => 'ব্রিকস ব্যাংকে বাংলাদেশ'],
                'body' => [
                    'en' => 'Bangladesh becomes a member of the New Development Bank, founded by Brazil and its BRICS partners.',
                    'pt_BR' => 'Bangladesh torna-se membro do Novo Banco de Desenvolvimento, criado pelo Brasil e seus parceiros do BRICS.',
                    'bn' => 'ব্রাজিল ও তার ব্রিকস অংশীদারদের প্রতিষ্ঠিত নিউ ডেভেলপমেন্ট ব্যাংকের সদস্য হয় বাংলাদেশ।',
                ],
            ],
            [
                'happened_on' => '2022-07-01',
                'date_label' => ['en' => 'July 2022', 'pt_BR' => 'Julho de 2022', 'bn' => 'জুলাই ২০২২'],
                'title' => ['en' => 'Fifty years of friendship', 'pt_BR' => 'Cinquenta anos de amizade', 'bn' => 'বন্ধুত্বের পঞ্চাশ বছর'],
                'body' => [
                    'en' => 'A visa-exemption agreement for official passports marks half a century of relations.',
                    'pt_BR' => 'Um acordo de isenção de visto para passaportes oficiais marca meio século de relações.',
                    'bn' => 'সরকারি পাসপোর্টে ভিসা অব্যাহতি চুক্তির মধ্য দিয়ে সম্পর্কের অর্ধশতক উদ্‌যাপিত হয়।',
                ],
            ],
            [
                'happened_on' => '2024-04-08',
                'image' => 'fbcci-2024-fm-selfie',
                'title' => ['en' => 'A first ministerial visit', 'pt_BR' => 'Uma primeira visita ministerial', 'bn' => 'প্রথম মন্ত্রিপর্যায়ের সফর'],
                'body' => [
                    'en' => "Brazil's foreign minister Mauro Vieira makes the first such visit to Dhaka and joins a BBCCI and FBCCI meeting on facilitating trade.",
                    'pt_BR' => 'O chanceler Mauro Vieira faz a primeira visita de um ministro das Relações Exteriores do Brasil a Daca e participa de um encontro da BBCCI e da FBCCI sobre facilitação do comércio.',
                    'bn' => 'ব্রাজিলের পররাষ্ট্রমন্ত্রী মাউরো ভিয়েইরা প্রথমবারের মতো ঢাকা সফর করেন এবং বাণিজ্য সহজীকরণ নিয়ে বিবিসিসিআই ও এফবিসিসিআইয়ের সভায় যোগ দেন।',
                ],
            ],
            [
                'happened_on' => '2024-05-15',
                'date_label' => ['en' => 'May 2024', 'pt_BR' => 'Maio de 2024', 'bn' => 'মে ২০২৪'],
                'image' => 'bbcci-bgmea-2024',
                'title' => ['en' => 'Garment makers on board', 'pt_BR' => 'Confecções a bordo', 'bn' => 'পোশাক শিল্প যুক্ত হলো'],
                'body' => [
                    'en' => 'BBCCI meets the leadership of BGMEA, the garment manufacturers\' association, to prepare a Bangladeshi presence in Brazil.',
                    'pt_BR' => 'A BBCCI se reúne com a diretoria da BGMEA, associação dos fabricantes de roupas, para preparar a presença de Bangladesh no Brasil.',
                    'bn' => 'ব্রাজিলে বাংলাদেশের উপস্থিতির প্রস্তুতি নিতে পোশাক প্রস্তুতকারকদের সংগঠন বিজিএমইএর নেতৃত্বের সঙ্গে বৈঠক করে বিবিসিসিআই।',
                ],
            ],
            [
                'happened_on' => '2025-05-10',
                'date_label' => ['en' => 'May 2025', 'pt_BR' => 'Maio de 2025', 'bn' => 'মে ২০২৫'],
                'image' => 'press-2025-05',
                'title' => ['en' => 'The expo is announced in Dhaka', 'pt_BR' => 'A feira é anunciada em Daca', 'bn' => 'ঢাকায় এক্সপোর ঘোষণা'],
                'body' => [
                    'en' => 'With the support of the Embassy of Brazil, BBCCI presents the first Made in Bangladesh Expo to the press.',
                    'pt_BR' => 'Com o apoio da Embaixada do Brasil, a BBCCI apresenta à imprensa a primeira Made in Bangladesh Expo.',
                    'bn' => 'ব্রাজিল দূতাবাসের সহযোগিতায় বিবিসিসিআই সংবাদমাধ্যমের সামনে প্রথম মেইড ইন বাংলাদেশ এক্সপো তুলে ধরে।',
                ],
            ],
            [
                'happened_on' => '2025-06-15',
                'edition_id' => $edition2025,
                'image' => 'expo25-delegation',
                'title' => ['en' => 'The first expo in São Paulo', 'pt_BR' => 'A primeira feira em São Paulo', 'bn' => 'সাও পাওলোতে প্রথম এক্সপো'],
                'body' => [
                    'en' => 'Bangladeshi manufacturers exhibit in Latin America for the first time, with B2B meetings, seminars and a delegation from Dhaka.',
                    'pt_BR' => 'Fabricantes de Bangladesh expõem pela primeira vez na América Latina, com rodadas de negócios, seminários e uma delegação de Daca.',
                    'bn' => 'প্রথমবারের মতো লাতিন আমেরিকায় প্রদর্শনী করেন বাংলাদেশের উৎপাদকেরা; ছিল বি২বি বৈঠক, সেমিনার ও ঢাকা থেকে আসা প্রতিনিধিদল।',
                ],
            ],
            [
                'happened_on' => '2026-05-16',
                'date_label' => ['en' => 'May 2026', 'pt_BR' => 'Maio de 2026', 'bn' => 'মে ২০২৬'],
                'image' => 'press-2026-05',
                'title' => ['en' => 'A bigger second edition', 'pt_BR' => 'Uma segunda edição maior', 'bn' => 'আরও বড় দ্বিতীয় আসর'],
                'body' => [
                    'en' => 'BBCCI announces a larger second edition in São Paulo, with more sectors and a business programme.',
                    'pt_BR' => 'A BBCCI anuncia uma segunda edição maior em São Paulo, com mais setores e programação de negócios.',
                    'bn' => 'আরও বেশি খাত ও ব্যবসায়িক কর্মসূচি নিয়ে সাও পাওলোতে আরও বড় দ্বিতীয় আসরের ঘোষণা দেয় বিবিসিসিআই।',
                ],
            ],
        ];

        foreach ($milestones as $sort => $milestone) {
            Milestone::firstOrCreate(['happened_on' => $milestone['happened_on']], $milestone + ['sort' => $sort]);
        }
    }
}
