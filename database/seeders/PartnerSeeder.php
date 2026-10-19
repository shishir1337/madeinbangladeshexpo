<?php

namespace Database\Seeders;

use App\Enums\PartnerRole;
use App\Models\Edition;
use App\Models\Partner;
use Illuminate\Database\Seeder;

/**
 * Only documented roles: BBCCI organises; the Embassy of Brazil in Dhaka supported the 2025 edition
 * (press banner, docs/research/01 §5.2). Other organisations are added when BBCCI confirms them.
 */
class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $edition2025 = Edition::query()->where('slug', '2025')->value('id');

        $partners = [
            [
                'role' => PartnerRole::Organiser,
                'logo' => 'bbcci-mark',
                'url' => 'https://brazilbangladeshchamber.com',
                'name' => [
                    'en' => 'Brazil Bangladesh Chamber of Commerce & Industry',
                    'pt_BR' => 'Câmara de Comércio e Indústria Brasil Bangladesh',
                    'bn' => 'ব্রাজিল বাংলাদেশ চেম্বার অব কমার্স অ্যান্ড ইন্ডাস্ট্রি',
                ],
            ],
            [
                'role' => PartnerRole::Supporter,
                'edition_id' => $edition2025,
                'name' => [
                    'en' => 'Embassy of Brazil in Dhaka',
                    'pt_BR' => 'Embaixada do Brasil em Daca',
                    'bn' => 'ঢাকায় ব্রাজিল দূতাবাস',
                ],
            ],
        ];

        foreach ($partners as $sort => $partner) {
            Partner::query()->where('role', $partner['role'])->where('name->en', $partner['name']['en'])->firstOr(
                fn (): Partner => Partner::create($partner + ['sort' => $sort]),
            );
        }
    }
}
