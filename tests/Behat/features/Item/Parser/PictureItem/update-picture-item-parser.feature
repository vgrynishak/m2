Feature: Parse request for UpdatePictureItem
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call Update Picture Item
    Then I should get Update Picture Item Command Interface command

  Scenario: Parse request without paragraphId param
    Given I'm set correct params
    But param "paragraphId" is empty
    When I call Update Picture Item
    Then I should get Exception "Bad request. paragraphId is required field"

  Scenario: Parse request without itemTypeId param
    Given I'm set correct params
    But param "itemTypeId" is empty
    When I call Update Picture Item
    Then I should get Exception "Bad request. itemTypeId is required field"

  Scenario: Parse request without label param
    Given I'm set correct params
    But param "label" is empty
    When I call Update Picture Item
    Then I should get Exception "Bad request. label is required field"

  Scenario: Parse request with incorrect parent key
    Given I'm create request with incorrect parent key
    When I call Update Picture Item
    Then I should get Exception "Bad request. Invalid root key"

  Scenario: Parse request with invalid paragraphId
    Given I'm set correct params
    But I'm set param "paragraphId" with next value "incorrect_id"
    When I call Update Picture Item
    Then I should get Exception "Bad request. Invalid Paragraph Id"