Feature: Map DeviceInstanceEntity to DeviceInstanceInterface with DoctrineEntityDeviceInstanceMapper
  Scenario: I want to map DeviceInstanceEntity to DeviceInstanceInterface with DoctrineEntityDeviceInstanceMapper
    Given I’m find and set correct DeviceInstanceEntity
    When I call Method map
    Then I should get DeviceInstance that Implements DeviceInstanceInterface
