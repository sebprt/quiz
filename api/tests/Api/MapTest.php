<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Map;
use App\Factory\MapFactory;
use App\Story\DefaultMapStory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use function Zenstruck\Foundry\faker;

class MapTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    protected function setUp(): void
    {
        parent::setUp();

        DefaultMapStory::load();
    }

    public function testCreateMap(): void
    {
        static::createClient()->request('POST', '/maps', [
            'json' => [
                'name' => $name = faker()->name(),
                'imageUrl' => $imageUrl = faker()->imageUrl(),
                'description' => $description = faker()->text(),
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Map',
            '@type' => 'Map',
            'name' => $name,
            'imageUrl' => $imageUrl,
            'description' => $description,
        ]);

        $this->assertMatchesResourceItemJsonSchema(Map::class);
    }

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/maps');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/Map',
            '@id' => '/maps',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 20,
        ]);
        $this->assertCount(20, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(Map::class);
    }

    public function testGetMap(): void
    {
        $event = MapFactory::first();

        $client = static::createClient();
        $iri = $this->findIriBy(Map::class, ['id' => $event->getId()]);

        $client->request('GET', $iri);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'name' => $event->getName(),
            'imageUrl' => $event->getImageUrl(),
            'description' => $event->getDescription(),
        ]);
    }

    public function testUpdateMap(): void
    {
        $event = MapFactory::first();

        $client = static::createClient();
        $iri = $this->findIriBy(Map::class, ['id' => $event->getId()]);

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
            'title' => $name,
            'imageUrl' => $event->getImageUrl(),
            'description' => $event->getDescription(),
        ]);
    }

    public function testDeleteMap(): void
    {
        $event = MapFactory::first();
        $id = $event->getId();

        $client = static::createClient();
        $iri = $this->findIriBy(Map::class, ['id' => $id]);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Map::class)->findOneBy(['id' => $id])
        );
    }
}
