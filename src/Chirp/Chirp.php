<?php

namespace Chirper\Chirp;


class Chirp
{
    /** @var string */
    private $id;
    /** @var string */
    private $text;

    public function __construct(string $id, string $text)
    {
        $this->id   = $id;
        $this->text = $text;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }
}