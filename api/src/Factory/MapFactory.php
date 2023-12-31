<?php

namespace App\Factory;

use App\Entity\Map;
use App\Repository\MapRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

use function Zenstruck\Foundry\lazy;
use function Zenstruck\Foundry\memoize;

/**
 * @extends ModelFactory<Map>
 *
 * @method        Map|Proxy                     create(array|callable $attributes = [])
 * @method static Map|Proxy                     createOne(array $attributes = [])
 * @method static Map|Proxy                     find(object|array|mixed $criteria)
 * @method static Map|Proxy                     findOrCreate(array $attributes)
 * @method static Map|Proxy                     first(string $sortedField = 'id')
 * @method static Map|Proxy                     last(string $sortedField = 'id')
 * @method static Map|Proxy                     random(array $attributes = [])
 * @method static Map|Proxy                     randomOrCreate(array $attributes = [])
 * @method static MapRepository|RepositoryProxy repository()
 * @method static Map[]|Proxy[]                 all()
 * @method static Map[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Map[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Map[]|Proxy[]                 findBy(array $attributes)
 * @method static Map[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Map[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class MapFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'description' => self::faker()->text(),
            'imageUrl' => self::faker()->imageUrl(),
            'name' => self::faker()->text(255),
            'regions' => RegionFactory::new()->many(5),
        ];
    }

    protected static function getClass(): string
    {
        return Map::class;
    }
}
