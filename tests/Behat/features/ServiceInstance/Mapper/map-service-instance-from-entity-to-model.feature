Feature: Map ServiceInstanceEntity to ServiceInstanceInterface with DoctrineEntityServiceInstanceMapper
  Scenario: I want to map ServiceInstanceEntity to ServiceInstanceInterface with DoctrineEntityServiceInstanceMapper
    Given I’m find and set correct ServiceInstanceEntity
    When I call Method map
    Then I should get ServiceInstance that Implements ServiceInstanceInterface
