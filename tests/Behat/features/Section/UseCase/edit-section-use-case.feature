Feature: Use EditSectionUseCaseInterface
  Scenario: I want to use EditSectionUseCaseInterface
    Given I'm set EditSectionCommandInterface with correct params
    When I call EditSectionUseCase
    Then I should get SectionInterface with edited params

