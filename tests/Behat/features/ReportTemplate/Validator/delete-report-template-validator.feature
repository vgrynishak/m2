Feature: Validate DeleteReportTemplateValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call DeleteReportTemplateValidator
    Then I should get true result

  Scenario: I want to Validate DeleteReportTemplateValidatorInterface with incorrect id
    Given I'm set correct command
    But ReportTemplate with id is not exist
    When I call DeleteReportTemplateValidator
    Then I should get message error "Report Template was not created"

  Scenario: I want to Validate DeleteReportTemplateValidatorInterface with incorrect User
    Given I'm set correct command
    But User is not created
    When I call DeleteReportTemplateValidator
    Then I should get message error "User was not found"
