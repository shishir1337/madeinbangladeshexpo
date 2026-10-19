<?php

namespace Database\Seeders;

use App\Enums\SessionKind;
use App\Models\Edition;
use App\Models\ProgrammeSession;
use Illuminate\Database\Seeder;

/**
 * The 2025 programme as BBCCI presented it at the exhibitor briefing (docs/research/01 §5.2). São Paulo local
 * times. PT and BN titles are AI-drafted and await client review. Safe to run repeatedly.
 */
class ProgrammeSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $edition = Edition::query()->where('slug', '2025')->first();

        if ($edition === null) {
            return;
        }

        $b2b = ['en' => 'B2B matchmaking', 'pt_BR' => 'Rodadas de negócios B2B', 'bn' => 'বিটুবি ম্যাচমেকিং'];

        $sessions = [
            ['2025-06-15', null, null, SessionKind::Setup, ['en' => 'Stall preparation and product display', 'pt_BR' => 'Montagem dos estandes e exposição dos produtos', 'bn' => 'স্টল প্রস্তুতি ও পণ্য সাজানো']],
            ['2025-06-16', '09:30', '10:30', SessionKind::Press, ['en' => 'Meet the press', 'pt_BR' => 'Encontro com a imprensa', 'bn' => 'সংবাদমাধ্যমের মুখোমুখি']],
            ['2025-06-16', '11:00', '13:00', SessionKind::Ceremony, ['en' => 'Inaugural ceremony', 'pt_BR' => 'Cerimônia de abertura', 'bn' => 'উদ্বোধনী অনুষ্ঠান']],
            ['2025-06-16', '14:00', '17:00', SessionKind::Matchmaking, $b2b],
            ['2025-06-17', '11:00', '13:00', SessionKind::Seminar, ['en' => 'Seminar: trade and investment opportunities between Bangladesh and Brazil', 'pt_BR' => 'Seminário: oportunidades de comércio e investimento entre Bangladesh e Brasil', 'bn' => 'সেমিনার: বাংলাদেশ ও ব্রাজিলের মধ্যে বাণিজ্য ও বিনিয়োগের সুযোগ']],
            ['2025-06-17', '14:00', '17:00', SessionKind::Matchmaking, $b2b],
            ['2025-06-18', '11:00', '13:00', SessionKind::Seminar, ['en' => 'Seminar by a Brazilian expert', 'pt_BR' => 'Seminário com especialista brasileiro', 'bn' => 'ব্রাজিলীয় বিশেষজ্ঞের সেমিনার']],
            ['2025-06-18', '14:00', '17:00', SessionKind::Matchmaking, $b2b],
            ['2025-06-18', '17:00', '19:30', SessionKind::Ceremony, ['en' => 'Meet the press and closing ceremony', 'pt_BR' => 'Encontro com a imprensa e cerimônia de encerramento', 'bn' => 'সংবাদমাধ্যমের মুখোমুখি ও সমাপনী অনুষ্ঠান']],
        ];

        foreach ($sessions as $sort => [$day, $startsAt, $endsAt, $kind, $title]) {
            ProgrammeSession::firstOrCreate(
                ['edition_id' => $edition->id, 'sort' => $sort],
                ['day' => $day, 'starts_at' => $startsAt, 'ends_at' => $endsAt, 'kind' => $kind, 'title' => $title],
            );
        }
    }
}
