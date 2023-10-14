<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\RemovedQuestionController;
use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SongRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['song:read']],
        ),
        new Post(
            denormalizationContext: ['groups' => ['song:write']],
        ),
        new Get(
            normalizationContext: ['groups' => ['song:read']],
        ),
        new Put(
            denormalizationContext: ['groups' => ['song:write']],
        ),
        new Patch(
            denormalizationContext: ['groups' => ['song:write']],
        ),
        new Delete(),
        new Get(
            uriTemplate: '/songs/{id}/questions',
            normalizationContext: ['groups' => ['song:read:questions']],
            name: 'get_song_questions'
        ),
        new Post(
            uriTemplate: '/songs/{id}/questions',
            denormalizationContext: ['groups' => ['song:write:questions']],
            name: 'post_song_questions'
        ),
        new Delete(
            uriTemplate: '/songs/{id}/questions/{questionId}',
            controller: RemovedQuestionController::class,
            read: false,
            name: 'delete_song_question',
        ),
    ]
)]
class Song
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['song:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    #[Groups(['song:read', 'song:write'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    #[Groups(['song:read', 'song:write'])]
    private ?string $artist = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    #[Groups(['song:read', 'song:write'])]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    #[Groups(['song:read', 'song:write'])]
    private ?string $audioUrl = null;

    #[ORM\JoinTable(name: 'song_questions')]
    #[ORM\InverseJoinColumn(unique: true)]
    #[ORM\ManyToMany(targetEntity: SongQuestion::class, orphanRemoval: true)]
    #[Assert\Count(
        min: 1,
        max: 10,
        minMessage: 'You must specify at least one question',
        maxMessage: 'You cannot specify more than {{ limit }} questions',
    )]
    #[Groups(['song:read:questions', 'song:write:questions'])]
    private Collection $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): static
    {
        $this->artist = $artist;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAudioUrl(): ?string
    {
        return $this->audioUrl;
    }

    public function setAudioUrl(string $audioUrl): static
    {
        $this->audioUrl = $audioUrl;

        return $this;
    }

    /**
     * @return Collection<int, SongQuestion>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(SongQuestion $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    public function removeQuestion(SongQuestion $question): static
    {
        $this->questions->removeElement($question);

        return $this;
    }
}
