Feature: Make Paragraph StyleTemplate
  Scenario: Make new StyleTemplate
    Given I'm Set Correct Params
    When I Call method Make
    Then I should get StyleTemplate that Implements Paragraph StyleTemplate Interface
