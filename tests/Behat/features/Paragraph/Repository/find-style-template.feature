Feature: Find Paragraph StyleTemplate by Id
  Scenario: I want to find Paragraph StyleTemplate by Id
    Given I'm Set correct param Id
    When I Call Method Find
    Then I should get StyleTemplate that Implement Paragraph StyleTemplate Interface

  Scenario: I want to get default Paragraph StyleTemplate
    Given I'm Set param to find default StyleTemplate
    When I Call Method Find
    Then I should get StyleTemplate that Implement Paragraph StyleTemplate Interface
