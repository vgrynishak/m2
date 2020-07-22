Feature: Map Service model to ServiceEntity
  Scenario: I want to map exists Service model to ServiceEntity
    Given I'm Set exists Service model
    When I Call Method Map
    Then I should get same ServiceEntity

  Scenario: I want to map new Service model to ServiceEntity
    Given I'm Set new Service model
    When I Call Method MapNew
    Then I should get same ServiceEntity
