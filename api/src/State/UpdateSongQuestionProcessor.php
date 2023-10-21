<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\UpdateSongQuestionDTO;
use App\Entity\Song;
use App\Entity\SongQuestion;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;

final readonly class UpdateSongQuestionProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $repository,
    ) {
    }

    /** @param UpdateSongQuestionDTO $data */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Song
    {
        /** @var Request $request */
        $request = $context['request'];
        $song = $this->repository->find(Song::class, $request->get('id'));
        if ($song === null) {
            throw new EntityNotFoundException();
        }

        $song->getQuestions()->map(
            fn (SongQuestion $question) =>
                $question->getId()?->equals(Uuid::fromString($request->get('questionId')))
                && $question->setText($data->text)
                && $question->setAnswer($data->answer)
        );

        $this->repository->persist($song);
        $this->repository->flush();

        return $song;
    }
}
