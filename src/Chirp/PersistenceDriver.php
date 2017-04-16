<?php

namespace Chirper\Chirp;

use Chirper\Persistence\PersistenceDriverException;

interface PersistenceDriver
{
    /**
     * @param Chirp $chirp
     * @return bool
     *
     * @throws PersistenceDriverException
     */
    public function create(Chirp $chirp): bool;
}