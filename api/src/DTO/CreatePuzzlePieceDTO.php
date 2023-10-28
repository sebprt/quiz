<?php

namespace App\DTO;

class CreatePuzzlePieceDTO
{
    public string $imageUrl;
    public float $locationX;
    public float $locationY;
    public bool $isMissing ;
    /** @var MathProblemDTO[] $mathProblems */
    public array $mathProblems;
}
