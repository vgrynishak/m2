Feature: Parse request for EditReportTemplateCommandInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call EditReportTemplateParser
    Then I should get EditReportTemplateCommand command

  Scenario: Parse request without ID param
    Given I'm set correct params
    But param "reportTemplateId" is empty
    When I call EditReportTemplateParser
    Then I should get Exception "Bad request. Report Template Id is required field"

  Scenario: Parse request without name param
    Given I'm set correct params
    But param "name" is empty
    When I call EditReportTemplateParser
    Then I should get Exception "Bad request. Invalid Name"

  Scenario: Parse request with incorrect parent key
    Given I'm create request with incorrect parent key
    When I call EditReportTemplateParser
    Then I should get Exception "Bad request. Invalid root key"

  Scenario: Parse request with invalid id
    Given I'm set correct params
    But I'm set param "reportTemplateId" with next value "incorrect_id"
    When I call EditReportTemplateParser
    Then I should get Exception "Invalid ReportTemplateId given"
