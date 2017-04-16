<?php

namespace Chirper\Chirp;

use Chirper\JsonApi\InvalidJsonException;

class JsonApiChirpTransformer implements JsonChirpTransformer
{
    public function toChirp(string $json): Chirp
    {
        //Validate
        //Transform
        $object = json_decode($json);
        if ($object === null) {
            throw new InvalidJsonException();
        }
        $data       = $object->data;
        $attributes = $data->attributes;
        return new Chirp($attributes->text);
    }
}