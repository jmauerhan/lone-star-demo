<?php

namespace Chirper\Chirp;

use Chirper\JsonApi\InvalidJsonApiException;
use Chirper\JsonApi\InvalidJsonException;

class JsonApiChirpTransformer implements JsonChirpTransformer
{
    public function toChirp(string $json): Chirp
    {
        //Validate
        $object = json_decode($json);
        if ($object === null) {
            throw new InvalidJsonException();
        }
        if (property_exists($object, 'data') === false) {
            throw new InvalidJsonApiException();
        }
        $data       = $object->data;
        $attributes = $data->attributes;
        //Transform
        return new Chirp($attributes->text);
    }
}