Feature: Map ItemCategoryEntity to ItemCategoryModel
  Scenario: I want to map exists ItemCategory entity to ItemCategory model
    Given I'm Set exists ItemCategory entity
    When I Call Method Map
    Then I should get same ItemCategoryModel