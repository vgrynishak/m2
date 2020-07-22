Feature: Map DeviceEntity to DeviceInterface with DoctrineEntityDeviceMapper
  Scenario: I want to map DeviceEntity to DeviceInterface with DoctrineEntityDeviceMapper
    Given I’m find and set correct DeviceEntity
    When I call Method map
    Then I should get Device which Implements DeviceInterface
