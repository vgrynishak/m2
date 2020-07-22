Feature: Parse request to CreateChildWithDeviceCommand
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call CreateChildWithDeviceParser
    Then I should get CreateChildWithDevice command
    And property header should be instance of CustomHeaderInterface

  Scenario: Parse request with correct params
    Given I'm set correct params
    But param "title" is absent
    When I call CreateChildWithDeviceParser
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Title is required field"

  Scenario: Parse request with correct params
    Given I'm set correct params
    But param "title" is empty
    When I call CreateChildWithDeviceParser
    Then I should get CreateChildWithDevice command
    And Style HeaderType should be instance of DeviceCardInterface

  Scenario: Parse request with correct params
    Given I'm set correct params
    But param "styleTemplate" is absent
    When I call CreateChildWithDeviceParser
    Then I should get CreateChildWithDevice command
    And Style Template Id should be default

  Scenario: Parse request with incorrect parent key
    Given I'm create request with incorrect parent key
    When I call CreateChildWithDeviceParser
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Invalid root key"

  Scenario: Parse request without ID param
    Given I'm set correct params
    But param "id" is absent
    When I call CreateChildWithDeviceParser
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Paragraph Id is required field"

  Scenario: Parse request without ParentId param
    Given I'm set correct params
    But param "parentId" is absent
    When I call CreateChildWithDeviceParser
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Parent Id is required field"

  Scenario: Parse request without DeviceId param
    Given I'm set correct params
    But param "deviceId" is absent
    When I call CreateChildWithDeviceParser
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Device Id is required field"

  Scenario: Parse request without FilterId param
    Given I'm set correct params
    But param "filterId" is absent
    When I call CreateChildWithDeviceParser
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Filter Id is required field"

  Scenario: Parse request with invalid paragraph id
    Given I'm set correct params
    But I'm set param "id" with incorrect value
    When I call CreateChildWithDeviceParser
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Invalid Paragraph Id"

  Scenario: Parse request with invalid parent id
    Given I'm set correct params
    But I'm set not exists param parentId
    When I call CreateChildWithDeviceParser
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Parent Paragraph was not found"

  Scenario: Parse request with invalid parent id
    Given I'm set correct params
    But I'm set param "parentId" with incorrect value
    When I call CreateChildWithDeviceParser
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Invalid Paragraph Id"

  Scenario: Parse request with invalid device id
    Given I'm set correct params
    But I'm set param "deviceId" with incorrect value
    When I call CreateChildWithDeviceParser
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. Invalid DeviceId given"

  Scenario: Parse request with invalid filter id
    Given I'm set correct params
    But I'm set param "filterId" with incorrect value
    When I call CreateChildWithDeviceParser
    Then I should get FailCreateAction Exception
    And error message should be "Bad request. "
