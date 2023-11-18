<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\UpdatePuzzlePieceDTO;
use App\Entity\Piece;
use App\Entity\Puzzle;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\Uuid;

final readonly class UpdatePuzzlePieceProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $repository,
    ) {
    }

    /** @param UpdatePuzzlePieceDTO $data */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Puzzle
    {
        /** @var Request $request */
        $request = $context['request'];
        $puzzle = $this->repository->find(Puzzle::class, $request->get('id'));
        if ($puzzle === null) {
            throw new NotFoundHttpException();
        }

        $puzzle->getQuestions()->map(
            fn (Piece $piece) =>
                $piece->getId()?->equals(Uuid::fromString($request->get('pieceId')))
                && $piece->setImageUrl($data->imageUrl)
                && $piece->setLocationX($data->locationX)
                && $piece->setLocationY($data->locationY)
                && $piece->setIsMissing($data->isMissing)
        );

        $this->repository->persist($puzzle);
        $this->repository->flush();

        return $puzzle;
    }
}
