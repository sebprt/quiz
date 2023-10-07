<?php

namespace App\Story;

use App\Factory\SentenceFactory;
use Zenstruck\Foundry\Story;

final class DefaultSentenceStory extends Story
{
    public function build(): void
    {
        SentenceFactory::createMany(100);
    }
}
