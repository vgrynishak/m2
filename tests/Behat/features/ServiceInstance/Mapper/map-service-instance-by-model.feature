Feature: Map new ServiceInstanceInterface to ServiceInstanceEntity with ServiceInstanceModel
  Scenario: I want to map new ServiceInstanceInterface to ServiceInstanceEntity with ServiceInstanceModel
    Given I’m set correct ServiceInstanceInterface
    When I call Method mapNew
    Then I should get ServiceInstanceEntity that Implements ServiceInstanceEntity
