<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Song;
use App\Factory\SongFactory;
use App\Story\DefaultSongStory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use function Zenstruck\Foundry\faker;

class SongTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    protected function setUp(): void
    {
        parent::setUp();

        DefaultSongStory::load();
    }

    public function testCreateSong(): void
    {
        static::createClient()->request('POST', '/songs', [
            'json' => [
                'title' => $title = faker()->title(),
                'artist' => $artist = faker()->name(),
                'genre' => $genre = faker()->word(),
                'audioUrl' => $audioUrl = faker()->url(),
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Song',
            '@type' => 'Song',
            'title' => $title,
            'artist' => $artist,
            'genre' => $genre,
            'audioUrl' => $audioUrl,
        ]);

        $this->assertMatchesResourceItemJsonSchema(Song::class);
    }

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/songs');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/Song',
            '@id' => '/songs',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 15,
        ]);
        $this->assertCount(15, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(Song::class);
    }

    public function testGetSong(): void
    {
        $event = SongFactory::first();

        $client = static::createClient();
        $iri = $this->findIriBy(Song::class, ['id' => $event->getId()]);

        $client->request('GET', $iri);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'title' => $event->getTitle(),
            'artist' => $event->getArtist(),
            'genre' => $event->getGenre(),
            'audioUrl' => $event->getAudioUrl(),
        ]);
    }

    public function testUpdateSong(): void
    {
        $event = SongFactory::first();

        $client = static::createClient();
        $iri = $this->findIriBy(Song::class, ['id' => $event->getId()]);

        $client->request('PATCH', $iri, [
            'json' => [
                'title' => $sentence = faker()->title(),
            ],
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ]
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'title' => $sentence,
            'artist' => $event->getArtist(),
            'genre' => $event->getGenre(),
            'audioUrl' => $event->getAudioUrl(),
        ]);
    }

    public function testDeleteSong(): void
    {
        $event = SongFactory::first();
        $id = $event->getId();

        $client = static::createClient();
        $iri = $this->findIriBy(Song::class, ['id' => $id]);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Song::class)->findOneBy(['id' => $id])
        );
    }
}
