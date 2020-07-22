Feature: Validate TextInputCommand
  Scenario: Validate InputItemCommand with correct params
    Given I'm set correct params
    When I call UpdateInputItemValidator
    Then I should get true result

  Scenario: Validate InputItemCommand with not exists paragraphId
    Given I'm set correct params
    But I'm set not exists param paragraphId
    When I call UpdateInputItemValidator
    Then I should get message error "Not found paragraphId"

  Scenario: Validate InputItemCommand with not exists itemId
    Given I'm set correct params
    But I'm set not exists param ItemId
    When I call UpdateInputItemValidator
    Then I should get message error "Item Id is not exists"

  Scenario: Validate InputItemCommand with invalid length label
    Given I'm set correct params
    But I'm set param "label" with incorrect value
    When I call UpdateInputItemValidator
    Then I should get message error "Label must be >= 1 characters and <= 255 characters"

  Scenario: Validate InputItemCommand with invalid length defaultAnswer
    Given I'm set correct params
    But I'm set param defaultAnswer[value] with incorrect value
    When I call UpdateInputItemValidator
    Then I should get message error "DefaultAnswer value must be >= 1 characters and <= 255 characters"

  Scenario: Validate InputItemCommand with invalid Assessment
    Given I'm set correct params
    But I'm set param defaultAnswer[AnswerAssessment] with incorrect value
    When I call UpdateInputItemValidator
    Then I should get message error "DefaultAnswer Assessment can not be Negative"
