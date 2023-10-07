<?php

namespace App\Factory;

use App\Entity\Event;
use App\Repository\EventRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Event>
 *
 * @method        Event|Proxy                     create(array|callable $attributes = [])
 * @method static Event|Proxy                     createOne(array $attributes = [])
 * @method static Event|Proxy                     find(object|array|mixed $criteria)
 * @method static Event|Proxy                     findOrCreate(array $attributes)
 * @method static Event|Proxy                     first(string $sortedField = 'id')
 * @method static Event|Proxy                     last(string $sortedField = 'id')
 * @method static Event|Proxy                     random(array $attributes = [])
 * @method static Event|Proxy                     randomOrCreate(array $attributes = [])
 * @method static EventRepository|RepositoryProxy repository()
 * @method static Event[]|Proxy[]                 all()
 * @method static Event[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Event[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Event[]|Proxy[]                 findBy(array $attributes)
 * @method static Event[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Event[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class EventFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'date' => self::faker()->dateTime(),
            'description' => self::faker()->text(255),
            'name' => self::faker()->text(255),
        ];
    }

    protected static function getClass(): string
    {
        return Event::class;
    }
}
