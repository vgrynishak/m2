Feature: Parse request for FindByChildrenDeviceQuery
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call ChildrenDevice Parser
    Then I should get FindByChildrenDeviceQuery

  Scenario: Parse request without deviceId param
    Given I'm set correct params
    But param "deviceId" is empty
    When I call ChildrenDevice Parser
    Then I should get Exception "Argument deviceId is required"

  Scenario: Parse request with invalid deviceId
    Given I'm set correct params
    But I'm set param "deviceId" with next value "incorrect_device_id"
    When I call ChildrenDevice Parser
    Then I should get Exception "Invalid DeviceId given"

  Scenario: Parse request without root key
    Given I'm set correct params
    But param root key is empty
    When I call ChildrenDevice Parser
    Then I should get Exception "Invalid root key"

  Scenario: Parse request without groupId
    Given I'm set correct params
    But param groupId  is empty
    When I call ChildrenDevice Parser
    Then I should get Exception "groupId is required field"
