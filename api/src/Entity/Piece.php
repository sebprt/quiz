<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Piece
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['puzzle:read:pieces'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    #[Groups(['puzzle:read:pieces'])]
    private ?string $imageUrl = null;

    #[ORM\Column]
    #[Assert\Type(type: 'float')]
    #[Groups(['puzzle:read:pieces'])]
    private ?float $locationX = null;

    #[ORM\Column]
    #[Assert\Type(type: 'float')]
    #[Groups(['puzzle:read:pieces'])]
    private ?float $locationY = null;

    #[ORM\Column]
    #[Assert\Type(type: 'boolean')]
    #[Groups(['puzzle:read:pieces'])]
    private ?bool $isMissing = null;

    #[ORM\JoinTable(name: 'piece_math_problems')]
    #[ORM\InverseJoinColumn(unique: true)]
    #[ORM\ManyToMany(targetEntity: MathProblem::class, orphanRemoval: true)]
    #[Assert\Count(
        min: 1,
        max: 3,
        minMessage: 'You must specify at least one math problem',
        maxMessage: 'You cannot specify more than {{ limit }} math problems',
    )]
    #[Groups(['puzzle:read:pieces'])]
    private Collection $mathProblems;

    public function __construct()
    {
        $this->mathProblems = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getLocationX(): ?float
    {
        return $this->locationX;
    }

    public function setLocationX(float $locationX): static
    {
        $this->locationX = $locationX;

        return $this;
    }

    public function getLocationY(): ?float
    {
        return $this->locationY;
    }

    public function setLocationY(float $locationY): static
    {
        $this->locationY = $locationY;

        return $this;
    }

    public function getIsMissing(): ?bool
    {
        return $this->isMissing;
    }

    public function setIsMissing(bool $isMissing): static
    {
        $this->isMissing = $isMissing;

        return $this;
    }

    /**
     * @return Collection<int, MathProblem>
     */
    public function getMathProblems(): Collection
    {
        return $this->mathProblems;
    }

    public function addMathProblem(MathProblem $mathProblem): static
    {
        if (!$this->mathProblems->contains($mathProblem)) {
            $this->mathProblems->add($mathProblem);
        }

        return $this;
    }

    public function removeMathProblem(MathProblem $mathProblem): static
    {
        $this->mathProblems->removeElement($mathProblem);

        return $this;
    }
}
