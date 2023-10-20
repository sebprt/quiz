<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Song;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class RemovedQuestionController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $repository,
    ) {
    }

    public function __invoke(string $id, string $questionId): void
    {
        $song = $this->repository->find(Song::class, $id);
        if ($song === null) {
            throw new EntityNotFoundException();
        }

        $question = $this->repository->find(Question::class, $questionId);
        if ($question === null) {
            throw new EntityNotFoundException();
        }

        $song->removeQuestion($question);

        $this->repository->persist($song);
        $this->repository->flush();
    }
}
