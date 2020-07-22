Feature: Validate ChangeSectionPositionCommandInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command params
    When I call ChangeSectionPositionValidator
    Then I should get true result

  Scenario: I want to Validate ChangeSectionPositionCommandInterface with incorrect id
    Given I'm set correct command params
    But Section with id is not exist
    When I call ChangeSectionPositionValidator
    Then I should get message error "Section is not exist"

  Scenario: I want to Validate ChangeSectionPositionCommandInterface with incorrect newPosition
    Given I'm set correct command params
    But Param newPosition is 0
    When I call ChangeSectionPositionValidator
    Then I should get message error "New position can not be lass than 1"

  Scenario: I want to Validate ChangeSectionPositionCommandInterface with incorrect ModifiedBy
    Given I'm set correct command params
    But User is not created
    When I call ChangeSectionPositionValidator
    Then I should get message error "Modified User was not found"
