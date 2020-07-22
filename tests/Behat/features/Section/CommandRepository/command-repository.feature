Feature: I want to check actions in the SectionCommandRepositoryInterface
  Scenario: I want to delete SectionInterface
    Given I'm find SectionInterface which I want to delete
    When I Call Method Delete
    Then I should not get this Section
