Feature: Update Item
  Scenario: I want to Update ItemEntity
    Given I'm Set correct Item model
    When I Call Method update
    Then I should get updated data item
