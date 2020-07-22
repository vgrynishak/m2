Feature: Validate ArchiveReportTemplateValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call ArchiveReportTemplateValidator
    Then I should get true result

  Scenario: I want to Validate ArchiveReportTemplateValidatorInterface with incorrect id
    Given I'm set correct command
    But ReportTemplate with id is not exist
    When I call ArchiveReportTemplateValidator
    Then I should get message error "Report Template is not found"

  Scenario: I want to Validate ArchiveReportTemplateValidatorInterface with incorrect User
    Given I'm set correct command
    But User is not created
    When I call ArchiveReportTemplateValidator
    Then I should get message error "User is not found"
