Feature: Get array after adapt GroupCollection
  Scenario: I want to get right array group
    Given Group Collection with filter and devices
    When I call static method adaptCollection
    Then I should have right array group