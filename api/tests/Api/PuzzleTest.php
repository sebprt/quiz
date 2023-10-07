<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Puzzle;
use App\Factory\PuzzleFactory;
use App\Story\DefaultPuzzleStory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use function Zenstruck\Foundry\faker;

class PuzzleTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    protected function setUp(): void
    {
        parent::setUp();

        DefaultPuzzleStory::load();
    }

    public function testCreatePuzzle(): void
    {
        static::createClient()->request('POST', '/puzzles', [
            'json' => [
                'name' => $name = faker()->name(),
                'imageUrl' => $imageUrl = faker()->imageUrl(),
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Puzzle',
            '@type' => 'Puzzle',
            'name' => $name,
            'imageUrl' => $imageUrl,
        ]);

        $this->assertMatchesResourceItemJsonSchema(Puzzle::class);
    }

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/puzzles');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/Puzzle',
            '@id' => '/puzzles',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 30,
            'hydra:view' => [
                '@id' => '/puzzles?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/puzzles?page=1',
                'hydra:next' => '/puzzles?page=2',
                'hydra:last' => '/puzzles?page=2',
            ],
        ]);
        $this->assertCount(30, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(Puzzle::class);
    }

    public function testGetPuzzle(): void
    {
        $event = PuzzleFactory::first();

        $client = static::createClient();
        $iri = $this->findIriBy(Puzzle::class, ['id' => $event->getId()]);

        $client->request('GET', $iri);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'name' => $event->getName(),
            'imageUrl' => $event->getImageUrl(),
        ]);
    }

    public function testUpdatePuzzle(): void
    {
        $event = PuzzleFactory::first();

        $client = static::createClient();
        $iri = $this->findIriBy(Puzzle::class, ['id' => $event->getId()]);

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
        ]);
    }

    public function testDeletePuzzle(): void
    {
        $event = PuzzleFactory::first();
        $id = $event->getId();

        $client = static::createClient();
        $iri = $this->findIriBy(Puzzle::class, ['id' => $id]);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Puzzle::class)->findOneBy(['id' => $id])
        );
    }
}
