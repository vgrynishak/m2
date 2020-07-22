Feature: Map InputItemInterface model to InputEntity
  Scenario: I want to map exists Input model to InputEntity
    Given I'm Set exists Input model
    When I Call Method Map
    Then I should get same InputEntity

  Scenario: I want to map new Input model to InputEntity
    Given I'm Set new Input model
    When I Call Method MapNew
    Then I should get same InputEntity
