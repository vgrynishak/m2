Feature: Parse request for FindByRootDeviceQuery
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call RootDevice Parser
    Then I should get FindByRootDeviceQuery

  Scenario: Parse request without deviceId param
    Given I'm set correct params
    But param "deviceId" is empty
    When I call RootDevice Parser
    Then I should get Exception "Argument deviceId is required"

  Scenario: Parse request with invalid deviceId
    Given I'm set correct params
    But I'm set param "deviceId" with next value "incorrect_device_id"
    When I call RootDevice Parser
    Then I should get Exception "Invalid DeviceId given"