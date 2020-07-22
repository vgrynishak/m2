Feature: Use DeleteReportTemplateUseCaseInterface
  Scenario: I want to use DeleteReportTemplateUseCaseInterface
    Given I'm set DeleteReportTemplateCommandInterface with correct params
    When I call DeleteReportTemplateUseCase
    Then I should get ReportTemplateInterface with correct deleted params