<?php

namespace App\Factory;

use App\Entity\RegionQuestion;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<RegionQuestion>
 *
 * @method        RegionQuestion|Proxy             create(array|callable $attributes = [])
 * @method static RegionQuestion|Proxy             createOne(array $attributes = [])
 * @method static RegionQuestion|Proxy             find(object|array|mixed $criteria)
 * @method static RegionQuestion|Proxy             findOrCreate(array $attributes)
 * @method static RegionQuestion|Proxy             first(string $sortedField = 'id')
 * @method static RegionQuestion|Proxy             last(string $sortedField = 'id')
 * @method static RegionQuestion|Proxy             random(array $attributes = [])
 * @method static RegionQuestion|Proxy             randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static RegionQuestion[]|Proxy[]         all()
 * @method static RegionQuestion[]|Proxy[]         createMany(int $number, array|callable $attributes = [])
 * @method static RegionQuestion[]|Proxy[]         createSequence(iterable|callable $sequence)
 * @method static RegionQuestion[]|Proxy[]         findBy(array $attributes)
 * @method static RegionQuestion[]|Proxy[]         randomRange(int $min, int $max, array $attributes = [])
 * @method static RegionQuestion[]|Proxy[]         randomSet(int $number, array $attributes = [])
 */
final class RegionQuestionFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'answer' => self::faker()->text(255),
            'text' => self::faker()->text(255),
        ];
    }

    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(RegionQuestion $regionQuestion): void {})
        ;
    }

    protected static function getClass(): string
    {
        return RegionQuestion::class;
    }
}
