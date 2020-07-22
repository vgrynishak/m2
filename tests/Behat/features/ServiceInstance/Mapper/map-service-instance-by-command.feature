Feature: Map CreateServiceInstanceCommandInterface to ServiceInstanceInterface
  Scenario: I want to map CreateServiceInstanceCommandInterface to ServiceInstanceInterface
    Given I’m set correct CreateServiceInstanceCommand
    When I call Method Map
    Then I should get ServiceInstance that Implements ServiceInstanceInterface
