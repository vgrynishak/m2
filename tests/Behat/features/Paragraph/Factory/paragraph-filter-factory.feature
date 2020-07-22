Feature: Make ParagraphFilter by ParagraphFilterFactory
  Scenario: Make ParagraphFilter
    Given I'm Set Correct Params
    When I Call ParagraphFilterFactory
    Then I should get Filter that Implement Paragraph Filter Interface
