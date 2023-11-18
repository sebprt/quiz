<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\CreateMapRegionDTO;
use App\DTO\RegionQuestionDTO;
use App\DTO\UpdateMapRegionDTO;
use App\Entity\Map;
use App\Entity\Question;
use App\Entity\Region;
use App\Entity\RegionQuestion;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class CreateMapRegionProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $repository,
    ) {
    }

    /** @param CreateMapRegionDTO $data */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Map
    {
        /** @var Request $request */
        $request = $context['request'];
        $map = $this->repository->find(Map::class, $request->get('id'));
        if ($map === null) {
            throw new NotFoundHttpException();
        }

        $region =  (new Region())
            ->setName($data->name)
            ->setDescription($data->description)
            ->setIsUnlocked($data->isUnlocked)
            ->setImageUrl($data->imageUrl);

        array_map(
            fn (RegionQuestionDTO $question) => $region->addQuestion(
                (new RegionQuestion())
                    ->setText($question->text)
                    ->setAnswer($question->answer)
            ),
            $data->questions,
        );

        $map->addRegion($region);

        $this->repository->persist($map);
        $this->repository->flush();

        return $map;
    }
}
