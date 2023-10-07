<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\MapRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MapRepository::class)]
#[ApiResource(operations: [
    new GetCollection(),
    new Post(),
    new Get(),
    new Put(),
    new Patch(),
    new Delete(),
    new Get(uriTemplate: '/maps/{id}/regions', name: 'get_map_regions'),
    new Post(uriTemplate: '/maps/{id}/regions', name: 'post_map_regions'),
    new Put(uriTemplate: '/maps/{id}/regions/{regionId}', name: 'put_map_regions'),
    new Patch(uriTemplate: '/maps/{id}/regions/{regionId}', name: 'patch_map_regions'),
    new Delete(uriTemplate: '/maps/{id}/regions/{regionId}', name: 'delete_map_regions'),
])]
class Map
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    private ?string $imageUrl = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotNull, Assert\NotBlank]
    private ?string $description = null;

    #[ORM\JoinTable(name: 'map_regions')]
    #[ORM\InverseJoinColumn(unique: true)]
    #[ORM\ManyToMany(targetEntity: Region::class)]
    #[Assert\Count(
        min: 1,
        max: 10,
        minMessage: 'You must specify at least one region',
        maxMessage: 'You cannot specify more than {{ limit }} region',
    )]
    private Collection $regions;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Region>
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): static
    {
        if (!$this->regions->contains($region)) {
            $this->regions->add($region);
        }

        return $this;
    }

    public function removeRegion(Region $region): static
    {
        $this->regions->removeElement($region);

        return $this;
    }
}
