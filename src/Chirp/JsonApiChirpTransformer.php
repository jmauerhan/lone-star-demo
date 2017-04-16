<?php

namespace Chirper\Chirp;

class JsonApiChirpTransformer implements JsonChirpTransformer
{
    public function toChirp(string $json): Chirp
    {
        //Validate
        //Transform
        $object     = json_decode($json);
        $data       = $object->data;
        $attributes = $data->attributes;
        return new Chirp($attributes->text);
    }
}