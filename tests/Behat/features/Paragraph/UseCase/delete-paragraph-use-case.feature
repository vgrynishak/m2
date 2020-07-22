Feature: Use DeleteParagraphUseCaseInterface
  Scenario: I want to delete Paragraph with DeleteParagraphUseCaseInterface
    Given I'm set DeleteParagraphCommandInterface
    And Find Paragraph which I want to delete
    And Find Paragraph List which need to be decreased after delete action
    When I call method delete
    Then Predefined paragraph list need to be decreased
    And Predefined Paragraph need to be deleted