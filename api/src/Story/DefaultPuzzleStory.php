<?php

namespace App\Story;

use App\Factory\PieceFactory;
use App\Factory\PuzzleFactory;
use Zenstruck\Foundry\Story;

final class DefaultPuzzleStory extends Story
{
    public function build(): void
    {
        PuzzleFactory::createMany(30, static function () {
            return [
                'pieces' => PieceFactory::randomRange(1, 100)
            ];
        });
    }
}
