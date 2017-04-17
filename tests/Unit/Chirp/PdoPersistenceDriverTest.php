<?php

namespace Test\Unit\Chirp;

use Chirper\Chirp\Chirp;
use Chirper\Chirp\PdoPersistenceDriver;
use Test\Unit\TestCase;

class PdoPersistenceDriverTest extends TestCase
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->createMock(\PDO::class);
        parent::__construct();
    }

    public function testCreatePreparesStatement()
    {
        $chirp = new Chirp('Testing');
        $sql   = "INSERT INTO chirp(chirp_text) VALUES(:chirp_text)";

        $statement = $this->createMock(\PDOStatement::class);
        $this->pdo->expects($this->once())
                  ->method('prepare')
                  ->with($sql)
                  ->willReturn($statement);

        $driver = new PdoPersistenceDriver($this->pdo);
        $driver->create($chirp);
    }

//    public function testCreateThrowsExceptionWhenPrepareThrowsException()
//    {
//    }
//
    public function testCreateExecutesStatement()
    {
        $chirp  = new Chirp('Testing');
        $params = ['chirp_text' => 'Testing'];

        $statement = $this->createMock(\PDOStatement::class);
        $statement->expects($this->once())
                  ->method('execute')
                  ->with($params);

        $this->pdo->method('prepare')
                  ->willReturn($statement);

        $driver = new PdoPersistenceDriver($this->pdo);
        $driver->create($chirp);
    }
//
//    public function testCreateThrowsExceptionWhenExecuteThrowsException()
//    {
//    }
//
//    public function testCreateReturnsTrueWhenChirpInserted()
//    {
//    }
}