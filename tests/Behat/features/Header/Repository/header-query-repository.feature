Feature: I want to check actions in the HeaderQueryRepositoryInterface
  Scenario: I want to find BaseHeaderInterface
    Given I'm Set correct ParagraphId
    When I Call Method find
    Then I should get BaseHeaderInterface
