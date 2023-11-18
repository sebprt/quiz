<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\UpdateMapRegionDTO;
use App\Entity\Map;
use App\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\Uuid;

final readonly class UpdateMapRegionProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $repository,
    ) {
    }

    /** @param UpdateMapRegionDTO $data */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Map
    {
        /** @var Request $request */
        $request = $context['request'];
        $map = $this->repository->find(Map::class, $request->get('id'));
        if ($map === null) {
            throw new NotFoundHttpException();
        }

        $map->getRegions()->map(
            fn (Region $region) =>
                $region->getId()?->equals(Uuid::fromString($request->get('regionId')))
                && ($data->imageUrl !== null ? $region->setImageUrl($data->imageUrl) : null)
                && ($data->name !== null ? $region->setName($data->name) : null)
                && ($data->description !== null ? $region->setDescription($data->description) : null)
                && ($data->isUnlocked !== null ? $region->setIsUnlocked($data->isUnlockednull) : null)
        );

        $this->repository->persist($map);
        $this->repository->flush();

        return $map;
    }
}
