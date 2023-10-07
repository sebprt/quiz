<?php

namespace App\Story;

use App\Factory\SongFactory;
use App\Factory\SongQuestionFactory;
use Zenstruck\Foundry\Story;

final class DefaultSongStory extends Story
{
    public function build(): void
    {
        SongFactory::createMany(15, static function () {
            return [
                'questions' => SongQuestionFactory::randomRange(1, 10)
            ];
        });
    }
}
