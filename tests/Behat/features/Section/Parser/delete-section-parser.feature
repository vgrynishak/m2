Feature: Parse request for DeleteSectionCommandInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call DeleteSectionParser
    Then I should get DeleteSectionCommandInterface

  Scenario: Parse request without sectionId param
    Given I'm set correct params
    But param "sectionId" is empty
    When I call DeleteSectionParser
    Then I should get Exception "Bad request. Section Id is required field"

  Scenario: Parse request with invalid sectionId
    Given I'm set correct params
    But I'm set param "sectionId" with next value "incorrect_id"
    When I call DeleteSectionParser
    Then I should get Exception "Invalid Section Id"
