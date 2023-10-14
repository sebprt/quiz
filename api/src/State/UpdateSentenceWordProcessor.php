<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\UpdateSentenceWordDTO;
use App\Entity\Sentence;
use App\Entity\Word;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;

final readonly class UpdateSentenceWordProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $repository,
    )
    {
    }

    /** @param UpdateSentenceWordDTO $data */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Sentence
    {
        /** @var Request $request */
        $request = $context['request'];
        $sentence = $this->repository->find(Sentence::class, $request->get('id'));
        if ($sentence === null) {
            throw new EntityNotFoundException();
        }

        $sentence->getWords()->map(
            fn (Word $word) =>
                $word->getId()?->equals(Uuid::fromString($request->get('wordId')))
                && $word->setText($data->text)
                && $word->setIsCorrect($data->isCorrect)
        );

        $this->repository->persist($sentence);
        $this->repository->flush();

        return $sentence;
    }
}
