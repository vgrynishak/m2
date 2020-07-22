Feature: Validate CreateSectionValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call CreateSectionValidator
    Then I should get true result

  Scenario: I want to Validate CreateSectionValidatorInterface with incorrect sectionId
    Given I'm set correct command
    But Section with id is already exist
    When I call CreateSectionValidator
    Then I should get message error "Section has already created"

  Scenario: I want to Validate CreateSectionValidatorInterface with incorrect reportTemplateId
    Given I'm set correct command
    But ReportTemplate is not exist
    When I call CreateSectionValidator
    Then I should get message error "Report template was not found"

  Scenario: I want to Validate CreateSectionValidatorInterface with incorrect CreatedBy
    Given I'm set correct command
    But User is not created
    When I call CreateSectionValidator
    Then I should get message error "User was not found"

  Scenario: I want to Validate CreateSectionValidatorInterface with small title
    Given I'm set correct command
    But Param 'title' small
    When I call CreateSectionValidator
    Then I should get message error "Section`s title can not be less than 3"

  Scenario: I want to Validate CreateReportTemplateValidatorInterface with large title
    Given I'm set correct command
    But Param 'title' large
    When I call CreateSectionValidator
    Then I should get message error "Section`s title can not be more than 500"
