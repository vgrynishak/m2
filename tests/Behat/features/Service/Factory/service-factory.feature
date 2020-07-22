Feature: Make Service
  Scenario: Making Service implements ServiceInterface
    Given I'm Set Correct Params For Service
    When I Call Method make
    Then I Should Get Service implements ServiceInterface
