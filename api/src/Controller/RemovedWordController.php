<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Sentence;
use App\Entity\Word;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class RemovedWordController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $repository,
    ){}

    public function __invoke(string $id, string $wordId): void
    {
        $sentence = $this->repository->find(Sentence::class, $id);
        if ($sentence === null) {
            throw new EntityNotFoundException();
        }

        $word = $this->repository->find(Word::class, $wordId);
        if ($word === null) {
            throw new EntityNotFoundException();
        }

        $sentence->removeWord($word);
        $this->repository->persist($sentence);
    }
}
