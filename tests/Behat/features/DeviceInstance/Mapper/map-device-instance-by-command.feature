Feature: Map CreateDeviceInstanceCommandInterface to DeviceInstanceInterface
  Scenario: I want to map CreateDeviceInstanceCommandInterface to DeviceInstanceInterface
    Given I’m set correct CreateDeviceInstanceCommand
    When I call Method Map
    Then I should get DeviceInstance that Implements DeviceInstanceInterface
