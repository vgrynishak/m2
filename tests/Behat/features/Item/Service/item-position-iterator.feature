Feature: Use ItemPositionIteratorInterface
  Scenario: I want to use ItemPositionIteratorInterface
    Given I'm set params
    When I call method next
    Then I should get increased position
