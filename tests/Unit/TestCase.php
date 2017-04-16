<?php

namespace Test\Unit;

use Faker;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var Faker\Generator */
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
        parent::__construct();
    }
}