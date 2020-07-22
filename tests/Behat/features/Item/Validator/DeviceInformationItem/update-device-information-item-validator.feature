Feature: Validate UpdateDeviceInformationItemCommand
  Scenario: Validate UpdateDeviceInformationItemCommand with correct params
    Given I'm set correct params
    When I call Update DeviceInformation Item Validator
    Then I should get true result

  Scenario: Validate UpdateDeviceInformationItemCommand with not exists paragraphId
    Given I'm set correct params
    But I'm set not exists param paragraphId
    When I call Update DeviceInformation Item Validator
    Then I should get message error "Not found paragraphId"

  Scenario: Validate UpdateDeviceInformationItemCommand with not exists itemId
    Given I'm set correct params
    But I'm set not exists param ItemId
    When I call Update DeviceInformation Item Validator
    Then I should get message error "Item Id is not exists"

  Scenario: Validate UpdateDeviceInformationItemCommand with invalid length label
    Given I'm set correct params
    But I'm set param "label" with incorrect value
    When I call Update DeviceInformation Item Validator
    Then I should get message error "Label must be >= 1 characters and <= 255 characters"

  Scenario: Validate UpdateDeviceInformationItemCommand with not exists infoSource
    Given I'm set correct params
    But I'm set not exists param infoSource
    When I call Update DeviceInformation Item Validator
    Then I should get message error "Not found InfoSourceId"
