<?php

namespace App\DTO;

use ApiPlatform\Metadata\ApiProperty;

class CreatePuzzlePieceDTO
{
    public string $imageUrl;
    public float $locationX;
    public float $locationY;
    public bool $isMissing ;
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
    /** @var MathProblemDTO[] $mathProblems */
    public array $mathProblems;
}
