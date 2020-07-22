Feature: Use ArchiveReportTemplateUseCaseInterface
  Scenario: I want to use ArchiveReportTemplateUseCaseInterface
    Given I'm set ArchiveReportTemplateCommandInterface with correct params
    When I call ArchiveReportTemplateUseCase
    Then I should get ReportTemplateInterface with archived params