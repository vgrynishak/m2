Feature: Create Item
  Scenario: I want to create ItemEntity By Item Model
    Given I'm Set correct Item model
    When I Call Method Create
    Then I should get created item