<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Event;
use App\Factory\EventFactory;
use App\Story\DefaultEventsStory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use function Zenstruck\Foundry\faker;

class EventTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    protected function setUp(): void
    {
        parent::setUp();

        DefaultEventsStory::load();
    }

    public function testCreateEvent(): void
    {
        static::createClient()->request('POST', '/events', [
            'json' => [
                'name' => $name = faker()->name(),
                'date' => $date = faker()->date(),
                'description' => $description = faker()->text(),
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Event',
            '@type' => 'Event',
            'name' => $name,
            'date' => $date,
            'description' => $description,
        ]);

        $this->assertMatchesResourceItemJsonSchema(Event::class);
    }

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/events');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/Event',
            '@id' => '/events',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 50,
            'hydra:view' => [
                '@id' => '/events?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/events?page=1',
                'hydra:last' => '/events?page=2',
            ],
        ]);
        $this->assertCount(30, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(Event::class);
    }

    public function testGetEvent(): void
    {
        $event = EventFactory::first();

        $client = static::createClient();
        $iri = $this->findIriBy(Event::class, ['id' => $event->getId()]);

        $client->request('GET', $iri);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'name' => $event->getName(),
            'description' => $event->getDescription(),
            'date' => $event->getDate()->format('Y-m-d'),
        ]);
    }

    public function testUpdateEvent(): void
    {
        $event = EventFactory::first();

        $client = static::createClient();
        $iri = $this->findIriBy(Event::class, ['id' => $event->getId()]);

        $client->request('PATCH', $iri, [
            'json' => [
                'name' => $name = faker()->name(),
            ],
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ]
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'name' => $name,
            'description' => $event->getDescription(),
            'date' => $event->getDate()->format('Y-m-d'),
        ]);
    }

    public function testDeleteEvent(): void
    {
        $event = EventFactory::first();
        $id = $event->getId();

        $client = static::createClient();
        $iri = $this->findIriBy(Event::class, ['id' => $id]);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Event::class)->findOneBy(['id' => $id])
        );
    }
}
