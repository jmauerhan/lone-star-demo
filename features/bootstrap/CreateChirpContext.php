<?php

namespace Test\Behavior\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;

class CreateChirpContext implements Context
{

    /**
     * @Given I write a Chirp with :arg1 or less characters
     */
    public function iWriteAChirpWithOrLessCharacters($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I post the Chirp
     */
    public function iPostTheChirp()
    {
        throw new PendingException();
    }

    /**
     * @Then I should see it in my timeline
     */
    public function iShouldSeeItInMyTimeline()
    {
        throw new PendingException();
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
