<?php

namespace Chirper\Chirp;

use Chirper\Persistence\PersistenceDriverException;

class PdoPersistenceDriver implements PersistenceDriver
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param Chirp $chirp
     * @return bool
     *
     * @throws PersistenceDriverException
     */
    public function create(Chirp $chirp): bool
    {
        $sql = "INSERT INTO chirp(id, chirp_text) VALUES(:id, :chirp_text)";
        try {
            $preparedStmt = $this->pdo->prepare($sql);
        } catch (\PDOException $PDOException) {
            throw new PersistenceDriverException($PDOException->getMessage());
        }

        $executed = $preparedStmt->execute(['id' => $chirp->getId(), 'chirp_text' => $chirp->getText()]);
        if ($executed === false) {
            throw new PersistenceDriverException();
        }

        return true;
    }

    public function getAll(): ChirpCollection
    {
        $sql  = "SELECT id, chirp_text FROM chirp";
        $stmt = $this->pdo->prepare($sql);

        $chirps = [];

        $results = $stmt->fetchAll();
        if (count($results) > 0) {
            foreach ($results AS $result) {
                $chirps[] = new Chirp($result['id'], $result['text']);
            }
        }
        return new ChirpCollection($chirps);
    }
}