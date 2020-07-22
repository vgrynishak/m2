Feature: Parse request for UpdateTextInputItem
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call UpdateInputItemParser
    Then I should get UpdateInputItemCommandInterface command

  Scenario: Parse request without paragraphId param
    Given I'm set correct params
    But param "paragraphId" is empty
    When I call UpdateInputItemParser
    Then I should get Exception "Bad request. paragraphId is required field"

  Scenario: Parse request without itemTypeId param
    Given I'm set correct params
    But param "itemTypeId" is empty
    When I call UpdateInputItemParser
    Then I should get Exception "Bad request. itemTypeId is required field"

  Scenario: Parse request without label param
    Given I'm set correct params
    But param "label" is empty
    When I call UpdateInputItemParser
    Then I should get Exception "Bad request. label is required field"

  Scenario: Parse request with incorrect parent key
    Given I'm create request with incorrect parent key
    When I call UpdateInputItemParser
    Then I should get Exception "Bad request. Invalid root key"

  Scenario: Parse request with invalid paragraphId
    Given I'm set correct params
    But I'm set param "paragraphId" with next value "incorrect_id"
    When I call UpdateInputItemParser
    Then I should get Exception "Bad request. Invalid Paragraph Id"

  Scenario: Parse request without answerId param
    Given I'm set correct params
    But param "defaultAnswer" "answerId" is empty
    When I call UpdateInputItemParser
    Then I should get Exception "Bad request. answerId is required field in object answer"

  Scenario: Parse request without value param
    Given I'm set correct params
    But param "defaultAnswer" "value" is empty
    When I call UpdateInputItemParser
    Then I should get Exception "Bad request. value is required field in object answer"

  Scenario: Parse request without defaultAnswer param
    Given I'm set correct params
    But param "defaultAnswer" is empty
    When I call UpdateInputItemParser
    Then I should get UpdateInputItemCommandInterface command