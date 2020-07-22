Feature: Map Device model to DeviceEntity
  Scenario: I want to map exists Device model to DeviceEntity
    Given I'm Set exists Device model
    When I Call Method Map
    Then I should get same DeviceEntity

  Scenario: I want to map new Device model to DeviceEntity
    Given I'm Set new Device model
    When I Call Method MapNew
    Then I should get same DeviceEntity
