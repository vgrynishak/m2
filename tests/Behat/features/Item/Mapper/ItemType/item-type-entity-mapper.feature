Feature: Map ItemTypeEntity to ItemTypeModel
  Scenario: I want to map exists ItemType entity to ItemType model
    Given I'm Set exists ItemType entity
    When I Call Method Map
    Then I should get same ItemTypeModel
