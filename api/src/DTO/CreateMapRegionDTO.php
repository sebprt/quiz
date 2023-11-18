<?php

namespace App\DTO;

use ApiPlatform\Metadata\ApiProperty;

final class CreateMapRegionDTO
{
    public string $name;
    public float $description;
    public float $imageUrl;
    public bool $isUnlocked;
    #[ApiProperty(
        openapiContext: [
            'type' => 'array',
            'items' => [
                'type' => 'object',
                'properties' => [
                    'text' => [
                        'type' => 'string'
                    ],
                    'answer' => [
                        'type' => 'string'
                    ],
                ]
            ],
        ]
    )]
    /** @var RegionQuestionDTO[] $questions */
    public array $questions;
}
