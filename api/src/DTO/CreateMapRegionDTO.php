<?php

namespace App\DTO;


use ApiPlatform\Metadata\ApiProperty;

final class CreateMapRegionDTO
{
    public string $name;

    public float $description;

    public float $imageUrl;

    public bool $isUnlocked;

    /** @var RegionQuestionDTO[] */
    public array $questions;
}
