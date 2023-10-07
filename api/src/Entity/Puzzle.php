<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\PuzzleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PuzzleRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Patch(),
        new Delete(),
        new Get(uriTemplate: '/quizzes/{id}/pieces', name: 'get_quiz_pieces'),
        new Post(uriTemplate: '/quizzes/{id}/pieces', name: 'post_quiz_pieces'),
        new Put(uriTemplate: '/quizzes/{id}/pieces/{pieceId}', name: 'put_quiz_pieces'),
        new Patch(uriTemplate: '/quizzes/{id}/pieces/{pieceId}', name: 'patch_quiz_pieces'),
        new Delete(uriTemplate: '/quizzes/{id}/pieces/{pieceId}', name: 'delete_quiz_pieces'),
    ],
)]
class Puzzle
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
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
