Feature: Parse request for GetByIdCommandInterface
  Scenario: Adapt short ReportTemplate by id
    Given I'm set correct ReportTemplate data for short adapter
    And Create correct predefined data
    When I compere ReportTemplateShortForGetOneAdapter data with predefined data
    Then I should get the same structure

  Scenario: Adapt short ReportTemplate by incorrect id
    Given I'm set incorrect ReportTemplate data for short adapter
    And Create correct predefined data
    When I compere ReportTemplateShortForGetOneAdapter data with predefined data
    Then I should not get the same structure