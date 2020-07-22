Feature: Map CreateSectionCommandInterface to SectionInterface
  Scenario: I want to map CreateSectionCommandInterface to Section
    Given I’m set correct CreateSectionCommand
    When I call Method Map
    Then I should get Section that Implements SectionInterface
