Feature: Validate CreateDeviceInformationItemCommand
  Scenario: Validate CreateDeviceInformationItemCommand with correct params
    Given I'm set correct params
    When I call Create DeviceInformation Item Validator
    Then I should get true result

  Scenario: Validate CreateDeviceInformationItemCommand with duplicate not exists paragraphId
    Given I'm set correct params
    But I'm set not exists param paragraphId
    When I call Create DeviceInformation Item Validator
    Then I should get message error "Not found paragraphId"

  Scenario: Validate CreateDeviceInformationItemCommand with invalid length label
    Given I'm set correct params
    But I'm set param "label" with incorrect value
    When I call Create DeviceInformation Item Validator
    Then I should get message error "Label must be >= 1 characters and <= 255 characters"

  Scenario: Validate CreateDeviceInformationItemCommand with not exists infoSource
    Given I'm set correct params
    But I'm set not exists param infoSource
    When I call Create DeviceInformation Item Validator
    Then I should get message error "Not found InfoSourceId"
