Feature: Make SectionInterface
  Scenario: Make new Section by command
    Given I'm Set Correct CreateSectionCommandInterface
    When I Call method MakeByCommand
    Then I should get SectionInterface
