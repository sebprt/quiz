<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\OpenApi\Model\Operation;
use App\Controller\RemovePieceController;
use App\DTO\CreatePuzzlePieceDTO;
use App\DTO\UpdatePuzzlePieceDTO;
use App\DTO\UpdateSentenceWordDTO;
use App\Repository\PuzzleRepository;
use App\State\CreateMapRegionProcessor;
use App\State\UpdateMapRegionProcessor;
use App\State\UpdatePuzzlePieceProcessor;
use App\State\UpdateSentenceWordProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PuzzleRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['puzzle:read']],
        ),
        new Post(
            denormalizationContext: ['groups' => ['puzzle:write']],
        ),
        new Get(
            normalizationContext: ['groups' => ['puzzle:read']],
        ),
        new Put(
            denormalizationContext: ['groups' => ['puzzle:write']],
        ),
        new Patch(
            denormalizationContext: ['groups' => ['puzzle:write']],
        ),
        new Delete(),
        new Get(
            uriTemplate: '/puzzles/{id}/pieces',
            openapi: new Operation(
                summary: 'Retrieves a Piece resource belonging to a Puzzle resource.',
                description: 'Deletes a Piece resource belonging to a Puzzle resource.',
            ),
            normalizationContext: ['groups' => ['puzzle:read:pieces']],
            name: 'get_puzzle_pieces',
        ),
        new Post(
            uriTemplate: '/puzzles/{id}/pieces',
            openapi: new Operation(
                summary: 'Creates a Piece resource belonging to a Puzzle resource.',
                description: 'Creates a Piece resource belonging to a Puzzle resource.',
            ),
            input: CreatePuzzlePieceDTO::class,
            read: false,
            name: 'post_puzzle_pieces',
            processor: CreateMapRegionProcessor::class,
        ),
        new Put(
            uriTemplate: '/puzzles/{id}/pieces/{pieceId}',
            openapi: new Operation(
                summary: 'Updates a Piece resource belonging to a Puzzle resource.',
                description: 'Updates a Piece resource belonging to a Puzzle resource.',
            ),
            input: UpdatePuzzlePieceDTO::class,
            read: false,
            name: 'put_puzzle_piece',
            processor: UpdatePuzzlePieceProcessor::class,
        ),
        new Delete(
            uriTemplate: '/puzzles/{id}/pieces/{pieceId}',
            controller: RemovePieceController::class,
            openapi: new Operation(
                summary: 'Removes a Piece resource belonging to a Puzzle resource.',
                description: 'Removes a Piece resource belonging to a Puzzle resource.',
            ),
            read: false,
            name: 'delete_puzzle_piece',
        ),
    ],
)]
class Puzzle
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['puzzle:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    #[Groups(['puzzle:read', 'puzzle:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    #[Groups(['puzzle:read', 'puzzle:write'])]
    private ?string $imageUrl = null;

    #[ORM\JoinTable(name: 'puzzle_pieces')]
    #[ORM\InverseJoinColumn(unique: true)]
    #[ORM\ManyToMany(targetEntity: Piece::class, orphanRemoval: true)]
    #[Assert\Count(
        min: 10,
        max: 20,
        minMessage: 'You must specify at least one piece',
        maxMessage: 'You cannot specify more than {{ limit }} pieces',
    )]
    #[Groups(['puzzle:read:pieces'])]
    private Collection $pieces;

    public function __construct()
    {
        $this->pieces = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return Collection<int, Piece>
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(Piece $piece): static
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces->add($piece);
        }

        return $this;
    }

    public function removePiece(Piece $piece): static
    {
        $this->pieces->removeElement($piece);

        return $this;
    }
}
