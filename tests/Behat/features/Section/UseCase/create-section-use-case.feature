Feature: Use CreateSectionUseCaseInterface
  Scenario: I want to use CreateSectionUseCaseInterface
    Given I'm set CreateSectionCommandInterface
    When I call method create
    Then I should get SectionInterface
    And Section position need to be increased
    And Section printable field need to be true

