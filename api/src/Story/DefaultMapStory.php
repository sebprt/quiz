<?php

namespace App\Story;

use App\Factory\MapFactory;
use Zenstruck\Foundry\Story;

final class DefaultMapStory extends Story
{
    public function build(): void
    {
        MapFactory::createMany(5);
    }
}
