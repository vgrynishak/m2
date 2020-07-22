Feature: Iterate Paragraph position in section
  Scenario: I want to iterate new Paragraph position in section
    Given I’m set first Paragraph in Section
    When I call Method Next
    Then I should get Position 1

  Scenario: I want to iterate Paragraph position 1 in section
    Given I’m set new Paragraph in Section that have last paragraph with position
    When I call Method Next
    Then I should get Position 5

