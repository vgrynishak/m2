Feature: Parse request for ChangeItemPositionCommandInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call ChangeItemPositionParser
    Then I should get ChangeItemPositionCommandInterface command

  Scenario: Parse request without ID param
    Given I'm set correct params
    But param "id" is empty
    When I call ChangeItemPositionParser
    Then I should get Exception "Bad request. Item Id is required field"

  Scenario: Parse request without newPosition param
    Given I'm set correct params
    But param "newPosition" is empty
    When I call ChangeItemPositionParser
    Then I should get Exception "Bad request. newPosition is required field"

  Scenario: Parse request with incorrect parent key
    Given I'm create request with incorrect parent key
    When I call ChangeItemPositionParser
    Then I should get Exception "Bad request. Invalid root key"

  Scenario: Parse request with invalid id
    Given I'm set correct params
    But I'm set param "id" with next value "incorrect_id"
    When I call ChangeItemPositionParser
    Then I should get Exception "Bad request. Invalid ItemId given"
