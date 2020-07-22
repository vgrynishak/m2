Feature: Map TextInputCommand to ItemModel
  Scenario: I want to map TextInputCommand to Item model
    Given I'm Set TextInputCommand
    When I Call Method Map
    Then I should get InputItemInterface
