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
            $this->persistenceDriver->create($chirp);
        } catch (InvalidJsonException $invalidJsonException) {
            return new UnableToCreateChirpResponse($invalidJsonException->getMessage());
        } catch (PersistenceDriverException $persistenceDriverException) {
            return new InternalServerErrorResponse($persistenceDriverException->getMessage());
        }

        return new ChirpCreatedResponse($json);
    }
}