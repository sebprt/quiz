<?php

namespace App\Factory;

use App\Entity\MathProblem;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<MathProblem>
 *
 * @method        MathProblem|Proxy                create(array|callable $attributes = [])
 * @method static MathProblem|Proxy                createOne(array $attributes = [])
 * @method static MathProblem|Proxy                find(object|array|mixed $criteria)
 * @method static MathProblem|Proxy                findOrCreate(array $attributes)
 * @method static MathProblem|Proxy                first(string $sortedField = 'id')
 * @method static MathProblem|Proxy                last(string $sortedField = 'id')
 * @method static MathProblem|Proxy                random(array $attributes = [])
 * @method static MathProblem|Proxy                randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static MathProblem[]|Proxy[]            all()
 * @method static MathProblem[]|Proxy[]            createMany(int $number, array|callable $attributes = [])
 * @method static MathProblem[]|Proxy[]            createSequence(iterable|callable $sequence)
 * @method static MathProblem[]|Proxy[]            findBy(array $attributes)
 * @method static MathProblem[]|Proxy[]            randomRange(int $min, int $max, array $attributes = [])
 * @method static MathProblem[]|Proxy[]            randomSet(int $number, array $attributes = [])
 */
final class MathProblemFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'answer' => self::faker()->text(255),
            'text' => self::faker()->text(255),
        ];
    }

    protected static function getClass(): string
    {
        return MathProblem::class;
    }
}
