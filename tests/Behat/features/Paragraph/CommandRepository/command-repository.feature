Feature: I want to check actions in the ParagraphCommandRepositoryInterface
  Scenario: I want to delete BaseParagraphInterface
    Given I'm find BaseParagraphInterface which I want to delete
    When I Call Method Delete
    Then I should not get this Paragraph
