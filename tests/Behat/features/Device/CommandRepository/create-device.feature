Feature: Create Device
  Scenario: I want to create DeviceEntity by Device model
    Given I'm Set correct Device model
    When I Call Method Create
    Then I should get created device
