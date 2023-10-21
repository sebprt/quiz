<?php

namespace App\DTO;

class UpdatePuzzlePieceDTO
{
    public ?string $imageUrl = null;
    public ?float $locationX = null;
    public ?float $locationY = null;
    public ?bool $isMissing = null;
}
