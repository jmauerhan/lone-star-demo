<?php

namespace Chirper\Chirp;

use Chirper\JsonApi\InvalidJsonException;

interface JsonChirpTransformer
{
    /**
     * @param string $json
     * @return Chirp
     *
     * @throws InvalidJsonException
     */
    public function toChirp(string $json): Chirp;
}