Feature: Parse request for ChangeSectionPositionCommandInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call ChangeSectionPositionParser
    Then I should get ChangeSectionPositionCommandInterface command

  Scenario: Parse request without ID param
    Given I'm set correct params
    But param "id" is empty
    When I call ChangeSectionPositionParser
    Then I should get Exception "Bad request. Section Id is required field"

  Scenario: Parse request without newPosition param
    Given I'm set correct params
    But param "newPosition" is empty
    When I call ChangeSectionPositionParser
    Then I should get Exception "Bad request. newPosition is required field"

  Scenario: Parse request with incorrect parent key
    Given I'm create request with incorrect parent key
    When I call ChangeSectionPositionParser
    Then I should get Exception "Bad request. Invalid root key"

  Scenario: Parse request with invalid id
    Given I'm set correct params
    But I'm set param "id" with next value "incorrect_id"
    When I call ChangeSectionPositionParser
    Then I should get Exception "Bad request. Invalid Section Id"
