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
use ApiPlatform\OpenApi\Model\RequestBody;
use App\Controller\RemoveRegionController;
use App\DTO\CreateMapRegionDTO;
use App\DTO\UpdateMapRegionDTO;
use App\Repository\MapRepository;
use App\State\CreateMapRegionProcessor;
use App\State\UpdateMapRegionProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MapRepository::class)]
#[ApiResource(operations: [
    new GetCollection(
        normalizationContext: ['groups' => ['map:read']],
    ),
    new Post(
        denormalizationContext: ['groups' => ['map:write']],
    ),
    new Get(
        normalizationContext: ['groups' => ['map:read']],
    ),
    new Put(
        denormalizationContext: ['groups' => ['map:write']],
    ),
    new Patch(
        denormalizationContext: ['groups' => ['map:write']],
    ),
    new Delete(),
    new Get(
        uriTemplate: '/maps/{id}/regions',
        openapi: new Operation(
            summary: 'Retrieves the collection of Region resources belonging to a Map resource.',
            description: 'Retrieves the collection of Region resources belonging to a Map resource.',
        ),
        normalizationContext: ['groups' => ['map:read:regions']],
        name: 'get_map_regions',
    ),
    new Post(
        uriTemplate: '/maps/{id}/regions',
        openapi: new Operation(
            summary: 'Creates a Region resource belonging to a Map resource.',
            description: 'Creates a Region resource belonging to a Map resource.',
        ),
        input: CreateMapRegionDTO::class,
        read: false,
        name: 'post_map_regions',
        processor: CreateMapRegionProcessor::class,
    ),
    new Put(
        uriTemplate: '/maps/{id}/regions/{regionId}',
        openapi: new Operation(
            summary: 'Updates a Region resource belonging to a Map resource.',
            description: 'Updates a Region resource belonging to a Map resource.',
        ),
        input: UpdateMapRegionDTO::class,
        read: false,
        name: 'put_map_region',
        processor: UpdateMapRegionProcessor::class
    ),
    new Delete(
        uriTemplate: '/maps/{id}/regions/{regionId}',
        controller: RemoveRegionController::class,
        openapi: new Operation(
            summary: 'Deletes a Region resource belonging to a Map resource.',
            description: 'Deletes a Region resource belonging to a Map resource.',
        ),
        read: false,
        name: 'delete_map_region',
    ),
])]
class Map
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['map:read'])]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    #[Groups(['map:read', 'map:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull, Assert\NotBlank]
    #[Groups(['map:read', 'map:write'])]
    private ?string $imageUrl = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotNull, Assert\NotBlank]
    #[Groups(['map:read', 'map:write'])]
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
    #[Groups(['map:read:regions'])]
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
