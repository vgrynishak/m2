Feature: I want to check actions in the DeviceInstanceCommandRepositoryInterface
  Scenario: I want to create new DeviceInstanceEntity
    Given I'm set new DeviceInstanceInterface which I want to create
    When I Call Method Create
    Then I should get new DeviceInstanceEntity
