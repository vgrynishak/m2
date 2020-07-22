Feature: Map PictureInputCommand to ItemModel
  Scenario: I want to map PictureInputCommand to Item model
    Given I'm Set Picture Input Command
    When I Call Method Map
    Then I should get Input Item Interface
