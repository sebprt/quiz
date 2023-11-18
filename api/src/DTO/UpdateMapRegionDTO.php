<?php

namespace App\DTO;

class UpdateMapRegionDTO
{
    public ?string $name = null;
    public ?float $description = null;
    public ?float $imageUrl = null;
    public ?bool $isUnlocked = null;
}
