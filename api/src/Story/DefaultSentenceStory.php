<?php

namespace App\Story;

use App\Factory\SentenceFactory;
use App\Factory\WordFactory;
use Zenstruck\Foundry\Story;

final class DefaultSentenceStory extends Story
{
    public function build(): void
    {
        SentenceFactory::createMany(100, static function () {
            return [
                'words' => WordFactory::randomRange(1, 6),
            ];
        });
    }
}
