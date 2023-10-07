<?php

namespace App\Factory;

use App\Entity\Piece;
use App\Entity\Puzzle;
use App\Repository\PuzzleRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

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
            'imageUrl' => self::faker()->text(255),
            'name' => self::faker()->text(255),
            'pieces' => PieceFactory::new()->many(100),
        ];
    }

    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (Puzzle $puzzle): void {
                $isMissingPieces = $puzzle->getPieces()->filter(fn (Piece $piece) => $piece->getIsMissing())->count();
                while ($isMissingPieces <= 20) {
                    $puzzle->getPieces()
                        ->get(random_int(0, 99))
                        ->setIsMissing(true);

                    $isMissingPieces++;
                }
            })
        ;
    }

    protected static function getClass(): string
    {
        return Puzzle::class;
    }
}
