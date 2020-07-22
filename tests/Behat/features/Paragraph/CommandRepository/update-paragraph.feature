Feature: Update Paragraph
  Scenario: I want to update ParagraphEntity by RootParagraphWithoutDevice model
    Given I'm Set correct RootParagraphWithoutDevice model
    When I Call Method Update
    Then I should get updated data

  Scenario: I want to update ParagraphEntity by RootParagraphWithDevice model
    Given I'm Set correct RootParagraphWithDevice model
    When I Call Method Update
    Then I should get updated data

  Scenario: I want to update ParagraphEntity by ChildParagraphWithDevice model
    Given I'm Set correct ChildParagraphWithDevice model
    When I Call Method Update
    Then I should get updated data
