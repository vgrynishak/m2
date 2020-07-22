Feature: Change Item Position
  Scenario: I want to increase Item Position
    Given param with id "b825dbb7-c20e-44ce-b029-723338c0dbe6"
    And param position "3" which i want to change
    When I call changePosition
    Then compare state list paragraph with increased list item

  Scenario: I want to decrease Item Position
    Given param with id "b825dbb7-c20e-44ce-b029-723338c0dbe7"
    And param position "1" which i want to change
    When I call changePosition
    Then compare state list paragraph with decreased list item

