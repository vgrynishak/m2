Feature: Validate DeleteParagraphValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call DeleteParagraphValidator
    Then I should get true result

  Scenario: I want to Validate DeleteParagraphValidatorInterface with incorrect id
    Given I'm set correct command
    But Paragraph with id is not exist
    When I call DeleteParagraphValidator
    Then I should get message error "Paragraph is not exist"

  Scenario: I want to Validate DeleteParagraphValidatorInterface with incorrect Modified User
    Given I'm set correct command
    But User is not created
    When I call DeleteParagraphValidator
    Then I should get message error "Modified User was not found"

  Scenario: I want to Validate DeleteParagraphValidatorInterface with incorrect paragraph
    Given I'm set correct command
    But Paragraph contain children
    When I call DeleteParagraphValidator
    Then I should get message error "Paragraph which contains children can not be deleted"
