Feature: Validate CreatePictureItemCommand
  Scenario: Validate CreatePictureItemCommand with correct params
    Given I'm set correct params
    When I call Create Picture Item Validator
    Then I should get true result

  Scenario: Validate CreatePictureItemCommand with duplicate not exists paragraphId
    Given I'm set correct params
    But I'm set not exists param paragraphId
    When I call Create Picture Item Validator
    Then I should get message error "Not found paragraphId"

  Scenario: Validate CreatePictureItemCommand with invalid length label
    Given I'm set correct params
    But I'm set param "label" with incorrect value
    When I call Create Picture Item Validator
    Then I should get message error "Label must be >= 1 characters and <= 255 characters"

  Scenario: Validate CreatePictureItemCommand with remember option true for Signature
    Given I'm set correct params
    But I'm set param "itemTypeId" value "signature" with param remembered true
    When I call Create Picture Item Validator
    Then I should get message error "Signature Item cannot be remembered"