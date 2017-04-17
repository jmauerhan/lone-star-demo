<?php

namespace Chirper\Chirp;

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
        $sql          = "INSERT INTO chirp(chirp_text) VALUES(:chirp_text)";
        $preparedStmt = $this->pdo->prepare($sql);
        $preparedStmt->execute(['chirp_text' => $chirp->getText()]);

        return true;
    }
}