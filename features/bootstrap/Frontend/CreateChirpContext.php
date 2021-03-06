<?php

namespace Test\Behavior\Context\Frontend;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Faker;
use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Session;

class CreateChirpContext implements Context
{
    /** @var Faker\Generator */
    private $faker;

    /** @var Session */
    private $session;

    /** @var string */
    private $chirpText;

    /** @var string */
    private $chirpUuid;

    private $host = 'http://localhost:8080';

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
        $driver      = new GoutteDriver();
        $session     = new Session($driver);
        $session->start();
        $this->session = $session;
    }

    /**
     * @Given I write a Chirp with :numCharacters or less characters
     */
    public function iWriteAChirpWithOrLessCharacters($numCharacters)
    {
        $this->chirpText = $this->faker->realText($numCharacters);
        $this->session->visit($this->host);
        $page = $this->session->getPage();
        $page->fillField('Chirp', $this->chirpText);
    }

    /**
     * @When I post the Chirp
     */
    public function iPostTheChirp()
    {
        $page = $this->session->getPage();
        $page->pressButton('Submit');
    }

    /**
     * @Then I should see it in my timeline
     */
    public function iShouldSeeItInMyTimeline()
    {
        $page = $this->session->getPage();
        if ($page->hasContent($this->chirpText) !== true) {
            throw new \Exception("Chirp Text of: '{$this->chirpText}' Not Found");
        }
    }

    /**
     * @Given I write a Chirp with more than :arg1 characters
     */
    public function iWriteAChirpWithMoreThanCharacters($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see an error
     */
    public function iShouldSeeAnError()
    {
        throw new PendingException();
    }

    /**
     * @Then I should not see the Chirp in my timeline
     */
    public function iShouldNotSeeTheChirpInMyTimeline()
    {
        throw new PendingException();
    }
}
