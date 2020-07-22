Feature: Iterate Child Paragraph Level in section
  Scenario: I want to iterate child Paragraph level in section with Parent Root Paragraph
    Given I’m set child Paragraph with Parent Root Paragraph
    When I call Method Next
    Then I should get Level 2

  Scenario: I want to iterate child Paragraph level in section with Parent Child Paragraph
    Given I’m set child Paragraph with Parent Child Paragraph
    When I call Method Next
    Then I should get Level 3
