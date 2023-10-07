<?php

namespace App\Factory;

use App\Entity\Song;
use App\Repository\SongRepository;
use Zenstruck\Foundry\LazyValue;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;
use function Zenstruck\Foundry\lazy;
use function Zenstruck\Foundry\memoize;

/**
 * @extends ModelFactory<Song>
 *
 * @method        Song|Proxy                     create(array|callable $attributes = [])
 * @method static Song|Proxy                     createOne(array $attributes = [])
 * @method static Song|Proxy                     find(object|array|mixed $criteria)
 * @method static Song|Proxy                     findOrCreate(array $attributes)
 * @method static Song|Proxy                     first(string $sortedField = 'id')
 * @method static Song|Proxy                     last(string $sortedField = 'id')
 * @method static Song|Proxy                     random(array $attributes = [])
 * @method static Song|Proxy                     randomOrCreate(array $attributes = [])
 * @method static SongRepository|RepositoryProxy repository()
 * @method static Song[]|Proxy[]                 all()
 * @method static Song[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Song[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Song[]|Proxy[]                 findBy(array $attributes)
 * @method static Song[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Song[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class SongFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'artist' => self::faker()->text(255),
            'audioUrl' => self::faker()->text(255),
            'genre' => self::faker()->text(255),
            'title' => self::faker()->text(255),
            'questions' => SongQuestionFactory::new()->many(1, 5),
        ];
    }

    protected static function getClass(): string
    {
        return Song::class;
    }
}
