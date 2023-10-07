<?php

namespace App\Factory;

use App\Entity\SongQuestion;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<SongQuestion>
 *
 * @method        SongQuestion|Proxy               create(array|callable $attributes = [])
 * @method static SongQuestion|Proxy               createOne(array $attributes = [])
 * @method static SongQuestion|Proxy               find(object|array|mixed $criteria)
 * @method static SongQuestion|Proxy               findOrCreate(array $attributes)
 * @method static SongQuestion|Proxy               first(string $sortedField = 'id')
 * @method static SongQuestion|Proxy               last(string $sortedField = 'id')
 * @method static SongQuestion|Proxy               random(array $attributes = [])
 * @method static SongQuestion|Proxy               randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static SongQuestion[]|Proxy[]           all()
 * @method static SongQuestion[]|Proxy[]           createMany(int $number, array|callable $attributes = [])
 * @method static SongQuestion[]|Proxy[]           createSequence(iterable|callable $sequence)
 * @method static SongQuestion[]|Proxy[]           findBy(array $attributes)
 * @method static SongQuestion[]|Proxy[]           randomRange(int $min, int $max, array $attributes = [])
 * @method static SongQuestion[]|Proxy[]           randomSet(int $number, array $attributes = [])
 */
final class SongQuestionFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'answer' => self::faker()->text(255),
            'text' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(SongQuestion $songQuestion): void {})
        ;
    }

    protected static function getClass(): string
    {
        return SongQuestion::class;
    }
}
