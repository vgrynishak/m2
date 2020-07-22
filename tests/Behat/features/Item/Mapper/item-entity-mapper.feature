Feature: Map InputEntity to InputModel
  Scenario: I want to map exists InputEntity to InputModel
    Given I'm Set exists Input entity
    When I Call Method Map
    Then I should get same InputModel
