<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Sentence;
use App\Factory\SentenceFactory;
use App\Story\DefaultSentenceStory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use function Zenstruck\Foundry\faker;

class SentenceTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    protected function setUp(): void
    {
        parent::setUp();

        DefaultSentenceStory::load();
    }

    public function testCreateSentence(): void
    {
        static::createClient()->request('POST', '/sentences', [
            'json' => [
                'text' => $sentence = faker()->sentence,
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Sentence',
            '@type' => 'Sentence',
            'text' => $sentence,
        ]);

        $this->assertMatchesResourceItemJsonSchema(Sentence::class);
    }

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/sentences');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/Sentence',
            '@id' => '/sentences',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 20,
        ]);
        $this->assertCount(20, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(Sentence::class);
    }

    public function testGetSentence(): void
    {
        $event = SentenceFactory::first();

        $client = static::createClient();
        $iri = $this->findIriBy(Sentence::class, ['id' => $event->getId()]);

        $client->request('GET', $iri);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'text' => $event->getText(),
        ]);
    }

    public function testUpdateSentence(): void
    {
        $event = SentenceFactory::first();

        $client = static::createClient();
        $iri = $this->findIriBy(Sentence::class, ['id' => $event->getId()]);

        $client->request('PATCH', $iri, [
            'json' => [
                'text' => $sentence = faker()->sentence,
            ],
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ]
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'text' => $sentence,
        ]);
    }

    public function testDeleteSentence(): void
    {
        $event = SentenceFactory::first();
        $id = $event->getId();

        $client = static::createClient();
        $iri = $this->findIriBy(Sentence::class, ['id' => $id]);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Sentence::class)->findOneBy(['id' => $id])
        );
    }
}
