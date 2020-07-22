Feature: Parse request for DeleteReportTemplateCommandInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call DeleteReportTemplateParser
    Then I should get DeleteReportTemplateCommand command

  Scenario: Parse request without reportTemplateId param
    Given I'm set correct params
    But param "reportTemplateId" is empty
    When I call DeleteReportTemplateParser
    Then I should get Exception "Bad request. Report Template Id is required field"

  Scenario: Parse request with invalid reportTemplateId
    Given I'm set correct params
    But I'm set param "reportTemplateId" with next value "incorrect_id"
    When I call DeleteReportTemplateParser
    Then I should get Exception "Invalid ReportTemplateId given"
