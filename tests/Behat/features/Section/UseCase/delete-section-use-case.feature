Feature: Use DeleteSectionUseCaseInterface
  Scenario: I want to delete Section with DeleteSectionUseCaseInterface
    Given I'm set DeleteSectionCommandInterface
    And Find Section which I want to delete
    And Find Section List which need to be decreased after delete action
    When I call method delete
    Then Predefined section list need to be decreased
    And Predefined Section need to be deleted