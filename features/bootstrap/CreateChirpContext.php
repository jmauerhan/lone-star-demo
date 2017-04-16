<?php

namespace Test\Behavior\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Faker;
use GuzzleHttp\Client;

class CreateChirpContext implements Context
{
    /** @var Faker\Generator */
    private $faker;

    /** @var Client */
    private $httpClient;

    /** @var string */
    private $chirpText;

    /** @var string */
    private $chirpUuid;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
        $clientOpt = [
            'base_uri' => 'http://localhost:3000',
        ];
        $client = new Client($clientOpt);
        $this->httpClient = $client;
    }

    /**
     * @Given I write a Chirp with :numCharacters or less characters
     */
    public function iWriteAChirpWithOrLessCharacters($numCharacters)
    {
        $this->chirpText = $this->faker->realText($numCharacters);

    }

    /**
     * @When I post the Chirp
     */
    public function iPostTheChirp()
    {
        $this->chirpUuid = $this->faker->uuid();
        $obj = (object)[
            'data' => (object)[
                'type' => 'chirp',
                'id' => $this->chirpUuid,
                'attributes' => (object)[
                    'text' => $this->chirpText
                ]
            ]
        ];

        $this->httpClient->post('chirp', ['json' => $obj]);
    }

    /**
     * @Then I should see it in my timeline
     */
    public function iShouldSeeItInMyTimeline()
    {
        $timelineResponse = $this->httpClient->get('/');
        $responseJson = $timelineResponse->getBody()->getContents();
        $response = json_decode($responseJson);
        $chirps = $response->data;
        foreach ($chirps AS $chirp) {
            if ($chirp->id === $this->chirpUuid) {
                if ($chirp->attributes->text === $this->chirpText) {
                    return true;
                }
                throw new \Exception('A matching UUID was found, but the text did not match.');
            }
        }
        throw new \Exception('A Chirp matching the UUID and text was not found');
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
