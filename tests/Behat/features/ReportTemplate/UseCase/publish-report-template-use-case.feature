Feature: Use PublishReportTemplateUseCaseInterface
  Scenario: I want to use PublishReportTemplateUseCaseInterface
    Given I'm set PublishReportTemplateCommandInterface with correct params
    When I call PublishReportTemplateUseCase
    Then I should get ReportTemplateInterface with published params