<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SongRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Patch(),
        new Delete(),
        new Get(uriTemplate: '/songs/{id}/questions', name: 'get_song_questions'),
        new Post(uriTemplate: '/songs/{id}/questions', name: 'post_song_questions'),
        new Put(uriTemplate: '/songs/{id}/questions/{questionId}', name: 'put_song_questions'),
        new Patch(uriTemplate: '/songs/{id}/questions/{questionId}', name: 'patch_song_questions'),
        new Delete(uriTemplate: '/songs/{id}/questions/{questionId}', name: 'delete_song_questions'),
    ]
)]
class Song
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    private ?string $artist = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
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
