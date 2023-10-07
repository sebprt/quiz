<?php

namespace App\Factory;

use App\Entity\Region;
use App\Entity\Word;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\LazyValue;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;
use function Zenstruck\Foundry\lazy;
use function Zenstruck\Foundry\memoize;

/**
 * @extends ModelFactory<Region>
 *
 * @method        Region|Proxy                     create(array|callable $attributes = [])
 * @method static Region|Proxy                     createOne(array $attributes = [])
 * @method static Region|Proxy                     find(object|array|mixed $criteria)
 * @method static Region|Proxy                     findOrCreate(array $attributes)
 * @method static Region|Proxy                     first(string $sortedField = 'id')
 * @method static Region|Proxy                     last(string $sortedField = 'id')
 * @method static Region|Proxy                     random(array $attributes = [])
 * @method static Region|Proxy                     randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static Region[]|Proxy[]                 all()
 * @method static Region[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Region[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Region[]|Proxy[]                 findBy(array $attributes)
 * @method static Region[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Region[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class RegionFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'description' => self::faker()->text(),
            'imageUrl' => self::faker()->imageUrl(),
            'isUnlocked' => true,
            'name' => self::faker()->text(255),
            'questions' => RegionQuestionFactory::new()->many(10),
        ];
    }

    protected static function getClass(): string
    {
        return Region::class;
    }
}
