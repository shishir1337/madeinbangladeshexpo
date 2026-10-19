<?php

namespace Database\Seeders;

use App\Models\Edition;
use App\Models\Video;
use Illuminate\Database\Seeder;

/**
 * BBCCI's YouTube catalogue (docs/research/01 §13). Shown behind a click-to-load facade.
 */
class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $edition2025 = Edition::query()->where('slug', '2025')->value('id');

        $videos = [
            [
                'youtube_id' => 'AhCawT3n2Uo',
                'poster' => 'expo25-welcome',
                'is_featured' => true,
                'edition_id' => $edition2025,
                'title' => ['en' => 'Made in Bangladesh Expo 2025 in São Paulo', 'pt_BR' => 'Made in Bangladesh Expo 2025 em São Paulo', 'bn' => 'সাও পাওলোতে মেইড ইন বাংলাদেশ এক্সপো ২০২৫'],
            ],
            [
                'youtube_id' => 'yEet013K4qs',
                'poster' => 'expo25-speaker-shahriar-ahmed',
                'speaker' => 'Shahriar Ahmed',
                'title' => ['en' => 'The President of BBCCI on the expo', 'pt_BR' => 'O presidente da BBCCI fala sobre a feira', 'bn' => 'এক্সপো নিয়ে বিবিসিসিআইয়ের সভাপতি'],
            ],
            [
                'youtube_id' => 'mDVMcqUm_H8',
                'poster' => 'expo25-speaker-saiful-alam',
                'speaker' => 'Md. Saiful Alam',
                'title' => ['en' => 'The Vice President of BBCCI on Brazil', 'pt_BR' => 'O vice-presidente da BBCCI fala sobre o Brasil', 'bn' => 'ব্রাজিল নিয়ে বিবিসিসিআইয়ের সহসভাপতি'],
            ],
            [
                'youtube_id' => 'Yy8khT4DCAU',
                'poster' => 'expo25-speaker-joynal-abdin',
                'speaker' => 'Md. Joynal Abdin',
                'title' => ['en' => 'A message from the Secretary General', 'pt_BR' => 'Mensagem do secretário-geral', 'bn' => 'মহাসচিবের বার্তা'],
            ],
            [
                'youtube_id' => '5MlpxdHUHqs',
                'poster' => 'forum-2024-panel',
                'speaker' => 'Shahriar Ahmed',
                'title' => ['en' => 'The future of Brazil–Bangladesh trade', 'pt_BR' => 'O futuro do comércio Brasil–Bangladesh', 'bn' => 'ব্রাজিল–বাংলাদেশ বাণিজ্যের ভবিষ্যৎ'],
            ],
            [
                'youtube_id' => 'XnuwXSDGaVs',
                'poster' => 'fbcci-2024-meeting',
                'speaker' => 'Md. Saiful Alam',
                'title' => ['en' => 'Brazil–Bangladesh trade: an untapped goldmine', 'pt_BR' => 'Comércio Brasil–Bangladesh: uma mina de ouro inexplorada', 'bn' => 'ব্রাজিল–বাংলাদেশ বাণিজ্য: অব্যবহৃত সোনার খনি'],
            ],
        ];

        foreach ($videos as $sort => $video) {
            Video::firstOrCreate(['youtube_id' => $video['youtube_id']], $video + ['sort' => $sort]);
        }
    }
}
