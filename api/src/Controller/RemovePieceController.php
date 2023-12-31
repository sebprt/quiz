<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Piece;
use App\Entity\Puzzle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsController]
class RemovePieceController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $repository,
    ) {
    }

    public function __invoke(string $id, string $pieceId): void
    {
        $puzzle = $this->repository->find(Puzzle::class, $id);
        if ($puzzle === null) {
            throw new NotFoundHttpException();
        }

        $piece = $this->repository->find(Piece::class, $pieceId);
        if ($piece === null) {
            throw new NotFoundHttpException();
        }

        $puzzle->removePiece($piece);

        $this->repository->persist($puzzle);
        $this->repository->flush();
    }
}
