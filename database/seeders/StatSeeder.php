<?php

namespace Database\Seeders;

use App\Models\Stat;
use Illuminate\Database\Seeder;

/**
 * Sourced trade figures (docs/research/02 §3 and 03 §A.5). Safe to run repeatedly; never overwrites edits.
 */
class StatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $million = ['en' => 'm', 'pt_BR' => ' mi', 'bn' => ' মিলিয়ন'];
        $billion = ['en' => 'bn', 'pt_BR' => ' bi', 'bn' => ' বিলিয়ন'];
        $percent = ['en' => '%', 'pt_BR' => '%', 'bn' => '%'];

        $stats = [
            [
                'key' => 'bd-exports-to-brazil',
                'value' => 215,
                'prefix' => 'US$',
                'suffix' => $million,
                'label' => [
                    'en' => "Bangladesh's exports to Brazil, a record (+14.6%)",
                    'pt_BR' => 'Exportações de Bangladesh para o Brasil, um recorde (+14,6%)',
                    'bn' => 'ব্রাজিলে বাংলাদেশের রপ্তানি, যা রেকর্ড (+১৪.৬%)',
                ],
                'source' => 'EPB',
                'as_of' => 'FY2025-26',
            ],
            [
                'key' => 'bilateral-trade',
                'value' => 3.0,
                'decimals' => 1,
                'prefix' => 'US$',
                'suffix' => $billion,
                'label' => [
                    'en' => 'Two-way trade between Brazil and Bangladesh in 2025',
                    'pt_BR' => 'Comércio entre Brasil e Bangladesh em 2025, nos dois sentidos',
                    'bn' => '২০২৫ সালে ব্রাজিল ও বাংলাদেশের দ্বিপক্ষীয় বাণিজ্য',
                ],
                'source' => 'UN Comtrade',
                'as_of' => 'CY2025',
            ],
            [
                'key' => 'clothing-supplier-rank',
                'value' => 2,
                'suffix' => ['en' => 'nd', 'pt_BR' => 'º', 'bn' => 'য়'],
                'label' => [
                    'en' => "Bangladesh's place among Brazil's clothing suppliers, every year since 2018",
                    'pt_BR' => 'Posição de Bangladesh entre os fornecedores de roupas do Brasil, todos os anos desde 2018',
                    'bn' => 'ব্রাজিলের পোশাক সরবরাহকারীদের মধ্যে বাংলাদেশের অবস্থান, ২০১৮ সাল থেকে প্রতি বছর',
                ],
                'source' => 'ComexStat',
                'as_of' => '2018–2025',
            ],
            [
                'key' => 'apparel-share',
                'value' => 90,
                'prefix' => '~',
                'suffix' => $percent,
                'label' => [
                    'en' => "of Bangladesh's sales to Brazil are apparel",
                    'pt_BR' => 'das vendas de Bangladesh ao Brasil são roupas',
                    'bn' => 'ব্রাজিলে বাংলাদেশের রপ্তানির এই অংশই পোশাক',
                ],
                'source' => 'UN Comtrade',
                'as_of' => 'CY2025',
            ],
            [
                'key' => 'brazil-cotton-share',
                'value' => 25,
                'prefix' => '~',
                'suffix' => $percent,
                'label' => [
                    'en' => "of Bangladesh's cotton comes from Brazil, its largest supplier",
                    'pt_BR' => 'do algodão de Bangladesh vem do Brasil, seu maior fornecedor',
                    'bn' => 'বাংলাদেশের তুলার এই অংশ আসে ব্রাজিল থেকে, যা সবচেয়ে বড় সরবরাহকারী',
                ],
                'source' => 'USDA FAS',
                'as_of' => 'MY2024/25',
            ],
            [
                'key' => 'brazil-consumers',
                'value' => 213,
                'suffix' => $million,
                'label' => [
                    'en' => "consumers in Brazil, Latin America's largest market",
                    'pt_BR' => 'consumidores no Brasil, o maior mercado da América Latina',
                    'bn' => 'ব্রাজিলের ভোক্তা, লাতিন আমেরিকার সবচেয়ে বড় বাজার',
                ],
                'source' => 'World Bank',
                'as_of' => '2024',
            ],
            [
                'key' => 'brazil-to-bangladesh',
                'value' => 2.72,
                'decimals' => 2,
                'prefix' => 'US$',
                'suffix' => $billion,
                'label' => [
                    'en' => 'Brazil → Bangladesh',
                    'pt_BR' => 'Brasil → Bangladesh',
                    'bn' => 'ব্রাজিল → বাংলাদেশ',
                ],
                'source' => 'UN Comtrade',
                'as_of' => 'CY2025',
                'placement' => 'routes',
            ],
            [
                'key' => 'bangladesh-to-brazil',
                'value' => 281.8,
                'decimals' => 1,
                'prefix' => 'US$',
                'suffix' => $million,
                'label' => [
                    'en' => 'Bangladesh → Brazil',
                    'pt_BR' => 'Bangladesh → Brasil',
                    'bn' => 'বাংলাদেশ → ব্রাজিল',
                ],
                'source' => 'UN Comtrade',
                'as_of' => 'CY2025',
                'placement' => 'routes',
            ],
            [
                'key' => 'sao-paulo-population',
                'value' => 11.5,
                'decimals' => 1,
                'suffix' => $million,
                'label' => [
                    'en' => 'people in the city of São Paulo, the largest in the Americas',
                    'pt_BR' => 'habitantes na cidade de São Paulo, a maior das Américas',
                    'bn' => 'মানুষ সাও পাওলো শহরে, দুই আমেরিকার সবচেয়ে বড় শহর',
                ],
                'source' => 'IBGE Census',
                'as_of' => '2022',
                'placement' => 'about',
            ],
        ];

        foreach ($stats as $sort => $stat) {
            Stat::firstOrCreate(['key' => $stat['key']], $stat + ['sort' => $sort, 'placement' => 'home']);
        }
    }
}
