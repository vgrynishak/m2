Feature: Mapping Entity Group to Model Group
  Scenario: I want to have right Group
    Given I'm Set correct Entity Group
    When I Call Method map
    Then I should get Group that Implement GroupInterface
