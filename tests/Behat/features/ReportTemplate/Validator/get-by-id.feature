Feature: Validate get Report Template by Id
  Scenario: I want to Validate correct Command
    Given I'm set correct command params
    When I call GetByIdValidator
    Then I should get next positive result

  Scenario: I want to Validate Command with incorrect ReportTemplateId
    Given I'm set correct command params
    But Report Template is not created
    When I call GetByIdValidator
    Then I should get message error "Report template was not found"