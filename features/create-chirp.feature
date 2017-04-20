Feature: User can create Chirps with 100 character or less
  As a User of Chirper
  In order to share short messages with the world
  I need to be able to create Chirps

  Scenario: User Posts Chirp
    Given I write a Chirp with 100 or less characters
    When I post the Chirp
    Then I should see it in my timeline

  Scenario: User cannot post more than 100 characters
    Given I write a Chirp with more than 100 characters
    When I post the Chirp
    Then I should see an error
    And I should not see the Chirp in my timeline