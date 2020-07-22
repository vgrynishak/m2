Feature: Validate EditReportTemplateValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call EditReportTemplateValidator
    Then I should get true result

  Scenario: I want to Validate EditReportTemplateValidatorInterface with incorrect id
    Given I'm set correct command
    But ReportTemplate with id is not exist
    When I call EditReportTemplateValidator
    Then I should get message error "Report template was not found"

  Scenario: I want to Validate EditReportTemplateValidatorInterface with incorrect status
    Given I'm set correct command
    But Status is invalid for this action
    When I call EditReportTemplateValidator
    Then I should get message error "Invalid Report template status"

  Scenario: I want to Validate EditReportTemplateValidatorInterface with incorrect ModifiedBy
    Given I'm set correct command
    But User is not created
    When I call EditReportTemplateValidator
    Then I should get message error "Modified User was not found"

  Scenario: I want to Validate EditSectionCommandInterface with incorrect name
    Given I'm set correct command
    But Param 'name' is 'ti'
    When I call EditReportTemplateValidator
    Then I should get message error "Report Template name can not be less that 3"

  Scenario: I want to Validate EditSectionCommandInterface with incorrect description
    Given I'm set correct command
    But Param 'description' is 'de'
    When I call EditReportTemplateValidator
    Then I should get message error "Report Template description can not be less that 3"

