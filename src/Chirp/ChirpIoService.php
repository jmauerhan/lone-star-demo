<?php

namespace Chirper\Chirp;

use Chirper\Http\Request;
use Chirper\Http\Response;

class ChirpIoService
{
    /** @var JsonChirpTransformer */
    private $jsonTransformer;

    /** @var PersistenceDriver */
    private $persistenceDriver;

    public function __construct(JsonChirpTransformer $transformer, PersistenceDriver $persistenceDriver)
    {
        $this->jsonTransformer   = $transformer;
        $this->persistenceDriver = $persistenceDriver;
    }

    public function create(Request $request): Response
    {
        $json = $request->getBody()->getContents();
        $this->jsonTransformer->toChirp($json);
        return new Response();
    }
}