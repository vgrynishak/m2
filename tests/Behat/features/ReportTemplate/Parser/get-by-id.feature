Feature: Parse request for GetByIdCommandInterface
  Scenario: Parse request with correct params
    Given I'm set correct params
    When I call GetById Parser
    Then I should get GetByIdCommandInterface

  Scenario: Parse request without reportTemplateId param
    Given I'm set correct params
    But param "reportTemplateId" is empty
    When I call GetById Parser
    Then I should get Exception "Report Template Id is required field"

  Scenario: Parse request with invalid paragraph id
    Given I'm set correct params
    But I'm set param "reportTemplateId" with next value "incorrect_report_template_id"
    When I call GetById Parser
    Then I should get Exception "Invalid ReportTemplateId given"