Feature: Map command implements CreateServiceCommandInterface to ServiceInterface
  Scenario: I want to map command implements CreateServiceCommandInterface to ServiceInterface
    Given I’m set correct command implements CreateServiceCommandInterface
    When I call Method Map
    Then I should get Service that implements ServiceInterface
    And I should get same Service properties
