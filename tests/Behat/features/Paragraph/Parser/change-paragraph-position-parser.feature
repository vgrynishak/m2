Feature: Parse request for ChangeParagraphPositionCommandInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call ChangeParagraphPositionParser
    Then I should get ChangeParagraphPositionCommandInterface command

  Scenario: Parse request without ID param
    Given I'm set correct params
    But param "id" is empty
    When I call ChangeParagraphPositionParser
    Then I should get Exception "Bad request. Paragraph Id is required field"

  Scenario: Parse request without newPosition param
    Given I'm set correct params
    But param "newPosition" is empty
    When I call ChangeParagraphPositionParser
    Then I should get Exception "Bad request. newPosition is required field"

  Scenario: Parse request with incorrect parent key
    Given I'm create request with incorrect parent key
    When I call ChangeParagraphPositionParser
    Then I should get Exception "Bad request. Invalid root key"

  Scenario: Parse request with invalid id
    Given I'm set correct params
    But I'm set param "id" with next value "incorrect_id"
    When I call ChangeParagraphPositionParser
    Then I should get Exception "Bad request. Invalid Paragraph Id"
