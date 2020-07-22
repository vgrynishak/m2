Feature: Validate PublishReportTemplateValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call PublishReportTemplateValidator
    Then I should get true result

  Scenario: I want to Validate PublishReportTemplateValidatorInterface with incorrect id
    Given I'm set correct command
    But ReportTemplate with id is not exist
    When I call PublishReportTemplateValidator
    Then I should get message error "Report Template is not found"

  Scenario: I want to Validate PublishReportTemplateValidatorInterface with incorrect status
    Given I'm set correct command
    But Status is invalid for this action
    When I call PublishReportTemplateValidator
    Then I should get message error "Report Template has unavailable status"

  Scenario: I want to Validate PublishReportTemplateValidatorInterface with incorrect User
    Given I'm set correct command
    But User is not created
    When I call PublishReportTemplateValidator
    Then I should get message error "User is not found"
