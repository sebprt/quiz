<?php

namespace App\Story;

use App\Factory\SongFactory;
use Zenstruck\Foundry\Story;

final class DefaultSongStory extends Story
{
    public function build(): void
    {
        SongFactory::createMany(20);
    }
}
