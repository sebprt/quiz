<?php

namespace App\Factory;

use App\Entity\Piece;
use App\Entity\Puzzle;
use App\Repository\PuzzleRepository;
use Zenstruck\Foundry\LazyValue;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;
use function Symfony\Component\DependencyInjection\Loader\Configurator\iterator;
use function Zenstruck\Foundry\lazy;
use function Zenstruck\Foundry\memoize;

/**
 * @extends ModelFactory<Puzzle>
 *
 * @method        Puzzle|Proxy                     create(array|callable $attributes = [])
 * @method static Puzzle|Proxy                     createOne(array $attributes = [])
 * @method static Puzzle|Proxy                     find(object|array|mixed $criteria)
 * @method static Puzzle|Proxy                     findOrCreate(array $attributes)
 * @method static Puzzle|Proxy                     first(string $sortedField = 'id')
 * @method static Puzzle|Proxy                     last(string $sortedField = 'id')
 * @method static Puzzle|Proxy                     random(array $attributes = [])
 * @method static Puzzle|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PuzzleRepository|RepositoryProxy repository()
 * @method static Puzzle[]|Proxy[]                 all()
 * @method static Puzzle[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Puzzle[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Puzzle[]|Proxy[]                 findBy(array $attributes)
 * @method static Puzzle[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Puzzle[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PuzzleFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'imageUrl' => self::faker()->imageUrl(),
            'name' => self::faker()->text(255),
            'pieces' => array_merge(
                PieceFactory::new()->many(15)->create(),
                PieceFactory::new()->many(5)->create([
                    'isMissing' => true
                ]),
            ),
        ];
    }

    protected static function getClass(): string
    {
        return Puzzle::class;
    }
}
