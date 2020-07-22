Feature: Change Paragraph Position
  Scenario: I want to increase Root Paragraph Position
    Given param with current position "1"
    And Paragraph with 1 level
    And param position "4" which i want to change
    When I call changePosition
    Then compare state list paragraph with increased list paragraph

  Scenario: I want to decrease Root Paragraph Position
    Given param with current position "4"
    And Paragraph with 1 level
    And param position "2" which i want to change
    When I call changePosition
    Then compare state list paragraph with decreased list paragraph


  Scenario: I want to increase Child Paragraph Position which has 2 level
    Given param with current position "1"
    And Paragraph with 2 level
    And param position "3" which i want to change
    When I call changePosition
    Then compare state list paragraph with increased list paragraph

  Scenario: I want to decrease Child Paragraph Position which has 2 level
    Given param with current position "3"
    And Paragraph with 2 level
    And param position "2" which i want to change
    When I call changePosition
    Then compare state list paragraph with decreased list paragraph

  Scenario: I want to increase Child Paragraph Position which has 3 level
    Given param with current position "1"
    And Paragraph with 3 level
    And param position "3" which i want to change
    When I call changePosition
    Then compare state list paragraph with increased list paragraph

  Scenario: I want to decrease Child Paragraph Position which has 3 level
    Given param with current position "3"
    And Paragraph with 3 level
    And param position "2" which i want to change
    When I call changePosition
    Then compare state list paragraph with decreased list paragraph