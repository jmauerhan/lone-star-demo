<?php

namespace Test\Unit\Chirp;

use Chirper\Chirp\Chirp;
use Chirper\Chirp\ChirpCollection;
use Chirper\Chirp\PdoPersistenceDriver;
use Chirper\Persistence\PersistenceDriverException;
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
        $chirp = new Chirp($this->faker->uuid, 'Testing');
        $sql   = "INSERT INTO chirp(id, chirp_text) VALUES(:id, :chirp_text)";

        $statement = $this->createMock(\PDOStatement::class);
        $this->pdo->expects($this->once())
                  ->method('prepare')
                  ->with($sql)
                  ->willReturn($statement);

        $driver = new PdoPersistenceDriver($this->pdo);
        $driver->create($chirp);
    }

    public function testCreateThrowsExceptionWhenPrepareThrowsException()
    {
        $this->expectException(PersistenceDriverException::class);
        $chirp = new Chirp($this->faker->uuid, 'Testing');

        $this->pdo->method('prepare')
                  ->willThrowException(new \PDOException());

        $driver = new PdoPersistenceDriver($this->pdo);
        $driver->create($chirp);
    }

    public function testCreateExecutesStatement()
    {
        $uuid   = $this->faker->uuid;
        $chirp  = new Chirp($uuid, 'Testing');
        $params = ['chirp_text' => 'Testing',
                   'id' => $uuid];

        $statement = $this->createMock(\PDOStatement::class);
        $statement->expects($this->once())
                  ->method('execute')
                  ->with($params);

        $this->pdo->method('prepare')
                  ->willReturn($statement);

        $driver = new PdoPersistenceDriver($this->pdo);
        $driver->create($chirp);
    }

    public function testCreateThrowsExceptionWhenExecuteReturnsFalse()
    {
        $this->expectException(PersistenceDriverException::class);

        $chirp = new Chirp($this->faker->uuid, 'Testing');

        $statement = $this->createMock(\PDOStatement::class);
        $statement->method('execute')
                  ->willReturn(false);
        $this->pdo->method('prepare')
                  ->willReturn($statement);

        $driver = new PdoPersistenceDriver($this->pdo);
        $driver->create($chirp);
    }

    public function testCreateReturnsTrueWhenChirpInserted()
    {
        $chirp  = new Chirp($this->faker->uuid, 'Testing');
        $params = ['chirp_text' => 'Testing'];

        $statement = $this->createMock(\PDOStatement::class);
        $this->pdo->method('prepare')
                  ->willReturn($statement);

        $driver = new PdoPersistenceDriver($this->pdo);
        $this->assertTrue($driver->create($chirp));
    }

    public function testGetAllPreparesStatement()
    {
        $sql = "SELECT id, chirp_text FROM chirp";

        $statement = $this->createMock(\PDOStatement::class);
        $this->pdo->expects($this->once())
                  ->method('prepare')
                  ->with($sql)
                  ->willReturn($statement);

        $driver = new PdoPersistenceDriver($this->pdo);
        $driver->getAll();

    }

    public function testGetAllReturnsChirps()
    {
        $chirp  = new Chirp($this->faker->uuid, 'Testing');
        $chirp2 = new Chirp($this->faker->uuid, 'Test 2');

        $expectedCollection = new ChirpCollection([$chirp, $chirp2]);

        $results = [
            ['id' => $chirp->getId(), 'text' => $chirp->getText()],
            ['id' => $chirp2->getId(), 'text' => $chirp2->getText()],
        ];

        $statement = $this->createMock(\PDOStatement::class);
        $statement->method('fetchAll')
                  ->willReturn($results);

        $this->pdo->method('prepare')
                  ->willReturn($statement);

        $driver     = new PdoPersistenceDriver($this->pdo);
        $collection = $driver->getAll();
        $this->assertEquals($expectedCollection, $collection);
    }
}