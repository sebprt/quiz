<?php

namespace App\Factory;

use App\Entity\Sentence;
use App\Entity\Word;
use App\Repository\SentenceRepository;
use Zenstruck\Foundry\LazyValue;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

use function Zenstruck\Foundry\lazy;
use function Zenstruck\Foundry\memoize;

/**
 * @extends ModelFactory<Sentence>
 *
 * @method        Sentence|Proxy                     create(array|callable $attributes = [])
 * @method static Sentence|Proxy                     createOne(array $attributes = [])
 * @method static Sentence|Proxy                     find(object|array|mixed $criteria)
 * @method static Sentence|Proxy                     findOrCreate(array $attributes)
 * @method static Sentence|Proxy                     first(string $sortedField = 'id')
 * @method static Sentence|Proxy                     last(string $sortedField = 'id')
 * @method static Sentence|Proxy                     random(array $attributes = [])
 * @method static Sentence|Proxy                     randomOrCreate(array $attributes = [])
 * @method static SentenceRepository|RepositoryProxy repository()
 * @method static Sentence[]|Proxy[]                 all()
 * @method static Sentence[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Sentence[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Sentence[]|Proxy[]                 findBy(array $attributes)
 * @method static Sentence[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Sentence[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class SentenceFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'text' => self::faker()->text(255),
            'words' => array_merge(
                WordFactory::new()->many(5)->create(),
                WordFactory::new()->many(1)->create([
                    'isCorrect' => true
                ]),
            ),
        ];
    }

    protected static function getClass(): string
    {
        return Sentence::class;
    }
}
