<?php

namespace Test\Unit\Chirp;

use Chirper\Chirp\Chirp;
use Chirper\Chirp\ChirpCreatedResponse;
use Chirper\Chirp\ChirpIoService;
use Chirper\Chirp\JsonChirpTransformer;
use Chirper\Chirp\PersistenceDriver;
use Chirper\Chirp\UnableToCreateChirpResponse;
use Chirper\Http\InternalServerErrorResponse;
use Chirper\Http\Request;
use Chirper\JsonApi\InvalidJsonException;
use Chirper\Persistence\PersistenceDriverException;
use Test\Unit\TestCase;

class ChirpIoServiceTest extends TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|JsonChirpTransformer */
    private $transformer;

    /** @var \PHPUnit_Framework_MockObject_MockObject|PersistenceDriver */
    private $persistenceDriver;

    public function __construct()
    {
        $this->transformer       = $this->createMock(JsonChirpTransformer::class);
        $this->persistenceDriver = $this->createMock(PersistenceDriver::class);
        parent::__construct();
    }

    public function testCreateSendsJsonFromRequestToTransformer()
    {
        $json    = '{"data":"some data"}';
        $request = new Request('POST', 'chirp', [], $json);

        $this->transformer->expects($this->once())
                          ->method('toChirp')
                          ->with($json);

        $service = new ChirpIoService($this->transformer, $this->persistenceDriver);
        $service->create($request);

    }

    public function testCreateReturnsFailureResponseWhenTransformerThrowsException()
    {
        $json      = '{"data}';
        $reason    = 'Invalid JSON: ' . $json;
        $exception = new InvalidJsonException($reason);

        $this->transformer->method('toChirp')
                          ->willThrowException($exception);

        $request  = new Request('POST', 'chirp', [], $json);
        $service  = new ChirpIoService($this->transformer, $this->persistenceDriver);
        $response = $service->create($request);

        $this->assertInstanceOf(UnableToCreateChirpResponse::class, $response);

    }

    public function testCreatePersistsChirpReturnedFromTransformer()
    {
        $json    = '{"data":"valid chirp"}';
        $request = new Request('POST', 'chirp', [], $json);

        $chirp = new Chirp('Test');
        $this->transformer->method('toChirp')
                          ->willReturn($chirp);

        $this->persistenceDriver->expects($this->once())
                                ->method('create')
                                ->with($chirp);

        $service = new ChirpIoService($this->transformer, $this->persistenceDriver);
        $service->create($request);
    }

    public function testCreateReturnsInternalServerErrorResponseWhenPersistenceDriverThrowsException()
    {
        $this->persistenceDriver->method('create')
                                ->willThrowException(new PersistenceDriverException());

        $request  = new Request('POST', 'chirp');
        $service  = new ChirpIoService($this->transformer, $this->persistenceDriver);
        $response = $service->create($request);

        $this->assertInstanceOf(InternalServerErrorResponse::class, $response);
    }

    public function testCreateReturnsChirpCreatedResponse()
    {
        $request  = new Request('POST', 'chirp');
        $service  = new ChirpIoService($this->transformer, $this->persistenceDriver);
        $response = $service->create($request);

        $this->assertInstanceOf(ChirpCreatedResponse::class, $response);
    }
}