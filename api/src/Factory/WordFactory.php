<?php

namespace App\Factory;

use App\Entity\Word;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Word>
 *
 * @method        Word|Proxy                       create(array|callable $attributes = [])
 * @method static Word|Proxy                       createOne(array $attributes = [])
 * @method static Word|Proxy                       find(object|array|mixed $criteria)
 * @method static Word|Proxy                       findOrCreate(array $attributes)
 * @method static Word|Proxy                       first(string $sortedField = 'id')
 * @method static Word|Proxy                       last(string $sortedField = 'id')
 * @method static Word|Proxy                       random(array $attributes = [])
 * @method static Word|Proxy                       randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static Word[]|Proxy[]                   all()
 * @method static Word[]|Proxy[]                   createMany(int $number, array|callable $attributes = [])
 * @method static Word[]|Proxy[]                   createSequence(iterable|callable $sequence)
 * @method static Word[]|Proxy[]                   findBy(array $attributes)
 * @method static Word[]|Proxy[]                   randomRange(int $min, int $max, array $attributes = [])
 * @method static Word[]|Proxy[]                   randomSet(int $number, array $attributes = [])
 */
final class WordFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'isCorrect' => false,
            'text' => self::faker()->text(255),
        ];
    }

    protected static function getClass(): string
    {
        return Word::class;
    }
}
