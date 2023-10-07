<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\SentenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SentenceRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['sentence:read']],
        ),
        new Post(
            denormalizationContext: ['groups' => ['sentence:write']],
        ),
        new Get(
            normalizationContext: ['groups' => ['sentence:read']],
        ),
        new Put(
            denormalizationContext: ['groups' => ['sentence:write']],
        ),
        new Patch(
            denormalizationContext: ['groups' => ['sentence:write']],
        ),
        new Delete(),
        new Get(
            uriTemplate: '/sentences/{id}/words',
            normalizationContext: ['groups' => ['sentence:read:words']],
            name: 'get_sentence_words',
        ),
        new Post(
            uriTemplate: '/sentences/{id}/words',
            denormalizationContext: ['groups' => ['sentence:write']],
            name: 'post_sentence_words',
        ),
        new Put(uriTemplate: '/sentences/{id}/words/{wordId}', name: 'put_sentence_words'),
        new Patch(uriTemplate: '/sentences/{id}/words/{wordId}', name: 'patch_sentence_words'),
        new Delete(uriTemplate: '/sentences/{id}/words/{wordId}', name: 'delete_sentence_word'),
    ],
)]
class Sentence
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups('sentence:read')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    #[Groups(['sentence:read', 'sentence:write'])]
    private ?string $text = null;

    #[ORM\JoinTable(name: 'sentence_words')]
    #[ORM\InverseJoinColumn(unique: true)]
    #[ORM\ManyToMany(targetEntity: Word::class, orphanRemoval: true)]
    #[Assert\Count(
        min: 1,
        max: 6,
        minMessage: 'You must specify at least one word',
        maxMessage: 'You cannot specify more than {{ limit }} words',
    )]
    #[Groups(['sentence:read:words', 'sentence:write:words'])]
    private Collection $words;

    public function __construct()
    {
        $this->words = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, Word>
     */
    public function getWords(): Collection
    {
        return $this->words;
    }

    public function addWord(Word $word): static
    {
        if (!$this->words->contains($word)) {
            $this->words->add($word);
        }

        return $this;
    }

    public function removeWord(Word $word): static
    {
        $this->words->removeElement($word);

        return $this;
    }
}
