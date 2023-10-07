<?php

namespace App\Factory;

use App\Entity\Piece;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Piece>
 *
 * @method        Piece|Proxy                      create(array|callable $attributes = [])
 * @method static Piece|Proxy                      createOne(array $attributes = [])
 * @method static Piece|Proxy                      find(object|array|mixed $criteria)
 * @method static Piece|Proxy                      findOrCreate(array $attributes)
 * @method static Piece|Proxy                      first(string $sortedField = 'id')
 * @method static Piece|Proxy                      last(string $sortedField = 'id')
 * @method static Piece|Proxy                      random(array $attributes = [])
 * @method static Piece|Proxy                      randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static Piece[]|Proxy[]                  all()
 * @method static Piece[]|Proxy[]                  createMany(int $number, array|callable $attributes = [])
 * @method static Piece[]|Proxy[]                  createSequence(iterable|callable $sequence)
 * @method static Piece[]|Proxy[]                  findBy(array $attributes)
 * @method static Piece[]|Proxy[]                  randomRange(int $min, int $max, array $attributes = [])
 * @method static Piece[]|Proxy[]                  randomSet(int $number, array $attributes = [])
 */
final class PieceFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'imageUrl' => self::faker()->text(255),
            'isMissing' => self::faker()->boolean(),
            'locationX' => self::faker()->randomFloat(),
            'locationY' => self::faker()->randomFloat(),
        ];
    }

    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Piece $piece): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Piece::class;
    }
}
