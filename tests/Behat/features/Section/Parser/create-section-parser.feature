Feature: Parse request for CreateSectionCommandInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call CreateSectionParser
    Then I should get CreateSectionCommandInterface

  Scenario: Parse request without ID param
    Given I'm set correct params
    But param "sectionId" is empty
    When I call CreateSectionParser
    Then I should get Exception "Bad request. Section Id is required field"

  Scenario: Parse request with invalid id
    Given I'm set correct params
    But I'm set param "sectionId" with next value "incorrect_id"
    When I call CreateSectionParser
    Then I should get Exception "Bad request. Invalid Section Id"

  Scenario: Parse request without reportTemplateId param
    Given I'm set correct params
    But param "reportTemplateId" is empty
    When I call CreateSectionParser
    Then I should get Exception "Bad request. ReportTemplate Id is required field"

  Scenario: Parse request with invalid reportTemplateId
    Given I'm set correct params
    But I'm set param "reportTemplateId" with next value "incorrect_id"
    When I call CreateSectionParser
    Then I should get Exception "Bad request. Invalid ReportTemplateId given"

  Scenario: Parse request without title param
    Given I'm set correct params
    But param "title" is empty
    When I call CreateSectionParser
    Then I should get Exception "Bad request. Invalid Title"

  Scenario: Parse request with incorrect parent key
    Given I'm create request with incorrect parent key
    When I call CreateSectionParser
    Then I should get Exception "Bad request. Invalid root key"
