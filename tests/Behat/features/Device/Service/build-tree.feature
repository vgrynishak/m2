Feature: Build Tree Devices
  Scenario: I want to Build tree of devices
    Given I should have array of Devices
    When I call build method
    Then I should have tree array of devices

  Scenario: I want to try Build tree of devices without devices
    Given I should have empty array of Devices
    When I call build method
    Then I should have Exception "Device list is empty"

  Scenario: I want to try Build tree of devices with depth level more than 2
    Given I should have array of Devices with device with level more then two
    When I call build method
    Then I should have Exception "Too high level a maximum is allowed 2"