Feature: Modify Paragraph by EditParagraphCommand
  Scenario: I want to get modified Paragraph implements BaseParagraphInterface
    Given I'm set correct EditParagraphCommand
    When I call Method Edit
    Then I should get Paragraph implements BaseParagraphInterface
