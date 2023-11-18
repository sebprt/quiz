<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Map;
use App\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsController]
class RemoveRegionController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $repository,
    ) {
    }

    public function __invoke(string $id, string $regionId): void
    {
        $map = $this->repository->find(Map::class, $id);
        if ($map === null) {
            throw new NotFoundHttpException();
        }

        $region = $this->repository->find(Region::class, $regionId);
        if ($region === null) {
            throw new NotFoundHttpException();
        }

        $map->removeQuestion($region);

        $this->repository->persist($map);
        $this->repository->flush();
    }
}
