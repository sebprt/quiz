<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\CreatePuzzlePieceDTO;
use App\DTO\MathProblemDTO;
use App\DTO\RegionQuestionDTO;
use App\DTO\UpdatePuzzlePieceDTO;
use App\Entity\MathProblem;
use App\Entity\Piece;
use App\Entity\Puzzle;
use App\Entity\Region;
use App\Entity\RegionQuestion;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\Uuid;

final readonly class CreatePuzzlePieceProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $repository,
    ) {
    }

    /** @param CreatePuzzlePieceDTO $data */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Puzzle
    {
        /** @var Request $request */
        $request = $context['request'];
        $puzzle = $this->repository->find(Puzzle::class, $request->get('id'));
        if ($puzzle === null) {
            throw new NotFoundHttpException();
        }

        $piece = (new Piece())
            ->setLocationY($data->locationY)
            ->setLocationX($data->locationX)
            ->setIsMissing($data->isMissing)
            ->setImageUrl($data->imageUrl);

        array_map(
            fn (MathProblemDTO $problem) => $piece->addMathProblem(
                (new MathProblem())
                    ->setText($problem->text)
                    ->setAnswer($problem->answer)
            ),
            $data->questions,
        );

        $puzzle->addPiece($piece);

        $this->repository->persist($puzzle);
        $this->repository->flush();

        return $puzzle;
    }
}
