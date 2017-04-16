<?php

namespace Test\Unit\Chirp;

use Chirper\Chirp\Chirp;
use Chirper\Chirp\JsonApiChirpTransformer;
use Chirper\JsonApi\InvalidJsonException;
use Test\Unit\TestCase;

class JsonApiChirpTransformerTest extends TestCase
{
    public function testToChirpReturnsChirpWithPropertiesFromJson()
    {
        $uuid          = $this->faker->uuid;
        $text          = $this->faker->realText(25);
        $attributes    = (object)[
            'text' => $text
        ];
        $data          = (object)[
            'type' => 'chirp',
            'id' => $uuid,
            'attributes' => $attributes
        ];
        $requestObject = (object)[
            'data' => $data
        ];

        $json = json_encode($requestObject);

        $expectedChirp = new Chirp($text);

        $transformer = new JsonApiChirpTransformer();
        $chirp       = $transformer->toChirp($json);

        $this->assertEquals($expectedChirp, $chirp);
    }

    public function testToChirpThrowsInvalidJsonExceptionWhenJsonInvalid()
    {
        $this->expectException(InvalidJsonException::class);

        $json        = '{"data":"}';
        $transformer = new JsonApiChirpTransformer();
        $transformer->toChirp($json);
    }


//    public function testToChirpThrowsInvalidJsonApiExceptionWhenJsonApiInvalid()
//    {
//        $this->expectException(InvalidJsonException::class);
//    }
}