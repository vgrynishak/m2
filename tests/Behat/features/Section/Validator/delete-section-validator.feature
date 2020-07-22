Feature: Validate DeleteSectionValidatorInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command
    When I call DeleteSectionValidator
    Then I should get true result

  Scenario: I want to Validate DeleteSectionValidatorInterface with incorrect id
    Given I'm set correct command
    But Section with id is not exist
    When I call DeleteSectionValidator
    Then I should get message error "Section is not exist"

  Scenario: I want to Validate DeleteSectionValidatorInterface with incorrect Modified User
    Given I'm set correct command
    But User is not created
    When I call DeleteSectionValidator
    Then I should get message error "Modified User was not found"

  Scenario: I want to Validate DeleteSectionValidatorInterface with incorrect section
    Given I'm set correct command
    But Section contain paragraphs
    When I call DeleteSectionValidator
    Then I should get message error "Section which contains paragraphs can not be deleted"
