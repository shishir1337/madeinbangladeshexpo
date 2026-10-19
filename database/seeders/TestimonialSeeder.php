<?php

namespace Database\Seeders;

use App\Models\Edition;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

/**
 * Quotes about Expo 2025 as published by BBCCI (docs/research/01 §5.2, post 264). PT and BN are translations.
 */
class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $edition2025 = Edition::query()->where('slug', '2025')->value('id');

        $testimonials = [
            [
                'person' => 'Shahriar Ahmed',
                'image' => 'leader-shahriar-ahmed',
                'role' => ['en' => 'President, BBCCI', 'pt_BR' => 'Presidente da BBCCI', 'bn' => 'সভাপতি, বিবিসিসিআই'],
                'quote' => [
                    'en' => "This historic event marked a turning point in Bangladesh's global trade outreach.",
                    'pt_BR' => 'Este evento histórico marcou uma virada na presença comercial de Bangladesh no mundo.',
                    'bn' => 'এই ঐতিহাসিক আয়োজন বিশ্ববাণিজ্যে বাংলাদেশের পথচলায় এক নতুন মোড় এনে দিয়েছে।',
                ],
            ],
            [
                'person' => 'Paulo Fernando Dias Feres',
                'role' => ['en' => 'Ambassador of Brazil to Bangladesh', 'pt_BR' => 'Embaixador do Brasil em Bangladesh', 'bn' => 'বাংলাদেশে ব্রাজিলের রাষ্ট্রদূত'],
                'quote' => [
                    'en' => 'The expo showcased how much untapped potential exists between our two nations.',
                    'pt_BR' => 'A feira mostrou quanto potencial inexplorado existe entre os nossos dois países.',
                    'bn' => 'আমাদের দুই দেশের মধ্যে কতটা অব্যবহৃত সম্ভাবনা রয়েছে, এক্সপো তা দেখিয়ে দিয়েছে।',
                ],
            ],
            [
                'person' => 'Md. Saiful Alam',
                'image' => 'leader-saiful-alam',
                'role' => ['en' => 'Vice President, BBCCI', 'pt_BR' => 'Vice-presidente da BBCCI', 'bn' => 'সহসভাপতি, বিবিসিসিআই'],
                'quote' => [
                    'en' => 'The expo was not just about promoting exports. It was about building relationships.',
                    'pt_BR' => 'A feira não foi apenas para promover exportações. Foi para construir relacionamentos.',
                    'bn' => 'এক্সপো শুধু রপ্তানি বাড়ানোর জন্য ছিল না, এটি ছিল সম্পর্ক গড়ার আয়োজন।',
                ],
            ],
            [
                'person' => 'Rafael dos Santos',
                'role' => ['en' => 'Visitor, Expo 2025', 'pt_BR' => 'Visitante, Expo 2025', 'bn' => 'দর্শনার্থী, এক্সপো ২০২৫'],
                'quote' => [
                    'en' => "I found the textile quality outstanding. We've begun discussions with two Bangladeshi RMG manufacturers.",
                    'pt_BR' => 'Achei a qualidade têxtil excelente. Já iniciamos conversas com dois fabricantes de roupas de Bangladesh.',
                    'bn' => 'কাপড়ের মান অসাধারণ লেগেছে। বাংলাদেশের দুটি পোশাক প্রস্তুতকারকের সঙ্গে আমাদের আলোচনা শুরু হয়েছে।',
                ],
            ],
            [
                'person' => 'Md. Joynal Abdin',
                'image' => 'leader-joynal-abdin',
                'role' => ['en' => 'Secretary General, BBCCI', 'pt_BR' => 'Secretário-geral da BBCCI', 'bn' => 'মহাসচিব, বিবিসিসিআই'],
                'quote' => [
                    'en' => 'This event created real momentum.',
                    'pt_BR' => 'Este evento criou um impulso real.',
                    'bn' => 'এই আয়োজন সত্যিকারের গতি তৈরি করেছে।',
                ],
            ],
        ];

        foreach ($testimonials as $sort => $testimonial) {
            Testimonial::firstOrCreate(['person' => $testimonial['person']], $testimonial + ['sort' => $sort, 'edition_id' => $edition2025]);
        }
    }
}
