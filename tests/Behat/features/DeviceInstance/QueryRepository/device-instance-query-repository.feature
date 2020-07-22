Feature: I want to check requests in the DeviceInstanceQueryRepositoryInterface
  Scenario: I want to find DeviceInstanceInterface
    Given I'm set DeviceInstanceId
    When I Call Method find
    Then I should get DeviceInstanceInterface

  Scenario: I want to not find DeviceInstanceInterface
    Given I'm set incorrect DeviceInstanceId
    When I Call Method find
    Then I should not get DeviceInstanceInterface
