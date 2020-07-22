Feature: Use CreateServiceInstanceUseCaseInterface
  Scenario: I want to use CreateServiceInstanceUseCaseInterface
    Given I'm set CreateServiceInstanceCommandInterface
    When I call method create
    Then I should get ServiceInstanceInterface