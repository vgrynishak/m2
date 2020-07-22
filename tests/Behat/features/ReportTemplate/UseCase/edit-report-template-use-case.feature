Feature: Use EditReportTemplateUseCaseInterface
  Scenario: I want to use EditReportTemplateUseCaseInterface
    Given I'm set EditReportTemplateCommandInterface with correct params
    When I call EditReportTemplateUseCase
    Then I should get ReportTemplateInterface with edited params