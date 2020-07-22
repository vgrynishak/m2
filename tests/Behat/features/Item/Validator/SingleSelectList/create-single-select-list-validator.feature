Feature: Validate CreateListInputCommand Quick Select
  Scenario: Validate CreateListInputCommand with correct params
    Given I'm set correct params with itemTypeId single_select_list
    When I call CreateListInputValidator
    Then I should get true result

  Scenario: Validate CreateListInputCommand with not exists paragraphId
    Given I'm set correct params with itemTypeId single_select_list
    But I'm set not exists param paragraphId
    When I call CreateListInputValidator
    Then I should get message error "Not found paragraphId"

  Scenario: Validate CreateListInputCommand with invalid length label
    Given I'm set correct params with itemTypeId single_select_list
    But I'm set param "label" with incorrect value
    When I call CreateListInputValidator
    Then I should get message error "Label must be >= 1 characters and <= 255 characters"

  Scenario: Validate CreateListInputCommand with invalid number answers
    Given I'm set correct params with itemTypeId single_select_list
    But I'm set answers less than 2
    When I call CreateListInputValidator
    Then I should get message error "The number of answers should be more or equal 2"

  Scenario: Validate CreateListInputCommand with invalid length answersValue
    Given I'm set correct params with itemTypeId single_select_list
    But I'm set param answers[0][value] with invalid length
    When I call CreateListInputValidator
    Then I should get message error "Answer value must be >= 1 characters and <= 255 characters"

  Scenario: Validate CreateListInputCommand with duplicate answerId
    Given I'm set correct params with itemTypeId single_select_list
    But I'm set duplicate answerId
    When I call CreateListInputValidator
    Then I should get message error "Answer Id already exists"

  Scenario: Validate CreateListInputCommand with negative assessment defaultAnswer
    Given I'm set correct params with itemTypeId single_select_list
    But I'm set defaultAnswerId negative assessment
    When I call CreateListInputValidator
    Then I should get message error "DefaultAnswer Assessment can not be Negative"
