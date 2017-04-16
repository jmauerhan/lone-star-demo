<?php

namespace Test\Unit\Chirp;

use Chirper\Chirp\ChirpIoService;
use Chirper\Chirp\JsonChirpTransformer;
use Chirper\Chirp\PersistenceDriver;
use Chirper\Http\Request;
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

//    public function testCreateReturnsFailureResponseWhenTransformerThrowsException()
//    {
//
//    }
//
//    public function testCreatePersistsChirpReturnedFromTransformer()
//    {
//    }
//
//    public function testCreateReturnsInternalErrorResponseWhenPersistenceDriverThrowsException()
//    {
//    }
//
//    public function testCreateReturnsChirpCreatedResponse()
//    {
//    }
}