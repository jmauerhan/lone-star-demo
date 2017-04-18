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
        $data = $object->data;

        if (property_exists($data, 'type') === false) {
            throw new InvalidJsonApiException();
        }
        if (property_exists($data, 'id') === false) {
            throw new InvalidJsonApiException();
        }
        if (property_exists($data, 'attributes') === false) {
            throw new InvalidJsonApiException();
        }
        $attributes = $data->attributes;
        if (property_exists($attributes, 'text') === false) {
            throw new InvalidJsonApiException();
        }
        //Transform
        return new Chirp($data->id, $attributes->text);
    }

    public function collectionToJson(ChirpCollection $chirpCollection): string
    {
        $data = [];
        /** @var Chirp $chirp */
        foreach ($chirpCollection AS $chirp) {
            $attributes = (object)['text' => $chirp->getText()];
            $data[]     = (object)[
                'type' => 'chirps',
                'id' => $chirp->getId(),
                'attributes' => $attributes
            ];
        }
        $result = (object)['data' => $data];
        return json_encode($result);
    }
}