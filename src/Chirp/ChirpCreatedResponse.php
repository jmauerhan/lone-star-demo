<?php

namespace Chirper\Chirp;

use Chirper\Http\Response;

class ChirpCreatedResponse extends Response
{
    public function __construct(string $body)
    {
        parent::__construct(Response::CREATED, [], $body);
    }
}