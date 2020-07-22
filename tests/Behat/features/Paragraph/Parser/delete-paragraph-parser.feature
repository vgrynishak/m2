Feature: Parse request for DeleteParagraphCommandInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call DeleteParagraphParser
    Then I should get DeleteParagraphCommandInterface

  Scenario: Parse request without paragraphId param
    Given I'm set correct params
    But param "paragraphId" is empty
    When I call DeleteParagraphParser
    Then I should get Exception "Bad request. Paragraph Id is required field"

  Scenario: Parse request with invalid paragraphId
    Given I'm set correct params
    But I'm set param "paragraphId" with next value "incorrect_id"
    When I call DeleteParagraphParser
    Then I should get Exception "Invalid Paragraph Id"
