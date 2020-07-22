Feature: Get device list for child paragraph creation
  Scenario: I want to get right array group
    Given Device with id and array all devices
    When I call method group
    Then I should have right array group

  Scenario: I want to get exception on too high level array devices
    Given Device with id and array with too high level devices
    When I call method group
    Then I should have ChildrenDeviceInvalidLevelException