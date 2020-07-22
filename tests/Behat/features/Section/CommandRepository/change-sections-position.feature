Feature: Change Section Position
  Scenario: I want to increase Section Position
    Given param with current position "1"
    And param position "5" which i want to change
    When I call changePosition
    Then compare state list section with increased list section

  Scenario: I want to decrease Section Position
    Given param with current position "5"
    And param position "2" which i want to change
    When I call changePosition
    Then compare state list section with decreased list section