<?php

namespace Test\Integration\Chirp;

use Chirper\Http\Request;
use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;
use Test\Unit\TestCase;

class CreateChirpTest extends TestCase
{
    private $host = 'http://localhost:3000';

    public function testValidPostReturnsSuccessfulResponse()
    {
        $attributes = (object)['text' => 'This is a new Chirp'];
        $data       = (object)[
            'type' => 'chirp',
            'id' => Uuid::uuid4(),
            'attributes' => $attributes
        ];
        $object     = (object)['data' => $data];
        $payload    = json_encode($object);

        $guzzle   = new Client(['base_uri' => $this->host]);
        $opt      = ['body' => $payload];
        $response = $guzzle->post('chirp', $opt);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($payload, $response->getBody()->getContents());

    }
}