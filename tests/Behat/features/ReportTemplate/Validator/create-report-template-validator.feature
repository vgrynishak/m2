Feature: Validate CreateReportTemplateValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call CreateReportTemplateValidator
    Then I should get true result

  Scenario: I want to Validate CreateReportTemplateValidatorInterface with incorrect id
    Given I'm set correct command
    But ReportTemplate with id is already exist
    When I call CreateReportTemplateValidator
    Then I should get message error "Report Template has already created"

  Scenario: I want to Validate CreateReportTemplateValidatorInterface with incorrect serviceId
    Given I'm set correct command
    But Service is not exist
    When I call CreateReportTemplateValidator
    Then I should get message error "Invalid service"

  Scenario: I want to Validate CreateReportTemplateValidatorInterface with incorrect deviceId
    Given I'm set correct command
    But Device is not exist
    When I call CreateReportTemplateValidator
    Then I should get message error "Invalid device"

  Scenario: I want to Validate CreateReportTemplateValidatorInterface with incorrect CreatedBy
    Given I'm set correct command
    But User is not created
    When I call CreateReportTemplateValidator
    Then I should get message error "User was not found"

  Scenario: I want to Validate CreateReportTemplateValidatorInterface with incorrect name
    Given I'm set correct command
    But Param 'name' is 'ti'
    When I call CreateReportTemplateValidator
    Then I should get message error "Report Template`s name can not be less that 3"

  Scenario: I want to Validate CreateReportTemplateValidatorInterface with incorrect description
    Given I'm set correct command
    But Param 'description' is 'de'
    When I call CreateReportTemplateValidator
    Then I should get message error "Report Template`s description can not be less that 3"
