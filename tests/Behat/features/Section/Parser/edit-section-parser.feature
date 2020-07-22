Feature: Parse request for EditSectionCommandInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call EditSectionParser
    Then I should get EditSectionCommandInterface command

  Scenario: Parse request without ID param
    Given I'm set correct params
    But param "id" is empty
    When I call EditSectionParser
    Then I should get Exception "Bad request. Section Id is required field"

  Scenario: Parse request without title param
    Given I'm set correct params
    But param "title" is empty
    When I call EditSectionParser
    Then I should get Exception "Bad request. Title is required field"

  Scenario: Parse request with incorrect parent key
    Given I'm create request with incorrect parent key
    When I call EditSectionParser
    Then I should get Exception "Bad request. Invalid root key"

  Scenario: Parse request with invalid id
    Given I'm set correct params
    But I'm set param "id" with next value "incorrect_id"
    When I call EditSectionParser
    Then I should get Exception "Bad request. Invalid Section Id"
