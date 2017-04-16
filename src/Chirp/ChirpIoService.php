<?php

namespace Chirper\Chirp;

use Chirper\Http\InternalServerErrorResponse;
use Chirper\Http\Request;
use Chirper\Http\Response;
use Chirper\JsonApi\InvalidJsonException;
use Chirper\Persistence\PersistenceDriverException;

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
        try {
            $chirp = $this->jsonTransformer->toChirp($json);
        } catch (InvalidJsonException $e) {
            return new UnableToCreateChirpResponse($e->getMessage());
        }
        try {
            $this->persistenceDriver->create($chirp);
        } catch (PersistenceDriverException $e) {
            return new InternalServerErrorResponse();
        }

        return new Response();
    }
}