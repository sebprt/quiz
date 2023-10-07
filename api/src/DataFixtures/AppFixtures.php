<?php

namespace App\DataFixtures;

use App\Story\DefaultEventsStory;
use App\Story\DefaultMapStory;
use App\Story\DefaultPuzzleStory;
use App\Story\DefaultSentenceStory;
use App\Story\DefaultSongStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        DefaultEventsStory::load();
        DefaultSentenceStory::load();
        DefaultPuzzleStory::load();
        DefaultMapStory::load();
        DefaultSongStory::load();

        $manager->flush();
    }
}
