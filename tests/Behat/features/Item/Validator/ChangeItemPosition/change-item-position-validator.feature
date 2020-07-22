Feature: Validate ChangeItemPositionCommandInterface
  Scenario: I want to Validate correct Command
    Given I'm set correct command params
    When I call ChangeItemPositionValidator
    Then I should get true result

  Scenario: I want to Validate ChangeItemPositionCommandInterface with incorrect id
    Given I'm set correct command params
    But Item with id is not exist
    When I call ChangeItemPositionValidator
    Then I should get message error "Item is not exist"

  Scenario: I want to Validate ChangeItemPositionCommandInterface with incorrect newPosition
    Given I'm set correct command params
    But Param newPosition is 0
    When I call ChangeItemPositionValidator
    Then I should get message error "New position can not be lass than 1"


  Scenario: I want to Validate ChangeItemPositionCommandInterface with incorrect newPosition
    Given I'm set correct command params
    But Param newPosition is 4
    When I call ChangeItemPositionValidator
    Then I should get message error "New position can not be more than max position in paragraph"
