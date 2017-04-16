<?php

namespace Chirper\Chirp;

interface JsonChirpTransformer
{
    /**
     * @param string $json
     * @return Chirp
     */
    public function toChirp(string $json): Chirp;
}