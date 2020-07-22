Feature: Validate ChangeParagraphPositionCommandInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command params
    When I call ChangeParagraphPositionValidator
    Then I should get true result

  Scenario: I want to Validate ChangeParagraphPositionCommandInterface with incorrect id
    Given I'm set correct command params
    But Paragraph with id is not exist
    When I call ChangeParagraphPositionValidator
    Then I should get message error "Paragraph is not exist"

  Scenario: I want to Validate ChangeParagraphPositionCommandInterface with incorrect newPosition
    Given I'm set correct command params
    But Param newPosition is 0
    When I call ChangeParagraphPositionValidator
    Then I should get message error "New position can not be lass than 1"

  Scenario: I want to Validate ChangeParagraphPositionCommandInterface with incorrect ModifiedBy
    Given I'm set correct command params
    But User is not created
    When I call ChangeParagraphPositionValidator
    Then I should get message error "Modified User was not found"
