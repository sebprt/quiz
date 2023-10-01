<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    #[ORM\Column]
    private ?bool $isUnlocked = null;

    #[ORM\JoinTable(name: 'region_questions')]
    #[ORM\InverseJoinColumn(unique: true)]
    #[ORM\ManyToMany(targetEntity: RegionQuestion::class)]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function isIsUnlocked(): ?bool
    {
        return $this->isUnlocked;
    }

    public function setIsUnlocked(bool $isUnlocked): static
    {
        $this->isUnlocked = $isUnlocked;

        return $this;
    }

    /**
     * @return Collection<int, RegionQuestion>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(RegionQuestion $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    public function removeQuestion(RegionQuestion $question): static
    {
        $this->questions->removeElement($question);

        return $this;
    }
}
