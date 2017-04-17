<?php

namespace Chirper\Chirp;

class PdoPersistenceDriver implements PersistenceDriver
{
    /**
     * @param Chirp $chirp
     * @return bool
     *
     * @throws PersistenceDriverException
     */
    public function create(Chirp $chirp): bool
    {

    }
}