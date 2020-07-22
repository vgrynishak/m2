Feature: Map new DeviceInstanceInterface to DeviceInstanceEntity with DeviceInstanceModel
  Scenario: I want to map new DeviceInstanceInterface to DeviceInstanceEntity with DeviceInstanceModel
    Given I’m set correct DeviceInstanceInterface
    When I call Method mapNew
    Then I should get DeviceInstanceEntity that Implements DeviceInstanceEntity
