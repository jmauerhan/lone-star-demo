<?php

namespace Test\Unit\Chirp;

use Chirper\Chirp\JsonChirpTransformer;
use Chirper\Chirp\PersistenceDriver;
use Test\Unit\TestCase;

class ChirpIoServiceTest extends TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|JsonChirpTransformer */
    private $transformer;

    /** @var \PHPUnit_Framework_MockObject_MockObject|PersistenceDriver */
    private $persistenceDriver;

    public function __construct()
    {
        $this->transformer = $this->createMock(JsonChirpTransformer::class);
        $this->persistenceDriver = $this->createMock(PersistenceDriver::class);
    }

    public function testCreateSendsJsonFromRequestToTransformer()
    {
    }

    public function testCreateReturnsFailureResponseWhenTransformerThrowsException()
    {
    }

    public function testCreatePersistsChirpReturnedFromTransformer()
    {
    }

    public function testCreateReturnsInternalErrorResponseWhenPersistenceDriverThrowsException()
    {
    }

    public function testCreateReturnsChirpCreatedResponse()
    {
    }
}