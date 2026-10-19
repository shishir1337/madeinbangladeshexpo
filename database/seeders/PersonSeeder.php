<?php

namespace Database\Seeders;

use App\Enums\PersonGroup;
use App\Models\Person;
use Illuminate\Database\Seeder;

/**
 * Only people BBCCI has published (docs/research/01 §3–4). Board members are added when BBCCI names them.
 */
class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $people = [
            [
                'name' => 'H.E. Paulo Fernando Dias Feres',
                'group' => PersonGroup::Patron,
                'photo' => null,
                'role' => [
                    'en' => 'Chief Patron of BBCCI · Ambassador of Brazil to Bangladesh',
                    'pt_BR' => 'Patrono-chefe da BBCCI · Embaixador do Brasil em Bangladesh',
                    'bn' => 'বিবিসিসিআইয়ের প্রধান পৃষ্ঠপোষক · বাংলাদেশে ব্রাজিলের রাষ্ট্রদূত',
                ],
            ],
            [
                'name' => 'Shahriar Ahmed',
                'group' => PersonGroup::Leadership,
                'email' => 'president@brazilbangladeshchamber.com',
                'photo' => 'leader-shahriar-ahmed',
                'role' => ['en' => 'President', 'pt_BR' => 'Presidente', 'bn' => 'সভাপতি'],
                'bio' => [
                    'en' => 'Leads the chamber and its Board, and represents BBCCI with governments, embassies and partner chambers in both countries.',
                    'pt_BR' => 'Lidera a câmara e seu conselho e representa a BBCCI junto a governos, embaixadas e câmaras parceiras nos dois países.',
                    'bn' => 'চেম্বার ও এর পরিচালনা পর্ষদের নেতৃত্ব দেন এবং দুই দেশের সরকার, দূতাবাস ও সহযোগী চেম্বারের কাছে বিবিসিসিআইয়ের প্রতিনিধিত্ব করেন।',
                ],
            ],
            [
                'name' => 'Md. Saiful Alam',
                'group' => PersonGroup::Leadership,
                'email' => 'vp@brazilbangladeshchamber.com',
                'photo' => 'leader-saiful-alam',
                'role' => ['en' => 'Vice President', 'pt_BR' => 'Vice-presidente', 'bn' => 'সহসভাপতি'],
                'bio' => [
                    'en' => 'Supports the President, leads partner outreach for the expo and signed the 2025 exhibitor invitation.',
                    'pt_BR' => 'Apoia o presidente, conduz a aproximação com parceiros da feira e assinou o convite aos expositores de 2025.',
                    'bn' => 'সভাপতিকে সহায়তা করেন, এক্সপোর অংশীদার সংযোগের নেতৃত্ব দেন এবং ২০২৫ সালের প্রদর্শক আমন্ত্রণপত্রে স্বাক্ষর করেন।',
                ],
            ],
            [
                'name' => 'Md. Joynal Abdin',
                'group' => PersonGroup::Leadership,
                'email' => 'sg@brazilbangladeshchamber.com',
                'photo' => 'leader-joynal-abdin',
                'role' => ['en' => 'Secretary General', 'pt_BR' => 'Secretário-geral', 'bn' => 'মহাসচিব'],
                'bio' => [
                    'en' => 'Runs the secretariat and day-to-day operations, and is the first contact for exhibitors, members and partners.',
                    'pt_BR' => 'Comanda a secretaria e as operações do dia a dia e é o primeiro contato de expositores, associados e parceiros.',
                    'bn' => 'সচিবালয় ও দৈনন্দিন কার্যক্রম পরিচালনা করেন এবং প্রদর্শক, সদস্য ও অংশীদারদের প্রথম যোগাযোগের মানুষ।',
                ],
            ],
        ];

        foreach ($people as $sort => $person) {
            Person::firstOrCreate(['name' => $person['name']], $person + ['sort' => $sort]);
        }
    }
}
