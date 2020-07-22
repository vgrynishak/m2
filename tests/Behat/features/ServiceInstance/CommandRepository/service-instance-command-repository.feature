Feature: I want to check actions in the ServiceInstanceCommandRepositoryInterface
  Scenario: I want to create new ServiceInstanceEntity
    Given I'm set new ServiceInstanceInterface which I want to create
    When I Call Method Create
    Then I should get new ServiceInstanceEntity
