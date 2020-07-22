Feature: Find Group by Id
  Scenario: I want to find Group by Id
    Given I'm Set correct param Id
    When I Call Method Find
    Then I should get Group that Implement GroupInterface
